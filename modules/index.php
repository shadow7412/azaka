<?php
include_once "../include/db.php";
include_once "../include/userobject.php";
$db = new Database();
$u = new UserObject();

if(isset($_GET['update'])){

} else {
	$result = $db->qry("SELECT id, name, url FROM modules WHERE enabled = 1 & onsidebar = 0");
	while($row = mysql_fetch_array($result)){
		extract($row);
		echo "$name<div id=\"module mod-$id\">";
		include $url;
		echo "</div>";
	}
}
?>