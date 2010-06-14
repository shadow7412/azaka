<?php
if (strpos($_SERVER['HTTP_USER_AGENT'],"iPhone")) require("aesthetics/iphone.html");
else require("aesthetics/pc.html");
?>