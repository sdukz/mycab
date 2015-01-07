<?php

session_start();

unset($_SESSION['driver_id']);
unset($_SESSION['verification_code']);

session_destroy();

header("Location:index.php");

?>
