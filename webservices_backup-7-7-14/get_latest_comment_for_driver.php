<?php
include_once('configure.php');

$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");
$DriverId     = $_POST['driver_id'];



if(($DriverId !=''))
{
	$query = "SELECT * FROM rate_review_driver WHERE driver_id ='$DriverId' AND status =1 ORDER BY created_date DESC";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		while($post = mysql_fetch_assoc($result))
		{
			$Passanger = get_passanger_detail_by_id($post['passanger_id']);
			$post  = array_push_assoc($post,'passanger_name',$Passanger['passanger_name']);
			$post  = array_push_assoc($post,'passanger_image',$Passanger['passanger_image']);
			
			$rating = get_driver_average_rating($DriverId);
			$post   = array_push_assoc($post,'average_rating',$rating);
			$posts[]  =  $post;
		}
	}
	else
	{
		$post  = array_push_assoc($post,'message','Driver Id Is Not Valid OR No Comment Available');
	    $posts[] =  $post;
	}		
}
else
{
	$post  = array_push_assoc($post,'message','Driver Id Is Needed');
	$posts[] =  $post;
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>