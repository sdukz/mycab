<?php include('header.php'); ?>

   
    
    <div class="content">
        
    <div style="margin: 0 auto; padding:14%;"> <?php if(isset($_GET) && isset($_GET['payment'])){if($_GET['payment']=='unsuccess') { echo"Your transaction is unsuccessful !"; } if($_GET['payment']=='success') { echo "<center>Transaction successful .</center>"; } } ?>
    <div style="margin: 0 auto; text-align: center; color: yellow; size: 15px;">
    	<h2 style="margin: 0 auto; text-align: center; color: yellow; font-size:28px;">
    		    				Page Not Found : Error 404 </h2>		
	
Ooops ! Really sorry but something has gone wrong and the page you are looking for cannot be found.
<br />
<center>
<script>
function goBack()
  {
  window.history.back()
  }
</script>
<br />
<center> <input type="button" value="Go Back" onclick="goBack()" /> </center>

    </div>
    
    </div>
</div>    

<?php include 'footer.php'; ?>


<script>
$(function() {
$( '#mi-slider' ).catslider();});
</script>




</body>
</html>
