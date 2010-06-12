<?php
include "dbconfig.php";

mysql_connect($db['host'], $db['user'], $db['pass']) or error("The connection to MySQL couldn't be made. Check dbconfig.php.");
mysql_query("IF NOT EXIST CREATE DATABASE azaka");
mysql_select_db($db['db']) or error("The database \"".$db['db']."\" couldn't be found. Have you run the installer by any chance..?");

mysql_query("CREATE TABLE  `azaka`.`users` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,in
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

mysql_query("CREATE TABLE  `azaka`.`news` (
`id` INT NOT NULL ,
`visible` INT NOT NULL ,
`uid` INT NOT NULL COMMENT  'Id of user who posted news',
`time` DATETIME NOT NULL ,
`content` TEXT NOT NULL
) ENGINE = MYISAM");


mysql_query("CREATE TABLE  `azaka`.`bills` (
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

Header('Location: ..');
?>
