CREATE TABLE  `azaka`.`users` (
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
) ENGINE = MYISAM 