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

if (($PassangerId != '')) {

	$query = "SELECT * FROM map_bookmark WHERE passanger_id='$PassangerId' ORDER BY `bookmark_name` ASC";
	$result = mysql_query($query);
	$count = mysql_num_rows($result);

	if ($count > 0 && $count != '') {
		while ($post = mysql_fetch_assoc($result)) {
			$posts[] = $post;
		}
	} else {
//		$post = array_push_assoc($post, 'message', 'No Bookmark Added Now');
		$posts[] = array('message' =>'No Bookmark Added Now');
	}
} else {
//	$post = array_push_assoc($post, 'message', 'Passanger Id Is Needed');
//	$posts[] = array('post' => $post);
    $posts[] = array('message' =>'Passanger Id Is Needed');
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