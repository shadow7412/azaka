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

//LINK SETTINGS
} elseif ($_GET['action']=="linksettings"){
	$p->db->qry("DELETE FROM links"); //clear current links before adding them back in
	$value = strtok($_GET['order'],' ');
	if ($value != '')
		do{
			$p->db->qry("INSERT INTO links (label, url, reqaccess, billoverride) VALUES ('{$_GET['label'.$value]}','{$_GET['url'.$value]}','{$_GET['access'.$value]}','{$_GET['billoverride'.$value]}')");
		}while (($value = strtok(' '))!=null);
		
	if($_GET['newurl']!='')
		$p->db->qry("INSERT INTO links (label, url) VALUES ('{$_GET['newlabel']}','{$_GET['newurl']}')");
	$p->addJs("loadXML('links');"); //reload link bar straight away
	
//PAGE SETTINGS			
} elseif ($_GET['action']=='pagesetup'){
	echo "<pre>".print_r($_GET,true)."</pre>";
	
//MODULE SETTINGS			
} elseif ($_GET['action']=='modulesetup'){
	$p->infoBox('Changing module settings can break the page. If this happens, just refresh your browser.');

	$order = 0;
	$value = strtok($_GET['order'],' ');
	do{
		$order++;
		$p->db->qry("UPDATE modules SET `enabled`='{$_GET["enabled".$value]}', `order`='$order', `onsidebar`='{$_GET["onsidebar".$value]}',`localrefresh`='{$_GET["localrefresh".$value]}',`webrefresh`='{$_GET["webrefresh".$value]}' WHERE `id` = '$value'");
	}while ($value = strtok(' '));
	$p->addJs("forceModulesUpdate();grabSidebar();");

//USER ADMIN
} elseif ($_GET['action']=='useradmin'){
	$userid = strtok($_GET['victims'],' ');
	do 
		$p->db->qry("UPDATE users SET `access`='{$_GET["access$userid"]}', `billable`='{$_GET["billable$userid"]}' WHERE id='{$userid}'" );
	while (($userid = strtok(' ')) != null);

} elseif ($_GET['action']=='user_delete'){
		$p->db->qry("UPDATE users SET disabled='1' WHERE id='".$_GET['user']."'");
		$p->infoBox("User has been disabled.");
	}
  elseif ($_GET['action']=='user_reset'){
	$p->db->qry("UPDATE users SET password='".$_GET['newpass']."' WHERE id='".$_GET['user']."'");
	$p->infoBox("Password has been reset.");
}

// SHOW FORMS
echo "<div id=\"accordion\">";
$p->addJs("$(\"#accordion\").accordion({autoHeight: false, navigation: true})");

//SETTINGS
echo "<h3><a>Settings</a></h3><div>";
$p->infoBox("If you are unclear on any setting, put your mouse over the title of its label. A tooltip will appear.");
echo "<form type=\"get\" name=\"settings\" onsubmit=\"sendForm(this,'admin')\" >
	<table><tr><td><strong>Option</strong></td><td><strong>Setting</strong></td></tr>";
$p->db->qry("SELECT * FROM settings");
while($row = $p->db->fetchLast()){
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
		case ("mail"): echo "<input size=\"40\" name=\"{$row['option']}\" value=\"{$row['setting']}\" onblur=\"if((!isEmail(this.value))&&this.value!=''){this.value='';this.focus();errorMsg('the email in that field is not valid');}\"></input>";
			break;
		case ("int"): echo "<input size=\"40\" name=\"{$row['option']}\" value=\"{$row['setting']}\" onKeyPress=\"enterNumbers()\"></input>";
			break;
		case ("tbox"): echo "<textarea cols=\"40\" rows=\"3\" name=\"{$row['option']}\">{$row['setting']}</textarea>";
			break;
		default: echo "Input type unknown.";
	}
	echo "</td></tr>";
}

echo "<tr><td><input type=\"submit\" name=\"submitbutton\" value=\"Update settings\" class=\"ui-button ui-widget ui-state-default ui-corner-all\"/></td></tr></table></form></div>";

//LINK SETTINGS
$row = $p->db->fetch($p->db->qry("SELECT enabled FROM modules WHERE name='links'"));
if($row['enabled']){
	echo "<h3><a>Link Module Settings</a></h3><div><form name=\"linksettings\" id=\"linksettings\" onsubmit=\"sendForm(this,'admin',document.getElementById('linksettingslist'))\">
<ul id=\"linksettingslist\" class=\"ui-helper-reset\" unselectable=\"on\">";

	$p->addJs("$(\"#linksettingslist\").sortable({placeholder: 'ui-state-highlight'});");
	$id = 0;
	$p->db->qry("SELECT * FROM links");
	while($row=$p->db->fetchLast()){
		echo "<li class=\"ui-state-default\" style=\"list-style-type: none; margin: 0; padding: 0; width: 100%;\">
		<input type=\"hidden\" value=\"$id\"/>
		<table><tr><td><span class=\"ui-icon ui-icon-arrowthick-2-n-s\"></span></td><td>
		<input name=\"label$id\" size = \"7\" value=\"{$row['label']}\"/>
		<input name=\"url$id\" value=\"{$row['url']}\"/> 
		<select name=\"access$id\">
			<option value=\"0\">Unauthorised</option>
			<option value=\"1\">Authorised</option>
			<option value=\"2\">Admin</option>
			<option value=\"3\">God</option>
		</select>
		</td><td>
		<select name=\"billoverride$id\">
			<option value=\"0\">Ignore Billability</option>
			<option value=\"1\">or Billable</option>
		</select></td>
		<td><input type=\"button\" onclick=\"this.parentElement.parentElement.parentElement.parentElement.parentElement.outerHTML = '';\" value=\"Delete\"/></td></tr></table></li>";
		$id++; 
		}
	echo "</ul>
	<input type=\"hidden\" name=\"newlabel\"/><input type=\"hidden\" name=\"newurl\"/>
	<input type=\"submit\" onclick=\"
	if(
	((document.linksettings.newlabel.value = prompt('Label?')) != undefined) &&
document.linksettings.newlabel.value != '' &&
 ((document.linksettings.newurl.value=prompt('URL?')) != undefined) &&
document.linksettings.newurl.value != '') return true; else {errorMsg('Adding new link cancelled.');false;}\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" value=\"add new\"/>
	<input type=\"submit\" class=\"ui-button ui-widget ui-state-default ui-corner-all\"></form></div>";
}

