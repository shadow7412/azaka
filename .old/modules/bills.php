<?php
include_once "../include/module.php";
$m = new Module("bills", 1);
$nobills=0;
if($m->db->getSetting('bills_all')){
	$firstresult = $m->db->qry("SELECT username, SUM(amount) AS amount FROM users, `bills` WHERE uid = users.id AND `paid` = 0 AND `confirmed` = 0 GROUP BY username ORDER BY `uid` ASC");
	while($row = $m->db->fetchLast()){
		if($m->u->username == $row['username'])
			$m->addContent("<strong>");
		$m->addContent("{$row['username']} has \${$row['amount']} owing.<br/>");
		if($m->u->username == $row['username'])
			$m->addContent("</strong>");
	}
	
	$m->db->qry("SELECT username, SUM(amount) AS amount FROM users, `bills` WHERE uid = users.id AND `paid` = 1 AND `confirmed` = 0 GROUP BY username ORDER BY `uid` ASC");
	if($m->db->no($firstresult)!=0 && $m->db->noLast()!=0) $m->addContent('<br/>');
	while($row = $m->db->fetchLast()){
		if ($nobills==1){$nobills=2;addContent('<br/>');}
		$m->addContent("{$row['username']} has \${$row['amount']} unconfirmed.<br/>");
	}
	if($m->db->no($firstresult)==0 && $m->db->noLast()==0) $m->addContent("No one has any bills outstanding.");

} else {
	$m->db->qry("SELECT SUM(amount) AS amount FROM `bills` WHERE uid = '{$m->u->id}' AND `paid` = 0 AND `confirmed` = 0 GROUP BY uid ORDER BY `uid` ASC");
	if($row = $m->db->fetchLast())
		$m->addContent("<strong>You have \${$row['amount']} owing.</strong><br/>");
	if($m->db->noLast()!=0) $nobills=1;
	$m->db->qry("SELECT SUM(amount) AS amount FROM `bills` WHERE uid = '{$m->u->id}' AND `paid` = 1 AND `confirmed` = 0 GROUP BY uid ORDER BY `uid` ASC");
	if($row = $m->db->fetchLast()){
		if($nobills) $m->addContent("<br/>");
		$m->addContent("You have \${$row['amount']} unconfirmed.<br/>");
		}
	if($nobills==0 && $m->db->noLast()==0) $m->addContent("No outstanding bills.");
}
?>