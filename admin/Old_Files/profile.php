<?php include('header.php');
    
   $query = "SELECT * FROM super_admin WHERE id={$_SESSION['id']} ";
	      $db->query($query);
		  $db->singleRecord();
 ?> 
    <div class="content">
   <!-- Profile-->
	<table width="100%" align="center">
	<tr>
	<td><img src="images/admin.jpg"></td>
	<td align="center">
	<span class="color_18" style="font-family: Niconne, cursive; font-size: 60px;"> <h1><?php echo $db->Record['username']; ?></h1> </span>
	<table>
	<tr>
	<td colspan="2"> This is Super Admin Portal . You can change your username and password on clicking bellow button.</td>
	</tr>
	<tr>
	<td colspan="2"><a href="edit_profile.php"><input type="button" value="Edit My Profle"></a></td>
	</tr>
	</table>
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
