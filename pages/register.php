<?php
include_once "../include/page.php";
$p = new Page("registration",0);

if (isset($_GET['username'])
	&& isset($_GET['password'])
	&& $result = mysql_fetch_array($p->db->qry("SELECT username, password FROM users WHERE username = '".$_GET['username']."'"))){
		if($result['password']==$_GET['password']){
			$p->u->updateCookies($_GET['username'], $_GET['password']);
			$p->addJs("forceUpdateMods();forceHash();");
		} else {
			//incorrect password
			echo "You seem to have inaccuratly typed your password.<br/>Poor you.<br/>Try again, or you can ask your benevolent admin to reset it...";
		}	
} else if(isset($_GET['action']) && $_GET['action']=="logout"){
	$p->u->invalidateSession();
	$p->addJs("forceUpdateMods();forceHash();");
} else {
	if(!(isset($_GET['action']) && $_GET['action']=="register"))
		echo "I do not remember you... But if you like you may register.";
	
}
?>