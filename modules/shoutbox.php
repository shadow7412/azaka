<?php

include_once "../include/module.php";
include_once "../include/userobject.php";

$m = new Module("shoutbox", 0);
$u = new UserObject;

$m->addContent("<div id=\"mod-shoutbox-contents\"></div>");
$m->addJs("var shoutbox = document.getElementById('mod-shoutbox-contents'); shoutbox.innerHTML = ''; var count = 0;");
$m->addJs("while((message = xml.getElementsByTagName('message')[count++]) != undefined)");
$m->addJs("shoutbox.innerHTML += '<p><b>' + message.childNodes[0].childNodes[0].nodeValue + '</b> ' + message.childNodes[1].childNodes[0].nodeValue + '<br />' + message.childNodes[2].childNodes[0].nodeValue + '</p>'");

if($u->canAccess(1)){
   $m->addContent("<form id=\"mod-shoutbox-form\" name=\"Shoutblog\" onsubmit=\"if(document.getElementById('mod-shoutbox-form').message.value == ''){
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

?>
