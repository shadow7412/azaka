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
		if (strpos($_SERVER['HTTP_USER_AGENT'],"iPhone") || //All iOS devices
			strpos($_SERVER['HTTP_USER_AGENT'],"TC_") ||    //HTC - Windows phone
		    strpos($_SERVER['HTTP_USER_AGENT'],"Android"))  //Andriod (duh)
			require("aesthetics/mobile.html");
		elseif (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE")) //Internet Explorer
			require("aesthetics/ie.html");
		else require("aesthetics/pc.html");
}
?>