<?php
include "../include/userobject.php";
$u = new UserObject();

header("Content-Type: application/xml; charset=ISO-8859-1");
echo "<rss version=\"2.0\"> 
<channel> 
<title>news - azaka</title> 
<link></link> 
<description>azaka news</description> 
<language>en-uk</language>  
<lastBuildDate>".time()."</lastBuildDate> 
<ttl>60</ttl>";

$u->db->qry("SELECT * FROM news");
while($item = $u->db->fetchLast()){
	echo"
	<item> 
	<title>{$item['title']} by {$item['uid']}</title> 
	<link></link> 
	<pubDate>{$item['time']}</pubDate> 
	<description><![CDATA[ {$item['content']}]]></description> 
	</item>\n";
}
echo "</channel> 
</rss>"
?>