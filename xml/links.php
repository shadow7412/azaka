<?php 
include_once "../include/userobject.php";
include_once "../include/linklist.php";

$u = new UserObject;
$u->db->qry("SELECT * FROM links");

header("content-type: text/xml");

echo "<links>";
while($link = $u->db->fetchLast())
	if($u->canAccess($link['reqaccess']) || ($link['billoverride'] && $u->billable))
		echo "\n\t<link><label>{$link['label']}</label><url>{$link['url']}</url></link>";
echo "\n</links>";
?>