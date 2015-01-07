<?php
include_once('configure.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$Current_date  = date("Y-m_d H:i:s");
$PassId   	   = $_POST['passanger_id'];
$DrivId   	   = $_POST['driver_id'];
$RideConId     = $_POST['ride_confirm_id'];
$DriveStatus   = $_POST['drive_status'];


if($_POST['driver_id'] !='' && $PassId !='' && $RideConId !='')
{
   $query = "INSERT INTO drive_status(passanger_id,driver_id,ride_confirm_id,drive_status,created_date) VALUES
             ('$PassId','$DrivId','$RideConId','$DriveStatus','$Current_date')";
   $result= mysql_query($query);
   $ins_id= mysql_insert_id();
	
	if($ins_id > 0 && $ins_id !='')
	{
	   $up_q = "UPDATE driver SET busy='No',updated_date='$Current_date' WHERE driver_id='$DrivId' ";
       $up_r = mysql_query($up_q);
		
	 $R_C_D= get_ride_confirm_detail_by_id($RideConId);
	 $up_q_req = "UPDATE ride_request SET status='2',updated_date='$Current_date' WHERE ride_request_id={$R_C_D['ride_request_id']} ";
	 $up_r_res = mysql_query($up_q_req);
	 $up_q_res = "UPDATE ride_responce SET status='2',updated_date='$Current_date' WHERE ride_responce_id={$R_C_D['ride_responce_id']} ";
	 $up_r_res = mysql_query($up_q_res);
	 
	 $AvgRat   = get_driver_average_rating($DrivId);
	 $Amt      = 0;
	 $Res      = get_responce_detail_by_ride_responce_id($R_C_D['ride_responce_id']);
	// $Amt    = ($Res['amount']/100)*10;
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
	 					('$PassId','$DrivId','{$R_C_D['ride_request_id']}','{$R_C_D['ride_responce_id']}','$RideConId','$Amt','$Current_date') ";
     $resultAdminEarn= mysql_query($queryAdminEarn);
		
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
	$post  = array_push_assoc($post,'message','Driver Id And Passanger Id And Ride Confirm Id Is Needed');
	$posts = array('post' => $post);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>