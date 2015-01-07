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
			if($row['device_type'] !='' && $row['device_token'] !='' && $row['device_token'] !='(null)')
			{
				if($row['device_type'] == 'iphone')
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

//send_notification_new('fbf04bf4ace2f1e823016082da3a798cf3ab666ae99a395b65e364eb4c6d6d4a','msg by Mycab certificate  Mycab.pem JUST TEST');
function send_notification_new($deviceToken,$message,$pemfile='Mycab.pem')
{

	// Put your private key's passphrase here:
	$passphrase = '1234';


	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', $pemfile);
	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

	// Open a connection to the APNS server
	$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

	if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

	

	// Create the payload body
	$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default',
	'badge' => 1
	);

	// Encode the payload as JSON
	$payload = json_encode($body);

	// Build the binary notification
	$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

	// Send it to the server
	$result = fwrite($fp, $msg, strlen($msg));

	if (!$result)
		return 'Message not delivered';
	else
		return 'Message successfully delivered';

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
            'Authorization: key=' .'AIzaSyCuJ6PupdVqrJwu3Iqp0sNIW8FYrYIm7M0',
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
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
      //  echo $result;
          
    }

//send_android_notification('APA91bHaYlWjJLVDs5brbF0WkZpd-hBz6gnKQ8dNVZU0ro7XPLziK2IDGZP46Erb1zx4mlEppUv1tkdSF0ajsZL2vdsTEOg_A84qwqLinKX0_vNFGgb8cwOindesfnQA0LUcxjFl2PzZ','Driver - asdf arrived on source location.JUST TEST');
?>
