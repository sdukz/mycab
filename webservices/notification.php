<?php

function send_notification($type,$msg,$id)
{

	$Current_time = date("Y-m-d H:i:s");

	if($type !='' && $msg !='' && $id !='' && $id !=0)
	{
		switch ($type) {
		  case 'ride_request':
			 $query="SELECT driver_id,device_type,device_token FROM `driver` WHERE driver_id IN($id) AND status=1";			  
			  break;
		  case 'ride_responce':
			   $query="SELECT passanger_id,device_type,device_token FROM `passanger` WHERE passanger_id =$id AND status=1";
			  break;
		  case 'ride_confirm':
			   $query="SELECT driver_id,device_type,device_token FROM `driver` WHERE driver_id = '$id' AND status=1";
			  break;
		 case 'ride_cancle_by_passanger':
			  $query="SELECT driver_id,device_type,device_token FROM `driver` WHERE driver_id = '$id' AND status=1";
			  break;
		 case 'ride_cancle_by_driver':
			 $query="SELECT passanger_id,device_type,device_token FROM `passanger` WHERE passanger_id = '$id' AND status=1";
			  break;
		 case 'ride_accept':
			 $query="SELECT passanger_id,device_type,device_token FROM `passanger` WHERE passanger_id = '$id' AND status=1";
			  break;			  
	                   }

		$result=mysql_query($query);	
	    if(mysql_num_rows($result) > 0)
		{
		while($row=mysql_fetch_assoc($result))
		{
			if($row['device_type'] !='' && $row['device_type'] !='(null)' && $row['device_token'] !='' && $row['device_token'] !='(null)')
			{
			         
				if($row['device_type'] == 'iphone' || $row['device_type'] == 'iPhone')
				{
					send_notification_new($row['device_token'], $msg);
				}
				if($row['device_type'] == 'android')
				{
					send_android_notification($row['device_token'], $msg);
				}
				$query_ins = "INSERT INTO `notification`(`device_token`,`notification_type`,`message`,`status`,`created_date`)
						               VALUES('".$row['device_token']."','$type','$msg','1','$Current_time')";
				$result_ins = mysql_query($query_ins) OR die(mysql_error());
			}
       			else
 			{
				$query_ins = "INSERT INTO `notification`(`device_token`,`notification_type`,`message`,`status`,`created_date`)
						               VALUES('".$row['device_token']."','$type','$msg','2','$Current_time')";
				$result_ins = mysql_query($query_ins) OR die(mysql_error());	
			}		
		}			
		}
	}
	
}

//send_notification_new('2f599fbb07eb486fc30ec02709bcb0c0500665ebfaedc6ba436574dc2472d50a','this is demo notification');
function send_notification_new($deviceToken,$message,$pemfile='ck.pem')
{
	 
	// Put your private key's passphrase here:
	$passphrase = 'letsdoit@123';


	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', $pemfile);
	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

	// Open a connection to the APNS server
	$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

	if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

	// Create the payload body
	
	//$explode = explode('#',$message);
	$count = count($explode);
	if($count == 3){
		$body['aps'] = array('id' => $explode[0],
		'alert' => $message,
		//'tag' => $explode[1],
		'badge' => '1',
		'sound'=>'default');
	}else{
		$body['aps'] = array('id' => '',
		'alert' => $message,
		//'tag' => $explode[0],
		'badge' => '1',
		'sound'=>'default');
	}
	
	/*$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default',
	'badge' => 1
	);*/

	// Encode the payload as JSON
	$payload = json_encode($body);

	// Build the binary notification
	$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

	// Send it to the server
	$result = fwrite($fp, $msg, strlen($msg));
      
	//if (!$result)
	//	return 'Message not delivered';
	//else
	//	return 'Message successfully delivered';

	// Close the connection to the server
	fclose($fp);
}

//Send notification on android device 
function send_android_notification($registatoin_ids, $message) {
        // include config
 
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
 
        $fields = array(
            'registration_ids' => array($registatoin_ids),
           'data' =>  array('message' => $message),
        );
 
        $headers = array(
           // 'Authorization: key=' .'AIzaSyCuJ6PupdVqrJwu3Iqp0sNIW8FYrYIm7M0',AIzaSyCdC07sCz1SU3LKucUY4aw1gBZKkDXh-_E
           'Authorization: key=AIzaSyAuCPPW3G16XWbSlokDCmNmsRtswK9jpVU',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
           // die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
      //  echo $result;
      // print_r($result);
      /* $regID=$userslists['device_ID'];
								 $registatoin_ids=array($regID);
									
								$msg=array("message"=>$userdetails['first_name']." ".$userdetails['last_name'].' has added '.$custom_list_name.' List'); 
								$url='https://android.googleapis.com/gcm/send';
							  	$fields=array ( 'registration_ids'=>$registatoin_ids, 'data'=>$msg ); 
							  	
							  	$headers=array ( 'Authorization: key=AIzaSyAEgnMvYm-ZlO_mgWMOkY6d2Z1JISIBaw8', 'Content-Type: application/json' );
							   	$ch=curl_init();
								curl_setopt($ch,CURLOPT_URL,$url);
								curl_setopt($ch,CURLOPT_POST,true); 
								curl_setopt($ch,CURLOPT_HTTPHEADER,$headers); 
								curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
								curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false); 
								curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
								curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields)); 
								$result=curl_exec($ch); 
								curl_close($ch); 
								*/
          
    }

//send_android_notification('APA91bHEB2SZOn2M9YXtIm55uYi5jK8pxjY2MlVTXUUr9ZclOVqK7CyDqiehfqQSYrt18tSjmdsZj4-TaxTKAhccUSkeggJYLuszES973OLz5DMn9sl9XNF6RHNE0Qs3Z0oOPpArCeqDB6RYrazVAznUSGPeSbfSpQ','Driver 52- asdf arrived on source location.JUST TEST');
//send_android_notification('APA91bE44RXqQuw2E3OBC_mihZLOzb21Dlaind3Vs70eTXoLUjQ33tKd0k8zG_jCBY12eH3YC2M98WlPTfvq23o5jnBxY9ra-NG4Kuk4q49jbiJ5tL4V3mw2kZRywFLsYsH5CcNpjEICfxe4viGioPsmUE1BgV69Yw','passanger 62- asdf arrived on source location.JUST TEST');
?>