<?php

include_once('configure.php');

/*
echo"<pre>";
print_r($_POST);
exit;
*/

$format = 'json';
$post   = array();
$posts  = array();
$msg    = '';
$Current_date = date("Y-m_d H:i:s");

		$Lati  = $_POST['latitude'];
		$Logi  =$_POST['longitude'];
		$Radious = 2;
		
		$query = "SELECT *,(((ACOS( SIN( $Lati * PI( ) /180 ) * SIN( `latitude` * PI( ) /180 ) + COS( $Lati * PI( ) /180 ) *
	     COS( `latitude` * PI( ) /180 ) * COS( ( $Logi - `longitude` ) * PI( ) /180 ) ) *180 / PI( )) *60 * 1.1515) * 1.60934) 
	     AS distance FROM driver WHERE status=1 AND busy='No' HAVING distance <= '2'";

        $result= mysql_query($query);
        $count = mysql_num_rows($result);
		if($count >0)
         {
   	        while($post = mysql_fetch_assoc($result))	
               {
               	       $posts[] = $post;  	
      		   }   	
          }
   		else
		 {
//	 		$post = array_push_assoc($post,'message','No');
//			$posts[] =  $post;
            $posts[] = array('message'=>'No');
		 }

/* output in necessary format */
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($posts);

//* disconnect from the db */
@mysql_close($con);


?>