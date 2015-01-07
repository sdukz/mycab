<?php 
// ------------ distance calculation function ---------------------
   
    //**************************************
    //     
    // Name: Calculate Distance and Radius u
    //     sing Latitude and Longitude in PHP
    // Description:This function calculates 
    //     the distance between two locations by us
    //     ing latitude and longitude from ZIP code
    //     , postal code or postcode. The result is
    //     available in miles, kilometers or nautic
    //     al miles based on great circle distance 
    //     calculation. 
    // By: ZipCodeWorld
    //
    //This code is copyrighted and has
	// limited warranties.Please see http://
    //     www.Planet-Source-Code.com/vb/scripts/Sh
    //     owCode.asp?txtCodeId=1848&lngWId=8    //for details.    //**************************************
    //     
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*:: :*/
    /*:: This routine calculates the distance between two points (given the :*/
    /*:: latitude/longitude of those points). It is being used to calculate :*/
    /*:: the distance between two ZIP Codes or Postal Codes using our:*/
    /*:: ZIPCodeWorld(TM) and PostalCodeWorld(TM) products. :*/
    /*:: :*/
    /*:: Definitions::*/
    /*::South latitudes are negative, east longitudes are positive:*/
    /*:: :*/
    /*:: Passed to function::*/
    /*::lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees) :*/
    /*::lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees) :*/
    /*::unit = the unit you desire for results:*/
    /*::where: 'M' is statute miles:*/
    /*:: 'K' is kilometers (default):*/
    /*:: 'N' is nautical miles :*/
    /*:: United States ZIP Code/ Canadian Postal Code databases with latitude & :*/
    /*:: longitude are available at http://www.zipcodeworld.com :*/
    /*:: :*/
    /*:: For enquiries, please contact sales@zipcodeworld.com:*/
    /*:: :*/
    /*:: Official Web site: http://www.zipcodeworld.com :*/
    /*:: :*/
    /*:: Hexa Software Development Center © All Rights Reserved 2004:*/
    /*:: :*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
  function GML_distance($lat1, $lon1, $lat2, $lon2) { 
    $theta = $lon1 - $lon2; 
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
    $dist = acos($dist); 
    $dist = rad2deg($dist); 
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);
	$bearingDeg = (rad2deg(atan2(sin(deg2rad($lon2) - deg2rad($lon1)) * 
	   cos(deg2rad($lat2)), cos(deg2rad($lat1)) * sin(deg2rad($lat2)) - 
	   sin(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon2) - deg2rad($lon1)))) + 360) % 360;

	$bearingWR = GML_direction($bearingDeg);
	
    $km = round($miles * 1.609344); 
    $kts = round($miles * 0.8684);
	$miles = round($miles);
	return(array('miles'=>$miles,'km'=>$km,'bearingDeg'=>$bearingDeg,'bearingWR'=>$bearingWR));
  }
  
function GML_direction($degrees) {
   // figure out a text value for compass direction
   // Given the direction, return the text label
   // for that value.  16 point compass
   $winddir = $degrees;
   if ($winddir == "n/a") { return($winddir); }

  if (!isset($winddir)) {
    return "---";
  }
  if (!is_numeric($winddir)) {
	return($winddir);
  }

  $windlabel = array ("N","NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S",
	 "SSW","SW", "WSW", "W", "WNW", "NW", "NNW");
// $windlabel = array ("N","E", "S", "W");
  $dir = $windlabel[ fmod((($winddir + 11) / 22.5),16) ];
  return($dir);

} // end function GML_direction	

$dis = GML_distance('22.720457','75.852249','22.728057','76.024597');
print_r($dis);

?>
&nbsp;&nbsp;<br />

<?php
function calcbearing($lat1,$lon1,$lat2,$lon2)
{
	// calculate Great Circle bearing
	// SOURCE: http://www.yourhomenow.com/house/haversine.html
	$dLon = deg2rad($lon2-$lon1); 
	$y = sin($dLon) * cos($lat2);
	$x = cos($lat1)*sin($lat2) - sin($lat1)*cos($lat2)*cos($dLon);
	$brng = atan2($y, $x);//.toBrng();
	$brng = $brng * (180 / pi());
	$brng = ($brng +360) % 360;
	return $brng;
}

$dis = calcbearing('22.722357','75.865982','22.964716','76.046569');
print_r($dis);

?>
