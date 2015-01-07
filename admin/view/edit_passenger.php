<?php 
    include('header.php');	
?>
    
    
    <div class="content">
    
    <div style="text-align: center; color: red;"><?php if(isset($updated)){ if($updated=='success')echo"Updated Successfully!"; if($updated=='unsuccess')echo"Profile Not Updated !"; }  ?> </div>
    <form method="post" name="updatepassangerDetail" action="" enctype="multipart/form-data">
	<table width="100%" align="center">
	<tr>
	<td style="width: 300px; height: 500px; padding:10px;"><img class="profile_img" src="<?php echo $result['passanger_image']; ?>" >
   <!-- <a href="edit_profile.php">-->
    	<input type="submit" name="update" value="Update" style="padding: 11px 25px;float: left;background: none repeat scroll 0% 0% rgb(255, 204, 51);border: 1px solid rgb(211, 163, 18);border-radius: 5px 5px 5px 5px;cursor: pointer; font-size: 16px; margin-top:50px; width:100%; outline:none;">
    	<!--</a>-->
    </td>
	<td align="left" style="line-height: 40px; padding-left:40px;">
	<h1 style="font-size: 42px; line-height: 50px; padding:0px 0px 30px 5px;" ><?php echo $result['passanger_name']; ?></h1>
	<table cellspacing="5" width="100%">
	<tr>
	<td class="profile_field details_static">Name</td><td class="profile_field details_edit"> <input type="text" id="name" name="passanger_name" value="<?php echo $result['passanger_name']; ?>" required="required" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Profile Picture</td><td class="profile_field details_edit"> <input type="file" name="passenger_image" accept="image/*"  class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Mobile No</td><td class="profile_field details_edit"> <input type="text" id="mobileNo" name="mobile_no" value="<?php echo $result['mobile_no']; ?>" required="required" class="input_field"></td>
	</tr>
    </table>
    
    
	
	</table>
	</form>
    </div>
	
	    
	 
</div>


<?php include 'footer.php'; ?>

<script>
$(function() {
$( '#mi-slider' ).catslider();});
</script>

<script type="text/javascript">
    var txtbx = document.getElementById('name');

    txtbx.addEventListener('keypress', function (event) {
    	
    	var key = event.which || event.keyCode || event.charCode;
    	   console.log(key);
    	   
    	   if(key =='' || key ==8 || !key ==94 || !key ==95 || !key ==47 )
    	   {    	   	
    	   	return true;
    	   }
    	   
        var value = this.value + String.fromCharCode(key);
        console.log(value);
        /*if (!/^([a-zA-z ]+)?$/.test(value)) {*/
       	if (!/^([a-zA-Z ]+(_[a-zA-Z]+)*)(\s([a-zA-Z]+(_[a-zA-Z]+)*))*$/.test(value)) {
            event.preventDefault();
        }

    }, false);
</script> 

<script>
$(function() {
$( '#mi-slider' ).catslider();});
</script>

<script type="text/javascript">
    var txtbx = document.getElementById('mobileNo');

    txtbx.addEventListener('keypress', function (event) {
    	
    	var key = event.which || event.keyCode || event.charCode;
    	   console.log(key);
    	   
    	   if(key =='' || key ==8)
    	   {
    	   	
    	   	return true;
    	   }
        var value = this.value + String.fromCharCode(key);
        console.log(value);
        if (!/^\d{0,11}(?:\.\d{0,2})?$/.test(value)) {
            event.preventDefault();
        }

    }, false);
</script>


</body>
</html>
