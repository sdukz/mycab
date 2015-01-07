<?php include('header.php'); ?>
    
    
    <div class="content">
   <!-- Home-->
   <?php $query1 = "SELECT count(*) AS total FROM driver";
         $db->query($query1);
		 if($db->numRows() >0)
		 {
		 $db->singleRecord();
		 echo "<br/>Total Drivers : ".$db->Record['total'];
		 }
		 else
		 {
		 	echo "<br/>Total Drivers : 00";		 				 
		 }
	?>
	
	<?php $query1 = "SELECT count(*) AS total FROM driver WHERE DATE(created_date)=CURDATE()";
         $db->query($query1);
		 if($db->numRows() >0)
		 {
		 $db->singleRecord();
		 echo "<br/>Today Registered Drivers : ".$db->Record['total'];
		 }
		 else
		 {
		 	echo "<br/>Today Registered Drivers : 00";		 				 
		 }
	 ?>
	 <?php $query1 = "SELECT count(*) AS total FROM passanger";
         $db->query($query1);
		 if($db->numRows() >0)
		 {
		 $db->singleRecord();
		 echo "<br/>Total Passenger : ".$db->Record['total'];
		 }
		 else
		 {
		 	echo "<br/>Total Passenger : 00";		 				 
		 }
	?>
	
	<?php $query1 = "SELECT count(*) AS total FROM passanger WHERE DATE(created_date)=CURDATE()";
         $db->query($query1);
		 if($db->numRows() >0)
		 {
		 $db->singleRecord();
		 echo "<br/>Today Registered Passenger : ".$db->Record['total'];
		 }
		 else
		 {
		 	echo "<br/>Today Registered Passenger : 00";		 				 
		 }
		 
	 ?>
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
