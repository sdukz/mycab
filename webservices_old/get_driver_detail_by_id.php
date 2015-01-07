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
	          `driver_id`, `driver_name`, `driver_image`, `mobile_no`, `latitude`, `longitude`, `taxi_no`,`licance_id`, `taxi_model`, `taxi_color`, `no_of_seat`,`busy`,`luggage_carrier`, `child_seat`, `radious`,`balance`,`min_search_amount`,`max_search_amount`, `device_type`, `device_token`, `status`, `verification_code`, `created_date`, `updated_date`  
	           FROM driver WHERE driver_id ='$DriverId' AND status =1";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		while($post = mysql_fetch_assoc($result))
		{
			$rating = get_driver_average_rating($DriverId);
			$post   = array_push_assoc($post,'average_rating',$rating);
			$posts  = array('post' => $post);
		}
	}
	else
	{
		$post  = array_push_assoc($post,'message','Driver Id Is Not Valid');
	    $posts = array('post' => $post);
	}		
}
else
{
	$post  = array_push_assoc($post,'message','Driver Id Is Needed');
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