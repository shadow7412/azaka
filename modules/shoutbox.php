<?php

//includes (grab from some other module)
include_once "../include/module.php";
include_once "../include/userobject.php";

//create module class
$m = new Module("shoutbox", 0);
$u = new UserObject;

//add the placeholders for existig messages using addContent()

$m->addContent("<div id=\"mod-shoutbox-contents\"></div>");
$m->addJs("var shoutbox = document.getElementById('mod-shoutbox-contents'); shoutbox.innerHTML = ''; var count = 0;");
$m->addJs("while((message = xml.getElementsByTagName('message')[count++]) != undefined)");
$m->addJs("shoutbox.innerHTML += '<p><b>' + message.childNodes[0].childNodes[0].nodeValue + '</b> ' + message.childNodes[1].childNodes[0].nodeValue + '<br />' + message.childNodes[2].childNodes[0].nodeValue + '</p>'");

if($u->canAccess(1)){
   $m->addContent("<form id=\"mod-shoutbox-form\" name=\"Shoutblog\" onsubmit=\"if(document.getElementById('message') == ''){
                     errorMsg('Please enter a message in the field before pressing enter..'); return false;}
                     else{sendForm(this, 'shoutbox')};\">
                  <table>
                     <tr>Message:</tr>
                     <tr><input type=\"text\" name=\"message\" id=\"message\"></tr>
                     <tr>
                        <td><input type=\"submit\" value=\"Shout\" class=\"ui-buttonui-widget ui-state-default ui-corner-all\"/></td>
                     </tr>
                  </table>
                  </form>");
}

//add the messages into the place holder using javascript > addJs()
//You will want to see another module file (such as links) to figure
//this out
?>
