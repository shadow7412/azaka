<?php
include_once "../include/module.php";
$m = new Module("ventrilio", 0);
$m->addContent("test");
//$m->db->sql("SELECT * FROM ");
$m->addJs("document.getElementById('mod-ventrilio').innerHTML = 'updated successfully'");
?>