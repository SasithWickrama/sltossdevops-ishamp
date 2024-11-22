<?php

include "../../db/Constants.php";

function OracleConnection(){
    $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.16.243)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
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
$cablecolour = $dom->createElement('color', 'ffff0000');
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

$a=1;

$path .= $fdpdata['LON'].','.$fdpdata['LAT'].',0 ';

foreach( $poldata as $row ) 
{

	if($row['LON'] && $row['LAT']){
		
		$path .= $row['LON'].','.$row['LAT'].',0 ';
	
	}

}

$path .= $cusldata['LON'].','.$cusldata['LAT'];

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
$coordinates = $dom->createElement('coordinates',$path);
$lineNode->appendChild($coordinates);
$placeNode->appendChild($lineNode);

$kmlOutput = $dom->saveXML();
$dom->save("../kmlfiles/cblAutoSt.kml");

?>