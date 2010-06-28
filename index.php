<?php
if(!isset($_GET['view']))
	$_GET['view'] = "";
	
switch ($_GET['view']){
	case 'pc':
		require("aesthetics/pc.html");
		break;
	case 'mobile':
		require("aesthetics/mobile.html");
		break;
	default:
		if (strpos($_SERVER['HTTP_USER_AGENT'],"iPhone") || 
		strpos($_SERVER['HTTP_USER_AGENT'],"Android"))
			require("aesthetics/mobile.html");
		else require("aesthetics/pc.html");
}
?>