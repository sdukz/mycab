<?php
include_once('configure.php');


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
			$driver = get_driver_name_image_by_id($post['driver_id']);
			$avgRat = get_driver_average_rating($post['driver_id']);

			$post     = array_push_assoc($post,'driver_name',$driver['driver_name']);
			$post     = array_push_assoc($post,'driver_image',$driver['driver_image']);
			$post     = array_push_assoc($post,'driver_average_rating',$avgRat);
			$posts['data'][]  = $post;
			
		}
		$posts['status']  = 1;
	}
	else
	{
		$posts = array('message'=>'Failure' ,'status'=>0);
	}		
}
else
{
    $posts = array('message'=>'Passanger Id And Ride Request Id Is Needed' ,'status'=>0);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>