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
$ride_request_id     = $_POST['ride_request_id'];



if(($ride_request_id !=''))
{
	$query = "SELECT * FROM ride_responce WHERE ride_request_id ='$ride_request_id' AND status =1";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		while($posting = mysql_fetch_assoc($result))
		{
			$query2= "SELECT driver_name,driver_image FROM driver WHERE driver_id ='".$posting['driver_id']."' AND status =1";
			$result2= mysql_fetch_assoc(mysql_query($query2));
			$posting['driver_name'] = $result2['driver_name'];
			$posting['driver_image'] = $result2['driver_image'];
			$posting['avg_rating'] = get_driver_average_rating($posting['driver_id']);
			$posting['total_rating'] = get_driver_total_rating($posting['driver_id']);
				
			$post[]=$posting;
		}
		$status = 1;
		$posts  = array('data' => $post,'status'=>$status);
		
	}
	else
	{
		$post  = array_push_assoc($post,'message','Request Id Is Not Valid');
		$status = 0;
	    $posts = array('data' => $post,'status'=>$status);
	}		
}
else
{
	$post  = array_push_assoc($post,'message','Request Id Is Needed');
	$status = 0;
	$posts = array('data' => $post,'status'=>$status);
}

/* output in necessary format */
if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);
?>