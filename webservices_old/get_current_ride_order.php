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
$Pass   = array();

$DriverId       = $_POST['driver_id'];
//$Radious        = $_POST['radious'];
//$Lati           = $_POST['latitude'];
//$Logi           = $_POST['longitude'];


if($_POST['driver_id'] !='')
{
	$query_d = "SELECT driver_id,latitude,longitude,radious,child_seat,luggage_carrier,no_of_seat,balance,min_search_amount,max_search_amount FROM driver WHERE driver_id=$DriverId ";
    $result_d= mysql_query($query_d);
    $count_d = mysql_num_rows($result_d);

    if($count_d > 0)
      {
      	$row_d = mysql_fetch_assoc($result_d);
//print_r($row_d);
//exit;
/*
echo $row_d['balance'];
exit;*/
        if($row_d['balance'] !=0)
		{
		
		$Lati  = $row_d['latitude'];
		$Logi  = $row_d['longitude'];
		$Radious = $row_d['radious'];

		$ChildSeat= $row_d['child_seat'];
		$LuggCarr = $row_d['luggage_carrier'];
		$NoOfSeat = $row_d['no_of_seat'];
		$Balance  = $row_d['balance'];  
		$MinAmount= $row_d['min_search_amount'];
		$MaxAmount= $row_d['max_search_amount'];   
		
		$ResIds   = get_responded_request_id($DriverId);
        
	    $query = "SELECT *,(((ACOS( SIN( $Lati * PI( ) /180 ) * SIN( `source_latitude` * PI( ) /180 ) + COS( $Lati * PI( ) /180 ) *
	     COS( `source_latitude` * PI( ) /180 ) * COS( ( $Logi - `source_longitude` ) * PI( ) /180 ) ) *180 / PI( )) *60 * 1.1515) * 1.60934) 
	     AS distance FROM ride_request WHERE status=1 AND amount >= $MinAmount AND amount <= $MaxAmount AND ride_request_id NOT IN($ResIds) HAVING distance <= '$Radious' ORDER BY created_date DESC";


/*
echo $query;
exit;*/


        $result= mysql_query($query);
        $count = mysql_num_rows($result);
        if($count >0)
         {
   	        while($post = mysql_fetch_assoc($result))	
               {
               	if($post['extra_luggage']=='Yes' && $LuggCarr =='No')
				{ continue; }
                if($post['child_seat']=='Yes' && $ChildSeat =='No')
                { continue; }   
                if($post['passanger_count'] > $NoOfSeat)
                { continue; }
				if(($post['amount']/100)*10 > $Balance)
				{ continue; }
				
				$TotalRides  = get_passanger_total_rides($post['passanger_id']);
				$TotalHazRu  = get_total_times_haz_rude($post['passanger_id']);
				$TotalSpoIn  = get_total_times_spoiled_interier($post['passanger_id']);
				$TotalNtC2C  = get_total_times_did_not_come_to_car($post['passanger_id']);
				$TotalCanOr  = get_total_times_cancled_order($post['passanger_id']);
				$Pass        = get_passanger_name_image_by_id($post['passanger_id']);
				if(isset($Pass) && $Pass !='' && $Pass !=null)
				{				
				$post    = array_push_assoc($post,'passanger_image',$Pass['passanger_image']);
				}
				$post    = array_push_assoc($post,'total_rides_of_passanger',$TotalRides);
				$post    = array_push_assoc($post,'haz_rude,',$TotalHazRu);
				$post    = array_push_assoc($post,'poiled_interier',$TotalSpoIn);
				$post    = array_push_assoc($post,'did_not_come_to_car',$TotalNtC2C);
				$post    = array_push_assoc($post,'cancel_orders',$TotalCanOr);				      
      	        
      	        $posts[] = $post;  	
      		   }	     		   
      		   if(empty($posts))
               $posts[]=array('message'=>'No ride match to your profile');
          }
   		else
		 {
//	 		$post = array_push_assoc($post,'message','No');
//			$posts[] =  $post;
			$posts[]=array('message'=>'No');
		 }
	    }
       else
       {
       	$posts[]=array('message'=>'balance is 0');       	
	   }
	}
  else
   {
//   	$post   = array_push_assoc($post,'message','driver_id not exists');
//	$posts[]= $post;
	$posts[]=array('message'=>'driver_id not exists');	
   }
}
else
{
//	$post    = array_push_assoc($post,'message','driver_id needed');
//	$posts[] = $post;	
	$posts[]=array('message'=>'driver_id needed');	
}  
/*
print_r($posts);
exit;*/


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