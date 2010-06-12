<?php
//aaaaaall the includes
global $userinfo;
include_once "inc/db.php";
include_once "inc/linklist.php";
include_once "inc/userobject.php";

class universal {
	var $bottom;
	function __construct($pagename,$reqaccess){
		global $userinfo;
		$userinfo = new userObject();
		include "aesthetic/top.php";
		$bottom = file_get_contents("aesthetic/bottom.html");

		//if device is iphone - ask if user wants to go to iphone page
		if (strpos($_SERVER['HTTP_USER_AGENT'],"iPhone"))
			echo confirmredirect("/azaka/mobile/","Do you want to go to the iPhone version of this site?");
	}
	
	function __destruct(){
		//on closing of script, update any changes to the userinfo array into the sessions, and update the cookies.
		//display bottom of page
		global $bottom;
		echo $bottom;
	}
}

function redirect($url, $message){ //This is just a function that pumps out javascript redirection text so I don't need to keep retyping it.
	echo "<script type='text/javascript'>";
	if(isset($message))	echo "alert(\"$message\");";
	echo "window.location=\"".$url."\";</script>";
	die("Redirecting...");
}

function confirmredirect($url, $question){ //This is just a function that pumps out javascript redirection text so I don't need to keep retyping it.
	echo "<script type='text/javascript'>";
	echo "if(confirm(\"$question\"))";
	echo "window.location=\"$url\";</script>";
}

function error($msg){
	echo "<div id=error>$msg</div>";
	die;
}
?>