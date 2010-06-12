<?php
class linklist {
	var $links = array();
	var $counter;
	
	function __construct(){
		global $counter;
		$counter = 0;
	}
	
	function additem($label,$link, $reqaccess){
	global $userinfo;
	global $counter;
	if ($userinfo->access<$reqaccess){
		$links[$counter]["label"] = $label;
		$links[$counter++]["link"] = $link;
		}
	}

	function addbreak(){
		global $counter;
		$counter++;
	}
	
	function disp(){
		global $counter;
		for($i=0;$i!=$counter;$i++){
		if(isset($link[$i]['label']) && $link[$i]['label']!="")
			echo "<a href=\"$link\">$label</a><br/>";
		else
			echo "<br/>";
		}
	}

}
?>