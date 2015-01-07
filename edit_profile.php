<?php 
    include('header.php'); 
	$query = "SELECT * FROM driver WHERE driver_id={$_SESSION['driver_id']} ";
	      $db->query($query);
		  $db->singleRecord();
?>
    
    <div class="content">
    
    <div style="text-align: center; color: red;"><?php if(isset($_GET) && isset($_GET['update'])) { if($_GET['update']=='success')echo"Updated Successfully!"; if($_GET['update']=='unsuccess')echo"Not Updated! !"; } ?> </div>
    <form method="post" name="updateDriverDetail" action="update.php" enctype="multipart/form-data">
	<table width="100%" align="center">
	<tr>
	<td style="width: 300px; height: 500px; padding:10px;"><img class="profile_img" src="<?php echo $db->Record['driver_image']; ?>" >
    <!--<a href="edit_profile.php">-->
    	<input type="submit" value="Update" style="padding: 11px 25px;float: left;background: none repeat scroll 0% 0% rgb(255, 204, 51);border: 1px solid rgb(211, 163, 18);border-radius: 5px 5px 5px 5px;cursor: pointer; font-size: 16px; margin-top:50px; width:100%; outline:none;">
    	<!--</a>-->
    </td>
	<td align="left" style="line-height: 40px; padding-left:40px;">
	<h1 style="font-size: 42px; line-height: 50px; padding:0px 0px 30px 5px;" ><?php echo $db->Record['driver_name']; ?></h1>
	<table cellspacing="5" width="100%">
	<tr>
	<td class="profile_field details_static">Name</td><td class="profile_field details_edit"> <input type="text" name="driver_name" id="testString" value="<?php echo $db->Record['driver_name']; ?>" required="required" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Profile Picture</td><td class="profile_field details_edit"> <input type="file" name="driver_image" accept="image/*"  style="padding: 0px; width: auto;"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Mobile No</td><td class="profile_field details_edit"> <input type="text" maxlength="11" name="mobile_no" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="<?php echo $db->Record['mobile_no']; ?>" required="required" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Taxi No</td><td class="profile_field details_edit">  <input type="text" name="taxi_no" value="<?php echo $db->Record['taxi_no']; ?>" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Taxi Model</td><td class="profile_field details_edit">  <input type="text" name="taxi_model" value="<?php echo $db->Record['taxi_model']; ?>" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Licence Id</td><td class="profile_field details_edit">  <input type="text" name="licance_id" value="<?php echo $db->Record['licance_id']; ?>" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Taxi Color</td><td class="profile_field details_edit">  <input type="text" name="taxi_color" value="<?php echo $db->Record['taxi_color']; ?>" class="input_field"></td>
	</tr>
	<tr>
	<td class="profile_field details_static">No of seats in taxi</td><td class="profile_field details_edit"> <input type="number" min="1" max="10" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" name="no_of_seat" value="<?php echo $db->Record['no_of_seat']; ?>" required="required" class="input_field" ></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Child Seat</td><td class="profile_field details_edit"> 
	                       <?php $csy=($db->Record['child_seat']=='Yes') ? 'selected=selected' : ''; $csn=($db->Record['child_seat']=='No') ? 'selected=selected' : ''; ?>
						   <select name="child_seat" style="width: 100%; padding: 10px 10px 10px 0px; background: none repeat scroll 0% 0% transparent; border: medium none; outline: none;">
								<option value="Yes" $ <?php echo $csy; ?> >Yes</option>
								<option value="No" $ <?php echo $csn; ?> >No</option>
								</select>
						   </td>
	</tr>
	<tr>
	<td class="profile_field details_static">Luggage Carrier</td><td class="profile_field details_edit"> 
	                            <?php $lcy=($db->Record['luggage_carrier']=='Yes') ? 'selected=selected' : ''; $lcn=($db->Record['luggage_carrier']=='No') ? 'selected=selected' : ''; ?>
								<select name="luggage_carrier" style="width: 100%; outline: none; padding: 10px 10px 10px 0px; background: none repeat scroll 0% 0% transparent; border: medium none; ">
								<option value="Yes" $ <?php echo $lcy; ?> >Yes</option>
								<option value="No" $ <?php echo $lcn; ?> >No</option>
								</select>
								</td>
	</tr>
	<tr>
	<td class="profile_field details_static">Busy Status</td><td class="profile_field details_edit"> 
	                        <?php $by=($db->Record['busy']=='Yes') ? 'selected=selected' : ''; $bn=($db->Record['busy']=='No') ? 'selected=selected' : '';?>
							<select name="busy" style="width: 100%; outline: none; padding: 10px 10px 10px 0px; background: none repeat scroll 0% 0% transparent; border: medium none; ">
								<option value="Yes" $ <?php echo $by; ?> >Yes</option>
								<option value="No" $ <?php echo $bn; ?> >No</option>
								</select>
							</td>
	</tr>
	<tr>
	<td></td><td> <input type="hidden" name="driver_id" value="<?php echo $db->Record['driver_id']; ?>"></td>
	</tr>
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

<script type="text/javascript">
    var txtbx = document.getElementById('testString');

    txtbx.addEventListener('keypress', function (event) {
    	
    	
    	var key = event.which || event.keyCode || event.charCode;
    	   console.log(key);
    	   
    	   if(key =='' || key ==8)
    	   {
    	   	
    	   	return true;
    	   }
        var value = this.value + String.fromCharCode(key);
       // if (!/^(?!\s)[a-zA-Z ]$/.test(value)) {
      
       	
        console.log(value);
        /*if (!/^([a-zA-z ]+)?$/.test(value)) {*/
       	if (!/^([a-zA-Z ]+(_[a-zA-Z]+)*)(\s([a-zA-Z]+(_[a-zA-Z]+)*))*$/.test(value)) {

       // if (!/^\d{0,6}(?:\.\d{0,2})?$/.test(value)) {
            event.preventDefault();
        }

    }, false);
</script>  
<!--
<script type="text/javascript">
    var txtbx = document.getElementById('testNumber');

    txtbx.addEventListener('keypress', function (evt) {
        var value = this.value + String.fromCharCode(evt.which);
       // if (!/^(?!\s)[a-zA-Z ]$/.test(value)) {
        console.log(value);
       // if (!/^([a-zA-z ]+)?$/.test(value)) {

        if (!/^\d{0,11}(?:\.\d{0,2})?$/.test(value)) {
            evt.preventDefault();
        }

    }, false);
</script>   -->



</body>
</html>
