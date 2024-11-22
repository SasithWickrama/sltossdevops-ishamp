<?php
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



if ($_GET['x'] == 'cab_assign') {
    $area = $_GET['y'];

    if($area == ',ALL'){
        $sql = "select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,aa.EX_NO
                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc
                where aa.SO_NUM = dd.CON_SERO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and TO_CHAR(aa.SETI) = bb.CON_OSP_WORO_ID
                and TO_CHAR(aa.SETI) = cc.CON_ADDE_WORO_ID
                AND aa.STATUS='0'
                AND aa.S_TYPE= 'AB-CAB'
                AND aa.IPTV IS NOT NULL";
    }else {
        $areas = str_replace(",", "','", $area);
        $sql = "select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,aa.EX_NO
                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc
                where aa.SO_NUM = dd.CON_SERO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and TO_CHAR(aa.SETI) = bb.CON_OSP_WORO_ID
                and TO_CHAR(aa.SETI) = cc.CON_ADDE_WORO_ID
                AND aa.STATUS='0'
                AND aa.RTOM IN ('$areas')
                AND aa.S_TYPE= 'AB-CAB'
                AND aa.IPTV IS NOT NULL";
    }
    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}

if ($_GET['x'] == 'ftth_assign') {
    $area = $_GET['y'];

    if($area == ',ALL'){
        $sql = "select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,aa.EX_NO
                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc
                where aa.SO_NUM = dd.CON_SERO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and TO_CHAR(aa.SETI) = bb.CON_OSP_WORO_ID
                and TO_CHAR(aa.SETI) = cc.CON_ADDE_WORO_ID
                AND aa.STATUS='0'
                AND aa.S_TYPE= 'AB-FTTH'
                AND aa.IPTV IS NOT NULL
                order by aa.RTOM,aa.LEA,aa.VOICENUMBER";
    }else {
        $areas = str_replace(",", "','", $area);
        $sql = "select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,aa.EX_NO
                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc
                where aa.SO_NUM = dd.CON_SERO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and TO_CHAR(aa.SETI) = bb.CON_OSP_WORO_ID
                and TO_CHAR(aa.SETI) = cc.CON_ADDE_WORO_ID
                AND aa.STATUS='0'
                AND aa.RTOM IN ('$areas')
                AND aa.S_TYPE= 'AB-FTTH'
                AND aa.IPTV IS NOT NULL
                order by aa.RTOM,aa.LEA,aa.VOICENUMBER";
    }

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}

if ($_GET['x'] == 'peo_assign') {
    $area = $_GET['y'];

    if($area == ',ALL'){
        $sql = "select  distinct aa.RTOM,aa.LEA,aa.SO_NUM,dd.CON_PSTN_NUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_MEGA_PKG PKG,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,dd.CON_WORO_SEIT,aa.EX_NO
                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd ,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_EQ_DATA bb
                where aa.SO_NUM = dd.CON_SERO_ID
                and aa.SETI = bb.CON_EQ_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and TO_CHAR(aa.SETI) = cc.CON_ADDE_WORO_ID
                AND aa.STATUS='0'
                and aa.S_TYPE like '%E-IPTV%'
                AND aa.IPTV IS NOT NULL
                order by aa.RTOM,aa.LEA,dd.CON_PSTN_NUMBER";
    }else {
        $areas = str_replace(",", "','", $area);
        $sql = "select  distinct aa.RTOM,aa.LEA,aa.SO_NUM,dd.CON_PSTN_NUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_MEGA_PKG PKG,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,dd.CON_WORO_SEIT,aa.EX_NO
                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd ,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_EQ_DATA bb
                where aa.SO_NUM = dd.CON_SERO_ID
                and aa.SETI = bb.CON_EQ_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and TO_CHAR(aa.SETI) = cc.CON_ADDE_WORO_ID
                AND aa.STATUS='0'
                and aa.S_TYPE like '%E-IPTV%'
                AND aa.RTOM IN ('$areas')
                AND aa.IPTV IS NOT NULL
                order by aa.RTOM,aa.LEA,dd.CON_PSTN_NUMBER";
    }
    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}

