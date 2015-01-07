<?php
include('db.php');
$db = new Database();

if(isset($_FILES['driver_image']))
	{		
	 if($_FILES['driver_image']['error'] ==0)
	  {
	  	$random_no = $db->random_no();
		move_uploaded_file($_FILES['driver_image']['tmp_name'],"avatar/".$random_no.$_FILES['driver_image']['name']);
		$_POST['driver_image']= "http://admin.tvdevphp.com/Mycab/avatar/".$random_no.$_FILES['driver_image']['name'];
	  }
	}
$_POST = array_map('trim',$_POST);

if($_POST['driver_name'] =='' || $_POST['mobile_no'] =='')
{
	header("Location:edit_profile.php?update=unsuccess");
}
$Data = array_filter($_POST);

if(array_key_exists('submit', $Data))
unset($Data['submit']);

$query = $db->create_query($Data,'driver','UPDATE');

$db->query($query);

if($db->affectedRows() >0)
{
	header("Location:edit_profile.php?update=success");
}
else
{
	header("Location:edit_profile.php?update=unsuccess");	
}
/*
echo $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
echo"<br/>".$_SERVER["REQUEST_URI"];
echo"<br/>".basename($_SERVER["REQUEST_URI"]);
exit;
*/

?>