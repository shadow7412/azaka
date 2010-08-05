<?php
if (isset($_GET['page'])){
	include_once "../include/db.php";
	$db = new Database;
	$db->qry("SELECT name, url FROM pages WHERE enabled = 1");
	$foundEntry = false;
	while($row = $db->fetchLast())
		if($_GET['page'] == $row['name']){
			$foundEntry = true;
			if(file_exists($row['url']))
				include $row['url'];
			else 
				header("page in db does not exist", true, 501);
		}
	if(!$foundEntry) header("invalid page link", true, 404); //this will not run if page is already included
} else header("accessed page directly", true, 500);
?>