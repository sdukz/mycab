<?php include('header.php'); ?>

<?php
     $query = "SELECT radious,min_search_amount,max_search_amount FROM driver WHERE driver_id='{$_SESSION['driver_id']}' ";
		$db->query($query);
		$db->singleRecord();
?>    
    
    <div class="content">
    <h3><font style="font: 30px/1.4em 'Niconne','cursive'">Change your kilometer radius and set Min & Max Amount for filtering ride orders</font></h3>
    <center>
    	<?php if(isset($_GET['update'])) 
    	        { echo "Successfully Updated."; }
			 else if(isset($_GET['radius']))
			    { echo "Radius Should Between 5 to 50!"; } 
			//  else { echo"Not Updated!"; } ?></center>
    <form method="post" name="filterForm" action="setFilter.php">
    <table cellpadding="10px;" cellspacing="20px;" style="">
    	<tr>
    		<td>
    			Radius (Km)
    		</td>
    		<td>
    			:
    		</td>
    		<td>
    			<div id="range">
                  <input id="bob" name="radious" type="range" min="5" max="50" value="<?php echo $db->Record['radious']; ?>" style="width: 350px;" >
                  <output for="bob">1</output>
                  </div>
    		</td>
    	</tr>
    	<tr>
    		<td>
    			Min Amount
    		</td>
    		<td>
    			:
    		</td>
    		<td class="profile_field details_edit">    			
                  <input name="min_search_amount"  type="text" value="<?php echo $db->Record['min_search_amount']; ?>" class="input_field" >                 
    		</td>
    	</tr>
    	<tr>
    		<td>
    			Max Amount
    		</td>
    		<td>
    			:
    		</td>
    		<td class="profile_field details_edit">    			
                  <input name="max_search_amount" type="text" value="<?php echo $db->Record['max_search_amount']; ?>" class="input_field" >                   
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3">
    			<input name="submit" type="submit" value="Set Filter" style="padding: 11px 25px; float: left; background: none repeat scroll 0% 0% rgb(255, 204, 51); border: 1px solid rgb(211, 163, 18); border-radius: 5px 5px 5px 5px; cursor: pointer; font-size: 16px; margin-top: 50px; width: 100%; outline: medium none;"  >                    
    		</td>
    	</tr>
    </table>   
    </form> 
    								
    </div>
	
	    
	 
</div>


<?php include 'footer.php'; ?>




</body>
</html>
