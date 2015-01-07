<?php
include_once('configure.php');

$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");

$MobNo   = $_POST['mobile_no'];
$DevTy   = $_POST['device_type'];
$DevTo   = $_POST['device_token'];

//new field added on 10 June 2014 by JK
$passangerName = $_POST['passanger_name'];
if(isset($_POST['email'])){
	$email   = $_POST['email'];
}else{
	$email   = '';
}

$DefaultImage = 'http://'.$_SERVER["HTTP_HOST"].'/MyCab_Server/avatar/default_passanger.jpeg';

//$DefaultName  = 'Mycab Passenger';

//new code added on 10 June 2014 by JK
if($passangerName == "")
{
	$passangerName = 'Mycab Passenger';
}




if(($_POST['mobile_no'] !=''))
{
	if(isset($_POST['passanger_id']) && $_POST['passanger_id'] !='' ){
		$query = "select * from passanger where passanger_id=".$_POST['passanger_id'];
	    $result= mysql_query($query);
		if(!empty($result)){
			$rows = mysql_num_rows($result);
		}else{
			$rows = 0;
		}
		if($rows > 0){
			$passanger = mysql_fetch_assoc($result);
			if($passanger['mobile_no'] != $MobNo){
					$verification_code = unique_id();
				    $query = "UPDATE passanger set 
				   			 passanger_name ='$passangerName',passanger_image ='$DefaultImage',mobile_no='$MobNo',device_type='$DevTy',device_token='$DevTo',created_date='$Current_date',
				   			 email='$email',status=0,resend_activation_time='',resend_activation_count=0,verification_code='$verification_code' where passanger_id=".$_POST['passanger_id'];
				   $result= mysql_query($query);
				   send_act_code_sms($MobNo,"Your verification code for MyCab App: ".$verification_code);
			}else{
				   $query = "UPDATE passanger set 
				   			 passanger_name ='$passangerName',passanger_image ='$DefaultImage',mobile_no='$MobNo',device_type='$DevTy',device_token='$DevTo',created_date='$Current_date',
				   			 email='$email' where passanger_id=".$_POST['passanger_id'];
				   $result= mysql_query($query);
			}
			
			if($result)
			{
				 $post = array_push_assoc($post,'message','Passanger data successfully updated.');
				 $post = array_push_assoc($post,'user_id',$_POST['passanger_id']);
				 $status = 1;
				 $posts = array('data' => $post,'status'=>$status);
			}else
			{
			 $post = array_push_assoc($post,'message','No Passanger data updated.');
			 $status = 0;
			 $posts = array('data' => $post,'status'=>$status);
			}
		}else{
			$post = array_push_assoc($post,'message','No Passanger available with such ID');
		 	$status = 0;
		 	$posts = array('data' => $post,'status'=>$status);
		}
	}else{
		$verification_code = unique_id();
	    $query = "INSERT INTO passanger
	   			 (passanger_name,passanger_image,mobile_no,device_type,device_token,created_date,email,verification_code) 
	   			 VALUES 
	   			 ('$passangerName','$DefaultImage','$MobNo','$DevTy','$DevTo','$Current_date','$email','$verification_code') ";
	   $result= mysql_query($query);
	   $ins_id= mysql_insert_id();
		
		if($ins_id > 0 && $ins_id !='')
		{
		 $post = array_push_assoc($post,'message','Yes');
		 $post = array_push_assoc($post,'user_id',$ins_id);
		 $status = 1;
		 $posts = array('data' => $post,'status'=>$status);
		 
		 send_act_code_sms($MobNo,"Your verification code for MyCab App: ".$verification_code);
		}
		else
		{
		 $post = array_push_assoc($post,'message','No');
		 $status = 0;
		 $posts = array('data' => $post,'status'=>$status);
		}
	}
   	
}
else
{
	$post  = array_push_assoc($post,'message','Mobile No Needed');
	$status = 0;
	$posts = array('data' => $post,'status'=>$status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>