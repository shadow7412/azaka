<?php
include_once "../include/module.php";
include_once "../include/linklist.php";
$m = new Module("user", 0);
$l = new LinkList($m->u);

//Login box
$m->addContent("<div id=\"mod-user-loginbox\" style=\"display:none;\">
<form id=\"mod-user-login\" name=\"login\" method=\"get\" onsubmit=\"
		if(
		   validatePopulated(document.getElementById('mod-user-login-username').value) 
		&& validatePopulated(document.getElementById('mod-user-login-password').value)){
				sendForm(this,'register'); 
			} else {
				errorMsg('Please take this seriously.', 'To log in you need to type in your username and password.');
			}
		return false; \">
		<table>
		<tr>
		<td>
		<label for=\"username\">user</label>
		</td>
		<td>
		<input type=\"text\" name=\"username\" id=\"mod-user-login-username\" />
		</td>
		</tr>
		<tr>
		<td>
		<label for=\"password\">code</label>
		</td>
		<td>
		<input type=\"password\" name=\"password\" id=\"mod-user-login-password\" />
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td>
		<input type=\"submit\" value=\"login\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" />
		<input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:grabContent('register','action=wanttoregister')\" value=\"register\" />
		</td></tr></table></form></div>");
		
//User Info section
$m->addContent("<div id=\"mod-user-info\" style=\"display:inline;\">
	Logged in as: <div id=\"mod-user-info-username\" style=\"display:inline;\">...</div><br/>
	<div id=\"mod-user-info-connection\">still loading...</div>
	<input type=\"button\" value=\"logout\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:document.cookie = 'azaka_user=;path=/';grabModules(); grabSidebar();grabContent(window.location.hash.substring(1,99));false;\"/>
	</div>");

//Show/hide relevant area.
$m->addJs("if(xml.getElementsByTagName('username')[0].childNodes[0].nodeValue == 'guest') {");
$m->addJs("document.getElementById('mod-user-info').style.display = 'none';");
$m->addJs("document.getElementById('mod-user-loginbox').style.display = 'inline';");
$m->addJs("} else {");
$m->addJs("document.getElementById('mod-user-info').style.display = 'inline';");
$m->addJs("document.getElementById('mod-user-loginbox').style.display = 'none';}");

//Fill in userdata
$m->addJs("document.getElementById('mod-user-info-username').innerHTML = xml.getElementsByTagName('username')[0].childNodes[0].nodeValue;");
$m->addJs("document.getElementById('mod-user-info-connection').innerHTML = xml.getElementsByTagName('connection')[0].childNodes[0].nodeValue;");
$m->addJs("document.getElementById('mod-user-info-connection').innerHTML += ' - ' + xml.getElementsByTagName('ip')[0].childNodes[0].nodeValue;");
$m->addJs("document.getElementById('skin').href = xml.getElementsByTagName('skin')[0].childNodes[0].nodeValue;");

//$m->addJs("document.getElementById('mod-user-content').innerHTML = xml.getElementsByTagName('content')[0].nodeValue;");
?>
