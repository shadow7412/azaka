<?php
include_once "../include/page.php";
$p = new Page("ping",0);

$p->addJs("$(\"#accordion\").accordion({autoHeight: false, navigation:true} )");
exec("vnstat",$vnstat);
if (strpos($_SERVER['SERVER_SOFTWARE'],"Win"))
	exec("ping www.google.com",$ping);
else
	exec("ping -c 3 www.google.com",$ping);

echo "<div id=\"accordion\">";

echo "<h3><a>ping</a></h3><div>";
foreach($ping as $output)
	echo $output."<br/>";
echo "</div>";	

echo "<h3><a>stats</a></h3><div><pre>";
foreach($vnstat as $output)
	echo $output."<br/>";
echo "</pre></div>";


echo" </div>";


?>
