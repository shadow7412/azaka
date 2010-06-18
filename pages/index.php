<?php


if (isset($_GET['page'])){
	include "../include/db.php";
	$db = new Database;
	$results = $db->qry("SELECT name, url FROM pages WHERE enabled = 1");
	switch ($_GET['page']){
		case ('error'):
			include "error.php";
			break;
		case ('bills'):
			include "bills.php";
		case ('news'):
			include "news.php";
			break;
		case ('admin_news'):
			include "admin_news.php";
			break;
		default:
			header("invalid page link", true, 404);
	}
} else {
	header("accessed page directly", true, 500);
}
?>