<?php
include_once "../include/page.php";
include_once "../module/shoutbox.php";

$p = new Page("shoutbox", 0);
$p->addJs("$(\"#accordion\").accordion({autoHeight:false, navigation:true})");

dev();

$user = $p->db->qry("SELECT id, username FROM users");
$username = array();
while($user = $p->db->fetchLast()){
   $username[$user['id']] = $user['username'];
}

$p->db->qry("SELECT * FROM shoutbox ORDER BY time DESC");
echo "<div id=\"accordion\">";

while($row = $p->db->fetchLast()){
   
   echo "<h3><a>".$username[$row['uid']]." ".$row['time']."</a></h3><div>".$row['message']."</div>";
}

echo "</div>";
?>
