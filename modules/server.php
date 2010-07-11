<?php
include_once "../include/module.php";

$m = new Module("server", 2);
$m->addContent("Upload: <a id=\"mod-server-upload\">...</a><br/>Download:<a id=\"mod-server-download\">...</a>");
$m->addJs("var modserverxml = (new DOMParser()).parseFromString(grabXML(\"xml/server.php\",\"mod-server\"),\"text/xml\");");
$m->addJs("document.getElementById('mod-server-upload').innerHTML = modserverxml.getElementsByTagName('upload')[0].childNodes[0].nodeValue;");
$m->addJs("document.getElementById('mod-server-download').innerHTML = modserverxml.getElementsByTagName('download')[0].childNodes[0].nodeValue;");
?>