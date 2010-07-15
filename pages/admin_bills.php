<?php 
include_once "../include/page.php";
include_once "../include/linklist.php";
$p = new Page('bills - admin',1);

if(isset($_GET['action'])){
	if($_GET['action']=='pay') $p->db->qry("UPDATE `bills` SET `paid` = 1, `datepaid` = '".date('Y-m-d')."' WHERE `id` = '".$_GET['control']."'");
	if($_GET['action']=='cancel') $p->db->qry("UPDATE `bills` SET `paid` = 0 WHERE `id` = '".$_GET['control']."'");
}
$p->addJs("$(\"#accordion\").accordion({autoHeight: false, navigation: true})");
$p->l->addItem('manage bills','admin_bills.php',2);
$p->l->addLink('bendigo bank','https://www.bendigobank.com.au/banking/BBLIBanking/',0);
$p->l->addLink('commonwealth bank','https://www3.netbank.commbank.com.au/netbank/bankmain',0);
$p->l->addLink('nab','https://ib.nab.com.au/nabib/index.jsp',0);
echo $p->l->dispList()."<br/>";
echo "<div class=\"ui-widget\"><div class=\"ui-state-highlight ui-corner-all\" style=\"margin-top: 20px; padding: 0 .7em;\"><p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span>{$p->db->getSetting('bills_info')}</p></div></div>";

$p->db->qry("SELECT * FROM `bills` WHERE uid = '".$p->u->id."' AND `confirmed` = 0 ORDER BY `uid` ASC");
echo "<div id=\"accordion\"><h3><a>current bills</a></h3><div>";
if ($p->db->noLast() != 0){
	$unpaid = 0;
	$unconfirmed = 0;
	echo "<table border=1><tr><td>service</td><td>amount</td><td>date added</td><td>date due</td><td>date paid</td><td>date confirmed</td></tr>\n";
	while($row = $p->db->fetchLast()) {
		extract($row);
		echo "<tr><td>$service</td>
		<td>$$amount</td>
		<td>$dateentered</td>
		<td>$datedue</td>
		<td>";
		if (!$paid){echo "<a href=\"javascript:sendPost('pages/bills.php?action=pay&control=$id')\">pay</a></td><td>pay first"; $unpaid += $amount;}
		else {echo "$datepaid</td><td><a href=\"javascript:sendPost('pages/bills.php?action=cancel&control=$id')\">cancel</a>"; $unconfirmed+= $amount;}
		echo "</td></tr>";
	}
	echo "</table>\n<br/><br/>";
	if ($unpaid!=0) echo "<strong>$$unpaid outstanding</strong><br/>"; else echo "$0 outstanding<br/>";
	if ($unconfirmed!=0) echo "<strong>$$unconfirmed unconfirmed<br/></strong>"; else echo "$0 unconfirmed<br/>";
	echo "<br/>";
} else echo "You currently do not have any bills outstanding. Outstanding!";
echo "</div><h3><a>bill history</a></h3><div>";
$p->db->qry("SELECT * FROM `bills` WHERE uid = '".$p->u->id."' ORDER BY `uid` ASC");
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
	echo "<br/>";
} else echo "You currently do not have any bills outstanding. Outstanding!";
echo "</div></div>";
?>