if ($_GET['x'] == 'return_pending') {
    $area = $_GET['y'];

    if($area == ',ALL'){
        $sql = "select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_NAME,bb.RETURNED_DATE, bb.RETURNED_REASON,bb.RETURNED_COMMENT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd, TECHS_RET_REASONS bb
                where aa.SETI = dd.CON_WORO_SEIT
                and aa.SO_NUM = bb.SOID
                and aa.S_TYPE = 'AB-FTTH'
                and dd.CON_STATUS IN ('RETURN_SLT')
                and bb.RETURNED_DATE = (select max(x.RETURNED_DATE) from TECHS_RET_REASONS x where x.SOID = bb.SOID )
                union
                select aa.RTOM,aa.LEA,aa.SO_NUM,dd.CON_PSTN_NUMBER VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_NAME,bb.RETURNED_DATE, bb.RETURNED_REASON,bb.RETURNED_COMMENT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd, TECHS_RET_REASONS bb
                where aa.SETI = dd.CON_WORO_SEIT
                and aa.SO_NUM = bb.SOID
                and aa.S_TYPE like '%E-IPTV%'
                and aa.IPTV > 0
                and dd.CON_STATUS IN ('RETURN_SLT')
                and bb.RETURNED_DATE = (select max(x.RETURNED_DATE) from TECHS_RET_REASONS x where x.SOID = bb.SOID )";
    }else {
        $areas = str_replace(",", "','", $area);
        $sql = "select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_NAME,bb.RETURNED_DATE, bb.RETURNED_REASON,bb.RETURNED_COMMENT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd, TECHS_RET_REASONS bb
                where aa.SETI = dd.CON_WORO_SEIT
                and aa.SO_NUM = bb.SOID
                and aa.S_TYPE = 'AB-FTTH'and aa.RTOM IN ('$areas')
                and dd.CON_STATUS IN ('RETURN_SLT')
                and bb.RETURNED_DATE = (select max(x.RETURNED_DATE) from TECHS_RET_REASONS x where x.SOID = bb.SOID )
                union
                select aa.RTOM,aa.LEA,aa.SO_NUM,dd.CON_PSTN_NUMBER VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_NAME,bb.RETURNED_DATE, bb.RETURNED_REASON,bb.RETURNED_COMMENT
                from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd, TECHS_RET_REASONS bb
                where aa.SETI = dd.CON_WORO_SEIT
                and aa.SO_NUM = bb.SOID
                and aa.S_TYPE like '%E-IPTV%' aa.RTOM IN ('$areas')
                and aa.IPTV > 0
                and dd.CON_STATUS IN ('RETURN_SLT')
                and bb.RETURNED_DATE = (select max(x.RETURNED_DATE) from TECHS_RET_REASONS x where x.SOID = bb.SOID )";
    }
    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}


