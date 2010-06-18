<?php
if(!isset($_GET['view']))
	$_GET['view'] = "";
	
switch ($_GET['view']){
	case 'pc':
		require("aesthetics/pc.html");
		break;
	case 'iphone':
		require("aesthetics/iphone.html");
		break;
	default:
		if (strpos($_SERVER['HTTP_USER_AGENT'],"iPhone")) require("aesthetics/iphone.html");
		else require("aesthetics/pc.html");
}
?>