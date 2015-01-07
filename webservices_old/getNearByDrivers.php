<?
include("db.php");
/*function for Adding new array to an associative array*/
function array_push_assoc($array, $key, $value)
{
	$array[$key] = $value;
	return $array;
}
/*function to display time in Xhrs Xmin format*/
function display_time($time)
{
	list($int, $dec) = explode('.', $time);
	$int=intval($int);
	$dec=intval($dec);
	if($dec>=60)
	{
		 $dec=$dec-60;
		 $int=$int+1;
	}
	if($int>0&&$dec>0)
	{
		 $time="$int Hrs,$dec Min";
	}
	if($int<=0&&$dec>0)
	{
		 $time="$dec Min.";
	}
	if($int>0&&$dec<=0)
	{
		 $time="$int Hrs.";  
	}	
	return $time;
}

	
	$format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml'; //xml is the default

	

    $LAT1 = $_GET["lat"];
    $LON1 = $_GET["long"];
	$DriverId = $_GET["driverid"];
	/****************************Code to get Prefrred Rerordset by login user************************/
	$Recordset=20;//by default Recordset is 20 it will use for old users. 
	$queryJson="SELECT value FROM w6h8a_community_fields_values where user_id='$DriverId' and field_id=92";	
	$resultJson = mysql_query($queryJson,$link) or die('Errant query:  '.$queryJson);	
	$count=mysql_num_rows($resultJson);
	while($post = mysql_fetch_assoc($resultJson))
	{$Recordset=$post['value'];}	
	/***********Parameters for paging***********/	
	$LwrLmt=0;// by default zero
	$LwrLmt = $_GET["LwrLmt"];
	if($LwrLmt=="")
	$LwrLmt=0;// by default zero
	$UprLmt=$LwrLmt+$Recordset;
	
	/****************************Code to get Distance value set by login user************************/
	$distancevalue=100;
	$queryJson="SELECT value FROM w6h8a_community_fields_values where user_id='$DriverId' and field_id=95";	
	$resultJson = mysql_query($queryJson,$link) or die('Errant query:  '.$queryJson);	
	$count=mysql_num_rows($resultJson);
	while($post = mysql_fetch_assoc($resultJson))
	{$distancevalue=$post['value'];}	
	
	
	/********************************Query to get all userid withen distance********************************/

	/*$queryJson = "SELECT `userid`,`posted_on`, `avatar`, `thumb`,`latitude`, `longitude`,username,email,((ACOS( SIN( $LAT1 * PI( ) /180 )
			* SIN(  `latitude` * PI( ) /180 )
			+ COS( $LAT1 * PI( ) /180 ) 
			* COS(  `latitude` * PI( ) /180 )
			* COS( ( $LON1 -  `longitude` ) 
			* PI( ) /180 ) ) *180 / PI( ))
			*60 * 1.1515) 
			AS distance
			FROM  `w6h8a_community_users` 
			INNER JOIN  `w6h8a_users` ON  `w6h8a_community_users`.UserId =`w6h8a_users`.Id 
			AND w6h8a_community_users.profile_id=2 
			HAVING distance <=$distancevalue ORDER BY distance ASC";*/
			$queryJson = "SELECT w6h8a_community_users.userid,  `posted_on` ,  `avatar` ,  `thumb` , w6h8a_community_favloc.latitude, w6h8a_community_favloc.longitude,
		((ACOS( SIN( $LAT1 * PI( ) /180 )
		* SIN( w6h8a_community_favloc.`latitude` * PI( ) /180 )
		+ COS( $LAT1 * PI( ) /180 )
		* COS( w6h8a_community_favloc.`latitude` * PI( ) /180 ) 
		* COS( ( $LON1 - w6h8a_community_favloc.`longitude` ) 
		* PI( ) /180 ) ) *180 / PI( ))
		*60 * 1.1515) 
		AS distance
