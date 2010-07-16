<?php
include_once "../include/module.php";
$m = new Module("bills", 1);
$nobills=0;

$m->db->qry("SELECT username, SUM(amount) AS amount FROM users, `bills` WHERE uid = users.id AND `paid` = 0 AND `confirmed` = 0 GROUP BY username ORDER BY `uid` ASC");
while($row = $m->db->fetchLast()){
	if($m->u->username == $row['username'])
		$m->addContent("<strong>");
	$m->addContent("{$row['username']} has \${$row['amount']} owing.<br/>");
	if($m->u->username == $row['username'])
		$m->addContent("</strong>");
}
if($m->db->noLast()!=0) $m->addContent("<br/>"); else $nobills=1;
$m->db->qry("SELECT username, SUM(amount) AS amount FROM users, `bills` WHERE uid = users.id AND `paid` = 1 AND `confirmed` = 0 GROUP BY username ORDER BY `uid` ASC");
while($row = $m->db->fetchLast()){
	$m->addContent("{$row['username']} has \${$row['amount']} unconfirmed.<br/>");
}
if($nobills==1&$m->db->noLast()==0) $m->addContent("No outstanding bills.");
?>