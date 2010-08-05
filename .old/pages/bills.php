<?php 
include_once "../include/page.php";

$p = new Page('bills',1); //This page handles it's own access levels. So allow all registered users.
if((!$p->u->canAccess(2)) && (!$p->u->billable))
	die(header("Not billable or admin", true, 403)); //halt rendering, and say access denied
	
if(isset($_GET['action'])){
	if($_GET['action']=='pay') $p->db->qry("UPDATE `bills` SET `paid` = 1, `datepaid` = '".date('Y-m-d')."' WHERE `id` = '".$_GET['control']."'");
	if($_GET['action']=='cancel') $p->db->qry("UPDATE `bills` SET `paid` = 0 WHERE `id` = '".$_GET['control']."'");
}
$p->addJs("$(\"#accordion\").accordion({autoHeight: false, navigation: true})");
$p->l->addItem('manage bills','admin_bills',2);
$p->l->addLink('bendigo bank','https://www.bendigobank.com.au/banking/BBLIBanking/',0);
$p->l->addLink('commonwealth bank','https://www3.netbank.commbank.com.au/netbank/bankmain',0);
$p->l->addLink('nab','https://ib.nab.com.au/nabib/index.jsp',0);
echo $p->l->dispList();
$p->infoBox($p->db->getSetting('bills_info'));

$p->db->qry("SELECT * FROM `bills` WHERE uid = '".$p->u->id."' AND `confirmed` = 0 ORDER BY `uid` ASC");
echo "<div id=\"accordion\"><h3><a>current bills</a></h3><div>";
if ($p->db->noLast() != 0){
	$unpaid = 0;
	$unconfirmed = 0;
	echo "<table border=1><tr><td>service</td><td>amount</td><td>date added</td><td>date due</td><td>date paid</td><td>date confirmed</td></tr>\n";
	while($row = $p->db->fetchLast()) {
		extract($row);
		echo "<tr><td>$service</td>
		<td>$$amount</td>
		<td>$dateentered</td>
		<td>$datedue</td>
		<td>";
		if (!$paid){
			echo "<input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:sendPost('pages/bills.php?action=pay&control=$id')\" value=\"mark as paid\"></td><td>";
			if ($paypalemail = $p->db->getSetting('paypal_email')) {
				echo "<form action=\"https://www.paypal.com/cgi-bin/webscr\" target=\"_blank\" method=\"post\">
				<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
				<input type=\"hidden\" name=\"business\" value=\"$paypalemail\">
				<input type=\"hidden\" name=\"lc\" value=\"AU\">
				<input type=\"hidden\" name=\"item_name\" value=\"{$p->u->username}$service\">
				<input type=\"hidden\" name=\"amount\" value=\"$amount\">
				<input type=\"hidden\" name=\"currency_code\" value=\"AUD\">
				<input type=\"hidden\" name=\"button_subtype\" value=\"services\">
				<input type=\"hidden\" name=\"shipping\" value=\"0.00\">
				<input type=\"hidden\" name=\"bn\" value=\"PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted\">
				<input type=\"submit\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" value=\"pay with paypal\" border=\"0\" name=\"submit\" title=\"pay via paypal, mastercard, visa etc.\">
				</form>";
				} else 
					echo "pay first";
			$unpaid += $amount;
			} else {
				echo "$datepaid</td><td><input type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:sendPost('pages/bills.php?action=cancel&control=$id')\" value=\"mark as unpaid\">";
				$unconfirmed+= $amount;
			}
		echo "</td></tr>";
	}
	echo "</table>\n<br/><br/>";
	if ($unpaid!=0) echo "<strong>$$unpaid outstanding</strong><br/>"; else echo "$0 outstanding<br/>";
	if ($unconfirmed!=0) echo "<strong>$$unconfirmed unconfirmed<br/></strong>"; else echo "$0 unconfirmed<br/>";
} else echo "You currently do not have any bills outstanding. Outstanding!";
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
} else echo "You do not yet have a history. Enjoy it while it lasts... heh heh heh...";
echo "</div></div>";
?>