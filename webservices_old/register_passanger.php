<?php
include_once('configure.php');

/*
echo"<pre>";
print_r($_POST);
exit;
*/
/* echo $query = create_query($_POST,'insert',passanger);
 exit; */
$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");
//$Name    = $_POST['passanger_name'];
$MobNo   = $_POST['mobile_no'];
$DevTy   = $_POST['device_type'];
$DevTo   = $_POST['device_token'];

$DefaultImage = 'http://admin.tvdevphp.com/Mycab/avatar/default_passanger.jpeg';
$DefaultName  = 'Mycab Passanger';


if(($_POST['mobile_no'] !=''))
{
   $query = "INSERT INTO passanger (passanger_name,passanger_image,mobile_no,device_type,device_token,created_date) VALUES 
   ('$DefaultName','$DefaultImage','$MobNo','$DevTy','$DevTo','$Current_date') ";
   $result= mysql_query($query);
   $ins_id= mysql_insert_id();
	
	if($ins_id > 0 && $ins_id !='')
	{
	 $post = array_push_assoc($post,'message','Yes');
	 $post = array_push_assoc($post,'user_id',$ins_id);
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
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>