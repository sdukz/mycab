<?php
include('configure.php');

$post  = array();
$posts = array();
$format= 'json';
$Current_date = date("Y-m-d H:i:s");

if($_POST['driver_id']!='')
{
	$radious    = $_POST['radious'];
	//$minAmount  = $_POST['min_search_amount'];
	//$maxAmount  = $_POST['max_search_amount'];
	$id         = $_POST['driver_id'];
	$settingStatus = $_POST['status'];
	
	//$query = "UPDATE driver SET radious='$radious',min_search_amount='$minAmount',max_search_amount='$maxAmount',
	//		updated_date='$Current_date' WHERE driver_id='$id' ";
	
	$query = "UPDATE driver SET radious='$radious',display_map='$settingStatus',updated_date='$Current_date' WHERE driver_id='$id' ";
    $result= mysql_query($query);
	$affect= mysql_affected_rows();
	
	if($affect > 0)
	{
		$query = "SELECT 
	          `driver_id`, `driver_name`, `driver_image`, `mobile_no`, `latitude`, `longitude`, `taxi_no`,`licance_id`,
	           `taxi_model`, `taxi_color`, `no_of_seat`,`status`,`busy`,`luggage_carrier`, `child_seat`, `radious`,`balance`,
	           `min_search_amount`,`max_search_amount`, `device_type`,taxi_brand,taxi_year,extra_comment,`created_date`, `updated_date`,`display_map`  
	           FROM driver WHERE driver_id ='$id' AND status =1";
		$result= mysql_fetch_assoc(mysql_query($query));
		$rating = get_driver_average_rating($id);
		$result['average_rating']= $rating;
		$result['message']= 'Yes';
		$result['radious']= $radious;
		$result['setting_status']= $settingStatus;
		$post = array_push_assoc($post,'message','Yes');
		$post = array_push_assoc($post,'radious',$radious);
		$post = array_push_assoc($post,'setting_status',$settingStatus);
		$status = 1;
        $posts= array('data'=> $result,'status'=>$status);
	}
	else
	{
		$post = array_push_assoc($post,'message','No');
		$status = 0;
        $posts= array('data'=> $post,'status'=>$status);
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

if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);

//* disconnect from the db */
@mysql_close($con);

?>