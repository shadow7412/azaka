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
		$this->db = new Database();
		$this->javascript = "<script id=\"pagejs\">";
		$this->setupTop($title);
		$this->setupSidebar();
	}
	function addJs($js){
		$this->javascript .= "\n\n".$js;
	}
	function infoBox($info){
	echo "<div class=\"ui-widget\"><div class=\"ui-state-highlight ui-corner-all\" style=\"margin-top: 20px; padding: 0 .7em;\"><p><table><tr><td><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span></td><td>$info</td></tr></table></p></div></div><br/>";

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
		$this->db->qry("SELECT name, url FROM modules WHERE enabled = 1 AND onsidebar = 1 ORDER BY `order`");
		$sidebar = "<ul style=\"list-style-type: none; margin: 0; padding: 0; width: 100%;\" id=\"sidelist\">";
		$sidebarjs = "";
		while($row = $this->db->fetchLast()){
			if(file_exists("../modules/".$row['url'])){
				include "../modules/".$row['url'];
				if($this->u->canAccess($m->accessreq)){
					$sidebar .= "<li style=\"width:100%\"><div class=\"ui-state-default ui-corner-top\">{$m->name}</div>";
					$sidebar .= "<div class=\"ui-widget-content ui-corner-bottom\">".$m->getContent()."</div><br/></li>";
					$sidebarjs .= $m->getRawJs();
				}
			} else {
				$sidebar .= "<li style=\"width:100%\"><div class=\"ui-widget-content ui-corner-all\">Fatal error loading {$row['name']}. Check to see if the module has been copied over, and that the database points to the correct file.</div><br/></li>";
			}
		}
		$sidebar.="</ul>";
		$this->addJs("document.getElementById('sidebar').innerHTML = '$sidebar';");
		$this->addJs($sidebarjs);
		$this->addJs("$(\"#sidelist\").sortable();$(\"#sidelist\").disableSelection();");		
	}
	function __destruct(){
		$this->javascript .= "</script>";
		echo $this->javascript;
	}
}
?>