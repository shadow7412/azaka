<?php
include_once "../include/module.php";

$m = new Module("internet", 2);
$m->addContent("<strong id=\"mod-internet-plan\">time remaining</strong><div id=\"mod-internet-timebar\"></div><div id=\"mod-internet-time\"></div><br/>");
$m->addContent("<strong>onpeak remaining</strong><div id=\"mod-internet-onpeakbar\"></div><div id=\"mod-internet-onpeak\"></div><br/>");
$m->addContent("<strong>offpeak remaining</strong><div id=\"mod-internet-offpeakbar\"></div><div id=\"mod-internet-offpeak\"></div><div id=\"mod-internet-upload\"></div>");

$m->addJs("document.getElementById('mod-internet-plan').innerHTML = xml.getElementsByTagName('plan')[0].childNodes[0].nodeValue;");
$m->addJs("$(\"#mod-internet-timebar\").progressbar({value: parseInt(xml.getElementsByTagName('time')[0].childNodes[0].nodeValue)});");
$m->addJs("document.getElementById('mod-internet-time').innerHTML = \"days left:\" + xml.getElementsByTagName('daysleft')[0].childNodes[0].nodeValue;");
$m->addJs("$(\"#mod-internet-onpeakbar\").progressbar({value: parseInt(xml.getElementsByTagName('onpercentage')[0].childNodes[0].nodeValue)});");
$m->addJs("document.getElementById('mod-internet-onpeak').innerHTML = \"data used:\" + xml.getElementsByTagName('onpeakused')[0].childNodes[0].nodeValue + \"/\"+ xml.getElementsByTagName('onpeaktotal')[0].childNodes[0].nodeValue+\"<br/>gb/d remaining: \"+xml.getElementsByTagName('ongbday')[0].childNodes[0].nodeValue;");
$m->addJs("$(\"#mod-internet-offpeakbar\").progressbar({value: parseInt(xml.getElementsByTagName('offpercentage')[0].childNodes[0].nodeValue)});");
$m->addJs("document.getElementById('mod-internet-offpeak').innerHTML = \"data used:\" + xml.getElementsByTagName('offpeakused')[0].childNodes[0].nodeValue + \"/\"+ xml.getElementsByTagName('offpeaktotal')[0].childNodes[0].nodeValue + \"<br/>gb/d remaining: \"+xml.getElementsByTagName('offgbday')[0].childNodes[0].nodeValue;");
$m->addJs("document.getElementById('mod-internet-upload').innerHTML = \"<br/>data uploaded:\" + xml.getElementsByTagName('uploaded')[0].childNodes[0].nodeValue+'gb';");
?>