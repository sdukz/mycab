<?php
include_once('configure.php');

$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$Current_date = date("Y-m_d H:i:s");

//SELECT ride_request.* FROM ride_request LEFT OUTER JOIN ride_responce ON ride_request.ride_request_id = ride_responce.ride_request_id WHERE ride_responce.ride_request_id IS null
$query_reses = "SELECT ride_request.* FROM ride_request LEFT OUTER JOIN ride_responce ON ride_request.ride_request_id = ride_responce.ride_request_id WHERE ride_responce.ride_request_id IS null";
$result_reses= mysql_query($query_reses);

while($data = mysql_fetch_assoc($result_reses)){
	
	$today = date("Y-m-d H:i");
	if($data['from_date'] != '' || $data['from_date'] != '0000-00-00 00:00:00'){
		$expire = $data['from_date'];
 	}else{
		$expire = $data['created_date']; //from db
	}
	
	$today_time = strtotime($today);
	$expire_time = strtotime($expire);

	if ($expire_time < $today_time) {
		
		   $query_res = "DELETE FROM ride_request WHERE  ride_request_id='".$data['ride_request_id']."'";
		   $result_res= mysql_query($query_res);
		   $aff_res   = mysql_affected_rows();
		  
	}

}


//* disconnect from the db */
@mysql_close($con);

?>