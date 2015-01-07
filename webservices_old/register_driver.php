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
$Name    = $_POST['driver_name'];
$MobNo   = $_POST['mobile_no'];
$TaxiNo  = $_POST['taxi_no'];
$DevTy   = $_POST['device_type'];
$DevTo   = $_POST['device_token'];

//$country_code ='+91';

$DefaultImage = 'http://admin.tvdevphp.com/Mycab/avatar/default_taxi.jpeg';

if(($_POST['mobile_no'] !=''))
{
/*****************Code to send SMS to driver***********/
//$activation_code = '1234';
//$activation_code = genActivationCode();
//$message= "Your activation code for calltaxi driver account is $activation_code";
//$sms_result = send_act_code_sms($country_code.$MobNo,$message);
//$sms_result='success';// SMS sent or not Registration should be done.
/*****************Code to send SMS to driver end ******/
//if($sms_result=='success')
// {
   $query = "INSERT INTO driver (driver_name,driver_image,mobile_no,taxi_no,device_type,device_token,created_date) VALUES
               ('$Name','$DefaultImage','$MobNo','$TaxiNo','$DevTy','$DevTo','$Current_date') ";
//exit;
   $result= mysql_query($query);
   $ins_id= mysql_insert_id();

// mysql_query("insert into ofUser values('".$ins_id."_driver','".$ins_id."_driver',NULL,'".$Name."','',UNIX_TIMESTAMP(),UNIX_TIMESTAMP())");
 	
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
// }
// else
// {
//	$post['message']=$sms_result;		
//	$posts[]=$post;//String for json	
	
// }	
}
else
{
	$post  = array_push_assoc($post,'message','Mobile No Needed');
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