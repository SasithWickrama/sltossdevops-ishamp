<?php
session_start();
include "Constants.php";

$areas = $_SESSION["uarea"];
$user = $_SESSION["uid"];



function OracleConnection(){
    $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.16.243)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )
";

//    $db = "(DESCRIPTION =
//    (ADDRESS_LIST =
//      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
//    )
//    (CONNECT_DATA = (SID=clty))
//  )
//";

    try {
        $conn = new PDO("oci:dbname=".$db, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}


function log_all($usr,$so_id,$msg)
{
    $sql ="INSERT INTO CONTRACTOR_LOG (CON_USER,LOG_DATE,SO_ID,MSG ) VALUES (:USR,sysdate,:SOD,:MSG)";
    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['USR' => $usr, 'SOD' => $so_id, 'MSG' => $msg]);
}

$result="";

if(isset($_POST["q"]) && $_POST["q"] == 'conInprogress') {

    $sod = $_POST["sod"];

    $oraconn = OracleConnection();

    $sql ="update CONTRACTOR_NEW_CON set CON_SO_STATUS = 'INPROGRESS', CON_SO_STATUS_DATE = sysdate 
        where CON_SO_ID = :CON_SO_ID and CON_SO_STATUS = 'ASSIGNED'";
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['CON_SO_ID' => $sod]);

    $sql2 ="update CONTRACTOR_WORK_ORDERS set CON_STATUS = 'INPROGRESS',CON_STATUS_DATE = sysdate where CON_SERO_ID = :CON_SERO_ID
           and CON_STATUS = 'ASSIGNED'";
    $stmt2 = $oraconn->prepare($sql2);
    $stmt2->execute(['CON_SERO_ID' => $sod]);

    $msg = 'Connection status change to inprogress';
    log_all($user,$sod,$msg);
    $result =  "success";

}

if(isset($_POST["q"]) && $_POST["q"] == '1') {

    $info=$_POST["info"];
    $sod=$info[2];

    $oraconn = OracleConnection();

    $sql ="UPDATE CONTRACTOR_WORK_ORDERS SET CON_NAME = :CON_NAME ,CON_DATE_TO_CONTRACTOR  = SYSDATE , CON_WORO_DISCRIPTION= :CON_WORO_DISCRIPTION
           WHERE CON_SERO_ID IN (SELECT SO_NUM  FROM CON_CLARITY_SOLIST  WHERE EX_NO = :EX_NO  AND STATUS = 0)";
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['CON_NAME' => $info[1], 'EX_NO' => $info[3],'CON_WORO_DISCRIPTION' => $info[4]]);

    $sql2 ="UPDATE CONTRACTOR_NEW_CON SET CON_CONTRACTOR = :CON_CONTRACTOR , CON_SO_DATE_RECEIVED  = SYSDATE
            WHERE CON_SO_ID IN (SELECT SO_NUM  FROM CON_CLARITY_SOLIST  WHERE EX_NO = :EX_NO  AND STATUS = 0)";
    $stmt2 = $oraconn->prepare($sql2);
    $stmt2->execute(['CON_CONTRACTOR' => $info[1], 'EX_NO' => $info[3]]);

    $sql3 ="UPDATE CON_CLARITY_SOLIST SET CONTRATOR=:CONTRATOR,STATUS='1',UPDATE_USER='$user',STATUS_DATE=sysdate
                          WHERE VOICENUMBER = :VOICENUMBER AND STATUS='0'";
    $stmt3 = $oraconn->prepare($sql3);
    $stmt3->execute(['CONTRATOR' => $info[1], 'VOICENUMBER' => $info[0]]);

    $msg = 'Service Order assigned to: '.$info[1];
    log_all($user,$sod,$msg);

    $result =  "success";

}

