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

$p->db->qry("SELECT users.username as username, shoutbox.time as time, shoutbox.message as message FROM users,shoutbox WHERE shoutbox.uid = users.id ORDER BY time DESC");
echo "<div id=\"accordion\">";

while($row = $p->db->fetchLast()){
   echo "<h3><a>".$row['username']." ".$row['time']."</a></h3>
             <div>".$row['message'];
   if($u->id == $row['uid'] || $u->canAccess(2)) echo "<a
href='#shoutbox&delete={$row['id']}&idNumber={$row['uid']}'
style=\"float: right; margin-right:4%;\"><input type= 'submit'
class=\"ui-button ui-widget ui-state-default ui-corner-all\"name='Delete' value='Delete'></a>"; 
   echo "</div>";
}

echo "</div>";
?>
