<?php
/*
 	1 ) array_push_assoc()   -- used to add key and it's value in array for json output like messages etc.
	2 ) displayJsonOutput()  -- use to encode array into json . for json output.
	3 ) genRandomNo()        -- for generate 10 random no from given str '12346789abcdefghjkmnpqrstuvwxyABCDEFGHJKLMNPQRSTUVWXYZ' .
	4 ) save_image()         -- using for saving image in forlder and get name of image by base 64.
	5 ) get_driver_id_for_ride_order() -- return driver's id whose radius circule contain given lat long point.
	6 ) get_driver_name_image_by_id()
    7 ) get_passanger_name_image_by_id()
 *  8 ) get_passanger_id_by_ride_request_id()
 *  9 ) get_driver_or_passanger_id_by_ride_confirm_id()
 *  10) get_request_detail_by_ride_request_id()
 *  11) get_responce_detail_by_ride_responce_id()
 *  12) create_query()
 *  13) check_driver_status_by_id()
 *  14) get_driver_average_rating()
 *  15) get_responded_request_id()
 *  16) get_ride_confirm_detail_by_id()
 *  17) get_drive_status()
 *  18) get_driver_detail_by_id()
 *  19) get_passanger_detail_by_id()
 *  20) get_passanger_rat_by_driver_by_confirm_id()
 *  21) get_passanger_total_ride()
 *  22) get_total_times_haz_rude()
 *  23) get_toal_times_spoled_interier()
 *  24) get_total_times_did_not_come_to_car()
 *  25) 
 *  26) 
   
 */

include('db_webservice.php');

global $Application;

$Application['current_time'] = date('Y-m-d H:i:s');

/**********Some IMP Functions**********************/

function array_push_assoc($array, $key, $value)
{
		$array[$key] = $value;
		return $array;
}

function displayJsonOutput($result='')//Display Output According to JSON Format 
{
	header("Content-type:text/json");
	//change by JK on 10-June-2014
	//echo json_encode(array("posts"=>$result));
	echo json_encode($result);
}

function genRandomNo()
{
	$length = 10;     
	$characters = '12346789abcdefghjkmnpqrstuvwxyABCDEFGHJKLMNPQRSTUVWXYZ';
	$string = '';
	for ($p = 0; $p < $length; $p++)
	{
		$string .= @$characters[@mt_rand(0, @strlen($characters))];
	}
	return $string;
}

function save_image($imgstring)   // this function is for save user avatar image saving
{	
	$imagename=time();
	$ImagePath='';
	$img=false;

	$decodeimage=str_replace(" ","+",$imgstring);	
	$img = imagecreatefromstring(base64_decode($decodeimage));//Code to decode image from base64 to string.//	exit;
	if($img != false)
	{
		     	   
		    $imagename=$imagename.genRandomNo();
			$convimage = imagejpeg($img,'../avatar/'.$imagename.'.jpg');//Code to convert image in jpeg.			
			//$ImagePath = $ApplicationSettings['cover_photo_location'].$imagename.'.jpg';
			$ImagePath = 'http://'.$_SERVER["HTTP_HOST"].'/MyCab_Server/avatar/'.$imagename.'.jpg';		
	}
	else
	{
		$ImagePath="Unable to save image.";
	}
	return $ImagePath;
}

function get_driver_id_for_ride_order($lat,$long,$amount,$child_seat,$luggage_carrier,$no_of_seat)
{
//echo $lat."    ".$long."  ".$amount."   ".$child_seat."   ".$luggage_carrier."  ".$no_of_seat;

	$str = '';
	$amt = ($amount/100)*10;
//echo $amt;
//exit;	
	$query = "SELECT driver.radious AS radious, driver_name,driver_id,balance,luggage_carrier,child_seat,no_of_seat, (
(
(
ACOS( SIN( $lat * PI( ) /180 ) * SIN( `latitude` * PI( ) /180 ) + COS( $lat * PI( ) /180 ) * COS( `latitude` * PI( ) /180 ) * COS( ( $long - `longitude` ) * PI( ) /180 ) ) *180 / PI( )
) *60 * 1.1515
) * 1.60934
) AS distance
FROM `driver` WHERE status=1 AND busy='No' AND balance !=0 AND balance >= $amt AND min_search_amount <= $amount AND max_search_amount >= $amount
HAVING distance < radious "; 
//exit;
	$result = mysql_query($query);
	if(isset($result) && !empty($result)){
		$count  = mysql_num_rows($result);
	}else{
		$count = 0;
	}
	
	if($count >0)
	{
		while($row=mysql_fetch_assoc($result))
	     {
	     	if($luggage_carrier=='Yes' && $row['luggage_carrier'] =='No')
			{ continue; }
            if($child_seat=='Yes' && $row['child_seat'] =='No')
            { continue; }   
            if($no_of_seat > $row['no_of_seat'])
            { continue; }			
	      $str .= $row['driver_id'].",";
	     }
	}
	else
	{
		$str = 0;
	}
	
	return rtrim($str,',');
}

