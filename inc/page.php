<?php
// 0 - Guest, 1 - User, 2 - Admin, 3 - God
include_once "inc/userobject.php";

class Page {
	private $javascript;
	public $u;
	
	function __construct($title,$accessreq){
		$this->u = new UserObject();
		if($this->u->access < $accessreq) die(header($accessreq, true, 403)); //halt rendering, and say access denied
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