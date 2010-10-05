<?php

//header
header("content-type: text/xml");
error_reporting(E_ALL);
ini_set("display_errors",1);

//includes
include_once "../include/db.php";

//create objects
$newObj = new Database;

$query = $newObj->qry("SELECT id, username FROM users");
$username = array();
while($user = $newObj->fetchLast()){
   $username[$user['id']] = $user['username'];
}

echo "<?xml version=\"1.0\" ?>";

//suggested output:
echo "<shoutbox>";

$query = $newObj->qry("SELECT * FROM shoutbox");
while($values = $newObj->fetchLast())
	echo "<message>
          <user>{$username[$values['uid']]}</user>
          <time>{$values['time']}</time>
          <content>{$values['message']}</content>
         </message>";

echo "</shoutbox>";
?>
