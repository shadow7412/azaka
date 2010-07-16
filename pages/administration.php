<?php
include_once "../include/page.php";
$p = new Page("administration",3);

// DO ACTIONS
if(!isset($_GET['action'])){
//SETTINGS
} elseif ($_GET['action']=='settings'){
	foreach ($_GET as $option => $setting)
		if ($option != "action")
			$p->db->qry("UPDATE settings SET setting = '$setting' WHERE `option`='$option'");
//PAGE SETTINGS			
} elseif ($_GET['action']=='pagesetup')
	echo "";
//USER ADMIN
  elseif ($_GET['action']=='delete')
	$p->db->qry("UPDATE users SET disabled='1' WHERE id='".$_GET['user']."'");
  elseif ($_GET['action']=='reset'){
	$p->db->qry("UPDATE users SET password='".$_GET['newpass']."' WHERE id='".$_GET['user']."'");
	echo "Password has been reset";
}
echo "<div id=\"accordion\">";
$p->addJs("$(\"#accordion\").accordion({autoHeight: false, navigation: true})");

//SETTINGS
echo "<h3><a>Settings</a></h3><div>";
echo "<form type=\"get\" name=\"settings\" action=\"javascript:sendPost('pages/administration.php?action=settings\">
	<table><tr><td><strong>Option</strong></td><td><strong>Setting</strong></td></tr>";
$p->db->qry("SELECT * FROM settings");
while($row = $p->db->fetchLast()){
	$p->addJs("document.settings.action += \"&{$row['option']}='+document.settings.{$row['option']}.value + '\";");
	echo "<tr><td title=\"{$row['help']}\">{$row['title']}</td><td>";
	switch($row['type']){
		case ("bool"):
			echo "<select name=\"{$row['option']}\"><option value=\"1\"";
			echo $row['setting']?" selected=\"selected\"":"";
			echo " >Yes</option><option value=\"0\"";
			echo $row['setting']?"":" selected=\"selected\"";
			echo ">No</option></select>";
			break;
		case ("text"): echo "<input size=\"40\" name=\"{$row['option']}\" value=\"{$row['setting']}\"></input>";
			break;
		case ("tbox"): echo "<textarea cols=\"40\" rows=\"3\" name=\"{$row['option']}\">{$row['setting']}</textarea>";
			break;
		default: echo "Input type unknown.";
	}
	echo "</td></tr>";
}
$p->addJs("document.settings.action+=\"')\"");
echo "<tr><td><input type=\"submit\" value=\"Update settings\" class=\"ui-button ui-widget ui-state-default ui-corner-all\"/></td></tr></table></form></div>";

//PAGE SETTINGS
echo "<h3><a>Page Settings</a></h3><div>";
echo "Working on it...</div>";

//MODULE SETTINGS
echo "<h3><a>Module Settings</a></h3><div>";
$p->addJs("$(\"#modsettings\").sortable();");
$p->db->qry("SELECT * FROM modules ORDER BY `order`");
echo "<form><ul id=\"modsettings\" class=\"ui-helper-reset\" unselectable=\"on\">";
while ($row=$p->db->fetchLast()){
	echo "<li class=\"ui-state-default\" style=\"list-style-type: none; margin: 0; padding: 0; width: 100%;\">";
	echo "<table><tr><td><span class=\"ui-icon ui-icon-arrowthick-2-n-s\"></span></td><td width=\"90\"><strong>{$row['name']}: </strong></td><td>";
	echo "<select name=\"{$row['name']}onsidebar\"><option value=\"1\"";
	echo $row['onsidebar']?" selected=\"selected\"":"";
	echo " >SideBar</option><option value=\"0\"";
	echo $row['onsidebar']?"":" selected=\"selected\"";
	echo ">ModuleBar</option></select>";
	echo " local refresh<input type=\"text\" size=\"5\" name=\"localrefresh{$row['name']}\" value=\"{$row['localrefresh']}\"/>ms webrefresh<input type=\"text\" size=\"5\" name=\"localrefresh{$row['name']}\" value=\"{$row['webrefresh']}\"/>ms</li></td></tr></table>";
	}
echo "</ul><input type=\"submit\" value=\"Update\"class=\"ui-button ui-widget ui-state-default ui-corner-all\"/></form></div>";

//USER ADMINISTRATION
echo "<h3><a>User Administration</a></h3><div>";
$p->db->qry("SELECT id, username, access, billable FROM users WHERE disabled=0 ORDER BY username");
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
  <td><input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:if(newpass=prompt('What to?')) sendPost('pages/administration.php?action=reset&user=$id&newpass='+hex_md5(newpass))\" value=\"reset code\"/></td>
  <td><input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:if(confirm('Are you sure?')) sendPost('pages/administration.php?action=delete&user=$id')\" value = \"delete\"/></td></tr>";
  $p->addJs("document.useradmin.access$id.value = $access");
  $p->addJs("document.useradmin.billable$id.value = $billable");
	}
echo "<td></td></table></form></div>";

//ADD MORE ADMIN SECTIONS HERE
echo "</div>"
	
?>