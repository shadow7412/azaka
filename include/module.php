<?php
include_once "../include/db.php";
include_once "../include/userobject.php";

class Module {
	public $u;
	public $name;
	public $accessreq;
	public $db;
	private $content;
	private $js;
	private $refresh;
	
	function __construct($name, $accessreq){
		$this->u = new UserObject();
		$this->db = new Database();
		$this->accessreq = $accessreq;
		$this->refresh = 200;
		$js = ";";
		$content = "";
		$this->name = $name;
	}
	function getContent(){
		if($this->u->canAccess($this->accessreq))
			return "<div id=\"mod-".$this->name."\">".$this->content."</div>";
		else
			return "<div id=\"mod-".$this->name."\"></div>";
	}
	function getJs(){
		if($this->u->canAccess($this->accessreq))
			return "<script id=\"modjs-".$this->name."\">".$this->js.";setTimeout(\"runJs('modjs-".$this->name."')\",".$this->refresh.")</script>";
		else
			return "<script id=\"modjs-".$this->name."\"></script>";
	}
	function addContent($newContent){
		$this->content .= $newContent;
	}
	function addJs($newJs){
		$this->js .= $newJs;
	}
	function setRefresh($newrefresh){
		$this->refresh = $newrefresh;
	}
}
?>
