<?php 
    include('header.php');	
?>
    
    
    <div class="content">
    
    <div style="text-align: center; color: red;"><?php if(isset($updated)){ if($updated=='success')echo"Updated Successfully!"; if($updated=='unsuccess')echo"Profile Not Updated !"; }  ?> </div>
    <form method="post" name="updateDriverDetail" action="" enctype="multipart/form-data">
	<table width="100%" align="center">
	<tr>
	<td style="width: 300px; height: 500px; padding:10px;"><img class="profile_img" src="<?php echo $result['driver_image']; ?>" >
    <!--<a href="edit_profile.php">-->
    	<input type="submit" name="update" value="Update" style="padding: 11px 25px;float: left;background: none repeat scroll 0% 0% rgb(255, 204, 51);border: 1px solid rgb(211, 163, 18);border-radius: 5px 5px 5px 5px;cursor: pointer; font-size: 16px; margin-top:50px; width:100%; outline:none;">
    	<!--</a>-->
    </td>
	<td align="left" style="line-height: 40px; padding-left:40px;">
	<h1 style="font-size: 42px; line-height: 50px; padding:0px 0px 30px 5px;" ><?php echo $result['driver_name']; ?></h1>
	<table cellspacing="5" width="100%">
	<tr>
	<td class="profile_field details_static">Name</td><td class="profile_field details_edit"> <input type="text" id="name" name="driver_name" value="<?php echo $result['driver_name']; ?>" required="required" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Profile Picture</td><td class="profile_field details_edit"> <input type="file" name="driver_image" accept="image/*"  class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Mobile No</td><td class="profile_field details_edit"> <input type="text" id="mobileNo" name="mobile_no" value="<?php echo $result['mobile_no']; ?>" required="required" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Taxi No</td><td class="profile_field details_edit">  <input type="text" name="taxi_no" value="<?php echo $result['taxi_no']; ?>" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Taxi Model</td><td class="profile_field details_edit">  <input type="text" name="taxi_model" value="<?php echo $result['taxi_model']; ?>"  class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Licence Id</td><td class="profile_field details_edit">  <input type="text" name="licance_id" value="<?php echo $result['licance_id']; ?>" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Taxi Color</td><td class="profile_field details_edit">  <input type="text" id="taxiColor" name="taxi_color" value="<?php echo $result['taxi_color']; ?>" required="required" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">No of seats in taxi</td><td class="profile_field details_edit"> <input type="number" id="noOfSeat" min="1" max="4" name="no_of_seat" value="<?php echo $result['no_of_seat']; ?>" required="required" class="input_field" ></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Child Seat</td><td class="profile_field details_edit"> 
	                       <?php $csy=($result['child_seat']=='Yes') ? 'selected=selected' : ''; $csn=($result['child_seat']=='No') ? 'selected=selected' : ''; ?>
						   <select name="child_seat" style="width: 100%; outline: none; padding: 10px 10px 10px 0px; background: none repeat scroll 0% 0% transparent; border: medium none; ">
								<option value="Yes" $ <?php echo $csy; ?> >Yes</option>
								<option value="No" $ <?php echo $csn; ?> >No</option>
								</select>
						   </td>
	</tr>
	<tr>
	<td class="profile_field details_static">Luggage Carrier</td><td class="profile_field details_edit"> 
	                            <?php $lcy=($result['luggage_carrier']=='Yes') ? 'selected=selected' : ''; $lcn=($result['luggage_carrier']=='No') ? 'selected=selected' : ''; ?>
								<select name="luggage_carrier" style="width: 100%; outline: none; padding: 10px 10px 10px 0px; background: none repeat scroll 0% 0% transparent; border: medium none; ">
								<option value="Yes" $ <?php echo $lcy; ?> >Yes</option>
								<option value="No" $ <?php echo $lcn; ?> >No</option>
								</select>
								</td>
	</tr>
	<tr>
	<td class="profile_field details_static">Busy Status</td><td class="profile_field details_edit"> 
	                        <?php $by=($result['busy']=='Yes') ? 'selected=selected' : ''; $bn=($result['busy']=='No') ? 'selected=selected' : '';?>
							<select name="busy" style="width: 100%; outline: none; padding: 10px 10px 10px 0px; background: none repeat scroll 0% 0% transparent; border: medium none; ">
								<option value="Yes" $ <?php echo $by; ?> >Yes</option>
								<option value="No" $ <?php echo $bn; ?> >No</option>
								</select>
							</td>
	</tr>
    </table>
    
    
	
	</table>
	</form>
    </div>
	
	    
	    <div style="width: 100%; height: 30px;"></div>
	 
</div>

<?php include 'footer.php'; ?>

<script type="text/javascript">
    var txtbx = document.getElementById('name');

    txtbx.addEventListener('keypress', function (event) {
    	
    	var key = event.which || event.keyCode || event.charCode;
    	   console.log(key);
    	   
    	   if(key =='' || key ==8)
    	   {    	   	
    	   	return true;
    	   }
    	   if(key ==92 || key==94 || key ==95)
    	   {
    	   	return false;
    	   }
        var value = this.value + String.fromCharCode(key);
        console.log(value);
        /*if (!/^([a-zA-z ]+)?$/.test(value)) {*/
        if (!/^([a-zA-Z ]+(_[a-zA-Z]+)*)(\s([a-zA-Z]+(_[a-zA-Z]+)*))*$/.test(value)) {
            event.preventDefault();
        }

    }, false);
</script> 

<script type="text/javascript">
    var txtbx = document.getElementById('taxiColor');

    txtbx.addEventListener('keypress', function (event) {
    	
    	var key = event.which || event.keyCode || event.charCode;
    	   console.log(key);
    	   
    	   if(key =='' || key ==8)
    	   {
    	   	
    	   	return true;
    	   }
        var value = this.value + String.fromCharCode(key);
        console.log(value);
        if (!/^([a-zA-z ]+)?$/.test(value)) {
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

<script type="text/javascript">
    var txtbx = document.getElementById('noOfSeat');

    txtbx.addEventListener('keypress', function (event) {
    	
    	var key = event.which || event.keyCode || event.charCode;
    	   console.log(key);
    	   
    	   if(key =='' || key ==8)
    	   {
    	   	
    	   	return true;
    	   }
        var value = this.value + String.fromCharCode(key);
        console.log(value);
        if (value > 4)
          { false; }
        if (!/^\d{0,1}(?:\.\d{0,2})?$/.test(value)) {
            event.preventDefault();
        }

    }, false);
</script>


</body>
</html>
