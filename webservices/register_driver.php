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

//new field added on 10 June 2014 by JK
$email   = $_POST['email'];
$taxiModel = $_POST['taxi_model'];
$taxiBrand = $_POST['taxi_brand'];
$taxiYear = $_POST['taxi_year'];
$license_id = $_POST['license_id'];

$status = 0;

$DefaultImage = 'http://'.$_SERVER["HTTP_HOST"].'/MyCab_Server/avatar/default_taxi.jpeg';

if(($_POST['mobile_no'] !=''))
{
	 if(isset($_POST['driver_id']) && $_POST['driver_id'] !='' ){
	 	$query = "select * from driver where driver_id=".$_POST['driver_id'];
	    $result= mysql_query($query);
		if(!empty($result)){
			$rows = mysql_num_rows($result);
		}else{
			$rows = 0;
		}
		if($rows > 0){
			$drive = mysql_fetch_assoc($result);
			if($drive['mobile_no'] != $MobNo){
				$verification_code = unique_id();
			   	$query = "Update driver set  
			    driver_name= '$Name',driver_image='$DefaultImage',mobile_no ='$MobNo',taxi_no='$TaxiNo',device_type='$DevTy',device_token='$DevTo',created_date='$Current_date',
			    email='$email',taxi_model='$taxiModel',taxi_brand='$taxiBrand',taxi_year='$taxiYear',licance_id='$license_id',status=0,resend_activation_time='',resend_activation_count=0,verification_code='$verification_code' where driver_id=".$_POST['driver_id'];
				//exit;
			    $result= mysql_query($query);
				send_act_code_sms($MobNo,"Your verification code for MyCab App: ".$verification_code);
			}else{
				$query = "Update driver set  
			    driver_name= '$Name',driver_image='$DefaultImage',mobile_no ='$MobNo',taxi_no='$TaxiNo',device_type='$DevTy',device_token='$DevTo',created_date='$Current_date',
			    email='$email',taxi_model='$taxiModel',taxi_brand='$taxiBrand',taxi_year='$taxiYear',licance_id='$license_id' where driver_id=".$_POST['driver_id'];
				//exit;
			    $result= mysql_query($query);
			}
			if($result)
			{
			 $post = array_push_assoc($post,'message','Driver data successfully updated.');
			 $post = array_push_assoc($post,'driver_id',$_POST['driver_id']);
			 $post = array_push_assoc($post,'radious','5');
			 $status = 1;
			 $posts = array('data' => $post,'status'=>$status);
			
			}
			else
			{
			 $post = array_push_assoc($post,'message','No Driver data updated.');
			 $status = 0;
			 $posts = array('data' => $post,'status'=>$status);
			}
		}else{
			$post = array_push_assoc($post,'message','No Driver available with such ID');
		 	$status = 0;
		 	$posts = array('data' => $post,'status'=>$status);
		}
	 }else{
		/*****************Code to send SMS to driver***********/
		$verification_code = unique_id();
	   	$query = "INSERT INTO driver 
	    (driver_name,driver_image,mobile_no,taxi_no,device_type,device_token,created_date,email,taxi_model,taxi_brand,taxi_year,licance_id,verification_code) 
	    VALUES 
	    ('$Name','$DefaultImage','$MobNo','$TaxiNo','$DevTy','$DevTo','$Current_date','$email','$taxiModel','$taxiBrand','$taxiYear','$license_id','$verification_code')";
		//exit;
	    $result= mysql_query($query);
	    $ins_id= mysql_insert_id();
	 	
		if($ins_id > 0 && $ins_id !='')
		{
		 $post = array_push_assoc($post,'message','Yes');
		 $post = array_push_assoc($post,'driver_id',$ins_id);
		 $post = array_push_assoc($post,'radious','5');
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