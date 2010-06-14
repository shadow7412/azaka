<?php
class linklist {
	var $links = array();
	var $counter;
	
	function __construct(){
		$this->counter = 0;
	}
	
	function additem($label,$link, $reqaccess){
	if (true/*$userinfo->access<$reqaccess*/){
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
				echo "<li><a href=\"javascript:jah('".$this->links[$i]["link"]."','content');\">".$this->links[$i]["label"]."</a></li>";
			else
				echo "<br/>";
		}
	echo "</ul></div>";
	$this->counter=0;
	}
}
?>