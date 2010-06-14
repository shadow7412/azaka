<?php
include_once("inc/userobject.php");
class linklist {
	var $links;
	var $counter;
	var $u;
	function __construct(){
		$this->links = array();
		$this->counter = 0;
		$this->u = new UserObject();
	}
	
	function additem($label,$link, $reqaccess){
	if ($this->u->access >= $reqaccess){
		$this->links[$this->counter]["label"] = $label;
		$this->links[$this->counter++]["link"] = $link;
		}
	}
	function addbreak(){
		$this->counter++;
	}
	function disp(){
	if($this->counter!=0){
		echo "<div id=\"linklist\"><ul>";
		for($i=0; $i != $this->counter; $i++)
			if(isset($this->links[$i]['label']) && $this->links[$i]['label'] != "")
				echo "<li><a href=\"javascript:updateContent('".$this->links[$i]["link"]."');\">".$this->links[$i]["label"]."</a></li>";
			else
				echo "<br/>";
		}
	echo "</ul></div>";
	$this->counter=0;
	}
}
?>