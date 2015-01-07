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


if(($_POST['passanger_id'] !=''))
{
   $query = "INSERT INTO ride_request (passanger_id,source_address,source_latitude,source_longitude,destination_address,
   destination_latitude,destination_longitude,amount,passanger_count,extra_luggage,child_seat,smoker,created_date) 
   VALUES 
   ('$PassangerId','$SourceAdd','$SourceLati','$SourceLogi','$DestinationAdd','$DestinationLati','$DestinationLogi','$Amount',
    '$PassangerCount','$ExtraLugg','$ChildSeat','$Smoker','$Current_date') ";
   
   $result= mysql_query($query);
   $ins_id= mysql_insert_id();

	if($ins_id > 0 && $ins_id !='')
	{
		
	 $driver_ids = get_driver_id_for_ride_order($SourceLati,$SourceLogi,$Amount,$ChildSeat,$ExtraLugg,$PassangerCount);
	 
	 send_notification('ride_request','New request in your range.',$driver_ids);
		
	 $post = array_push_assoc($post,'message','Yes');
	 $post = array_push_assoc($post,'ride_request_id',$ins_id);
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
	$post  = array_push_assoc($post,'message','Passanger Id Needed');
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