//PAGE SETTINGS
echo "<h3><a>Page Settings</a></h3><div>";
echo "Working on it...</div>";

//MODULE SETTINGS
echo "<h3><a>Module Settings</a></h3><div>";
$p->addJs("$(\"#modsettingslist\").sortable({placeholder: 'ui-state-highlight'});");
$p->db->qry("SELECT * FROM modules ORDER BY `order`");
echo "<div class=\"ui-widget\">".$p->infoBox("The sidebar is on the left. It will refresh whenever a page is loaded.<br/>The modulebar is on the right. It will refresh automatically as indicated by the local/web refresh fields")."</div>";

echo "<form name=\"modulesetup\" onsubmit=\"sendForm(this,'admin',document.getElementById('modsettingslist'));\">
<ul id=\"modsettingslist\" class=\"ui-helper-reset\" unselectable=\"on\">";
while ($row=$p->db->fetchLast()){
	echo "<li class=\"ui-state-default\" style=\"list-style-type: none; margin: 0; padding: 0; width: 100%;\">";
	echo "<input type=\"hidden\" value=\"{$row['id']}\"/>";
	
	echo "<table><tr><td><span class=\"ui-icon ui-icon-arrowthick-2-n-s\"></span></td><td width=\"90\"><strong>{$row['name']}: </strong></td><td>";
	
	echo "<select name=\"enabled{$row['id']}\"><option value=\"1\"";
	echo $row['enabled']?" selected=\"selected\"":"";
	echo " >On</option><option value=\"0\"";
	echo $row['enabled']?"":" selected=\"selected\"";
	echo ">Off</option></select>";

	echo "<select name=\"onsidebar{$row['id']}\"><option value=\"1\"";
	echo $row['onsidebar']?" selected=\"selected\"":"";
	echo " >SideBar</option><option value=\"0\"";
	echo $row['onsidebar']?"":" selected=\"selected\"";
	echo ">ModuleBar</option></select>";
	
	echo " local-refresh<input type=\"text\" size=\"4\" name=\"localrefresh{$row['id']}\" value=\"{$row['localrefresh']}\"/>";
	echo "ms web-refresh<input type=\"text\" size=\"4\" name=\"webrefresh{$row['id']}\" value=\"{$row['webrefresh']}\"/>ms</li></td></tr></table>";
	}
echo "</ul><input type=\"submit\" value=\"Update\" class=\"ui-button ui-widget ui-state-default ui-corner-all\"/></form></div>";

//USER ADMINISTRATION
echo "<h3><a>User Administration</a></h3><div>";
$p->db->qry("SELECT id, username, access, billable FROM users WHERE disabled=0 ORDER BY username");
echo "<form name='useradmin' onsubmit=\"sendForm(this,'admin')\">
	<input type=\"hidden\" value=\"\" name=\"victims\"/><table>";
while($row = $p->db->fetchLast()){
	extract($row);
	echo "<tr><td>$username</td><td>
  <select name=\"access$id\">
    <option value=\"0\">Unauthorised</option>
    <option value=\"1\">Authorised</option>
    <option value=\"2\">Admin</option>
    <option value=\"3\">God</option>
  </select>
  </td><td>
  <select name=\"billable$id\">
    <option value=\"0\">Standard</option>
    <option value=\"1\">Billable</option>
  </select></td>
  <td><input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:if(newpass=prompt('What to?')) grabContent('admin','action=user_reset&user=$id&newpass='+hex_md5(newpass))\" value=\"reset code\"/></td>
  <td><input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:if(confirm('Are you sure?')) grabContent('admin','action=user_delete&user=$id')\" value = \"disable\"/></td></tr>";
	$p->addJs("document.useradmin.access$id.value = $access;");
	$p->addJs("document.useradmin.billable$id.value = $billable;");
	$p->addJs("document.useradmin.victims.value += $id+' ';");
	}
echo "<tr id=\"admin-users-eof\"></tr></table><input type=\"submit\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" value=\"Update\"/>";

$p->db->qry("SELECT id, username FROM users WHERE disabled=1");
if($p->db->noLast()){
	echo "<input type\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" value=\"View disabled users\"/>";
	$disableduserform = "<tr><td>a</td></tr><tr id=\"admin-user-eof\"></tr>";
	$p->addJs("document.getElementById('admin-users-eof').outerHTML='$disableduserform'");
}
echo "</form></div>";

//ADD MORE ADMIN SECTIONS HERE
echo "</div>"
	
?>
