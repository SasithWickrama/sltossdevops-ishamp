<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$strArr = array();

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

$imgId = $_POST['imgId'];

$dom=new DOMDocument('1.0','UTF-8');

$node=$dom-> createElementNs('http://earth.google.com/kml/2.1', 'kml');
$parNode = $dom->appendChild($node);

$dnode = $dom->createElement('Document');
$docNode = $parNode->appendChild($dnode);

$manholeStyleNode = $dom->createElement('Style');
$manholeStyleNode->setAttribute('id', 'manholeStyle');
$manholeIconstyleNode = $dom->createElement('IconStyle');
$manholeIconstyleNode->setAttribute('id', 'manhole');
$manholescale=$dom->createElement('scale', '1.25');
$manholeIconstyleNode->appendChild($manholescale);
$manholeIconNode = $dom->createElement('Icon');
$manholeHref = $dom->createElement('href', '../../assets/img/pole.png');
$manholeIconNode->appendChild($manholeHref);
$manholeIconstyleNode->appendChild($manholeIconNode);
$manholeStyleNode->appendChild($manholeIconstyleNode);
$docNode->appendChild($manholeStyleNode);

$i=0;
		
$sql = "SELECT * FROM SERIAL_NO_IMAGES WHERE IMAGE_NAME = '".$imgId."' AND IMAGE_NAME is not null";

$oraconn = OracleConnection();
$statment = $oraconn->prepare($sql);
$statment->execute();
$cctdetails = $statment->fetchAll();

foreach( $cctdetails as $row ) 
{
	$discription = makeDiscription($row);

	$node = $dom->createElement('Placemark');
	$placeNode = $docNode->appendChild($node);

	$placeNode->setAttribute('id', 'placemark' . $row['IMAGEID']);

	$nameNode = $dom->createElement('name',htmlentities($row['IMAGE_DISNAME']));
	$placeNode->appendChild($nameNode);
	$descNode = $dom->createElement('description', $discription);
	$placeNode->appendChild($descNode);
	
	$styleUrl = $dom->createElement('styleUrl', '#manholeStyle');
	$placeNode->appendChild($styleUrl);

	$pointNode = $dom->createElement('Point');
	$placeNode->appendChild($pointNode);

	$coorStr = $row['LON'] . ','  . $row['LAT'];
	$coorNode = $dom->createElement('coordinates', $coorStr);
	$pointNode->appendChild($coorNode);
}
	
function makeDiscription($row){

$dis = '<!DOCTYPE html>
<html>
<head>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="css/font/font-awesome.js"></script>

</head>
<body>

<table class="table" style="width:100%"> ';
	
	$dis.='<tr>
			<td><b>Image Name : </b></td>
			<td>'.$row['IMAGE_DISNAME'].'</td>
		  </tr>

		<tr>
		  <td rowspan=2><b>GPS LOCATION : </b></td>
		  <td>Longitute:'.$row['LON'].'</td>
		</tr>
			
		<tr>
			<td>Latitude:'.$row['LAT'].'</td>
		</tr>

		</table>';
 
return $dis;

}

$kmlOutput = $dom->saveXML();
$dom->save("../kmlfiles/".$rtom."mapview.kml");

?>