<?php
include_once "../include/page.php";
$p = new Page("administration",3);

if(!isset($_GET['action'])){
} elseif ($_GET['action']=='delete')
	$p->db->qry("UPDATE users SET disabled='1' WHERE id='".$_GET['user']."'");
  elseif ($_GET['action']=='reset'){
	$p->db->qry("UPDATE users SET password='".$_GET['newpass']."' WHERE id='".$_GET['user']."'");
	echo "Password has been reset";
}

echo "<h2>User Administration</h2>";
$p->db->qry("SELECT id, username, access, billable FROM users WHERE disabled=0");
echo "<form name='useradmin' id='useradmin'><table>";
while($row = $p->db->fetchLast()){
	extract($row);
	echo "<tr><td>$username</td><td>
  <select name=\"access$id\" id=\"access\">
    <option value=\"0\">Unauthorised</option>
    <option value=\"1\">Authorised</option>
    <option value=\"2\">Admin</option>
    <option value=\"3\">God</option>
  </select>
  </td><td>
  <select name=\"billable$id\" id=\"billable\">
    <option value=\"0\">Standard</option>
    <option value=\"1\">Billable</option>
  </select></td>
  <td><a href=\"javascript:if(newpass=prompt('What to?')) sendPost('pages/administration.php?action=reset&user=$id&newpass='+hex_md5(newpass))\">reset code</a></td>
  <td>or <a href=\"javascript:if(confirm('Are you sure?')) sendPost('pages/administration.php?action=delete&user=$id')\">delete</a></td></tr>";
  $p->addJs("document.useradmin.access$id.value = $access");
  $p->addJs("document.useradmin.billable$id.value = $billable");
	}
echo "</table></form>"
	
?>