<?php
include_once('configure.php');

$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$Current_date = date("Y-m_d H:i:s");
$PassId       = $_POST['passanger_id'];
$page         = ($_POST['page']=='') ? 1 : $_POST['page'];
$totalRec     = '';
$end     	  = '';
$start     	  = '';   

if(($PassId !=''))
{
	$queryCount = "SELECT * FROM ride_confirm WHERE passanger_id ='$PassId' ";
	$resultCount= mysql_query($queryCount);
	$count = mysql_num_rows($resultCount);
	if($count > 0 )
	{
		$totalRec = ceil($count/10); 
	
		$end      = ($page*10);
		$start    = ($end - 10);
	
		$query = "SELECT * FROM ride_confirm WHERE passanger_id ='$PassId' LIMIT $start,$end";
		$result= mysql_query($query);
		
		while($post = mysql_fetch_assoc($result))
		{
			$P = get_passanger_name_image_by_id($post['passanger_id']);
			$D = get_driver_detail_by_id($post['driver_id']);
			$Ar= get_driver_average_rating($post['driver_id']);
			
			$post['passanger_name'] = $P['passanger_name'];
			$post['passanger_image'] = $P['passanger_image'];
			
			$post['driver_name'] = $D['driver_name'];
			$post['driver_image'] = $D['driver_image'];
			$post['driver_mobile_no'] = $D['mobile_no'];
			$post['taxi_no'] = $D['taxi_no'];
			$post['licance_id'] = $D['licance_id'];
			$post['taxi_model'] = $D['taxi_model'];
			$post['driver_average_rating'] = $Ar;
			
			$DriveS = get_drive_status($post['ride_confirm_id']);			
			$post['drive_status'] = $DriveS;
			
			$Req = get_request_detail_by_ride_reqest_id($post['ride_request_id']);
			$post['source_address'] = $Req['source_address'];
			$post['destination_address'] = $Req['destination_address'];
			$post['source_latitude'] = $Req['source_latitude'];
			$post['source_longitude']= $Req['source_longitude'];
			$post['destination_latitude'] = $Req['destination_latitude'];
			$post['destination_longitude']= $Req['destination_longitude'];
			
			$Res = get_responce_detail_by_ride_responce_id($post['ride_responce_id']);
			$post['amount'] = $Res['amount'];
			
			if(array_key_exists('cancle_by', $post))
			{
				if($post['cancle_by'] =='Driver')
				$post['cancle']='By Driver';
				
				if($post['cancle_by']=='Passanger')
				$post['cancle']='By Me';
				
				if($post['cancle_by']=='0')
				$post['cancle']='No';
				
				unset($post['cancle_by']);				
			}
			
			if($count > $end)
				{
					$post = array_push_assoc($post, 'next', 'yes');
				}
			else 
				{
					$post = array_push_assoc($post, 'next', 'no');
				}
			$posts[]=$post;
		}
	}
	else
	{
		$posts[] = array('message' => 'No');
	}
	
}
else
{
	$posts[] = array('message' => 'Passanger Id Is Needed');
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>