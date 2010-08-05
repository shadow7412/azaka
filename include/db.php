<?php

class Database{
	private $lastQry;
	
	function __construct(){
	//echo $_SERVER['SCRIPT_NAME']."<br/>";
		include "../config/dbconfig.php";
		mysql_connect($db['host'], $db['user'], $db['pass']) or $this->error("The connection to MySQL couldn't be made. Make sure MySQL is on, and the username is correct.");
		mysql_select_db($db['db']) or $this->error("The database \"".$db['db']."\" couldn't be found. Have you run the installer by any chance..?");
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
	function noLast(){
		return $this->no($this->lastQry);
	}
	function getSetting($option){
		$result = mysql_query("SELECT setting FROM settings WHERE `option` = '$option'") or $this->error("Error getting setting for $option.");
		$setting = mysql_fetch_array($result);
		return $setting['setting'];
	}
	function error($msg){
	die("<div id=error>$msg<a href=\"config/initsetup.php\" onclick=\"return confirm('This will delete all existing data in the database if it exists. Continue?');\">Maybe remake database?</a></div>");
	}
}
?>
