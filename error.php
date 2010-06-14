<?php
if(isset($_GET['code'])&isset($_GET['msg']))
	echo "<h1>Oops we have a ".$_GET['code']."</h1>\n".$_GET['msg'];
else
	echo "Why would you manually go to an error page?";
?>