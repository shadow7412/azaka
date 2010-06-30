<?php
include_once "../include/page.php";
$p = new Page('profile',1);

$p->db->qry("SELECT * FROM users WHERE id='".$p->u->id."'");
extract($p->db->fetchLast());
echo "To change your password fill out the password fields - or just leave them be to leave your password be.<br/><br/><form><table>";
echo "<tr><td>change password</td><td><input type=\"password\" name=\"password\" id=\"password\"/></td></tr>";
echo "<tr><td>confirm password</td><td><input type=\"password\" name=\"cpassword\" id=\"cpassword\"/></td></tr>";
echo "<tr><td>first name</td><td><input type=\"text\" name=\"fname\" id=\"fname\" value=\"$firstname\"/></td></tr>";
echo "<tr><td>last name</td><td><input type=\"text\" name=\"lname\" id=\"lname\" value=\"$lastname\"/></td></tr>";
echo "<tr><td>email</td><td><input type=\"text\" name=\"email\" id=\"email\" value=\"$email\"/></td></tr>";
echo "<tr><td><input type=\"submit\" value=\"update\"/></td></tr>";
echo "</table></form>";
?>