<?php include('header.php');
    
   $query = "SELECT * FROM driver WHERE driver_id={$_SESSION['driver_id']} ";
	      $db->query($query);
		  $db->singleRecord();
 ?> 
    <div class="content">
    
	<table width="100%" align="center">
	<tr>
	<td style="width: 300px; height: 500px; padding:10px;">
    
    <img src="<?php echo $db->Record['driver_image']; ?>" class="profile_img">
    <a href="edit_profile.php"><input type="button" value="Edit Profile" style="padding: 11px 25px;float: left;background: none repeat scroll 0% 0% rgb(255, 204, 51);border: 1px solid rgb(211, 163, 18);border-radius: 5px 5px 5px 5px;cursor: pointer; font-size: 16px; margin-top:50px; width:100%; outline:none"></a>
    
    </td>
	<td align="left" style="line-height: 40px; padding-left:40px;">
	<h1 style="font-size: 42px; line-height: 50px; padding:0px 0px 30px 5px; "><?php echo $db->Record['driver_name']; ?></h1>
	<table cellspacing="5" style="width:100%;">
	<tr>
	<td class="profile_field details_static">Mobile No</td><td class="profile_field details_dynamic"> <?php echo $db->Record['mobile_no']; ?></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Taxi No</td><td class="profile_field details_dynamic"> <?php echo $db->Record['taxi_no']; ?></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Taxi Model</td><td class="profile_field details_dynamic"><?php echo $db->Record['taxi_model']; ?></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Licence Id</td><td class="profile_field details_dynamic"> <?php echo $db->Record['licance_id']; ?></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Taxi Color</td><td class="profile_field details_dynamic"> <?php echo $db->Record['taxi_color']; ?></td>
	</tr>
	<tr>
	<td class="profile_field details_static">No of seats in taxi</td><td class="profile_field details_dynamic"> <?php echo $db->Record['no_of_seat']; ?></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Child Seat</td><td class="profile_field details_dynamic"> <?php echo $db->Record['child_seat']; ?></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Luggage Carrier</td><td class="profile_field details_dynamic"> <?php echo $db->Record['luggage_carrier']; ?></td>
	</tr>
	<tr>
	<td class="profile_field details_static">Busy Status</td><td class="profile_field details_dynamic"> <?php echo $db->Record['busy']; ?></td>
	</tr>
	
	</table>
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
