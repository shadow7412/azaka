<?php
include_once "../include/module.php";
include_once "../include/linklist.php";
$m = new Module("links", 1);
$l = new LinkList($m->u);

$m->db->qry("SELECT label, url, reqaccess, billoverride FROM links");
while($row = $m->db->fetchLast()){
	if($row['billoverride']&&$m->u->billable) $row['reqaccess'] = 0; //override default access if required
	$l->addLink($row['label'],$row['url'], $row['reqaccess']);
}
if($m->db->noLast()==0)
	$m->addContent("No links available.");
else $m->addContent($l->dispBox(2));
?>