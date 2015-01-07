<?php

include_once('configure.php');


$format = 'json';
$post   = array();
$posts  = array();
$posts1  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");
  $Lati  = $_POST['latitude'];
				$Logi  =$_POST['longitude'];
				$PassangerId     = $_POST['passanger_id'];
				$Latitude   = $_POST['latitude'];
$Longitude   = $_POST['longitude'];
if(($PassangerId !='' && $Latitude !='' && $Longitude !=''))
{
	$up_query = "UPDATE passanger SET latitude ='$Latitude',longitude='$Longitude',updated_date='$Current_date' WHERE passanger_id ='$PassangerId' AND status =1";
	$up_result= mysql_query($up_query);
	$affect   = mysql_affected_rows();
		
	if($affect >0)
		{			
			 
		//		$Radious = 2;
				// driver_id,driver_name,lat,long,time_to_reach,price,rating,number_of_ratings
				$query = "SELECT `driver_id`,`driver_name`,`latitude`,`longitude`,`radious`,(((ACOS( SIN( $Lati * PI( ) /180 ) * SIN( `latitude` * PI( ) /180 ) + COS( $Lati * PI( ) /180 ) *
			     COS( `latitude` * PI( ) /180 ) * COS( ( $Logi - `longitude` ) * PI( ) /180 ) ) *180 / PI( )) *60 * 1.1515) * 1.60934) 
			     AS distance FROM driver WHERE status=1 AND busy='No' HAVING distance <= radious";
		
		        $result= mysql_query($query);
		        $count = mysql_num_rows($result);
				if($count >0)
		         {
		   	        while($post = mysql_fetch_assoc($result))	
		               {
		               		   $post['avg_rating'] = get_driver_average_rating($post['driver_id']);
							   $post['total_rating'] = get_driver_total_rating($post['driver_id']);
		               	       $posts[] = $post;  	
		      		   }   
					   $status = 1;	
					   $posts1= array('drivers'=> $posts,'status'=>$status);
		          }
		   		else
				 {
				 	$post = array_push_assoc($post,'message','No Driver Found');
		            $posts[] = $post;
					$status = 0;	
					$posts1= array('drivers'=> $posts,'status'=>$status);
				 }
		}
		else
		{
			$post = array_push_assoc($post,'message','No Update');
			$status = 0;
	        $posts = array('data' => $post,'status'=>$status);			
		}
}
else
{
	$post  = array_push_assoc($post,'message','Passanger Id , Latitude And Longitude Is Needed');
	$status = 0;
	$posts = array('data' => $post,'status'=>$status);
}
		

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts1);

//* disconnect from the db */
@mysql_close($con);


?>