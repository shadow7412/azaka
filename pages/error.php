<?php
include "../include/page.php";
$p = new Page((isset($_GET['code']))?"error: ".$_GET['code']:"error",0);
if(isset($_GET['code'])&isset($_GET['msg'])){
	switch($_GET['code']){
	case 403:
	case 404:
	case 501:
		echo "<center><h1>-".$_GET['code']."-</h1><img src=\"aesthetics/images/error.png\"/></center>";
		break;
	default:
		echo "<div id=\"error\"<h1>Oops we have a ".$_GET['code']."</h1>\n".$_GET['msg']."</div>Hit the back button on your browser. You may need to double click. If all is lost - click the logo to reset the page.";	
	}
	
	} else echo "<div id=\"error\">The error page has been accessed directly.<br/> Click a link up the top, or to reset the page click the logo.</div>";
?>