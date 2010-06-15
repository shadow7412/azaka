<?php
// 0 - Guest, 1 - User, 2 - Admin, 3 - God
include_once "inc/userobject.php";
include_once "inc/linklist.php";

class Page {
	private $javascript;
	public $u;
	public $ll;
	
	function __construct($title,$accessreq){
		$this->u = new UserObject();
		if($this->u->access < $accessreq) die(header($accessreq, true, 403)); //halt rendering, and say access denied
		$this->ll = new LinkList();
		$this->javascript = "<script id=\"pagejs\">";
		$this->setupTop($title);
	}
	function setupTop($title){
		$this->ll->additem("news","news.php",0);
		$toolbarContent = $this->ll->dispBar().$this->u->username;
		$this->addJs("document.title = '$title - azaka';");
		$this->addJs("document.getElementById('toolbar').innerHTML = '$toolbarContent';");
	}
	function addJs($js){
	$this->javascript.=$js;
	}
	function __destruct(){
		$this->javascript .= "</script>";
		echo $this->javascript;
	}
}
?>