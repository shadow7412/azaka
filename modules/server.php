<?php
include_once "../include/module.php";

$m = new Module("server", 2);
$m->addContent("Upload: <a id=\"mod-server-upload\">...</a><br/>Download:<a id=\"mod-server-download\">...</a><br/><br/>");
$m->addContent("<strong>time remaining</strong><div id=\"mod-server-timebar\"></div><div id=\"mod-server-time\"></div><br/>");
$m->addContent("<strong>onpeak remaining</strong><div id=\"mod-server-onpeakbar\"></div><div id=\"mod-server-onpeak\"></div><br/>");
$m->addContent("<strong>offpeak remaining</strong><div id=\"mod-server-offpeakbar\"></div><div id=\"mod-server-offpeak\"></div><br/>");
$m->addJs("var modserverxml = (new DOMParser()).parseFromString(grabXML(\"xml/server.php\",\"mod-server\"),\"text/xml\");");
$m->addJs("document.getElementById('mod-server-upload').innerHTML = modserverxml.getElementsByTagName('liveupload')[0].childNodes[0].nodeValue;");
$m->addJs("document.getElementById('mod-server-download').innerHTML = modserverxml.getElementsByTagName('livedownload')[0].childNodes[0].nodeValue;");
$m->addJs("$(\"#mod-server-timebar\").progressbar({value: parseInt(modserverxml.getElementsByTagName('time')[0].childNodes[0].nodeValue)});");
$m->addJs("document.getElementById('mod-server-time').innerHTML = \"days left:\" + modserverxml.getElementsByTagName('time')[0].childNodes[0].nodeValue;");
$m->addJs("$(\"#mod-server-onpeakbar\").progressbar({value: parseInt(modserverxml.getElementsByTagName('onpercentage')[0].childNodes[0].nodeValue)});");
$m->addJs("document.getElementById('mod-server-onpeak').innerHTML = \"data used:\" + modserverxml.getElementsByTagName('onpeakused')[0].childNodes[0].nodeValue + \"/\"+ modserverxml.getElementsByTagName('onpeaktotal')[0].childNodes[0].nodeValue;");
$m->addJs("$(\"#mod-server-offpeakbar\").progressbar({value: parseInt(modserverxml.getElementsByTagName('offpercentage')[0].childNodes[0].nodeValue)});");
$m->addJs("document.getElementById('mod-server-offpeak').innerHTML = \"data used:\" + modserverxml.getElementsByTagName('offpeakused')[0].childNodes[0].nodeValue + \"/\"+ modserverxml.getElementsByTagName('offpeaktotal')[0].childNodes[0].nodeValue;");
/*
data used: 12.11 / 26.00 gb 
data remaining: 13.89 gb 
gb/day remaining: 2.62 used: 0.49 
*/
?>