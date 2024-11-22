<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "Constants.php";

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

$q = $_GET['q'];

if($q == 'loadpl'){
	
$soId = $_GET['soId'];
$st = $_GET['st'];

$sql = "SELECT A.* FROM SERIAL_NO_IMAGES A,CONTRACTOR_WORK_ORDERS B WHERE A.SOID = B.CON_SERO_ID AND SOID = '$soId' AND (STATUS != '5' OR STATUS IS NULL) AND IMAGEID = '21' AND B.CON_STATUS = '$st' ORDER BY IMAGE_DISNAME";
$oraconn = OracleConnection();
$statment = $oraconn->prepare($sql);
$statment->execute();
$cctdetails = $statment->fetchAll();
$returndata['datapl'] = $cctdetails;

}

if($q == 'loadfdp'){
	
    $soId = $_GET['soId'];
    $st = $_GET['st'];
    
    $sql = "SELECT A.* FROM SERIAL_NO_IMAGES A,CONTRACTOR_WORK_ORDERS B WHERE A.SOID = B.CON_SERO_ID AND SOID = '$soId' AND (STATUS != '5' OR STATUS IS NULL) AND IMAGEID = '4' AND B.CON_STATUS = '$st' ORDER BY IMAGE_DISNAME";
    $oraconn = OracleConnection();
    $statment = $oraconn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['datapl'] = $cctdetails;
    
}

if($q == 'loadcusl'){

    $soId = $_GET['soId'];
    $st = $_GET['st'];
    
    $sql = "SELECT A.* FROM SERIAL_NO_IMAGES A,CONTRACTOR_WORK_ORDERS B WHERE A.SOID = B.CON_SERO_ID AND SOID = '$soId' AND (STATUS != '5' OR STATUS IS NULL) AND IMAGEID = '8' AND B.CON_STATUS = '$st' ORDER BY IMAGE_DISNAME";
    $oraconn = OracleConnection();
    $statment = $oraconn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['datapl'] = $cctdetails;
    
}

$statment->closeCursor();
header('Content-Type: application/json; charset=utf-8');
echo json_encode($returndata);
