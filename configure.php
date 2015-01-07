<?php
//include 'db.php';
$dataB = new Database();


//-------------------------------------------
//    Geterate Random No
//-------------------------------------------
    function getPassengerNameById($passId)
        {
	$query = "SELECT passanger_name FROM passanger WHERE passanger_id='$passId'";
	$dataB->query($query);
	$dataB->singleRecord();
	return $dataB->Record['passanger_name'];
        } // end function random no
        
//-------------------------------------------
//    Geterate Random No
//-------------------------------------------
    function getResponceAmountByResId($resId)
        {
	$query = "SELECT amount FROM ride_responce WHERE ride_responce_id='$resId'";
	
	$dataB->query($query);
	$dataB->singleRecord();
	return $dataB->Record['amount'];
        } // end function random no



?>