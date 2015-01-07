<?php
include_once('configure.php');
include_once('notification.php');

/*
echo"<pre>";
print_r($_POST);
exit;
*/

$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");

$DrivId   = $_POST['driver_id'];
$RideConId  = $_POST['ride_confirm_id'];

if(($DrivId !='' && $RideConId !=''))
{
   $query = "UPDATE ride_confirm SET cancle_by='Driver' WHERE driver_id='$DrivId' AND ride_confirm_id='$RideConId'";
   $result= mysql_query($query);
   $aff_rw= mysql_affected_rows();
	
	if($aff_rw > 0 && $aff_rw !='')
	{
	 $C     = get_driver_or_passanger_id_by_ride_confirm_id($RideConId);
	 $D     = get_driver_name_image_by_id($DrivId);
	 send_notification('ride_cancle_by_driver','Driver -'.$D['driver_name'].' cancelled your ride.',$C['passanger_id']);
	 
	 $up_q = "UPDATE driver SET busy='No' WHERE driver_id='$DrivId";
	 $up_r = mysql_query($up_q);
	 
	 $R_C_D= get_ride_confirm_detail_by_id($RideConId);
	 $up_q = "UPDATE ride_request SET status='2' WHERE ride_request_id={$R_C_D['ride_request_id']} ";
	 $up_r = mysql_query($up_q);
	 $up_q = "UPDATE ride_responce SET status='2' WHERE ride_responce_id={$R_C_D['ride_responce_id']} ";
	 $up_r = mysql_query($up_q);	 
	 
	 	
//	 $post  = array_push_assoc($post,'message','Yes');
	 $posts = array('message' => 'Yes');
	}
	else
	{
//	 $post = array_push_assoc($post,'message','No');
	 $posts = array('message' => 'No');
	}	
}
else
{
//	$post  = array_push_assoc($post,'message','Driver Id And Ride Confirm Id Is Needed');
	$posts = array('message' => 'Driver Id And Ride Confirm Id Is Needed');
}

/* output in necessary format */
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>