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
$VerifiCode   = $_POST['verification_code'];


if(($DriverId !='' && $VerifiCode !=''))
{
	$query = "SELECT * FROM driver WHERE driver_id ='$DriverId' AND verification_code ='$VerifiCode' AND status=0 ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count > 0 )
	{
		$up_query = "UPDATE driver SET status = 1 ,updated_date='$Current_date' WHERE driver_id ='$DriverId' AND verification_code ='$VerifiCode'";
		$up_result= mysql_query($up_query);
		$affect   = mysql_affected_rows();
		
		if($affect >0)
		{
			$query = "SELECT 
	          `driver_id`, `driver_name`, `driver_image`, `mobile_no`, `latitude`, `longitude`, `taxi_no`,`licance_id`,
	           `taxi_model`, `taxi_color`, `no_of_seat`,`status`,`busy`,`luggage_carrier`, `child_seat`, `radious`,`balance`,
	           `min_search_amount`,`max_search_amount`, `device_type`,taxi_brand,taxi_year,extra_comment,`created_date`, `updated_date`,`display_map`   
	           FROM driver WHERE driver_id ='$DriverId' AND status =1";
			$result= mysql_fetch_assoc(mysql_query($query));
			$rating = get_driver_average_rating($DriverId);
			$result['average_rating']= $rating;		
			$result['message'] = 'yes';	
		    $post = array_push_assoc($post,'message',$result);
			$status = 1;
	        $posts = array('data' => $post,'status'=>$status);
		}
		else
		{
			$post = array_push_assoc($post,'message','No');
			$status = 0;
	        $posts = array('data' => $post,'status'=>$status);			
		}
	}
	else
	{
		$post  = array_push_assoc($post,'message','No Driver Found With This Verification Code');
		$status = 0;
	    $posts = array('data' => $post,'status'=>$status);
	}
	
}
else
{
	$post  = array_push_assoc($post,'message','Driver Id and Verification Code Is Needed');
	$status = 0;
	$posts = array('data' => $post,'status'=>$status);
}

/* output in necessary format */
if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>