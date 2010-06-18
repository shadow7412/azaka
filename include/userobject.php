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
	//first pull in any cookie info
		if(isset($_COOKIE['username'])&&isset($_COOKIE['password'])){
			$this->username = $_COOKIE['azaka_username'];
			$this->password = $_COOKIE['azaka_password'];
		}
	//if cookie info is existent and correct, log user in
		if(isset($this->username)){
			if($result = mysql_fetch_array($db->qry("SELECT * FROM users WHERE username='".$this->username."' AND password = '".$this->password."'"))){
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
		
		//save any changes
		setcookie("azaka_username",$this->username,time()+60*60*24*14);
		setcookie("azaka_password",$this->password,time()+60*60*24*14);
	}
	/*function __destruct(){
		//save any changes
		setcookie("azaka_username",$this->username,time()+60*60*24*14);
		setcookie("azaka_password",$this->password,time()+60*60*24*14);
	}*/
}
?>