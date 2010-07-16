<?php
include_once "../include/module.php";
include_once "../include/linklist.php";
$m = new Module("user info", 0);
$l = new LinkList($m->u);

if($m->u->username == "guest"){
	$m->addContent("<form name=\"login\" method=\"get\" onsubmit=\"javascript:if(document.login.username.value == null || document.login.username.value == \'\' ||document.login.password.value == \'\' ){errorMsg(\'Please take this seriously.\');return false;} sendPost(\'pages/register.php?username=\'+document.login.username.value+\'&password=\'+hex_md5(document.login.password.value)); return false; \"><table><tr><td><label for=\"username\">user</label></td><td><input type=\"text\" name=\"username\" id=\"username\"></td></tr><tr><td><label for=\"password\">code</label></td><td><input type=\"password\" name=\"password\" id=\"password\"></td></tr><tr><td></td><td><input type=\"submit\" value=\"login\"/ class=\"ui-button ui-widget ui-state-default ui-corner-all\"> or <input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:sendPost(\'pages/register.php?action=register\')\" value=\"register\"></button</td></tr></table></form>");
} else {
	$m->addContent("Logged in as: ".$m->u->username);
	if($m->u->isLocal)	$m->addContent("<br/>Is local."); else $m->addContent("<br/>Is remote.");
	$l->addlink("logout","javascript:sendPost(\'pages/register.php?action=logout\')",1);
	$m->addContent($l->dispBox(2));
}
?>