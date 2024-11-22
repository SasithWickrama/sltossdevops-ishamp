<?php

session_start();
include "db/DbOperations.php";
$db = new DbOperations;

if ($_POST['token'] == $_SESSION['token'])
{
    $user_name = $_POST["username"];
    $pass = $_POST["password"];
    $contype = $_POST["usertype"];
    $hash = md5($pass);

    $area='';

    if($contype == 'SLT'){
        $auth = $db->validate_user($user_name,$contype);

        //$row=oci_fetch_array($auth);

        if($auth[0]['CON_MGT_UNAME']==$user_name)
        {
            $uname = $user_name."@intranet.slt.com.lk";

            $link = ldap_connect( 'intranet.slt.com.lk' );
            if( ! $link )
            {
                echo"Cant Connect to Server";
            }
            ldap_set_option( $link, LDAP_OPT_PROTOCOL_VERSION, 3 );
            ldap_set_option($link, LDAP_OPT_REFERRALS, 0);
            if (  ldap_bind( $link, $uname, $pass ) )
            {
                $_SESSION['loggedin'] = true;
                $_SESSION["uid"] = $user_name;
                $_SESSION["ucatagory"] = $contype; //Contractor name or SLT

                foreach( $auth as $row ) {
                    $_SESSION["umobile"] = $row[2];
                    $_SESSION["uname"] = $row[3];
                    $_SESSION["utype"] = $row[4];
                    $_SESSION["urole"] = $row[5];

                    $area = $area.','.$row[6];

                }

                $areasArr = array();
                $areaArr = explode('|',$area);
                for($i=0; $i<sizeof($areaArr); $i++){
                    $areasArr[$i]= "'".$areaArr[$i]."'";
                }

                //$_SESSION["uarea"] = implode(",",$areasArr);
                $_SESSION["uarea"] = $area;

                //Retrieve AD Details
                $ldap_base_dn = 'DC=intranet,DC=slt,DC=com,DC=lk';
                $filter = '(sAMAccountName='.$user_name.')';
                $attributes = array("name", "physicaldeliveryofficename", "mail", "samaccountname","thumbnailphoto","displayname","title");
                $result = ldap_search($link, $ldap_base_dn, $filter, $attributes);

                if (FALSE !== $result){

                    $entries = ldap_get_entries($link, $result);
                    for ($x=0; $x<$entries['count']; $x++){

                        //img
                        $ldap_img = "";
                        $ldap_name="";
                        $ldap_mail="";
                        $ldap_ofc="";
                        $ldap_ou="";

                        if (!empty($entries[$x]['thumbnailphoto'][0])) {
                            $ldap_img = $entries[$x]["thumbnailphoto"][0];

                        }

                        if (!empty($entries[$x]['mail'][0])) {
                            $ldap_mail = $entries[$x]["mail"][0];

                        }
                        if (!empty($entries[$x]['displayname'][0])) {
                            $ldap_name = $entries[$x]["displayname"][0];

                        }
                        if (!empty($entries[$x]['physicaldeliveryofficename'][0])) {
                            $ldap_ofc = $entries[$x]["physicaldeliveryofficename"][0];

                        }
                        if (!empty($entries[$x]['title'][0])) {
                            $ldap_tit = $entries[$x]["title"][0];

                        }


                    }

                    $_SESSION['ldap_img']= $ldap_img;
                    $_SESSION['mail']= $ldap_mail;
                    $_SESSION['ldap_name']= $ldap_name;
                    $_SESSION['ldap_tit']= $ldap_tit;
                }


                $ldap_base_dn = 'DC=intranet,DC=slt,DC=com,DC=lk';
                $filter = '(sAMAccountName='.$user_name.')';
                $attributes = array("name", "telephonenumber", "mail", "samaccountname","thumbnailphoto","sn");
                $result = ldap_search($link, $ldap_base_dn, $filter, $attributes);

                if (FALSE !== $result){

                    $entries = ldap_get_entries($link, $result);
                    for ($x=0; $x<$entries['count']; $x++){

                        //img
                        $ldap_img = "";

                        if (!empty($entries[$x]['thumbnailphoto'][0])) {
                            $ldap_img = $entries[$x]["thumbnailphoto"][0];

                        }

                        $_SESSION['ldap_img']= $ldap_img;

                    }

                }
                echo '<script type="text/javascript"> document.location = "slt/sod_inbox";</script>';
            }
            else{
                echo "<script>alert('Invalid Credentials')</script>";
                echo '<script type="text/javascript"> document.location = "login";</script>';
            }

        }else{
            echo "<script type='text/javascript'>alert('Sorry, your not authorized for this site')</script>";
            echo '<script type="text/javascript"> document.location = "login";</script>';

        }
    }else{

        if($user_name == 'WEBADMIN' && $hash == 'a2cee7e92f5bf48541dc3151d1542285')
        {
            $_SESSION['loggedin'] = true;
            $_SESSION["uid"] = $user_name;
            $_SESSION["ucatagory"] = $contype; //Contractor name
            $_SESSION["umobile"] = '';
            $_SESSION["uname"] = 'Portal Admin';
            $_SESSION["utype"] = 'Admin';
            $_SESSION["urole"] = 'Admin';
            $_SESSION["uarea"] = 'ALL';

            echo '<script type="text/javascript"> document.location = "contr/solist";</script>';
        }
        else
        {
            $auth = $db->validate_user($user_name,$contype);

            if($auth[0]['CON_MGT_UNAME']==$user_name && $auth[0]['CON_MGT_PW_HASH']==$hash){
                $db->change_hash($user_name,$contype);

                $_SESSION['loggedin'] = true;
                $_SESSION["uid"] = $user_name;
                $_SESSION["ucatagory"] = $contype; //Contractor name

                foreach( $auth as $row ) {
                    $_SESSION["umobile"] = $row[2];
                    $_SESSION["uname"] = $row[3];
                    $_SESSION["utype"] = $row[4];
                    $_SESSION["urole"] = $row[5];

                    $area = $area.'|'.$row[6];
                }
                $areasArr = array();
                $areaArr = explode('|',$area);
                for($i=0; $i<sizeof($areaArr); $i++){
                    $areasArr[$i]= "'".$areaArr[$i]."'";
                }

                $_SESSION["uarea"] = implode(",",$areasArr);


                if($contype== 'SMH'){
                    echo '<script type="text/javascript"> document.location = "smarthome/index";</script>';
                }elseif($contype== 'AION'){
                    echo '<script type="text/javascript"> document.location = "fleetmgt/index";</script>';
                }else{
                    echo '<script type="text/javascript"> document.location = "contr/solist";</script>';
                }

            }
            else
            {
                echo "<script type='text/javascript'>alert('Sorry, your credentials are not valid, Please try again.')</script>";
                echo '<script type="text/javascript"> document.location = "login";</script>';
            }
        }
    }




}

?>
