<?php
include_once "../include/bandwidth.php";
$stats = new Bandwidth;
header ("content-type: text/xml");

$xml = simplexml_load_file('../../xml/netspace.xml'); //Open (local) NetSpace XML
$startdate = strtotime($xml["START_DATE"]); //startdate in seconds
$enddate = strtotime($xml["END_DATE"]); //enddate in seconds
$ontotal = round($xml->PLAN->LIMIT[0]["MEGABYTES"]/1000,1); //peak total
$offtotal = round($xml->PLAN->LIMIT[1]["MEGABYTES"]/1000,1); //offpeak total
$offused = round($xml->TRAFFIC->DATA[0]["DOWNLOADS"]/1000,1); //offpeak used
$onused = round($xml->TRAFFIC->DATA[1]["DOWNLOADS"]/1000,1); //peakused
$uploaded = ($xml->TRAFFIC->DATA[0]["UPLOADS"]+$xml->TRAFFIC->DATA[1]["UPLOADS"])/1000; //uploads (both on and off peak)
$timeleft = date('U',$enddate) - date('U');
$totaltime = date('U',$enddate) - date('U', $startdate);
$time = round($timeleft/$totaltime*100,2);
$daysleft = round((date('U',$enddate) - date('U'))/60/60/24,2);
$onpercentage = 100 - $onused/$ontotal*100;
$offpercentage = 100 - $offused/$offtotal*100;
echo "<bandwidth>
	<plan>{$xml->PLAN['DESCRIPTION']}</plan>
	<time>$time</time>
	<daysleft>$daysleft</daysleft>
	<onpercentage>$onpercentage</onpercentage>
	<onpeaktotal>$ontotal</onpeaktotal>
	<onpeakused>$onused</onpeakused>
	<offpercentage>$offpercentage</offpercentage>
	<offpeaktotal>$offtotal</offpeaktotal>
	<offpeakused>$offused</offpeakused>
	<uploaded>$uploaded</uploaded>
	<liveupload>{$stats->upload}</liveupload>
	<livedownload>{$stats->download}</livedownload>
</bandwidth>";



?>