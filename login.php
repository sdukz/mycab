<?php
session_start();

include_once("db.php");

$MobileNo      = $_POST['mobile_no'];
$VerificationC = $_POST['verification_code'];
$db = new Database();

if($MobileNo !='' && $VerificationC !='')
{
	$query = "SELECT driver_id,mobile_no,verification_code FROM driver WHERE `mobile_no`='$MobileNo' AND `verification_code`='$VerificationC'";
	
	$db->query($query);
	
	if($db->numRows() != 0)
	{
		$db->singleRecord();
		$_SESSION['driver_id']         = $db->Record['driver_id'] ;
		$_SESSION['verification_code'] = $db->Record['verification_code'];
		header("Location:home.php");
	}
	else
	{
		header("Location:index.php?res=not_author");		
	}
}
else
{
	header("Location:index.php?res=fill_entry");	
}

?>
