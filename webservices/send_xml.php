 
<?php 
$xml_data ="<H2HXmlRequest class='myClass'>
<Call>
    <CallerID></CallerID>
    <Duration>0</Duration>
</Call>
<Terminal>
    <CancelDate></CancelDate>
    <ClerkLoginTime></ClerkLoginTime>
</Terminal>
<Transaction>
    <AcceptedCurrency></AcceptedCurrency>
    <AccountId>6208700003</AccountId>
</Transaction>
</H2HXmlRequest>";
 
 
$URL = "http://admin.tvdevphp.com/Mycab/webservices/update_passanger.php";
 
			/*
			$ch = curl_init($URL);
						curl_setopt($ch, CURLOPT_MUTE, 1);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
						curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);*/
			$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		echo	$output = curl_exec($ch);
			curl_close($ch);
 
?>