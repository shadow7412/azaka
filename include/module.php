<?php
include_once "../include/db.php";

class Module {
	private $content;
	private $js;
	private $name;
	public $u;
	private $db;
	
	function __construct($name,$accessreq){
		$this->u = new UserObject();
		if($this->u->access < $accessreq) die(header($accessreq, true, 403)); //halt rendering, and say access denied
		$this->db = new Database();
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
		echo "<table width = 100%><tr><td><h5>".$this->name."</h5></td></tr><tr><td><div id=\"mod-".$this->name."\">".$this->content."</div></td></tr></table>";
	}
	function getContent(){
		return "<table width = 100%><tr><td><h5>".$this->name."</h5></td></tr><tr><td><div id=\"mod-".$this->name."\">".$this->content."</div></td></tr></table>";
	}
	function renderJs(){
		echo "<script id=\"modjs-".$this->name."\">".$this->js."</script>";
	}
	function getJs(){
		return "<script id=\"modjs-".$this->name."\">".$this->js."</script>";
	}
}

?>