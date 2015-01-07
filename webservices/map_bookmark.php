<?php
include_once ('configure.php');


$format = 'json';
$post = array();
$posts = array();
$msg = '';

$Current_date = date("Y-m_d H:i:s");
$PassangerId = $_POST['passanger_id'];
$Address = $_POST['address'];
$Latitude = $_POST['latitude'];
$Longitude = $_POST['longitude'];
$BookMarkName = $_POST['bookmark_name'];

if (($PassangerId != '')) {
	if($Latitude !=''){
		if($Longitude !=''){
			$query = "INSERT INTO map_bookmark (passanger_id,address,latitude,longitude,bookmark_name,created_date) VALUES 
		             ('$PassangerId','$Address','$Latitude','$Longitude','$BookMarkName','$Current_date') ";
			$result = mysql_query($query);
			$ins_id = mysql_insert_id();
			
			if ($ins_id > 0 && $ins_id != '') {
				
				
				$map = "SELECT * FROM map_bookmark where  passanger_id=".$PassangerId;
				$result2 = mysql_query($map);
				while($datas = mysql_fetch_assoc($result2)){
					$post[]=$datas;
				}
				$bookmark_id =  $ins_id;
				$message = 'Yes';
				$status = 1;
				$posts = array('data' => $post ,'status'=>$status,'message'=>$message);
			} else {
				$post = array_push_assoc($post, 'message', 'No');
				$status = 0;
				$posts = array('data' => $post ,'status'=>$status);
			}
		}else{
			$post = array_push_assoc($post, 'message', 'Longitude Is Needed');
			$status = 0;
			$posts = array('data' => $post ,'status'=>$status);
		}
	}else{
		$post = array_push_assoc($post, 'message', 'Latitude Is Needed');
		$status = 0;
		$posts = array('data' => $post ,'status'=>$status);
	}
} else {
	$post = array_push_assoc($post, 'message', 'Passanger Id Is Needed');
	$status = 0;
	$posts = array('data' => $post ,'status'=>$status);
}

/* output in necessary format */

if ($format == 'json')
	displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);
?>