function get_driver_name_image_by_id($DriverId)
{
	$D = array();
	
	$query = "SELECT driver_name,driver_image FROM driver WHERE driver_id=$DriverId";

	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		$row = mysql_fetch_assoc($result);
		$D['driver_name'] = $row['driver_name'];
		$D['driver_image'] = $row['driver_image'];
	}
	
	return $D;
}

function get_passanger_name_image_by_id($PassangerId)
{
	$P = array();
	
	$query = "SELECT passanger_name,passanger_image FROM passanger WHERE passanger_id=$PassangerId";

	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		$row = mysql_fetch_assoc($result);
		$P['passanger_name'] = $row['passanger_name'];
		$P['passanger_image'] = $row['passanger_image'];
	}
	
	return $P;
}

function get_passenger_id_by_ride_request_id($req_id)
{
	$PassId='';
	$query = "SELECT passanger_id FROM ride_request WHERE ride_request_id=$req_id";
	
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		$row = mysql_fetch_assoc($result);
		$PassId= $row['passanger_id'];
	}
	
	return $PassId;
}

function get_driver_or_passanger_id_by_ride_confirm_id($con_id)
{
	$C='';
	$query = "SELECT driver_id,passanger_id FROM ride_confirm WHERE ride_confirm_id=$con_id";
	
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		$row = mysql_fetch_assoc($result);
		$C['driver_id']= $row['driver_id'];
		$C['passanger_id']=$row['passanger_id'];
	}
	
	return $C;	
}

function get_request_detail_by_ride_reqest_id($reqId)
{
	$R = array();
	
	$query = "SELECT * FROM ride_request WHERE ride_request_id=$reqId";

	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	if($count >0)
	{
		$R = mysql_fetch_assoc($result);
	}
	
	return $R;
}

function get_responce_detail_by_ride_responce_id($recId)
{
	$R = array();
	
	$query = "SELECT * FROM ride_responce WHERE ride_responce_id=$recId";

	$result= mysql_query($query);
	if(!empty($result)){
	$count = mysql_num_rows($result);
	}else{
		$count = 0 ;
		
	}
	if($count >0)
	{
		$R = mysql_fetch_assoc($result);
	}
	
	return $R;
}



function create_query($Data,$type,$table)
{
	$col  = '';
	$val  = '';
	$str  = '';
	$query= '';
	$CurD = date("Y-m-d H:i:s");
	$Data = array_filter($Data);
	if(array_key_exists('submit', $Data))
        {	
			unset($Data['submit']);
		}
	
	if($type !='' && $Data !='')
	{		
		switch ($type) 
		{
			case 'insert':
				foreach ($Data as $key => $value) 
				{
					$col .= "`".$key."`,";
					$val .= "`".$value."`,";					
				}
				$col = $col.`created_date`;
				$val = $val.$CurD;
				
				$query = "INSERT INTO $table($col) VALUES ($val)";
				break;
		}
	}
	
	return $query;
}

function check_driver_status_by_id($DriverId)
{
	$busy='';
	$query = "SELECT busy FROM driver WHERE driver_id='$DriverId' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count >0)
	{
		$row = mysql_fetch_assoc($result);
		if($row['busy'] == 'Yes')
		{
			$busy = 'Busy';
		}
		else
		{
			$busy = 'Not_Busy';			
		}
	}
	return $busy;
}

function get_driver_average_rating($DriverId)
{
	$query = "SELECT avg(rating) AS rating FROM rate_review_driver WHERE driver_id='$DriverId' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count >0 && $count !=null)
	{
		$row = mysql_fetch_assoc($result);
		$rating = $row['rating'];
	}
	else
	{
		$rating = 0;		
	}
	$rating = ($rating ==null || $rating ==0 || $rating == NULL) ? 0 : $rating;
	return $rating;
}

function get_driver_total_rating($DriverId)
{
	$query = "SELECT count(*) AS totalrating FROM rate_review_driver WHERE driver_id='$DriverId' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count >0 && $count !=null)
	{
		$row = mysql_fetch_assoc($result);
		$rating = $row['totalrating'];
	}
	else
	{
		$rating = 0;		
	}
	$rating = ($rating ==null || $rating ==0 || $rating == NULL) ? 0 : $rating;
	return $rating;
}


function get_passanger_average_rating($passanger_id)
{
	$query = "SELECT avg(rating) AS rating FROM rate_review_passanger WHERE passanger_id='$passanger_id' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count >0 && $count !=null)
	{
		$row = mysql_fetch_assoc($result);
		$rating = $row['rating'];
	}
	else
	{
		$rating = 0;		
	}
	$rating = ($rating ==null || $rating ==0 || $rating == NULL) ? 0 : $rating;
	return $rating;
}

function get_passanger_total_rating($passanger_id)
{
	$query = "SELECT count(*) AS totalrating FROM rate_review_passanger WHERE passanger_id='$passanger_id' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count >0 && $count !=null)
	{
		$row = mysql_fetch_assoc($result);
		$rating = $row['totalrating'];
	}
	else
	{
		$rating = 0;		
	}
	$rating = ($rating ==null || $rating ==0 || $rating == NULL) ? 0 : $rating;
	return $rating;
}



