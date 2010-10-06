<?php
include_once "../include/module.php";
include_once "../include/linklist.php";
$m = new Module("links", 0);

$m->addContent("<ul id=\"mod-links-content\"></ul>");
$m->addJs("var links = document.getElementById('mod-links-content'); links.innerHTML = '';var count = 0; var link = null;");
$m->addJs("while((link = xml.getElementsByTagName('link')[count++]) != undefined)");
$m->addJs("links.innerHTML += '<li class=\"linklist\"><a href=\"'+link.childNodes[1].childNodes[0].nodeValue+'\">' + link.childNodes[0].childNodes[0].nodeValue + '</a></li>'");
?>