if(isset($_POST["q"]) && $_POST["q"] == 'snuser') {

    $info=$_POST["info"];

    $sql= "INSERT INTO SERIAL_NO_SO (SO_ID,ASSIGNED_TO ,ASSIGNED_BY,ASSIGNED_ON, CON_NAME,STATUS,
                          DATE_IN,RTOM,CIRCUIT,ORDER_TYPE,SER_TYPE,IPTV,PACKAGE,LEA,IPTV_2,IPTV_3,VOICE_2,BB,APP_PACKAGE,SIET)
            VALUES (:SO_ID,:ASSIGNED_TO ,:ASSIGNED_BY,sysdate, :CON_NAME,'1',sysdate,:RTOM,:CIRCUIT,
                    :ORDER_TYPE,:SER_TYPE,:IPTV,:PACKAGE,:LEA,:IPTV_2,:IPTV_3,:VOICE2,:BB,:APP_PACKAGE,:SIET)";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['SO_ID' => $info[1], 'ASSIGNED_TO' => $info[0], 'ASSIGNED_BY' => $user, 'CON_NAME' => $info[3],
        'RTOM' => $info[4], 'CIRCUIT' => $info[5], 'ORDER_TYPE' => $info[7], 'SER_TYPE' => $info[6], 'IPTV' => $info[10],
        'PACKAGE' => $info[9], 'LEA' => $info[8], 'IPTV_2' => $info[11], 'IPTV_3' => $info[12],
        'VOICE2' => $info[14],'BB' => $info[13],'APP_PACKAGE' => $info[15],'SIET' => $info[2]]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'mobile user assign for serial number capture: '.$info[0];
    log_all($user,$info[1],$msg);

}

if(isset($_POST["q"]) && $_POST["q"]== 'snuserchg' ) {

    $sod=$_POST["sod"];
    $usr=$_POST["usr"];

    $sql= "UPDATE SERIAL_NO_SO SET ASSIGNED_TO= : ASSIGNED_TO ,ASSIGNED_ON=sysdate ,ASSIGNED_BY=:ASSIGNED_BY
            where SO_ID=:SO_ID";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['SO_ID' => $sod,'ASSIGNED_TO' => $usr,'ASSIGNED_BY' => $user ]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'mobile user change for serial number capture: '.$usr;
    log_all($user,$sod,$msg);


}

if(isset($_POST["q"]) && $_POST["q"]== 'delteam' ) {

    $info=$_POST["info"];

    $sql= "DELETE FROM CONTRACTOR_TEAMS WHERE AREA= :AREA and CONTRACTOR= :CONTRACTOR
                               and TEAM_DATE = :TEAM_DATE and S_TYPE = :S_TYPE";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['AREA' => $info[0],'CONTRACTOR' => $info[1],'TEAM_DATE' => $info[2],'S_TYPE' => $info[3] ]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'Team deleted'.$info;
    log_all($user,$sod,$msg);


}

if(isset($_POST["q"]) && $_POST["q"]== 'confirmteam' ) {

    $info=$_POST["info"];

    $sql= "update  CONTRACTOR_TEAMS set TEAM_FLAG = '1' WHERE AREA= :AREA and CONTRACTOR= :CONTRACTOR
                               and TEAM_DATE = :TEAM_DATE and S_TYPE = :S_TYPE";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['AREA' => $info[0],'CONTRACTOR' => $info[1],'TEAM_DATE' => $info[2],'S_TYPE' => $info[3] ]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'Team confirmed'.$info;
    log_all($user,$sod,$msg);


}

if(isset($_POST["q"]) && $_POST["q"]== 'addteam' ) {

    $info=$_POST["info"];

    $sql= "INSERT INTO OSS_DEV_01.CONTRACTOR_TEAMS (AREA, CONTRACTOR, TEAM_DATE,S_TYPE, TEAM_COUNT, EN_USER, TEAM_FLAG) 
        VALUES (:AREA,:CONTRACTOR,TO_DATE(TO_CHAR(sysdate, 'MM/DD/YYYY'), 'MM/DD/YYYY'),:S_TYPE,:TEAM_COUNT,:EN_USER, '0')";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['AREA' => $info[0],'CONTRACTOR' => $info[1],'S_TYPE' => $info[2],'TEAM_COUNT' => $info[3],'EN_USER' => $user ]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'Team updated'.$info;
    log_all($user,$sod,$msg);


}


