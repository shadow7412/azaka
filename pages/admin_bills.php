<?php 
include_once "../include/page.php";
$p = new Page('bills',1);

if(isset($_GET['action'])){
	if($_GET['action']=='pay') $p->db->qry("UPDATE `bills` SET `paid` = 1, `datepaid` = '".date('Y-m-d')."' WHERE `id` = '".$_GET['control']."'");
	if($_GET['action']=='confirm') $p->db->qry("UPDATE `bills` SET `confirmed` = 1, `dateconfirmed` = '".date('Y-m-d')."' WHERE `id` = '".$_GET['control']."'");
	if($_GET['action']=='delete') $p->db->qry("UPDATE `bills` SET `confirm` = 1 WHERE `id` = '".$_GET['control']."'");
}
$p->addJs("$(\"#accordion\").accordion({autoHeight: false, navigation: true})");
$p->l->addItem('bills','admin_bills',2);
$p->l->addLink('bendigo bank','https://www.bendigobank.com.au/banking/BBLIBanking/',0);
$p->l->addLink('commonwealth bank','https://www3.netbank.commbank.com.au/netbank/bankmain',0);
$p->l->addLink('nab','https://ib.nab.com.au/nabib/index.jsp',0);
echo $p->l->dispList();

$p->db->qry("SELECT bills.*, username FROM users, `bills` WHERE uid = users.id AND `confirmed` = 0 ORDER BY `uid` ASC");
echo "<div id=\"accordion\"><h3><a>current bills</a></h3><div>";
if ($p->db->noLast() != 0){
	$unpaid = 0;
	$unconfirmed = 0;
	echo "<table border=1><tr><td>username</td><td>service</td><td>amount</td><td>date added</td><td>date due</td><td>date paid</td><td>date confirmed</td><td>delete</td></tr>\n";
	while($row = $p->db->fetchLast()) {
		extract($row);
		echo "<tr><td>$username</td>
		<td>$service</td>
		<td>$$amount</td>
		<td>$dateentered</td>
		<td>$datedue</td>
		<td>";
		if (!$paid){
			echo "<input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:sendPost('pages/admin_bills.php?action=pay&control=$id')\" value=\"mark as paid\"></td><td>";
			$unpaid += $amount;
			} else {
				echo "$datepaid</td><td><input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:sendPost('pages/admin_bills.php?action=confirm&control=$id')\" value=\"confirm\" title=\"Click here when you have verified that this amount has entered the account.\">";
				$unconfirmed+= $amount;
			}
		echo "</td><td><a href=\"javascript:if(confirm('You should not delete things unless they are mistakes.\\nBills are supposed to all be logged.\\n\\nAre you sure you want to delete this entry?'))sendPost('pages/admin_bills.php?action=delete&control=$id')\" class=\"ui-icon ui-icon-circle-close\"/></td></tr>";
	}
	echo "</table>\n<br/><br/>";
	if ($unpaid!=0) echo "<strong>$$unpaid outstanding</strong><br/>"; else echo "$0 outstanding<br/>";
	if ($unconfirmed!=0) echo "<strong>$$unconfirmed unconfirmed<br/></strong>"; else echo "$0 unconfirmed<br/>";
} else echo "There are no outstanding bills!";
echo "</div><h3><a>add bill</a></h3><div>";

echo "</div><h3><a>bill history</a></h3><div>";

$p->db->qry("SELECT * FROM `bills` WHERE uid = '".$p->u->id."' AND confirmed=1 ORDER BY `datedue` DESC");
if ($p->db->noLast() != 0){
	$totalpaid = 0;
	echo "<table border=1><tr><td>service</td><td>amount</td><td>date added</td><td>date due</td><td>date paid</td><td>date confirmed</td></tr>\n";
	while($row = $p->db->fetchLast()) {
		extract($row);
		echo "<tr><td>$service</td>
		<td>$$amount</td>
		<td>$dateentered</td>
		<td>$datedue</td>
		<td>$datepaid</td>
		<td>$dateconfirmed</td>
		</td></tr>";
		$totalpaid += $amount;
	}
	echo "</table>\n<br/><br/>";
	echo "<strong>$$totalpaid paid in total</strong><br/>";
} else echo "At this point history is not available because there is no history.";
echo "</div></div>";
?>