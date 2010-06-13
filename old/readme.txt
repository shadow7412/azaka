>>TODO
-set the iphone kajigger to happen only once (ie leave a cookie if users says no)

>>Login
Will use cookies like in saltfish - if you log in then you stay that way.


>>Database - run azaka/config/initsetup.php to set up the database

> users
-- id, int
-- username, varchar(10)
-- password, varchar(10)
-- access
-- first, varchar(15)
-- last, varchar(15)
-- dob
-- billable
-- email, varchar(20)

> bills
-- id
-- uid
-- service

> news
-- id
-- visible
-- idposter
-- time
-- content

> settings
