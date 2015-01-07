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
	$driverdata = mysql_fetch_assoc(mysql_query("SELECT `driver_id`,`display_map`,`driver_name`,`latitude`,`longitude`,`radious` FROM driver WHERE status=1 AND (busy='No' or busy='')  AND driver_id=".$DriverId));
	$driverdata['display_map'];
	if($driverdata['display_map'] == 1 ){	
		//$query = "SELECT * FROM ride_request WHERE driver_id ='$DriverId' AND status =1";
		$query = "SELECT *,(((ACOS( SIN( ".$driverdata['latitude']." * PI( ) /180 ) * SIN( `source_latitude` * PI( ) /180 ) + COS( ".$driverdata['latitude']." * PI( ) /180 ) *
			     COS( `source_latitude` * PI( ) /180 ) * COS( ( ".$driverdata['longitude']." - `source_longitude` ) * PI( ) /180 ) ) *180 / PI( )) *60 * 1.1515) * 1.60934) 
			     AS distance FROM ride_request WHERE status=1 HAVING distance <= ".$driverdata['radious']." order by created_date DESC";
		$result= mysql_query($query);
		if(isset($result) && !empty($result)){
			$count = mysql_num_rows($result);
		}else{
			$count = 0;
		}
		
		if($count >0)
		{
			while($posting = mysql_fetch_assoc($result))
			{
				$query2= "SELECT passanger_name,passanger_image FROM passanger WHERE passanger_id ='".$posting['passanger_id']."' AND status =1";
				$result2= mysql_fetch_assoc(mysql_query($query2));
				if(!empty($result2['passanger_name'])){
				$posting['passanger_name'] = $result2['passanger_name'];
				}else{
					$posting['passanger_name'] = '';
				}
				if(!empty($result2['passanger_image'])){
					$posting['passanger_image'] = $result2['passanger_image'];
				}else{
					$posting['passanger_image'] = '';
				}
				
				$posting['avg_rating'] = get_passanger_average_rating($posting['passanger_id']);
				$posting['total_rating'] = get_passanger_total_rating($posting['passanger_id']);
				
				$posting['total_rides_of_passanger']  = get_passanger_total_rides($posting['passanger_id']);
				$posting['haz_rude']  = get_total_times_haz_rude($posting['passanger_id']);
				$posting['poiled_interier']  = get_total_times_spoiled_interier($posting['passanger_id']);
				$posting['did_not_come_to_car']  = get_total_times_did_not_come_to_car($posting['passanger_id']);
				$posting['cancel_orders']  = get_total_times_cancled_order($posting['passanger_id']);
					
					
				$post[]=$posting;
			}
			$status = 1;
			$posts  = array('data' => $post,'status'=>$status);
			
		}
		else
		{
			$post  = array_push_assoc($post,'message','No Passanger request found');
			$status = 0;
		    $posts = array('data' => $post,'status'=>$status);
		}	
	}else
	{
		$post  = array_push_assoc($post,'message','No Passanger request found');
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