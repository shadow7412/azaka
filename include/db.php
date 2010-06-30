<?php

class Database{
	public $lastQry;
	
	function __construct(){
		include "../config/dbconfig.php";
		mysql_connect($db['host'], $db['user'], $db['pass']) or error("The connection to MySQL couldn't be made. Make sure MySQL is on, and the username is correct.");
		mysql_select_db($db['db']) or error("The database \"".$db['db']."\" couldn't be found. Have you run the installer by any chance..?");
	}
	function qry($query){
		$this->lastQry = mysql_query($query) or $this->error(mysql_error());
		return $this->lastQry;
	}
	function fetch($query){
		return mysql_fetch_array($query);
	}
	function fetchLast(){
		return $this->fetch($this->lastQry);
	}
	function no($results){ //TO FIX (PROBABLY)
		return mysql_num_rows($results);
	}
	function noLast(){ //TO FIX (PROBABLY)
		return $this->no($this->lastQry);
	}
function error($msg){
	echo "<div id=error>$msg  <a href=\"config/initsetup.php\" onclick=\"return confirm('This will delete all existing data in the database if it exists. Continue?');\">Maybe remake database?</a></div>";
	die();
}
}
?>