if(isset($_POST["q"]) && $_POST["q"]== 'addmobuser' ) {

    $info=$_POST["info"];

    $sql= "INSERT INTO OSS_DEV_01.TECHS_CON_USER (CON_USER, CON_USER_CONTACT, CON_CONTRACTOR, CON_TEAM_ID) 
        VALUES (:CON_USER,:CON_CONTACT,:CON_CONTRACTOR,:CON_TEAM_ID)";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['CON_USER' => $info[0],'CON_CONTRACTOR' => $info[1],'CON_CONTACT' => $info[2],'CON_TEAM_ID' => $info[3]]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'Team updated'.$info;
    log_all($user,$sod,$msg);


}

if(isset($_POST["q"]) && $_POST["q"]== 'updatemetFtth' ) {

    $info=$_POST["info"];

    $sql= "UPDATE  OSS_DEV_01.CONTRACTOR_FTTH_MET SET P0 = :P0 where SOID = :SOID and MET_ID= :MET_ID and UNIT_DESIG=:UNIT_DESIG";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['P0' => $info[3],'SOID' => $info[0],'MET_ID' => $info[2],'UNIT_DESIG' => $info[1]]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'Meterial Updated '.$info[1].' '.$info[3];
    log_all($user,$info[0],$msg);


}

if(isset($_POST["q"]) && $_POST["q"]== 'deleteMet' ) {

    $info=$_POST["info"];

    $sql= "DELETE FROM  OSS_DEV_01.CONTRACTOR_FTTH_MET where SOID = :SOID and MET_ID= :MET_ID and UNIT_DESIG=:UNIT_DESIG";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['SOID' => $info[0],'MET_ID' => $info[2],'UNIT_DESIG' => $info[1]]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'Meterial Deleted '.$info[1];
    log_all($user,$info[0],$msg);

}


if(isset($_POST["q"]) && $_POST["q"]== 'addMeterial' ) {

    $info=$_POST["info"];

    $sql= "INSERT INTO OSS_DEV_01.CONTRACTOR_FTTH_MET(SOID, VOICENO,UNIT_DESIG,P0,P1,SN,MET_ID)
             VALUES (:SOID,:VOICENO,:UNIT_DESIG,:P0,'0',:SN,MET_SEQ.nextval)";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['SOID' => $info[0],'P0' => $info[2],'VOICENO' => $info[1],'UNIT_DESIG' => $info[3],'SN' => $info[4]]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'Meterial Inserted '.$info[3].' '.$info[2];
    log_all($user,$info[0],$msg);

}


if(isset($_POST["q"]) && $_POST["q"]== 'closeSod' ) {

    $info=$_POST["info"];

    $sql= "update  CONTRACTOR_WORK_ORDERS set CON_STATUS_DATE = sysdate, CON_STATUS = 'COMPLETED' where CON_SERO_ID = :CON_SERO_ID";
    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['CON_SERO_ID' => $info[0]]);

    $sql3= "update  CON_CLARITY_SOLIST set STATUS_DATE = sysdate, STATUS = '20'  where SO_NUM = :SO_NUM";
    $stmt3 = $oraconn->prepare($sql3);
    $stmt3->execute(['SO_NUM' => $info[0]]);

    $sql2= "update  CONTRACTOR_NEW_CON set CON_SO_COM_DATE = sysdate, CON_SO_STATUS = 'COMPLETED'  where CON_SO_ID = :CON_SO_ID";
    $stmt2 = $oraconn->prepare($sql2);
    $stmt2->execute(['CON_SO_ID' => $info[0]]);

    $sql4= "update  SERIAL_NO_SO set STATUS = '10'  where SO_ID = :SO_ID";
    $stmt4 = $oraconn->prepare($sql3);
    $stmt4->execute(['SO_ID' => $info[0]]);

    if($stmt2->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'Service Order Completed '.$info[0];
    log_all($user,$info[0],$msg);

}

if(isset($_POST["q"]) && $_POST["q"]== 'returnSod' ) {

    $info=$_POST["info"];

    $sql= "update  CONTRACTOR_WORK_ORDERS set CON_STATUS_DATE = sysdate, CON_STATUS = 'RETURN_SLT' where CON_SERO_ID = :CON_SERO_ID";
    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['CON_SERO_ID' => $info[0]]);


    $sql2= "update  CONTRACTOR_NEW_CON set CON_SO_COM_DATE = sysdate, CON_SO_STATUS = 'RETURN_SLT'  where CON_SO_ID = :CON_SO_ID";
    $stmt2 = $oraconn->prepare($sql2);
    $stmt2->execute(['CON_SO_ID' => $info[0]]);

    if($stmt2->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'Service Order Retruned to SLT '.$info[0];
    log_all($user,$info[0],$msg);

}

