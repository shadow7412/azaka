<?php
include "dbconfig.php";
$errors = "";

function doqry($name,$query){
	mysql_query($query);
	return mysql_error()==""?"":"$name: ".mysql_error()."\n";
}

mysql_connect($db['host'], $db['user'], $db['pass']) or error("The connection to MySQL couldn't be made. Check dbconfig.php.");
$errors .= doqry("Drop Database","DROP DATABASE IF EXISTS ".$db['db']);
$errors .= doqry("Create Database","CREATE DATABASE ".$db['db']);
mysql_select_db($db['db']) or die("<pre>Observe the errors;\n\n".$errors."The database \"".$db['db']."\" couldn't be found. I am hungry.</pre>");

$errors .= doqry("User Table","CREATE TABLE `users` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`username` VARCHAR( 12 ) NOT NULL ,
`password` VARCHAR( 20 ) NOT NULL ,
`access` TINYINT NOT NULL DEFAULT  '0',
`firstname` VARCHAR( 15 ) NOT NULL ,
`lastname` VARCHAR( 15 ) NOT NULL ,
`dob` DATE NOT NULL ,
`billable` BOOL NOT NULL ,
`email` VARCHAR( 20 ) NOT NULL ,
UNIQUE (
`username`
)
) ENGINE = MYISAM ");

$errors .= doqry("Default User","INSERT INTO `users` (`username`, `password`, `access`, `firstname`, `lastname`, `dob`, `billable`, `email`) VALUES ('admin', '', '5', 'System', 'Default', CURDATE(), '0', '')");


$errors .= doqry("News Table","CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `uid` int(11) NOT NULL COMMENT 'Id of user who posted news',
  `time` datetime NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

$errors .= doqry("Default news item","INSERT INTO `news` (`id` ,`visible` ,`uid` ,`time` ,`content`)
VALUES (NULL ,  '1',  '1', CURDATE( ) ,  'Welcome to azaka.\n\nThis is the default news item. You seeing this (and no errors) implies that things have gone smoothly.\n\nShock horror hey :P')
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

if($errors == ""){
	header('Refresh: 1; url=..');
	echo "That seemed to work. Taking you to the mainpage...";
	} else
	echo "<pre>Observe the errors;\n\n".$errors."\n\n</pre><a href=\"..\">return to main page</a>";
?>
