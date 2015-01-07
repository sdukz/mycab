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
	$Name       = ucfirst($_POST['passanger_name']);
	$Image      = $_POST['passanger_image'];
	$id         = $_POST['passanger_id'];
	$email         = $_POST['email'];
	

    $query = "UPDATE passanger SET passanger_name='$Name',passanger_image='$Image',email='$email',
	          updated_date='$Current_date'
	                  WHERE passanger_id='$id' ";
	$result= mysql_query($query);
	$affect= mysql_affected_rows();
	
	if($affect > 0)
	{
		$query = "SELECT * FROM passanger WHERE passanger_id ='$id' AND status =1";
		$result= mysql_query($query);
		
		
		
			$results = mysql_fetch_assoc($result);
			
				    $TotalRides  = get_passanger_total_rides($id);
					$TotalHazRu  = get_total_times_haz_rude($id);
					$TotalSpoIn  = get_total_times_spoiled_interier($id);
					$TotalNtC2C  = get_total_times_did_not_come_to_car($id);
					$TotalCanOr  = get_total_times_cancled_order($id);
					
					$results    = array_push_assoc($results,'total_rides_of_passanger',$TotalRides);
					$results    = array_push_assoc($results,'haz_rude',$TotalHazRu);
					$results    = array_push_assoc($results,'poiled_interier',$TotalSpoIn);
					$results    = array_push_assoc($results,'did_not_come_to_car',$TotalNtC2C);
					$results    = array_push_assoc($results,'cancel_orders',$TotalCanOr);				      
	      	        
		
		$post = array_push_assoc($post,'message','Record Updated Successfully');
		
		$status = 1;
        $posts= array('data'=> $results,'status'=>$status);
	}
	else
	{
		$query = "SELECT * FROM passanger WHERE passanger_id ='$id' AND status =1";
		$result= mysql_query($query);
		
		
		
			$results = mysql_fetch_assoc($result);
			
				    $TotalRides  = get_passanger_total_rides($id);
					$TotalHazRu  = get_total_times_haz_rude($id);
					$TotalSpoIn  = get_total_times_spoiled_interier($id);
					$TotalNtC2C  = get_total_times_did_not_come_to_car($id);
					$TotalCanOr  = get_total_times_cancled_order($id);
					
					$results    = array_push_assoc($results,'total_rides_of_passanger',$TotalRides);
					$results    = array_push_assoc($results,'haz_rude',$TotalHazRu);
					$results    = array_push_assoc($results,'poiled_interier',$TotalSpoIn);
					$results    = array_push_assoc($results,'did_not_come_to_car',$TotalNtC2C);
					$results    = array_push_assoc($results,'cancel_orders',$TotalCanOr);				      
	      	        
				
				//$posts  = array('data' => $results,'status'=>$status);
			
		
		$post = array_push_assoc($post,'message','Record Not Updated');
		$status = 0;
        $posts= array('data'=> $results,'status'=>$status);
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