if(isset($_POST["q"]) && $_POST["q"]== 'imgDelete') {

    $info=$_POST["info"];

    if($info[2] == '24' || $info[2] == '25' || $info[2] == '15' ) {
        $sql ="DELETE FROM SERIAL_NO_IMAGES WHERE IMAGEID = :IMAGEID AND IMAGE_NAME=:IMAGE_NAME AND SOID = :SOID ";
    }else {
        $sql ="UPDATE SERIAL_NO_IMAGES SET IMAGE_NAME= '',LAT='', LON='', IN_DATE= '' WHERE IMAGEID = :IMAGEID AND IMAGE_NAME=:IMAGE_NAME AND SOID = :SOID ";
    }

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['IMAGEID' => $info[2],'IMAGE_NAME' => $info[1],'SOID' => $info[0]]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = $sql;
    }

}

if(isset($_POST["q"]) && $_POST["q"]== 'patStatus') {

    $info=$_POST["info"];

    if($info[1] == 'CONFIRM'  ) {
        $sql= "update  CONTRACTOR_WORK_ORDERS set CON_STATUS_DATE = sysdate, PAT_USER='$user', CON_STATUS = 'PAT_PASSED' where CON_SERO_ID = :CON_SERO_ID";
        $oraconn = OracleConnection();
        $stmt = $oraconn->prepare($sql);
        $stmt->execute(['CON_SERO_ID' => $info[0]]);
    }
    if($info[1] == 'REJECT'  ) {
        $sql= "update  CONTRACTOR_WORK_ORDERS set CON_STATUS_DATE = sysdate, PAT_USER='$user', CON_STATUS = 'PAT_REJECTED' where CON_SERO_ID = :CON_SERO_ID";
        $oraconn = OracleConnection();
        $stmt = $oraconn->prepare($sql);
        $stmt->execute(['CON_SERO_ID' => $info[0]]);

        $sql2 = "update SERIAL_NO_SO set STATUS = :STATUS where SO_ID = :SO_ID";
        $oraconn2 = OracleConnection();
        $stmt2 = $oraconn2->prepare($sql2);
        $stmt2->execute(['STATUS' => '12','SO_ID' => $info[0]]);

    }


    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'PAT Results Completed '.$info[1];
    log_all($user,$info[0],$msg);

}

if(isset($_POST["q"]) && $_POST["q"]== 'patReCorrect') {

    $info=$_POST["info"];


        $sql= "update  CONTRACTOR_WORK_ORDERS set CON_STATUS_DATE = sysdate, CON_STATUS = 'PAT_CORRECTED' where CON_SERO_ID = :CON_SERO_ID";
        $oraconn = OracleConnection();
        $stmt = $oraconn->prepare($sql);
        $stmt->execute(['CON_SERO_ID' => $info[0]]);

        $sql2 = "update SERIAL_NO_SO set STATUS = :STATUS where SO_ID = :SO_ID";
        $oraconn2 = OracleConnection();
        $stmt2 = $oraconn2->prepare($sql2);
        $stmt2->execute(['STATUS' => '15','SO_ID' => $info[0]]);


    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

    $msg = 'PAT Results Recorrected ';
    log_all($user,$info[0],$msg);

}

if(isset($_POST["q"]) && $_POST["q"]== 'bomCreate') {

    $info=$_POST["info"];



    $sql= "insert into TECHS_BOM values (:SOID,:VOICE,:RTOM,:CON,:BREF)";
    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['SOID' => $info[0],'VOICE' => $info[1],'RTOM' => $info[4],'CON' => $info[3],'BREF' => $info[2]]);

    $sql2= "update  CONTRACTOR_WORK_ORDERS set CON_WORO_APPROVEDBY = :CON_WORO_APPROVEDBY  where CON_SERO_ID = :CON_SERO_ID";
    $stmt2 = $oraconn->prepare($sql2);
    $stmt2->execute(['CON_SERO_ID' => $info[0],'CON_WORO_APPROVEDBY'=>$info[2]]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }
}

