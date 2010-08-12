<?php
include_once "../include/bandwidth.php";
include_once "../include/userobject.php";
$stats = new Bandwidth;
$u = new UserObject;

header("content-type: text/xml");
echo "<?xml version=\"1.0\" ?>";
if($u->canAccess(1)){
	echo "<bandwidth>
	<liveupload>{$stats->upload}</liveupload>
	<livedownload>{$stats->download}</livedownload>
</bandwidth>";
} else {
	echo "<bandwidth>
	<liveupload>0</liveupload>
	<livedownload>0</livedownload>
</bandwidth>";
}



?>