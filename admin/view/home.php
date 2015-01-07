<?php include('header.php'); ?>


	 <div class="current_box" style="width: 390px;">
	 	<table> <tr> <td align="left"> 
	 	<?php echo"Total My Cab Earned "; ?></td><td>:</td><td>$<?php echo $totalE = ($totalE =='' || $totalE == '0') ? 00.00 : round($totalE,2);	?>
	 	</td></tr><tr><td align="left">
		<?php echo "Total My Cab Drivers "; ?></td><td>:</td><td><?php echo $totalD;	?>  
	 </td></tr><tr><td align="left">
	    <?php echo "Total My Cab Passengers "; ?></td><td>:</td><td><?php echo $totalP;	?>	
	    </td></tr></table>     
	</div>   
    
    <div class="content_home">
   
	
	
	<div> 
		<table style="width:100%; height:300px; ">
			<tr>
				<td style="width: 400px; padding: 106px 30px; border-right: 1px dashed rgb(153, 153, 153); font-size: 27px; line-height: 25px;">
					<h1 style="color: rgb(255, 204, 51); font-size: 72px;">Welcome</h1> <br/>
					<!--The best driver in Almaty-->
				</td>
				<td style="padding: 55px 30px;">
					<h2 style="font-size:30px;"> Today : </h2>
				<table><tr><td>
		<?php echo "Joined Drivers </td><td>:</td><td> ".$todayD;	?></td></tr>
		<tr><td>
		<?php echo "Joined Passengers </td><td>:</td><td> ".$todayP; ?> </td></tr>
		<tr><td>
		<?php echo "Earning </td><td>:</td><td> $".$todayE = ($todayE == '' || $todayE ==0) ? 00.00 : round($todayE,2) ;?> </td></tr>
	      </table>
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
