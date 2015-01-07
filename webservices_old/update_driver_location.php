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
$Latitude   = $_POST['latitude'];
$Longitude   = $_POST['longitude'];


if(($DriverId !='' && $Latitude !='' && $Longitude !=''))
{
	$up_query = "UPDATE driver SET latitude ='$Latitude',longitude='$Longitude',updated_date='$Current_date' WHERE driver_id ='$DriverId' AND status =1";
	$up_result= mysql_query($up_query);
	$affect   = mysql_affected_rows();
		
	if($affect >0)
		{			
		    $post = array_push_assoc($post,'message','Yes');
//	        $posts = array('post' => $post);
            $posts = $post;
		}
		else
		{
			$post = array_push_assoc($post,'message','No');
//	        $posts = array('post' => $post);
	        $posts = $post;			
		}
}
else
{
	$post  = array_push_assoc($post,'message','Driver Id , Latitude And Longitude Is Needed');
//	$posts = array('post' => $post);
	$posts = $post;
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