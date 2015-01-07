<?php 
    include('header.php'); 
?>
    
    
    <div class="content">
    
    <div style="text-align: center; color: red;"><?php if(isset($result['update'])){ if($result['update']=='success')echo"Updated Successfully!"; 
    																			     if($result['update']=='unsuccess')echo"Not Updated! !"; 
    																			     if($result['update']=='mismatch')echo"New Password and Confirm Password mismatch!";
																					 if($result['update']=='blank')echo"New Password and Confirm Password could not be blank!"; 
																					 if($result['update']=='not available')echo"Wrong Old Password !"; } ?> </div>
    <form method="post" name="updateAdminPassword" action="" enctype="multipart/form-data">
	<table width="100%" align="center">
	<tr>
	<td style="width: 300px; height: 500px; padding:10px;"><img class="profile_img" src="images/admin.jpg" >
    <!--<a href="update_password">--><input type="submit" value="Update" name="submit" style="padding: 11px 25px;float: left;background: none repeat scroll 0% 0% rgb(255, 204, 51);border: 1px solid rgb(211, 163, 18);border-radius: 5px 5px 5px 5px;cursor: pointer; font-size: 16px; margin-top:50px; width:100%; outline:none;"><!--</a>-->
    </td>
	<td align="left" style="line-height: 40px; padding-left:40px;">
	<h1 style="font-size: 42px; line-height: 50px; padding:0px 0px 30px 5px;" ><?php echo $result['username']; ?></h1>
	<table cellspacing="5" width="100%">
	<tr>
		<?php //	echo $result['password']; ?>
	<td class="profile_field details_static">Old Password</td><td class="profile_field details_edit"> <input type="password" name="old_password" value="" required="required" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">New Password</td><td class="profile_field details_edit"> 
		<input type="password" id="passwordNew" name="new_password" value="" required="required" class="input_field" style="width: 100%;">
	</td>
	</tr>
	<tr>
	<td class="profile_field details_static">Confirm Password</td><td class="profile_field details_edit"> 
		<input type="password" id="a1" name="confirm_password" value="" required="required" class="input_field" style="width: 80%;"> 
		<span id="signIn">
			<img src="images/eye.png" style="width:40px; height:40px; float:right; cursor: pointer; " />
		</span> 
	</td>
	
    </table>
    
    
	
	</table>
	</form>
    </div>
	
	    
	    <div style="width: 100%; height: 30px;"></div>
	    
	 
</div>

<?php include 'footer.php'; ?>

<script>
$(function() {
$( '#mi-slider' ).catslider();});
</script>


</body>
</html>
