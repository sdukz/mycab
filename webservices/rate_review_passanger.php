<?php
include_once('configure.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$Current_date = date("Y-m_d H:i:s");
$PassId       = $_POST['passanger_id'];
$DrivId   	  = $_POST['driver_id'];
$RideConId	  = $_POST['ride_confirm_id'];
$Comment  	  = $_POST['cancel_order'];
$SpoileInt    = $_POST['spoiled_interier'];
$EasRude  	  = $_POST['eas_rude'];
$DidNotComeToCar = $_POST['did_not_come_to_car'];
$comment 	  = $_POST['comment'];
$rating 	  = $_POST['rating'];

if($DrivId !='' && $PassId !='' && $RideConId !='')
{
   $query = "INSERT INTO rate_review_passanger (passanger_id,driver_id,ride_confirm_id,cancel_order,spoiled_interier,haz_rude,did_not_come_to_car,rating,comment,created_date) VALUES
             ('$PassId','$DrivId','$RideConId','$Comment','$SpoileInt','$EasRude','$DidNotComeToCar','$rating','$comment','$Current_date')";
  
   $result= mysql_query($query);
   $ins_id= mysql_insert_id();
	
	if($ins_id > 0 && $ins_id !='')
	{
	 $up_q = "UPDATE driver SET busy='No' WHERE driver_id='$DrivId'";
	 $up_r = mysql_query($up_q);	 	
	 $post = array_push_assoc($post,'message','Yes');
	 $post = array_push_assoc($post,'rate_review_passanger_id',$ins_id);
	 $status = 1;
	 $posts = array('data' => $post ,'status'=>$status);
	}
	else
	{
	 $post = array_push_assoc($post,'message','No');
	 $status = 0;
	 $posts = array('data' => $post , 'status'=>$status);
	}	
}
else
{
	$post  = array_push_assoc($post,'message','Driver Id And Passanger Id And Ride Confirm Id Is Needed');
	$status = 0;
	$posts = array('data' => $post , 'status'=>$status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>