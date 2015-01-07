<?php

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
	$Name       = ucfirst($_POST['passanger_name']);
	$Image      = $_POST['passanger_image'];
	$id         = $_POST['passanger_id'];

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

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);

?>