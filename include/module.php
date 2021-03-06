<?php
include_once "../include/userobject.php";

class Module {
	public $u;
	public $name;
	public $accessreq;
	private $content;
	private $js;
	private $refresh;
	
	function __construct($name, $accessreq){
		$this->u = new UserObject();
		$this->db = new Database();
		$this->accessreq = $accessreq;
		$this->refresh = 2000;
		$js = ";";
		$content = "";
		$this->name = $name;
	}
	function getContent(){
		if($this->u->canAccess($this->accessreq))
			return "<div id=\"mod-".$this->name."\">".$this->content."</div>";
		else
			return "<div id=\"mod-".$this->name."\">Access Issue</div>";
	}
	/*function getRawContent(){
		if($this->u->canAccess($this->accessreq))
			return $this->content;
		else
			return "Access Issue. Please log in.";
	}*/
	function getJs(){
		if($this->u->canAccess($this->accessreq)){
			$returnstring = "<script id=\"modjs-".$this->name."\">".$this->js.";";
			if($this->refresh != 0) $returnstring .= "_moduleHandles['".$this->name."'] = setTimeout(\"loadXML('{$this->name}')\",".$this->refresh.");";
			return $returnstring."</script>";
		} else
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
