<?php
include_once "../include/page.php";
include_once "../include/userobject.php";

$p = new Page("shoutbox", 0);
$u = new UserObject;
$p->addJs("$(\"#accordion\").accordion({autoHeight:false, navigation:true})");

if(isset($_GET['message'])){
   $p->db->qry("INSERT INTO shoutbox VALUES(default,".$u->id.",default,\"".$_GET['message']."\")");
}

//$p->addJs("function delete(){alert('hello');}");

$user = $p->db->qry("SELECT id, username FROM users");
$username = array();
while($user = $p->db->fetchLast()){
   $username[$user['id']] = $user['username'];
}

$p->db->qry("SELECT * FROM shoutbox ORDER BY time DESC");
echo "<div id=\"accordion\">";

while($row = $p->db->fetchLast()){
   
   echo "<h3><a>".$username[$row['uid']]." ".$row['time']."</a></h3><div>".$row['message']."<a href=\"javascript:delete()\" style=\"color: yellow; float: right; margin-right:5%;\">Delete</a></div>";
}

echo "</div>";
?>
