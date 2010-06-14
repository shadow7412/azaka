<?php
include "inc/page.php";
include_once "inc/db.php";
include_once "inc/linklist.php";
include_once "inc/userobject.php";

$p = new Page("news",0);
$db = new Database();
$l = new Linklist();
$userinfo = new UserObject();

$l->additem("add news item","admin_news.php", 0);
$l->additem("invalid link","test.php", 0);
$l->disp();

$result = $db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid");
while($row = mysql_fetch_array($result)){
	extract($row);
	echo "$poster at $time wrote:<br/><blockquote>$content</blockquote><br/>";
}
?>