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

$DrivId   = $_POST['driver_id'];


if($_POST['driver_id'] !='')
{
   $query = "SELECT latitude,longitude FROM driver WHERE driver_id='$DrivId'";
   $result= mysql_query($query);
   $count = mysql_num_rows($result);
	
	if($count > 0 && $count !='')
	{
	 $post = mysql_fetch_assoc($result);

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