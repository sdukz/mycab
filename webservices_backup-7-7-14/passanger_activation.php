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
		$post  = array_push_assoc($post,'message','No Passanger Found With This Verification Code');
	    $posts = array('post' => $post);
	}
	
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id and Verification Code Is Needed');
	$posts = array('post' => $post);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>