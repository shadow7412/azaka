<?php
include_once "../include/page.php";
include_once "../include/userobject.php";

$p = new Page("shoutbox", 0);
$u = new UserObject;
$p->addJs("$(\"#accordion\").accordion({autoHeight:false, navigation:true})");


if(isset($_GET['message'])){
   $p->db->qry("INSERT INTO shoutbox VALUES(default,".$u->id.",default,\"".$_GET['message']."\")");
}

if(isset($_GET['delete']) && isset($_GET['idNumber'])){
    if($u->id == $_GET['idNumber'] || $u->canAccess(2)) $p->db->qry("DELETE FROM shoutbox WHERE id =".$_GET['delete']);
}

$HTML = null;

$user = $p->db->qry("SELECT id, username FROM users");
$username = array();
while($user = $p->db->fetchLast()){
   $username[$user['id']] = $user['username'];
}

$p->db->qry("SELECT * FROM shoutbox ORDER BY time DESC");
$HTML .= "<div id=\"accordion\">";

while($row = $p->db->fetchLast()){
   $HTML .= "<h3><a>".$username[$row['uid']]." ".$row['time']."</a></h3>
             <div>".$row['message'];
   if($u->id == $row['uid'] || $u->canAccess(2)) $HTML .= "<a href='#shoutbox&delete={$row['id']}&idNumber={$row['uid']}' style=\"color: yellow; float: right; margin-right:4%;\">Delete</a>"; 
   $HTML .= "</div>";
}

$HTML .= "</div>";
echo $HTML;
?>
