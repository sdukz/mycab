<?php include('header.php');
   
   
 ?> 
    <div class="content">
    
	<table width="100%" align="center">
	<tr>
	<td style="width: 300px; height: 500px; padding:10px;">    
    <img src="images/admin.jpg" class="profile_img">
    <a href="update_password">
    	<input type="button" value="Update Password" style="padding: 11px 25px;float: left;background: none repeat scroll 0% 0% rgb(255, 204, 51);border: 1px solid rgb(211, 163, 18);border-radius: 5px 5px 5px 5px;cursor: pointer; font-size: 16px; margin-top:50px; width:100%; outline:none">
    	</a>    
    </td>
   	<td align="left" style="line-height: 40px; padding-left:40px;">    		
	<h1 style="font-size: 42px; line-height: 50px; padding:0px 0px 30px 5px; "><?php echo $result['username']; ?></h1>
	It is Super Admin's Portal . You can change your password by clicking <b>'Update Password'</b> button.
	</td></tr>
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
