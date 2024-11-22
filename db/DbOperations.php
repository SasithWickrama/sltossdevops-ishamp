<?php
class DbOperations
{

    private $con;
    private $conrpt;

    function __construct()
    {
        include "DbConnect.php";

        $db = new DbConnect;
        $this->con = $db->connect();
        //$this->conrpt = $db->connectOssRpt();
    }

    function log_logging($usr, $ip)
    {
        $sql = "INSERT INTO CONTRACTOR_LOG (CON_USER,LOG_DATE,MSG ) 
        VALUES ('$usr',sysdate,'Successfully Logging to the System using ip : $ip ')";

        $result= oci_parse($this->con, $sql);
        if(oci_execute($result))
        {
            return 0;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }

    }

    function log_fail($usr, $ip)
    {
        $sql = "INSERT INTO CONTRACTOR_LOG (CON_USER,LOG_DATE,MSG ) 
        VALUES ('$usr',sysdate,'Logging Attempt Fail, logging ip : $ip ')";

        $result= oci_parse($this->con, $sql);
        if(oci_execute($result))
        {
            return 0;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }

    }

    public function log_all($usr,$so_id,$msg)
    {
        $sql ="INSERT INTO CONTRACTOR_LOG (CON_USER,LOG_DATE,SO_ID,MSG ) VALUES (:USR,sysdate,:SOD,:MSG)";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['USR' => $usr, 'SOD' => $so_id, 'MSG' => $msg]);
    }

    public function validate_user($uname, $con){
        $sql ="select aa.CON_MGT_CATOGARY, aa.CON_MGT_UNAME,aa.CON_MGT_MOBILE,aa.CON_MGT_USER,
                bb.CON_MGT_CATOGARY ,bb.CON_MGT_NAME,cc.CON_MGT_RTOMAREA,aa.CON_MGT_PW_HASH
                from TECHS_MGT_LOGIN aa, TECHS_MGT_ROLE bb,TECHS_MGT_AREA cc
                where aa. CON_MGT_ID  = cc.CON_MGT_ID
                and aa.CON_MGT_ROLEID = bb.CON_MGT_ROLEID
                and aa.CON_MGT_CATOGARY = :CON_MGT_CATOGARY
                and aa.CON_MGT_UNAME = :CON_MGT_UNAME";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['CON_MGT_CATOGARY' => $con, 'CON_MGT_UNAME' => $uname]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }else{
            echo "<script type='text/javascript'>alert('No Data Found')</script>";
        }
    }

    public function getCont(){
        $sql ="select distinct CON_NAME from TECHS_CONTRACTOR 
               where CON_NAME <> :CON_NAME order by CON_NAME";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['CON_NAME' => 'SLT']);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }else{
            echo "<script type='text/javascript'>alert('No Data Found')</script>";
        }
    }

    public function change_hash($uname , $con)
    {
        $sql ="update TECHS_MGT_LOGIN set CON_MGT_PW_HASH = '' ,CON_MGT_LASTLOG= sysdate
                            where CON_MGT_UNAME = :CON_MGT_UNAME
                            and CON_MGT_CATOGARY = :CON_MGT_CATOGARY";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['CON_MGT_CATOGARY' => $con, 'CON_MGT_UNAME' => $uname]);
    }

    function con_area()
    {
        $sql ="select distinct  RTOM_CODE  from SLT_AREA order by RTOM_CODE";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }else{
            echo "<script type='text/javascript'>alert('No Data Found')</script>";
        }
    }

    function con_area_rt($area)
    {
        $areas = str_replace(",","','",$area);
        $sql ="select distinct  RTOM_CODE  from SLT_AREA where RTOM_CODE IN ($areas) order by RTOM_CODE";

        echo $sql;
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }else{
            return $sql;
            echo "<script type='text/javascript'>alert('No Data Found')</script>";
        }
    }

    function getConDetail($sod,$siet, $cat)
    {

        if ($cat == 'FTTH' || $cat == 'CAB'){

            $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_RECIEV_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_OSP_DP_NAME|| ' ' ||bb.CON_OSP_DP_LOOP DP,bb.CON_OSP_PHONE_COLOUR PKG,bb.CON_OSP_PHONE_CLASS,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,
                to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,dd.CON_WORO_DISCRIPTION
                from CON_CLARITY_SOLIST aa,CONTRACTOR_OSP_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_OSP_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and dd.CON_WORO_SEIT = :CON_WORO_SEIT
                and aa. SO_NUM = :SO_NUM";

        }
        if ($cat == 'PEO'){
            $sql="select aa.RTOM,aa.LEA,aa.SO_NUM,aa.VOICENUMBER,aa.ORDER_TYPE,aa.S_TYPE,dd.CON_CUS_NAME,dd.CON_TEC_CONTACT,dd.CON_STATUS,to_char(dd.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM') CON_RECIEV_DATE,
                replace(cc.CON_ADDE_STREETNUMBER|| ' ' || cc.CON_ADDE_STRN_NAMEANDTYPE || ' ' || cc.CON_ADDE_SUBURB || ' ' || cc.CON_ADDE_CITY, ',', ' ') ADDRE,
                bb.CON_EQ_LOC_NAME|| '-' ||bb.CON_EQ_INDEX MSAN,bb.CON_MEGA_PKG PKG,bb.CON_EQ_CARD|| '-' ||bb.CON_EQ_PORT CARDPORT,bb.CON_PHN_PURCH,bb.CON_SALES,dd.CON_WORO_TASK_NAME,aa.IPTV,dd.CON_WORO_SEIT,
                to_char(dd.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM') CON_STATUS_DATE,dd.CON_WORO_DISCRIPTION
                from CON_CLARITY_SOLIST aa,CONTRACTOR_EQ_DATA bb,CONTRACTOR_SERVICE_ADDRESS cc,CONTRACTOR_WORK_ORDERS dd
                where aa.SETI = bb.CON_EQ_WORO_ID
                and aa.SETI = cc.CON_ADDE_WORO_ID
                and aa.SETI = dd.CON_WORO_SEIT
                and aa.IPTV = '1'
                and dd.CON_WORO_SEIT = :CON_WORO_SEIT
                and aa. SO_NUM = :SO_NUM";

        }

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['CON_WORO_SEIT' => $siet, 'SO_NUM' => $sod]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }else{
            echo "<script type='text/javascript'>alert('No Data Found')</script>";
        }
    }

    function getSnAssign($sod)
    {
        $sql ="select * from SERIAL_NO_SO where SO_ID= :SOD and STATUS <> '20'";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOD' => $sod]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getMobTeam($con,$areas)
    {

       if(strpos($areas, 'ALL') !== false){
            $sql="select distinct aa.USERNAME,aa.UNAME from APP_LOGIN aa, APP_LOGIN_RTOMS bb
                    where aa.USERNAME = bb.USERNAME
                    and aa.CONTRACTOR  = :CONTRACTOR
                    order by aa.USERNAME";
        }else{
            //$sql ="select USERNAME,UNAME from APP_LOGIN where CONTRACTOR  = :CONTRACTOR and  RT_AREA IN ($areas)";
            $sql="select distinct aa.USERNAME,aa.UNAME from APP_LOGIN aa, APP_LOGIN_RTOMS bb
                    where aa.USERNAME = bb.USERNAME
                    and aa.CONTRACTOR  = :CONTRACTOR
                    and bb.RTOM IN ($areas) 
                    order by aa.USERNAME";
        }

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['CONTRACTOR' => $con]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }


    }

    function getTeamUser($team,$con)
    {
        $sql ="select aa.CON_USER
            from TECHS_CON_USER aa, TECHS_CON_TEAMS bb
            where aa.CON_TEAM_ID = bb.CON_TEAM_ID
            and aa.CON_CONTRACTOR = :CONTRACTOR
            and bb.CON_TEAM = :TEAM";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['CONTRACTOR' => $con,'TEAM' => $team]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }



    function getSn($sod)
    {
        $sql = "select * from SERIAL_NO_ATT where SOID= :SOID";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOID' => $sod]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getLog($sod)
    {
        $sql = "select CON_USER,to_char(LOG_DATE, 'mm/dd/yyyy hh:mi:ss AM') LDATE,SO_ID,MSG ,LOG_DATE
        from CONTRACTOR_LOG where SO_ID= :SOID order by LOG_DATE DESC ";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOID' => $sod]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getTeamList($area,$con)
    {
        if($area == 'ALL'){
            $sql = "select AREA, CONTRACTOR, TO_CHAR(TEAM_DATE, 'MM/DD/YYYY'), S_TYPE, TEAM_COUNT, EN_USER, TEAM_FLAG,TEAM_DATE
	                from CONTRACTOR_TEAMS 
	                where CONTRACTOR = :CONTRACTOR 
	                and TEAM_DATE  = TO_DATE(TO_CHAR(sysdate, 'MM/DD/YYYY'), 'MM/DD/YYYY')";
        }else{
            $areas = str_replace(",","','",$area);

            $sql = "select AREA, CONTRACTOR, TO_CHAR(TEAM_DATE, 'MM/DD/YYYY'), S_TYPE, TEAM_COUNT, EN_USER, TEAM_FLAG,TEAM_DATE
	                from CONTRACTOR_TEAMS 
	                where CONTRACTOR = :CONTRACTOR 
	                and area IN  ('$areas')
	                and TEAM_DATE  = TO_DATE(TO_CHAR(sysdate, 'MM/DD/YYYY'), 'MM/DD/YYYY')";
        }


        $stmt = $this->con->prepare($sql);
        $stmt->execute(['CONTRACTOR' => $con]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getTeamReport($area,$from,$to,$con)
    {

            $sql = "select AREA, CONTRACTOR, TO_CHAR(TEAM_DATE, 'MM/DD/YYYY'), S_TYPE, TEAM_COUNT, EN_USER, TEAM_FLAG,TEAM_DATE
	                from CONTRACTOR_TEAMS
	                where CONTRACTOR = :CONTRACTOR
	                and area = :AREA
	                and  TEAM_DATE  BETWEEN TO_DATE(TO_CHAR('$from', 'MM/DD/YYYY'), 'MM/DD/YYYY')
	                and  TO_DATE(TO_CHAR('$to', 'MM/DD/YYYY'), 'MM/DD/YYYY')";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['AREA' => $area,'CONTRACTOR' => $con]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getNewSod($a,$b)
    {
        $sql ="select  c.CON_WORO_AREA,C.CON_SERO_ID,c.CON_PSTN_NUMBER,c.CON_WORO_SERVICE_TYPE,C.CON_WORO_ORDER_TYPE,to_char(c.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM'),
        C.CON_CUS_NAME,C.CON_TEC_CONTACT,d.CON_ADDE_STREETNUMBER||' '||d.CON_ADDE_STRN_NAMEANDTYPE||' '||d.CON_ADDE_SUBURB||' '||d.CON_ADDE_CITY,
        e.CON_OSP_DP_NAME||' -- '||e.CON_OSP_DP_LOOP,e.CON_OSP_PHONE_CLASS,e.CON_OSP_PHONE_COLOUR,e.CON_PHN_PURCH,c.CON_WORO_TASK_NAME,c.CON_WORO_SEIT,
        A.IPTV,e.CON_SALES,EX_NO,c.CON_WORO_DISCRIPTION,to_char(c.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM'),e.CON_EX_AREA,CON_STATUS
        from CON_CLARITY_SOLIST A,CONTRACTOR_WORK_ORDERS c,CONTRACTOR_SERVICE_ADDRESS d,CONTRACTOR_OSP_DATA e
        where A.SETI=c.CON_WORO_SEIT
        and A.SO_NUM = C.CON_SERO_ID
        and A.SETI=d.CON_ADDE_WORO_ID
        and A.SETI=e.CON_OSP_WORO_ID
        and d.CON_ADDE_WORO_ID=c.CON_WORO_SEIT
        and d.CON_ADDE_WORO_ID=e.CON_OSP_WORO_ID
        and c.CON_WORO_SEIT=e.CON_OSP_WORO_ID
        and A.SO_NUM = :SO_NUM
        and A.SETI= :SETI
        and C.CON_STATUS IN ('ASSIGNED', 'INPROGRESS','OSP_CLOSED','PROV_CLOSED' ,'RETURN_PENDING')";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_NUM' => $a ,'SETI' => $b]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getNewSodOsp($a,$b)
    {
        $sql ="select  c.CON_WORO_AREA,C.CON_SERO_ID,c.CON_PSTN_NUMBER,c.CON_WORO_SERVICE_TYPE,C.CON_WORO_ORDER_TYPE,to_char(c.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM'),
        C.CON_CUS_NAME,C.CON_TEC_CONTACT,d.CON_ADDE_STREETNUMBER||' '||d.CON_ADDE_STRN_NAMEANDTYPE||' '||d.CON_ADDE_SUBURB||' '||d.CON_ADDE_CITY,
        e.CON_OSP_DP_NAME||' -- '||e.CON_OSP_DP_LOOP,e.CON_OSP_PHONE_CLASS,e.CON_OSP_PHONE_COLOUR,e.CON_PHN_PURCH,c.CON_WORO_TASK_NAME,c.CON_WORO_SEIT,
        A.IPTV,e.CON_SALES,EX_NO,c.CON_WORO_DISCRIPTION,to_char(c.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM'),e.CON_EX_AREA,
        to_char(c.FTTH_INST, 'mm/dd/yyyy hh:mi:ss AM'),c.FTTH_INST_SIET,c.FTTH_INST_TASK,c.CON_STATUS
        from CON_CLARITY_SOLIST A,CONTRACTOR_WORK_ORDERS c,CONTRACTOR_SERVICE_ADDRESS d,CONTRACTOR_OSP_DATA e
        where A.SETI=c.CON_WORO_SEIT
        and A.SO_NUM = C.CON_SERO_ID
        and A.SETI=d.CON_ADDE_WORO_ID
        and A.SETI=e.CON_OSP_WORO_ID
        and d.CON_ADDE_WORO_ID=c.CON_WORO_SEIT
        and d.CON_ADDE_WORO_ID=e.CON_OSP_WORO_ID
        and c.CON_WORO_SEIT=e.CON_OSP_WORO_ID
        and A.INST_SEIT=C.FTTH_INST_SIET
        and A.SO_NUM = :SO_NUM
        and A.SETI= :SETI
        --and A.INST_SEIT= '1439848932'
        and C.CON_STATUS IN ('ASSIGNED', 'INPROGRESS','OSP_CLOSED','INSTALL_CLOSED','COMPLETED','PAT_OPMC_REJECTED','OPMC_PAT_SKIP')";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_NUM' => $a ,'SETI' => $b]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }


    function getSodAll($a)
    {
        $sql ="select  c.CON_WORO_AREA,C.CON_SERO_ID,c.CON_PSTN_NUMBER,c.CON_WORO_SERVICE_TYPE,C.CON_WORO_ORDER_TYPE,to_char(c.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM'),
        C.CON_CUS_NAME,C.CON_TEC_CONTACT,d.CON_ADDE_STREETNUMBER||' '||d.CON_ADDE_STRN_NAMEANDTYPE||' '||d.CON_ADDE_SUBURB||' '||d.CON_ADDE_CITY,
        e.CON_OSP_DP_NAME||' -- '||e.CON_OSP_DP_LOOP,e.CON_OSP_PHONE_CLASS,e.CON_OSP_PHONE_COLOUR,e.CON_PHN_PURCH,c.CON_WORO_TASK_NAME,c.CON_WORO_SEIT,
        A.IPTV,e.CON_SALES,EX_NO,c.CON_WORO_DISCRIPTION,to_char(c.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM'),e.CON_EX_AREA,
        to_char(c.FTTH_INST, 'mm/dd/yyyy hh:mi:ss AM'),c.FTTH_INST_SIET,c.FTTH_INST_TASK,c.CON_STATUS,a.CONTRATOR
        from CON_CLARITY_SOLIST A,CONTRACTOR_WORK_ORDERS c,CONTRACTOR_SERVICE_ADDRESS d,CONTRACTOR_OSP_DATA e
        where A.SETI=c.CON_WORO_SEIT
        and A.SO_NUM = C.CON_SERO_ID
        and A.SETI=d.CON_ADDE_WORO_ID
        and A.SETI=e.CON_OSP_WORO_ID
        and d.CON_ADDE_WORO_ID=c.CON_WORO_SEIT
        and d.CON_ADDE_WORO_ID=e.CON_OSP_WORO_ID
        and c.CON_WORO_SEIT=e.CON_OSP_WORO_ID
        and A.SO_NUM = :SO_NUM
        union all 
        select  c.CON_WORO_AREA,C.CON_SERO_ID,c.CON_PSTN_NUMBER,c.CON_WORO_SERVICE_TYPE,C.CON_WORO_ORDER_TYPE,to_char(c.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM'),
        C.CON_CUS_NAME,C.CON_TEC_CONTACT,d.CON_ADDE_STREETNUMBER||' '||d.CON_ADDE_STRN_NAMEANDTYPE||' '||d.CON_ADDE_SUBURB||' '||d.CON_ADDE_CITY,
        e.CON_EQ_LOC_NAME,e.CON_EQ_CARD||' '||e.CON_EQ_PORT,e.CON_MEGA_PKG,e.CON_PHN_PURCH,c.CON_WORO_TASK_NAME,c.CON_WORO_SEIT,
        A.IPTV,e.CON_SALES,EX_NO,c.CON_WORO_DISCRIPTION,to_char(c.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM'), e.CON_EX_AREA,
        to_char(c.FTTH_INST, 'mm/dd/yyyy hh:mi:ss AM'),c.FTTH_INST_SIET,e.CON_MEGA_PKG,c.CON_STATUS,a.CONTRATOR
        from CON_CLARITY_SOLIST A,CONTRACTOR_WORK_ORDERS c,CONTRACTOR_SERVICE_ADDRESS d,CONTRACTOR_EQ_DATA e
        where A.SETI=c.CON_WORO_SEIT
        and A.SO_NUM = C.CON_SERO_ID
        and A.SETI=d.CON_ADDE_WORO_ID
        and A.SETI=e.CON_EQ_WORO_ID
        and d.CON_ADDE_WORO_ID=c.CON_WORO_SEIT
        and d.CON_ADDE_WORO_ID=e.CON_EQ_WORO_ID
        and c.CON_WORO_SEIT=e.CON_EQ_WORO_ID
        and A.SO_NUM = :SO_NUM";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_NUM' => $a]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getNewSodWo($a,$b)
    {
        $sql ="select c.CON_WORO_AREA,C.CON_SERO_ID,c.CON_PSTN_NUMBER,c.CON_WORO_SERVICE_TYPE,C.CON_WORO_ORDER_TYPE,to_char(c.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM'),
        C.CON_CUS_NAME,C.CON_TEC_CONTACT,d.CON_ADDE_STREETNUMBER||' '||d.CON_ADDE_STRN_NAMEANDTYPE||' '||d.CON_ADDE_SUBURB||' '||d.CON_ADDE_CITY,
        e.CON_OSP_DP_NAME||' -- '||e.CON_OSP_DP_LOOP,e.CON_OSP_PHONE_CLASS,e.CON_OSP_PHONE_COLOUR,e.CON_PHN_PURCH,c.CON_WORO_TASK_NAME,c.CON_WORO_SEIT,
        0,e.CON_SALES,0,c.CON_WORO_DISCRIPTION,to_char(c.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM'),e.CON_EX_AREA,CON_STATUS
        from CONTRACTOR_WORK_ORDERS c,CONTRACTOR_SERVICE_ADDRESS d,CONTRACTOR_OSP_DATA e
        where c.CON_WORO_SEIT=d.CON_ADDE_WORO_ID
        and c.CON_WORO_SEIT=e.CON_OSP_WORO_ID
        and d.CON_ADDE_WORO_ID=e.CON_OSP_WORO_ID
        and C.CON_SERO_ID = :SO_NUM
        and c.CON_WORO_SEIT= :SETI
        and C.CON_STATUS IN ('ASSIGNED', 'INPROGRESS') ";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_NUM' => $a ,'SETI' => $b]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getNewSodIptv($a,$b)
    {
        $sql ="select a.SO_NUM, b.CON_EQ_INDEX, b.CON_EQ_LOC_NAME,b.CON_EQ_CARD||' '||b.CON_EQ_PORT,b.CON_EX_AREA,CON_MEGA_PKG,CON_PHN_PURCH,c.CON_WORO_TASK_NAME
            from CON_CLARITY_SOLIST a, CONTRACTOR_EQ_DATA b,CONTRACTOR_WORK_ORDERS c
            where a.SETI= b.CON_EQ_WORO_ID
            and A.SETI=c.CON_WORO_SEIT
            and b.CON_EQ_WORO_ID=c.CON_WORO_SEIT
            and a.VOICENUMBER = :VOICENUMBER
            and a.EX_NO = :EX_NO
            and a.S_TYPE like '%IPTV%'";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['VOICENUMBER' => $a ,'EX_NO' => $b]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function ftth_data($sod)
    {
        $sql = "select distinct * from CONTRACTOR_FTTH_DATA where CON_FTTH_SERO_ID = :CON_FTTH_SERO_ID";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['CON_FTTH_SERO_ID' => $sod]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getBearerMap($sod)
    {
        $sql = "select distinct * from SOD_BEARER_MAP where BEARER_SOD = :BEARER_SOD order by SOD";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['BEARER_SOD' => $sod]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getNewSod2($a,$b)
    {
        $sql ="select  c.CON_WORO_AREA,C.CON_SERO_ID,c.CON_PSTN_NUMBER,c.CON_WORO_SERVICE_TYPE,C.CON_WORO_ORDER_TYPE,to_char(c.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM'),
        C.CON_CUS_NAME,C.CON_TEC_CONTACT,d.CON_ADDE_STREETNUMBER||' '||d.CON_ADDE_STRN_NAMEANDTYPE||' '||d.CON_ADDE_SUBURB||' '||d.CON_ADDE_CITY,
        e.CON_EQ_LOC_NAME,e.CON_EQ_CARD||' '||e.CON_EQ_PORT,e.CON_MEGA_PKG,e.CON_PHN_PURCH,c.CON_WORO_TASK_NAME,c.CON_WORO_SEIT,
        A.IPTV,e.CON_SALES,EX_NO,c.CON_WORO_DISCRIPTION,to_char(c.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM'), e.CON_EX_AREA
        from CON_CLARITY_SOLIST A,CONTRACTOR_WORK_ORDERS c,CONTRACTOR_SERVICE_ADDRESS d,CONTRACTOR_EQ_DATA e
        where A.SETI=c.CON_WORO_SEIT
        and A.SO_NUM = C.CON_SERO_ID
        and A.SETI=d.CON_ADDE_WORO_ID
        and A.SETI=e.CON_EQ_WORO_ID
        and d.CON_ADDE_WORO_ID=c.CON_WORO_SEIT
        and d.CON_ADDE_WORO_ID=e.CON_EQ_WORO_ID
        and c.CON_WORO_SEIT=e.CON_EQ_WORO_ID
        and A.SO_NUM = :SO_NUM
        and A.SETI= :SETI
        and C.CON_STATUS IN ('ASSIGNED', 'INPROGRESS')";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_NUM' => $a,'SETI' => $b,]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }

    }

    function getNewSod2Wo($a,$b)
    {
        $sql ="select  c.CON_WORO_AREA,C.CON_SERO_ID,c.CON_PSTN_NUMBER,c.CON_WORO_SERVICE_TYPE,C.CON_WORO_ORDER_TYPE,to_char(c.CON_DATE_TO_CONTRACTOR, 'mm/dd/yyyy hh:mi:ss AM'),
        C.CON_CUS_NAME,C.CON_TEC_CONTACT,d.CON_ADDE_STREETNUMBER||' '||d.CON_ADDE_STRN_NAMEANDTYPE||' '||d.CON_ADDE_SUBURB||' '||d.CON_ADDE_CITY,
        e.CON_EQ_LOC_NAME,e.CON_EQ_CARD||' '||e.CON_EQ_PORT,e.CON_MEGA_PKG,e.CON_PHN_PURCH,c.CON_WORO_TASK_NAME,c.CON_WORO_SEIT,
        0,e.CON_SALES,0,c.CON_WORO_DISCRIPTION,to_char(c.CON_STATUS_DATE, 'mm/dd/yyyy hh:mi:ss AM'), e.CON_EX_AREA
        from CONTRACTOR_WORK_ORDERS c,CONTRACTOR_SERVICE_ADDRESS d,CONTRACTOR_EQ_DATA e
        where c.CON_WORO_SEIT=d.CON_ADDE_WORO_ID
        and c.CON_WORO_SEIT=e.CON_EQ_WORO_ID
        and d.CON_ADDE_WORO_ID=e.CON_EQ_WORO_ID 
        and C.CON_SERO_ID = :SO_NUM
        and c.CON_WORO_SEIT= :SETI
        and C.CON_STATUS IN ('ASSIGNED', 'INPROGRESS')";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_NUM' => $a,'SETI' => $b,]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getMobTeamList($con,$area)
    {
        if($area == 'ALL'){
            $sql = "select aa.CON_USER,aa.CON_USER_CONTACT,bb.CON_TEAM,aa.CON_CONTRACTOR
        from TECHS_CON_USER aa,TECHS_CON_TEAMS bb
        where aa.CON_CONTRACTOR = bb.CON_NAME(+)
        and aa.CON_TEAM_ID =bb.CON_TEAM_ID(+)
        and aa.CON_CONTRACTOR= :CON_CONTRACTOR";

        }else{
            $sql = "select aa.CON_USER,aa.CON_USER_CONTACT,bb.CON_TEAM,aa.CON_CONTRACTOR
        from TECHS_CON_USER aa,TECHS_CON_TEAMS bb,APP_LOGIN cc
        where aa.CON_CONTRACTOR = bb.CON_NAME(+)
        and aa.CON_TEAM_ID =bb.CON_TEAM_ID(+)
        and bb.CON_TEAM = cc.USERNAME  
        and aa.CON_CONTRACTOR= :CON_CONTRACTOR
        and cc.RT_AREA IN ($area)";

        }

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['CON_CONTRACTOR' => $con]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getFtthDW($sod)
    {
        $sql = "select * from CONTRACTOR_FTTH_MET where SOID = :SOID and  UNIT_DESIG=:UNIT_DESIG";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOID' => $sod,'UNIT_DESIG'=> 'FTTH-DW']);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getPoleCount($sod)
    {
        $sql = "select distinct POLE_COUNT from CONTRACTOR_NEW_CON where CON_SO_ID = :SOID ";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOID' => $sod]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getPoles($con)
    {
        $sql = "select UNIT_DESIG from CONTRACTOR_UD where UNIT_DESIG like 'PL%' and NEW= :NEW";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['NEW' => 'Y']);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getPolemet($sod)
    {
        $sql = "select * from CONTRACTOR_FTTH_MET where SOID = :SOID and  UNIT_DESIG like 'PL%'";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOID' => $sod]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getOtherMet($sod)
    {
        $sql = "select * from CONTRACTOR_FTTH_MET where SOID = :SOID and  UNIT_DESIG not like 'PL%' and UNIT_DESIG <> 'FTTH-DW'";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOID' => $sod]);
        $result = $stmt->fetchall();
        if($result){
            return $result;
        }
    }

    function getRetReason($sod,$val)
    {
        if($val == 'const'){
            $sql = "select bb.RETURNED_REASON,bb.RETURNED_COMMENT,aa.ATTNAME, aa.ATTVALUE
                from TECHS_ATTRIBUTES aa, TECHS_RET_REASONS bb
                where aa.SOID(+) =bb.SOID
                and bb.SOID = :SOID
                and bb.TASK_NAME= 'RETURNOSP'";
        }
        if($val == 'reconst'){
            $sql = "select bb.RETURNED_REASON,bb.RETURNED_COMMENT,aa.ATTNAME, aa.ATTVALUE
                from TECHS_ATTRIBUTES aa, TECHS_RET_REASONS bb
                where aa.SOID(+) =bb.SOID
                and bb.SOID = :SOID
                and bb.TASK_NAME= 'RETURNSECONDOSP'";

        }


        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOID' => $sod]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }
//--- Prabodha Chathuranga 17/05/2023
    function getretRea()
    {
        $sql = "select distinct reason from SERIAL_NO_RETREASON_LIST where status is null";

        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchall();
        if($result){
            return $result;
        }
    }
//--- Prabodha Chathuranga 17/05/2023


    function getPatReason($sod)
    {
        $sql = "select * from TECHS_PAT_COMMENT aa where aa.SOID = :SOID";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOID' => $sod]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }


    function getOthers($sod,$con)
    {
        if($con == 'SLT CON'){
            $sql = "select UNIT_DESIG from CONTRACTOR_UD where STYPE = 'FTTH' and  NEW= :NEW and STYPE = :STYPE and UNIT_DESIG not like 'PL-%'";
            $stmt = $this->con->prepare($sql);
            $stmt->execute(['NEW' => 'Y','STYPE' => 'SLT']);
        }else{
            $sql = "select UNIT_DESIG from CONTRACTOR_UD where STYPE = 'FTTH' and  NEW= :NEW and UNIT_DESIG not like 'PL-%'";
            $stmt = $this->con->prepare($sql);
            $stmt->execute(['NEW' => 'Y']);
        }


        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getTeam($area)
    {
        if($area == 'ALL'){
            $sql = "select aa.CON_TEAM,aa.CON_TEAM_ID,bb.RT_AREA
            from TECHS_CON_TEAMS aa, APP_LOGIN bb
            where aa.CON_TEAM = bb.USERNAME";
        }else{
            $sql = "select aa.CON_TEAM,aa.CON_TEAM_ID,bb.RT_AREA
            from TECHS_CON_TEAMS aa, APP_LOGIN bb
            where aa.CON_TEAM = bb.USERNAME
            and bb.RT_AREA IN ($area)";
        }

        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getUser($uname, $con)
    {
        $sql = "select distinct CON_MGT_MOBILE,CON_MGT_UNAME from TECHS_MGT_LOGIN where CON_MGT_UNAME = :CON_MGT_UNAME and CON_MGT_CATOGARY = :CON_MGT_CATOGARY";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['CON_MGT_UNAME' => $uname,'CON_MGT_CATOGARY' => $con]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    public function update_passwd($hash , $mobile)
    {
        $sql ="update TECHS_MGT_LOGIN set CON_MGT_PW_HASH = :CON_MGT_PW_HASH ,CON_MGT_PW_ASSIGN_DATE= sysdate
                            where CON_MGT_MOBILE = :CON_MGT_MOBILE";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['CON_MGT_PW_HASH' => $hash, 'CON_MGT_MOBILE' => $mobile]);
    }

    public function logPasswd($uname , $mobile,$passwd)
    {
        $sql ="INSERT INTO CONTRACTOR_LOG (CON_USER,LOG_DATE,MSG )
        VALUES (:Uname,sysdate,'User Name , Password Sent to : $mobile -  $passwd' )";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['Uname' => $uname]);
    }













    public function conlist()
    {
        $sql = "select distinct CON_MGT_CONTRACTOR from CONTRACTOR_MGT_USERS where  CON_MGT_CONTRACTOR <> 'SLT'order by CON_MGT_CONTRACTOR";
        $result= oci_parse($this->con, $sql);
        if(oci_execute($result))
        {
            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function con_user_name($cont)
    {
        $sql = "select CON_MGT_USER_NAME from CONTRACTOR_MGT_USERS where CON_MGT_CONTRACTOR = :CON_MGT_CONTRACTOR order by CON_MGT_USER_NAME";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_MGT_CONTRACTOR", $cont);
        if(oci_execute($result))
        {
            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getPhn($cont,$user)
    {
        $sql = "select CON_MGT_MOBILE from CONTRACTOR_MGT_USERS where CON_MGT_USER_NAME= :CON_MGT_USER_NAME and 
            CON_MGT_CONTRACTOR = :CON_MGT_CONTRACTOR";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_MGT_CONTRACTOR", $cont);
        oci_bind_by_name($result, ":CON_MGT_USER_NAME", $user);
        if(oci_execute($result))
        {
            $row=oci_fetch_array($result);
            return $row[0];
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getMegaline($area)
    {
        $sql = "select count(distinct SO_NUM  )
                from CON_CLARITY_SOLIST
                where RTOM = :CON_AREA
                and S_TYPE= 'AB-CAB'
                and CONTRATOR is not null
                and STATUS IN ('0','1')";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {
            $row=oci_fetch_array($result);
            return $row[0];
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getSmartline($area)
    {
        $sql = "select count(distinct CON_SERO_ID  )
                from CONTRACTOR_WORK_ORDERS
                where CON_WORO_SERVICE_TYPE = 'AB-FTTH'
                and CON_WORO_AREA= :CON_AREA
                and CON_STATUS IN ('ASSIGNED','INPROGRESS')";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {
            $row=oci_fetch_array($result);
            return $row[0];
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getPeotv($area)
    {
        $sql = "select count(aa) from (
                select distinct SO_NUM aa
                from CON_CLARITY_SOLIST
                where RTOM = :CON_AREA
                and S_TYPE= 'E-IPTV COPPER'
                and CONTRATOR is not null
                and STATUS IN ('0','1')
                union all
                select distinct CON_SERO_ID  aa
                from CONTRACTOR_WORK_ORDERS
                where CON_WORO_SERVICE_TYPE = 'E-IPTV FTTH'
                and CON_WORO_AREA= :CON_AREA
                and CON_STATUS IN ('ASSIGNED','INPROGRESS'))";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {
            $row=oci_fetch_array($result);
            return $row[0];
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }


    public function getMegalineCom($area)
    {
        $sql = "select count(distinct CON_SERO_ID  )
                from CONTRACTOR_WORK_ORDERS
                where CON_WORO_SERVICE_TYPE = 'AB-CAB'
                and CON_WORO_AREA= :CON_AREA
                and CON_STATUS = 'COMPLETED'
              --  and CON_WORO_TASK_NAME like 'INST%'
                and CON_STATUS_DATE  >= trunc(sysdate)
                And CON_STATUS_DATE < trunc(sysdate) + 1";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {
            $row=oci_fetch_array($result);
            return $row[0];
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getSmartlineCom($area)
    {
        $sql = "select count(distinct CON_SERO_ID  )
                from CONTRACTOR_WORK_ORDERS
                where CON_WORO_SERVICE_TYPE = 'AB-FTTH'
                and CON_WORO_AREA= :CON_AREA
                and CON_STATUS = 'COMPLETED'
              --  and CON_WORO_TASK_NAME like 'INST%'
                and CON_STATUS_DATE  >= trunc(sysdate)
                And CON_STATUS_DATE < trunc(sysdate) + 1";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {
            $row=oci_fetch_array($result);
            return $row[0];
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getPeotvCom($area)
    {
        $sql = "select count(aa) from (
                select distinct CON_SERO_ID  aa
                from CONTRACTOR_WORK_ORDERS
                where CON_WORO_SERVICE_TYPE = 'E-IPTV COPPER'
                and CON_WORO_AREA= :CON_AREA
                and CON_STATUS = 'COMPLETED'
                and CON_STATUS_DATE  >= trunc(sysdate)
                And CON_STATUS_DATE < trunc(sysdate) + 1
                union all
                select distinct CON_SERO_ID  aa
                from CONTRACTOR_WORK_ORDERS
                where CON_WORO_SERVICE_TYPE = 'E-IPTV FTTH'
                and CON_WORO_AREA= :CON_AREA
                and CON_STATUS = 'COMPLETED'
                and CON_STATUS_DATE  >= trunc(sysdate)
                And CON_STATUS_DATE < trunc(sysdate) + 1)";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {
            $row=oci_fetch_array($result);
            return $row[0];
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getMegalineRet($area)
    {
        $sql = "select count(distinct CON_SERO_ID  )
                from CONTRACTOR_WORK_ORDERS
                where CON_WORO_SERVICE_TYPE = 'AB-CAB'
                and CON_WORO_AREA= :CON_AREA
                and CON_STATUS IN ('RETURNED', 'RE_RETURNED')
                and CON_STATUS_DATE  >= trunc(sysdate)
                And CON_STATUS_DATE < trunc(sysdate) + 1";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {
            $row=oci_fetch_array($result);
            return $row[0];
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getSmartlineRet($area)
    {
        $sql = "select count(distinct CON_SERO_ID  )
                from CONTRACTOR_WORK_ORDERS
                where CON_WORO_SERVICE_TYPE = 'AB-FTTH'
                and CON_WORO_AREA= :CON_AREA
                and CON_STATUS IN ('RETURNED', 'RE_RETURNED')
                and CON_STATUS_DATE  >= trunc(sysdate)
                And CON_STATUS_DATE < trunc(sysdate) + 1";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {
            $row=oci_fetch_array($result);
            return $row[0];
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getPeotvRet($area)
    {
        $sql = "select count(aa) from (
                select distinct CON_SERO_ID  aa
                from CONTRACTOR_WORK_ORDERS
                where CON_WORO_SERVICE_TYPE = 'E-IPTV COPPER'
                and CON_WORO_AREA= :CON_AREA
                and CON_STATUS IN ('RETURNED', 'RE_RETURNED')
                and CON_STATUS_DATE  >= trunc(sysdate)
                And CON_STATUS_DATE < trunc(sysdate) + 1
                union all
                select distinct CON_SERO_ID  aa
                from CONTRACTOR_WORK_ORDERS
                where CON_WORO_SERVICE_TYPE = 'E-IPTV FTTH'
                and CON_WORO_AREA= :CON_AREA
                and CON_STATUS IN ('RETURNED', 'RE_RETURNED')
                and CON_STATUS_DATE  >= trunc(sysdate)
                And CON_STATUS_DATE < trunc(sysdate) + 1)";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {
            $row=oci_fetch_array($result);
            return $row[0];
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getContCount($area)
    {
        $sql = "SELECT * FROM(
                select  CON_NAME,CON_STATUS, count(  CON_SERO_ID) CON_SERO_ID
                from (select distinct CON_SERO_ID, CON_NAME,CON_STATUS from CONTRACTOR_WORK_ORDERS
                where CON_STATUS = 'COMPLETED'
                and CON_WORO_AREA= :CON_AREA
                and CON_NAME is not null
                and CON_STATUS_DATE  >= trunc(sysdate)
                and CON_STATUS_DATE < trunc(sysdate) + 1)
                group by CON_NAME,CON_STATUS
                union all
                select  CON_NAME,CON_STATUS, count(  CON_SERO_ID) CON_SERO_ID
                from (select distinct CON_SERO_ID, CON_NAME,CON_STATUS from CONTRACTOR_WORK_ORDERS
                where CON_STATUS = 'RETURNED'
                and CON_WORO_AREA= :CON_AREA
                and CON_NAME is not null
                and CON_STATUS_DATE  >= trunc(sysdate)
                and CON_STATUS_DATE < trunc(sysdate) + 1)
                group by CON_NAME,CON_STATUS
                union all
                select  CON_NAME,'PENDING', count(  CON_SERO_ID) CON_SERO_ID
                from (select  distinct SO_NUM CON_SERO_ID, CONTRATOR CON_NAME,'PENDING' CON_STATUS
                from CON_CLARITY_SOLIST
                where RTOM = :CON_AREA
                and S_TYPE= 'AB-CAB'
                and CONTRATOR is not null
                and STATUS IN ('0','1')
                union all 
                select distinct CON_SERO_ID, CON_NAME,'PENDING' CON_STATUS
                from CONTRACTOR_WORK_ORDERS
                where CON_WORO_SERVICE_TYPE = 'AB-FTTH'
                and CON_WORO_AREA= :CON_AREA
                and CON_STATUS IN ('ASSIGNED','INPROGRESS')
                union all
                select distinct SO_NUM CON_SERO_ID, CONTRATOR CON_NAME,'PENDING' CON_STATUS
                from CON_CLARITY_SOLIST
                where RTOM = :CON_AREA
                and S_TYPE= 'E-IPTV COPPER'
                and STATUS IN ('0','1')
                and CONTRATOR is not null
                union all
                select distinct CON_SERO_ID, CON_NAME,'PENDING' CON_STATUS
                from CONTRACTOR_WORK_ORDERS
                where CON_WORO_SERVICE_TYPE = 'E-IPTV FTTH'
                and CON_WORO_AREA= :CON_AREA
                and CON_STATUS IN ('ASSIGNED','INPROGRESS'))
                group by CON_NAME,CON_STATUS
                )
                PIVOT
                (
                  SUM(CON_SERO_ID)
                  FOR CON_STATUS IN ('PENDING','COMPLETED','RETURNED')
                )order by CON_NAME";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {
            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }



    public function getDataCom($area)
    {
        $sql = "SELECT * FROM(
                select CON_WORO_SERVICE_TYPE, count( CON_SERO_ID) CON_SERO_ID
                from year_com
                where CON_WORO_AREA = :CON_AREA
                and CON_WORO_SERVICE_TYPE IN ('AB-CAB','AB-FTTH')
                group by CON_WORO_SERVICE_TYPE
                union all
                select CON_WORO_SERVICE_TYPE ,count(CON_SERO_ID)
                from (
                select 'IPTV' CON_WORO_SERVICE_TYPE, CON_SERO_ID
                from year_com
                where CON_WORO_AREA = :CON_AREA
                and CON_WORO_SERVICE_TYPE IN ('E-IPTV COPPER','E-IPTV FTTH'))
                group by CON_WORO_SERVICE_TYPE
                )
                PIVOT
                (
                SUM(CON_SERO_ID)
                FOR CON_WORO_SERVICE_TYPE IN ('AB-FTTH','AB-CAB','IPTV')
                )";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {
            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getDataRet($area)
    {
        $sql = "SELECT * FROM(
                select CON_WORO_SERVICE_TYPE, count( CON_SERO_ID) CON_SERO_ID
                from year_ret
                where CON_WORO_AREA = :CON_AREA
                and CON_WORO_SERVICE_TYPE IN ('AB-CAB','AB-FTTH')
                group by CON_WORO_SERVICE_TYPE
                union all
                select CON_WORO_SERVICE_TYPE ,count(CON_SERO_ID)
                from (
                select 'IPTV' CON_WORO_SERVICE_TYPE, CON_SERO_ID
                from year_ret
                where CON_WORO_AREA =:CON_AREA
                and CON_WORO_SERVICE_TYPE IN ('E-IPTV COPPER','E-IPTV FTTH'))
                group by CON_WORO_SERVICE_TYPE
                )
                PIVOT
                (
                SUM(CON_SERO_ID)
                FOR CON_WORO_SERVICE_TYPE IN ('AB-FTTH','AB-CAB','IPTV')
                )";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {

            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }


    public function getConCom($area)
    {
        $sql = "select CON_NAME, count(CON_SERO_ID) 
                from year_com
                where CON_WORO_AREA = :CON_AREA
                group by CON_NAME
                order by CON_NAME";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {

            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getConRet($area)
    {
        $sql = "select CON_NAME, count(CON_SERO_ID) 
                from year_ret
                where CON_WORO_AREA = :CON_AREA
                group by CON_NAME
                order by CON_NAME";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {

            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getConComSer($area)
    {
        $sql = "select CON_WORO_SERVICE_TYPE, count(CON_SERO_ID) 
                from year_com
                where CON_WORO_AREA = :CON_AREA
                group by CON_WORO_SERVICE_TYPE
                order by CON_WORO_SERVICE_TYPE";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {

            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getConRetSer($area)
    {
        $sql = "select CON_WORO_SERVICE_TYPE, count(CON_SERO_ID) 
                from year_ret
                where CON_WORO_AREA = :CON_AREA
                group by CON_WORO_SERVICE_TYPE
                order by CON_WORO_SERVICE_TYPE";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {

            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }


    public function getConM($area)
    {
        $sql = "select CON_DATE, count (CON_SERO_ID)
                from YEAR_COM
                where CON_WORO_AREA = :CON_AREA
                and CON_WORO_SERVICE_TYPE = 'AB-CAB'
                group by CON_DATE
                order by CON_DATE";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {

            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getConS($area)
    {
        $sql = "select CON_DATE, count (CON_SERO_ID)
                from YEAR_COM
                where CON_WORO_AREA = :CON_AREA
                and CON_WORO_SERVICE_TYPE = 'AB-FTTH'
                group by CON_DATE
                order by CON_DATE";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {

            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    public function getConP($area)
    {
        $sql = "select CON_DATE, count (CON_SERO_ID)
                from YEAR_COM
                where CON_WORO_AREA = :CON_AREA
                and CON_WORO_SERVICE_TYPE like '%IPTV%'
                group by CON_DATE
                order by CON_DATE";
        $result= oci_parse($this->con, $sql);
        oci_bind_by_name($result, ":CON_AREA", $area);

        if(oci_execute($result))
        {

            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    function getrejImgcount($sod)
    {
        $sql = "select count(*) from SERIAL_NO_IMAGES where SOID = :SOID and STATUS=:STATUS and IMAGE_STAGE= :IMAGE_STAGE";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOID' => $sod,'STATUS'=> '5','IMAGE_STAGE' =>'1']);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function loadImg2($a,$b,$c)
    {
        $sql ="SELECT A.IMAGE_NAME,A.IMAGE_COMMENT,A.IMAGE_DISNAME,A.STATUS FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID = :IMG_T_ID AND IMAGE_STAGE=:IMG_STG ORDER BY IMAGE_NAME";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a,'IMG_T_ID' => $b,'IMG_STG' => $c]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function loadImgSt2($a,$c)
    {
        $sql ="SELECT A.IMAGE_NAME,A.IMAGEID,A.IMAGE_DISNAME,A.STATUS FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND  IMAGE_STAGE=:IMG_STG";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a,'IMG_STG' => $c]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getPatWkDImg()
    {
        $sql = "SELECT * FROM SERIAL_NO_PICLIST WHERE IMG_TAB = 'Work_Done' ORDER BY ID ASC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    function getPatCusFRImg()
    {
        $sql = "SELECT * FROM SERIAL_NO_PICLIST WHERE IMG_TAB = 'Customer_Feedback_Requests' ORDER BY ID ASC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    function getPatAcsImg()
    {
        $sql = "SELECT * FROM SERIAL_NO_PICLIST WHERE IMG_TAB = 'Accessories' ORDER BY ID ASC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    function getPatSpanImg()
    {
        $sql = "SELECT * FROM SERIAL_NO_PICLIST WHERE IMG_TAB = 'Spans' ORDER BY ID ASC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    function getAllImg()
    {
        $sql = "SELECT * FROM SERIAL_NO_PICLIST ORDER BY ID ASC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
        else
        {
            $err = oci_error($result);
            $e =  $err['message'];
            echo "<script type='text/javascript'>alert('$e')</script>";
        }
    }

    function loadImg($a,$b,$c)
    {
        $sql ="SELECT A.IMAGE_NAME,A.IMAGE_COMMENT,A.IMAGE_DISNAME,A.STATUS FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID = :IMG_T_ID AND IMAGE_STAGE=:IMG_STG";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a,'IMG_T_ID' => $b,'IMG_STG' => $c]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getPatAllImgCount($a,$b)
    {
        $sql = "SELECT COUNT(A.IMAGEID) AS IMG_CNT FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID IN (SELECT ID FROM SERIAL_NO_PICLIST) AND IMAGE_STAGE=:IMG_STG";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a,'IMG_STG' => $b]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getPatWkDImgCount($a,$b)
    {
        $sql = "SELECT COUNT(A.IMAGEID) AS IMG_CNT FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID IN (SELECT ID FROM SERIAL_NO_PICLIST WHERE IMG_TAB = 'Work_Done') AND IMAGE_STAGE=:IMG_STG";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a,'IMG_STG' => $b]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getPatCusFRImgCount($a,$b)
    {
        $sql = "SELECT COUNT(A.IMAGEID) AS IMG_CNT FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID IN (SELECT ID FROM SERIAL_NO_PICLIST WHERE IMG_TAB = 'Customer_Feedback_Requests') AND IMAGE_STAGE=:IMG_STG";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a,'IMG_STG' => $b]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getPatAcsImgCount($a,$b)
    {
        $sql = "SELECT COUNT(A.IMAGEID) AS IMG_CNT FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID IN (SELECT ID FROM SERIAL_NO_PICLIST WHERE IMG_TAB = 'Accessories') AND IMAGE_STAGE=:IMG_STG";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a,'IMG_STG' => $b]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getPatSpanImgCount($a,$b)
    {
        $sql = "SELECT COUNT(A.IMAGEID) AS IMG_CNT FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID IN (SELECT ID FROM SERIAL_NO_PICLIST WHERE IMG_TAB = 'Spans') AND IMAGE_STAGE=:IMG_STG";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a,'IMG_STG' => $b]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getwkdStgCount($a)
    {
        $sql = "SELECT MAX(A.IMAGE_STAGE) AS IMG_STG FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID IN (SELECT ID FROM SERIAL_NO_PICLIST WHERE IMG_TAB = 'Work_Done')";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getcfrStgCount($a)
    {
        $sql = "SELECT MAX(A.IMAGE_STAGE) AS IMG_STG FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID IN (SELECT ID FROM SERIAL_NO_PICLIST WHERE IMG_TAB = 'Customer_Feedback_Requests')";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getAcsStgCount($a)
    {
        $sql = "SELECT MAX(A.IMAGE_STAGE) AS IMG_STG FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID IN (SELECT ID FROM SERIAL_NO_PICLIST WHERE IMG_TAB = 'Accessories')";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getSpanStgCount($a)
    {
        $sql = "SELECT MAX(A.IMAGE_STAGE) AS IMG_STG FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID IN (SELECT ID FROM SERIAL_NO_PICLIST WHERE IMG_TAB = 'Spans')";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function loadPolPathImg($a)
    {
        $sql ="SELECT A.IMAGE_NAME,A.IMAGE_COMMENT,A.IMAGE_DISNAME,A.STATUS FROM SERIAL_NO_IMAGES A WHERE A.SOID = :SO_ID AND A.IMAGEID = '26'";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getPatGenCmt($a)
    {
        $sql = "SELECT COUNT(*) AS REC_C FROM PAT_COMMENT WHERE SO_ID = :SO_ID";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

    function getSodImgupSt($a,$b)
    {
        $sql ="select FTTH_WIFI from CONTRACTOR_NEW_CON where CON_SO_ID  = :SO_ID AND CON_SO_STATUS=:CON_SO_ST";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a,'CON_SO_ST' => $b]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }
	
	
	
    function getOflinSn($sod)
    {
        $sql = "SELECT * FROM CONTRACTOR_OSP_DATA WHERE CON_OSP_SERO_ID = :SOID AND CON_OSP_PHONE_CLASS = 'SLT'";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOID' => $sod]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getOfliniptv($sod)
    {
        $sql = "SELECT * FROM SOD_BEARER_MAP WHERE BEARER_SOD = :SOID AND SER_TYPE = 'E-IPTV FTTH' AND ( STAT <> 'CANCELLED' OR STAT IS NULL)";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOID' => $sod]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }
	
	
    function getTechAtt($sod)
    {
        $sql = "select * from TECHS_ATTRIBUTES where SOID = :SOID";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SOID' => $sod]);
        $result = $stmt->fetchAll();
        if($result){
            return $result;
        }
    }

    function getOflnImgUpcnt($a)
    {
        $sql ="SELECT COUNT(*) AS REC FROM SERIAL_NO_IMAGES WHERE SOID = :SO_ID AND IMAGE_NAME IS NOT NULL";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['SO_ID' => $a]);
        $result = $stmt->fetch();
        if($result){
            return $result;
        }
    }

}
