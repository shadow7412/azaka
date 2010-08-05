<?php
include_once "../include/page.php";
$p = new Page("ping",0);

exec("ping -c 3 www.google.com",$ping);

foreach($ping as $output)
	echo $output."<br/>";
?>
