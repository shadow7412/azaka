<?php

//header
header("content-type: text/xml");

//includes
include_once "../include/db.php";

//create objects
$newObj = new Database;

echo "<?xml version=\"1.0\" ?>";

//suggested output:
echo "<shoutbox>";

$query = $newObj->qry("SELECT users.username as username, shoutbox.time as time, shoutbox.message as message FROM users,shoutbox WHERE shoutbox.uid = users.id ORDER BY time DESC LIMIT 0,5");
while($values = $newObj->fetchLast())
	echo "<message><user>{$values['username']}</user><time>{$values['time']}</time><content>{$values['message']}</content></message>";

echo "</shoutbox>";
?>
