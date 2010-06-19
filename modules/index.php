<?php
include_once "../include/db.php";
include_once "../include/userobject.php";
$db = new Database();
$u = new UserObject();

$js = "<script id=\"modjs\">";
$result = $db->qry("SELECT name, url FROM modules WHERE enabled = 1 & onsidebar = 0");
while($row = mysql_fetch_array($result)){
	$js .= "try{eval(document.getElementById('modjs-".$row['name']."').innerHTML)} catch (err) {alert('".$row['name']." has failed: '+err);}";
	include $row['url'];
	$m->renderContent();
	$m->renderJs();
}
echo $js."</script>";
?>