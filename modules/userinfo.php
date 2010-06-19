<?php
include_once "../include/module.php";
include_once "../include/userobject.php";
$m = new Module("user info", 0);
$u = new UserObject();

$m->addContent($u->username);
?>