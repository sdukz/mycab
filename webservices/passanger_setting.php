<?php

include('configure.php');

$post  = array();
$posts = array();
$format= 'json';
$Current_date = date("Y-m-d H:i:s");

/*if(array_key_exists('passanger_image',$_POST))
   {
	    $imgstring = $_POST['passanger_image'];
        $_POST['passanger_image']= strlen($_POST['passanger_image']) ?  save_image(trim($imgstring)) : '';
   }*/
if($_POST['passanger_id']!='')
{
	$passanger_id      = $_POST['passanger_id'];
	$driver_id      = $_POST['driver_id'];
	$source_address      = $_POST['source_address'];
	$source_latitude        = $_POST['source_latitude'];
	$source_longitude      = $_POST['source_longitude'];
	$destination_address      = $_POST['destination_address'];
	$destination_latitude       = $_POST['destination_latitude'];
	$destination_longitude      = $_POST['destination_longitude'];
	$amount      = $_POST['amount'];
	$passanger_count       = $_POST['passanger_count'];
	$extra_luggage      = $_POST['extra_luggage'];
	$child_seat      = $_POST['child_seat'];
	$smoker      = $_POST['smoker'];
	$ac    = $_POST['ac'];
	$status      = $_POST['status'];
	$comments = $_POST['comments'];

    $query = "INSERT INTO ride_request SET passanger_id='$passanger_id',driver_id='$driver_id',source_address='$source_address',
	          source_latitude='$source_latitude',source_longitude='$source_longitude',
	          destination_address='$destination_address',destination_latitude='$destination_latitude',
	          destination_longitude='$destination_longitude',amount='$amount',
	          passanger_count='$passanger_count',extra_luggage='$extra_luggage',
	          child_seat='$child_seat',smoker='$smoker',ac='$ac',comments='$comments',
	          status='$status',created_date = '$Current_date' , updated_date = '$Current_date'";
	$result= mysql_query($query);
	$affect= mysql_affected_rows();
	if($result){
		$query = "SELECT * FROM passanger WHERE passanger_id ='$passanger_id' AND status =1";
		$result= mysql_query($query);
		
		
		
			$results = mysql_fetch_assoc($result);
			
			$TotalRides  = get_passanger_total_rides($passanger_id);
			$TotalHazRu  = get_total_times_haz_rude($passanger_id);
			$TotalSpoIn  = get_total_times_spoiled_interier($passanger_id);
			$TotalNtC2C  = get_total_times_did_not_come_to_car($passanger_id);
			$TotalCanOr  = get_total_times_cancled_order($passanger_id);
			$results    = array_push_assoc($results,'total_rides_of_passanger',$TotalRides);
			$results    = array_push_assoc($results,'haz_rude',$TotalHazRu);
			$results    = array_push_assoc($results,'poiled_interier',$TotalSpoIn);
			$results    = array_push_assoc($results,'did_not_come_to_car',$TotalNtC2C);
			$results    = array_push_assoc($results,'cancel_orders',$TotalCanOr);
			$results    = array_push_assoc($results,'message','Passanger setting added.');	
		 $post = array_push_assoc($post,'message','Passanger setting added.');
		 $status = 1;
	     $posts= array('data'=> $results,'status'=>$status);
	}else{
		$post = array_push_assoc($post,'message','Passanger setting Not added.');
		 $status =0;
	     $posts= array('data'=> $post,'status'=>$status);
	}
	
}
else
{
	 $post = array_push_assoc($post,'message','Passanger Id is Needed');
	 $status =0;
     $posts= array('data'=> $post,'status'=>$status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>