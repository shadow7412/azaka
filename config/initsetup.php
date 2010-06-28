<?php
include "dbconfig.php";
$errors = "";

function doqry($name,$query){
	mysql_query($query);
	return mysql_error()==""?"":"$name: ".mysql_error()."\n";
}

if(file_exists("stop")){
	echo "To (re)install the database please delete the stop file in config.<br/>Then refresh this page.";
} else {

	mysql_connect($db['host'], $db['user'], $db['pass']) or error("The connection to MySQL couldn't be made. Check dbconfig.php.");
	$errors .= doqry("Drop Database","DROP DATABASE IF EXISTS ".$db['db']);
	$errors .= doqry("Create Database","CREATE DATABASE ".$db['db']);
	mysql_select_db($db['db']) or die("<pre>Observe the errors;\n\n".$errors."The database \"".$db['db']."\" couldn't be found. I am hungry.</pre>");

	$errors .= doqry("User Table","CREATE TABLE `users` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`username` VARCHAR( 12 ) NOT NULL ,
	`password` VARCHAR( 40 ) NOT NULL ,
	`access` TINYINT NOT NULL DEFAULT  '1',
	`firstname` VARCHAR( 15 ) NOT NULL ,
	`lastname` VARCHAR( 15 ) NOT NULL ,
	`dob` DATE NOT NULL ,
	`billable` BOOL NOT NULL ,
	`email` VARCHAR( 20 ) NOT NULL ,
	UNIQUE (
	`username`
	)
	) ENGINE = MYISAM ");

	$errors .= doqry("Default User","INSERT INTO `users`
	(`username`, `password`, `access`, `firstname`, `lastname`, `dob`, `billable`, `email`)
	VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', '5', 'System', 'Default', CURDATE(), '0', '')");


	$errors .= doqry("News Table","CREATE TABLE `news` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `visible` tinyint(1) NOT NULL DEFAULT '1',
	  `uid` int(11) NOT NULL COMMENT 'Id of user who posted news',
	  `time` datetime NOT NULL,
	  `content` text NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

	$errors .= doqry("Default news item","INSERT INTO `news` (`id` ,`visible` ,`uid` ,`time` ,`content`)
	VALUES (NULL ,  '1',  '1', CURTIME( ) ,  'Welcome to azaka.\n\nThis is the default news item. You seeing this (and no errors) implies that things have gone smoothly.\n\nShock horror hey :P')
	");

	$errors .= doqry("Bills Table","CREATE TABLE `bills` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`uid` INT NOT NULL ,
	`service` VARCHAR( 10 ) NOT NULL ,
	`amount` DECIMAL( 5, 2 ) NOT NULL ,
	`dateentered` DATE NOT NULL ,
	`datedue` DATE NOT NULL ,
	`paid` BOOL NOT NULL ,
	`confirmed` INT NOT NULL ,
	`datepaid` DATE NOT NULL ,
	`dateconfirmed` DATE NOT NULL
	) ENGINE = MYISAM");

	$errors .= doqry("Pages Table","CREATE TABLE IF NOT EXISTS `pages` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `enabled` tinyint(1) NOT NULL DEFAULT '1',
	  `visible` tinyint(1) NOT NULL DEFAULT '1',
	  `name` text NOT NULL,
	  `url` text NOT NULL,
	  `access` tinyint(4) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

	$errors .= doqry("Add Pages","INSERT INTO pages (name, url, access, visible) VALUES
	('error','error.php',0 , 0),
	('register','register.php',0, 0),
	('bills','bills.php',1, 1),
	('news','news.php',0, 1),
	('admin_bills','admin_bills.php',2, 0),
	('admin_news','admin_news.php', 2, 0)
	");
	
	$errors .= doqry("Module Table","CREATE TABLE IF NOT EXISTS `modules` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `enabled` tinyint(1) NOT NULL DEFAULT '1',
	  `onsidebar` tinyint(1) NOT NULL DEFAULT '0',
	  `access` int(11) NOT NULL DEFAULT '0',
	  `name` text NOT NULL,
	  `url` text NOT NULL,
	  `localrefresh` int(11) NOT NULL DEFAULT '3000',
	  `webrefesh` int(11) NOT NULL DEFAULT '15000',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
	
	$errors .= doqry("Add Modules", "INSERT INTO modules (name, url, onsidebar) VALUES
	('userinfo','userinfo.php', 1),
	('server','server.php', 0),
	('ventrilio','vent.php', 0)
	");

	if($errors == ''){
		header('Refresh: 1; url=..');
		echo "That seemed to work. Taking you to the mainpage...";
		$file = fopen("stop","w");
		fclose($file);
	} else
		echo "<pre>Observe the errors;\n\n".$errors."\n\n</pre><a href=\"..\">return to main page</a>";
}
?>
