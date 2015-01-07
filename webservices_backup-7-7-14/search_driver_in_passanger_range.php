<?php

include_once('configure.php');


$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");

		$Lati  = $_POST['latitude'];
		$Logi  =$_POST['longitude'];
//		$Radious = 2;
		
		$query = "SELECT *,(((ACOS( SIN( $Lati * PI( ) /180 ) * SIN( `latitude` * PI( ) /180 ) + COS( $Lati * PI( ) /180 ) *
	     COS( `latitude` * PI( ) /180 ) * COS( ( $Logi - `longitude` ) * PI( ) /180 ) ) *180 / PI( )) *60 * 1.1515) * 1.60934) 
	     AS distance FROM driver WHERE status=1 AND busy='No' HAVING distance <= '2'";

        $result= mysql_query($query);
        $count = mysql_num_rows($result);
		if($count >0)
         {
   	        while($post = mysql_fetch_assoc($result))	
               {
               		   $post['avg_rating'] = get_driver_average_rating($post['driver_id']);
               	       $posts[] = $post;  	
      		   }   	
          }
   		else
		 {
            $posts[] = array('message'=>'No');
		 }

/* output in necessary format */

if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);


?>