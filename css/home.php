<?php include('header.php'); ?>
    
    
    <div class="content_home">
    Home
	<div>
		<?php $query = "SELECT balance FROM driver WHERE driver_id={$_SESSION['driver_id']} ";
	      $db->query($query);
		  $db->singleRecord();
		  echo "Current balance : ".$db->Record['balance']."$";
	?>  
	<br/>
	<?php $query = "SELECT AVG(rating) AS average_rating FROM rate_review_driver WHERE driver_id={$_SESSION['driver_id']} ";
	      $db->query($query);
		  $db->singleRecord();
		  $TotRat = $db->Record['average_rating'];
		  echo "Rating : ".$db->Record['average_rating'];
	?>  
	</div>
	
	<div> 
		<table width="100%">
			<tr>
				<td width="40%">
					<h1>Welcome</h1> <br/>
					The best driver in Almaty
				</td>
				<td>
					<h2> Today you: </h2>
				
		<?php
	         $query="SELECT * FROM ride_confirm WHERE DATE(`created_date`) = 'CURDATE()' AND status=1 AND driver_id={$_SESSION['driver_id']}";			
	         $db->query($query);
			 if($db->numRows() > 0)
			 {
		     $total = $db->numRows();
			 $db->singleRecord();
			 $ResId = $db->Record['ride_responce_id'];
			    echo "<br/> - gave a drive to ".$total." passengers.<br/>";
			 }
			 else
			 {
			 	echo "<br/> - gave a drive to 0 passengers.<br/>";				 
			 }
		?>
		<?php	
		if($ResId !='')
		{	
			$query_earn = "SELECT sum(amount) AS amount FROM ride_responce WHERE ride_responce_id=$ResId AND DATE(`created_date`)=`CURDATE()` ";
			$db->query($query_earn);
			if($db->numRows() >0)
			{
				$db->singleRecord();
		        echo "<br/> - earned  ".$db->Record['amount']."KZT";
		    }
            else {
	              echo "<br/> -earned 0 KZT.";
                 }
		}
		else
		{
			echo"<br/> - earned 0 KZT.<br/>";			
		}
			 
	      ?>
	      <?php
	      $query = "SELECT AVG(rating) AS average_rating FROM rate_review_driver WHERE driver_id={$_SESSION['driver_id']} AND DATE(created_date)=CURDATE() ";
	      $db->query($query);
		  if($db->numRows() >0)
		  {
		  $db->singleRecord();
		  $TodRat = $db->Record['average_rating'];
		  echo "<br/> - increased rating by ".($TotRat-$TodRat)."  stars";
		  }
         else {
	        echo "<br/> - increased rating by 0  stars.<br/>";
         }
		  ?>
	      
	           </td>
			</tr>
		</table>
	</div>
	
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
