<?php
include "/inc/uni.php";
$x = new universal("Home",0);
$db = new database();

		$result = $db->qry("SELECT * FROM users");
		print_r(mysql_fetch_array($result));
?>