if(isset($_POST["q"]) && $_POST["q"]== 'ftthbomdownload') {

    $info=$_POST["info"];
    $sql="SELECT * FROM (select aa.* ,bb.UNIT_DESIG,bb.P0 
            from TECHS_BOM aa , CONTRACTOR_FTTH_MET bb
            where aa.SOID = bb.SOID
            and aa.BOM_REF = :BOM_REF)
            PIVOT
            ( SUM(P0)
            FOR UNIT_DESIG IN ('FTTH-DW',
            'PL-C-5.6-L',
            'PL-C-5.6-CE',
            'PL-C-6.7',
            'PL-C6.7CE',
            'PL-C-7.5',
            'PL-C-8',
            'PLC-CON',
            'PLC-CON-SP',
            'PL-GI-2-ROCK',
            'PL-GI-2-GND',
            'PL-GI-2-SLB',
            'PL-GI-50',
            'PL-GI-100',
            'DW-LH',
            'FT-DP-VB-ID',
            'FT-DP-VP-ID',
            'FT-DP-V2P-ID',
            'FT-DP-V3P-ID',
            'FT-SP-PO-ID',
            'FT-3P-BP-ID',
            'FT-3P-B2P-ID'
            ))";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['BOM_REF' => $info[0]]);
    $cctdetails = $stmt->fetchAll();

    $HEADER = "SOD ,Circuit,RTOM,CONTRACTOR,FTTH-DW (m),PL-C-5.6-L (Pcs),PL-C-5.6-CE (Pcs),PL-C-6.7 (Pcs),PL-C6.7CE (Pcs),PL-C-7.5 (Pcs),PL-C-8 (Pcs),PLC-CON (Pcs),PLC-CON-SP (Pcs),PL-GI-2-ROCK (Pcs),PL-GI-2-GND (Pcs),PL-GI-2-SLB (Pcs),PL-GI-50 (Pcs),PL-GI-100 (Pcs),DW-LH (Nos.),FT-DP-VB-ID (Nos.),FT-DP-VP-ID (Nos.),FT-DP-V2P-ID (Nos.),FT-DP-V3P-ID (Nos.),FT-SP-PO-ID (Nos.),FT-3P-BP-ID (Nos.),FT-3P-B2P-ID (Nos.)  \n";

    foreach($cctdetails as $row) {
        $HEADER = $HEADER . "{$row[0]},{$row[1]},{$row[2]},{$row[3]},{$row[5]},{$row[6]},{$row[7]},{$row[8]},{$row[9]},{$row[10]},{$row[11]},{$row[12]},{$row[13]},{$row[14]},{$row[15]},{$row[16]},{$row[17]},{$row[18]},{$row[19]},{$row[20]},{$row[21]},{$row[22]},{$row[23]},{$row[24]},{$row[25]},{$row[26]}\n";
    }

    $File = "../files/".str_replace('/','-',$info[0]).".csv";
    $FILE_WRITE = fopen($File, 'w') or die("can't open file");
    fwrite($FILE_WRITE, $HEADER);
    fclose($FILE_WRITE);


    header("Location: $File");

    $result = 'success';
}

if(isset($_POST["q"]) && $_POST["q"]== 'addAcptCmt') {

    $info=$_POST["info"];

    $oraconn = OracleConnection();

    $sql = "SELECT MAX(A.IMAGE_STAGE) AS IMG_STG FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID = :IMG_ID";
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['SO_ID' => $info[0],'IMG_ID' => $info[1]]);
    $result = $stmt->fetch();

    $imgStg = $result[0]+1;

    $sql= "DELETE FROM OSS_DEV_01.SERIAL_NO_IMAGES WHERE SOID= :SOID AND IMAGEID = :IMGID AND IMAGE_NAME IS NULL";
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['SOID' => $info[0],'IMGID' => $info[1]]);

    $sql= "UPDATE OSS_DEV_01.SERIAL_NO_IMAGES SET IMAGE_COMMENT = :IMG_CMT, IMAGE_COMUSER = :IMG_CMT_USER,IMAGE_COM_DATE = SYSDATE,STATUS = '10',STATUS_DATE=SYSDATE WHERE SOID = :SO_ID AND IMAGEID = :IMG_ID AND IMAGE_NAME = :IMG_NAME AND IMAGE_NAME IS NOT NULL";
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['IMG_CMT' => $info[2],'IMG_CMT_USER' => $user,'SO_ID' => $info[0],'IMG_ID' => $info[1],'IMG_NAME' => $info[3]]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'fail';
    }

}