FROM  `w6h8a_community_users` 
INNER JOIN  `w6h8a_community_favloc` ON  `w6h8a_community_users`.UserId =  `w6h8a_community_favloc`.userid
AND w6h8a_community_users.profile_id =2
AND w6h8a_community_favloc.isCurrent=1
HAVING distance <=$distancevalue";
			
			//exit;
			$resultJson = mysql_query($queryJson,$link) or die('Errant query:  '.$queryJson);	
			$count=mysql_num_rows($resultJson);
			$posts = array();
			while($post = mysql_fetch_assoc($resultJson))
			{
				$distance=round((floatval($post["distance"])), 2);	
				//$distance=$distance+50;//Test Code.
				$post["distance"]=$distance;
				$userid=$post['userid'];
				if($distance>1)
				{
					
					$time=$distance/50;//Formula:time=distance/speed(by default 10 miles/hrs) 					
					$time=round(floatval($time),2);
					$time=display_time($time);
					
				}			
				else 
				$time=0;	
				//Time is added as extra parameeter in output array
				$post = array_push_assoc($post, 'Time', $time);
				
				/**********************Code to get NAME,username,email  Driver**************************/
				$queryname =  "SELECT name,username,email FROM  `w6h8a_users` WHERE `id`='$userid'";				
				$resultname = mysql_query($queryname,$link) or die('Errant query:  '.$queryname);
				$countname= mysql_num_rows($resultname);
				$recordname = mysql_fetch_assoc($resultname);
				$name = $recordname["name"];
				$username = $recordname["username"];
				$email = $recordname["email"];
				if($name=="")
				$name = "(null)";
				$post = array_push_assoc($post, 'name', $name);
				$post = array_push_assoc($post, 'username', $username);
				$post = array_push_assoc($post, 'email', $email);
				
				$querylandride =  "SELECT value as landride FROM w6h8a_community_fields_values
				WHERE field_id=18 AND `user_id` =  $userid";				
				$resultlandride = mysql_query($querylandride,$link) or die('Errant query:  '.$querylandride);
				$countlandride= mysql_num_rows($resultlandride);
				$recordlandride = mysql_fetch_assoc($resultlandride);
				$Landride = $recordlandride["landride"];
				if($Landride=="")
				$Landride = "(null)";

				$querysearide =  "SELECT value as searide FROM w6h8a_community_fields_values
				WHERE field_id=21 AND `user_id` =  $userid";				
				$resultsearide = mysql_query($querysearide,$link) or die('Errant query:  '.$querysearide);
				$countsearide= mysql_num_rows($resultsearide);
				$recordsearide = mysql_fetch_assoc($resultsearide);
				$Searide = $recordsearide["searide"];
				if($Searide=="")
				$Searide = "(null)";

				$queryairride =  "SELECT value as airride FROM w6h8a_community_fields_values
				WHERE field_id=20 AND `user_id` =  $userid";				
				$resultairride = mysql_query($queryairride,$link) or die('Errant query:  '.$queryairride);
				$countairride= mysql_num_rows($resultairride);
				$recordairride = mysql_fetch_assoc($resultairride);
				$Airride = $recordairride["airride"];
				if($Airride=="")
				$Airride = "(null)";
				
				//Land Sea Air is added as extra parameeter in output array

				$post = array_push_assoc($post, 'Landride', $Landride);			
				$post = array_push_assoc($post, 'Searide', $Searide);
				$post = array_push_assoc($post, 'Airride', $Airride);
				if($post['userid']==$DriverId)
				continue;
				$posts[] = array('post'=>$post); 
			}		 	

//echo "<pre>";
//print_r($posts);
//exit;

$Count=count($posts);
//echo"<br>**************************Code to get paged data****************************<br>";
//echo "Count:".$Count;
$i=0;
$j=0;
$Postx=array();
while($i<$Count)
{
	
	//echo "<pre>";
	//print_r($posts[$i]);	
	
	$posts[$i]['post'] = array_push_assoc($posts[$i]['post'], 'Count', $Count);
	$posts[$i]['post'] = array_push_assoc($posts[$i]['post'], 'Recordset', $Recordset);
	$posts[$i]['post'] = array_push_assoc($posts[$i]['post'], 'RecordNo', $i);
	//echo "<br>After Insert:<br>";
	//echo "<pre>";
	//print_r($posts[$i]);
	if(($i>=$LwrLmt)&&($i<$UprLmt))
	{
		$Postx[$j]=$posts[$i];
		$j++;
	}
	$i++;
	
}
//echo "<pre>";
//print_r($Postx);
//exit;

/* output in necessary format postx */
		  if($format == 'json') 
		  {
			  header('Content-type: application/json');
			  echo json_encode(array('posts'=>$Postx));
		  }
		  else
		  {
			  header('Content-type: text/xml');
			  echo '<posts>';
			  foreach($Postx as $index => $post) {
				  if(is_array($post)) {
					  foreach($post as $key => $value) {
						  echo '<',$key,'>';
						  if(is_array($value)) {
							  foreach($value as $tag => $val) {
								  echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
							  }
						  }
						  echo '</',$key,'>';
					  }
				  }
			  }
			  echo '</posts>';
		  }		  
	  
		  /* disconnect from the db */
		  @mysql_close($link);

?>