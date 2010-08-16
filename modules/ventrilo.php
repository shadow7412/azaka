<?php
include_once "../include/module.php";
include_once "../include/ventrilostatus.php";
$m = new Module("ventrilo", 0);

$m->addJs("var box = document.getElementById('mod-ventrilo');");
$m->addJs("box.innerHTML = '<strong>'+xml.getElementsByTagName('name')[0].childNodes[0].nodeValue+'</strong><br/>';");
$m->addJs("var counter = 0; var user='';");
$m->addJs("while((user = xml.getElementsByTagName('user')[counter++])!=null)");
$m->addJs("box.innerHTML+=user.childNodes[0].nodeValue+'<br/>';");
?>