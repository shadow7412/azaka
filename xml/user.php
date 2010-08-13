<?php 
include_once "../include/userobject.php";
include_once "../include/linklist.php";

$l = new LinkList($u = new UserObject);

header("content-type: text/xml");

echo <<<DTD
<?xml version="1.0" ?> 
<!DOCTYPE note [
  <!ELEMENT content (#PCDATA)>
]>
DTD;


echo "<content>";


if($u->username == "guest"){
	echo "<form name=\"login\" method=\"get\" onsubmit=\"
	javascript:if(
		   validateNotEmpty(document.login.username.value) 
		|| validateNotEmpty(document.login.password.value)){
				errorMsg('Please take this seriously.', 'To log in you need to type in your username and password.');
				return false;
			} sendForm(this); 
				return false; \">
		<table>
		<tr>
		<td>
		<label for=\"username\">user</label>
		</td>
		<td>
		<input type=\"text\" name=\"username\" id=\"username\" />
		</td>
		</tr>
		<tr>
		<td>
		<label for=\"password\">code</label>
		</td>
		<td>
		<input type=\"password\" name=\"password\" id=\"password\" />
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
		<input type=\"submit\" value=\"login\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" />
		<input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:grabContent('register','action=wanttoregister')\" value=\"register\" />
		</td>
		</tr>
		</table>
		</form>";
} else {
	echo "Logged in as: ".$m->u->username;
	if($m->u->isLocal)	echo "<br/>Is local."; else echo "<br/>Is remote.";
	$l->addlink("logout","javascript:sendPost('pages/register.php?action=logout')",1);
	$m->addContent($l->dispBox(2));
}
echo "</content>";
?>