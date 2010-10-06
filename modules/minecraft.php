<?php
include_once "../include/module.php";
include_once "../include/linklist.php";
$m = new Module("minecraft", 0);

$m->addContent("<ul id=\"mod-minecraft-content\"></ul>");
$m->addJs("var minecraft = document.getElementById('mod-minecraft-content'); minecraft.innerHTML = '';var count = 0; var line = null;");
$m->addJs("while((line = xml.getElementsByTagName('line')[count++]) != undefined)");
$m->addJs("minecraft.innerHTML += '<li>' + line.childNodes[0].nodeValue + '</li>'");
?>
