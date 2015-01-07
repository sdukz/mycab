<?php
include_once('configure.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$Current_date = date("Y-m_d H:i:s");
$PassId   = $_POST['passanger_id'];
$RideReqId= $_POST['ride_request_id'];



if($PassId !='' && $RideReqId !='')
{
   $query_res = "DELETE FROM ride_request WHERE passanger_id='$PassId' AND ride_request_id='$RideReqId'";
   $result_res= mysql_query($query_res);
   $aff_res   = mysql_affected_rows();
   if($aff_res >0)
   {
   	$query_res = "DELETE FROM ride_responce WHERE passanger_id='$PassId' AND ride_request_id='$RideReqId'";
    $result_req= mysql_query($query_res);   

	 $post = array_push_assoc($post,'message','Yes');
	 $status = 1;
	 $posts = array('data' => $post, 'status' => $status);
    }
	else
	{
	 $post = array_push_assoc($post,'message','No');
	 $status = 0;
	 $posts = array('data' => $post, 'status' => $status);
	}	
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id And Ride Request Id Is Needed');
	 $status = 0;
	$posts = array('data' => $post, 'status' => $status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>