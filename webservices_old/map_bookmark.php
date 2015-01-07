<?php
include_once ('configure.php');

/*
 echo"<pre>";
 print_r($_POST);
 exit;
 */

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

	$query = "INSERT INTO map_bookmark (passanger_id,address,latitude,longitude,bookmark_name,created_date) VALUES 
             ('$PassangerId','$Address','$Latitude','$Longitude','$BookMarkName','$Current_date') ";
	$result = mysql_query($query);
	$ins_id = mysql_insert_id();

	if ($ins_id > 0 && $ins_id != '') {
		$post = array_push_assoc($post, 'message', 'Yes');
		$post = array_push_assoc($post, 'bookmark_id', $ins_id);
		$posts = array('post' => $post);
	} else {
		$post = array_push_assoc($post, 'message', 'No');
		$posts = array('post' => $post);
	}
} else {
	$post = array_push_assoc($post, 'message', 'Passanger Id Is Needed');
	$posts = array('post' => $post);
}

/* output in necessary format */
if ($format == 'xml')
	displayXmlOutput($result_xml);
if ($format == 'nxml')
	displayNativeXmlOutput($result_json);
if ($format == 'json')
	displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);
?>