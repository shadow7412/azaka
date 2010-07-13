<?php
include_once "../include/module.php";

$m = new Module("server", 2);
$m->addContent("<table><tr><td width=10><span class=\"ui-icon ui-icon-carat-1-n\"></span></td><td width=60><span id=\"mod-server-upload\">...</span></td><td width=10><span class=\"ui-icon ui-icon-carat-1-s\"></span></td><td width=60><a id=\"mod-server-download\">...</a></td></tr></table>");
$m->addContent("<strong id=\"mod-server-plan\">time remaining</strong><div id=\"mod-server-timebar\"></div><div id=\"mod-server-time\"></div><br/>");
$m->addContent("<strong>onpeak remaining</strong><div id=\"mod-server-onpeakbar\"></div><div id=\"mod-server-onpeak\"></div><br/>");
$m->addContent("<strong>offpeak remaining</strong><div id=\"mod-server-offpeakbar\"></div><div id=\"mod-server-offpeak\"></div><br/>");
$m->addJs("var modserverxml = (new DOMParser()).parseFromString(grabXML(\"xml/server.php\",\"mod-server\"),\"text/xml\");");
$m->addJs("document.getElementById('mod-server-plan').innerHTML = modserverxml.getElementsByTagName('plan')[0].childNodes[0].nodeValue;");
$m->addJs("document.getElementById('mod-server-upload').innerHTML = modserverxml.getElementsByTagName('liveupload')[0].childNodes[0].nodeValue;");
$m->addJs("document.getElementById('mod-server-download').innerHTML = modserverxml.getElementsByTagName('livedownload')[0].childNodes[0].nodeValue;");
$m->addJs("$(\"#mod-server-timebar\").progressbar({value: parseInt(modserverxml.getElementsByTagName('time')[0].childNodes[0].nodeValue)});");
$m->addJs("document.getElementById('mod-server-time').innerHTML = \"days left:\" + modserverxml.getElementsByTagName('time')[0].childNodes[0].nodeValue;");
$m->addJs("$(\"#mod-server-onpeakbar\").progressbar({value: parseInt(modserverxml.getElementsByTagName('onpercentage')[0].childNodes[0].nodeValue)});");
$m->addJs("document.getElementById('mod-server-onpeak').innerHTML = \"data used:\" + modserverxml.getElementsByTagName('onpeakused')[0].childNodes[0].nodeValue + \"/\"+ modserverxml.getElementsByTagName('onpeaktotal')[0].childNodes[0].nodeValue+\"<br/>gb/d remaining: \"+modserverxml.getElementsByTagName('ongbday')[0].childNodes[0].nodeValue;");
$m->addJs("$(\"#mod-server-offpeakbar\").progressbar({value: parseInt(modserverxml.getElementsByTagName('offpercentage')[0].childNodes[0].nodeValue)});");
$m->addJs("document.getElementById('mod-server-offpeak').innerHTML = \"data used:\" + modserverxml.getElementsByTagName('offpeakused')[0].childNodes[0].nodeValue + \"/\"+ modserverxml.getElementsByTagName('offpeaktotal')[0].childNodes[0].nodeValue + \"<br/>gb/d remaining: \"+modserverxml.getElementsByTagName('offgbday')[0].childNodes[0].nodeValue;");
?>