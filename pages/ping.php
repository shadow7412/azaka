<?php
include_once "../include/page.php";
$p = new Page("ping",0);

$p->addJs("$(\"#accordion\").accordion({autoHeight: false, navigation:true} )");
exec("vnstat",$vnstat);
echo "<div id=\"accordion\"><h3><a>stats</a></h3><div><pre>";
foreach($vnstat as $output)
	echo $output."<br/>";
echo "</pre></div><h3><a>ping</a></h3><div>";

exec("ping -c 3 www.google.com",$ping);
foreach($ping as $output)
	echo $output."<br/>";
echo "</div></div>";


?>
