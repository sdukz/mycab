<?php 
    include('header.php'); 
	$query = "SELECT * FROM super_admin WHERE id={$_SESSION['id']} ";
	      $db->query($query);
		  $db->singleRecord();
?>
    
    
    <div class="content">
   <!-- Edit Profile-->
    <div style="text-align: center; color: red;"><?php if($_GET['update']=='success')echo"Updated Successfully!"; if($_GET['update']=='unsuccess')echo"Not Updated! !"; ?> </div>
    <form method="post" name="updateDriverDetail" action="update.php" enctype="multipart/form-data">
	<table width="100%" align="center">
	<tr>
	<td><img src="images/admin.jpg" ></td>
	<td align="center">
	<span class="color_18" style="font-family: Niconne, cursive; font-size: 60px;"> <h1><?php echo $db->Record['username']; ?></h1> </span>
	<table>
	<tr>
	<td>User Name :</td><td> <input type="text" name="driver_name" value="<?php echo $db->Record['username']; ?>" required="required"></td>
	</tr>
	<tr>
	<td>Password :</td><td> <input type="password" name="driver_name" value="<?php echo $db->Record['password']; ?>" required="required"></td>
	</tr>
	
	<tr>
	<td colspan="2"> <input type="submit" name="submit" value="Update" > </td>
	</tr>
	</table>
	</form>
    </div>
	
	    
	 
</div>


	
	

    <div id="footer">

	<div id="footer_content">
    
    <div id="copyright">
    © 2023 by Techvalens Pvt. Ltd. All rights reserved.
    </div>
    
    <div id="social_connect">
      <a href="#"><img src="images/fb_icon.png" width="25" height="25"></a>
      <a href="#"><img src="images/twitter_icon.png" width="25" height="25"></a>
      <a href="#"><img src="images/gmail_icon.png" width="25" height="25"></a>
    </div>
    
    </div>

	</div>




<script>
$(function() {
$( '#mi-slider' ).catslider();});
</script>




</body>
</html>
