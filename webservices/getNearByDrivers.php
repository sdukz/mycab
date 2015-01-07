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
		$driverid =$_POST['driverid'];
		//echo "SELECT `driver_id`,`driver_name`,`latitude`,`longitude`,`radious` FROM driver WHERE status=1 AND (busy='No' or busy='')  AND driver_id=".$driverid;
		$driverdata = mysql_fetch_assoc(mysql_query("SELECT `driver_id`,`driver_name`,`latitude`,`longitude`,`radious` FROM driver WHERE status=1 AND (busy='No' or busy='')  AND driver_id=".$driverid));
		//print_r($driverdata);
//		$Radious = 2;
		// driver_id,driver_name,lat,long,time_to_reach,price,rating,number_of_ratings
		/*$query = "SELECT `driver_id`,`driver_name`,`latitude`,`longitude`,`radious`,(((ACOS( SIN( $Lati * PI( ) /180 ) * SIN( `latitude` * PI( ) /180 ) + COS( $Lati * PI( ) /180 ) *
	     COS( `latitude` * PI( ) /180 ) * COS( ( $Logi - `longitude` ) * PI( ) /180 ) ) *180 / PI( )) *60 * 1.1515) * 1.60934) 
	     AS distance FROM driver WHERE status=1 AND busy='No' HAVING distance <= radious";*/
	     
	     if(isset($driverdata['radious']) || $driverdata['radious'] !=''){
		     $query = "SELECT *,(((ACOS( SIN( $Lati * PI( ) /180 ) * SIN( `latitude` * PI( ) /180 ) + COS( $Lati * PI( ) /180 ) *
		     COS( `latitude` * PI( ) /180 ) * COS( ( $Logi - `longitude` ) * PI( ) /180 ) ) *180 / PI( )) *60 * 1.1515) * 1.60934) 
		     AS distance FROM passanger WHERE display_map=1 and  status=1 HAVING distance <= ".$driverdata['radious'];
	
	        $result= mysql_query($query);
	        $count = mysql_num_rows($result);
			if($count >0)
	         {
	   	        while($post = mysql_fetch_assoc($result))	
	               {
	               		   $post['avg_rating'] = get_passanger_average_rating($post['passanger_id']);
						   $post['total_rating'] = get_passanger_total_rating($post['passanger_id']);
	               	       $posts[] = $post;  	
	      		   }   
				   $status = 1;	
				   $posts1= array('passanger'=> $posts,'status'=>$status);
	          }
	   		else
			 {
			 	$post = array_push_assoc($post,'message','No passanger Found');
	            $posts[] = $post;
				$status = 0;	
				$posts1= array('passanger'=> $posts,'status'=>$status);
			 }
		 }else{
		 	$post = array_push_assoc($post,'message','No Driver Found');
	            $posts[] = $post;
				$status = 0;	
				$posts1= array('passanger'=> $posts,'status'=>$status);
		 }

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts1);

//* disconnect from the db */
@mysql_close($con);


?>