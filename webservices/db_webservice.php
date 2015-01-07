<?php
if($_SERVER['HTTP_HOST'] == 'localhost'){
 	$con = mysql_connect('localhost','root','') OR DIE("Could not connect to server !!");
 	mysql_select_db("mycab_mycab",$con) OR DIE("Could not connect to database !!");
}else{
$con = mysql_connect('localhost','mycab_mycab','jy4d4uRSazWA2DM') OR DIE("Could not connect to server !!");
 mysql_select_db("mycab_mycab",$con) OR DIE("Could not connect to database !!");
}
 ?>