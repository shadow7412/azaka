<?php
include_once "../include/page.php";
include_once "../include/userobject.php";

$p = new Page("shoutbox", 0);
$u = new UserObject;
$p->addJs("$(\"#accordion\").accordion({autoHeight:false, navigation:true})");


if(isset($_GET['message'])){
   $p->db->qry("INSERT INTO shoutbox VALUES(default,".$u->id.",default,\"".$_GET['message']."\")");
}

if(isset($_GET['shout_id'])){
   $p->db->qry("SELECT shoutbox.uid as idNumber FROM shoutbox WHERE id =".$_GET['shout_id']);
   while($number = $p->db->fetchLast()){

      if($u->id == $number['idNumber'] || $u->canAccess(2)) 
         $p->db->qry("DELETE FROM shoutbox WHERE id =".$_GET['shout_id']);
}
}

$p->db->qry("SELECT shoutbox.id as shout_id, shoutbox.uid as idNumber, users.username as username, shoutbox.time as time, shoutbox.message as message FROM users,shoutbox WHERE shoutbox.uid = users.id ORDER BY time DESC");
echo "<div id=\"accordion\">";

while($row = $p->db->fetchLast()){

   echo "<h3><a>".$row['username']." ".$row['time']."</a></h3>
             <div>".$row['message'];

   if($u->id == $row['idNumber'] || $u->canAccess(2)) echo "<div style=\"float: right; margin-right:4%;\"><input type=\"button\" onClick=\"grabContent('shoutbox', 'shout_id=".$row['shout_id']."')\" class=\"ui-button ui-widget ui-state-default ui-corner-all\" value=\"Delete\"/></div>"; 
   echo "</div>";
}

echo "</div>";
?>
