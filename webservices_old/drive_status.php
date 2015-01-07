<?php
include_once('configure.php');

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
		$up_q = "UPDATE ride_request SET busy='No' WHERE driver_id='$DrivId";
	    $up_r = mysql_query($up_q);
		
	 $R_C_D= get_ride_confirm_detail_by_id($RideConId);
	 $up_q = "UPDATE ride_request SET status='2' WHERE ride_request_id={$R_C_D['ride_request_id']} ";
	 $up_r = mysql_query($up_q);
	 $up_q = "UPDATE ride_responce SET status='2' WHERE ride_responce_id={$R_C_D['ride_responce_id']} ";
	 $up_r = mysql_query($up_q);
		
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
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>