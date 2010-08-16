<?php
include_once "../include/userobject.php";
$u = new UserObject;
$db = $u->db;

header("content-type: text/xml");
echo "<?xml version=\"1.0\" ?>";
if($u->canAccess(1)&&$u->billable){
	echo "<bills>
	<owing>\n";

	$db->qry("SELECT username, SUM(amount) AS amount FROM users, `bills` WHERE uid = users.id AND `paid` = 0 AND `confirmed` = 0 GROUP BY username ORDER BY `uid` ASC");
	while($row = $db->fetchLast()){
		echo "\t\t<entry username = \"{$row['username']}\" amount = \"\${$row['amount']}\"/>\n";
	}
	echo "\t</owing>
	<unconfirmed>\n";

	$db->qry("SELECT username, SUM(amount) AS amount FROM users, `bills` WHERE uid = users.id AND `paid` = 1 AND `confirmed` = 0 GROUP BY username ORDER BY `uid` ASC");

	while($row = $db->fetchLast()){
		echo "\t\t<entry username = \"{$row['username']}\" amount = \"\${$row['amount']}\"/>\n";
	}
	echo "\t</unconfirmed>
</bills>";
}



?>