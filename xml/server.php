<?php
include_once "../include/bandwidth.php";
$stats = new Bandwidth;
header ("content-type: text/xml");
echo "<bandwidth><upload>".$stats->upload."</upload><download>".$stats->download."</download></bandwidth>";
?>