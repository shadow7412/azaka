<?php
include_once "../include/db.php";

//dev function shows the contents of $_GET. Done here because it is the most common include.
function dev(){
	error_reporting(E_ALL);
	echo "<pre onclick=\"this.innerHTML='".print_r($_SERVER,true)."'\">".print_r($_GET,true)."</pre>";
}

class UserObject {
	public $id;
	public $username;
	private $password;
	public $access;
	public $firstname;
	public $lastname;
	public $dob;
	public $billable;
	public $email;
	public $isLocal;
	public $skin;
	public $db;
	private $cookie; // md5(user.md5(password));
	
	function __construct(){
		$this->db = new Database();
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
		$this->updateCookies($this->username,$this->password);
	}
	function updateUser(){
		//if cookie info matches user, log them in - if not wipe cookie.
		if(isset($_COOKIE['azaka_user'])){
			$this->cookie = $_COOKIE['azaka_user'];
			$this->db->qry("SELECT * FROM users");
			while($result = $this->db->fetchLast()){
				if($this->cookie == md5($result['username'].$result['password'])){
					$this->id = $result['id'];
					$this->username = $result['username'];
					$this->password = $result['password'];
					$this->access = $result['access'];
					$this->firstname = $result['firstname'];
					$this->lastname = $result['lastname'];
					$this->dob = $result['dob'];
					$this->billable = $result['billable'];
					$this->skin = $result['skin'];
					$this->email = $result['email'];
					$this->db->qry("UPDATE  `users` SET  `lastactive` = NOW( ) WHERE  `users`.`id` ={$this->id}");
					break; //stop looking for the user
				}
			}
			if(!isset($this->username))
				unset($this->cookie); //if no valid user was logged in, clear the cookie
		}
		//if there is not cookie set - log user in as guest
		if(!isset($this->cookie)){
			$this->username = "guest";
			$this->skin = 1;
			$this->access = 0;
		}		
	}
	function invalidateSession(){
		setcookie("azaka_user",'');
	}
	function updateCookies($user, $pass){
		if(headers_sent())
			echo "<div id=\"error\">User info not updated</div>";
		else
			setcookie("azaka_user",md5($user.$pass),time()+3600+86400*$this->db->getSetting('account_timeout'),"/");
	}
	function updatePassword($pass){
		$this->updateCookies($this->username,$pass);
	}
	function canAccess($reqaccess){
		return ($this->access >= $reqaccess);
	}
	function getSkin(){
		$default = "aesthetics/skins/dark-hive/jquery-ui-1.8.2.custom.css"; //Should be dynamic (but isn't)
	
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
