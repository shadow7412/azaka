<?php
// 0 - Guest, 1 - User, 2 - Admin, 3 - God
include_once "../include/userobject.php";
include_once "../include/linklist.php";
include_once "../include/db.php";

class Page {
	private $javascript;
	public $u;
	private $ll;
	public $db;
	
	function __construct($title,$accessreq){
		$this->u = new UserObject();
		if($this->u->access < $accessreq) die(header($accessreq, true, 403)); //halt rendering, and say access denied
		$this->ll = new LinkList();
		$this->db = new Database();
		$this->javascript = "<script id=\"pagejs\">";
		$this->setupTop($title);
		$this->setupSidebar();
	}
	function addJs($js){
	$this->javascript .= $js;
	}
	function setupTop($title){
		$this->addJs("document.title = '$title - azaka';");
		$result = $this->db->qry("SELECT name, url, access FROM pages WHERE enabled = 1");
		while($row = mysql_fetch_array($result))
			$this->ll->additem($row['name'],$row['url'],$row['access']);
		$toolbarContent = $this->ll->dispBar()."<div id=\"rtoolbar\">".$this->u->username."</div>";
		$this->addJs("document.getElementById('toolbar').innerHTML = '$toolbarContent';");
	}
	function setupSidebar(){
		$this->addJs("document.getElementById('sidebar').innerHTML = 'sidebar updated'");
	}
	function __destruct(){
		$this->javascript .= "</script>";
		echo $this->javascript;
	}
}
?>