<?php
include_once('configure.php');

$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");
$passanger_id     = $_POST['passanger_id'];



if(($passanger_id !=''))
{
	$query = "SELECT * FROM rate_review_passanger WHERE passanger_id ='$passanger_id' AND status =1 ORDER BY created_date DESC";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		while($post = mysql_fetch_assoc($result))
		{
			$Passanger = get_driver_detail_by_id($post['driver_id']);
			$post  = array_push_assoc($post,'driver_name',$Passanger['driver_name']);
			$post  = array_push_assoc($post,'driver_image',$Passanger['driver_image']);
			
			$rating = get_passanger_average_rating($passanger_id);
			$post   = array_push_assoc($post,'passanger_average_rating',$rating);
			$posts['data'][]  =  $post;
		}
		$status = 1;
		$posts['status'] = $status;
	}
	else
	{
		$post  = array_push_assoc($post,'message','Passanger Id Is Not Valid OR No Comment Available');
	    $posts['data'] =  $post;
		$status = 0;
		$posts['status'] = $status;
	}		
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id Is Needed');
	$posts['data'] =  $post;
	$status = 0;
	$posts['status'] = $status;
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>