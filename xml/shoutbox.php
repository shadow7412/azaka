<?php

error_reporting(E_ALL);
ini_set("display_errors",1);

//includes
include_once "../include/db.php";

//create objects
$newObj = new Database;

$query = $newObj->qry("SELECT * FROM shoutbox");
$values = $newObj->fetchLast();

//header
header("content-type: text/xml");
echo "<?xml version=\"1.0\" ?>";

//suggested output:
echo "<shoutbox>";
	echo "<message>
		<user>{$values['uid']}</user>
		<time>{$values['time']}</time>
		<content>{$values['message']}</content> 
	</message>"; // repeat message for the last (up to) 5 messages
echo "</shoutbox>";
?>
