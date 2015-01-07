<?php
include_once('configure.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$PassangerId     = $_POST['passanger_id'];

if(($PassangerId !=''))
{
	$query = "SELECT * FROM passanger WHERE passanger_id ='$PassangerId' AND status=1";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count > 0 )
	{
		    $post = array_push_assoc($post,'message','Yes');
			$status = 1;
	        $posts = array('data' => $post,'status'=>$status);
	}
	else
	{
		$post  = array_push_assoc($post,'message','No Passanger Found');
		$status = 0;
	    $posts = array('data' => $post,'status'=>$status);
	}
	
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id Is Needed');
	$status = 0;
	$posts = array('data' => $post,'status'=>$status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>