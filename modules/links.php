<?php
include_once "../include/module.php";
include_once "../include/linklist.php";
$m = new Module("links", 0);

$m->addJs("var links = document.getElementById('mod-links'); links.innerHTML = '';var count = 0; var link = null;");
$m->addJs("while((link = xml.getElementsByTagName('link')[count++]) != undefined)");
$m->addJs("links.innerHTML += '<a href=\"'+link.childNodes[1].childNodes[0].nodeValue+'\">' + link.childNodes[0].childNodes[0].nodeValue + '</a><br/>'");
?>
