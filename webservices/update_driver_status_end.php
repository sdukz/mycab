<?php
include_once('configure.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$Current_date  = date("Y-m_d H:i:s");

$DrivId   	   = $_POST['driver_id'];



if($_POST['driver_id'] !='')
{
	$up_q = "SELECT * from  driver  WHERE driver_id='$DrivId' ";
    $up_r = mysql_query($up_q);
	$count = count($up_r);
	if($count > 0 ){
	   $up_q = "UPDATE driver SET busy='No',updated_date='$Current_date' WHERE driver_id='$DrivId' ";
       $up_r = mysql_query($up_q);
	   
	   if($up_r){
	   	   $status = 1;
		   $post  = array_push_assoc($post,'message','Driver Status Updated Successfully.');
		   $posts = array('post' => $post , 'status' => $status);
	   }else{
		   $status = 0;
		   $post  = array_push_assoc($post,'message','Driver Status Not Updated Successfully.');
		   $posts = array('post' => $post , 'status' => $status);
	   }
	}else{
		$status = 0;
		$post  = array_push_assoc($post,'message','Driver Id is not valid.');
		$posts = array('post' => $post , 'status' => $status);
	}
}
else
{
	$status = 0;
	$post  = array_push_assoc($post,'message','Driver Id And Passanger Id And Ride Confirm Id Is Needed');
	$posts = array('post' => $post , 'status' => $status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>