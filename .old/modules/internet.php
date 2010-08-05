<?php
include_once "../include/module.php";

$m = new Module("internet", 2);
$m->addContent("<strong id=\"mod-internet-plan\">time remaining</strong><div id=\"mod-internet-timebar\"></div><div id=\"mod-internet-time\"></div><br/>");
$m->addContent("<strong>onpeak remaining</strong><div id=\"mod-internet-onpeakbar\"></div><div id=\"mod-internet-onpeak\"></div><br/>");
$m->addContent("<strong>offpeak remaining</strong><div id=\"mod-internet-offpeakbar\"></div><div id=\"mod-internet-offpeak\"></div>");

$m->addJs("var modinternetxml = (new DOMParser()).parseFromString(grabXML(\"xml/internet.php\",\"mod-internet\"),\"text/xml\");");
$m->addJs("document.getElementById('mod-internet-plan').innerHTML = modinternetxml.getElementsByTagName('plan')[0].childNodes[0].nodeValue;");
$m->addJs("$(\"#mod-internet-timebar\").progressbar({value: parseInt(modinternetxml.getElementsByTagName('time')[0].childNodes[0].nodeValue)});");
$m->addJs("document.getElementById('mod-internet-time').innerHTML = \"days left:\" + modinternetxml.getElementsByTagName('daysleft')[0].childNodes[0].nodeValue;");
$m->addJs("$(\"#mod-internet-onpeakbar\").progressbar({value: parseInt(modinternetxml.getElementsByTagName('onpercentage')[0].childNodes[0].nodeValue)});");
$m->addJs("document.getElementById('mod-internet-onpeak').innerHTML = \"data used:\" + modinternetxml.getElementsByTagName('onpeakused')[0].childNodes[0].nodeValue + \"/\"+ modinternetxml.getElementsByTagName('onpeaktotal')[0].childNodes[0].nodeValue+\"<br/>gb/d remaining: \"+modinternetxml.getElementsByTagName('ongbday')[0].childNodes[0].nodeValue;");
$m->addJs("$(\"#mod-internet-offpeakbar\").progressbar({value: parseInt(modinternetxml.getElementsByTagName('offpercentage')[0].childNodes[0].nodeValue)});");
$m->addJs("document.getElementById('mod-internet-offpeak').innerHTML = \"data used:\" + modinternetxml.getElementsByTagName('offpeakused')[0].childNodes[0].nodeValue + \"/\"+ modinternetxml.getElementsByTagName('offpeaktotal')[0].childNodes[0].nodeValue + \"<br/>gb/d remaining: \"+modinternetxml.getElementsByTagName('offgbday')[0].childNodes[0].nodeValue;");
?>