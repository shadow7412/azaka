<?php
include_once "../include/module.php";
include_once "../include/ventrilostatus.php";
$m = new Module("ventrilo", 0);

$m->addJs("var box = document.getElementById('mod-ventrilo');");
$m->addJs("box.innerHTML = '<strong>'+xml.getElementsByTagName('name')[0].childNodes[0].nodeValue+'</strong><br/>';");
$m->addJs("var counter = 0; var users=''; var user='';");
$m->addJs("while((user = xml.getElementsByTagName('user')[counter++])!=null)");
$m->addJs("users+=user.childNodes[0].nodeValue+'<br/>';");
$m->addJs("box.innerHTML+=users;");
?>