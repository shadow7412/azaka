<?php
include "inc/page.php";
$p = new Page((isset($_POST['code']))?"error: ".$_POST['code']:"error",0);
if(isset($_POST['code'])&isset($_POST['msg'])){
	echo "<h1>Oops we have a ".$_POST['code']."</h1>\n".$_POST['msg'];
	} else
	echo "Why would you manually go to an error page?";
?>