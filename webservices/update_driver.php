<?php
include('configure.php');

$post  = array();
$posts = array();
$format= 'json';
$Current_date = date("Y-m-d H:i:s");

/*if(array_key_exists('driver_image',$_POST))
   {
	    $imgstring = $_POST['driver_image'];
        $_POST['driver_image']= strlen($_POST['driver_image']) ?  save_image(trim($imgstring)) : 'no data';
   }*/
if($_POST['driver_id']!='')
{
	$Name       = ucfirst($_POST['driver_name']);
	$Image      = $_POST['driver_image'];
	$TaxiModel  = $_POST['taxi_model'];
	$TaxiColor  = $_POST['taxi_color'];
	$NoOfSeat   = $_POST['no_of_seat'];
	$LuggCarr   = $_POST['luggage_carrier'];
	$ChSeat     = $_POST['child_seat'];
	$busy       = $_POST['busy'];
	$id         = $_POST['driver_id'];
	$LicanceId  = $_POST['licance_id'];
	
	$taxiBrand = $_POST['taxi_brand'];
	$taxiYear = $_POST['taxi_year'];
	$extraComment = $_POST['extra_comment'];
	$status = $_POST['status'];
	
    $query = "UPDATE driver SET driver_name='$Name',driver_image='$Image',licance_id='$LicanceId',
    		taxi_model='$TaxiModel',taxi_color='$TaxiColor',no_of_seat='$NoOfSeat',luggage_carrier='$LuggCarr',
    		child_seat='$ChSeat',busy='$busy', updated_date='$Current_date',taxi_brand ='$taxiBrand',taxi_year='$taxiYear',extra_comment='$extraComment',display_map='$status'
	                  WHERE driver_id='$id' ";
					  
	$result= mysql_query($query);
	$affect= mysql_affected_rows();
	
	if($affect > 0)
	{
		$query = "SELECT 
	          `driver_id`, `driver_name`, `driver_image`, `mobile_no`, `latitude`, `longitude`, `taxi_no`,`licance_id`,
	           `taxi_model`, `taxi_color`, `no_of_seat`,`status`,`display_map`,`busy`,`luggage_carrier`, `child_seat`, `radious`,`balance`,`email`,
	           `min_search_amount`,`max_search_amount`, `device_type`,taxi_brand,taxi_year,extra_comment,`created_date`, `updated_date`  
	           FROM driver WHERE driver_id ='$id' AND status =1";
		$result= mysql_fetch_assoc(mysql_query($query));
		$rating = get_driver_average_rating($id);
		$result['average_rating']= $rating;
		$post = array_push_assoc($post,'message','Record Updated Successfully');
		$status =1;
        $posts= array('status'=>$status,'data'=>$result);
	}
	else
	{
		$query = "SELECT * FROM driver WHERE driver_id='$id'";
		$result= mysql_fetch_assoc(mysql_query($query));
		$post = array_push_assoc($post,'message','Record Not Updated');
		$status = 0;
        $posts= array('status'=>$status,'data'=>$result);
	}
}
else
{
	 $post = array_push_assoc($post,'message','Driver Id is Needed');
	 $status = 0;
     $posts= array('data'=> $post,'status'=>$status);
}

/* output in necessary format */
if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>