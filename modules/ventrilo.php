<?php
include_once "../include/module.php";
include_once "../include/ventrilostatus.php";
$m = new Module("ventrilo", 0);

$m->addJs("var box = document.getElementById('mod-ventrilo');");
$m->addJs("box.innerHTML = xml.getElementsByTagName('name')[0].childNodes[0].nodeValue;");
$m->addJs("");
?>