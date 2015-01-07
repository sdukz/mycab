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

$D = get_driver_detail_by_id($DrivId);

if(($_POST['passanger_id'] !='' && $_POST['driver_id'] !=''))
{
   $query = "UPDATE ride_confirm SET driver_accept='Yes',updated_date = NOW() WHERE driver_id='$DrivId' AND passanger_id='$PassId' AND ride_confirm_id='$RideConId'";
   $result= mysql_query($query);
   $aff_rw= mysql_affected_rows();
	
	if($aff_rw > 0 && $aff_rw !='')
	{
		$R_C_D= get_ride_confirm_detail_by_id($RideConId);
		 $up_q_req = "UPDATE ride_request SET status='2',updated_date='$Current_date' WHERE ride_request_id={$R_C_D['ride_request_id']} ";
		 $up_r_req = mysql_query($up_q_req);
		 $up_q_res = "UPDATE ride_responce SET status='2',updated_date='$Current_date' WHERE ride_responce_id={$R_C_D['ride_responce_id']} ";
		 $up_r_res = mysql_query($up_q_res);
		 
		 $loc ['loc-key'] = DRIVER_ARRIVED; //Used for localization
	 	 $loc ['loc-args']= array($D['driver_name']);	
	 	 
		 //send_notification('ride_accept','driver_arrived#Driver - '.$D['driver_name'].' arrived on source location.',$PassId);
		 send_notification('ride_accept',$loc,$PassId);
		
		 $post = array_push_assoc($post , 'message','Yes');
		 $status = 1;
		 $posts = array('data' => $post , 'status' => $status);
	}
	else
	{
		 $post = array_push_assoc($post , 'message','No');
		 $status = 0;
		 $posts = array('data' => $post , 'status' => $status);
	}	
}
else
{
		$post  = array_push_assoc($post , 'message','Passanger Id And Driver Id Is Needed');
		$status = 0;
		$posts = array('data' => $post , 'status' => $status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

/* disconnect from the db */
@mysql_close($con);

?>