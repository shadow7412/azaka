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
) ENGINE = MYISAM");

Header('Location: ..');
?>