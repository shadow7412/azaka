<?php
//if device is iphone - ask if user wants to go to iphone page
if (strpos($_SERVER['HTTP_USER_AGENT'],"iPhone"))
	include_once("mobile.php");
else
	include_once("pc.php");

?>