<?php
include_once "../include/page.php";
$p = new Page('profile',1);

if(isset($_GET['action']) && $_GET['action']=='profile'){
	$p->addJs("loadXML('user')");
	if($_GET['password']=='d41d8cd98f00b204e9800998ecf8427e') //hash of ''
		$p->db->qry("UPDATE users SET skin='{$_GET['skin']}',firstname='{$_GET['fname']}',	lastname='{$_GET['lname']}', email='{$_GET['email']}' WHERE id='{$p->u->id}'");
	else {
		$p->db->qry("UPDATE users SET password='{$_GET['password']}', skin='{$_GET['skin']}', firstname='{$_GET['fname']}', lastname='{$_GET['lname']}', email='{$_GET['email']}' WHERE id='{$p->u->id}'");
		$p->u->updatePassword($_GET['password']);
	}
} else
	$p->infoBox("To change your password fill out the password fields - or just leave them be to leave your password be.");

$p->db->qry("SELECT * FROM users WHERE id='".$p->u->id."'");
extract($p->db->fetchLast());
$p->db->qry("SELECT * FROM skins");

echo "<div id=\"accordion\"><h3><a>Profile</a></h3><div><form name=\"profile\" id=\"profile\" type=\"get\" onsubmit=\"javascript:
if(document.profile.password.value == document.profile.cpassword.value){
	document.profile.cpassword.value='';
	sendForm(this, 'profile');
} else {
	document.profile.password.value='';
	document.profile.cpassword.value='';
	document.profile.password.focus();
	errorMsg('Your passwords did not match. Have another go.')
} return false;\">
<table><tr><td>change password</td><td><input type=\"password\" name=\"password\" id=\"password\"/></td></tr>
<tr><td>confirm password</td><td><input type=\"password\" name=\"cpassword\" id=\"cpassword\"/></td></tr>";

echo "<tr><td>skin</td><td><select name=\"skin\">";
while($row = $p->db->fetchLast())
	echo "<option value='{$row['id']}'>{$row['name']}</option>";
echo "</select></td></tr>";
$p->addJs("document.profile.skin.value = '{$p->u->skin}';");
$p->addJs("$(\"#accordion\").accordion({autoHeight: false, navigation: true})");
echo "<tr><td>first name</td><td><input type=\"tex
	if(validatePopulated(document.profile.password.value))
		document.profile.password.value=hex_md5(document.profile.password.value);t\" name=\"fname\" id=\"fname\" value=\"$firstname\"/></td></tr>
<tr><td>last name</td><td><input type=\"text\" name=\"lname\" id=\"lname\" value=\"$lastname\"/></td></tr>
<tr><td>email</td><td><input type=\"text\" name=\"email\" id=\"email\" value=\"$email\"/></td></tr>
<tr><td><input type=\"submit\" value=\"update\"')\"/></td></tr>";
echo "</table></form></div></div>";
?>
