<?php 
include_once "../include/page.php";
include_once "../include/linklist.php";
$p = new Page('bills',1);

$p->l->addLink('bendigo bank','https://www.bendigobank.com.au/banking/BBLIBanking/',1);
$p->l->addLink('commonwealth bank','https://www3.netbank.commbank.com.au/netbank/bankmain',1);
$p->l->addLink('nab','https://ib.nab.com.au/nabib/index.jsp',1);
echo $p->l->dispList();
?>