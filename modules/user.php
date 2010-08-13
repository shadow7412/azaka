<?php
include_once "../include/module.php";
include_once "../include/linklist.php";
$m = new Module("user", 0);
$l = new LinkList($m->u);

$m->addContent("<div id=\"mod-user-content\"></div>");
$m->addJs("alert(xml.getElementsByTagName('content')[0].childNodes[0].innerHTML)");
//$m->addJs("document.getElementById('mod-user-content').innerHTML = xml.getElementsByTagName('content')[0].nodeValue;");
?>
