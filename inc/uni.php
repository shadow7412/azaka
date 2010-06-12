<?php
include "inc/db.php";

class universal {
	function __construct($pagename,$reqaccess){
		
	
		include "aesthetic/top.php";
	}

	function __destruct(){
		//on closing of script, update any changes to the userinfo array into the sessions, and update the cookies.
		//global $userinfo;
		//$_SESSION['userinfo'] = $userinfo;
		//setcookie("username",$userinfo['username'],time()+60*60*24*14);
		//setcookie("password",$userinfo['password'],time()+60*60*24*14);
		
		//also render the bottom of the page
		//include "aesthetic/bottom.php";
	}
	
function redirect($url, $message){ //This is just a function that pumps out javascript redirection text so I don't need to keep retyping it.
	echo "<script type='text/javascript'>";
	if(isset($message))	echo "alert(\"$message\");";
	echo "window.location=\"".$url."\";</script>";
	die("Redirecting...");
}

function error($smg){
echo "<div id=error>$msg</div>";
die;
}

}
?>