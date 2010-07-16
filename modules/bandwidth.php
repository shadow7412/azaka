<?php
include_once "../include/module.php";

$m = new Module("bandwidth", 2);
$m->addContent("<table><tr><td width=10><span class=\"ui-icon ui-icon-carat-1-n\"></span></td><td width=60><span id=\"mod-bandwidth-upload\">...</span></td><td width=10><span class=\"ui-icon ui-icon-carat-1-s\"></span></td><td width=60><a id=\"mod-bandwidth-download\">...</a></td></tr></table>");

$m->addJs("var modbandwidthxml = (new DOMParser()).parseFromString(grabXML(\"xml/bandwidth.php\",\"mod-bandwidth\"),\"text/xml\");");
$m->addJs("document.getElementById('mod-bandwidth-upload').innerHTML = modbandwidthxml.getElementsByTagName('liveupload')[0].childNodes[0].nodeValue;");
$m->addJs("document.getElementById('mod-bandwidth-download').innerHTML = modbandwidthxml.getElementsByTagName('livedownload')[0].childNodes[0].nodeValue;");
?>