<?php include('header.php'); ?>

   
    
    <div class="content">
    Balance
    
    <div style="margin: 0 auto;"> <?php if($_GET['payment']=='unsuccess') { echo"Your Payment is Unsuccess!"; } if($_GET['payment']=='success') { echo "Payment Successfully!"; } ?>
    <div style="margin: 0 auto; text-align: center; color: yellow; size: 15px;">
    	<h2>You have: <?php $db->query("SELECT balance FROM driver WHERE driver_id={$_SESSION['driver_id']}"); $db->singleRecord(); echo $db->Record['balance']; ?> $ </h2>
    </div>
    <form method="post" name="payment" action="pay/process.php">
    	
    	<table style="margin: 0 auto;">
    		<tr>
    			<td>
    				I want to add to my balance: 
    			</td>
    			<td>
    				<input type="text" name="amount" /> $
    			</td>
    			
    		</tr>
    		<tr>
    			<td colspan="2" align="center">
    				<input type="submit" name="submit" value="Add Balance" />
    			</td>

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
