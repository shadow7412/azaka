<?php
include_once "../include/module.php";
include "ventrilostatus.php";
$m = new Module("ventrilo", 0);
$m->addJs("document.getElementById('mod-ventrilo').innerHTML = grabXML('modules/vent.php?update=doit');");

function VentriloDisplayEX1( &$stat, $name, $cid, $bgidx , &$m)
{
  global $colors; 
  $chan = $stat->ChannelFind( $cid );
/*
  if ( $bgidx % 2 )
  	$bg = $colors['cell_background'];
  else
  	$bg = $colors['background'];
*/
//$bg = "#111111";

/*
  if ( $chan->m_prot )
    $fg = "#FF0000";
  else
    $fg = "#FFFFFF";
*/
  $fg = "#FFFFFF";
  /*
  if ( $chan->m_prot )
  {
  		if ( $bgidx %2 )
			$bg = "#000000";
		else
			$bg = "#330000";
  }
  */
  $m->addContent("  <tr>\n");
  $m->addContent("    <td><font color=\"$fg\"><strong>");
  $m->addContent($name);
  $m->addContent("</strong></font>\n");
  
  $m->addContent("      <table width=\"95%\" border=\"0\" align=\"right\">\n");
  
  // Display Client for this channel.
  
  for ( $i = 0; $i < count( $stat->m_clientlist ); $i++ )
  {
  		$client = $stat->m_clientlist[ $i ];
		
  		if ( $client->m_cid != $cid )
			continue;
		
			
		$m->addContent("      <tr>\n");
		$m->addContent("        <td bgcolor=\"".$colors['cell_background']."\">");

		$flags = "";
		
		if ( $client->m_admin )
			$flags .= "A";
			
		if ( $client->m_phan )
			$flags .= "P";
			
		if ( strlen( $flags ) )
			$m->addContent("\"$flags\" ");
			
		$m->addContent($client->m_name);
		if ( $client->m_comm )
			$m->addContent(" ($client->m_comm)");
			
		$m->addContent("  </td>\n");
		$m->addContent("      </tr>\n");
  }
  
  // Display sub-channels for this channel.

  for ( $i = 0; $i < count( $stat->m_channellist ); $i++ )
  {
  		if ( $stat->m_channellist[ $i ]->m_pid == $cid )
		{
			$cn = $stat->m_channellist[ $i ]->m_name;
			if ( strlen( $stat->m_channellist[ $i ]->m_comm ) )
			{
				$cn .= " (";
				$cn .= $stat->m_channellist[ $i ]->m_comm;
				$cn .= ")";
			}
			
			VentriloDisplayEX1( $stat, $cn, $stat->m_channellist[ $i ]->m_cid, $bgidx + 1 );
		}
  }
  
  $m->addContent("      </table>\n");
  $m->addContent("    </td>\n");
  $m->addContent("  </tr>\n");
}

/*
	This example PHP script came with a file called ventriloreadme.txt and should
	be read if you are having problems making these scripts function properly.
	
	In it's current state this script is not usable. You MUST read the
	ventriloreadme.txt file if you do not know what needs to be changed.
	
	The location of the 'ventrilo_status' program must be accessible from
	PHP and what ever HTTP server you are using. This can be effected by
	PHP safemode and other factors. The placement, access rights and ownership
	of the file it self is your responsibility. Change to fit your needs.
*/

$stat = new CVentriloStatus;
$stat->m_cmdprog	= $m->db->getSetting("vent_path");	// Adjust accordingly.
$stat->m_cmdcode	= "2";					// Detail mode.
$stat->m_cmdhost	= $m->db->getSetting("vent_server");			// Assume ventrilo server on same machine.
$stat->m_cmdport	= $m->db->getSetting("vent_port");				// Port to be statused.
$stat->m_cmdpass	= $m->db->getSetting("vent_pass");					// Status password if necessary.

if (  $stat->Request() ){
	$m->addContent("<span onclick=\"javascript:errorMsg('CVentriloStatus->Request() failed. <strong>$stat->m_error</strong>')\">Error occurred. Click for details.</span>");
} else {

	if ($stat->m_clientcount != 0){
		$m->addContent("<center><table width=\"100%\" border=\"0\">\n");
		VentriloDisplayEX1( $stat, $stat->m_name, 0, 0 ,$m);
		$m->addContent("</table></center>\n");
	} else 
		$m->addContent("The Ventrilo server is lonely.");

}
if(isset($_GET['update']))	echo $m->getRawContent();

?>