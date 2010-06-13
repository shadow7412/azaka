<?php
include "inc/db.php";
include "inc/linklist.php";
include_once "inc/userobject.php";
$db = new Database();
$l = new Linklist();
$userinfo = new UserObject();

$l->additem("return to main news page","news.php", 0);
$l->disp();

$result = $db->qry("SELECT n.*, u.username AS poster FROM news AS n, users AS u WHERE u.id = n.uid");
while($row = mysql_fetch_array($result)){
	extract($row);
	echo "$poster at $time wrote:<br/><blockquote>$content</blockquote><br/>";
}
?>