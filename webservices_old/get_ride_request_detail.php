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
$Current_date  = date("Y-m_d H:i:s");
$PassangerId   = $_POST['passanger_id'];
$RideRequestId = $_POST['ride_request_id'];



if(($PassangerId !='' && $RideRequestId !=''))
{
	$query = "SELECT * FROM ride_request WHERE passanger_id ='$PassangerId' AND ride_request_id='$RideRequestId' AND status =1";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		while($post = mysql_fetch_assoc($result))
		{
			$passanger = get_passanger_name_image_by_id($post['passanger_id']);
			$post   = array_push_assoc($post,'passanger_name',$passanger['passanger_name']);
			$post   = array_push_assoc($post,'passanger_image',$passanger['passanger_image']);
			$posts  = array('post' => $post);
		}
	}
	else
	{
		$post  = array_push_assoc($post,'message','Invalid Passanger Or Ride Request Id');
	    $posts = array('post' => $post);
	}		
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id And Request Is Needed');
	$posts = array('post' => $post);
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