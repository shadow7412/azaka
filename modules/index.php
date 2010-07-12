<?php
include_once "../include/db.php";
include_once "../include/userobject.php";
$db = new Database();
$u = new UserObject();

$js = "<script id=\"modjs\">";
$db->qry("SELECT name, url, localrefresh, webrefresh FROM modules WHERE enabled = 1 AND onsidebar = 0");
while($row = $db->fetchLast()){
	$js .= "runJs('modjs-".$row['name']."');";
	include_once $row['url'];
	$m->setRefresh($u->islocal?$row['localrefresh']:$row['webrefresh']);
	echo $m->getContent();
	echo $m->getJs();
}
echo $js."</script>";
?>