if(isset($_POST["q"]) && $_POST["q"]== 'addRjCmt') {

    $info=$_POST["info"];

    $oraconn = OracleConnection();

    $sql = "SELECT MAX(A.IMAGE_STAGE) AS IMG_STG FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID = :IMG_ID";
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['SO_ID' => $info[0],'IMG_ID' => $info[1]]);
    $result = $stmt->fetch();

    $imgStg = $result[0]+1;

    $sql= "INSERT INTO OSS_DEV_01.SERIAL_NO_IMAGES (SOID,IMAGEID,IMAGE_DISNAME,IMAGE_STAGE) VALUES(:SOID,:IMGID,:IMGNAME,:IMG_STG)";
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['SOID' => $info[0],'IMGID' => $info[1],'IMGNAME' => $info[4],'IMG_STG' => $imgStg]);

    $sql= "UPDATE OSS_DEV_01.SERIAL_NO_IMAGES SET IMAGE_COMMENT = :IMG_CMT, IMAGE_COMUSER = :IMG_CMT_USER,IMAGE_COM_DATE = SYSDATE,STATUS = '5',STATUS_DATE=SYSDATE WHERE SOID = :SO_ID AND IMAGEID = :IMG_ID AND IMAGE_NAME = :IMG_NAME AND IMAGE_NAME IS NOT NULL";
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['IMG_CMT' => $info[2],'IMG_CMT_USER' => $user,'SO_ID' => $info[0],'IMG_ID' => $info[1],'IMG_NAME' => $info[3]]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'fail';
    }

}

if(isset($_POST["q"]) && $_POST["q"]== 'loadFatCmt') {

    $info=$_POST["info"];

    $sql ="SELECT IMAGE_COMMENT,IMAGE_COMUSER,TO_CHAR(IMAGE_COM_DATE, 'DD-MON-YYYY HH24:MI:SS') AS IMAGE_COM_DATE  FROM SERIAL_NO_IMAGES  WHERE SOID = '$info[0]' AND IMAGE_NAME = '$info[1]'";
        $oraconn = OracleConnection();
        $stmt = $oraconn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        
        $stmt->closeCursor();
        header('Content-Type: application/json; charset=utf-8');
        $result = json_encode($result);

}

if(isset($_POST["q"]) && $_POST["q"]== 'loadDwLen') {

    $info=$_POST["info"];

    $sql="SELECT A.* FROM SERIAL_NO_IMAGES A,CONTRACTOR_WORK_ORDERS B WHERE A.SOID = B.CON_SERO_ID AND SOID = '$info[0]' AND (STATUS != '5' OR STATUS IS NULL) AND IMAGEID IN ('21') AND B.CON_STATUS = '$info[1]' AND LON IS NOT NULL AND LAT IS NOT NULL ORDER BY IMAGE_DISNAME";
    $oraconn = OracleConnection();
    $statment = $oraconn->prepare($sql);
    $statment->execute();
    $poldata = $statment->fetchAll();

    $sql="SELECT A.* FROM SERIAL_NO_IMAGES A,CONTRACTOR_WORK_ORDERS B WHERE A.SOID = B.CON_SERO_ID AND SOID = '$info[0]' AND (STATUS != '5' OR STATUS IS NULL) AND IMAGEID = '4' AND B.CON_STATUS = '$info[1]' AND LON IS NOT NULL AND LAT IS NOT NULL ORDER BY IMAGE_DISNAME";
    $statment = $oraconn->prepare($sql);
    $statment->execute();
    $fdpdata = $statment->fetch();

    $sql="SELECT A.* FROM SERIAL_NO_IMAGES A,CONTRACTOR_WORK_ORDERS B WHERE A.SOID = B.CON_SERO_ID AND SOID = '$info[0]' AND (STATUS != '5' OR STATUS IS NULL) AND IMAGEID = '8' AND B.CON_STATUS = '$info[1]' AND LON IS NOT NULL AND LAT IS NOT NULL ORDER BY IMAGE_DISNAME";
    $statment = $oraconn->prepare($sql);
    $statment->execute();
    $cusldata = $statment->fetch();

    $imgData='';
    $result='';

    $imgData .= $fdpdata['IMAGE_DISNAME'].','.$fdpdata['LON'].','.$fdpdata['LAT'].'*';

    foreach( $poldata as $row ) 
    {
            
        $imgData .= $row['IMAGE_DISNAME'].','.$row['LON'].','.$row['LAT'].'*';

    }

    $imgData .= $cusldata['IMAGE_DISNAME'].','.$cusldata['LON'].','.$cusldata['LAT'].'*';

    $pathArr = explode('*',$imgData);

    for($a=0; $a<sizeof($pathArr); $a++){

        if(sizeof($pathArr)-2 > $a){

            $pointArr1 = explode(',',$pathArr[$a]);
            $pointArr2 = explode(',',$pathArr[$a+1]);
            $imgN1 = $pointArr1[0];
            $lon1 = $pointArr1[1];
            $lat1 = $pointArr1[2];
            $imgN2 = $pointArr2[0];
            $lon2 = $pointArr2[1];
            $lat2 = $pointArr2[2];

            $d = get_meters_between_points($lat1, $lon1, $lat2, $lon2); 

            $result.= $imgN1.','.$imgN2.','.round($d, 1).'*';
        }

    }

}

