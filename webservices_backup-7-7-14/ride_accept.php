<?php
include_once('configure.php');
include_once('notification.php');

$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");

$PassId   = $_POST['passanger_id'];
$DrivId   = $_POST['driver_id'];
$RideConId  = $_POST['ride_confirm_id'];

if(($_POST['passanger_id'] !='' && $_POST['driver_id'] !=''))
{
   $query = "UPDATE ride_confirm SET driver_accept='Yes' WHERE driver_id='$DrivId' AND passanger_id='$PassId' AND ride_confirm_id='$RideConId'";
   $result= mysql_query($query);
   $aff_rw= mysql_affected_rows();
	
	if($aff_rw > 0 && $aff_rw !='')
	{
		$D  = get_driver_name_image_by_id($DrivId);
		send_notification('ride_accept','Driver - '.$D['driver_name'].' arrived on source location.',$PassId);
		
	 $post = array_push_assoc($post,'message','Yes');
	 $posts = array('post' => $post);
	}
	else
	{
	 $post = array_push_assoc($post,'message','No');
	 $posts = array('post' => $post);
	}	
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id And Driver Id Is Needed');
	$posts = array('post' => $post);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>