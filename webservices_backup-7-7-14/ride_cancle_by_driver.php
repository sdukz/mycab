<?php
include_once('configure.php');
include_once('notification.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$Current_date = date("Y-m_d H:i:s");
$DrivId   	  = $_POST['driver_id'];
$RideConId    = $_POST['ride_confirm_id'];

if(($DrivId !='' && $RideConId !=''))
{
   $query = "UPDATE ride_confirm SET cancle_by='Driver',updated_date='$Current_date' WHERE driver_id='$DrivId' AND ride_confirm_id='$RideConId'";
   $result= mysql_query($query);
   $aff_rw= mysql_affected_rows();
	
	if($aff_rw > 0 && $aff_rw !='')
	{
	 $C     = get_driver_or_passanger_id_by_ride_confirm_id($RideConId);
	 $D     = get_driver_name_image_by_id($DrivId);
	 send_notification('ride_cancle_by_driver','Driver -'.$D['driver_name'].' cancelled your ride.',$C['passanger_id']);
	 
	 $up_q_d = "UPDATE driver SET busy='No',updated_date='$Current_date' WHERE driver_id='$DrivId' ";
	 $up_r_d = mysql_query($up_q_d);
	 
	 $R_C_D= get_ride_confirm_detail_by_id($RideConId);
	 $up_q_req = "UPDATE ride_request SET status='2',updated_date='$Current_date' WHERE ride_request_id={$R_C_D['ride_request_id']} ";
	 $up_r_req = mysql_query($up_q_req);
	 $up_q_res = "UPDATE ride_responce SET status='2',updated_date='$Current_date' WHERE ride_responce_id={$R_C_D['ride_responce_id']} ";
	 $up_r_res = mysql_query($up_q_res);	 
	 
	 $AvgRat = get_driver_average_rating($DrivId);
	 $Amt    = 0;
	 $Res    = get_responce_detail_by_ride_responce_id($R_C_D['ride_responce_id']);
	 if($AvgRat < 2.5)
	 {
	 	$Amt    = ($Res['amount']/100)*20;
	 }
	 else if($AvgRat <=4 && $AvgRat >2.5)
	 {
	 	$Amt    = ($Res['amount']/100)*15;
	 }
	 else
	 {
		 $Amt    = ($Res['amount']/100)*10;
	 }
	 $up_q_amount ="UPDATE driver SET balance=(balance - $Amt),updated_date='$Current_date' WHERE driver_id='$DrivId'";
	 $up_r_amount = mysql_query($up_q_amount);
	 
	 $queryAdminEarn = "INSERT INTO admin_earn (passanger_id,driver_id,ride_request_id,ride_responce_id,ride_confirm_id,amount,created_date) VALUES 
	 					('{$C['passanger_id']}','$DrivId','{$R_C_D['ride_request_id']}','{$R_C_D['ride_responce_id']}','$RideConId','$Amt','$Current_date') ";
     $resultAdminEarn= mysql_query($queryAdminEarn);
	 
	 $posts = array('message' => 'Yes');
	}
	else
	{
	 $posts = array('message' => 'No');
	}	
}
else
{
	$posts = array('message' => 'Driver Id And Ride Confirm Id Is Needed');
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>