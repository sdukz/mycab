<?php
include_once('configure.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$Current_date  = date("Y-m_d H:i:s");
$PassangerId   = $_POST['passanger_id'];
$RideRequestId = $_POST['ride_request_id'];



if(($PassangerId !='' && $RideRequestId !=''))
{
	$query = "SELECT * FROM ride_request WHERE passanger_id ='$PassangerId' AND ride_request_id='$RideRequestId' AND status =1";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		while($post = mysql_fetch_assoc($result))
		{
			$passanger = get_passanger_name_image_by_id($post['passanger_id']);
			$post   = array_push_assoc($post,'passanger_name',$passanger['passanger_name']);
			$post   = array_push_assoc($post,'passanger_image',$passanger['passanger_image']);
			$status = 1;
			$posts  = array('data' => $post ,'status'=>$status);
		}
	}
	else
	{
		$post  = array_push_assoc($post,'message','Invalid Passanger Or Ride Request Id');
		$status = 0;
	    $posts = array('data' => $post ,'status'=>$status);
	}		
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id And Request Is Needed');
	$status = 0;
	$posts = array('data' => $post ,'status'=>$status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>