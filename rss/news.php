<?php
include "../include/userobject.php";
$u = new UserObject();

header("Content-Type: application/xml; charset=ISO-8859-1");
echo "<rss version=\"2.0\"> 
<channel> 
<title>news - azaka</title> 
<link>http://{$_SERVER['SERVER_NAME']}/{$_SERVER['REQUEST_URI']}</link> 
<description>azaka news</description> 
<language>en-uk</language>  
<lastBuildDate>".date('r')."</lastBuildDate> 
<ttl>60</ttl>";

$u->db->qry("SELECT * FROM news");
while($item = $u->db->fetchLast()){
	echo "
	<item> 
	<title>{$item['title']} by {$item['uid']}</title> 
	<link>http://{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}#news</link> 
	<pubDate>".date('r', strtotime($item['time']))."</pubDate> 
	<description><![CDATA[ {$item['content']}]]></description> 
	</item>\n";
}
echo "</channel> 
</rss>";
?>