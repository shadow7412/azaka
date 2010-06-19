<?php
include_once "../include/module.php";
include_once "../include/userobject.php";
$m = new Module("user info", 0);
$u = new UserObject();

if($u->username = "guest"){
$m->addContent("<form name=\"login\" method=\"get\" onsubmit=\'if(document.login.username.value==null||document.login.password.value==null||document.login.username.value==\'\'||document.login.username.value==\'guest\'||document.login.password.value==\'\'){alert(\'Please take this seriously.\');return false;} action=\"javascript:sendPost(\'pages/register.php?username=\'+document.login.username.value+\'&password=\'+hex_md5(document.login.password.value))\"><table><tr><td><label for=\"username\">user</label></td><td><input type=\"text\" name=\"username\" id=\"password\"></td></tr><tr><td><label for=\"password\">code</label></td><td><input type=\"text\" name=\"password\" id=\"password\"></td></tr><tr><td></td><td><input type=\"submit\" /></td></tr></table></form>");
} else {
	$m->addContent("Logged in as: ".$u->username);
}
?>