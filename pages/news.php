<?php
include_once "../include/page.php";
include_once "../include/linklist.php";

$p = new Page("news",0);
$l = new Linklist();

$l->additem("add news item","admin_news", 2);
echo $l->dispList();

$result = $p->db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid");
while($row = mysql_fetch_array($result)){
	extract($row);
	echo "$poster at $time wrote:<blockquote>$content</blockquote>";
}
?>