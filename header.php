<?php @session_start();
if($_SESSION['driver_id'] !='')
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


<!--
	this is used for range bubble only ------ start
-->
	<style>
	#range { position: relative; margin: 13px 0 0 5px }
    output { 
      position: absolute;
      background-image: -moz-linear-gradient(top, #444444, #999999);
      background-image: -o-linear-gradient(top, #444444, #999999);
      background-image: -webkit-gradient(linear, left top, left bottom, from(#444444), to(#999999));
      background-image: -webkit-linear-gradient(top, #444444, #999999);
      width: 50px; 
     /* height: 20px;*/ 
      text-align: center; 
      color: white; 
      border-radius: 10px; 
      display: inline-block; 
      font: bold 15px/30px Georgia;
      bottom: 150%;
      left: 0;
      margin-left: -1%;
    }
	  output:after { 
	    content: "";
	    position: absolute;
	    width: 0;
	    height: 0;
	    border-top: 10px solid #999999;
	    border-left: 5px solid transparent;
	    border-right: 5px solid transparent;
	    top: 100%;
	    left: 50%;
	    margin-left: -5px;
	    margin-top: -0px;
	  }
	</style>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script>
	 $(function() {
	   var el, newPoint, newPlace, offset;
	   $("input[type='range']").change(function() {
	     el = $(this);
	     width = el.width();
	     newPoint = (el.val() - el.attr("min")) / (el.attr("max") - el.attr("min"));
	     offset = -0.3;
	     if (newPoint < 0) { newPlace = 0;  }
	     else if (newPoint > 1) { newPlace = width; }
	     else { newPlace = width * newPoint + offset; offset -= newPoint;}
	     el
	       .next("output")
	       .css({
	         left: newPlace,
	         marginLeft: offset + "%"
	       })
	       .text(el.val());
	   })
	   .trigger('change');
	 });
	</script>
	
	<!--
		End range Bubble-----------
	-->

</head>

<body>

<div id="background">
</div>

<div id="wrapper">

	<div id="header">

		<div id="nav">
        
        	<div class="logo">
          	<a href="#"><span class="color_18" style="font-family: Niconne, cursive;">My Cab</span> </a>
            </div>
           
            <div class="<?php echo $home; ?>">
            <a href="home.php">Home</a>
             	            	
          	</div>
            
            <div class="<?php echo $profile; ?>">
          	<a href="profile.php">Profile</a>
            </div>
            
          <div class="<?php echo $archive; ?>" onmouseover="document.getElementById('div1').style.display = 'block';" onmouseout="document.getElementById('div1').style.display = 'none';" >	<a href="archive.php">Archive</a>
            <div id="div1" style="display: none; position: absolute; right: 0px; top: 60px; text-align: center; width: 60px; height: 30px; padding:10px 22px 8px 22px; border-top: 2px solid rgb(204, 204, 204); color: rgb(255, 204, 51); background: none repeat scroll 0% 0% black;"><a href="detailed.php">Detailed</a></div>
          	
            </div>
            
            <div class="<?php echo $filter; ?>">
          	<a href="filter.php">Filter</a>
            </div>
            
            <div class="<?php echo $balance; ?>">
            <a href="balance.php">Balance</a>
            </div>
            
            <div class="logout">
            <a href="logout.php">Logout</a>
            </div> 
            
        
        </div>
			
                 

	</div>
