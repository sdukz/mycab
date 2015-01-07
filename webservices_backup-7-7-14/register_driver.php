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

$Name    = ($_POST['driver_name'] !='') ? ucfirst($_POST['driver_name']) : '';
$MobNo   = $_POST['mobile_no'];
$TaxiNo  = $_POST['taxi_no'];
$DevTy   = $_POST['device_type'];
$DevTo   = $_POST['device_token'];

//$country_code ='+91';

$DefaultImage = 'http://admin.tvdevphp.com/Mycab/avatar/default_taxi.jpeg';

if(($_POST['mobile_no'] !=''))
{
/*****************Code to send SMS to driver***********/

   $query = "INSERT INTO driver 
   (driver_name,driver_image,mobile_no,taxi_no,device_type,device_token,created_date) 
   VALUES 
   ('$Name','$DefaultImage','$MobNo','$TaxiNo','$DevTy','$DevTo','$Current_date') ";
//exit;
   $result= mysql_query($query);
   $ins_id= mysql_insert_id();
 	
	if($ins_id > 0 && $ins_id !='')
	{
	 $post = array_push_assoc($post,'message','Yes');
	 $post = array_push_assoc($post,'driver_id',$ins_id);
	 $post = array_push_assoc($post,'radious','5');
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
	$post  = array_push_assoc($post,'message','Mobile No Needed');
	$posts = array('post' => $post);
}

/* output in necessary format */
if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>