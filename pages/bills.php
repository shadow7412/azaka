<?php 
include_once "../include/page.php";
include_once "../include/linklist.php";
$p = new Page('bills',1);

if(isset($_POST['action'])){
	if($_POST['action']=='pay') $p->db->qry("UPDATE `bills` SET `paid` = 1, `datepaid` = '".date('Y-m-d')."' WHERE `id` = '".$_GET['control']."'");
	if($_POST['action']=='cancel') $p->db->qry("UPDATE `bills` SET `paid` = 0 WHERE `bills`.`id` = '".$_GET['control']."'");
}

$p->l->addItem('manage bills','admin_bills.php',2);
$p->l->addLink('bendigo bank','https://www.bendigobank.com.au/banking/BBLIBanking/',0);
$p->l->addLink('commonwealth bank','https://www3.netbank.commbank.com.au/netbank/bankmain',0);
$p->l->addLink('nab','https://ib.nab.com.au/nabib/index.jsp',0);
echo $p->l->dispList()."<br/>";
echo "<div class=\"ui-widget\"><div class=\"ui-state-highlight ui-corner-all\" style=\"margin-top: 20px; padding: 0 .7em;\"><p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span>{$p->db->getSetting('bills_info')}</p></div></div>";

$p->db->qry("SELECT * FROM `bills` WHERE uid = '".$p->u->id."' ORDER BY `uid` ASC");
if ($p->db->noLast() == 0)
	echo "No bills outstanding. :)";
else {
	$unpaid = 0;
	$unconfirmed = 0;
	$complete = 0;
	echo "<table border=1><tr><td>service</td><td>amount</td><td>date added</td><td>date due</td><td>date paid</td><td>date confirmed</td></tr>\n";
		while($row = $result->fetchRow()) {
			extract($row);
			echo "<tr><td>$service</td>
			<td>$$amount</td>
			<td>$dateadded</td>
			<td>$datedue</td>
			<td><form action=\"bills.php\" method=\"post\" name=\"pay$id\"><input type=\"hidden\" name=\"control\" value=\"$id\" />";
			if (!$paid){echo "<input type=\"submit\" name = \"action\" value=\"pay\"></td><td>pay first"; $unpaid += $amount;}
			if ($paid&&!$confirmed) {echo "$datepaid</td><td><input type=\"submit\" name = \"action\" value=\"cancel\">"; $unconfirmed+= $amount;}
			if($paid&&$confirmed) {echo "$datepaid</td><td>$dateconfirmed"; $complete+= $amount;};
			echo "</form></td></tr>";
		}
	echo "</table>\n<br/><br/>";
	if ($unpaid!=0) echo "<strong>$$unpaid outstanding</strong><br/>"; else echo "$0 outstanding<br/>";
	if ($unconfirmed!=0) echo "<strong>$$unconfirmed unconfirmed<br/></strong>"; else echo "$0 unconfirmed<br/>";
	if ($complete!=0) echo "$$complete paid<br/>";
}
?>