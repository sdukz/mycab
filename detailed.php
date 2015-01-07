<?php
include ('header.php');
//include('configure.php');
$CurrentDate = date("Y-m-d H:i:s");

$MonthNo = (isset($_GET['month'])) ? $_GET['month'] :date("m",strtotime($CurrentDate));

$YearNo = (isset($_GET['year'])) ? $_GET['year'] :date("Y",strtotime($CurrentDate));
$Month   = '';
switch ($MonthNo) {
	case '01':
		    $Month = 'January';
		break;
	case '02':
		    $Month = 'February';
		break;
	case '03':
		    $Month = 'March';
		break;
	case '04':
		    $Month = 'April';
		break;
	case '05':
		    $Month = 'May';
		break;
	case '06':
		    $Month = 'June';
		break;
	case '07':
		    $Month = 'July';
		break;
	case '08':
		    $Month = 'August';
		break;
	case '09':
		    $Month = 'September';
		break;
	case '10':
		    $Month = 'October';
		break;
	case '11':
		    $Month = 'November';
		break;
	case '12':
		    $Month = 'December';
		break;
}

?>
<div class="content">
	<table width="100%" border="0" cellspacing="5" cellpadding="0">
		<tr>
			<td colspan="3" height="60" align="center" valign="middle" style="background: none repeat scroll 0% 0% rgb(255, 204, 51); font-size: 28px; color: black;"> <?php echo "Complete Rides In Month - ".$Month; ?></td>
		</tr>
		
		<?php for($j=1; $j<= 31; $j++)
		{
			$j = (strlen($j) ==1) ? "0".$j : $j ;
			$query = "SELECT * FROM ride_confirm WHERE driver_id='{$_SESSION['driver_id']}' AND driver_accept='Yes' AND created_date LIKE '$YearNo-$MonthNo-$j%' ";
			$db->query($query);
		//	echo $db->numRows(); exit;
			if($db->numRows() > 0 )
			{
			?>
			<tr>				
				<td>
				<table width="100%" cellspacing="5" cellpadding="5" border="0" style="background:none repeat scroll 0% 0% rgb(238, 238, 238); color:#000;">
					<tr align="center" valign="middle">
						<td style="background: none repeat scroll 0% 0% rgb(41, 41, 41); color: white;" colspan="2"> <?php echo $Month." ".$j; ?></td>
					</tr>
			<?php
			$totalAmt =0;
			while($db->nextRecord())
			{ 
			?>
			        <tr>
					
			<?php
						 	$passId = $db->Record['passanger_id'];	
					            $passName=  getName($passId);						
							$ResId  = $db->Record['ride_responce_id']; 
								$passAmount= getAmount($ResId);
								$totalAmt += $passAmount;
  							echo"<td style='border-bottom:dashed 1px;'>".$passName."</td>";
							echo"<td style='border-bottom:dashed 1px;' align='right'>$".$passAmount."</td>";
							?>
							</tr>
							  							<?php
									  
									  }
									  ?>
									  <tr>
							  <td colspan="2" align="center">Total : $ <?php echo $totalAmt; ?> </td>
							  </tr>
							  </table>
									  
									  <?php
									  }
									  }
			?>
			</td></tr></table>
			
</div>
 <div style="width: 100%; height: 30px;"></div>
</div>

<?php include 'footer.php'; ?>
<?php


function getName($id)
{
$db2 = new Database();
							 $queryPassName = "SELECT passanger_name FROM passanger WHERE passanger_id=$id ";
							       $db2->query($queryPassName);
									  $db2->nextRecord();
									  $Name =  $db2->Record['passanger_name']; 
									  return $Name;
}
function getAmount($id)
{					
$db1 = new Database();		  
							$queryRideAmount = "SELECT amount FROM ride_responce WHERE ride_responce_id=$id ";
							       $db1->query($queryRideAmount);
									  $db1->nextRecord();
									  $Amount =  $db1->Record['amount']; 
									  return $Amount; 
}
?>
<script>
	$(function() {
		$('#mi-slider').catslider();
	}); 
</script>

</body>
</html>
