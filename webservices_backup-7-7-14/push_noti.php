<?php 

function send_notification($device,$message,$apnsCert='Mycab.pem')
//function send_notification($device,$message,$apnsCert='goalMachine.pem')
{
	//$device = 'fbf04bf4ace2f1e823016082da3a798cf3ab666ae99a395b65e364eb4c6d6d4a'; // My iphone deviceToken		   
	$payload['aps'] = array('alert' => $message, 'badge' => 1, 'sound' => 'default');
	$payload['server'] = array('serverId' => $serverId, 'name' => $name);
	$payload = json_encode($payload);
	
	//$apnsCert = 'key.pem';
	
	$streamContext = stream_context_create();
	stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
	
	$apns = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
	
	$apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $device)) . chr(0) . chr(strlen($payload)) . $payload;
	fwrite($apns, $apnsMessage);
	
	//socket_close($apns);
	fclose($apns);
}

//send_notification('fbf04bf4ace2f1e823016082da3a798cf3ab666ae99a395b65e364eb4c6d6d4a','Ashvin Gotta Bingo for goal machine');
  send_notification('0f6979bb779a08b9df61fe3e4cb8e358d18f2291b10acc1444ae92c875543fde','msg by Mycab certificate by Mycab.pem ');

/*
function send_iphone_notification($device,$message,$apnsCert='cer.pem')
{
	//$device = 'fbf04bf4ace2f1e823016082da3a798cf3ab666ae99a395b65e364eb4c6d6d4a'; // My iphone deviceToken		   
	$payload['aps'] = array('alert' => $message, 'badge' => 1, 'sound' => 'default');
	$payload['server'] = array('serverId' => $serverId, 'name' => $name);
	$payload = json_encode($payload);
	
	//$apnsCert = 'key.pem';
	
	$streamContext = stream_context_create();
	stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
	
	$apns = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
	
	$apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $device)) . chr(0) . chr(strlen($payload)) . $payload;
	fwrite($apns, $apnsMessage);
	
	//socket_close($apns);
	fclose($apns);
}

send_iphone_notification('fbf04bf4ace2f1e823016082da3a798cf3ab666ae99a395b65e364eb4c6d6d4a','msg by goalMachine certificate by cer.pem ');*/


?>
