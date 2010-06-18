<?php
if (isset($_GET['page'])){
	switch ($_GET['page']){
		case ('news'):
			include "news.php";
			break;
		case ('error'):
			include "error.php";
			break;
		default:
			header("invalid page link", true, 404);
	}
} else {
	header("accessed page directly", true, 500);
}
?>