<?php include('header.php'); ?>

   
	 <div class="current_box" style="width:360px">
                <table><tr><td align='left'>
		<?php $query = "SELECT balance FROM driver WHERE driver_id={$_SESSION['driver_id']} ";
	      $db->query($query);
		  $db->singleRecord();
		  echo "Current balance ";?></td><td>:</td><td>$ <?php echo round($db->Record['balance'],2);
	?>  
	</td></tr><tr><td align='left'>
	<?php $query = "SELECT AVG(rating) AS average_rating FROM rate_review_driver WHERE driver_id={$_SESSION['driver_id']} ";
	      $db->query($query);
		  $db->singleRecord();
		  $TotRat = $db->Record['average_rating'];
		  echo "Rating ";?></td><td>:</td><td><?php echo round($db->Record['average_rating'],2);
	?>  
        </td></tr></table>
	</div>   
    
    <div class="content_home">
   
	
	
	<div> 
		<table style="width:100%; height:300px; ">
			<tr>
				<td style="width: 400px; padding: 106px 30px; border-right: 1px dashed rgb(153, 153, 153); font-size: 27px; line-height: 25px;">
					<h1 style="color: rgb(255, 204, 51); font-size: 72px;">Welcome</h1> <br/>
					The best driver in Almaty
				</td>
				<td style="padding: 55px 30px;">
					<h2 style="font-size:30px;"> Today you: </h2>
				
		<?php
		 $ResId = '';
	         $query="SELECT * FROM ride_confirm WHERE DATE(`created_date`) = CURDATE() AND status=1 AND driver_id={$_SESSION['driver_id']}";
		     $db->query($query);
			 if($db->numRows() > 0)
			 {
		     $total = $db->numRows();
			 $db->singleRecord();
			 $ResId = $db->Record['ride_responce_id'];
			    echo "<br/> - gave a drive to ".$total." passengers.";
			 }
			 else
			 {
			 	echo "<br/> - gave a drive to 0 passengers.<br/>";				 
			 }
		?>
		<?php	
		if($ResId !='')
		{	
			$query_earn = "SELECT sum(amount) AS amount FROM ride_responce WHERE ride_responce_id=$ResId AND DATE(`created_date`)=CURDATE() ";
			$db->query($query_earn);
			if($db->numRows() >0)
			{
				$db->singleRecord();
		        echo "<br/> - earned  $ ".round($db->Record['amount'],2);
		    }
            else {
	              echo "<br/> -earned $ 0 .";
                 }
		}
		else
		{
			echo"<br/> - earned $ 0 .<br/>";			
		}
			 
	      ?>
	      <?php
	      $query = "SELECT AVG(rating) AS average_rating FROM rate_review_driver WHERE driver_id={$_SESSION['driver_id']} AND DATE(`created_date`)=CURDATE() ";
		  $db->query($query);
		  if($db->numRows() >0)
		  {
		  $db->singleRecord();
		  $TodRat = $db->Record['average_rating'];
		  echo "<br/> - increased rating by ".round($TodRat,2)."  stars.";
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
	
	     <div style="width: 100%; height: 30px;"></div>
	 
</div>

<?php include 'footer.php'; ?>

<script>
$(function() {
$( '#mi-slider' ).catslider();});
</script>




</body>
</html>
