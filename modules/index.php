<?php
include_once "../include/db.php";
include_once "../include/userobject.php";
$db = new Database();
$u = new UserObject();

$js = "<script id=\"modjs\">";
$db->qry("SELECT name, url FROM modules WHERE enabled = 1 & onsidebar = 0");
while($row = $db->fetchLast()){
	$js .= "runJs('modjs-".$row['name']."');";
	include $row['url'];
	echo $m->getContent();
	echo $m->getJs();
}
echo $js."</script>";
?>