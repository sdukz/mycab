<?php
include_once('configure.php');
include_once('notification.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$Current_date = date("Y-m_d H:i:s");
$PassId   	  = $_POST['passanger_id'];
$RideConId    = $_POST['ride_confirm_id'];

if(($PassId !='' && $RideConId !=''))
{
   $query = "UPDATE ride_confirm SET cancle_by='Passanger',updated_date='$Current_date' WHERE passanger_id='$PassId' AND ride_confirm_id='$RideConId'";
   $result= mysql_query($query);
   $aff_rw= mysql_affected_rows();
	
	if($aff_rw > 0 && $aff_rw !='')
	{
	 $C     = get_driver_or_passanger_id_by_ride_confirm_id($RideConId);
	 $P     = get_passanger_name_image_by_id($PassId);
	 send_notification('ride_cancle_by_passanger','Passenger -'.$P['passanger_name'].' cancelled your ride.',$C['driver_id']);
	 
	 $up_q_d = "UPDATE driver SET busy='No',updated_date='$Current_date' WHERE driver_id='".$C['driver_id']."'";
	 $up_r_d = mysql_query($up_q_d);
	 
	 $R_C_D= get_ride_confirm_detail_by_id($RideConId);
	 $up_q_req = "UPDATE ride_request SET status='2',updated_date='$Current_date' WHERE ride_request_id={$R_C_D['ride_request_id']} ";
	 $up_r_req = mysql_query($up_q_req);
	 $up_q_res = "UPDATE ride_responce SET status='2',updated_date='$Current_date' WHERE ride_responce_id={$R_C_D['ride_responce_id']} ";
	 $up_r_res = mysql_query($up_q_res);
	 		 
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
	$post  = array_push_assoc($post,'message','Passanger Id And Ride Confirm Id Is Needed');
	$posts = array('post' => $post);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>