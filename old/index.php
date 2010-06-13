<?php
include "inc/uni.php";
$p = new Page("home",0);
$db = new Database();
$l = new Linklist();

$l->additem("add news item","admin_addnews.php", 0);
$l->disp();
$result = $db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid");
while($row = mysql_fetch_array($result)){
	extract($row);
	echo "$poster at $time wrote:<br/><blockquote>$content</blockquote><br/>";
}
?>