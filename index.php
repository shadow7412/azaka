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
			strpos($_SERVER['HTTP_USER_AGENT'],"HTC") || 
		    strpos($_SERVER['HTTP_USER_AGENT'],"Android"))
			require("aesthetics/mobile.html");
		elseif (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE"))
			require("aesthetics/ie.html");
		else require("aesthetics/pc.html");
}
?>