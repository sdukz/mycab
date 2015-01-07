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
$VerifiCode   = $_POST['verification_code'];


if(($DriverId !='' && $VerifiCode !=''))
{
	$query = "SELECT * FROM driver WHERE driver_id ='$DriverId' AND verification_code ='$VerifiCode' AND status=0 ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count > 0 )
	{
		$up_query = "UPDATE driver SET status =1 WHERE driver_id ='$DriverId' AND verification_code ='$VerifiCode'";
		$up_result= mysql_query($up_query);
		$affect   = mysql_affected_rows();
		
		if($affect >0)
		{			
		    $post = array_push_assoc($post,'message','Yes');
	        $posts = array('post' => $post);
		}
		else
		{
			$post = array_push_assoc($post,'message','No');
	        $posts = array('post' => $post);			
		}
	}
	else
	{
		$post  = array_push_assoc($post,'message','No Driver Found With This Verification Code');
	    $posts = array('post' => $post);
	}
	
}
else
{
	$post  = array_push_assoc($post,'message','Driver Id and Verification Code Is Needed');
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