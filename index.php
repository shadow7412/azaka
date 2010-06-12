<?php
global $userinfo;
include "/inc/uni.php";
$x = new universal("Home",0);
$db = new database();
$l = new linklist();

$l->additem("add news item","admin_addnews.php", 1);
$l->disp();

$result = $db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid");
while($row = mysql_fetch_array($result)){
	extract($row);
	echo "$poster at $time wrote:<br/><blockquote>$content</blockquote><br/>";
}
?>