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

$DriverId     = $_POST['driver_id'];

if(($DriverId !=''))
{
	$query = "SELECT * FROM driver WHERE driver_id ='$DriverId' AND status=1";
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
		$post  = array_push_assoc($post,'message','No Driver Found');
		$status = 0;
	    $posts = array('data' => $post,'status'=>$status);
	}
	
}
else
{
	$post  = array_push_assoc($post,'message','Driver Id Is Needed');
	$status = 0;
	$posts = array('data' => $post,'status'=>$status);
}

/* output in necessary format */
if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>