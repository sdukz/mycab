<?php
include_once ('configure.php');


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
			$posts['data'][] = $post;
		}
		$posts['status']=1;
	} else {
		$posts = array('message' =>'No Bookmark Added Now','status'=>0);
	}
} else {
    $posts= array('message' =>'Passanger Id Is Needed','status'=>0);
	
}

/* output in necessary format */

if ($format == 'json')
	displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);
?>