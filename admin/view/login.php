<?php 
/*
echo " seession - ";
print_r($_SESSION);
exit;*/

     if(isset($_SESSION) && isset($_SESSION['id']) )
	 { header("Location:home"); }
	 else { }
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>MyCab Admin Login</title>

<link rel="stylesheet" type="text/css" href="./css/style.css" />

<link rel="stylesheet" type="text/css" href="./css/reset.css" />

</head>

<body>

<div id="background">
</div>

<div id="wrapper">
    
    
    <div class="">
    	<!--login form inputs-->
<form name="login-form" class="login-form" action="" method="post">

	<table style="margin: 80px auto; padding:25px; text-align: center; height:400px; margin:80px auto; color:#FFF; background:url(./images/transpix.png) repeat;">
		<tr><td colspan="2" style="height:80px; line-height:80px;"><h1 style="font-size:21px; color:#ffcc33; text-align:left;">Welcome to My Cab</h1> </td></tr>
		
    <tr>
    	
    	<td style="height:50px;" ><input name="username" type="text" class="input username" placeholder="User Name" required="required" style="width:200px; height:30px; padding:5px; border-radius:5px; border:none; outline:none; text-shadow:none;" /></td>
    </tr>
    <tr>
    	
    	<td style="height:50px;"> <input name="password" type="password" class="input password" placeholder="Password" required="required" style="width:200px; height:30px; padding:5px; border-radius:5px; border:none; outline:none; text-shadow:none;" /> </td>
    </tr>
    <tr>
    	<td colspan="2" style="height:30px;" valign="middle">
    		 <!--Login button--><input type="submit" name="submit" value="Login" class="button" style="padding: 11px 25px;
float: left;
background: none repeat scroll 0% 0% rgb(255, 204, 51);
border: 1px solid rgb(211, 163, 18);
border-radius: 5px 5px 5px 5px;
cursor: pointer;
box-shadow: 0px 1px 6px rgba(255, 255, 255, 0.75) inset;
font-size: 16px;" /><!--END Login button-->
    <!--Register button--><input type="reset" name="submit" value="Reset" class="register" style="padding: 11px 25px;
font-size: 16px;
float: right;
background: none repeat scroll 0% 0% transparent;
border-radius: 5px 5px 5px 5px;
cursor: pointer;
color: white;
border: medium none;" /><!--END Register button-->
    	
        </td>
    </tr>
    
    <tr><td colspan="2" style="height:25px; line-height:25px; padding-top:20px;">   
	  <span><?php if($result=='invalid user')
	               { echo 'Invalid Authentication! '; }	  
             ?> 
    </span> </td>
    </tr>
    
	</table>
    
</form>
<!--end login form-->

	</div>
	
	
 </div>
	
<?php include 'footer.php'; ?>

<script>
$(function() {
$( '#mi-slider' ).catslider();});
</script>




</body>
</html>
