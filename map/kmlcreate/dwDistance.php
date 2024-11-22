<?php

include "../../db/Constants.php";

function OracleConnection(){
    $db = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = ".DB_HOST.")(PORT = ".DB_PORT."))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = HADWH)
    )
  )
";
 
 //     $db = "(DESCRIPTION =
 //     (ADDRESS_LIST =
 //       (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
 //     )
 //     (CONNECT_DATA = (SID=clty))
 //   )
 // ";
 
     try {
         $conn = new PDO("oci:dbname=".$db, DB_USER, DB_PASSWORD);
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         return $conn;
     } catch(PDOException $e) {
         echo 'ERROR: ' . $e->getMessage();
     }
 }

$soId = $_POST['soId'];
$st = $_POST['st'];

$dom=new DOMDocument('1.0','UTF-8');

$node=$dom-> createElementNs('http://earth.google.com/kml/2.1', 'kml');
$parNode = $dom->appendChild($node);

$dnode = $dom->createElement('Document');
$docNode = $parNode->appendChild($dnode);

$cableStyleNode = $dom->createElement('Style');
$cableStyleNode->setAttribute('id', 'line-style-cbl');
$cablestyleNode = $dom->createElement('BalloonStyle');
$cablelinestyleNode = $dom->createElement('LineStyle');
$cablecolour = $dom->createElement('color', 'ff0000ff');
$cablelinestyleNode->appendChild($cablecolour);
$cablewidth = $dom->createElement('width', '4.294');
$cablelinestyleNode->appendChild($cablewidth);
$cablestyleNode->appendChild($cablelinestyleNode);
$cableStyleNode->appendChild($cablestyleNode);
$docNode->appendChild($cableStyleNode);

$sql="SELECT A.* FROM SERIAL_NO_IMAGES A,CONTRACTOR_WORK_ORDERS B WHERE A.SOID = B.CON_SERO_ID AND SOID = '$soId' AND (STATUS != '5' OR STATUS IS NULL) AND IMAGEID IN ('21') AND B.CON_STATUS = '$st' AND LON IS NOT NULL AND LAT IS NOT NULL ORDER BY IMAGE_DISNAME";
$oraconn = OracleConnection();
$statment = $oraconn->prepare($sql);
$statment->execute();
$poldata = $statment->fetchAll();

$sql="SELECT A.* FROM SERIAL_NO_IMAGES A,CONTRACTOR_WORK_ORDERS B WHERE A.SOID = B.CON_SERO_ID AND SOID = '$soId' AND (STATUS != '5' OR STATUS IS NULL) AND IMAGEID = '4' AND B.CON_STATUS = '$st' AND LON IS NOT NULL AND LAT IS NOT NULL ORDER BY IMAGE_DISNAME";
$oraconn = OracleConnection();
$statment = $oraconn->prepare($sql);
$statment->execute();
$fdpdata = $statment->fetch();

$sql="SELECT A.* FROM SERIAL_NO_IMAGES A,CONTRACTOR_WORK_ORDERS B WHERE A.SOID = B.CON_SERO_ID AND SOID = '$soId' AND (STATUS != '5' OR STATUS IS NULL) AND IMAGEID = '8' AND B.CON_STATUS = '$st' AND LON IS NOT NULL AND LAT IS NOT NULL ORDER BY IMAGE_DISNAME";
$oraconn = OracleConnection();
$statment = $oraconn->prepare($sql);
$statment->execute();
$cusldata = $statment->fetch();

$path='';

$path .= $fdpdata['LON'].','.$fdpdata['LAT'].',0 ';

foreach( $poldata as $row ) 
{

	if($row['LON'] && $row['LAT']){
		
		$path .= $row['LON'].','.$row['LAT'].',0 ';
	
	}

}

$path .= $cusldata['LON'].','.$cusldata['LAT'];

$pathArr = explode(',0',$path);

for($a=0; $a<sizeof($pathArr); $a++){

	if(sizeof($pathArr)-1 > $a){

		$pathdw = $pathArr[$a].',0 '.$pathArr[$a+1];

		$pointArr1 = explode(',',$pathArr[$a]);
		$pointArr2 = explode(',',$pathArr[$a+1]);
		$lon1 = $pointArr1[0];
		$lat1 = $pointArr1[1];
		$lon2 = $pointArr2[0];
		$lat2 = $pointArr2[1];

		$d = get_meters_between_points($lat1, $lon1, $lat2, $lon2); 

		$dis = makeDiscription($d);

		$node = $dom->createElement('Placemark');
		$placeNode = $docNode->appendChild($node);

		$placeNode->setAttribute('id', 'placemark' . $a);
		
		$styleUrl = $dom->createElement('styleUrl', '#line-style-cbl');
		$placeNode->appendChild($styleUrl);

		$discription = $dom->createElement('description', $dis);
		$placeNode->appendChild($discription);
		
		$lineNode = $dom->createElement('LineString');
		$tessellate = $dom->createElement('tessellate','');
		$lineNode->appendChild($tessellate);
		$coordinates = $dom->createElement('coordinates',$pathdw);
		$lineNode->appendChild($coordinates);
		$placeNode->appendChild($lineNode);

		$pathdw='';

	}

}

function makeDiscription($d){
	
	$dis = '<!DOCTYPE html>
	<html>
	<head>
	</head>
	<body>
	
	<table class="table" style="width:100%">';
		
	$dis.='<tr>
			<td>Distance</td>
			<td>'.round($d, 1).' meters'.'</td>
		</tr>';
		
	$dis.='</table>
	
	</body>
	</html>';
	
	return $dis;
	
}
	
function get_meters_between_points($latitude1, $longitude1, $latitude2, $longitude2) {

	if (($latitude1 == $latitude2) && ($longitude1 == $longitude2)) { return 0; } // distance is zero because they're the same point
	$p1 = deg2rad($latitude1);
	$p2 = deg2rad($latitude2);
	$dp = deg2rad($latitude2 - $latitude1);
	$dl = deg2rad($longitude2 - $longitude1);
	$a = (sin($dp/2) * sin($dp/2)) + (cos($p1) * cos($p2) * sin($dl/2) * sin($dl/2));
	$c = 2 * atan2(sqrt($a),sqrt(1-$a));
	$r = 6371008; // Earth's average radius, in meters
	$d = $r * $c;
	return $d; // distance, in meters
}

$kmlOutput = $dom->saveXML();
$dom->save("../kmlfiles/dwDistance.kml");

?>