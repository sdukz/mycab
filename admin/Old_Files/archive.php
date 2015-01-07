<?php include('header.php'); ?>
    
    
    <div class="content">
    Drivers
    <table>
     	<tr>
     		<th>
     			Name
     		</th>
     		<th>
     			Balance
     		</th>
     		<th>
     			Joining Date
     		</th>
     		<th>
     			Operatoins
     		</th>
     	</tr>
    <?php
         $query = "SELECT * FROM driver";
		 $db->query($query);
		 if($db->numRows() >0)
		 {
		 while($db->nextRecord())
		   {     
     ?>
     
     	<tr>
     		<td>
     			<?php echo $db->Record['driver_name']; ?>
     		</td>
     		<td>
     			<?php echo $db->Record['balance']; ?>
     		</td>
     		<td>
     			<?php echo $db->Record['created_date']; ?>
     		</td>
     		<td>
     			<a href="#" title="Delere driver">D</a> &nbsp; <a href="#">S</a> &nbsp; <a href="#">E</a>
     		</td>
     	</tr>
     
     <?php
		   }
		 }
	 	  
    
    ?>
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
