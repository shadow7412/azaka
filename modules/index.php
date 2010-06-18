<?php
include_once "../include/db.php";
include_once "../include/userobject.php";
$db = new Database();
$u = new UserObject();
$result = $db->qry("SELECT name, url FROM modules WHERE enabled = 1");
while($row = mysql_fetch_array($result)){
	extract($row);
	echo "$name<div id=\"module mod-$name\">";
	include $url;
	echo "</div>";
}
?>