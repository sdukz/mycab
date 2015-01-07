<?php
include_once('configure.php');
include_once('notification.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");

$DriverId     = $_POST['driver_id'];
$RideReqId    = $_POST['ride_request_id'];
$Amount       = $_POST['amount'];
$TimeToGetPass= $_POST['time_to_get_passanger'];

$Balance      = ($Amount/100)*10;

$PassId       = get_passenger_id_by_ride_request_id($RideReqId);

$D            = get_driver_detail_by_id($DriverId);



if(($_POST['driver_id'] !=''))
{
	if(isset($D['balance']) && $D['balance'] >= $Balance)
	{
		$ridestatus = mysql_fetch_assoc(mysql_query('select status from ride_request where ride_request_id='.$RideReqId));
		if(!empty($ridestatus)){
			if( $ridestatus['status'] == 2){
					 $status = 4;
					 $post = array_push_assoc($post,'message','Driver has been chosen.');
					 $posts = array('data' => $post ,'status' => $status);
			}
			else{
			
			   $query = "INSERT INTO ride_responce (driver_id,ride_request_id,amount,time_to_get_passanger,created_date) 
			   VALUES 
			   ('$DriverId','$RideReqId','$Amount','$TimeToGetPass','$Current_date') ";
			//    exit;
			   $result= mysql_query($query);
			   $ins_id= mysql_insert_id();
				
					if($ins_id > 0 && $ins_id !='')
					{
						$loc ['loc-key'] = RIDE_RESPONCE; //Used for localization
						$loc ['loc-args']= array($D['driver_name']);
						//send_notification('ride_responce','ride_responce#Driver - '.$D['driver_name'].' responded on your ride.',$PassId);
						send_notification('ride_responce',$loc,$PassId);
						
					 $post = array_push_assoc($post,'message','Yes');
					 $post = array_push_assoc($post,'ride_responce_id',$ins_id);
					 $status = 1;
					 $posts = array('data' => $post ,'status' => $status);
					}
					else
					{
					 $status = 0;
					 $post = array_push_assoc($post,'message','No');
					 $posts = array('data' => $post ,'status' => $status);
					}
			}
		}else{
				$status = 0;
				 $post = array_push_assoc($post,'message','No ride request available.');
				 $posts = array('data' => $post ,'status' => $status);
		}
				
	}
   else
   	{
   		$status = 2;
   		$post  = array_push_assoc($post,'message','Your Balance Is Low');
	    $posts = array('data' => $post ,'status' => $status);
	}
}
else
{
	$status = 0;
	$post  = array_push_assoc($post,'message','Driver Id Needed');
	$posts = array('data' => $post ,'status' => $status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>