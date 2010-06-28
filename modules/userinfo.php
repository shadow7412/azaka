<?php
include_once "../include/module.php";
include_once "../include/linklist.php";
$m = new Module("user info", 0);
$ll = new LinkList();

if($m->u->username == "guest"){
	$m->addContent("<form name=\"login\" method=\"get\" onsubmit=\"javascript:if(document.login.username.value == null || document.login.username.value == \'\' ||document.login.password.value == \'\' ){alert(\'Please take this seriously.\');return false;} sendPost(\'pages/register.php?username=\'+document.login.username.value+\'&password=\'+hex_md5(document.login.password.value)); return false; \"><table><tr><td><label for=\"username\">user</label></td><td><input type=\"text\" name=\"username\" id=\"username\"></td></tr><tr><td><label for=\"password\">code</label></td><td><input type=\"password\" name=\"password\" id=\"password\"></td></tr><tr><td></td><td><input type=\"submit\" /> or <a href=\"javascript:sendPost(\'pages/register.php?action=register\')\">register</a></td></tr></table></form>");
} else {
	$m->addContent("Logged in as: ".$m->u->username);
	if($m->u->islocal)	$m->addContent("<br/>Is local.");
	else $m->addContent("<br/>Is remote.");
	$ll->addlink("logout","javascript:sendPost(\'pages/register.php?action=logout\')",1);
	$m->addContent($ll->dispBox(2));
	$m->addContent("<a href=\">Log off</a>");
}
?>