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
	 $status = 0;
	 $posts = array('data' => $post , 'status' => $status);		
	}
	else
	{
		
   $query = "INSERT INTO ride_confirm (passanger_id,driver_id,ride_request_id,ride_responce_id,created_date)
   		 VALUES 
   		 ('$PassId','$DrivId','$RideReqId','$RideResId','$Current_date') ";

   $result= mysql_query($query);
   $ins_id= mysql_insert_id();
	$R_C_D= get_ride_confirm_detail_by_id($ins_id);
		 $up_q_req = "UPDATE ride_request SET status='2',updated_date='$Current_date' WHERE ride_request_id={$R_C_D['ride_request_id']} ";
		 $up_r_req = mysql_query($up_q_req);
		 $up_q_res = "UPDATE ride_responce SET status='2',updated_date='$Current_date' WHERE ride_responce_id={$R_C_D['ride_responce_id']} ";
		 $up_r_res = mysql_query($up_q_res);
	if($ins_id > 0 && $ins_id !='')
	{
		$loc ['loc-key'] = RIDE_CONFIRM; //Used for localization
	 	$loc ['loc-args']= array($ins_id,$P['passanger_name']);
	 	
		//send_notification('ride_confirm',$ins_id.'#ride_confirm#Passenger -'.$P['passanger_name'].' confirmed your ride order.',$DrivId);
		send_notification('ride_confirm',$loc,$DrivId);
	 /*
	 $up_q = "UPDATE driver SET busy='Yes',balance=(balance - $Amt),updated_date='$Current_date' WHERE driver_id='$DrivId'";
					 $up_r = mysql_query($up_q);*/
	 	
	 $post = array_push_assoc($post,'message','Yes');
	 $post = array_push_assoc($post,'ride_confirm_id',$ins_id);
	 $status = 1;
	 $posts = array('data' => $post , 'status' => $status);
	}
	else
	{
	 $post = array_push_assoc($post,'message','No');
	 $status = 0;
	 $posts = array('data' => $post , 'status' => $status);
	}
	
	}	
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id And Ride Responce Id Is Needed');
	$status = 0;
	$posts = array('data' => $post , 'status' => $status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>