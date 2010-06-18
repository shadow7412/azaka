<?php
include_once "../inc/page.php";
include_once "../inc/db.php";
include_once "../inc/linklist.php";
include_once "../inc/userobject.php";
$p = new Page('news - admin', 2);
$db = new Database();
$l = new Linklist();
$userinfo = new UserObject();

$l->additem("return to main news page","news.php", 0);
$l->disp();

echo "<form><textarea name=\"textarea\" id=\"textarea\" cols=\"45\" rows=\"5\" ></textarea><input type=\"submit\" /></form>";

$result = $db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid");
while($row = mysql_fetch_array($result)){
	extract($row);
	echo "$poster at $time wrote:<br/><blockquote>$content</blockquote><br/>";
}
?>