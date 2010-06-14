<?php
include_once "inc/page.php";
//include_once "inc/linklist.php";
include_once "inc/userobject.php";

class Page {
	private $javascript;
	public $u;
	
	function __construct($title,$accessreq){
		$this->u = new UserObject();
		$this->javascript = "<script id=\"pagejs\">";
		$this->setupTop($title);
	}
	function setupTop($title){
		$this->javascript .= "document.title = '$title - azaka';";
		$this->javascript .= "document.getElementById('toolbar').innerHTML = '".$this->u->username."';";
	}
	function addJs($js){
	$this->js.=$fs;
	}
	function __destruct(){
		$this->javascript .= "</script>";
		echo $this->javascript;
	}
}
?>