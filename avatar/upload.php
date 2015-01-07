<?php

$name = $_POST['name'];
$filename = $_POST['filename'];
//echo "Name = '" . $name . "', filename = '" . $filename . "'.";

move_uploaded_file($_FILES['uploadedfile']['tmp_name'], "./".$_FILES["uploadedfile"]["name"]);

//error_log ( "Name = '" . $name . "', filename = '" . $filename . "'." );

?>