<?php
include('configure.php');

$post  = array();
$posts = array();
$format= 'json';
$Current_date = date("Y-m-d H:i:s");

if($_POST['driver_id']!='')
{
	$radious    = $_POST['radious'];
	$minAmount  = $_POST['min_search_amount'];
	$maxAmount  = $_POST['max_search_amount'];
	$id         = $_POST['driver_id'];
	
	$query = "UPDATE driver SET radious='$radious',min_search_amount='$minAmount',max_search_amount='$maxAmount',
			updated_date='$Current_date' WHERE driver_id='$id' ";
    $result= mysql_query($query);
	$affect= mysql_affected_rows();
	
	if($affect > 0)
	{
		$post = array_push_assoc($post,'message','Yes');
		$post = array_push_assoc($post,'radious',$radious);
        $posts= array('post'=> $post);
	}
	else
	{
		$post = array_push_assoc($post,'message','No');
        $posts= array('post'=> $post);
	}
}
else
{
	 $post = array_push_assoc($post,'message','Driver Id is Needed');
     $posts= array('post'=> $post);
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