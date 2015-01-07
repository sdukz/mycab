<?php session_start();
if($_SESSION['id'] !='' && $_SESSION['username'] !='')
{
}
else { header("LOCATION:index.php"); }
include('db.php');
$db = new Database();

$home = (basename($_SERVER["REQUEST_URI"],'.php') == 'home') ? 'home active_class' : 'home';
$profile = (basename($_SERVER["REQUEST_URI"],'.php') == 'profile') ? 'profile active_class' : 'profile';
$balance = (basename($_SERVER["REQUEST_URI"],'.php') == 'balance') ? 'balance active_class' : 'balance';
$filter = (basename($_SERVER["REQUEST_URI"],'.php') == 'filter') ? 'filter active_class' : 'filter';
$archive = (basename($_SERVER["REQUEST_URI"],'.php') == 'archive') ? 'archive active_class' : 'archive';

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>MyCab Home</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<link rel="stylesheet" type="text/css" href="css/reset.css" />

</head>

<body>

<div id="background">
</div>

<div id="wrapper">

	<div id="header">

		<div id="nav">
        
        	<div class="logo">
          	<a href="index.html"><span class="color_18" style="font-family: Niconne, cursive;">My Cab</span> </a>
            </div>
           
            <div class="<?php echo $home; ?>">
             <a href="logout.php">Logout</a>	            	
          	<a href="home.php">Home</a>
            </div>
            
            <div class="<?php echo $profile; ?>">
          	<a href="profile.php">Profile</a>
            </div>
            
            <div class="<?php echo $archive; ?>">
          	<a href="archive.php">Archive</a>
            </div>
            
            <div class="<?php echo $filter; ?>">
          	<a href="filter.php">Filter</a>
            </div>
            
            <div class="<?php echo $balance; ?>">
            <a href="balance.php">Balance</a>
            </div>
        
        </div>

                  

	</div>