<?php
/*
echo $ImagePath = 'http://'.$_SERVER["HTTP_HOST"].'/Mycab/avatar/';*/
/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
exit;*/
/*
print_r($_POST);
foreach ($_POST->H2HXmlRequest as $game) {
    echo (string) $game->name;
}

exit;
$xml = file_get_contents($_POST);
echo $xml;
echo "hi";
exit;

$xml = simplexml_load_string($xml);
foreach ($xml->games->game as $game) {
    echo (string) $game->name;
}*/


/*********************/


/*********************/
include('configure.php');

$post  = array();
$posts = array();
$format= 'json';
$Current_date = date("Y-m-d H:i:s");

if(array_key_exists('passanger_image',$_POST))
   {
	    $imgstring = $_POST['passanger_image'];
        $_POST['passanger_image']= strlen($_POST['passanger_image']) ?  save_image(trim($imgstring)) : '';
   }
if($_POST['passanger_id']!='')
{
	$Name       = $_POST['passanger_name'];
	$Image      = $_POST['passanger_image'];
//	$CountryCode= $_POST['country_code'];
	//$MobNo      = $_POST['mobile_no'];
	$id         = $_POST['passanger_id'];
	
//	$query = "UPDATE passanger SET passanger_name='$Name',passanger_image='$Image',country_code='$CountryCode',mobile_no='$MobNo',
//	          updated_date='$Current_date'
//	                  WHERE passanger_id='$id' ";
    	$query = "UPDATE passanger SET passanger_name='$Name',passanger_image='$Image',
	          updated_date='$Current_date'
	                  WHERE passanger_id='$id' ";
	$result= mysql_query($query);
	$affect= mysql_affected_rows();
	
	if($affect > 0)
	{
		$post = array_push_assoc($post,'message','Record Updated Successfully');
        $posts= array('post'=> $post);
	}
	else
	{
		$post = array_push_assoc($post,'message','Record Not Updated');
        $posts= array('post'=> $post);
	}
}
else
{
	 $post = array_push_assoc($post,'message','Passanger Id is Needed');
     $posts= array('post'=> $post);
}

/* output in necessary format */
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>