<?php
$netspacefile = '../../xml/netspace.xml';     // Netspace XML file
$updatefile = '../../xml/nslastupdate.dat'; // File with time file was last updated

include_once "../include/userobject.php";
$u = new UserObject;

header("content-type: text/xml");
echo "<?xml version=\"1.0\" ?>";
if(file_exists($netspacefile) & $u->canAccess(1)){
	$xml = simplexml_load_file($netspacefile); //Open (local) NetSpace XML
	$startdate = strtotime($xml["START_DATE"]); //startdate in seconds
	$enddate = strtotime($xml["END_DATE"]); //enddate in seconds
	if($xml->PLAN->LIMIT[0]["NAME"]=="Peak"){
		$ontotal = $xml->PLAN->LIMIT[0]["MEGABYTES"]/1000; //peak total
		$offtotal =$xml->PLAN->LIMIT[1]["MEGABYTES"]/1000; //offpeak total
	} else if($xml->PLAN->LIMIT[0]["NAME"]=="Off Peak"){
		$offtotal = $xml->PLAN->LIMIT[0]["MEGABYTES"]/1000; //offpeak total
		$ontotal =$xml->PLAN->LIMIT[1]["MEGABYTES"]/1000; //peak total
	}
	if($xml->TRAFFIC->DATA[0]["TYPE"] == "Peak"){
		$onused = $xml->TRAFFIC->DATA[0]["DOWNLOADS"]/1000; //peakused
		$offused = $xml->TRAFFIC->DATA[1]["DOWNLOADS"]/1000; //offpeak used
	} else if($xml->TRAFFIC->DATA[0]["TYPE"] == "Off Peak"){
		$offused = $xml->TRAFFIC->DATA[0]["DOWNLOADS"]/1000; //offpeak used
		$onused = $xml->TRAFFIC->DATA[1]["DOWNLOADS"]/1000; //peakused
	}
	$uploaded = round(($xml->TRAFFIC->DATA[0]["UPLOADS"]+$xml->TRAFFIC->DATA[1]["UPLOADS"])/1000,2); //uploads (both on and off peak)
	$timeleft = date('U',$enddate) - date('U');
	$totaltime = date('U',$enddate) - date('U', $startdate);
	$time = round($timeleft/$totaltime*100,2);
	$daysleft = round((date('U',$enddate) - date('U'))/60/60/24,2);
	$onpercentage = 100 - $onused/$ontotal*100;
	$offpercentage = 100 - $offused/$offtotal*100;
	$ongbday = round($onused / $daysleft,2);
	$offgbday = round($offused / $daysleft,2);;
} else {
	$xml->PLAN['DESCRIPTION'] = "File not set up.";
	$time = $daysleft = $onpercentage = $ontotal = $onused = $offpercentage = $offtotal = $offused = $uploaded = $ongbday = $offgbday = 0;
}
echo "<internet>
	<plan>{$xml->PLAN['DESCRIPTION']}</plan>
	<time>$time</time>
	<daysleft>$daysleft</daysleft>
	<onpercentage>$onpercentage</onpercentage>
	<onpeaktotal>$ontotal</onpeaktotal>
	<onpeakused>$onused</onpeakused>
	<ongbday>$ongbday</ongbday>
	<offpercentage>$offpercentage</offpercentage>
	<offpeaktotal>$offtotal</offpeaktotal>
	<offpeakused>$offused</offpeakused>
	<offgbday>$offgbday</offgbday>
	<uploaded>$uploaded</uploaded>";
if(file_exists($updatefile) & $u->canAccess(1)){
	$handle = fopen($updatefile, "r");
	$contents = fread($handle, filesize($updatefile));
	echo "<updated>$contents</updated>";
} else
	echo "<updated></updated>";
echo "</internet>";



?>