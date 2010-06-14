<?php
include "inc/page.php";
$p = new Page((isset($_POST['code']))?"error: ".$_POST['code']:"error",0);
if(isset($_POST['code'])&isset($_POST['msg'])){
	switch($_POST['code']){
	case 403:
	case 404:
		echo "<center><h1>-".$_POST['code']."-</h1><img src=\"aesthetics/images/error.png\"/></center>";
		break;
	default:
		echo "<div id=\"error\"<h1>Oops we have a ".$_POST['code']."</h1>\n".$_POST['msg']."</div>Hit the back button on your browser. You may need to double click. If all is lost - click the logo to reset the page.";	
	}
	
	} else
	echo "<div id=\"error\">Something weird has happened. Click the logo to reset the page.</div>";
?>