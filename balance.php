<?php include('header.php'); ?>

   
    
    <div class="content">
        
    <div style="margin: 0 auto; padding:14%;"> <?php if(isset($_GET) && isset($_GET['payment'])){if($_GET['payment']=='unsuccess') { echo"<center>Your transaction is unsuccessful !</center>"; } if($_GET['payment']=='success') { echo "<center>Transaction successful .</center>"; } } ?>
    <div style="margin: 0 auto; text-align: center; color: yellow; size: 15px;">
    	<h2 style="margin: 0 auto; text-align: center; color: yellow; font-size:28px;">Your Current Balance $ <?php $db->query("SELECT balance FROM driver WHERE driver_id={$_SESSION['driver_id']}"); $db->singleRecord(); echo $db->Record['balance']; ?>  </h2>
    </div>
    <form method="post" name="payment" action="pay/process.php" style="margin-top:50px;">
    	
    	<table style="margin: 0px auto; line-height: 40px;" cellspacing="5">
    		<tr>
    			<td style="background: none repeat scroll 0% 0% rgb(41, 41, 41); padding: 0px 10px;">
    				I want to add to my balance: 
    			</td>
    			<td style="background: none repeat scroll 0% 0% rgb(238, 238, 238); border-radius: 5px 5px 5px 5px; color: black; padding-left: 10px; padding-right: 10px;">
    				$<input type="text" name="amount" / style="border: medium none; background: none repeat scroll 0% 0% transparent; color: black; outline: none;"> 
    			</td>
    			
    		</tr>
    		<tr>
    			<td colspan="2" align="center">
    				<input type="submit" name="submit" value="Add Balance" / style="padding: 11px 25px; float: left; background: none repeat scroll 0% 0% rgb(255, 204, 51); border: 1px solid rgb(211, 163, 18); border-radius: 5px 5px 5px 5px; cursor: pointer; font-size: 16px; margin-top: 50px; width: 100%; outline: medium none;">
    			</td>

    		</tr>
    	</table>
    </form>
    </div>
</div>    

<?php include 'footer.php'; ?>


<script>
$(function() {
$( '#mi-slider' ).catslider();});
</script>




</body>
</html>
