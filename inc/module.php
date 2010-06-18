<?php
include_once "../inc/userobject.php";
include_once "../inc/db.php";
class Module {
	public $u;
	public $db;
	
	__constructor($name, $accessreq){
		
	}
	__destruct(){
	}
	render(){
		return "$name - module";
	}
}
?>