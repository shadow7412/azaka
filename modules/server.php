<?php
include_once "../include/module.php";
$m = new Module("server", 5);
$m->addContent("later");
$m->addJs("document.getElementById('mod-server').innerHTML = 'updated successfully'");
?>