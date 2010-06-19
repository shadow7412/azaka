<?php
include_once "../include/module.php";
$m = new Module("ventrilio", 0);
$m->addContent("test");
$m->addJs("document.getElementById('mod-ventrilio').innerHTML = 'woo updated'");
?>