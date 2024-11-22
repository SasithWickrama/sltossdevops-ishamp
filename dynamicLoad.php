<?php
$connstring = '(DESCRIPTION =
(ADDRESS_LIST =
(ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
)
(CONNECT_DATA = (SID=clty))
)';
$user = 'OSS_DEV_01';
$pass = 'pass123#';


try {
    $conn = new PDO("oci:dbname=" . $connstring, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
    echo "<script>alert('DB Error!'); </script>";
}


if ($_GET['x'] == 'ftth') {
    $rt= $_GET['y'];

    $dat = explode("_",$_GET['z']);

    $tempD1=  explode("-",$dat[1]);
    $tempD2=  explode("-",$dat[2]);

    $rt= $dat[0];

    $from= $tempD1[1].'/'.$tempD1[2].'/'.$tempD1[0];
    $to= $tempD2[1].'/'.$tempD2[2].'/'.$tempD2[0];

    $rtom = str_replace(",","','",$rt);
    #$sql = "select rtom ,lea ,so_id,circuit,ser_type,DATE_IN  from COLLECT_CPE_SN where STATUS =0 and rtom in ('$rtom')";

    $sql="select distinct CON_WORO_AREA,CON_SERO_ID,CON_PSTN_NUMBER,CON_WORO_SERVICE_TYPE,CON_WORO_ORDER_TYPE,CON_WORO_TASK_NAME,CON_NAME,CON_STATUS,
                    to_char(CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_DATE_TO_CONTRACTOR,
                    to_char(CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                    TO_CHAR(wo.CON_WORO_SEIT) SEIT,op.CON_OSP_DP_NAME ||'-'||op.CON_OSP_DP_LOOP DPLOOP,op.CON_EX_AREA,op.CON_OSP_PHONE_CLASS,pk.CON_FTTH_PKG,
                    op.CON_PHN_PURCH, replace(D.CON_ADDE_STREETNUMBER||' '||D.CON_ADDE_STRN_NAMEANDTYPE||' '||D.CON_ADDE_SUBURB||' '||D.CON_ADDE_CITY ,',',' ') ADDRE,replace(op.CON_SALES,',',' ') CON_SALES,
                    trunc( sysdate-wo.CON_DATE_TO_CONTRACTOR )
                    from CONTRACTOR_WORK_ORDERS wo,CONTRACTOR_OSP_DATA op,CONTRACTOR_SERVICE_ADDRESS D,CONTRACTOR_FTTH_DATA pk
                    where wo.CON_SERO_ID = op.CON_OSP_SERO_ID(+)
                    and TO_CHAR(wo.CON_WORO_SEIT) = op.CON_OSP_WORO_ID (+)
                    and wo.CON_SERO_ID = D.CON_ADDE_SERO_ID(+)
                    and TO_CHAR(wo.CON_WORO_SEIT) = D.CON_ADDE_WORO_ID(+)
                    and TO_CHAR(wo.CON_WORO_SEIT) = pk.CON_FTTH_WORO_ID(+)
                    and wo.CON_WORO_SERVICE_TYPE = 'AB-FTTH'
                    and wo.CON_STATUS IN ( 'ASSIGNED','INPROGRESS')
                    and wo.CON_WORO_AREA = '$dat[0]'
                    and  wo.CON_STATUS_DATE BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm') 
                    AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";

    // echo $sql ;
    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;

}

if ($_GET['x'] == 'cab') {
    $rt= $_GET['y'];
    $rtom = str_replace(",","','",$rt);

    $dat = explode("_",$_GET['z']);

    $tempD1=  explode("-",$dat[1]);
    $tempD2=  explode("-",$dat[2]);


    $from= $tempD1[1].'/'.$tempD1[2].'/'.$tempD1[0];
    $to= $tempD2[1].'/'.$tempD2[2].'/'.$tempD2[0];


    $sql="select distinct CON_WORO_AREA,CON_SERO_ID,CON_PSTN_NUMBER,CON_WORO_SERVICE_TYPE,CON_WORO_ORDER_TYPE,CON_WORO_TASK_NAME,CON_NAME,CON_STATUS,
                    to_char(CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_DATE_TO_CONTRACTOR,
                    to_char(CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                    TO_CHAR(wo.CON_WORO_SEIT) SEIT,op.CON_OSP_DP_NAME ||'-'||op.CON_OSP_DP_LOOP DPLOOP,op.CON_EX_AREA,op.CON_OSP_PHONE_CLASS,op.CON_OSP_PHONE_COLOUR,
                    op.CON_PHN_PURCH, replace(D.CON_ADDE_STREETNUMBER||' '||D.CON_ADDE_STRN_NAMEANDTYPE||' '||D.CON_ADDE_SUBURB||' '||D.CON_ADDE_CITY ,',',' ') ADDRE,replace(op.CON_SALES,',',' ') CON_SALES,
                    trunc( sysdate-wo.CON_DATE_TO_CONTRACTOR )
                    from CONTRACTOR_WORK_ORDERS wo,CONTRACTOR_OSP_DATA op,CONTRACTOR_SERVICE_ADDRESS D
                    where wo.CON_SERO_ID = op.CON_OSP_SERO_ID(+)
                    and TO_CHAR(wo.CON_WORO_SEIT) = op.CON_OSP_WORO_ID (+)
                    and wo.CON_SERO_ID = D.CON_ADDE_SERO_ID(+)
                    and TO_CHAR(wo.CON_WORO_SEIT) = D.CON_ADDE_WORO_ID(+)
                    and wo.CON_WORO_SERVICE_TYPE = 'AB-CAB'
                    and wo.CON_WORO_AREA = '$dat[0]'
                    and wo.CON_STATUS IN ( 'ASSIGNED','INPROGRESS')
                    and  wo.CON_STATUS_DATE BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm')
                    AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";

    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'peoftth') {
    $rt= $_GET['y'];
    $rtom = str_replace(",","','",$rt);

    $dat = explode("_",$_GET['z']);

    $tempD1=  explode("-",$dat[1]);
    $tempD2=  explode("-",$dat[2]);


    $from= $tempD1[1].'/'.$tempD1[2].'/'.$tempD1[0];
    $to= $tempD2[1].'/'.$tempD2[2].'/'.$tempD2[0];

    $sql = "select distinct CON_WORO_AREA,CON_SERO_ID,CON_PSTN_NUMBER,CON_WORO_SERVICE_TYPE,CON_WORO_ORDER_TYPE,CON_WORO_TASK_NAME,CON_NAME,CON_STATUS,
                    to_char(CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_DATE_TO_CONTRACTOR,
                    to_char(CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                    TO_CHAR(wo.CON_WORO_SEIT) SEIT,op.CON_EQ_CARD ||'-'||op.CON_EQ_PORT,op.CON_EX_AREA,'',CON_MEGA_PKG,
                    op.CON_PHN_PURCH, replace(D.CON_ADDE_STREETNUMBER||' '||D.CON_ADDE_STRN_NAMEANDTYPE||' '||D.CON_ADDE_SUBURB||' '||D.CON_ADDE_CITY ,',',' ') ADDRE,replace(op.CON_SALES,',',' ') CON_SALES,
                    trunc( sysdate-wo.CON_DATE_TO_CONTRACTOR )
                    from CONTRACTOR_WORK_ORDERS wo,CONTRACTOR_EQ_DATA op,CONTRACTOR_SERVICE_ADDRESS D
                    where wo.CON_SERO_ID = op.CON_EQ_SERO_ID(+)
                    and TO_CHAR(wo.CON_WORO_SEIT) = op.CON_EQ_WORO_ID (+)
                    and wo.CON_SERO_ID = D.CON_ADDE_SERO_ID(+)
                    and TO_CHAR(wo.CON_WORO_SEIT) = D.CON_ADDE_WORO_ID(+)
                    and wo.CON_WORO_SERVICE_TYPE = 'E-IPTV COPPER'
                    and wo.CON_WORO_AREA = '$dat[0]'
                    and wo.CON_STATUS IN ( 'ASSIGNED','INPROGRESS')
                    and  wo.CON_STATUS_DATE BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm')
                    AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";
    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'peocab') {
    $rt= $_GET['y'];
    $rtom = str_replace(",","','",$rt);

    $dat = explode("_",$_GET['z']);

    $tempD1=  explode("-",$dat[1]);
    $tempD2=  explode("-",$dat[2]);


    $from= $tempD1[1].'/'.$tempD1[2].'/'.$tempD1[0];
    $to= $tempD2[1].'/'.$tempD2[2].'/'.$tempD2[0];

    $sql = "select distinct CON_WORO_AREA,CON_SERO_ID,CON_PSTN_NUMBER,CON_WORO_SERVICE_TYPE,CON_WORO_ORDER_TYPE,CON_WORO_TASK_NAME,CON_NAME,CON_STATUS,
                    to_char(CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_DATE_TO_CONTRACTOR,
                    to_char(CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,
                    TO_CHAR(wo.CON_WORO_SEIT) SEIT,op.CON_EQ_CARD ||'-'||op.CON_EQ_PORT,op.CON_EX_AREA,'',CON_MEGA_PKG,
                    op.CON_PHN_PURCH, replace(D.CON_ADDE_STREETNUMBER||' '||D.CON_ADDE_STRN_NAMEANDTYPE||' '||D.CON_ADDE_SUBURB||' '||D.CON_ADDE_CITY ,',',' ') ADDRE,replace(op.CON_SALES,',',' ') CON_SALES,
                    trunc( sysdate-wo.CON_DATE_TO_CONTRACTOR )
                    from CONTRACTOR_WORK_ORDERS wo,CONTRACTOR_EQ_DATA op,CONTRACTOR_SERVICE_ADDRESS D
                    where wo.CON_SERO_ID = op.CON_EQ_SERO_ID(+)
                    and TO_CHAR(wo.CON_WORO_SEIT) = op.CON_EQ_WORO_ID (+)
                    and wo.CON_SERO_ID = D.CON_ADDE_SERO_ID(+)
                    and TO_CHAR(wo.CON_WORO_SEIT) = D.CON_ADDE_WORO_ID(+)
                    and wo.CON_WORO_SERVICE_TYPE = 'E-IPTV COPPER'
                    and wo.CON_WORO_AREA = '$dat[0]'
                    and wo.CON_STATUS IN ( 'ASSIGNED','INPROGRESS')
                    and  wo.CON_STATUS_DATE BETWEEN TO_DATE('$from 12:00:00 AM','mm,dd,yyyy:hh:mi:ss pm')
                    AND TO_DATE('$to 11:59:59 PM','mm,dd,yyyy:hh:mi:ss pm')";
    // echo $sql ;
    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

//SMART HOME

if ($_GET['x'] == 'smarthome_pending') {
    $rt= $_GET['y'];
    $rtom = str_replace(",","','",$rt);

    if ($_GET['z'] == 0){
        $sql = "select RTOM ,LEA ,SO_ID,CIRCUIT,ORDER_TYPE,to_char(DATE_IN, 'mm/dd/yyyy hh:mi:ss AM') DATE_IN,STATUS,TASKNAME,CON_NAME,CUSTOMER_NAME,STATUS  
            from SMART_HOME_SO where  STATUS in ('0','1' , '2', '3') and rtom in ('$rtom')";
    }else {

        $dat = explode("_",$_GET['z']);

        $tempD1=  explode("-",$dat[1]);
        $tempD2=  explode("-",$dat[2]);

        $from= $tempD1[1].'/'.$tempD1[2].'/'.$tempD1[0];
        $to= $tempD2[1].'/'.$tempD2[2].'/'.$tempD2[0];

        $sql = "select RTOM ,LEA ,SO_ID,CIRCUIT,ORDER_TYPE,to_char(DATE_IN, 'mm/dd/yyyy hh:mi:ss AM') DATE_IN,STATUS,TASKNAME,CON_NAME,CUSTOMER_NAME,STATUS  
            from SMART_HOME_SO where  STATUS in ('0','1' , '2', '3') and rtom in ('$rtom')";
    }

    // echo $sql ;
    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}

if ($_GET['x'] == 'smarthome_completed') {
    $rt= $_GET['y'];
    $rtom = str_replace(",","','",$rt);

    if ($_GET['z'] == 0){
        $sql = "select RTOM ,LEA ,SO_ID,CIRCUIT,ORDER_TYPE,to_char(DATE_IN, 'mm/dd/yyyy hh:mi:ss AM') DATE_IN,
            to_char(DATE_IN, 'mm/dd/yyyy hh:mi:ss AM') DATE_COM,TASKNAME,CON_NAME,CUSTOMER_NAME,STATUS  
            from SMART_HOME_SO where  STATUS = '4' and rtom in ('$rtom')";
    }else {

        $dat = explode("_",$_GET['z']);

        $tempD1=  explode("-",$dat[1]);
        $tempD2=  explode("-",$dat[2]);

        $from= $tempD1[1].'/'.$tempD1[2].'/'.$tempD1[0];
        $to= $tempD2[1].'/'.$tempD2[2].'/'.$tempD2[0];


        $sql = "select RTOM ,LEA ,SO_ID,CIRCUIT,ORDER_TYPE,to_char(DATE_IN, 'mm/dd/yyyy hh:mi:ss AM') DATE_IN,
            to_char(DATE_IN, 'mm/dd/yyyy hh:mi:ss AM') DATE_COM,TASKNAME,CON_NAME,CUSTOMER_NAME,STATUS  
            from SMART_HOME_SO where  STATUS = '4' and rtom in ('$rtom')";
    }


    // echo $sql ;
    $statment = $conn->prepare($sql);
    $statment->execute();
    $cctdetails = $statment->fetchAll();
    $returndata['data'] = $cctdetails;
}


$statment->closeCursor();
header('Content-Type: application/json; charset=utf-8');
echo json_encode($returndata);
?>