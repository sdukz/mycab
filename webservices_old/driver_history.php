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
$driver_id     = $_POST['driver_id'];

if(($driver_id !=''))
{
	$query = "SELECT * FROM ride_confirm WHERE driver_id ='$driver_id' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count > 0 )
	{
		while($post = mysql_fetch_assoc($result))
		{
			$P = get_passanger_detail_by_id($post['passanger_id']);
			$D = get_driver_name_image_by_id($post['driver_id']);
			$R = get_passanger_rat_by_driver_by_confirm_id($post['ride_confirm_id']);
			
			$post['passanger_name'] = $P['passanger_name'];
			$post['passanger_image'] = $P['passanger_image'];
			$post['passanger_mobile_no'] = $P['mobile_no'];
			if(is_array($R))
			{
			$post['passanger_haz_rude'] = $R['haz_rude'];
			$post['passanger_cancled_order'] = $R['cancle_order'];
			$post['passanger_spoiled_interier'] = $R['spoiled_interier'];
			$post['did_not_come_to_car'] = $R['did_not_come_to_car'];
			}
			else
			{
				$post['passanger_haz_rude'] = 'Not commented';
			    $post['passanger_cancled_order'] = 'Not commented';
			    $post['passanger_spoiled_interier'] = 'Not commented';
			    $post['did_not_come_to_car'] = 'Not commented';				
			}
						
			$post['driver_name'] = $D['driver_name'];
			$post['driver_image'] = $D['driver_image'];
			
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
				$post['cancle']='By Me';
				
				if($post['cancle_by']=='Passanger')
				$post['cancle']='By Passanger';
				
				if($post['cancle_by']=='0')
				$post['cancle']='No';
				
				unset($post['cancle_by']);				
			}
			
			$posts[]=$post;
		}
	}
	else
	{
//		$post  = array_push_assoc($post,'message','No');
	    $posts[] = array('message' => 'No');
	}
	
}
else
{
//	$post  = array_push_assoc($post,'message','Driver Id Is Needed');
	$posts[] = array('message' => 'Driver Id Is Needed');
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