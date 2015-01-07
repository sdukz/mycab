<?php
include_once('configure.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$Current_date = date("Y-m_d H:i:s");
$DrivId   = $_POST['driver_id'];


if($_POST['driver_id'] !='')
{
   $query = "SELECT latitude,longitude FROM driver WHERE driver_id='$DrivId'";
   $result= mysql_query($query);
   $count = mysql_num_rows($result);
	
	if($count > 0 && $count !='')
	{
	 $post = mysql_fetch_assoc($result);
	 $status = 1;
	 $posts = array('post' => $post , 'status' => $status);
	}
	else
	{
	 $post = array_push_assoc($post,'message','No');
	 $status = 0;
	 $posts = array('post' => $post , 'status' => $status);
	}	
}
else
{
	$post  = array_push_assoc($post,'message','Driver Id Is Needed');
	$status = 0;
	$posts = array('post' => $post , 'status' => $status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>