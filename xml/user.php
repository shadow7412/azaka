<?php 
include_once "../include/userobject.php";
include_once "../include/linklist.php";

$l = new LinkList($u = new UserObject);

header("content-type: text/xml");

echo "<user>
	<id>{$u->id}</id>
	<username>{$u->username}</username>
	<access>{$u->access}</access>
	<firstname>{$u->firstname}</firstname>
	<lastname>{$u->lastname}</lastname>
	<dob>{$u->dob}</dob>
	<billable>{$u->billable}</billable>
	<email>{$u->email}</email>
	<connection>";
	echo $u->isLocal?"On LAN":"On Internet";
	echo "</connection>
	<skin>{$u->getSkin()}</skin>
</user>";
?>