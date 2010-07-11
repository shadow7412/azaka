<?php
/*
NOTE THAT THIS CLASS WILL TAKE A FULL SECOND TO LOAD.
This is because the ifstat runs for one second. This will hit load times drastically - so only use this when needed, and preferably via ajax to prevent having to wait.
*/


class Bandwidth {
	public $upload
	public $download
	
	function __construct(){
		exec("ifstat -i eth0 1 1",$output);
		$this->upload = strtok($output[2]," ");
		$this->download = strtok(" ");
	}
?>
