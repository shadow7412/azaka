<?php include_once "inc/userobject.php"; $u = new UserObject(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>azaka</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="aesthetics/pc.css" media="screen" />
<script language="javascript1.3" src="inc/jquery.js" />
<script language="javascript1.3" src="inc/ajax.js" />
</head>

<body onload="javascript:jah('news.php','content');">
<div id="top">
<a href="index.php"><img src="aesthetics/title.gif" alt="azaka" /></a>
<noscript>This page relies on javascript. You should enable it.</noscript>
</div>

<div id="loader"><img src="aesthetics/notloading.gif" /></div>

<div id="toolbar" align="right"><?php echo $u->username ?></div>


<div id="content" ></div>

<div id="bottom">
<a href="http://validator.w3.org/check?uri=referer" title="Click here to check xhtml compliency of this page">azaka</a><a href="http://jigsaw.w3.org/css-validator/check/referer" title="click here to check the css on this page">(c)</a> is copyright - Steven Huf 2010
</div></body></html>