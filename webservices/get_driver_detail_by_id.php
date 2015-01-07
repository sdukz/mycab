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
$DriverId     = $_POST['driver_id'];



if(($DriverId !=''))
{
	$query = "SELECT 
	          `driver_id`, `email`,`driver_name`,`display_map`, `driver_image`, `mobile_no`, `latitude`, `longitude`, `taxi_no`,`licance_id`,
	           `taxi_model`, `taxi_color`, `no_of_seat`,`status`,`busy`,`luggage_carrier`, `child_seat`, `radious`,`balance`,
	           `min_search_amount`,`max_search_amount`, `device_type`,taxi_brand,taxi_year,extra_comment,`created_date`, `updated_date`  
	           FROM driver WHERE driver_id ='$DriverId' AND status =1";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		while($post = mysql_fetch_assoc($result))
		{
			$rating = get_driver_average_rating($DriverId);
			$post   = array_push_assoc($post,'average_rating',$rating);
			$status = 1;
			$posts  = array('data' => $post,'status'=>$status);
		}
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
				$posts['comments'][]  =  $post;
			}
			
		}
		else
		{
			$post  = array_push_assoc($post,'message','No Comment Available');
		    $posts['comments'][] =  $post;
			$status = 0;
			$posts['commentsstatus'] = $status;
		}		
	}
	else
	{
		$post  = array_push_assoc($post,'message','Driver Id Is Not Valid');
		$status = 0;
	    $posts = array('data' => $post,'status'=>$status);
	}		
}
else
{
	$post  = array_push_assoc($post,'message','Driver Id Is Needed');
	$status = 0;
	$posts = array('data' => $post,'status'=>$status);
}

/* output in necessary format */
if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>