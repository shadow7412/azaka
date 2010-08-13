<?php
include_once "../include/module.php";
$m = new Module("bandwidth", 0);

//create placeholders
$m->addContent("<table><tr><td width=10><span class=\"ui-icon ui-icon-carat-1-n\"></span></td><td width=60>
<span id=\"mod-bandwidth-upload\">...</span></td><td width=10><span class=\"ui-icon ui-icon-carat-1-s\"></span></td><td width=60>
<span id=\"mod-bandwidth-download\">...</span></td></tr></table>");

//Add in data
$m->addJs("document.getElementById('mod-bandwidth-upload').innerHTML = xml.getElementsByTagName('liveupload')[0].childNodes[0].nodeValue;");
$m->addJs("document.getElementById('mod-bandwidth-download').innerHTML = xml.getElementsByTagName('livedownload')[0].childNodes[0].nodeValue;");
?>