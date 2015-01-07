<html>
	<head>
		
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<script>
 $(document).ready(
 
  function () {
$('#signIn').mouseenter(function(){ 
  
$('#a1').removeAttr("text");
 
$('#a1').prop('type','text');
})

$('#signIn').mouseleave(function(){ 
  
$('#a1').removeAttr("text");
 
$('#a1').prop('type','password');
})

})
</script>
<body>
  <input type="password" id="a1" name="abc" value ="abc">
	<span id="signIn">abc</span>
</body>
</html>