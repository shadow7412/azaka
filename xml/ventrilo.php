<?php 
include_once "../include/userobject.php";
include_once "../include/ventrilostatus.php";
header("content-type: text/xml");

$u = new UserObject();

function VentriloDisplayEX1( &$stat, $name, $cid, $bgidx)
{
  global $colors; 
  $chan = $stat->ChannelFind( $cid );
  echo "<name>".$name."</name>";

  for ( $i = 0; $i < count( $stat->m_clientlist ); $i++ )
  {
  		$client = $stat->m_clientlist[ $i ];
		
  		if ( $client->m_cid != $cid )
			continue;
		
		echo "<user>";
		
		$flags = "";
		
		if ( $client->m_admin )
			$flags .= "A";
			
		if ( $client->m_phan )
			$flags .= "P";
			
		if ( strlen( $flags ) )
			echo "\"$flags\" ";
			
		echo $client->m_name;
		if ( $client->m_comm )
			echo " ($client->m_comm)";
			
		echo "</user>";
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
$stat->m_cmdprog	= $u->db->getSetting("vent_path");	// Adjust accordingly.
$stat->m_cmdcode	= "2";				            	// Detail mode.
$stat->m_cmdhost	= $u->db->getSetting("vent_server");// Assume ventrilo server on same machine.
$stat->m_cmdport	= $u->db->getSetting("vent_port");	// Port to be statused.
$stat->m_cmdpass	= $u->db->getSetting("vent_pass");	// Status password if necessary.

echo "<ventrilo>";

if (  $stat->Request() ){
	echo "<name>{$stat->m_error}</name>";
} else {
	if ($stat->m_clientcount == 0)
		echo "<user>The Ventrilo server is lonely</user>";
		VentriloDisplayEX1( $stat, $stat->m_name, 0, 0);
}

echo "</ventrilo>";
?>
