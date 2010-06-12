<?php
class userObject {
	var $id;
	var $username;
	var $password;
	var $access;
	var $firstname;
	var $lastname;
	var $dob;
	var $billable;
	var $email;

	function __construct(){
		if(isset($_COOKIE['username'])&&isset($_COOKIE['password'])){
			$userinfo['username'] = $_COOKIE['username'];
			$userinfo['password'] = $_COOKIE['password'];
		}

		if(isset($userinfo['username'])){
			if($result = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='$username' AND password = '$password'"))){
				$id = $result['id'];
				$access = $result['access'];
				$firstname = $result['firstname'];
				$lastname = $result['lastname'];
				$dob = $result['dob'];
				$billable = $result['billable'];
				$email = $result['email'];
			} else {
				unset($userinfo['username']);
			}
		}
		
		if(!isset($userinfo['username'])){
			$userinfo['username'] = "Guest";
			$userinfo['password'] = "";
			$userinfo['access'] = 0;
		}
		
		global $username, $password;
		setcookie("username",$username,time()+60*60*24*14);
		setcookie("password",$password,time()+60*60*24*14);
		
	}
	
}
?>