<?php

	/*Client ID: AMLR34
	Username: knight127
	Password: NZWWXUgbRULaFa
	API ID  : 3434487 */
    //$user = "ashvingargav";
    $user = "knight127";
    //$password = "AGeECDRZULBVeG";
	$password = "NZWWXUgbRULaFa";
    //$api_id = "3434374";
	$api_id = "3434487";	
    $baseurl ="http://api.clickatell.com";// Keep it as it is
    if(isset($_GET['to']) && $_GET['to']!='')
	{
    	$to = $_GET['to'];		
	}
	else
	{
		$to ="917389374560";  	
	} 
    $text = urlencode("This is an example message.");
     
    
 
    // auth call
    $url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id";
 
    // do auth call
    $ret = file($url);
 
    // explode our response. return string is on first line of the data returned
    $sess = explode(":",$ret[0]);
    if ($sess[0] == "OK")
	{
 
        $sess_id = trim($sess[1]); // remove any whitespace
        $url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";
 
        // do sendmsg call
        $ret = file($url);
        $send = explode(":",$ret[0]);
 
        if ($send[0] == "ID") {
            echo "successnmessage ID: ". $send[1];
        } 
        else
		{
            echo "send message failed";
        }
    } 
    else
	{
        echo "Authentication failure: ". $ret[0];
    }
?>