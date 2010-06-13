<?php
function renderTop($userinfo,$pagename){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="aesthetic/azaka.css" media="screen" />
<title><?php
	echo isset($pagename)?"$pagename - ":""
?>azaka</title>
</head>

<body><center><a href="index.php"><img src="aesthetic/title.gif" alt="azaka" /></a></center><br/>

<div id="right" align="right">Your IP is <?php echo $_SERVER['REMOTE_ADDR']; ?><br/><br/></div>

<div id="main">
<div id="toolbar" align=right>
<?php echo $userinfo->username; ?>
</div>
<div id="content">
<?php
}