<?php
include_once('configure.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");
$PassangerId     = $_POST['passanger_id'];
$VerifiCode   = $_POST['verification_code'];


if(($PassangerId !='' && $VerifiCode !=''))
{
	$query = "SELECT * FROM passanger WHERE passanger_id ='$PassangerId' AND verification_code ='$VerifiCode' AND status=0 ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count > 0 )
	{
		$up_query = "UPDATE passanger SET status =1,updated_date='$Current_date' WHERE passanger_id ='$PassangerId' AND verification_code ='$VerifiCode'";
		$up_result= mysql_query($up_query);
		$affect   = mysql_affected_rows();
		
		if($affect >0)
		{
			$query = "SELECT * FROM passanger WHERE passanger_id ='$PassangerId' AND status =1";
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
		    $post = array_push_assoc($post,'message','Yes');
			$status = 1;
	        $posts = array('data' => $results,'status'=>$status);
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
		$post  = array_push_assoc($post,'message','No Passanger Found With This Verification Code');
		$status = 0;
	    $posts = array('data' => $post,'status'=>$status);
	}
	
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id and Verification Code Is Needed');
	$status = 0;
	$posts = array('data' => $post,'status'=>$status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>