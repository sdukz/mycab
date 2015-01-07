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
$DriverId     = $_POST['driver_id'];



if(($DriverId !=''))
{
	$query = "SELECT * FROM rate_review_driver WHERE driver_id ='$DriverId' AND status =1 ORDER BY created_date DESC limit 5";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		while($post = mysql_fetch_assoc($result))
		{
			$rating = get_driver_average_rating($DriverId);
			$post   = array_push_assoc($post,'average_rating',$rating);
			$posts  = array('post' => $post);
		}
	}
	else
	{
		$post  = array_push_assoc($post,'message','Driver Id Is Not Valid OR No Comment Available');
	    $posts = array('post' => $post);
	}		
}
else
{
	$post  = array_push_assoc($post,'message','Driver Id Is Needed');
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