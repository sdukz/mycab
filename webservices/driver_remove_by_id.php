<?php

include('configure.php');

$post  = array();
$posts = array();
$format= 'json';
$Current_date = date("Y-m-d H:i:s");

/*if(array_key_exists('passanger_image',$_POST))
   {
	    $imgstring = $_POST['passanger_image'];
        $_POST['passanger_image']= strlen($_POST['passanger_image']) ?  save_image(trim($imgstring)) : '';
   }*/
if($_POST['driver_id']!='')
{
	
	$id         = $_POST['driver_id'];

    $query = "UPDATE driver SET status=3
	                  WHERE driver_id='$id' ";
	$result= mysql_query($query);
	if($result){
		//$delete = mysql_query("delete from map_bookmark where passanger_id = '$id'");
		$post = array_push_assoc($post,'message','Driver has been deleted');
		$status =1;
		$posts= array('data'=> $post,'status'=>$status);
	}else{
		$post = array_push_assoc($post,'message','This driver is not deleted');
		$status =0;
		$posts= array('data'=> $post,'status'=>$status);
	}
	
}
else
{
	 $post = array_push_assoc($post,'message','Driver Id is Needed');
	 $status =0;
     $posts= array('data'=> $post,'status'=>$status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>