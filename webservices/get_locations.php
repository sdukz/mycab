<?php
include_once('configure.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';

$Current_date = date("Y-m_d H:i:s");
$DrivId   = $_POST['driver_id'];
$passanger_id  = $_POST['passanger_id'];

$passanger_long   = $_POST['passanger_long'];
$passanger_lat  = $_POST['passanger_lat'];
if($_POST['passanger_long'] != '' && $_POST['passanger_lat'] !=''){
	$query = "UPDATE passanger SET  latitude =".$_POST['passanger_lat'].",longitude=".$_POST['passanger_long']." WHERE passanger_id='$passanger_id'";
   	$result= mysql_query($query);
}

$driver_long   = $_POST['driver_long'];
$driver_lat  = $_POST['driver_lat'];
if($_POST['driver_long'] != '' && $_POST['driver_lat'] !=''){
	$query = "UPDATE driver SET  latitude =".$_POST['driver_lat'].",longitude=".$_POST['driver_long']." WHERE driver_id='$DrivId'";
   	$result= mysql_query($query);
}
if($_POST['driver_id'] !='' && $_POST['passanger_id']!='')
{
   $query = "SELECT latitude,longitude FROM driver WHERE driver_id='$DrivId'";
   $result= mysql_query($query);
   $count = mysql_num_rows($result);
   $queryp = "SELECT latitude,longitude FROM passanger WHERE passanger_id='$passanger_id'";
   $resultp= mysql_query($queryp);
	if($count > 0 && $count !='')
	{
	 $post['driver'] = mysql_fetch_assoc($result);
	 $post['passanger'] = mysql_fetch_assoc($resultp);
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