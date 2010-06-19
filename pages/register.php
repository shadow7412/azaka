<?php
echo "<pre>";
print_r($_SERVER);
echo "</pre>";
include_once "/include/db.php";
include_once "../include/userinfo.php";
$u = new UserObject();
$p = new Page;

if (isset($_GET['username']) && isset($_GET['password'])){
	$results = $db->qry("SELECT username, password FROM users WHERE username = '".$_POST['username']."'");
	
	if($result = mysql_fetch_array($db->qry("SELECT username, password FROM users WHERE username = '".$_POST['username']."'"))){
		if(/*password*/true){
			$u->updateCookies($_GET['username'], $_GET['password']);
			$u->updateUser();
			$p->addJs("forceUpdateMods();");
		} else {
			//incorrect password
			echo "dont like your password.";
		}
	} else {
		//username does not exist
			echo "who are you?";
	}
}
?>