<?php
session_start();

include_once("db.php");

$UserN      = $_POST['username'];
$Pass = $_POST['password'];
$db = new Database();

if($UserN !='' && $Pass !='')
{
	$query = "SELECT * FROM super_admin WHERE `username`='$UserN' AND `password`='$Pass'";
	
	$db->query($query);
	
	if($db->numRows() != 0)
	{
		$db->singleRecord();
		$_SESSION['id']         = $db->Record['id'] ;
		$_SESSION['username'] = $db->Record['username'];
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