if ($_GET['x'] == 'ftth') {
    $dat = explode("_",$_GET['z']);

    $rt= $dat[0];
    $st= $dat[3];

    $tempD1=  explode("-",$dat[1]);
    $tempD2=  explode("-",$dat[2]);

    $from= $tempD1[1].'/'.$tempD1[2].'/'.$tempD1[0];
    $to= $tempD2[1].'/'.$tempD2[2].'/'.$tempD2[0];

    if($st == 'ALL')
    {
        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,dd.CON_NAME
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and bb.CON_OSP_WORO_ID = cc.CON_ADDE_WORO_ID
                and bb.CON_OSP_WORO_ID =dd.CON_WORO_SEIT
                and cc.CON_ADDE_WORO_ID = dd.CON_WORO_SEIT
                and aa.S_TYPE = 'AB-FTTH'
                and aa.RTOM = '$rt'
                and dd.CON_STATUS_DATE BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')
                order by aa.RTOM,aa.LEA,aa.VOICENUMBER";
    }
    if($st == 'PENDING')
    {
        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,dd.CON_NAME
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and bb.CON_OSP_WORO_ID = cc.CON_ADDE_WORO_ID
                and bb.CON_OSP_WORO_ID =dd.CON_WORO_SEIT
                and cc.CON_ADDE_WORO_ID = dd.CON_WORO_SEIT
                and aa.S_TYPE = 'AB-FTTH'
                and aa.RTOM = '$rt'
                and dd.CON_STATUS IN ('ASSIGNED','INPROGRESS','OSP_CLOSED','PROV_CLOSED')
                and dd.CON_DATE_TO_CONTRACTOR BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')
                order by aa.RTOM,aa.LEA,aa.VOICENUMBER";
    }
    if($st == 'COMPLETED')
    {
        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,dd.CON_NAME
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and bb.CON_OSP_WORO_ID = cc.CON_ADDE_WORO_ID
                and bb.CON_OSP_WORO_ID =dd.CON_WORO_SEIT
                and cc.CON_ADDE_WORO_ID = dd.CON_WORO_SEIT
                and aa.S_TYPE = 'AB-FTTH'
                and aa.RTOM = '$rt'
                and dd.CON_STATUS IN ('COMPLETED','INSTALL_CLOSED', 'PAT_OPMC_PASSED','PAT_OPMC_REJECTED','OPMC_PAT_SKIP')
                and dd.CON_STATUS_DATE BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')
                order by aa.RTOM,aa.LEA,aa.VOICENUMBER";
    }
    if($st == 'RETURNED')
    {
        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,dd.CON_NAME
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and bb.CON_OSP_WORO_ID = cc.CON_ADDE_WORO_ID
                and bb.CON_OSP_WORO_ID =dd.CON_WORO_SEIT
                and cc.CON_ADDE_WORO_ID = dd.CON_WORO_SEIT
                and aa.S_TYPE = 'AB-FTTH'
                and aa.RTOM = '$rt'
                and dd.CON_STATUS IN ('RETURN_PENDING','RETURN_SLT','RETURN_CLOSED')
                and dd.CON_DATE_TO_CONTRACTOR BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')
                order by aa.RTOM,aa.LEA,aa.VOICENUMBER";
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
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,dd.CON_NAME
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

    if($st == 'PROVISIONING')
    {
        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,dd.CON_NAME
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.S_TYPE = 'AB-CAB'
                and aa.RTOM = '$rt'
                and dd. CON_STATUS IN ('')
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

    if($st == 'ALL')
    {
        $sql="select distinct aa.RTOM,aa.LEA,aa.SO_NUM,dd.CON_PSTN_NUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_MEGA_PKG PKG,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,dd.CON_WORO_SEIT,dd.CON_NAME
                from CON_CLARITY_SOLIST aa,CONTRACTOR_EQ_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_EQ_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.IPTV = '1'
                and aa.S_TYPE = 'E-IPTV FTTH'
                and dd.CON_STATUS_DATE BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')
                order by aa.RTOM,aa.LEA,dd.CON_PSTN_NUMBER";
    }
    if($st == 'PENDING')
    {
        $sql="select distinct aa.RTOM,aa.LEA,aa.SO_NUM,dd.CON_PSTN_NUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_MEGA_PKG PKG,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,dd.CON_WORO_SEIT,dd.CON_NAME
                from CON_CLARITY_SOLIST aa,CONTRACTOR_EQ_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_EQ_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.IPTV = '1'
                and aa.S_TYPE = 'E-IPTV FTTH'
                and dd. CON_STATUS IN ('ASSIGNED','INPROGRESS')
                and dd.CON_DATE_TO_CONTRACTOR BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')
                order by aa.RTOM,aa.LEA,dd.CON_PSTN_NUMBER";
    }
    if($st == 'COMPLETED')
    {
        $sql="select distinct aa.RTOM,aa.LEA,aa.SO_NUM,dd.CON_PSTN_NUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_MEGA_PKG PKG,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,dd.CON_WORO_SEIT,dd.CON_NAME
                from CON_CLARITY_SOLIST aa,CONTRACTOR_EQ_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_EQ_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.IPTV = '1'
                and aa.S_TYPE = 'E-IPTV FTTH'
                and dd. CON_STATUS IN ('COMPLETED')
                and dd.CON_STATUS_DATE BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')
                order by aa.RTOM,aa.LEA,dd.CON_PSTN_NUMBER";
    }
    if($st == 'RETURNED')
    {
        $sql="select distinct aa.RTOM,aa.LEA,aa.SO_NUM,dd.CON_PSTN_NUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_MEGA_PKG PKG,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,dd.CON_WORO_SEIT,dd.CON_NAME
                from CON_CLARITY_SOLIST aa,CONTRACTOR_EQ_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_EQ_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.IPTV = '1'
                and aa.S_TYPE = 'E-IPTV FTTH'
                and dd. CON_STATUS IN ('RETURN_PENDING','RETURN_SLT','RETURN_CLOSED')
                and dd.CON_STATUS_DATE BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')
                order by aa.RTOM,aa.LEA,dd.CON_PSTN_NUMBER";
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
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_MEGA_PKG PKG,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,dd.CON_WORO_SEIT,dd.CON_NAME
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

    if($st == 'PROVISIONING')
    {
        $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_MEGA_PKG PKG,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,dd.CON_WORO_SEIT,dd.CON_NAME
                from CON_CLARITY_SOLIST aa,CONTRACTOR_EQ_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_EQ_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.IPTV = '1'
                and aa.S_TYPE = 'E-IPTV COPPER'
                and dd. CON_STATUS IN ('')
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
    $statment->execute(['AREA' => $dat[0]]);
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'userdetails') {

    $sql="select distinct cc.CON_MGT_CATOGARY,cc.CON_MGT_UNAME,cc.CON_MGT_EMAIL, cc.CON_MGT_MOBILE,CON_MGT_USER,
        bb.CON_MGT_NAME, bb.CON_MGT_CATOGARY ROLETYP, (SELECT LISTAGG(CON_MGT_RTOMAREA, ' | ') WITHIN GROUP (ORDER BY CON_MGT_RTOMAREA)
        FROM TECHS_MGT_AREA
        where CON_MGT_ID = cc.CON_MGT_ID
        GROUP BY CON_MGT_ID) AREA
        from TECHS_MGT_ROLE bb ,TECHS_MGT_LOGIN cc
        where cc.CON_MGT_ROLEID = bb.CON_MGT_ROLEID
        and cc.CON_MGT_CATOGARY = :CONTRACTOR";

    $statment = $conn->prepare($sql);
    $statment->execute(['CONTRACTOR' => $_GET['z']]);
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'qty_assign') {

    $area =$_GET['z'];
    $areas = str_replace(",","','",$area);

    $sql="select CON_WORO_AREA, CON_EX_AREA,CON_SERO_ID,CON_PSTN_NUMBER,ADDRESS,DPLOOP,CON_NAME,SOD_TYP,QC_STAT,QC_USER
          from OPMC_QC_CHK
          where QC_STAT IN ( '0')
          and CON_WORO_AREA IN ('$areas')
          and CON_SERO_ID not like 'SLTQTY%'
          and QTY_IN_TIME BETWEEN TO_DATE (concat(TO_CHAR(SYSDATE -14, 'MM/DD/YYYY'),' 11:59:59 PM' ),'mm,dd,yyyy:hh:mi:ss pm')
          AND TO_DATE (concat(TO_CHAR(SYSDATE, 'MM-DD-YYYY'),' 12:00:00 AM' ),'mm,dd,yyyy:hh:mi:ss pm')
          union all
          select CON_WORO_AREA, CON_EX_AREA,CON_SERO_ID,CON_PSTN_NUMBER,ADDRESS,DPLOOP,CON_NAME,SOD_TYP,QC_STAT,QC_USER
          from OPMC_QC_CHK
          where QC_STAT IN ( '1')
          and CON_WORO_AREA IN ('$areas')
          and CON_SERO_ID not like 'SLTQTY%'";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'pat') {

    $dat = explode("_",$_GET['z']);
    $rtom =  $dat[0];
    $contrc =  $dat[1];

    $sql="select aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_STATUS,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,dd.CON_NAME,dd.CON_WORO_TASK_NAME
        from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd
        where aa.SETI = dd.CON_WORO_SEIT
        and aa.S_TYPE = 'AB-FTTH'
        and aa.RTOM = '$rtom'
        and dd.CON_STATUS IN ('PAT_OPMC_PASSED','PAT_CORRECTED','OPMC_PAT_SKIP') 
        and CON_NAME = '$contrc'";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}

if ($_GET['x'] == 'patreject') {

    $sql="select aa.RTOM,aa.SO_NUM,aa.VOICENUMBER,aa.S_TYPE,aa.ORDER_TYPE,dd.CON_STATUS,dd.CON_NAME,dd.PAT_USER,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE
        from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd
        where aa.SETI = dd.CON_WORO_SEIT
        and dd.CON_STATUS = 'PAT_REJECTED'";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}

if ($_GET['x'] == 'patsuccess') {

    $sql="select aa.RTOM,aa.SO_NUM,aa.VOICENUMBER,aa.S_TYPE,aa.ORDER_TYPE,dd.CON_STATUS,dd.CON_NAME,dd.PAT_USER,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE
        from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd
        where aa.SETI = dd.CON_WORO_SEIT
        and dd.CON_STATUS = 'PAT_PASSED'";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}

if ($_GET['x'] == 'patOpmc') {
    $rtom = $_GET['z'];



    $sql="select aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_STATUS,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,dd.CON_NAME,dd.CON_WORO_TASK_NAME
        from CON_CLARITY_SOLIST aa,CONTRACTOR_WORK_ORDERS dd
        where aa.SETI = dd.CON_WORO_SEIT
        and aa.S_TYPE = 'AB-FTTH'
        and aa.RTOM = '$rtom'
        and dd.CON_STATUS = 'COMPLETED'";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}

if ($_GET['x'] == 'search') {
    $tpno = $_GET['z'];



    $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,dd.CON_PSTN_NUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_STATUS,to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,aa.IPTV,dd.CON_NAME
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and bb.CON_OSP_WORO_ID = cc.CON_ADDE_WORO_ID
                and bb.CON_OSP_WORO_ID =dd.CON_WORO_SEIT
                and cc.CON_ADDE_WORO_ID = dd.CON_WORO_SEIT
                and dd.CON_PSTN_NUMBER = '$tpno'";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}


if ($_GET['x'] == 'ftthbomload') {

    $sql="select distinct BOM_REF, RTOM, CON from TECHS_BOM ";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}
$statment->closeCursor();
header('Content-Type: application/json; charset=utf-8');
echo json_encode($returndata);
?>