function get_responded_request_id($DriverId)
{
	$id='';
	$query = "SELECT ride_request_id FROM ride_responce WHERE driver_id='$DriverId' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count >0)
	{
		while($row = mysql_fetch_assoc($result))
		{
			$id .= $row['ride_request_id'].",";			
		}		
	}
	else
	{
		$id = '0';		
	}
	$id = rtrim($id,',');
	return $id;	
}

function get_ride_confirm_detail_by_id($RideConId)
{
	$row='';
	$query = "SELECT * FROM ride_confirm WHERE ride_confirm_id='$RideConId' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count >0)
	{
		$row = mysql_fetch_assoc($result);
	}
	else
	{
		$row = '0';		
	}
	return $row;		
}

function get_drive_status($RidConId)
{
	$stat='';
	$query = "SELECT * FROM ride_confirm WHERE ride_confirm_id='$RideConId' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count >0)
	{
		$row = mysql_fetch_assoc($result);
		$stat= $row['drive_status'];
	}
	else
	{
		$stat = 'No';		
	}
	return $stat;			
}

function get_driver_detail_by_id($DriverId)
{
	$Data='';
	$query = "SELECT * FROM driver WHERE driver_id='$DriverId' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count >0)
	{
		$Data = mysql_fetch_assoc($result);
	}
	else
	{
		$Data = 'No';		
	}
	return $Data;	
}

function get_passanger_detail_by_id($PassId)
{
	$Data='';
	$query = "SELECT * FROM passanger WHERE passanger_id='$PassId' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count >0)
	{
		$Data = mysql_fetch_assoc($result);
	}
	else
	{
		$Data = 'No';		
	}
	return $Data;	
}

function get_passanger_rat_by_driver_by_confirm_id($RideConId)
{
	$Data='';
	$query = "SELECT * FROM rate_review_passanger WHERE ride_confirm_id='$RideConId' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	if($count >0)
	{
		$Data = mysql_fetch_assoc($result);
	}
	else
	{
		$Data = 'No';		
	}
	return $Data;
}

function get_passanger_total_rides($PassId)
{
	//$Data='';
	$query = "SELECT * FROM ride_confirm WHERE passanger_id='$PassId' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	return $count;
}

function get_total_times_haz_rude($PassId)
{
	//$Data='';
	$query = "SELECT * FROM rate_review_passanger WHERE passanger_id='$PassId' AND haz_rude='Yes' OR haz_rude='1' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	return $count;
}

function get_total_times_spoiled_interier($PassId)
{
	//$Data='';
	$query = "SELECT * FROM rate_review_passanger WHERE passanger_id='$PassId' AND spoiled_interier='Yes'  OR spoiled_interier='1' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	return $count;
}

function get_total_times_did_not_come_to_car($PassId)
{
	//$Data='';
	$query = "SELECT * FROM rate_review_passanger WHERE passanger_id='$PassId' AND did_not_come_to_car='Yes'  OR did_not_come_to_car='1'  ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	return $count;
}

function get_total_times_cancled_order($PassId)
{
	//$Data='';
	$query = "SELECT * FROM rate_review_passanger WHERE passanger_id='$PassId' AND cancel_order='Yes'   OR cancel_order='1' ";
	$result= mysql_query($query);
	$count = mysql_num_rows($result);
	
	return $count;
}

/**********************************************************************************/
/* To send sms */
function send_act_code_sms($to,$message)
{
	
	$user = "knight127";
    $password = "NZWWXUgbRULaFa";
    $api_id = "3434487";	
    /*$user = "Adikson";
    $password = "Adikson123";
    $api_id = "3444586";*/
    $baseurl ="http://api.clickatell.com";// Keep it as it is
    $text = urlencode($message); 
    // auth call
    $url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id";
 	//http://api.clickatell.com/http/sendmsg?user=Adikson&password=Adikson123&api_id=3444586&to=918401110094&text=Hello%20Kaisar!%20This%20is%20test%20message
    // do auth call
    $ret = file($url);
 
    // explode our response. return string is on first line of the data returned
    $sess = explode(":",$ret[0]);
    if ($sess[0] == "OK")
	{
 
        $sess_id = trim($sess[1]); // remove any whitespace
        //$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";
        $url = "$baseurl/http/sendmsg?user=$user&password=$password&api_id=$api_id&to=$to&text=$text";
 
        // do sendmsg call
        $ret = file($url);
        $send = explode(":",$ret[0]);
 
        if ($send[0] == "ID") {
            //return "successnmessage ID: ". $send[1];
            return "success";
        } 
        else
		{
            return "failed";
			
        }
    } 
    else
	{
        //return "Authentication failure: ". $ret[0];
        return "failure";
    }
}


//code added on 10-june-2014 by JK
//generate unique verification code 
function unique_id($l = 6) {
    return substr(md5(uniqid(mt_rand(), true)), 0, $l);
}


?>
