<?php
include "../inc/page.php";
include_once "../inc/linklist.php";
include_once "../inc/userobject.php";

$p = new Page("news",0);
$l = new Linklist();
$userinfo = new UserObject();

$l->additem("add news item","admin_news.php", 2);
$l->additem("invalid link","test.php", 0);
echo $l->disp();

$result = $p->db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid");
while($row = mysql_fetch_array($result)){
	extract($row);
	echo "$poster at $time wrote:<br/><blockquote>$content</blockquote><br/>";
}
?>