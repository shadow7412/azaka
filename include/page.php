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
		$this->javascript .= "\n\n".$js;
	}
	function setupTop($title){
		$this->addJs("document.title = '$title - azaka';");
		$result = $this->db->qry("SELECT name, url, access FROM pages WHERE visible = 1");
		while($row = mysql_fetch_array($result))
			$this->ll->additem($row['name'],$row['name'],$row['access']);
		$toolbarContent = $this->ll->dispBar();
		$this->addJs("document.getElementById('toolbar').innerHTML = '$toolbarContent';");
	}
	function setupSidebar(){
		$sidebar = "";
		$result = $this->db->qry("SELECT url FROM modules WHERE enabled = 1 & onsidebar = 1");
		while($row = mysql_fetch_array($result)){
			include "../modules/".$row['url'];
			$sidebar = $m->getContent();
		}
		$this->addJs("document.getElementById('sidebar').innerHTML = '$sidebar';");
	}
	function __destruct(){
		$this->javascript .= "</script>";
		echo $this->javascript;
	}
}
?>