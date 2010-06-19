<?php
include "../include/page.php";
include_once "../include/linklist.php";
include_once "../include/userobject.php";

$p = new Page("news",0);
$l = new Linklist();
$userinfo = new UserObject();

$l->additem("add news item","admin_news", 2);
echo $l->disp();

$result = $p->db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid");
while($row = mysql_fetch_array($result)){
	extract($row);
	echo "$poster at $time wrote:<blockquote>$content</blockquote>";
}
?>