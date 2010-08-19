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
		if(!$this->u->canAccess($accessreq)) die(header($accessreq, true, 403)); //halt rendering, and say access denied
		$this->l = new LinkList($this->u);
		$this->db = $this->u->db;
		$this->javascript = "<script id=\"pagejs\">";
		$this->setupTop($title);
	}
	function addJs($js){
		$this->javascript .= "\n\n".$js;
	}
	function infoBox($info){
	echo "<div class=\"ui-widget\" onclick=\"this.outerHTML='';\"><div class=\"ui-state-highlight ui-corner-all\" style=\"margin-top: 20px; padding: 0 .7em;\"><p><table><tr><td><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span></td><td>$info</td></tr></table></p></div></div><br/>";
	}
	function setupTop($title){
		$this->addJs("document.title = '$title - azaka';");
		$this->db->qry("SELECT name, url, access FROM pages WHERE visible = 1");
		while($row = $this->db->fetchLast())
			$this->l->additem($row['name'],$row['name'],$row['access']);
		$this->addJs("document.getElementById('toolbar').innerHTML = '".addSlashes($this->l->dispBar())."';");
	}
	function __destruct(){
		$this->javascript .= "</script>";
		echo $this->javascript;
	}
}
?>