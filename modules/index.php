<?php
include_once "../include/db.php";
include_once "../include/userobject.php";
$db = new Database();
$u = new UserObject();

$js = "<script id=\"modjs\">$(\"#modlist\").sortable();$(\"#modlist\").disableSelection();";
$db->qry("SELECT name, url, localrefresh, webrefresh FROM modules WHERE enabled = 1 AND onsidebar = 0");
echo "<ul style=\"list-style-type: none; margin: 0; padding: 0; width: 100%;\" id=\"modlist\">";
while($row = $db->fetchLast()){
	include_once $row['url'];
	if($u->canAccess($m->accessreq)){
		$js .= "runJs('modjs-".$row['name']."');";
		$m->setRefresh($u->islocal?$row['localrefresh']:$row['webrefresh']);
		echo "<li style=\"width:100%\"><div class=\"ui-state-default ui-corner-top\">{$m->name}</div>";
		echo "<div class=\"ui-widget-content ui-corner-bottom\">".$m->getContent()."</div><br/></li>";
		echo $m->getJs();
	}
}
echo "</ul>".$js."</script>";
?>