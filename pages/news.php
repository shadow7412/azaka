<?php
include_once "../include/page.php";
$p = new Page("news",0);

$p->addJs("$(\"#accordion\").accordion({autoHeight: false, navigation: true})");
$p->l->additem("add news item","admin_news", 2);
echo $p->l->dispList();

$p->db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid ORDER BY time DESC");
echo "<div id=\"accordion\">";
while($row = $p->db->fetchLast()){
	extract($row);
	echo "<h3><a href=\"#\">$title by $poster @ $time</a></h3><div>$content</div>";
}
echo "</div>";
?>