<?php
include_once "../include/page.php";
include_once "../include/linklist.php";
$p = new Page("news",2);
$l = new Linklist();

$l->additem("news items","news", 0);
echo $l->dispList();

if(!isset($_GET['action'])){
	//if no action, do nothing. This is just so we do not need to check every time.
} elseif ($_GET['action']=='add')
	$p->db->qry("INSERT INTO news (uid, content) VALUES ('".$p->u->id."', '".addSlashes($_GET['content'])."')");
elseif ($_GET['action']=='modify')
	echo "501";//$p->db->qry("INSERT INTO news (uid, content) VALUES ('".$p->u->id."', '".addSlashes($_GET['content'])."')");
elseif ($_GET['action']=='delete')
	$p->db->qry("DELETE FROM news WHERE id = {$_GET['item']}");
//modify

//delete


//new
echo "<form name=\"addnews\" id=\"addnews\" onsubmit=\"sendPost('pages/admin_news.php?action=add&content='+this.newscontent.value);return false;\"> ".$p->u->username." at [now] wrote:<blockquote><textarea id=\"newscontent\" name=\"newscontent\" cols=\"45\" rows=\"5\"></textarea></blockquote><input type=submit /></form><br/>";

//show all articles
$result = $p->db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid ORDER BY time DESC");
while($row = mysql_fetch_array($result)){
	extract($row);
	echo "$poster at $time wrote:
	(<a href=\"javascript:if(confirm('Are you sure?'))sendPost('pages/admin_news.php?action=delete&item=$id');\">delete</a> or
	<a href=\"javascript:sendPost('pages/admin_news.php?action=modify&item=$id');\">edit</a>)<blockquote><pre>$content</pre></blockquote>";
}
?>