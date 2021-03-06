<?php
/*
NOTE THAT THIS CLASS WILL TAKE A FULL SECOND TO LOAD.
This is because the ifstat runs for one second. This will hit load times drastically - so only use this when needed, and preferably via ajax to prevent having to wait.
*/

class Bandwidth {
	public $upload;
	public $download;
	
	function __construct(){
		exec("ifstat -i eth1 1 1",$output);
		if(isset($output[2])){
			$this->download = strtok($output[2]," ");
			$this->upload = strtok(" ");
		} else { //if ifstat does not exist, then this will not be defined.
			$this->upload = "Install";
			$this->download = "ifstat";
		}
	}
}
?>
