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
		for($i=0; $i != $this->counter; $i++){
			
			if(isset($this->link[$i]['label']) && $this->link[$i]['label'] != "")
				echo "<a href=\"".$this->links[$i]["link"]."\">".$this->links[$i]["label"]."</a><br/>";
			else
				echo "<br/>";
			}
		}

}
?>