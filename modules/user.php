<?php
include_once "../include/module.php";
include_once "../include/linklist.php";
$m = new Module("user", 0);
$l = new LinkList($m->u);

$m->addContent("<div id=\"mod-user-content\"></div>");
$m->addJs("document.getElementById('mod-user-content').value = xml.getElementByTagName('content')[0].nodeValue;");
?>
