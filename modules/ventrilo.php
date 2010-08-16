<?php
include_once "../include/module.php";
include_once "../include/ventrilostatus.php";
$m = new Module("ventrilo", 0);

$m->addJs("var box = document.getElementById('mod-ventrilo');");
$m->addJs("box.innerHTML = 'Pull successful. Now to parse the XML...';");
$m->addJs("");
?>