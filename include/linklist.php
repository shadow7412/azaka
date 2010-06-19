<?php
include_once("../include/userobject.php");
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
	$output = '';
	if($this->counter!=0){
		$output .= "<div id=\"linklist\"><ul>";
		for($i=0; $i != $this->counter; $i++)
			if(isset($this->links[$i]['label']) && $this->links[$i]['label'] != "")
				$output .= "<li><a href=\"javascript:grabContent('pages/".$this->links[$i]["link"]."');\">".$this->links[$i]["label"]."</a></li>";
			else
				$output .= "<br/>";
		}
	$output .= "</ul></div>";
	$this->counter=0;
	return $output;
	}
	function dispBar(){
	if($this->counter!=0){
		$output = "<ul>";
		for($i=0; $i != $this->counter; $i++)
			if(isset($this->links[$i]['label']) && $this->links[$i]['label'] != "")
				$output .= "<li><a href=\"javascript:grabContent(\'".$this->links[$i]["link"]."\');\">".$this->links[$i]["label"]."</a></li>";
	}
	$output .= "</ul>";
	$this->counter=0;
	return $output;
	}
}
?>