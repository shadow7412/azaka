<?php
if (strpos($_SERVER['HTTP_USER_AGENT'],"iPhone")) require("iphone.html");
else require("pc.html");
?>