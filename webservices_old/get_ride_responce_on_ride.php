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
$PassangerId     = $_POST['passanger_id'];
$RideReqId       = $_POST['ride_request_id'];



if(($PassangerId !='' || $RideRqId !=''))
{
	$query = "SELECT * FROM ride_responce WHERE ride_request_id ='$RideReqId' AND status =1";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		while($post = mysql_fetch_assoc($result))
		{
//			print_r($post);
//			exit;
			$driver = get_driver_name_image_by_id($post['driver_id']);
			$avgRat = get_driver_average_rating($post['driver_id']);
		
//			print_r($driver_name);
//			exit;
			$post     = array_push_assoc($post,'driver_name',$driver['driver_name']);
			$post     = array_push_assoc($post,'driver_image',$driver['driver_image']);
			$post     = array_push_assoc($post,'driver_average_rating',$avgRat);
			$posts[]  = $post;
		}
	}
	else
	{
//		$post  = array_push_assoc($post,'message','Failure');
//	    $posts[] = $post;
		$posts[] = array('message'=>'Failure');
	}		
}
else
{
//	$post  = array_push_assoc($post,'message','Passanger Id And Ride Request Id Is Needed');
//	$posts[] = $post;
    $posts[] = array('message'=>'Passanger Id And Ride Request Id Is Needed');
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