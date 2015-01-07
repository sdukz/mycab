<?php
include_once('configure.php');

$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");
//$Name    = $_POST['passanger_name'];
$DriverId   = $_POST['driver_id'];
$ResId      = $_POST['ride_responce_id'];



if(($DriverId !=''))
{
   $query = "SELECT * FROM ride_confirm WHERE driver_id=$DriverId AND ride_responce_id=$ResId AND status=1 ";
   $result= mysql_query($query);
   $count = mysql_num_rows($result);
	
	if($count > 0)
	{
		while($post = mysql_fetch_assoc($result))
		{
			$Passanger = get_passanger_detail_by_id($post['passanger_id']);
			$ReqDetail = get_request_detail_by_ride_reqest_id($post['ride_request_id']);
			
			$post  = array_push_assoc($post,'passanger_name',$Passanger['passanger_name']);
			$post  = array_push_assoc($post,'passanger_image',$Passanger['passanger_image']);
			$post  = array_push_assoc($post,'passanger_mobile_no',$Passanger['mobile_no']);
			$post  = array_push_assoc($post,'source_address',$ReqDetail['source_address']);
			$post  = array_push_assoc($post,'destination_address',$ReqDetail['destination_address']);
			$post  = array_push_assoc($post,'amount',$ReqDetail['amount']);
			$post  = array_push_assoc($post,'passanger_count',$ReqDetail['passanger_count']);
			
			$posts =  $post;
		}
	}
	else
	{
	 $post = array_push_assoc($post,'message','No');
	 $posts =  $post;
	}	
}
else
{
	$post  = array_push_assoc($post,'message','Driver Id Is Needed');
	$posts =  $post;
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