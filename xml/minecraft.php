<?php 
//puts log into stdstream, takes out the timestamp, gets the last 8 entries, gets rid of the <>'s which would berak xml.
exec("cat /home/gui/minecraft/server.log|cut -c 28-|tail -n 5 |tr -t '<>' '[]'",$output);
header("content-type: text/xml");
echo "<minecraft>
<log>";
foreach($output as $line)
	echo "<line>$line</line>\n";
echo "</log>
</minecraft>";
?>