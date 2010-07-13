<?php
include_once "../include/page.php";
$p = new Page("news",0);

$p->l->additem("add news item","admin_news", 2);
echo $p->l->dispList();

$p->db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid ORDER BY time DESC");
while($row = $p->db->fetchLast()){
	extract($row);
	echo "$poster at $time wrote:<blockquote><pre>$content</pre></blockquote>";
}
?>