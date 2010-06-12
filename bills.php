<?php
require_once "inc/uni.php";
include "inc/linklist.php";
$x = new universal("Bills",1);
$l = new linklist();
$db = new database();
global $userinfo;

$l->additem('add/edit bills','admin_bills.php',2);
if (isset($_GET['view']) && $_GET['view']=='full') {
	$l->additem('show current bills','bills.php',1);
	$result = $db->qry("SELECT * FROM `bills` b, users u WHERE u.id = b.uid AND b.uid = '".$userinfo->id."' ORDER BY u.`username` ASC");
	} else {
	$l->additem('show full history','bills.php?view=full',1);
	$result = $db->qry("SELECT * FROM `bills` b, users u WHERE u.id = b.uid AND b.confirmed = 0 AND b.uid = '".$userinfo->id."' ORDER BY u.`username` ASC");
	}
$l->addbreak();
$l->additem('bendigo bank','https://www.bendigobank.com.au/banking/BBLIBanking/',1);
$l->additem('commonwealth bank','https://www3.netbank.commbank.com.au/netbank/bankmain',1);
$l->additem('nab','https://ib.nab.com.au/nabib/index.jsp',1);

$l->disp();

if(isset($_POST['action'])){
	if($_POST['action']=='pay') $db->qry("UPDATE `bills` SET `paid` = 1, `datepaid` = '".date('Y-m-d')."' WHERE `id` = '".$_POST['control']."'");
	if($_POST['action']=='cancel') $db->qry("UPDATE `bills` SET `paid` = 0 WHERE `bills`.`id` = '".$_POST['control']."'");
}
	
$unpaid = 0;
$unconfirmed = 0;
$complete = 0;
echo "<table border=1><tr><td>service</td><td>amount</td><td>date added</td><td>date due</td><td>date paid</td><td>date confirmed</td></tr>\n";
	while($row = mysql_fetch_array($result)) {
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

	
?>