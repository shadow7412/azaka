<?php
include_once "../include/db.php";

class Module {
	private $content;
	private $js;
	private $accessreq;
	private $name;
	public $u;
	private $db;
	
	function __construct($name,$accessreq){
		$this->u = new UserObject();
		$this->db = new Database();
		$this->accessreq = $accessreq;
		$js = ";";
		$content = "";
		$this->name = $name;
	}
	function addContent($newContent){
		$this->content .= $newContent;
	}
	function addJs($newJs){
		$this->js .= $newJs;
	}
	function renderContent(){
		echo $this->getContent();
	}
	function getContent(){
		if($this->checkAccess())
			return "<table width = 100%><tr><td><h5>".$this->name."</h5></td></tr><tr><td><div id=\"mod-".$this->name."\">".$this->content."</div></td></tr></table>";
		else
			return "<div id=\"mod-".$this->name."\"></div>";
	}
	function renderJs(){
		echo $this->getJs();
	}
	function getJs(){
		if($this->checkAccess())
			return "<script id=\"modjs-".$this->name."\">".$this->js."</script>";
		else
			return "<script id=\"modjs-".$this->name."\"></script>";
	}
	function checkAccess(){
		return ($this->u->access >= $this->accessreq);
	}
}
?>