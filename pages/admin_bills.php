<?php 
include_once "../include/page.php";
$p = new Page('bills',1);
dev();
if(isset($_GET['action'])){
	if($_GET['action']=='pay') $p->db->qry("UPDATE `bills` SET `paid` = 1, `datepaid` = '".date('Y-m-d')."' WHERE `id` = '".$_GET['control']."'");
	if($_GET['action']=='confirm') $p->db->qry("UPDATE `bills` SET `confirmed` = 1, `dateconfirmed` = '".date('Y-m-d')."' WHERE `id` = '".$_GET['control']."'");
	if($_GET['action']=='delete') $p->db->qry("UPDATE `bills` SET `confirm` = 1 WHERE `id` = '".$_GET['control']."'");
}
$p->addJs("$(\"#accordion\").accordion({autoHeight: false, navigation: true})");
$p->l->addItem('bills','admin_bills',2);
$p->l->addLink('bendigo bank','https://www.bendigobank.com.au/banking/BBLIBanking/',0);
$p->l->addLink('commonwealth bank','https://www3.netbank.commbank.com.au/netbank/bankmain',0);
$p->l->addLink('nab','https://ib.nab.com.au/nabib/index.jsp',0);
echo $p->l->dispList();

$p->db->qry("SELECT bills.*, username FROM users, `bills` WHERE uid = users.id AND `confirmed` = 0 ORDER BY `uid` ASC");
echo "<div id=\"accordion\"><h3><a>current bills</a></h3><div>";
if ($p->db->noLast() != 0){
	$unpaid = 0;
	$unconfirmed = 0;
	echo "<table border=1><tr><td>username</td><td>service</td><td>amount</td><td>date added</td><td>date due</td><td>date paid</td><td>date confirmed</td><td>delete</td></tr>\n";
	while($row = $p->db->fetchLast()) {
		extract($row);
		echo "<tr><td>$username</td>
		<td>$service</td>
		<td>$$amount</td>
		<td>$dateentered</td>
		<td>$datedue</td>
		<td>";
		if (!$paid){
			echo "<input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:sendPost('pages/admin_bills.php?action=pay&control=$id')\" value=\"mark as paid\"></td><td>";
			$unpaid += $amount;
			} else {
				echo "$datepaid</td><td><input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:sendPost('pages/admin_bills.php?action=confirm&control=$id')\" value=\"confirm\" title=\"Click here when you have verified that this amount has entered the account.\">";
				$unconfirmed+= $amount;
			}
		echo "</td><td><a href=\"javascript:if(confirm('You should not delete things unless they are mistakes.\\nBills are supposed to all be logged.\\n\\nAre you sure you want to delete this entry?'))sendPost('pages/admin_bills.php?action=delete&control=$id')\" class=\"ui-icon ui-icon-circle-close\"/></td></tr>";
	}
	echo "</table>\n<br/><br/>";
	if ($unpaid!=0) echo "<strong>$$unpaid outstanding</strong><br/>"; else echo "$0 outstanding<br/>";
	if ($unconfirmed!=0) echo "<strong>$$unconfirmed unconfirmed<br/></strong>"; else echo "$0 unconfirmed<br/>";
} else echo "There are no outstanding bills!";
echo "</div><h3><a>add bill</a></h3><div>";
////////////////////////////////////////////////////////////////////////////////////////////////////

	$p->db->qry("SELECT `id`,`username`, `email` FROM `users` WHERE `billable` = '1' ORDER BY `username` ASC");
	$users = 0;
	$emailnotice = "";
	if($p->db->noLast() != 0){
		echo "<form action=\"javascript:sendForm(this, 'admin_bills')\" name=\"addform\" id=\"addform\"><table>";
		while($row = $p->db->fetchLast()) {
			extract($row);
			$p->addJs("document.addform.action += '\'&amount$id=\'+document.addform.amount$users.value;';");
			echo "<tr><td>$username</td>
				<td><input type=\"checkbox\" name\"checkuser$users\" id=\"checkuser$users\" checked/>
				<input type=\"text\" name=\"amount$users\" id=\"amount$users\" value = 0>
				</td></tr>\n";
			$users++;
			if(false && isset($_GET['action']) && $_GET['action'] == 'addform' && isset($_GET['amount'+$id]) && $_GET['amount'+$id] !=0 ){
				$p->db->qry("INSERT INTO `bills` (uid,amount,dateentered,datedue,service) VALUES ('$id', '".$_GET['amount'+$id]."', '".date('Y-m-d')."', '".$_GET['datedue']."', '".$_GET['service']."')");
				
				//email new bill notice
				if($p->db->getSetting("bills_email") && $email != "") {
					if(!(mail($email, "azaka - new bill." , ucfirst($username).",\n\nA new bill has been added.\n\nFor: ".$_GET['service']."\nAmount: $".$_GET['amount'.$id]."\n\nPlease pay, then head to http://lemon.thruhere.net/alp/bills.php and mark it.\nYou cannot reply to this email. Or rather you can, but it will die in cyberspace.\nAlso if you want to change which email this is sent to, do so in the users section in lemon.\n\nThankyou." )))
						$emailnotice .= "Email not sent to $username. SMTP error occurred. Attempted to send to ".$row["email"]."\\n\\n";
					else
						$emailnotice .= "Email sent to $username. successfully.\\n\\n";
				} else {
					$emailnotice .= "Email not sent to $username. Users email not found in DB.\\n\\n";
				}
			}
		}
		if($emailnotice!="")
			echo "<script language=\"JavaScript\">alert('$emailnotice');</script>";
		$p->addJs("document.addform.action += ')';");
		
		//draw the common elements, and the split form
		echo "tick the people to spilt between or enter figures manually<br/>total <input type=\"text\" id=\"splitfield\">
		<input id=\"split\" value=\"split\" type=\"button\" onClick=\"var average = 0.0;";
		for($ii=0;$ii!=$users;$ii++) echo "if (getElementById('checkuser$ii').checked) average++;";
		for($ii=0;$ii!=$users;$ii++) echo "if (getElementById('checkuser$ii').checked) getElementById('user$ii').value = getElementById('splitfield').value/average; else getElementById('user$ii').value = 0;";
		echo "\"><br/><br/>";	
		
		echo "<tr><td>datedue</td><td>	<input type=\"text\" name=\"datedue\" value = ".date('Y-m-d')."></td></tr>
		<tr><td>service</td><td> <input type=\"text\" name=\"service\" value = \"misc\"></td></table>
		<input value = \"add\" type=\"submit\"></form><br/>";
	} else {
		echo "No users have been marked as billable.";
	}

////////////////////////////////////////////////////////////////////////////////////////////////////
echo "</div><h3><a>bill history</a></h3><div>";

$p->db->qry("SELECT * FROM `bills` WHERE uid = '".$p->u->id."' AND confirmed=1 ORDER BY `datedue` DESC");
if ($p->db->noLast() != 0){
	$totalpaid = 0;
	echo "<table border=1><tr><td>service</td><td>amount</td><td>date added</td><td>date due</td><td>date paid</td><td>date confirmed</td></tr>\n";
	while($row = $p->db->fetchLast()) {
		extract($row);
		echo "<tr><td>$service</td>
		<td>$$amount</td>
		<td>$dateentered</td>
		<td>$datedue</td>
		<td>$datepaid</td>
		<td>$dateconfirmed</td>
		</td></tr>";
		$totalpaid += $amount;
	}
	echo "</table>\n<br/><br/>";
	echo "<strong>$$totalpaid paid in total</strong><br/>";
} else echo "At this point history is not available because there is no history.";
echo "</div></div>";
?>