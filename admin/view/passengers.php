<?php include('header.php'); ?>
   
   <center><font color="yellow">
                        <?php if($deleted !=''&& $deleted=='success') echo "Deleted Successfully!"; if($deleted !=''&& $deleted=='unsuccess')  echo "Deleted Unsucccess!"; ?>
                        <?php if($status !=''&& $status=='success') echo "Status Changed Successfully!"; if($status !=''&& $status=='unsuccess')  echo "Status didn't Changed!"; ?>
                   
     </font>    
        </center>
    
    <div class="content">
    
    	<table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
    		<thead>    		
     	<tr>
     		<th>
     			Name
     		</th>
     		<th>
     			Mobile No
     		</th>
     		<th>
     			Joining Date
     		</th>
     		<th>
     			Operations
     		</th>
     	</tr>
     	</thead>
     	<tbody>
    <?php
    if(isset($result['message']))
	{
	?>
	<tr>
		<td colspan="4">
			<h2> No User Available!</h2>
		</td>
	</tr>
	<?php
	}
	else{
        for($i=0; $i<$record; $i++)
		{   
     ?>     
     	<tr>
     		<td>
     			<?php echo $result[$i]['passanger_name']; ?>
     		</td>
     		<td>
     			<?php echo $result[$i]['mobile_no']; ?>
     		</td>
     		<td>
     			<?php echo $result[$i]['created_date']; ?>
     		</td>
     		<td>
     			<a href="passengers?id=<?php echo $result[$i]['passanger_id']; ?>&type=passengers&operation=delete" title="Delere passengers">
     				<img src="images/delete.png" />
     				</a> &nbsp; 
     			<a href="passengers?id=<?php echo $result[$i]['passanger_id']; ?>&type=passengers&operation=status&status=<?php echo $result[$i]['status']; ?>">
     				<?php  $img = ($result[$i]['status']==1) ? 'status_a.png' : 'status_na.png';  ?>
     				<img src="images/<?php echo $img; ?>" />
     				</a> &nbsp; 
     			<a href="edit_passenger?id=<?php echo $result[$i]['passanger_id']; ?>">
     				<img src="images/edit.png" />
     				</a>
     		</td>
     	</tr>     
     <?php
		}
	}    
    ?>
    </tbody>
     </table>
     
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
