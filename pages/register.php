<?php
include_once "../include/page.php";
include_once "../include/userobject.php";
$u = new UserObject();
$p = new Page("registration",0);

if (isset($_GET['username'])
	&& isset($_GET['password'])
	&& $result = mysql_fetch_array($p->db->qry("SELECT username, password FROM users WHERE username = '".$_GET['username']."'"))){
		if($result['password']==$_GET['password']){
			$u->updateCookies($_GET['username'], $_GET['password']);
			$p->addJs("forceUpdateMods();forceHash();");
		} else {
			//incorrect password
			echo "dont like your password.";
		}	
} else if($_GET['action']=="logout"){
	$u->invalidateSession();
	$p->addJs("forceUpdateMods();forceHash();");
} else {
	echo "Registration Form";
}
?>