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

$DriverId     = $_POST['driver_id'];
$RideReqId    = $_POST['ride_request_id'];
$Amount       = $_POST['amount'];
$TimeToGetPass= $_POST['time_to_get_passanger'];

$Balance      = ($Amount/100)*10;

$PassId       = get_passenger_id_by_ride_request_id($RideReqId);

$D            = get_driver_detail_by_id($DriverId);



if(($_POST['driver_id'] !=''))
{
	if($D['balance'] >= $Balance)
	{
		
   $query = "INSERT INTO ride_responce (driver_id,ride_request_id,amount,time_to_get_passanger,created_date) 
   VALUES 
   ('$DriverId','$RideReqId','$Amount','$TimeToGetPass','$Current_date') ";
//    exit;
   $result= mysql_query($query);
   $ins_id= mysql_insert_id();
	
	if($ins_id > 0 && $ins_id !='')
	{
		
		send_notification('ride_responce','Driver -'.$D['driver_name'].' responded on your ride.',$PassId);
		
	 $post = array_push_assoc($post,'message','Yes');
	 $post = array_push_assoc($post,'ride_responce_id',$ins_id);
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
   		$post  = array_push_assoc($post,'message','Your Balance Is Low');
	    $posts = array('post' => $post);
	}
}
else
{
	$post  = array_push_assoc($post,'message','Driver Id Needed');
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