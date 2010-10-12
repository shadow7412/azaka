<?php
include_once "../include/page.php";
include_once "../include/linklist.php";
$p = new Page("news",2);
$l = new LinkList($p->u);
dev();
$l->additem("news items","news", 0);
echo $l->dispList();
$p->addJs("$(\"#accordion\").accordion({autoHeight: false, navigation: true})");

if(!isset($_GET['action'])){
	//if no action, do nothing. This is just so we do not need to check every time.
} elseif ($_GET['action']=='addnews')
	if((!isset($_GET['item'])) || $_GET['item']=="")
		$p->db->qry("INSERT INTO news (title, uid, content) VALUES ('{$_GET['title']}','{$p->u->id}', '".addSlashes($_GET['newscontent'])."')");
	else
		$p->db->qry("UPDATE news SET uid = '{$p->u->id}',time = CURRENT_TIMESTAMP, title = '{$_GET['title']}',content = '".addSlashes($_GET['newscontent'])."' WHERE id='".$_GET['item']."'");
  elseif ($_GET['action']=='modify'){
    extract($_GET);
	$p->db->qry("SELECT title, content FROM news WHERE id='$item' LIMIT 1");
	$row = $p->db->fetchLast();
	$p->addJs("document.addnews.newscontent.value='".addSlashes($row['content'])."';");
	$p->addJs("document.addnews.title.value='{$row['title']}';");
	$p->addJs("document.addnews.item.value='$item';");
} elseif ($_GET['action']=='delete')
	$p->db->qry("DELETE FROM news WHERE id = {$_GET['item']}");
	
//new
echo "<div id=\"accordion\"><h3><a>Edit Entry</a></h3><div>";
echo "<form name=\"addnews\" id=\"addnews\" onsubmit=\"sendForm(this,'admin_news');false;\">
<input type=\"text\" name=\"title\" /> by {$p->u->username} @ [now] wrote:<br/><textarea id=\"newscontent\" name=\"newscontent\" cols=\"45\" rows=\"5\"></textarea><br/><input type=\"submit\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" /><input type=\"hidden\" name=\"item\" id=\"item\" value=\"\" /></form></div>";

//show all articles
$p->db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid ORDER BY time DESC");
while($row = $p->db->fetchLast()){
	extract($row);
	echo "<h3><a>$title by $poster @ $time</a></h3><div>(<a href=\"javascript:if(confirm('Are you sure?'))grabContent('admin_news','action=delete&item=$id');\">delete</a> or
	<a href=\"javascript:grabContent('admin_news','action=modify&item=$id');\">edit</a>)<br/><br/>$content</div>";
}
echo "</div>";
?>