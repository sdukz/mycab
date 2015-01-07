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
$Current_date = date("Y-m_d H:i:s");
$PassangerId     = $_POST['passanger_id'];



if(($PassangerId !=''))
{
	$query = "SELECT * FROM passanger WHERE passanger_id ='$PassangerId' AND status =1";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		while($post = mysql_fetch_assoc($result))
		{
			$TotalRides  = get_passanger_total_rides($post['passanger_id']);
				$TotalHazRu  = get_total_times_haz_rude($post['passanger_id']);
				$TotalSpoIn  = get_total_times_spoiled_interier($post['passanger_id']);
				$TotalNtC2C  = get_total_times_did_not_come_to_car($post['passanger_id']);
				$TotalCanOr  = get_total_times_cancled_order($post['passanger_id']);
				
				$post    = array_push_assoc($post,'total_rides_of_passanger',$TotalRides);
				$post    = array_push_assoc($post,'haz_rude',$TotalHazRu);
				$post    = array_push_assoc($post,'poiled_interier',$TotalSpoIn);
				$post    = array_push_assoc($post,'did_not_come_to_car',$TotalNtC2C);
				$post    = array_push_assoc($post,'cancel_orders',$TotalCanOr);				      
      	        
				
			$posts  = array('post' => $post);
		}
	}
	else
	{
		$post  = array_push_assoc($post,'message','Passanger Id Not Valid');
	    $posts = array('post' => $post);
	}		
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id Is Needed');
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