<?php
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

	function __construct(){
		$this->updateUser();
		$this->updateCookies($this->username,$this->password);
	}

	function updateUser(){
	//first pull in any cookie info
		if(isset($_COOKIE['azaka_username']) && isset($_COOKIE['azaka_password'])){
			$this->username = $_COOKIE['azaka_username'];
			$this->password = $_COOKIE['azaka_password'];
		}
	//if cookie info is existent and correct, log user in. if not, destroy stuff.
		include_once "../include/db.php";
		$db = new Database();
		if(isset($this->username)){
			if($result = mysql_fetch_array($db->qry("SELECT * FROM users WHERE username='".$this->username."' AND password = '{$this->password}'"))){
				$this->id = $result['id'];
				$this->access = $result['access'];
				$this->firstname = $result['firstname'];
				$this->lastname = $result['lastname'];
				$this->dob = $result['dob'];
				$this->billable = $result['billable'];
				$this->email = $result['email'];
			} else {
				unset($this->username);
			}
		}
	//if user did not successfully log in, log in a pseudo guest account
		if(!isset($this->username)){
			$this->username = "guest";
			$this->password = "";
			$this->access = 0;
		}
	}
	function invalidateSession(){
		$this->updateCookies('','');
	}
	function updateCookies($user, $pass){
		setcookie("azaka_username",$user,time()+60*60*24*14,"/");
		setcookie("azaka_password",$pass,time()+60*60*24*14,"/");
	}
}
?>