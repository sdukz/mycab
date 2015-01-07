<?php 

if( isset($_SESSION) && isset($_SESSION['id']) && isset($_SESSION['username']) && $_SESSION['id'] !='' && $_SESSION['username'] !='')
{ }
else
{
	header("Location:404");	
}


$home = (basename($_SERVER["REQUEST_URI"],'.php') == 'home') ? 'home active_class' : 'home';
$profile = (basename($_SERVER["REQUEST_URI"],'.php') == 'profile') ? 'profile active_class' : 'profile';
$balance = (basename($_SERVER["REQUEST_URI"],'.php') == 'balance') ? 'balance active_class' : 'balance';
$passengers = (basename($_SERVER["REQUEST_URI"],'.php') == 'passengers') ? 'filter active_class' : 'filter';
$drivers = (basename($_SERVER["REQUEST_URI"],'.php') == 'drivers') ? 'archive active_class' : 'archive';
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>MyCab Home</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<link rel="stylesheet" type="text/css" href="css/reset.css" />

<!--This is using for table shorting -->
<link rel="stylesheet" href="css/tableshort/style.css" type="text/css" media="print, projection, screen" />	
<script type="text/javascript" src="css/tableshort/jquery-latest.js"></script>
<script type="text/javascript" src="css/tableshort/jquery.tablesorter.js"></script>
<script type="text/javascript">
	$(function() {		
		$("#tablesorter-demo").tablesorter({sortList:[[0,0],[2,1]], widgets: ['zebra']});
		$("#options").tablesorter({sortList: [[0,0]], headers: { 3:{sorter: false}, 4:{sorter: false}}});
	});	
	</script>
	
	<!--Using For eye in pwd field -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<script>
 $(document).ready(
 
  function () {
$('#signIn').mouseenter(function(){ 
  
$('#a1').removeAttr("text");
 
$('#a1').prop('type','text');
})

$('#signIn').mouseleave(function(){ 
  
$('#a1').removeAttr("text");
 
$('#a1').prop('type','password');
})

})
</script>
<!-- End Eye code -->

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
            <a href="home">Home</a>
             	            	
          	</div>
            
            <div class="<?php echo $profile; ?>">
          	<a href="profile">Profile</a>
            </div>
            
            <div class="<?php echo $drivers; ?>" >
          	<!--<a href="archive.php">Archive</a>-->
          	<a href="drivers">Drivers</a>
          	<!--
			  <br/>
							<a href="add_driver/">Add Driver</a>-->
			  
            </div>
            
            
            <div class="<?php echo $passengers; ?>">
                          <!--<a href="filter.php">Filter</a>-->
                          <a href="passengers">Passengers</a>
                        </div>
            
            
            <div class="<?php echo $balance; ?>">
                       <!--<a href="balance.php">Balance</a>-->
                       <a href="logout">Logout</a>
                                              </div>
                       
           
            
           <!-- <div class="logout">-->
                        <!--<a href="logout.php">Logout</a>-->
                        <!--
                        <a href="logout">Logout</a>
                                                </div>-->
                        
             
            
        
        </div>
			
                 

	</div>