if(isset($_POST["q"]) && $_POST["q"]== 'addGenCmt' ) {

    $info=$_POST["info"];
    $user = $_SESSION["uid"];

    $sql= "INSERT INTO OSS_DEV_01.PAT_COMMENT(SO_ID, PAT_GEN_CMT,CMT_USER,CMT_DATE) VALUES ('$info[0]','$info[1]','$user',SYSDATE)";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

}

if(isset($_POST["q"]) && $_POST["q"]== 'loadPatGenCmt') {

    $info=$_POST["info"];

    $sql ="SELECT *  FROM PAT_COMMENT  WHERE SO_ID = '$info[0]'";
        $oraconn = OracleConnection();
        $stmt = $oraconn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $stmt->closeCursor();
        header('Content-Type: application/json; charset=utf-8');
        $result = json_encode($result);

}

if(isset($_POST["q"]) && $_POST["q"]== 'imgCompare') {

    $info=$_POST["info"];

    $sql ="SELECT IMAGE_STAGE  FROM SERIAL_NO_IMAGES  WHERE SOID = :SOID AND IMAGE_NAME = :IMG_N";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['SOID' => $info[0],'IMG_N' => $info[1]]);
    $data = $stmt->fetch();

    $prevst = $data['IMAGE_STAGE']-1;
    $stage = $data['IMAGE_STAGE'];

    $sql2 ="SELECT * FROM SERIAL_NO_IMAGES WHERE IMAGEID IN(SELECT IMAGEID  FROM SERIAL_NO_IMAGES  WHERE SOID = :SOID AND IMAGE_NAME = :IMG_N) AND SOID = :SOID AND IMAGE_STAGE IN('$prevst','$stage') ORDER BY IMAGE_STAGE";
        
    $stmt2 = $oraconn->prepare($sql2);
    $stmt2->execute(['SOID' => $info[0],'IMG_N' => $info[1]]);
    $result = $stmt2->fetchAll();
        
    $stmt->closeCursor();
    header('Content-Type: application/json; charset=utf-8');
    $result = json_encode($result);

}

if(isset($_POST["q"]) && $_POST["q"]== 'addImgUpSt' ) {

    $info=$_POST["info"];

    $sql= "UPDATE  OSS_DEV_01.CONTRACTOR_NEW_CON SET FTTH_WIFI = 'Y' where CON_SO_ID  = :SO_ID AND CON_SO_STATUS=:CON_SO_ST";

    $oraconn = OracleConnection();
    $stmt = $oraconn->prepare($sql);
    $stmt->execute(['SO_ID' => $info[0],'CON_SO_ST' => $info[1]]);

    if($stmt->rowCount() == '1'){
        $result = 'success';
    }else{
        $result = 'failed';
    }

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

echo  $result;
