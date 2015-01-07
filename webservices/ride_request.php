<?php
include_once('configure.php');
include_once('notification.php');

$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");

$PassangerId    = $_POST['passanger_id'];
$SourceAdd      = $_POST['source_address'];
$SourceLati     = $_POST['source_latitude'];
$SourceLogi     = $_POST['source_longitude'];
$DestinationAdd = $_POST['destination_address'];
$DestinationLati= $_POST['destination_latitude'];
$DestinationLogi= $_POST['destination_longitude'];
$Amount         = $_POST['amount'];
$PassangerCount = $_POST['passanger_count'];
$ChildSeat      = $_POST['child_seat'];
$ExtraLugg      = $_POST['extra_luggage'];
$Smoker         = $_POST['smoker'];
$car_type         = $_POST['car_type'];
$ac         = $_POST['ac'];
$comments         = $_POST['comments'];
if(isset($_POST['from_date'])){
	$from_date         = $_POST['from_date'];
}else{
	$from_date         = '';
}
if(isset($_POST['to_date'])){
	$to_date        = $_POST['to_date'];
}else{
	$to_date        = '';
}

if(($_POST['passanger_id'] !=''))
{
   $query = "INSERT INTO ride_request (passanger_id,source_address,source_latitude,source_longitude,destination_address,
   destination_latitude,destination_longitude,amount,passanger_count,extra_luggage,child_seat,smoker,ac,car_type,comments,from_date,to_date,created_date,status) 
   VALUES 
   ('$PassangerId','$SourceAdd','$SourceLati','$SourceLogi','$DestinationAdd','$DestinationLati','$DestinationLogi','$Amount',
    '$PassangerCount','$ExtraLugg','$ChildSeat','$Smoker','$ac','$car_type','$comments','$from_date','$to_date','$Current_date',1) ";
   
   $result= mysql_query($query);
   $ins_id= mysql_insert_id();

	if($ins_id > 0 && $ins_id !='')
	{
		
	 $driver_ids = get_driver_id_for_ride_order($SourceLati,$SourceLogi,$Amount,$ChildSeat,$ExtraLugg,$PassangerCount);
	 
	 $loc ['loc-key'] = RIDE_REQUEST; //Used for localization
	 $loc ['loc-args']= array();
	 //send_notification('ride_request','ride_request#New request in your range.',$driver_ids);
	 send_notification('ride_request',$loc,$driver_ids);
		
	 $post = array_push_assoc($post,'message','Yes');
	 $post = array_push_assoc($post,'ride_request_id',$ins_id);
	 $status = 1;
	 $posts = array('data' => $post ,'status'=>$status);
	}
	else
	{
	 $post = array_push_assoc($post,'message','No');
	 $status = 0;
	 $posts = array('data' => $post ,'status'=>$status);
	}	
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id Needed');
	$status = 0;
	$posts = array('data' => $post ,'status'=>$status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>