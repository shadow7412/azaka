<?php
include_once "../include/page.php";
include_once "../include/linklist.php";
$p = new Page("news",2);
$l = new Linklist();

$l->additem("news items","news", 0);
echo $l->dispList();

if(isset($_GET['action'])){
	$p->db->qry("INSERT INTO news (uid, content) VALUES ('".$p->u->id."', '".addSlashes($_GET['content'])."')");
}
//add

//modify

//delete

//new
echo "<form name=\"addnews\" id=\"addnews\" onsubmit=\"sendPost('pages/admin_news.php?action=add&content='+this.newscontent.value);return false;\"> ".$p->u->username." at [now] wrote:<blockquote><textarea id=\"newscontent\" name=\"newscontent\" cols=\"45\" rows=\"5\"></textarea></blockquote><input type=submit /></form><br/>";

//show all articles
$result = $p->db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid ORDER BY time DESC");
while($row = mysql_fetch_array($result)){
	extract($row);
	echo "$poster at $time wrote:<blockquote>$content</blockquote>";
}
?>