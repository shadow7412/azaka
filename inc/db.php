<?php
function error($msg){
	echo "<div id=error>$msg  <a href=\"config/initsetup.php\" onclick=\"return confirm('This will delete all existing data in the database if it exists. Continue?');\">Maybe remake database?</a></div>";
	die;
}

class Database{
	function __construct(){
		include "/config/dbconfig.php";

		mysql_connect($db['host'], $db['user'], $db['pass']) or error("The connection to MySQL couldn't be made. Make sure MySQL is on, and the username is correct.");
		mysql_select_db($db['db']) or error("The database \"".$db['db']."\" couldn't be found. Have you run the installer by any chance..?");
	}
	
	function qry($query){
		$result	= mysql_query($query) or error(mysql_error());
		return $result;
	}
}
?>
