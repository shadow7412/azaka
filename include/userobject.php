<?php
include_once "../include/db.php";

//dev function shows the contents of $_GET. Done here because it is the most common include.
function dev(){
	echo "<pre onclick=\"this.innerHTML='".print_r($_SERVER,true)."'\">".print_r($_GET,true)."</pre>";
}

class UserObject {
	public $id;
	public $username;
	public $password;
	public $access;
	public $firstname;
	public $lastname;
	public $dob;
	public $billable;
	public $email;
	public $isLocal;
	public $skin;
	public $db;
	private $changed;
	
	function __construct(){
		$this->db = new Database();
		$this->changed = false;
		$this->updateUser();
		switch ($_SERVER['REMOTE_ADDR'][0].$_SERVER['REMOTE_ADDR'][1].$_SERVER['REMOTE_ADDR'][2]){ //until i work out substring..
			case ("127"):
			case ("192"):
			case ("172"):
			case ("10."):
				$this->isLocal = true;
				break;
			default:
				$this->isLocal = false;
		}
		if($this->changed) $this->updateCookies($this->username,$this->password);
	}

	function updateUser(){
	//first pull in any cookie info
		if(isset($_COOKIE['azaka_username']) && isset($_COOKIE['azaka_password'])){
			$this->username = $_COOKIE['azaka_username'];
			$this->password = $_COOKIE['azaka_password'];
		}
	//if cookie info is existent and correct, log user in. if not, destroy stuff.
		if(isset($this->username)){
			if($result = $this->db->fetch(
				$this->db->qry("SELECT * FROM users WHERE username='".$this->username."' AND password = '".$this->password."' AND disabled=0")
			)){
				$this->id = $result['id'];
				$this->access = $result['access'];
				$this->firstname = $result['firstname'];
				$this->lastname = $result['lastname'];
				$this->dob = $result['dob'];
				$this->billable = $result['billable'];
				$this->skin = $result['skin'];
				$this->email = $result['email'];
				$this->db->qry("UPDATE  `users` SET  `lastactive` = NOW( ) WHERE  `users`.`id` ={$this->id};");
			} else {
				unset($this->username);
				$this->changed = true;
			}
		}
	//if user did not successfully log in, log in a pseudo guest account
		if(!isset($this->username)){
			$this->username = "guest";
			$this->skin = 1;
			$this->access = 0;
		}
	}
	function invalidateSession(){
		$this->changed = true;
		$this->updateCookies('','');
	}
	function updateCookies($user, $pass){
		$timeout = $this->db->getSetting('account_timeout');
		setcookie("azaka_username",$user,time()+60*60+60*60*24*$timeout,"/");
		setcookie("azaka_password",$pass,time()+60*60+60*60*24*$timeout,"/");
	}
	function updatePassword($pass){
		$this->changed=true;
		setcookie("azaka_password",$pass,time()+60*60*24*14,"/");
	}
	function canAccess($reqaccess){
		return ($this->access >= $reqaccess);
	}
	function getSkin(){
		$default = "aesthetics/skins/dark-hive/jquery-ui-1.8.2.custom.css"; //Should be dynamic
	
		if(isset($this->id)){
			$this->db->qry("SELECT skins.css AS css FROM skins, users WHERE users.id = {$this->id} AND skins.id=users.skin");
			if($row = $this->db->fetchLast())
				return "aesthetics/skins/".$row['css'];
			else
				return $default;
		} else 
			return $default;
	}
}
?>
