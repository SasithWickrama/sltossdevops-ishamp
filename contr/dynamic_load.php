<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../db/Constants.php";

$connstring = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = ".DB_HOST.")(PORT = ".DB_PORT."))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = HADWH)
    )
  )";

try {
    $conn = new PDO("oci:dbname=" . $connstring, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
    echo "<script>alert('DB Error!'); </script>";
}

if ($_GET['x'] == 'ftth') {
    $dat = explode("_",$_GET['z']);

    $tempD1=  explode("-",$dat[1]);
    $tempD2=  explode("-",$dat[2]);

    $rt= $dat[0];
    $st= $dat[3];
    $con= $dat[4];

    $from= $tempD1[1].'/'.$tempD1[2].'/'.$tempD1[0];
    $to= $tempD2[1].'/'.$tempD2[2].'/'.$tempD2[0];

    if($st == 'PENDING')
    {
        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and bb.CON_OSP_WORO_ID = cc.CON_ADDE_WORO_ID
                and bb.CON_OSP_WORO_ID =dd.CON_WORO_SEIT
                and cc.CON_ADDE_WORO_ID = dd.CON_WORO_SEIT
                and aa.S_TYPE = 'AB-FTTH'
                and aa.RTOM = '$rt'
                and dd.CON_NAME = '$con'
                and dd. CON_STATUS IN ('ASSIGNED','INPROGRESS')
                and dd.CON_DATE_TO_CONTRACTOR BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";
    }
    if($st == 'COMPLETED')
    {
        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and bb.CON_OSP_WORO_ID = cc.CON_ADDE_WORO_ID
                and bb.CON_OSP_WORO_ID =dd.CON_WORO_SEIT
                and cc.CON_ADDE_WORO_ID = dd.CON_WORO_SEIT
                and aa.S_TYPE = 'AB-FTTH'
                and aa.RTOM = '$rt'
                and dd.CON_NAME = '$con'
                and dd. CON_STATUS IN ('COMPLETED','INSTALL_CLOSED','PAT_OPMC_PASSED','PAT_CORRECTED','OPMC_PAT_SKIP','PAT_REJECTED','PAT_OPMC_REJECTED')
                and dd.CON_STATUS_DATE BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";
    }
    if($st == 'RETURNED')
    {
        $sql = "select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_NAME,bb.RETURNED_DATE, bb.RETURNED_REASON,bb.RETURNED_COMMENT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd, TECHS_RET_REASONS bb
                where aa.SETI = dd.CON_WORO_SEIT
                and aa.SO_NUM = bb.SOID
                and aa.S_TYPE = 'AB-FTTH'
                and aa.RTOM = '$rt'
                and dd.CON_NAME = '$con'  
                and dd.CON_STATUS IN ('RETURN_SLT','RETURN_PENDING')";
    }
    if($st == 'APPROVED')
    {
        $sql="";
    }

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'cab') {
    $dat = explode("_",$_GET['z']);

    $tempD1=  explode("-",$dat[1]);
    $tempD2=  explode("-",$dat[2]);

    $rt= $dat[0];
    $st= $dat[3];

    $from= $tempD1[1].'/'.$tempD1[2].'/'.$tempD1[0];
    $to= $tempD2[1].'/'.$tempD2[2].'/'.$tempD2[0];

    if($st == 'PENDING')
    {
        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.S_TYPE = 'AB-CAB'
                and aa.RTOM = '$rt'
                and dd. CON_STATUS IN ('ASSIGNED','INPROGRESS')
                and dd.CON_DATE_TO_CONTRACTOR BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";
    }
    if($st == 'COMPLETED')
    {
        $sql="";
    }
    if($st == 'RETURNED')
    {
        $sql="";
    }
    if($st == 'APPROVED')
    {
        $sql="";
    }

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'peoftth') {
    $dat = explode("_",$_GET['z']);

    $tempD1=  explode("-",$dat[1]);
    $tempD2=  explode("-",$dat[2]);

    $rt= $dat[0];
    $st= $dat[3];

    $from= $tempD1[1].'/'.$tempD1[2].'/'.$tempD1[0];
    $to= $tempD2[1].'/'.$tempD2[2].'/'.$tempD2[0];

    if($st == 'PENDING')
    {
        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_MEGA_PKG PKG,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,dd.CON_WORO_SEIT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_EQ_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_EQ_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.IPTV = '1'
                and aa.S_TYPE = 'E-IPTV FTTH'
                and dd. CON_STATUS IN ('ASSIGNED','INPROGRESS')
                and dd.CON_DATE_TO_CONTRACTOR BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";
    }
    if($st == 'COMPLETED')
    {
        $sql="";
    }
    if($st == 'RETURNED')
    {
        $sql="";
    }
    if($st == 'APPROVED')
    {
        $sql="";
    }

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'peocopper') {
    $dat = explode("_",$_GET['z']);

    $tempD1=  explode("-",$dat[1]);
    $tempD2=  explode("-",$dat[2]);

    $rt= $dat[0];
    $st= $dat[3];

    $from= $tempD1[1].'/'.$tempD1[2].'/'.$tempD1[0];
    $to= $tempD2[1].'/'.$tempD2[2].'/'.$tempD2[0];

    if($st == 'PENDING')
    {
        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_MEGA_PKG PKG,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,dd.CON_WORO_SEIT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_EQ_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_EQ_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.IPTV = '1'
                and aa.S_TYPE = 'E-IPTV COPPER'
                and dd. CON_STATUS IN ('ASSIGNED','INPROGRESS')
                and dd.CON_DATE_TO_CONTRACTOR BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";
    }
    if($st == 'COMPLETED')
    {
        $sql="";
    }
    if($st == 'RETURNED')
    {
        $sql="";
    }
    if($st == 'APPROVED')
    {
        $sql="";
    }

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}



if ($_GET['x'] == 'ftthpen') {

    $dat = explode("_",$_GET['z']);
    $rt= $dat[1];
    $con= $dat[0];

        $sql="select distinct aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,replace(dd.CON_TEC_CONTACT, ',', ' ') CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,dd.FTTH_INST_SIET,ee.FTTH_WIFI
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd,CONTRACTOR_NEW_CON ee
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and bb.CON_OSP_WORO_ID = cc.CON_ADDE_WORO_ID
                and bb.CON_OSP_WORO_ID =dd.CON_WORO_SEIT
                and cc.CON_ADDE_WORO_ID = dd.CON_WORO_SEIT
                and aa.SO_NUM = ee.CON_SO_ID
                and aa.S_TYPE = 'AB-FTTH'
                and aa.RTOM = :RTOM
                and dd.CON_NAME = :CON_NAME
                and dd. CON_STATUS IN ('ASSIGNED','INPROGRESS','INSTALL_CLOSED','RETURN_PENDING','PROV_CLOSED')";

//    $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,replace(dd.CON_TEC_CONTACT, ',', ' ') CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
//                dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,dd.FTTH_INST_SIET
//                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd
//                where aa.SETI = dd.CON_WORO_SEIT
//                and aa.S_TYPE = 'AB-FTTH'
//                and aa.RTOM = :RTOM
//                and dd.CON_NAME = :CON_NAME
//                and dd. CON_STATUS IN ('ASSIGNED','INPROGRESS','OSP_CLOSED','INSTALL_CLOSED')";


    $statment = $conn->prepare($sql);
    $statment->execute(['RTOM' => $rt, 'CON_NAME' => $con]);

    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;


}

if ($_GET['x'] == 'cabpen') {
    $dat = explode("_",$_GET['z']);
    $rt= $dat[1];
    $con= $dat[0];

        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.S_TYPE = 'AB-CAB'
                and aa.RTOM = :RTOM
                and dd.CON_NAME = :CON_NAME
                and dd. CON_STATUS IN ('ASSIGNED','INPROGRESS')";

    $statment = $conn->prepare($sql);
    $statment->execute(['RTOM' => $rt, 'CON_NAME' => $con]);
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'peoftthpen') {
    $dat = explode("_",$_GET['z']);
    $rt= $dat[1];
    $con= $dat[0];

        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_MEGA_PKG PKG,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,dd.CON_WORO_SEIT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_EQ_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_EQ_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.IPTV = '1'
                and aa.S_TYPE = 'E-IPTV FTTH'
                and aa.RTOM = :RTOM
                and dd.CON_NAME = :CON_NAME
                and dd. CON_STATUS IN ('ASSIGNED','INPROGRESS')";

    $statment = $conn->prepare($sql);
    $statment->execute(['RTOM' => $rt, 'CON_NAME' => $con]);
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'peocopperpen') {
    $dat = explode("_",$_GET['z']);
    $rt= $dat[1];
    $con= $dat[0];

        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_MEGA_PKG PKG,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,dd.CON_WORO_SEIT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_EQ_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_EQ_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.IPTV = '1'
                and aa.S_TYPE = 'E-IPTV COPPER'
                and aa.RTOM = :RTOM
                and dd.CON_NAME = :CON_NAME  
                and dd. CON_STATUS IN ('ASSIGNED','INPROGRESS')";

    $statment = $conn->prepare($sql);
    $statment->execute(['RTOM' => $rt, 'CON_NAME' => $con]);
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'opmcpatrej') {

    $dat = explode("_",$_GET['z']);
    $rt= $dat[1];
    $con= $dat[0];

    $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,replace(dd.CON_TEC_CONTACT, ',', ' ') CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,dd.FTTH_INST_SIET
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and bb.CON_OSP_WORO_ID = cc.CON_ADDE_WORO_ID
                and bb.CON_OSP_WORO_ID =dd.CON_WORO_SEIT
                and cc.CON_ADDE_WORO_ID = dd.CON_WORO_SEIT
                and aa.S_TYPE = 'AB-FTTH'
                and aa.RTOM = :RTOM
                and dd.CON_NAME = :CON_NAME
                and dd. CON_STATUS IN ('PAT_OPMC_REJECTED')";

//    $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,replace(dd.CON_TEC_CONTACT, ',', ' ') CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
//                dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,dd.FTTH_INST_SIET
//                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd
//                where aa.SETI = dd.CON_WORO_SEIT
//                and aa.S_TYPE = 'AB-FTTH'
//                and aa.RTOM = :RTOM
//                and dd.CON_NAME = :CON_NAME
//                and dd. CON_STATUS IN ('ASSIGNED','INPROGRESS','OSP_CLOSED','INSTALL_CLOSED')";


    $statment = $conn->prepare($sql);
    $statment->execute(['RTOM' => $rt, 'CON_NAME' => $con]);

    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;


}



if ($_GET['x'] == 'teamrep') {
    $dat = explode("_",$_GET['z']);

    $tempD1=  explode("-",$dat[1]);
    $tempD2=  explode("-",$dat[2]);

    $from= $tempD1[1].'/'.$tempD1[2].'/'.$tempD1[0];
    $to= $tempD2[1].'/'.$tempD2[2].'/'.$tempD2[0];

    if($dat[0] == 'ALL'){
        $sql="select AREA, CONTRACTOR, TO_CHAR(TEAM_DATE, 'MM/DD/YYYY') DAT, S_TYPE, TEAM_COUNT, EN_USER, TEAM_FLAG,TEAM_DATE
        from CONTRACTOR_TEAMS where TEAM_DATE BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
        AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm') and TEAM_FLAG = '1'";
    }else{
        $sql="select AREA, CONTRACTOR, TO_CHAR(TEAM_DATE, 'MM/DD/YYYY') DAT, S_TYPE, TEAM_COUNT, EN_USER, TEAM_FLAG,TEAM_DATE
        from CONTRACTOR_TEAMS where area = :AREA
        and TEAM_DATE BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
        AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm') and TEAM_FLAG = '1'";
    }

    $statment = $conn->prepare($sql);
    $statment->execute(['AREA' => $dat[0],'CONTRACTOR' => $dat[3]]);
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'userdetails') {
    $dat = explode("_",$_GET['z']);


    $sql="select cc.CON_MGT_UNAME,cc.CON_MGT_EMAIL, cc.CON_MGT_MOBILE,CON_MGT_USER,aa.CON_MGT_RTOMAREA, bb.CON_MGT_NAME
        from TECHS_MGT_AREA aa, TECHS_MGT_ROLE bb ,TECHS_MGT_LOGIN cc
        where aa.CON_MGT_ID = cc.CON_MGT_ID
        and cc.CON_MGT_ROLEID = bb.CON_MGT_ROLEID
        and aa.CON_MGT_RTOMAREA = :CON_MGT_RTOMAREA
        and cc.CON_MGT_CATOGARY = :CONTRACTOR";

    $statment = $conn->prepare($sql);
    $statment->execute(['CON_MGT_RTOMAREA' => $dat[0],'CONTRACTOR' => $dat[1]]);
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'patreject') {
    $con = $_GET['con'];
    $sql="select aa.RTOM,aa.SO_NUM,aa.VOICENUMBER,aa.S_TYPE,aa.ORDER_TYPE,dd.CON_STATUS,dd.CON_NAME,dd.PAT_USER,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE
        from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd
        where aa.SETI = dd.CON_WORO_SEIT
        and dd.CON_NAME = '$con'
        and dd.CON_STATUS = 'PAT_REJECTED'";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}

if ($_GET['x'] == 'patsuccess') {

    $con = $_GET['con'];
    $sql="select aa.RTOM,aa.SO_NUM,aa.VOICENUMBER,aa.S_TYPE,aa.ORDER_TYPE,dd.CON_STATUS,dd.CON_NAME,dd.PAT_USER,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE
        from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd
        where aa.SETI = dd.CON_WORO_SEIT
        and dd.CON_NAME = '$con'
        and dd.CON_STATUS = 'PAT_PASSED'";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}

if ($_GET['x'] == 'ftthbom') {

    $dat = explode("_",$_GET['z']);
    $rt= $dat[0];
    $con= $dat[1];

    $sql="select aa.RTOM,aa.SO_NUM,aa.VOICENUMBER,aa.S_TYPE,aa.ORDER_TYPE,dd.CON_STATUS,dd.CON_NAME,dd.PAT_USER,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE
          from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd
          where aa.SETI = dd.CON_WORO_SEIT
          and aa.RTOM = :RTOM
          and dd.CON_NAME = :CON_NAME
          and dd.CON_STATUS = :CON_STATUS
          and CON_WORO_APPROVEDBY is null";

    $statment = $conn->prepare($sql);
    $statment->execute(['CON_STATUS' => 'PAT_PASSED','CON_NAME' => $con,'RTOM' => $rt]);
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}

if ($_GET['x'] == 'ftthbomload') {

    $sql="select distinct BOM_REF, RTOM, CON from TECHS_BOM where CON =:CON";

    $statment = $conn->prepare($sql);
    $statment->execute(['CON' => $_GET['z']] );
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}




$statment->closeCursor();
header('Content-Type: application/json; charset=utf-8');
echo json_encode($returndata);
?>