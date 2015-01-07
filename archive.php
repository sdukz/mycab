<?php
include ('header.php');
 ?>    
    
    <div class="content">
    <table width="100%" height="1200" border="0" cellspacing="2" cellpadding="0" class="td_color" align="center" style="text-align:center; color:#000">
  <tr valign="middle">
    <td height="60" colspan="14" style="background: none repeat scroll 0% 0% rgb(255, 204, 51); font-size:28px;" >Yearly Calendar</td>
    
  </tr>
  <tr valign="middle">
    <td style="background:#292929; color:#fff;">Days</td>
    <td style="background:#292929; color:#FFF"><a href="detailed.php?month=01">Jan</a></td>
    <td style="background:#292929; color:#FFF"><a href="detailed.php?month=02">Feb</td>
    <td  style="background:#292929; color:#FFF" ><a href="detailed.php?month=03">Mar</td>
    <td  style="background:#292929; color:#FFF" ><a href="detailed.php?month=04">Apr</td>
    <td  style="background:#292929; color:#FFF" ><a href="detailed.php?month=05">May</td>
    <td  style="background:#292929; color:#FFF" ><a href="detailed.php?month=06">Jun</td>
    <td  style="background:#292929; color:#FFF" ><a href="detailed.php?month=07">Jul</td>
    <td  style="background:#292929; color:#FFF" ><a href="detailed.php?month=08">Aug</td>
    <td  style="background:#292929; color:#FFF" ><a href="detailed.php?month=09">Sep</td>
    <td  style="background:#292929; color:#FFF" ><a href="detailed.php?month=10">Oct</td>
    <td  style="background:#292929; color:#FFF" ><a href="detailed.php?month=11">Nov</td>
    <td  style="background:#292929; color:#FFF" ><a href="detailed.php?month=12">Dec</td>
    <!--<td  style="background:#292929; color:#FFF" >Total</td>-->
  </tr>
 <?php
    $i='';
	$j='';
	  for($i=1; $i<=31; $i++)
	  {
	  	$i = (strlen($i)==1) ? '0'.$i : $i ;
  ?>
  <tr valign="middle">
  	<td style="background:#292929; color:#fff;"><?php echo $i; ?></td>
  	<?php
	  	for($j=1; $j<=12; $j++)
		{
			$j = (strlen($j)==1) ? '0'.$j : $j ;
		?>    
    
    	<?php
		$query = "SELECT count(*) AS Total FROM `ride_confirm` WHERE `driver_id`='{$_SESSION['driver_id']}' AND created_date LIKE '2013-$j-$i%' ";
		$db->query($query);
			$db->singleRecord();
			if($db->Record['Total'] >0)
			{
			echo "<td style='background:#FFCC33;'>".$db->Record['Total']."</td>";
			}
			else { echo "<td>00</td>"; }
			?>
			</td>
			<?php	} ?>
    <!--<td>91</td>-->
  </tr>
  <?php	  } ?>  
  <tr valign="middle">
    <td height="60" colspan="13" style="background: none repeat scroll 0% 0% rgb(255, 204, 51); font-size:28px;" >Grand Total</td>
    <!--<td>2821</td>-->
  </tr>
</table>

    </div>
	
	    <div style="width: 100%; height: 30px;"></div>
	    
	 
</div>

<?php include 'footer.php'; ?>

<script>
	$(function() {
		$('#mi-slider').catslider();
	});
</script>

<style type="text/css">
	.td_color tr td {
		background: #eee;
	}

</style>




</body>
</html>
