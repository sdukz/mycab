<?php
session_start();

if(isset($_SESSION) && isset($_SESSION['driver_id']))
{ }
else {
	header("Location:index.php");
}
include('db.php');
$db = new Database();

$CurrentDate = date("Y-m-d H:i:s");
$_POST = array_map('trim',$_POST);

$Data = array_filter($_POST);

if(array_key_exists('submit', $Data))
unset($Data['submit']);
/*
print_r($Data);
exit;*/

if( ($Data['radious'] >= 5) && ($Data['radious'] <= 50) ) 
{
$Data['driver_id'] = $_SESSION['driver_id'];
$Data['updated_date'] = $CurrentDate;
$query = $db->create_query($Data,'driver','UPDATE');

$db->query($query);

if($db->affectedRows() >0)
{
	header("Location:filter.php?update=success");
}
else
{
	header("Location:filter.php?update=unsuccess");	
}

}
else 
{
	header("Location:filter.php?radius=unsuccess");
}
?>