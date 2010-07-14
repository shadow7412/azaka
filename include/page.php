<?php
// 0 - Guest, 1 - User, 2 - Admin, 3 - God
include_once "../include/userobject.php";
include_once "../include/linklist.php";
include_once "../include/db.php";

class Page {
	private $javascript;
	public $u;
	public $l;
	public $db;
	
	function __construct($title,$accessreq){
		$this->u = new UserObject();
		if($this->u->access < $accessreq) die(header($accessreq, true, 403)); //halt rendering, and say access denied
		$this->l = new LinkList($this->u);
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
		$this->db->qry("SELECT name, url, access FROM pages WHERE visible = 1");
		while($row = $this->db->fetchLast())
			$this->l->additem($row['name'],$row['name'],$row['access']);
		$toolbarContent = addSlashes($this->l->dispBar());
		$this->addJs("document.getElementById('toolbar').innerHTML = '$toolbarContent';");
	}
	function setupSidebar(){
		$sidebar = "";
		$this->db->qry("SELECT url FROM modules WHERE enabled = 1 & onsidebar = 1");
		$sidebar .= "<ul style=\"list-style-type: none; margin: 0; padding: 0; width: 100%;\" id=\"modlist\">";
		while($row = $this->db->fetchLast()){
			include "../modules/".$row['url'];
			$sidebar .= "<li style=\"width:100%\"><div class=\"ui-state-default ui-corner-top\">{$m->name}</div>";
			$sidebar .= "<div class=\"ui-widget-content ui-corner-bottom\">".$m->getContent()."</div></li>";
		}
		$sidebar.="</ul>";
		$this->addJs("document.getElementById('sidebar').innerHTML = '$sidebar';");
	}
	function __destruct(){
		$this->javascript .= "</script>";
		echo $this->javascript;
	}
}
?>