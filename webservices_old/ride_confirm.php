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

$PassId   = $_POST['passanger_id'];
$DrivId   = $_POST['driver_id'];
$RideReqId  = $_POST['ride_request_id'];
$RideResId  = $_POST['ride_responce_id'];

$P      = get_passanger_name_image_by_id($PassId);

$Res    = get_responce_detail_by_ride_responce_id($RideResId);
$Amt    = ($Res['amount']/100)*10;

if(($_POST['passanger_id'] !='' && $_POST['ride_responce_id'] !='' && $_POST['driver_id'] !=''))
{
	$Ds = check_driver_status_by_id($DrivId);
	if($Ds == 'Busy')
	{
	 $post = array_push_assoc($post,'message','Driver Bussy');
	 $posts = array('post' => $post);		
	}
	else
	{
		
   $query = "INSERT INTO ride_confirm (passanger_id,driver_id,ride_request_id,ride_responce_id,created_date) VALUES ('$PassId','$DrivId','$RideReqId','$RideResId','$Current_date') ";

   $result= mysql_query($query);
   $ins_id= mysql_insert_id();
	
	if($ins_id > 0 && $ins_id !='')
	{
		send_notification('ride_confirm','Passenger -'.$P['passanger_name'].' confirmed your ride order.',$DrivId);
	 $up_q = "UPDATE driver SET busy='Yes',balance=(balance - $Amt),updated_date='$Current_date' WHERE driver_id='$DrivId'";
	
	 $up_r = mysql_query($up_q);
	 
	 $queryAdminEarn = "INSERT INTO admin_earn (passanger_id,driver_id,ride_request_id,ride_responce_id,ride_confirm_id,amount,created_date) VALUES ('$PassId','$DrivId','$RideReqId','$RideResId','$ins_id','$Amt','$Current_date') ";
     $resultAdminEarn= mysql_query($queryAdminEarn);
	 	
	 $post = array_push_assoc($post,'message','Yes');
	 $post = array_push_assoc($post,'ride_confirm_id',$ins_id);
	 $posts = array('post' => $post);
	}
	else
	{
	 $post = array_push_assoc($post,'message','No');
	 $posts = array('post' => $post);
	}
	
	}	
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id And Ride Responce Id Is Needed');
	$posts = array('post' => $post);
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