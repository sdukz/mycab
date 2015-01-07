<?php
include_once('configure.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$Current_date = date("Y-m_d H:i:s");
$driver_id    = $_POST['driver_id'];
$page         = ($_POST['page']=='') ? 1 : $_POST['page'];
$totalRec     = '';
$end     = '';
$start     = '';

if(($driver_id !=''))
{
	$queryCount = "SELECT * FROM ride_confirm WHERE driver_id ='$driver_id'";
	$resultCount= mysql_query($queryCount);
	$count = mysql_num_rows($resultCount);
	if($count > 0 )
	{
					
		$totalRec = ceil($count/50); 
	
		$end      = ($page*50);
		$start    = ($end - 50);
	
		$query = "SELECT * FROM ride_confirm WHERE driver_id ='$driver_id' group by created_date order by created_date DESC LIMIT $start,$end";
		$result= mysql_query($query);
			
		while($post = mysql_fetch_assoc($result))
		{
			$date = $post['created_date'];
			$time=strtotime($date);
			$month=date("F",$time);
			
			$P = get_passanger_detail_by_id($post['passanger_id']);
			$D = get_driver_name_image_by_id($post['driver_id']);
			$R = get_passanger_rat_by_driver_by_confirm_id($post['ride_confirm_id']);
						
			$post['passanger_name'] = $P['passanger_name'];
			$post['passanger_image'] = $P['passanger_image'];
			$post['passanger_mobile_no'] = $P['mobile_no'];
			if(is_array($R))
			{
				$post['passanger_haz_rude'] = ($R['haz_rude'] !='(null)' || $R['naz_rude'] !='') ? 1 : 0;
				$post['passanger_cancled_order'] = ($R['cancel_order'] =='(null)' || $R['cancel_order'] =='') ? 0 : 1;
				$post['passanger_spoiled_interier'] = ($R['spoiled_interier'] =='(null)' || $R['spoiled_interier'] =='') ? 0 : 1;
				$post['did_not_come_to_car'] = ($R['did_not_come_to_car'] =='(null)' || $R['did_not_come_to_car'] =='') ? 0 : 1;			
			}
			else
			{
				$post['passanger_haz_rude'] = '0';
			    $post['passanger_cancled_order'] = '0';
			    $post['passanger_spoiled_interier'] = '0';
			    $post['did_not_come_to_car'] = '0';				
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
				
				if($post['cancle_by']=='0' || $post['cancle_by']=='')
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
			
			if($month == 'January'){
				$posts['data'][$month][]=$post;
				$January = 1;
			}
			if($month == 'February'){
				$posts['data'][$month][]=$post;
				$February = 1;
			}
			if($month == 'March'){
				$posts['data'][$month][]=$post;
				$March = 1;
			}
			if($month == 'April'){
				$posts['data'][$month][]=$post;
				$April = 1;
			}
			if($month == 'May'){
				$posts['data'][$month][]=$post;
				$May = 1;
			}
			if($month == 'June'){
				$posts['data'][$month][]=$post;
				$June = 1;
			}
			if($month == 'July'){
				$posts['data'][$month][]=$post;
				$July = 1;
			}
			if($month == 'August'){
				$posts['data'][$month][]=$post;
				$August = 1;
			}
			if($month == 'September'){
				$posts['data'][$month][]=$post;
				$September = 1;
			}
			if($month == 'October'){
				$posts['data'][$month][]=$post;
				$October = 1;
			}
			if($month == 'November'){
				$posts['data'][$month][]=$post;
				$November = 1;
			}
			if($month == 'December'){
				$posts['data'][$month][]=$post;
				$December = 1;
			}
			
			
		}
		if($January != 1){
			$posts['data']['January'][] = array('message' => 'No History');
		}
		if($February != 1){
			$posts['data']['February'][] = array('message' => 'No History');
		}
		if($March != 1){
			$posts['data']['March'][] = array('message' => 'No History');
		}
		if($April != 1){
			$posts['data']['April'][] = array('message' => 'No History');
		}
		if($May != 1){
			$posts['data']['May'][] = array('message' => 'No History');
		}
		if($June != 1){
			$posts['data']['June'][] = array('message' => 'No History');
		}
		if($July != 1){
			$posts['data']['July'][] = array('message' => 'No History');
		}
		if($August != 1){
			$posts['data']['August'][] = array('message' => 'No History');
		}
		if($September != 1){
			$posts['data']['September'][] = array('message' => 'No History');
		}
		if($October != 1){
			$posts['data']['October'][] = array('message' => 'No History');
		}
		if($November != 1){
			$posts['data']['November'][] = array('message' => 'No History');
		}
		if($December != 1){
			$posts['data']['December'][] = array('message' => 'No History');
		}
		
		$posts['data']['status']=1;

	}
	else
	{
		$status = 0;
	    $posts['data'] = array('message' => 'No' , 'status' => $status);
	}
	
}
else
{
	$status = 0;
	$posts['data'] = array('message' => 'Driver Id Is Needed'  , 'status' => $status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>