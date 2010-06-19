<?php
class Module {
	private $content;
	private $js;
	private $name;
	
	function __construct($name,$accessreq){
		$this->u = new UserObject();
		if($this->u->access < $accessreq) die(header($accessreq, true, 403)); //halt rendering, and say access denied
		$js = "";
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
		echo "<table border = 1 width = 100%><tr><td>".$this->name."</td></tr><tr><td><div id=\"mod-".$this->name."\">".$this->content."</div></td></tr></table>";
	}
	function getContent(){
		return "<table border = 1 width = 100%><tr><td>".$this->name."</td></tr><tr><td><div id=\"mod-".$this->name."\">".$this->content."</div></td></tr></table>";
	}
	function renderJs(){
		echo "<script id=\"modjs-".$this->name."\">".$this->js."</script>";
	}
	function getJs(){
		return "<script id=\"modjs-".$this->name."\">".$this->js."</script>";
	}
}

?>