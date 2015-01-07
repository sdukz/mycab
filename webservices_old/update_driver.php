<?php
/*
echo $ImagePath = 'http://'.$_SERVER["HTTP_HOST"].'/Mycab/avatar/';
print_r($_POST);
exit;*/

include('configure.php');

$post  = array();
$posts = array();
$format= 'json';
$Current_date = date("Y-m-d H:i:s");
if(array_key_exists('driver_image',$_POST))
   {
	    $imgstring = $_POST['driver_image'];
        $_POST['driver_image']= strlen($_POST['driver_image']) ?  save_image(trim($imgstring)) : '';
   }
if($_POST['driver_id']!='')
{
	$Name       = $_POST['driver_name'];
	$Image      = $_POST['driver_image'];
//	$CountryCode= $_POST['country_code'];
	$MobNo      = $_POST['mobile_no'];
	$TaxiModel  = $_POST['taxi_model'];
	$TaxiColor  = $_POST['taxi_color'];
	$NoOfSeat   = $_POST['no_of_seat'];
	$LuggCarr   = $_POST['luggage_carrier'];
	$ChSeat     = $_POST['child_seat'];
	$busy       = $_POST['busy'];
	//$Smoker     = $_POST['smoker'];
	$id         = $_POST['driver_id'];
	$LicanceId         = $_POST['licance_id'];
	
//	$query = "UPDATE driver SET driver_name='$Name',driver_image='$Image',country_code='$CountryCode',mobile_no='$MobNo',taxi_model='$TaxiModel',
//	                taxi_color='$TaxiColor',no_of_seat='$NoOfSeat',luggage_carrier='$LuggCarr',child_seat='$ChSeat',
//	                smoker='$Smoker',updated_date='$Current_date'
//	                  WHERE driver_id='$id' ";
    	$query = "UPDATE driver SET driver_name='$Name',driver_image='$Image',mobile_no='$MobNo',licance_id='$LicanceId',taxi_model='$TaxiModel',
	                taxi_color='$TaxiColor',no_of_seat='$NoOfSeat',luggage_carrier='$LuggCarr',child_seat='$ChSeat',busy='$busy', updated_date='$Current_date'
	                  WHERE driver_id='$id' ";
					  
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
	 $post = array_push_assoc($post,'message','Driver Id is Needed');
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