<?php
include_once "../include/page.php";
$p = new Page("registration",0);
//dev();
if (isset($_GET['action']) && $_GET['action']=="login" && isset($_GET['username']) && isset($_GET['password'])
	&& $result = $p->db->fetch($p->db->qry("SELECT username, password, disabled FROM users WHERE username = '".$_GET['username']."'"))){
		if($result['password']==$_GET['password']){
			if($result['disabled']){
				$p->infoBox("You have successfully identified yourself, but your account is disabled.");
				$p->infoBox("To gain access please talk to your admin.");
				echo "<input onclick=\"history.go(-1);\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" value=\"Return\"/>";
				die();
			} else {
				$p->u->updateCookies($_GET['username'], $_GET['password']);
				$p->addJs("grabModules(); grabSidebar(); setTimeout('history.go(-1)',500);");
				die($p->infoBox("Logging In..."));
			}
		} else {
			//incorrect password
			$p->infoBox("You seem to have inaccuratly typed your password. For examples sake, I have intentionally misspelled inaccurately. Poor you.<br/>Try again, or you can ask your benevolent admin to reset it...");
			$p->infoBox("If you have not used this system before, please register.");
		}
} else if (isset($_GET['action']) && $_GET['action']=="wanttoregister"){
	$p->infoBox("Here is the paperwork..");
} else if (isset($_GET['action']) && $_GET['action']=="register"){
	//make sure there are no duplicate names
	$p->db->qry("SELECT username, disabled FROM users WHERE username = '".$_GET['username']."'");
	if($row = $p->db->fetchLast()){
		if($row['disabled']) $p->infoBox("This username is already taken, but disabled. If you are this user, you may want to talk to your benevolent admin");
		$p->infoBox("That username (".$row['username'].") is taken");
		$p->infoBox("Your punishment is filling out the whole form again because I haven't made it autopopulate yet.");
	} else {
		//add user to database
		extract($_GET);
		$p->db->qry("INSERT INTO users (username, password, firstname, lastname, dob, email)
			VALUES ('$username','$password','$firstname','$lastname','$doby-$dobm-$dobd','$email')");
		//log user in
		$p->u->updateCookies($_GET['username'], $_GET['password']);
		$p->addJs("grabModules(); grabSidebar(); setTimeout('history.go(-1)',500);");
	}
} else {
	$p->infoBox("Dunno who the heck you are... Fill this out if you want to register.");
}
?>

<form id="register" name="register" onsubmit="
if(document.register.username.value == '' || 
document.register.password.value == '' || 
document.register.confirm.value == '' || 
document.register.firstname.value == '' || 
document.register.lastname.value =='' || 
document.register.doby.value == '' || 
document.register.email.value == '' ){
	errorMsg('Please fill out ALL fields.');
} else if(document.register.username.value == 'guest'){
	errorMsg('\'guest\' is not a valid username.');
	document.register.username.value = '';
	document.register.username.focus();
} else if(document.register.password.value != document.register.confirm.value){
	errorMsg('Please learn how to type. Start simply - by typing the same password twice.');
	document.register.password.value = '';
	document.register.confirm.value = '';
	document.register.password.focus();
} else if(!validateEmail(document.register.email.value)){
	errorMsg('the email does not seem valid');
	document.register.email.value = '';
	document.register.email.focus();
} else {
	sendForm(this,'register');
};" action="javascript:false">
  <table width="500" border="0">
    <tr>
      <td width="167">username</td>
      <td><input type="text" name="username"/></td>
    </tr>
    <tr>
      <td>password</td>
      <td><input type="password" name="password"/></td>
    </tr>
    <tr>
      <td>confirm</td>
      <td><input type="password" name="confirm"/></td>
    </tr>
    <tr>
      <td>first name</td>
      <td><input type="text" name="firstname"/></td>
    </tr>
    <tr>
      <td>last name</td>
      <td><input type="text" name="lastname"/></td>
    </tr>
    <tr>
      <td>date of birth</td>
      <td><select name="dobd" id="dobd">
        <option value="1">01</option>
        <option value="2">02</option>
        <option value="3">03</option>
        <option value="4">04</option>
        <option value="5">05</option>
        <option value="6">06</option>
        <option value="7">07</option>
        <option value="8">08</option>
        <option value="9">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
      </select>
        <select name="dobm" id="dobm">
        <option value="1">01</option>
        <option value="2">02</option>
        <option value="3">03</option>
        <option value="4">04</option>
        <option value="5">05</option>
        <option value="6">06</option>
        <option value="7">07</option>
        <option value="8">08</option>
        <option value="9">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
      </select>
      <input name="doby" type="text" id="doby" size="4" onkeypress=enterNumbers() /></td>
    </tr>
    <tr>
      <td>email</td>
      <td><input type="text" name="email"/></td>
    </tr>
  </table>
  <tr><input type="submit" name="action" value="register" class="ui-button ui-widget ui-state-default ui-corner-all"/></tr>
</form>
