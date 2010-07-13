<?php 
include_once "../include/page.php";
include_once "../include/linklist.php";
$p = new Page('bills',1);

$p->l->addLink('bendigo bank','https://www.bendigobank.com.au/banking/BBLIBanking/',1);
$p->l->addLink('commonwealth bank','https://www3.netbank.commbank.com.au/netbank/bankmain',1);
$p->l->addLink('nab','https://ib.nab.com.au/nabib/index.jsp',1);
$p->l->addBreak();
if (isset($_GET['view']) && $_GET['view']=='full') {
	$p->l->addItem('show current bills','bills',1);
	$result = $p->db->qry("SELECT * FROM `bills` WHERE uid = '".$p->u->id."' ORDER BY `uid` ASC");
	}
if (!isset($_GET['view']) || !$_GET['view']=='full') {
	$p->l->addItem('show full history','bills',1);
	$result = $p->db->qry("SELECT * FROM `bills` WHERE confirmed = 0 AND uid = '".$p->u->id."' ORDER BY `uid` ASC");
	}
$p->l->addItem('add and edit bills','admin_bills.php',2);
echo $p->l->dispList();
?>