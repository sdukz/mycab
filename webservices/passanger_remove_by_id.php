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
if($_POST['passanger_id']!='')
{
	
	$id         = $_POST['passanger_id'];

    $query = "UPDATE passanger SET status=3
	                  WHERE passanger_id='$id' ";
	$result= mysql_query($query);
	if($result){
		$delete = mysql_query("delete from map_bookmark where passanger_id = '$id'");
		$post = array_push_assoc($post,'message','Passanger has been deleted');
		$status =1;
		$posts= array('data'=> $post,'status'=>$status);
	}else{
		$post = array_push_assoc($post,'message','This passenger is not deleted');
		$status =0;
		$posts= array('data'=> $post,'status'=>$status);
	}
	
}
else
{
	 $post = array_push_assoc($post,'message','Passanger Id is Needed');
	 $status =0;
     $posts= array('data'=> $post,'status'=>$status);
}

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>