<?php

error_reporting(E_ALL);
ini_set("display_errors",1);

//includes (grab from some other module)
include_once "../include/module.php";
include_once "../include/userobject.php";

//create module class
$m = new Module("shoutbox", 0);
$u = new UserObject;

//add the placeholders for existig messages using addContent()
$m->addContent("<ul id=\"mod-shoutbox-content\"></ul>");
$m->addJs("var shoutbox = document.getElementById('mod-shoutbox-content'); shoutbox.innerHTML = ''; var count = 0; var shoutbox = null;");
$m->addJs("while(shoutbox = xml.getElementsByTagName('message')[count++] != undefined);");

//add the form using addContent() - verify a message is printed. Maybe do not show form unless a user is logged in
/*
if($u->canAccess(1)){
   $m->addContent("<form id=\"mod-shoutbox-form\" name=\"shoutblog\" onsubmit=\"if(document.mod-shoutbox-form.message.value == ''){
                     errorMsg('Please enter a message in the field before pressing enter..');
                     };\" action = \"javascript:false\">
                  <table>
                     <tr>
                        <td>Message</td>
                        <td><textarea rows=\"10\" cols=\"60\" name=\"message\">A big load of text here</textarea></td>
                     </tr>
                     <tr>
                        <td><input type=\"submit\" name=\"action\" value=\"shoutblog\" class=\"ui-buttonui-widget ui-state-default ui-corner-all\"></td>
                     </tr>
                  </table>
                  </form>");
}
*/
//add the messages into the place holder using javascript > addJs()
//You will want to see another module file (such as links) to figure
//this out
?>
