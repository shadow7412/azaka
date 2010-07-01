<?php
include_once "../include/page.php";
$p = new Page('profile',1);
echo "<pre>";
print_r($_GET);
echo "</pre>";
$p->db->qry("SELECT * FROM users WHERE id='".$p->u->id."'");
extract($p->db->fetchLast());
echo "To change your password fill out the password fields - or just leave them be to leave your password be.<br/><br/>
<form name=\"profile\" id=\"profile\" type=\"get\" action=\"pages/profile.php\" onsubmit=\"javascript:if(document.profile.password.value==document.profile.cpassword.value)sendPost('pages/profile.php?password='+document.profile.password.value+'&firstname='+document.profile.fname.value+'&lastname='+document.profile.lname.value+'&email='+document.profile.email.value);else {document.profile.password.value='';document.profile.cpassword.value='';errorMsg('Your passwords do not match')};return false;\"><table>
<tr><td>change password</td><td><input type=\"password\" name=\"password\" id=\"password\"/></td></tr>
<tr><td>confirm password</td><td><input type=\"password\" name=\"cpassword\" id=\"cpassword\"/></td></tr>
<tr><td>first name</td><td><input type=\"text\" name=\"fname\" id=\"fname\" value=\"$firstname\"/></td></tr>
<tr><td>last name</td><td><input type=\"text\" name=\"lname\" id=\"lname\" value=\"$lastname\"/></td></tr>
<tr><td>email</td><td><input type=\"text\" name=\"email\" id=\"email\" value=\"$email\"/></td></tr>
<tr><td><input type=\"submit\" value=\"update\"')\"/></td></tr>";
echo "</table></form>";
?>