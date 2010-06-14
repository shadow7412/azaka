<?php
//aaaaaall the includes
include_once "inc/db.php";
include_once "inc/linklist.php";
include_once "inc/userobject.php";
include_once "aesthetic/top.php";

class Page {
	private $bottom;
	public $userinfo;
	function __construct($pagename,$reqaccess){
		$this->userinfo = new UserObject();
		renderTop($this->userinfo,$pagename);
		$this->bottom = file_get_contents("aesthetic/bottom.html");

		//if device is iphone - ask if user wants to go to iphone page
		if (strpos($_SERVER['HTTP_USER_AGENT'],"iPhone"))
			echo confirmredirect("/azaka/mobile/","Do you want to go to the iPhone version of this site?");
	}
	
	function __destruct(){
		//display bottom of page
		echo $this->bottom;
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
	echo "<div id=error>$msg  <a href=\"config/initsetup.php\" onclick=\"return confirm('This will delete all existing data in the database if it exists. Continue?');\">Maybe remake database?</a></div>";
	die;
}
?>