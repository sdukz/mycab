<?php

include_once("controller/Controller.php");

$controller = new Controller();

if(isset($_POST['Update']) && isset($_POST))
{
	$controller->updatePassword();
}
else
{
	$controller->updatePasswordForm();
}

?>
