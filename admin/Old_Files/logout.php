<?php

session_start();

unset($_SESSION['id']);
unset($_SESSION['usrename']);

session_destroy();

header("Location:index.php");

?>
