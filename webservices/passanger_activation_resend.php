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
$PassangerId     = $_POST['passanger_id'];


if(($PassangerId !=''))
{
	$verification_code = unique_id();
	
	$query = "SELECT * FROM passanger WHERE passanger_id ='$PassangerId' AND status=0";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count > 0 )
	{
		$Data = mysql_fetch_assoc($result);
		//check 3 times resend activation called?
		if($Data['resend_activation_count'] == 3){
			
			//check last 30 minutes difference
			$datetime1 = new DateTime();
			$datetime2 = new DateTime($Data['resend_activation_time']);
			$interval = $datetime1->diff($datetime2);
			$hours = $interval->format('%h');
			$elapsed = $interval->format('%i');
			
			if($hours <1 && $elapsed<=30)
			{
				$post = array_push_assoc($post,'message','You are blocked for 30 minutes');
				$status = 2;
	        	$posts = array('data' => $post,'status'=>$status);
			}else{
				$up_query = "UPDATE passanger SET resend_activation_count = 1, resend_activation_time='$Current_date',verification_code ='$verification_code' WHERE passanger_id ='$PassangerId'";
				$up_result= mysql_query($up_query);
				
				$post = array_push_assoc($post,'message','Yes');
				$status = 1;
		        $posts = array('data' => $post,'status'=>$status);
				
				send_act_code_sms($Data['mobile_no'],"Your verification code for MyCab App: ".$verification_code);
			}

		}
		//check resend activation is not called more than 3 times and update its counter
		else if($Data['resend_activation_count'] < 3)
		{
			$up_query = "UPDATE passanger SET resend_activation_count = resend_activation_count+1,resend_activation_time='$Current_date',verification_code ='$verification_code' WHERE passanger_id ='$PassangerId' and resend_activation_count<3";
			$up_result= mysql_query($up_query);
			$affect   = mysql_affected_rows();
			
			if($affect >0)
			{			
			    $post = array_push_assoc($post,'message','Yes');
				$status = 1;
		        $posts = array('data' => $post,'status'=>$status);
				
				send_act_code_sms($Data['mobile_no'],"Your verification code for MyCab App: ".$verification_code);
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
		$post  = array_push_assoc($post,'message','No Passanger Found');
		$status = 0;
	    $posts = array('data' => $post,'status'=>$status);
	}
	
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id Is Needed');
	$status = 0;
	$posts = array('data' => $post,'status'=>$status);
}

/* output in necessary format */
if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>