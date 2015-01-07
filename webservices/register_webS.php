<?php
/*echo"<pre>";
print_r($_POST);
exit;*/

include('db.php');
//include('configure.php');

$post = array();
$posts= array();
$format ="json";
$Current_date = date("Y-m-d H:i:s");

/****************************** Get data for user registration or updation ************************/
//$Operation     =$_POST['Operation'];
$FirstName     =$_POST['FirstName'];
$LastName      =$_POST['LastName'];
$Email         =$_POST['Email'];
$Password      =$_POST['Password'];
$PnToken    =$_POST['PnToken'];
$DeviceType    =$_POST['DeviceType'];
$CurrentDate  = date("Y-m-d H:i:s");
$DefaultAvatar="http://goal.skytemple.com/avatar/default_avatar.jpg";

 $query  ="SELECT * FROM `user` WHERE `Email`='".$Email."' AND deleted='0'";
 $result = mysql_query($query);
 $count  = mysql_num_rows($result);

 if($count==0)
 {
   $Activation_Key = gen_activation_key($Email);
    
//   $avatar_link ="/avatar/default_avatar.jpg";
//   $avatar_link = add_site_url($avatar_link);
    $insert_query ="INSERT INTO `user`(`first_name`,`last_name`,`email`,`password`,`avatar`,`user_created_time`,`pn_token`,`device_type`) 
           VALUES ('".$FirstName."','".$LastName."','".$Email."','".$Password."','".$DefaultAvatar."','".$Current_date."','".$PnToken."','".$DeviceType."')";			   
    $result   =mysql_query($insert_query);
    $new_user = mysql_insert_id();

    if(isset($result) || $result !='')
    {
	    $res  = get_all_user_data($new_user);
		while($post = mysql_fetch_assoc($res))
		{
    	$post =array_push_assoc($post, 'message', 'register successfully');
		//$post =array_push_assoc($post, 'user_id', $new_user);
        $posts = array('post'=>$post);
		}
    }
	else
	{
	    $post =array_push_assoc($post, 'message', 'could not add this user - cause of some error.');
		$post =array_push_assoc($post, 'user_id', $new_user);
        $posts = array('post'=>$post);
	}

 
  }
 else
  {
	
     $post =array_push_assoc($post, 'message', 'Existing Record');
     $posts = array('post'=>$post);
  }

/* output in necessary format */
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($posts);


function displayJsonOutput($result='')//Display Output According to JSON Format 
{
	header("Content-type:text/json");
	echo json_encode(array("posts"=>$result));
}

//* disconnect from the db */
@mysql_close($con);

?>
