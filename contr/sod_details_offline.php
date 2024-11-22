<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){

    $i=0;

    include "../db/DbOperations.php";
    $db = new DbOperations;
    $areas = $_SESSION["uarea"];
    $usr = $_SESSION["uid"];
    $con = $_SESSION["ucatagory"];


    $dat = explode("_",$_GET['sod']);
    //$getConDetail = $db->getConDetail($dat[0],$dat[2],$dat[3]);
    //$getSnAssign = $db->getSnAssign($dat[0]);
    $getSn = $db->getSn($dat[0]);

    //--------------offline ------------//
    $getOflinSn = $db->getOflinSn($dat[0]);
    $getOfliniptv = $db->getOfliniptv($dat[0]);
    //--------------offline ------------//

    $getLog = $db->getLog($dat[0]);

    $b = $i1 = $i2 = $i3 = $v2= '0';
    $bb = $iptv1 = $iptv2 = $iptv3 = $voice2 = '';

    $sod = $dat[0];
    $seit = $dat[2];
    $_SESSION["so_id"] = $sod;
    $stat = $dat[1];

    if($stat == 'OSPCLOSED'){
        $stat = 'OSP_CLOSED';
    }
    if($stat == 'PROVCLOSED'){
        $stat = 'PROV_CLOSED';
    }
    if($stat == 'INSTALLCLOSED'){
        $stat = 'INSTALL_CLOSED';
    }
    if($stat == 'RETURNPENDING'){
        $stat = 'RETURN_PENDING';

    }
    if($stat == 'PATOPMC'){
        $stat = 'PAT_OPMC_REJECTED';

    }

    if($dat[3] == 'FTTH'){
        $stype= 'AB-FTTH';
    }
    if($dat[3] == 'PEO'){
        $stype= 'E-IPTV FTTH';
    }


    $i=1;
    $getSnAssign= $db->getSnAssign($sod);


    $sval = '000000';

    if($stype == 'AB-CAB' || $stype == 'AB-FTTH') {

        if ($stat == 'INSTALL_CLOSED' || $stat == 'COMPLETED' || $stat == 'PAT_OPMC_REJECTED'){
            $row = $db->getNewSodOsp($sod, $seit);
        }else{
            $row = $db->getNewSod($sod, $seit);
        }


        if($row[0] == ''){
            $row = $db->getNewSodWo($sod, $seit);

        }else{
            if ($row[15] > '0') {
                if($row[4] == 'CREATE-UPGRD SAME NO'){
                    $iptv1='';
                    $iptv2='';
                    $iptv3='';
                }else{
                    $iptvrowall = $db->getNewSodIptv($row[2], $row[17]);
                }
            }
        }

        if($stype == 'AB-FTTH'){
            $ftth_data= $db->ftth_data($sod);

            $getBearerMap = $db->getBearerMap($sod);
            $getFtthDW = $db->getFtthDW($sod);
            $getPoleCount = $db->getPoleCount($sod);
            $getPoles= $db->getPoles($sod);
            $getPolemet= $db->getPolemet($sod);
            $getOthers= $db->getOthers($sod,$con);
            $getOtherMet= $db->getOtherMet($sod);
            $getTechAtt= $db->getTechAtt($sod);

            if($stat == 'RETURN_PENDING'){
                $getRetReason = $db->getRetReason($sod);
            }
            if($stat == 'PAT_OPMC_REJECTED'){
                $getPatReason = $db->getPatReason($sod);
            }

        }

    }

    if($stype == 'E-IPTV COPPER' || $stype == 'E-IPTV FTTH') {
        $row = $db->getNewSod2($sod, $seit);

        if($row[0] == ''){
            $row = $db->getNewSod2Wo($sod, $seit);
        }
        $iptv1='';
        $iptv2='';
        $iptv3='';
    }

    $rtom= $row[0];
    $circuit= $row[2];
    $order = $row[4];

    $lea  =$row[20];

    if($stype == 'AB-FTTH'){
        if($row[11] == 'VOICE'){
            $pkg  ='Single Play';
        }
        if($row[11] == 'VOICE_IPTV'){
            $pkg  ='Double Play - PeoTV';
        }
        if($row[11] == 'VOICE_INT'){
            $pkg  ='Double Play-BB';
        }
        if($row[11] == 'VOICE_INT_IPTV'){
            $pkg  ='Triple Play';
        }

    }else{
        $pkg  =$row[11];
    }



}else{
    echo '<script type="text/javascript"> document.location = "../login";</script>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>i-Shamp - Service Order Details</title>
    <!--  BEGIN HEAD  -->
    <?php
    include "header.php"
    ?>
    <!--  END NAVBAR  -->
    <style>
        .container1 {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .container1 img {
            width: 300px;
            height: 300px;
        }

        .container1 .btn {
            position: absolute;
            top: 10%;
            left: 90%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            background: red;
            color: white;
            font-size: 12px;
            padding: 12px 24px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-align: center;
        }

    </style>

    <style>
        hr {
            display: block;
            margin-top: 0.2em;
            margin-bottom: 0.2em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 1px;
            background-color: #1ba87e;
        }

        a:hover{
            color: #236aef;
        }

        label {
            font-weight: bold;
        }

        <!-- ===== -->

        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 2; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 500px;
        }

        /* Add Animation */
        .modal-content, #caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {-webkit-transform:scale(0)}
            to {-webkit-transform:scale(1)}
        }

        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 500px){
            .modal-content {
                width: 80%;
            }
        }

        .mt-0 {
        padding: 5px; !important;
        }

    </style>
</head>
<body class="alt-menu sidebar-noneoverflow">
<!-- BEGIN LOADER -->
<div id="load_screen"> <div class="loader"> <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div></div></div>
<!--  END LOADER -->

<!--  BEGIN NAVBAR  -->
<?php
include "navbar.php"
?>
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN TOPBAR  -->

    <?php
    include "topbar.php"
    ?>
    <!--  END TOPBAR  -->

    <!--  BEGIN CONTENT PART  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <br/><div class="page-header">

                <?php 
                
                $getSodImgupSt = $db->getSodImgupSt($sod,$stat); 

                //------------chk offline -----------//
                $getOflnImgUpcnt = $db->getOflnImgUpcnt($sod); 
                
                ?>

                <div class="page-title">
                    <h4>CONNECTION DETAIL - <span style="color: blue; font-size: larger; font-weight: bold"><?php echo $circuit; ?></span><span style="color: #f39c12;font-weight:bold "><?php if($getSodImgupSt[0] != ''){ echo ' (OFFLINE)'; }?></span></h4>
                </div>
                <?php if($stat == 'INSTALL_CLOSED' || $stat == 'PAT_OPMC_REJECTED'){ ?>
                    <h6 style="color: red">Warning : There are Pending Images to Upload</h6>
                    <button class="btn btn-success mb-4" style="height: 40px;"  onclick="closeSod()">COMPLETED</button>

                <?php } ?>
                <?php if($stat == 'RETURN_PENDING'){ ?>
                    <button class="btn btn-success mb-4" style="height: 40px;"  onclick="closeReturn()">RETURN TO SLT</button>
                <?php } ?>
                 <!------------- offline ------------->
                <?php if($getSodImgupSt[0] == '' && $stat == 'INPROGRESS'){ ?>
                    <button class="btn btn-warning mb-4" style="height: 40px;"  onclick="checkOffline()"><i class="fa fa-ban"></i> OFFLINE</button>
                <?php } ?>
                <?php if($getSodImgupSt[0] == '3' && $stat == 'PROV_CLOSED'){ ?>
                    <button class="btn btn-success mb-4" style="height: 40px;"  onclick="CmptIntTask()"><i class="fa fa-check"></i> COMPLETE INSTALLATION TASK</button>
                <?php } ?>
                <!------------- offline ------------->

            </div><hr/>

                <!--  ==================  -->
                <div class="row layout-top-spacing">

                    <!--  ==================  -->
                    <div class="col-lg-12 col-12 layout-spacing" >
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area border-top-tab">
                                <ul class="nav nav-tabs mb-12 mt-3" id="borderTop" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="border-top-home-tab" data-toggle="tab" href="#sod_details" role="tab" aria-controls="border-top-home" aria-selected="true"><span style="font-weight: bold; font-size: 16px;">ORDER DETAILS</span> </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="border-top-profile-tab" data-toggle="tab" href="#sn" role="tab" aria-controls="border-top-profile" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">TEAM ASSIGN & SERIAL NUMBERS</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="border-top-contact-tab" data-toggle="tab" href="#met" role="tab" aria-controls="border-top-contact" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">METERIALS</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="border-top-contact-tab" data-toggle="tab" href="#images" role="tab" aria-controls="border-top-contact" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">IMAGES</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="border-top-contact-tab" data-toggle="tab" href="#log" role="tab" aria-controls="border-top-contact" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">LOGS</span></a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="borderTopContent">

                                    <!--- -->
                                    <div class="tab-pane fade show active" id="sod_details" role="tabpanel" aria-labelledby="border-top-home-tab">
                                        <div class="card">
                                            <div class="card-header ">
                                                <a href="#" style="font-weight: bold; font-size:large">SERVICE ORDER DETAILS</a>
                                            </div>
                                            <!--    ==============================   -->

                                            <div class="card-body">

                                                <div class="row" style="font-size: 15px; font-weight: bold">
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">RTOM</label><br/>
                                                        <label id="rtom"><?php echo $row[0]; ?></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">SERVICE ORDER</label><br/>
                                                        <label><?php echo $row[1]; ?></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">CIRCUIT</label><br/>
                                                        <label id="circuit"><?php echo $row[2]; ?></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">SERVICE</label><br/>
                                                        <label><?php echo $row[3]; ?></label>
                                                    </div>
                                                </div>
                                                <hr/>

                                                <div class="row" style="font-size: 15px; font-weight: bold;">
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">RECEIVED DATE</label><br/>
                                                        <label><?php echo $row[5]; ?></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">CUSTOMER NAME</label><br/>
                                                        <label><?php echo $row[6]; ?></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">CONTACT NO</label><br/>
                                                        <label><?php echo $row[7]; ?></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">ADDRESS</label><br/>
                                                        <label><?php echo $row[8]; ?></label>
                                                    </div>

                                                </div>
                                                <hr/>

                                                <div class="row" style="font-size: 15px; font-weight: bold">
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">STATUS</label><br/>
                                                        <label><?php echo $stat; ?></label>
                                                        <!--                                                        <select style="border-radius:5px;width:250px;height:35px;  color:#1C96B1; font-weight: bold"  onchange="STUPDATE()" class="txtbg" id="ch_status">-->
                                                        <!--                                                            --><?php //if($stat == 'OSP_CLOSED' ) {?>
                                                        <!--                                                                <option value="OSP_CLOSED" selected>OSP_CLOSED</option>-->
                                                        <!--                                                            --><?php //}else if($stat == 'INSTALL_CLOSED' ){ ?>
                                                        <!--                                                                <option value="COMPLETED" selected>COMPLETED</option>-->
                                                        <!--                                                            --><?php //}else{ ?>
                                                        <!--                                                                <option value="INPROGRESS" selected>INPROGRESS</option>-->
                                                        <!--                                                            --><?php //}?>
                                                        <!---->
                                                        <!--                                                        </select>-->
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">STATUS DATE</label><br/>
                                                        <label><?php echo $row[19]; ?></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">ORDER TYPE</label><br/>
                                                        <label id="order"><?php echo $row[4]; ?></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">TASK</label><br/>
                                                        <?php if($stat == 'OSP_CLOSED') {?>
                                                            <label><?php echo $row[23]; ?></label>
                                                        <?php }else{ ?>
                                                            <label><?php echo $row[13]; ?></label>
                                                        <?php }?>

                                                    </div>


                                                </div>
                                                <hr/>

                                                <div class="row" style="font-size: 15px; font-weight: bold">
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">PACKAGE</label><br/>
                                                        <label id="pkg"><?php echo $pkg; ?></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">EQUIPMENT CLASS</label><br/>
                                                        <label><?php echo $row[10]; ?></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">EQUIPMENT PURCHASE FROM SLT</label><br/>
                                                        <label><?php echo $row[12]; ?></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">SALES PERSON</label><br/>
                                                        <label><?php echo $row[16]; ?></label>
                                                    </div>

                                                </div>
                                                <hr/>

                                                <div class="row" style="font-size: 15px; font-weight: bold">
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">DP LOOP</label><br/>
                                                        <label><?php echo $row[9]; ?></label>
                                                    </div>

                                                    <?php if($stype == 'AB-FTTH'){ ?>
                                                        <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                            <label style="color: #0dcaf0">OLT MANUFACTURER</label><br/>
                                                            <label><?php echo $ftth_data[6]; ?></label>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-8  mr-auto">
                                                            <label style="color: #0dcaf0">DESCRIPTION</label><br/>
                                                            <label><?php echo $row[18]; ?></label>
                                                        </div>
                                                    <?php }else {  ?>
                                                        <div class="col-lg-9 col-md-6 col-sm-8  mr-auto">
                                                            <label style="color: #0dcaf0">DESCRIPTION</label><br/>
                                                            <label><?php echo $row[18]; ?></label>
                                                        </div>

                                                    <?php }?>

                                                </div>
                                                <hr/>



                                            </div>


                                            <!--    ==============================   -->
                                        </div>

                                        <br/>
                                        <?php if($stype == 'AB-FTTH'){ ?>
                                        <div class="card">
                                            <div class="card-header ">
                                                <a href="#" style="font-weight: bold; font-size:large">SERVICES SOD DETAILS</a>
                                            </div>
                                            <!--    ==============================   -->
                                            <div class="card-body">
                                                <div class="row" style="font-size: 15px; font-weight: bold">
                                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">SERVICE ORDER</label>
                                                    </div>
                                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">SERVICE TYPE</label>
                                                    </div>
                                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">ORDER TYPE</label>
                                                    </div>
                                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">LINE TYPE</label>
                                                    </div>
                                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">CIRCUIT</label>
                                                    </div>
                                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">STATUS</label>
                                                    </div>
                                                </div>
                                                <?php foreach ($getBearerMap as $sodrow) {

                                                    if($sodrow[1] == 'E-IPTV FTTH' && $sodrow[3] == '1'){
                                                        $iptv1= $sodrow[0];
                                                        $iptv2= '';
                                                        $iptv3= '';
                                                        $i1='1';
                                                        $i2='0';
                                                        $i3='0';
                                                    }
                                                    if($sodrow[1] == 'E-IPTV FTTH' && $sodrow[3] == '2'){
                                                        $iptv2= $sodrow[0];
                                                        $iptv3= '';
                                                        $i2='1';
                                                        $i3='0';
                                                    }
                                                    if($sodrow[1] == 'E-IPTV FTTH' && $sodrow[3] == '3'){
                                                        $iptv3= $sodrow[0];
                                                        $i3='1';

                                                    }
                                                    if($sodrow[1] == 'V-VOICE FTTH' && $sodrow[3] == 'SECONDARY'){
                                                        $voice2= $sodrow[0];
                                                        $v2='1';

                                                    }
                                                    if($sodrow[1] == 'BB-INTERNET FTTH'){
                                                        $bb= $sodrow[0];
                                                        $b= '1';
                                                    }
                                                    $i++;

                                                    if($sodrow[5] == '' && $stat == 'OSP_CLOSED'){
                                                        $sodstat = 'COMPLETED';
                                                    }else{
                                                        $sodstat = $sodrow[5];
                                                    }

                                                    ?>




                                                    <div class="row" style="font-size: 15px; font-weight: bold">
                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            <label><?php echo $sodrow[0]; ?></label>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            <label><?php echo $sodrow[1]; ?></label>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            <label><?php echo $sodrow[2]; ?></label>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            <label><?php echo $sodrow[3]; ?></label>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            <label><?php echo $sodrow[4]; ?></label>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            <label><?php echo $sodstat; ?></label>
                                                        </div>
                                                    </div>
                                                    <hr/>

                                                <?php } ?>
                                            </div><br/>
                                            <input type="hidden" id="iptv1" value="<?php echo $iptv1; ?>">
                                            <input type="hidden" id="iptv2" value="<?php echo $iptv2; ?>">
                                            <input type="hidden" id="iptv3" value="<?php echo $iptv3; ?>">
                                            <input type="hidden" id="bb" value="<?php echo $bb; ?>">
                                            <input type="hidden" id="voice2" value="<?php echo $voice2; ?>">
                                            <input type="hidden" id="sval" value="<?php echo '1'.$v2.$b.$i1.$i2.$i3; ?>">



                                            <!--    ==============================   -->
                                        </div>
                                        <?php } ?>
                                        <br/>



                                        <?php if($stat == 'RETURN_PENDING'){ ?>
                                            <div class="card">
                                                <div class="card-header ">
                                                    <a href="#" style="font-weight: bold; font-size:large">RETURNED REASON</a>
                                                </div>
                                                <!--    ==============================   -->
                                                <div class="card-body">
                                                    <div class="row" style="font-size: 15px; font-weight: bold">
                                                        <div class="col-lg-4 col-md-6 col-sm-8  mr-auto">
                                                            <label style="color: #0dcaf0">REASON</label>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6 col-sm-8  mr-auto">
                                                            <label style="color: #0dcaf0">COMMENT</label>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            <label style="color: #0dcaf0">ATTRIBUTE NAME</label>
                                                        </div>
                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            <label style="color: #0dcaf0">ATTRIBUTE VALUE</label>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="row" style="font-size: 15px; font-weight: bold; padding-left: 20px;">
                                                    <div class="col-lg-4 col-md-6 col-sm-8  mr-auto">
                                                        <label><?php echo $getRetReason[0]; ?></label>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6 col-sm-8  mr-auto">
                                                        <label><?php echo $getRetReason[1];; ?></label>
                                                    </div>
                                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                        <label><?php echo $getRetReason[2];; ?></label>
                                                    </div>
                                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                        <label><?php echo $getRetReason[3];; ?></label>
                                                    </div>

                                                </div>
                                                <br/>

                                                <!--    ==============================   -->
                                            </div>
                                            <br/>
                                        <?php } ?>

                                        <?php if($stat == 'PAT_OPMC_REJECTED'){ ?>
                                            <div class="card">
                                                <div class="card-header ">
                                                    <a href="#" style="font-weight: bold; font-size:large">OPMC PAT REJECTED REASON</a>
                                                </div>
                                                <!--    ==============================   -->
                                                <div class="card-body">
                                                    <div class="row" style="font-size: 15px; font-weight: bold">
                                                        <div class="col-lg-12 col-md-6 col-sm-8  mr-auto">
                                                            <label style="color: #0dcaf0">REASON</label>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="row" style="font-size: 15px; font-weight: bold; padding-left: 20px;">
                                                    <div class="col-lg-12 col-md-6 col-sm-8  mr-auto">
                                                        <label><?php echo $getPatReason[1]; ?></label>
                                                    </div>

                                                </div>
                                                <br/>

                                                <!--    ==============================   -->
                                            </div>
                                            <br/>
                                        <?php } ?>

                                        <!---------------------- offline customer confirmation ----------->

                                        <?php if($getSodImgupSt[0] == 1){ ?>

                                        <div class="card">
                                        <div class="card-header ">
                                            <h2 style="font-weight: bold; font-size:large">CUSTOMER CONFIRMATION</h2>
                                        </div>
                                        <div class="card-body ">
                                        <div class="row" style="font-size: 15px; padding-left: 20px; font-weight: bold">
                                        <table class="table table-stripe">

                                        <?php if($pkg == 'Triple Play'){ ?>

                                            <tr><td colspan="5">Service Return</td></tr>
                                            <tr>
                                            <td><input type="checkbox" id="chkiptv" onclick="chkIptv();"> IPTV</td>
                                            <td><input type="checkbox" id="chkbb" onclick="chkBB();"> BB-INTERNET</td>
                                            <td><select id="rtreson" class="form-control form-control-sm" style="display:none"><option>Return Reason</option></select></td>
                                            <td><input type="text" class="form-control form-control-sm" id="rtcmt" style="display:none" placeholder="Comment"></td>
                                            <td colspan="2"></td>
                                            </tr>
                                        <?php

                                        }

                                        ?>

                                        <tr>
                                        <td colspan="2"><input type="checkbox" id="chksodrtn" onclick="chkSod();"> SOD RETURN</td>
                                        <td><select id="rtresonall" onchange="disPwlevl();" class="form-control form-control-sm" style="display:none"></select></td>
                                        <td><input type="text" class="form-control form-control-sm" id="pwlevel" style="display:none" placeholder="Power Level"></td>
                                        <td><input type="text" class="form-control form-control-sm" id="rtcmtall" style="display:none" placeholder="Comment"></td>
                                        </tr>

                                        <tr>
                                            <td colspan="5"><input type="checkbox" id="chkFdpchg" onclick="fdptxtEnable();"/> Change FDP</td>
                                        </tr>

                                        <tr>
                                        <td colspan="3"><input type="text" id="txtcfdp" class="form-control" disabled placeholder="Fdp"/></td>
                                        <td colspan="2"><input type="text" id="txtcLoop" class="form-control" disabled placeholder="Loop"/></td>
                                        </tr>

                                        <tr><td colspan="5"><button class="btn btn-success btn-sm float-right" onclick="processOrder();"><i class="fa fa-gear"></i> PROCEED</button></td></tr>
                                        
                                        </table>

                                        </div>

                                        </div>

                                        </div>

                                        <?php } ?>

                                    </div>

                                    <!--- -->
                                    <div class="tab-pane fade" id="sn" role="tabpanel" aria-labelledby="border-top-profile-tab">

                                        <?php

                                        if($getSodImgupSt[0] == ''){

                                        ?>

                                            <div class="card" id="mobTeamRw">
                                                <div class="card-header ">
                                                    <a href="#" style="font-weight: bold; font-size:large">MOBILE TEAM DETAILS</a>
                                                </div>

                                                <?php if ($getSnAssign[0] == ''){ ?>
                                                    <div class="card-body ">
                                                        <div class="row">
                                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                                                <label style="color: #0dcaf0">MOBILE TEAM</label><br/>
                                                                <select  class="form-control basic"  name="mobusr" id="mobusr" style="color:#1C96B1; font-weight: bold"  required>
                                                                    <option value="">-- Select Team --</option>";
                                                                    <?php
                                                                    $getMobTeam = $db->getMobTeam($con,$_SESSION["uarea"]);
                                                                    foreach ($getMobTeam as $mobusr ){
                                                                        echo "<option value=\"$mobusr[0]\">$mobusr[0] - $mobusr[1]</option>";
                                                                    }


                                                                    ?>
                                                                </select>

                                                            </div>
                                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                                                <label style="color: #0dcaf0">&nbsp;</label><br/>
                                                                <button class="btn btn-info" id="mobasgnButton" style="height: 40px;"  onclick="SnMobAssign()">ASSIGN</button>

                                                            </div>
                                                        </div><br/>


                                                    </div>

                                                <?php }else{ ?>

                                                    <div class="card-body ">

                                                        <div class="row">
                                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                                                <label style="color: #0dcaf0">MOBILE TEAM</label><br/>
                                                                <select  class="form-control   basic" name="mobusr" id="mobusr" style="color:#1C96B1; font-weight: bold"  required>
                                                                    <option value="">-- Select Team --</option>";

                                                                    <?php
                                                                    if($stat == 'OSP_CLOSED' || $stat == 'INSTALL_CLOSED' || $stat == 'COMPLETED') {
                                                                        $getMobTeam = $db->getMobTeam($con,$_SESSION["uarea"]);
                                                                        foreach ($getMobTeam as $mobusr) {
                                                                            if ($getSnAssign[11] == $mobusr[0]) {
                                                                                echo "<option value=\"$mobusr[0]\" selected>$mobusr[0] - $mobusr[1]</option>";
                                                                            }
                                                                        }
                                                                    }else{
                                                                        $getMobTeam = $db->getMobTeam($con,$_SESSION["uarea"]);
                                                                        foreach ($getMobTeam as $mobusr) {
                                                                            if ($getSnAssign[11] == $mobusr[0]) {
                                                                                echo "<option value=\"$mobusr[0]\" selected>$mobusr[0] - $mobusr[1]</option>";
                                                                            } else {
                                                                                echo "<option value=\"$mobusr[0]\" >$mobusr[0] - $mobusr[1]</option>";
                                                                            }

                                                                        }

                                                                    }


                                                                    ?>
                                                                </select>

                                                            </div>
                                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                                                <label style="color: #0dcaf0">&nbsp;</label><br/>
                                                                <?php if($stat == 'OSP_CLOSED'|| $stat == 'INSTALL_CLOSED' || $stat == 'COMPLETED') {?>
                                                                <?php }else{ ?>
                                                                    <button class="btn btn-info" id="mobasgnButton" style="height: 40px;"  onclick="changeMobUser()">CHANGE</button>
                                                                <?php }?>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                                                <label style="color: #0dcaf0">TEAM USERS</label><br/>

                                                                <?php $getTeamUser = $db->getTeamUser($getSnAssign[11],$con);
                                                                foreach ($getTeamUser as $mobusr) { ?>

                                                                    <label style="font-weight: bold"><?php echo $mobusr[0] ;?></label><br/>

                                                                <?php }
                                                                ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                <?php } ?>
                                            </div>

                                        <?php } ?>

                                        <br/>

                                        <?php 

                                        if(($getSodImgupSt[0] != '' && sizeOf($getSn)>0) || $getSodImgupSt[0] == ''){
                               
                                        ?>

                                        <div class="card">
                                            <div class="card-header ">
                                                <a href="#" style="font-weight: bold; font-size:large">SERIAL NUMBER DETAILS</a>
                                            </div>

                                            <div class="card-body ">
                                                <div class="row" style="font-size: 15px; font-weight: bold">
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">ATTRIBUTE NAME</label><br/>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">DEFAULT VALUE</label><br/>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0"></label><br/>
                                                    </div>

                                                </div>

                                                <?php foreach ($getSn as $sn){ ?>

                                                    <div class="row" style="font-size: 15px; padding-left: 20px; font-weight: bold">
                                                        <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                            <label><?php echo $sn[1]; ?></label><br/>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                            <label><?php echo $sn[2]; ?></label><br/>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-8  mr-auto">
                                                            <label style="color: #0dcaf0"></label><br/>
                                                        </div>

                                                    </div><hr/>


                                                <?php }?>


                                            </div>
                                        </div>

                                        <?php } ?>

                                        <?php if($getSodImgupSt[0] == '2' && $stat == 'INPROGRESS') { ?>

                                        <div class="card">
                                        <div class="card-header ">
                                            <a href="#" style="font-weight: bold; font-size:large">SERIAL NUMBER DETAILS</a>
                                        </div>

                                        <div class="card-body ">

                                            <div class="row" style="font-size: 15px; font-weight: bold">
                                            <div class="col-lg-6 col-md-6 col-sm-8  mr-auto">    
                                            <table class="table table-stripe" id="tbloflnSr">

                                            <?php 

                                            $i=0;

                                            foreach ($getOflinSn as $snOfln){  

                                                $i++;
                                                
                                            ?>
                                                <tr>
                                                    <td style="display:none"><?php echo $snOfln[0]; ?></td>
                                                    <td style="width:250px"><?php echo 'Telephone Number Serial'.$i; ?></td>
                                                    <td><input type="text" class="form-control"/></td>
                                                </tr>
                                                
                                            <?php } ?>

                                                </table>
                                                </div>
                                            </div>

                                            <div class="row" style="font-size: 15px; font-weight: bold">
                                            <div class="col-lg-6 col-md-6 col-sm-8  mr-auto">    
                                            <table class="table table-stripe" id="tbloflnIptv">

                                            <?php 

                                            $i=0;

                                            foreach ($getOfliniptv as $iptvOfln){  

                                                $i++;
                                                
                                            ?>
                                                <tr>
                                                    <td style="display:none"><?php echo $iptvOfln[0]; ?></td>
                                                    <td style="width:250px"><?php echo 'PeoTv STB MAC S/N'.$i; ?></td>
                                                    <td><input type="text" class="form-control"/></td>
                                                </tr>
                                                
                                            <?php } ?>

                                                </table>
                                                </div>
                                            </div>
                                            
                                            <?php if($row[3]=='AB-FTTH'){ ?>

                                            <div class="row" style="font-weight: bold">
                                            <div class="col-lg-6 col-md-6 col-sm-8  mr-auto">    
                                            <table class="table table-stripe">
                                                <tr>
                                                    <td style="width:250px">ONT ROUTER SERIAL NUMBER</td>
                                                    <td><input type="text" id="txtont" class="form-control"/></td>
                                                </tr>
                                            </table>
                                            </div>
                                            </div>

                                            <?php } ?>

                                            <br/>

                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-8  mr-auto">
                                                    <button class="btn btn-success btn-sm float-right" onclick="validateSerial();"><i class="fa fa-save"></i> SAVE</button>
                                                </div>
                                            </div>

                                            </div>
                                        </div>

                                        <?php } ?>

                                    </div>

                                    <!--- -->
                                       
                                    <div class="tab-pane fade" id="met" role="tabpanel" aria-labelledby="border-top-contact-tab">

                                    <!-- check offline --->
                                    <?php

                                    if($getSodImgupSt[0] == '' || $getSodImgupSt[0] == '2' || $getSodImgupSt[0] == '3' || $getSodImgupSt[0] == '4'){

                                    ?>
                                        <div class="card">
                                            <div class="card-header ">
                                                <a href="#" style="font-weight: bold; font-size:large">METERIAL DETAILS</a>
                                            </div>

                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                                        <label style="color: #0dcaf0">DROP WIRE</label><br/><br/>
                                                        <?php if ($getFtthDW[3] != '' ){ ?>
                                                            <div class="row">
                                                                <div class="col-lg-1 col-md-6 col-sm-8  mr-auto">
                                                                </div>
                                                                <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                                    <input type="text" id="dw" class="form-control" style="border-radius:5px;width:250px;height:40px;  color:#1C96B1; font-weight: bold"  value="<?php echo $getFtthDW[2]; ?>" disabled>
                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                    <input type="number"  id="dwvalue" class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold"  value="<?php echo $getFtthDW[3]; ?>" >

                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                </div>
                                                                <?php if($getSodImgupSt[0] == '' || $getSodImgupSt[0] == '2' || $getSodImgupSt[0] == '3') { ?>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                    <?php if($stat == 'COMPLETED'|| $stat == 'PAT_OPMC_REJECTED') {?>

                                                                    <?php }else{ ?>
                                                                        <button class="btn btn-info mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="updateMeterial('<?php echo $getFtthDW[0]; ?>','<?php echo $getFtthDW[2]; ?>','<?php echo $getFtthDW[6]; ?>')">UPDATE</button>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php } ?>

                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                </div>
                                                            </div>
                                                        <?php }else { ?>

                                                            <?php if($getSodImgupSt[0] == '' || $getSodImgupSt[0] == '2' || $getSodImgupSt[0] == '3') { ?>

                                                            <div class="row">
                                                                <div class="col-lg-1 col-md-6 col-sm-8  mr-auto">
                                                                </div>
                                                                <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                                    <input type="text" id="dw" class="form-control" style="border-radius:5px;width:250px;height:40px;  color:#1C96B1; font-weight: bold"  value="FTTH-DW" disabled>
                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                    <input type="number" id="dwvalue" class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold"   dis>

                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                    <button class="btn btn-info mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="addMeterial()">&nbsp;&nbsp;&nbsp;ADD&nbsp;&nbsp;&nbsp;</button>
                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                </div>
                                                            </div>

                                                            <?php } ?>

                                                        <?php } ?>

                                                    </div>

                                                </div><br/><hr/><br/>
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                                        <label style="color: #0dcaf0">POLES</label><br/>

                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                                                <div class="row">
                                                                    <div class="col-lg-1 col-md-6 col-sm-8  mr-auto">
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                                        <input type="text" class="form-control" style="border-radius:5px;width:250px;height:40px;  color:#1C96B1; font-weight: bold"  value="NUMBER OF POLES" disabled>
                                                                    </div>
                                                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                        <input type="number"  id="dwvalue" class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold"  value="<?php echo $getPoleCount[0]; ?>" disabled>

                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 col-sm-8  mr-auto">
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div><br/><br/>

                                                        <?php foreach ($getPolemet as $poles){ ?>

                                                            <div class="row">
                                                                <div class="col-lg-1 col-md-6 col-sm-8  mr-auto">
                                                                </div>
                                                                <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                                    <label>UNIT DESIGNATOR</label>
                                                                    <input type="text" class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" value="<?php echo $poles[2];?>" disabled >

                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                    <label>QUANTITY</label>
                                                                    <input type="number"  class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" value="<?php echo $poles[3];?>" disabled >

                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                    <label>SERIAL NO</label>
                                                                    <input type="text"  class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" value="<?php echo $poles[5];?>" disabled >

                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                    <label>&nbsp;</label><br/>
                                                                    <?php if($getSodImgupSt[0] == '' || $getSodImgupSt[0] == '2' || $getSodImgupSt[0] == '3') { ?>

                                                                    <?php if($stat == 'COMPLETED' || $stat == 'PAT_OPMC_REJECTED') {?>

                                                                    <?php }else{ ?>
                                                                        <button class="btn btn-danger mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="deletePolMeterial('<?php echo $poles[0]; ?>','<?php echo $poles[2]; ?>','<?php echo $poles[6]; ?>')">DELETE</button>
                                                                    <?php } ?>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                </div>
                                                            </div>

                                                        <?php } ?>

                                                        <?php if($stat == 'COMPLETED' || $stat == 'PAT_OPMC_REJECTED') {?>
                                                            <br/><hr/><br/>
                                                        <?php }else{ ?>

                                                            <?php if($getSodImgupSt[0] == '' || $getSodImgupSt[0] == '2' || $getSodImgupSt[0] == '3') { ?>

                                                            <div class="row">
                                                                <div class="col-lg-1 col-md-6 col-sm-8  mr-auto">
                                                                </div>
                                                                <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                                    <label>UNIT DESIGNATOR</label>
                                                                    <select class="form-control  basic" name="pole" id="pole" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" required>
                                                                        <option value="">SELECT POLE ...</option>
                                                                        <?php
                                                                        foreach ($getPoles as $pole ){
                                                                            echo "<option value=\"$pole[0]\">$pole[0]</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                    <label>QUANTITY</label>
                                                                    <input type="number" id="qty" class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" value="1" disabled >

                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                    <label>SERIAL NO</label>
                                                                    <input type="text" id="snvalue" class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold"   >

                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                    <label>&nbsp;</label><br/>
                                                                    <button class="btn btn-info mb-4" style="height: 40px;" id="btnAddPol"  name="SubmitButton" onclick="addMeterialPole()">&nbsp;&nbsp;&nbsp;ADD&nbsp;&nbsp;&nbsp;</button>
                                                                </div>
                                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                            <hr/><br/>
                                                        <?php } ?>


                                                        <div class="row">
                                                            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                                                <label style="color: #0dcaf0">OTHER</label><br/>

                                                                <?php foreach ($getOtherMet as $othetmet){ ?>

                                                                    <div class="row">
                                                                        <div class="col-lg-1 col-md-6 col-sm-8  mr-auto">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                                            <label>UNIT DESIGNATOR</label>
                                                                            <input type="text" class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" value="<?php echo $othetmet[2];?>" disabled >

                                                                        </div>
                                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                            <label>QUANTITY</label>
                                                                            <input type="number"  class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" value="<?php echo $othetmet[3];?>" disabled >

                                                                        </div>
                                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                            <label>&nbsp;</label><br/>
                                                                            <?php if($stat == 'COMPLETED' || $stat == 'PAT_OPMC_REJECTED') {?>

                                                                            <?php }else{ ?>
                                                                                <button class="btn btn-danger mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="deleteMeterial('<?php echo $othetmet[0]; ?>','<?php echo $othetmet[2]; ?>','<?php echo $othetmet[6]; ?>')">DELETE</button>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                        </div>
                                                                    </div>

                                                                <?php } ?>

                                                                <?php if($stat == 'COMPLETED' || $stat == 'PAT_OPMC_REJECTED') {?>

                                                                <?php }else{ ?>
                                                                    <div class="row">

                                                                        <div class="col-lg-1 col-md-6 col-sm-8  mr-auto">
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                                            <label>UNIT DESIGNATOR</label>
                                                                            <select class="form-control  basic" name="oth" id="oth" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" required>
                                                                                <option value="">SELECT METERIAL ...</option>
                                                                                <?php
                                                                                foreach ($getOthers as $other ){
                                                                                    echo "<option value=\"$other[0]\">$other[0]</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                            <label>QUANTITY</label>
                                                                            <input type="number" id="othvalue" class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" >

                                                                        </div>
                                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                            <label>&nbsp;</label><br/>
                                                                            <button class="btn btn-info mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="addMeterialOther()">&nbsp;&nbsp;&nbsp;ADD&nbsp;&nbsp;&nbsp;</button>
                                                                        </div>
                                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>

                                                            </div>

                                                        </div><br/><hr/></br>

                                                        <!---- Techs Attributes ----->
                                                        <div class="row">
                                                        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                                        <label style="color: #0dcaf0">Attributes</label><br/>

                                                        <?php foreach ($getTechAtt as $techAtt){ ?>

                                                        <div class="row">
                                                            <div class="col-lg-1 col-md-6 col-sm-8  mr-auto">
                                                            </div>
                                                            <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                                <label>ATTRIBUTE NAME</label>
                                                                <input type="text" class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" value="<?php echo $techAtt[1];?>" disabled >

                                                            </div>
                                                            <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                <label>ATTRIBUTE VALUE</label>
                                                                <input type="number"  class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" value="<?php echo $techAtt[2];?>" disabled >

                                                            </div>
                                                            <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            </div>
                                                            <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                <label>&nbsp;</label><br/>
                                                                <?php if($stat == 'COMPLETED' || $stat == 'PAT_OPMC_REJECTED') {?>

                                                                <?php }else{ ?>
                                                                    <button class="btn btn-danger mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="deleteTechAtt('<?php echo $techAtt[0]; ?>','<?php echo $techAtt[1]; ?>')">DELETE</button>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            </div>
                                                        </div>

                                                        <?php } ?>

                                                        <?php if($stat == 'COMPLETED' || $stat == 'PAT_OPMC_REJECTED') {?>

                                                        <?php }else{ ?>
                                                        <div class="row">

                                                            <div class="col-lg-1 col-md-6 col-sm-8  mr-auto">
                                                            </div>
                                                            <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                                <label>ATTRIBUTE NAME</label>
                                                                <select class="form-control  basic" name="cmbtAtt" id="cmbtAtt" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" required>
                                                                    <option value="">--SELECT ATTRIBUTE NAME--</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                <label>ATTRIBUTE VALUE</label>
                                                                <input type="number" id="tAttvalue" class="form-control" style="border-radius:5px;width:150px;height:40px;  color:#1C96B1; font-weight: bold" >

                                                            </div>
                                                            <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            </div>
                                                            <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                                <label>&nbsp;</label><br/>
                                                                <button class="btn btn-info mb-4" style="height: 40px;" id="btnTAtt"  name="btnTAtt" onclick="addTechAtt()">&nbsp;&nbsp;&nbsp;ADD&nbsp;&nbsp;&nbsp;</button>
                                                            </div>
                                                            <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            </div>
                                                        </div>
                                                        <?php } ?>

                                                        </div>

                                                        </div><br/>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php } ?>

                                    </div>

                                    <!--- -->
                                    <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="border-top-contact-tab">

                                        <!-- check offline --->
                                        <?php

                                        if($getSodImgupSt[0] == '' || $getSodImgupSt[0] == '2' || $getSodImgupSt[0] == '3' || $getSodImgupSt[0] == '4'){

                                        ?>

                                        <div class="card">
                                            <div class="card-header ">
                                                <a href="#" style="font-weight: bold; font-size:large">IMAGE DETAILS</a>
                                            </div>

                                            <div class="card-body ">
                                                <?php

                                                $dirname = "https://serviceportal.slt.lk/disk2/ishampImages/";

                                                $getAllImg = $db->getAllImg();

                                                $getPatAllImgCount = $db->getPatAllImgCount($sod,1);

                                                $imgc = 0;

                                                $upimgN = strtotime("now");

                                                foreach( $getAllImg as $row ) {


                                                $loadImgData = $db->loadImg2($sod,$row[0],'1');


                                                foreach( $loadImgData as $loadImg ) {

                                                $img_url='';
                                                $imgc++;
                                                $img_url = $dirname.$sod."/".$loadImg[0].'.png';

                                                if($imgc%4 == 1){ ?>

                                                <div class="row" style="font-size: 15px; font-weight: bold">
                                                    <?php } ?>

                                                    <div class="col-lg-3 col-md-4 col-sm-8  mr-auto">
                                                        <div class="col-lg-12 col-md-12 col-sm-8  mr-auto center"><label style="color: #0dcaf0" title="<?php echo $row[4]; ?>"><?php echo $loadImg[2]; ?></label></div>
                                                        <input type="hidden" value="<?php echo $upimgN; ?>" id="<?php echo $row[0].'imgN'; ?>">
                                                        <input type="hidden" value="<?php echo $row[1]; ?>" id="<?php echo $row[0].'imgDN'; ?>">
                                                        <input type="hidden" value="<?php echo $loadImg[0]; ?>" id="<?php echo $row[0].'limg'; ?>">
                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto image-set">
                                                            <a data-magnify="gallery" data-src="" data-group="a" title="<?php echo $row[4]; ?>" href="<?php echo $img_url; ?>">
                                                                <img class="modal2-content" id="1" src="<?php echo $img_url; ?>" width="200" height="200" onerror="this.src='../assets/img/no-image.png'">
                                                            </a>
                                                        </div>
                                                        
                                                        <?php 
                                                        
                                                        if($stat != 'COMPLETED'){ 
                                                        
                                                        //------------offline -----------//
                                                        $getSodImgupSt = $db->getSodImgupSt($sod,$stat); 

                                                        if($getSodImgupSt[0] != ''){

                                                        if($loadImg[0] == ''){
                                                            
                                                        ?>

                                                        <div class="mt-0"></div>
                                                                        
                                                        <div class="col-lg-10 col-md-12 col-sm-8  mr-auto center">
                                                        <input type="file" id="<?php echo $row[0].'img_file'; ?>" name="<?php echo $row[0].'img_file'; ?>" accept="image/*">
                                                        </div>

                                                        <div class="mt-0"></div>

                                                        <div class="col-lg-10 col-md-12 col-sm-8  mr-auto center">
                                                        <button class="btn btn-sm btn-warning" onclick="imgUpload(<?php echo $row[0] ?>);" title="Upload"><i class="fa fa-upload"></i></button>
                                                        </div>

                                                        <?php }else{ ?>

                                                        <div class="col-lg-10 col-md-12 col-sm-8  mr-auto center">
                                                            <button class="btn btn-sm btn-danger" onclick="deleteImg(<?php echo $row[0]; ?>,<?php echo $loadImg[0]; ?>);" title="Delete"><i class="fa fa-trash"></i></button>
                                                        </div>

                                                        <?php 
                                                        
                                                        }

                                                        }else{ 
                                                            
                                                            if($loadImg[0] != ''){

                                                        ?>
                                                            
                                                        <div class="col-lg-10 col-md-12 col-sm-8  mr-auto center">
                                                            <button class="btn btn-sm btn-danger" onclick="deleteImg(<?php echo $row[0]; ?>,<?php echo $loadImg[0]; ?>);" title="Delete"><i class="fa fa-trash"></i></button>
                                                        </div>

                                                        <?php

                                                            }

                                                        }

                                                        }
                                                        
                                                        ?>

                                                    </div>

                                                    <?php  if($imgc%4 == 0){ ?>

                                                </div>
                                                </br>
                                            <hr/>
                                                </br>

                                            <?php }

                                            if($getPatAllImgCount[0] == $imgc && $imgc%4 != 0){ ?>

                                            </div>
                                            </br>
                                            <hr/>
                                            </br>

                                            <?php } } }?>

                                        </div>

                                        </div>

                                        <?php } ?>
                                
                                    </div>

                                    <!--- -->
                                    <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="border-top-contact-tab">
                                        <div class="card">
                                            <div class="card-header ">
                                                <a href="#" style="font-weight: bold; font-size:large">LOG DETAILS</a>
                                            </div>

                                            <div class="card-body ">
                                                <?php foreach ($getLog as $log){ ?>

                                                    <div class="row" style="font-size: 15px; padding-left: 20px; font-weight: bold">
                                                        <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                            <label><?php echo $log[1]; ?></label><br/>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                            <label><?php echo $log[0]; ?></label><br/>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-8  mr-auto">
                                                            <label style="color: #0dcaf0"><?php echo $log[3]; ?></label><br/>
                                                        </div>

                                                    </div><hr/>


                                                <?php }?>


                                            </div>
                                        </div>
                                    </div>

                                </div>
                        </div>
                    </div>




                    <!--  =================  -->

                </div>


        </div>



        <!-- FOOTER -->
        <?php
        include "footer.php"
        ?>
        <!-- FOOTER -->
    </div>

</div>
</div>
<!--  END CONTENT PART  -->

</div>
<!-- END MAIN CONTAINER -->


<!-- JAVASCRIPT --->
<?php
include "script.php"
?>

<script>
    function SnMobAssign(){

        var info =[];

         info[0]= document.getElementById('mobusr').value;
         info[1]= <?php echo json_encode($sod); ?>;
         info[2]= <?php echo json_encode($seit); ?>;
         info[3]= <?php echo json_encode($con); ?>;
         info[4]= <?php echo json_encode($rtom); ?>;
         info[5]= <?php echo json_encode($circuit); ?>;
         info[6]= <?php echo json_encode($stype); ?>;
         info[7]= <?php echo json_encode($order); ?>;
         info[8]= <?php echo json_encode($row[20]); ?>;
         info[9]= <?php echo json_encode($pkg); ?>;


        if(info[7] == 'CREATE-UPGRD SAME NO'){
             info[10]='';
             info[11]='';
             info[12]='';
        }else{
             info[10]= document.getElementById('iptv1').value;
             info[11]= document.getElementById('iptv2').value;
             info[12]= document.getElementById('iptv3').value;
        }

        info[13]= document.getElementById('bb').value;
        info[14]= document.getElementById('voice2').value;
        info[15]= document.getElementById('sval').value;


        if(info[0] == ''){
            Snackbar.show({
                text: 'user cannot be empty',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });
        }else {
            var r = confirm("Are you sure you want to Assign sod!");

            if (r == true) {
                var q = "snuser";
                $.ajax({

                    type: "POST",
                    url: "../db/DbFunctions",
                    data: {info: info, q: q},
                    success: function (data) {

                        if (data == 'success') {

                            Snackbar.show({
                                text: 'mobile user assign success',
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 3000);


                        } else {
                            Snackbar.show({
                                text: 'mobile user assign failed',
                                actionTextColor: '#fff',
                                backgroundColor: '#e7515a',
                                pos: 'top-center',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 3000);
                        }

                    }
                });

            }
        }
    }

    function changeMobUser(){

        var user= document.getElementById('mobusr').value;
        var sod= <?php echo json_encode($sod); ?>;

        if(user == ''){
            Snackbar.show({
                text: 'user cannot be empty',
                actionTextColor: '#fff',
                backgroundColor: '#6ccb09',
                pos: 'top-center',
            });
        }else {
            var r = confirm("Are you sure you want to Change the User!");


            if (r == true) {
                var q = "snuserchg";
                $.ajax({

                    type: "POST",
                    url: "../db/DbFunctions",
                    data: {sod: sod,usr:user, q: q},
                    success: function (data) {

                        if (data == 'success') {

                            Snackbar.show({
                                text: 'mobile user change success',
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 3000);


                        } else {
                            Snackbar.show({
                                text: 'mobile user change failed',
                                actionTextColor: '#fff',
                                backgroundColor: '#e7515a',
                                pos: 'top-center',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 3000);
                        }

                    }
                });

            }
        }

    }

    function updateMeterial(sod,udesig,metid){

        var info =[];

        var dwvalue= document.getElementById("dwvalue").value;
        if(udesig == 'FTTH-DW'){

            if(dwvalue > 1000){

                Snackbar.show({
                    text: 'Drop Wire Length should be less than 1000',
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a',
                    pos: 'top-center',
                });

            }else{
                info[0]=sod;
                info[1]=udesig;
                info[2]=metid;
                info[3]=dwvalue;

                var q = 'updatemetFtth';
                $.ajax({

                    type: "POST",
                    url: "../db/DbFunctions",
                    data: {info: info, q: q},
                    success: function (data) {

                        if (data == 'success') {

                            Snackbar.show({
                                text: 'meterial update success',
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 3000);


                        } else {
                            Snackbar.show({
                                text: 'meterial update failed',
                                actionTextColor: '#fff',
                                backgroundColor: '#e7515a',
                                pos: 'top-center',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 3000);
                        }

                    }
                });

            }

        }


    }

    function addMeterial(){

        var info =[];

        info[0]="<?php echo $sod; ?>";
        info[1]="<?php echo $circuit; ?>";
        info[2]=document.getElementById("dwvalue").value;
        info[3]=document.getElementById("dw").value;
        info[4]='';

        if(info[2] == ''){
            Snackbar.show({
                text: 'Drop Wire Length Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });
            return;
        }else{

            var q = 'addMeterial';
            $.ajax({

                type: "POST",
                url: "../db/DbFunctions",
                data: {info: info, q: q},
                success: function (data) {

                    if (data == 'success') {

                        Snackbar.show({
                            text: 'meterial add success',
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 3000);


                    } else {
                        Snackbar.show({
                            text: 'meterial add failed',
                            actionTextColor: '#fff',
                            backgroundColor: '#e7515a',
                            pos: 'top-center',
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }

                }
            });

        }



    }

    function addMeterialPole(){

        var info =[];

        info[0]="<?php echo $sod; ?>";
        info[1]="<?php echo $circuit; ?>";
        info[3]=document.getElementById("pole").value;
        info[2]=document.getElementById("qty").value;
        info[4]=document.getElementById("snvalue").value;
        
        $("#btnAddPol").prop('disabled', true);

        if(info[3] == ''){
            Snackbar.show({
                text: 'UNIT DESIGNATOR required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });
            return;
        }
        if(info[4] == ''){
            Snackbar.show({
                text: 'SERIAL NUMBER required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });
            return;
        }

        var q = 'addMeterial';
        $.ajax({

            type: "POST",
            url: "../db/DbFunctions",
            data: {info: info, q: q},
            success: function (data) {

                if (data == 'success') {

                    //insPolMat();

                    upPolCount();


                } else {
                    Snackbar.show({
                        text: 'meterial add failed',
                        actionTextColor: '#fff',
                        backgroundColor: '#e7515a',
                        pos: 'top-center',
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }

            }
        });


    }

    //------------------offline------------//
    /*function insPolMat(){

        var soid = "<?php echo $sod; ?>";
        var len = 1;
        var voice = "<?php echo $circuit; ?>";
        var name = document.getElementById("pole").value;
        var sn = document.getElementById("snvalue").value;

        $.ajax({
        type:"post",
        url:"https://serviceportal.slt.lk/ApiPro/public/insertMaterial",
        data:{soid: soid, len: len, voice: voice, name: name, sn: sn},
        success:function(data){

            if(data.error == false){

                upPolCount();

            }else{

                Snackbar.show({
                    text: data.message,
                    actionTextColor: '#fff',
                    backgroundColor: '#6ccb09',
                    pos: 'top-center',
                });

            }
        
            }
        });

    }*/

    function upPolCount(){

        var info =[];
        info[0]="<?php echo $sod; ?>";

        var pcount = 0;
        var soid = "<?php echo $sod; ?>";
        var len = 1;
        var voice = "<?php echo $circuit; ?>";
        var name = document.getElementById("pole").value;
        var sn = document.getElementById("snvalue").value;

        $.ajax({
        type: "POST",
        url: "../db/DbFunctions",
        data: {info: info, q: 'getExPolCnt'},
        success: function (data) {

            if(data.POLE_COUNT>0){

                pcount = data.POLE_COUNT;

            }else{

                pcount = 0;

            }

            pcount = parseFloat(pcount)+1;

            //-------------up pol count-------------//

            $.ajax({
            type:"post",
            url:"https://serviceportal.slt.lk/ApiPro/public/updatePoles",
            data:{soid: soid, pcount: pcount},
            success:function(data){

                if(data.error == false){

                   //---------------ins pol img -------------//

                    $.ajax({
                    type:"post",
                    url:"https://serviceportal.slt.lk/ApiPro/public/insertPoleImage",
                    data:{soid: soid, pno: pcount},
                    success:function(data){

                        if(data.error == false){

                            Snackbar.show({
                            text: 'meterial add success',
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                            });

                            //$("#btnAddPol").prop('disabled', false);

                            setTimeout(function(){window.location.reload();}, 2000);

                        }else{

                            Snackbar.show({
                                text: data.message,
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });

                        }
                    
                        }
                    });

                    //----------------- ins pol img -------------//

                }else{

                    Snackbar.show({
                        text: data.message,
                        actionTextColor: '#fff',
                        backgroundColor: '#6ccb09',
                        pos: 'top-center',
                    });

                }
            
                }
            });

            }
        });

    }

    function deleteMeterial(sod,udesig,metid){

    var info =[];

        info[0]=sod;
        info[1]=udesig;
        info[2]=metid;
        var q = 'deleteMet';

        //--------del mat-----------//

        $.ajax({
        type: "POST",
        url: "../db/DbFunctions",
        data: {info: info, q: q},
        success: function (data) {

            if (data == 'success') {

                Snackbar.show({
                    text: 'meterial delete success',
                    actionTextColor: '#fff',
                    backgroundColor: '#6ccb09',
                    pos: 'top-center',
                });

                setTimeout(function(){window.location.reload();}, 3000);

            } else {
                Snackbar.show({
                    text: 'meterial delete failed',
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a',
                    pos: 'top-center',
                });
                setTimeout(function () {
                    location.reload();
                }, 3000);
            }

        }
        });

        //--------del mat-----------//
        
    }

    //------------offline------------//

    function deletePolMeterial(sod,udesig,metid){

        var info =[];

            info[0]=sod;
            info[1]=udesig;
            info[2]=metid;
            var q = 'deleteMet';

            //--------del mat-----------//

            $.ajax({
            type: "POST",
            url: "../db/DbFunctions",
            data: {info: info, q: q},
            success: function (data) {

                if (data == 'success') {

                    delpolImg();

                } else {
                    Snackbar.show({
                        text: 'meterial delete failed',
                        actionTextColor: '#fff',
                        backgroundColor: '#e7515a',
                        pos: 'top-center',
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }

            }
            });

            //--------del mat-----------//
            
    }

    function delpolImg(){

        var info =[];
        info[0]="<?php echo $sod; ?>";

        var pcount = 0;
        var soid = "<?php echo $sod; ?>";

        $.ajax({
        type: "POST",
        url: "../db/DbFunctions",
        data: {info: info, q: 'getExPolCnt'},
        success: function (data) {

            if(data.POLE_COUNT=='' || data.POLE_COUNT <= 0){

                pcount = 0;

            }else{

                pcount = parseFloat(data.POLE_COUNT)-1;

            }

            var polimgN = '%#'+data.POLE_COUNT+'%';

            //-------------up pol count-------------//

            $.ajax({
            type:"post",
            url:"https://serviceportal.slt.lk/ApiPro/public/updatePoles",
            data:{soid: soid, pcount: pcount},
            success:function(data){

                if(data.error == false){

                   //---------------del pol img -------------//

                    $.ajax({
                    type: "POST",
                    url: "../db/DbFunctions",
                    data: {soid: soid, polimgN:polimgN, q: 'delExPolImg'},
                    success: function (data) {

                        if (data == 'success') {

                            Snackbar.show({
                                text: 'meterial delete success',
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });

                            setTimeout(function(){window.location.reload();}, 2000);

                        }else{

                            Snackbar.show({
                                text: data,
                                actionTextColor: '#fff',
                                backgroundColor: '#e7515a',
                                pos: 'top-center',
                            });

                        }
                    
                        }
                    });

                    //----------------- del pol img -------------//

                }else{

                    Snackbar.show({
                        text: data.message,
                        actionTextColor: '#fff',
                        backgroundColor: '#e7515a',
                        pos: 'top-center',
                    });

                }
            
                }
            });
            //--------------//

            

        }

        });


    }

    function addMeterialOther(){

        var info =[];

        info[0]="<?php echo $sod; ?>";
        info[1]="<?php echo $circuit; ?>";
        info[2]=document.getElementById("othvalue").value;
        info[3]=document.getElementById("oth").value;
        info[4]='';

        if(info[2] == ''){
            Snackbar.show({
                text: 'Value Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });
            return;
        }else{

            var q = 'addMeterial';
            $.ajax({

                type: "POST",
                url: "../db/DbFunctions",
                data: {info: info, q: q},
                success: function (data) {

                    if (data == 'success') {

                        Snackbar.show({
                            text: 'meterial add success',
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 3000);


                    } else {
                        Snackbar.show({
                            text: 'meterial add failed',
                            actionTextColor: '#fff',
                            backgroundColor: '#e7515a',
                            pos: 'top-center',
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }

                }
            });

        }



    }

    //----------------- add tech attributes ------//

    function addTechAtt(){

    var info =[];

    var soid = "<?php echo $sod; ?>";
    var val  = document.getElementById("tAttvalue").value;
    var att = document.getElementById("cmbtAtt").value;
    var user = "<?php echo $usr; ?>";
    
    if(att == ''){

        Snackbar.show({
            text: 'Attribute Name Required',
            actionTextColor: '#fff',
            backgroundColor: '#e7515a',
            pos: 'top-center',
        });
        return;

    }else if(val == ''){

        Snackbar.show({
            text: 'Attribute Value Required',
            actionTextColor: '#fff',
            backgroundColor: '#e7515a',
            pos: 'top-center',
        });
        return;
        
    }else{

        $("#btnTAtt").prop('disabled', true);

        $.ajax({
        type:"post",
        url:"https://serviceportal.slt.lk/ApiPro/public/updateAttributes",
        data:{soid: soid, val: val, attname:att, user:user},
        success:function(data){

            if(data.error == false){

                Snackbar.show({
                text: 'Attribute add success',
                actionTextColor: '#fff',
                backgroundColor: '#6ccb09',
                pos: 'top-center',
                });

               // $("#btnTAtt").prop('disabled', false);

                setTimeout(function(){window.location.reload();}, 2000);

            }else{

                Snackbar.show({
                    text: data.message,
                    actionTextColor: '#fff',
                    backgroundColor: '#6ccb09',
                    pos: 'top-center',
                });

            }
        
            }
        });

    }



    }

    //-------------------------------------------//

    //---------------del tech Att --------------//
    function deleteTechAtt(sod,attN){

    var soid = sod;
    var attname = attN;

    $.ajax({
    type:"post",
    url:"https://serviceportal.slt.lk/ApiPro/public/deleteAtt",
    data:{soid: soid, attname:attname},
    success:function(data){

        if(data.error == false){

            Snackbar.show({
            text: 'Attribute Delete success',
            actionTextColor: '#fff',
            backgroundColor: '#6ccb09',
            pos: 'top-center',
            });

            setTimeout(function(){window.location.reload();}, 2000);

        }else{

            Snackbar.show({
                text: data.message,
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });

        }
    
        }
    });
    
    }

    //--------------- end del tech Att --------------//

    function closeSod(){

        var r = confirm("Are you sure you want to Complete ");
        if (r == true) {
            var info =[];

            info[0]="<?php echo $sod; ?>";
            var iptv1= document.getElementById('iptv1').value;
            var iptv2= document.getElementById('iptv2').value;
            var iptv3= document.getElementById('iptv3').value;

            if(iptv1 != ''){
                closeSodIptv(iptv1);
            }
            if(iptv2 != ''){
                closeSodIptv(iptv2);
            }
            if(iptv3 != ''){
                closeSodIptv(iptv3);
            }
            var q = 'closeSod';
            $.ajax({

                type: "POST",
                url: "../db/DbFunctions",
                data: {info: info, q: q},
                success: function (data) {

                    if (data == 'success') {

                        Snackbar.show({
                            text: 'Service Order Completed Success',
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 3000);


                    } else {
                        Snackbar.show({
                            text: 'Service Order Completed failed',
                            actionTextColor: '#fff',
                            backgroundColor: '#e7515a',
                            pos: 'top-center',
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }

                }
            });
        }else {
            location.reload();
            return false;
        }
    }

    function closeSodIptv(sod){

        var info =[];

        info[0]=sod;

        var q = 'closeSod';
        $.ajax({

            type: "POST",
            url: "../db/DbFunctions",
            data: {info: info, q: q},
            success: function (data) {

            }
        });
    }


    function closeReturn(){

        var r = confirm("Are you sure you want to Retrun ");
        if (r == true) {
            var info =[];

            info[0]="<?php echo $sod; ?>";

            var q = 'returnSod';
            $.ajax({

                type: "POST",
                url: "../db/DbFunctions",
                data: {info: info, q: q},
                success: function (data) {

                    if (data == 'success') {

                        Snackbar.show({
                            text: 'Service Order Returned Success',
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                        });
                        setTimeout(function () {
                            window.location='solist.php'
                        }, 3000);


                    } else {
                        Snackbar.show({
                            text: 'Service Order Returned failed',
                            actionTextColor: '#fff',
                            backgroundColor: '#e7515a',
                            pos: 'top-center',
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }

                }
            });
        }else {
            location.reload();
            return false;
        }
    }

    function deleteImg(imgid,imgN){
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Delete Image!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
            if (result.isConfirmed) {

            var soid = <?php echo json_encode($sod); ?>;
            var imgName = imgN;
            
            var info =[];
            info[0]=soid;
            info[1]=imgName;
            info[2]=imgid;

            $.ajax({

                type: "POST",
                url: "../db/DbFunctions",
                data: {info: info, q: "imgDelete"},
                success: function (data) {

                    if (data == 'success') {

                        Snackbar.show({
                            text: 'Image Delete Success',
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                        });

                        setTimeout(function () {
                            location.reload();
                        }, 3000);


                    } else {
                        Snackbar.show({
                            text: 'Image Delete failed',
                            actionTextColor: '#fff',
                            backgroundColor: '#e7515a',
                            pos: 'top-center',
                        });

                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }

                }
            });

        }
        });
    }

</script>

<script>
    var ss = $(".basic").select2({
        tags: true,
    });

    $(document).ready(function() {

        document.getElementById("dash").className = "menu single-menu ";
        document.getElementById("sod").className = "menu single-menu active";
        document.getElementById("datasod").className = "menu single-menu ";
        document.getElementById("quality").className = "menu single-menu ";
        document.getElementById("user").className = "menu single-menu ";
        document.getElementById("invoice").className = "menu single-menu ";
        document.getElementById("doc").className = "menu single-menu "; 

    });

    /--------- image display modal -------//
    window.prettyPrint && prettyPrint();

    var defaultOpts = {
        draggable: true,
        resizable: true,
        movable: true,
        keyboard: true,
        title: true,
        modalWidth: 320,
        modalHeight: 320,
        fixedContent: true,
        fixedModalSize: false,
        initMaximized: false,
        gapThreshold: 0.02,
        ratioThreshold: 0.1,
        minRatio: 0.05,
        maxRatio: 16,
        headToolbar: ['maximize', 'close'],
        footToolbar: ['zoomIn', 'zoomOut', 'fullscreen', 'actualSize', 'rotateRight'],
        multiInstances: true,
        initEvent: 'click',
        initAnimation: true,
        fixedModalPos: false,
        zIndex: 1090,
        dragHandle: '.magnify-modal',
        progressiveLoading: true
    };

    var vm = new Vue({
        el: '#playground',
        data: {
            options: defaultOpts
        },
        methods: {
            changeTheme: function (e) {
                if (e.target.value === '0') {
                    $('.magnify-theme').remove();
                } else if (e.target.value === '1') {
                    $('.magnify-theme').remove();
                    $('head').append('<link class="magnify-theme" href="css/magnify-bezelless-theme.css" rel="stylesheet">');
                } else if (e.target.value === '2') {
                    $('.magnify-theme').remove();
                    $('head').append('<link class="magnify-theme" href="css/magnify-white-theme.css" rel="stylesheet">');
                }
            }
        },
        updated: function () {
            $('[data-magnify]').magnify(this.options);
        }
    });


//---------- start offline ---------------//

loadResonLst();
loadTAttLst();

function checkOffline(){

var info =[];
info[0]= <?php echo json_encode($sod); ?>;
info[1]= <?php echo json_encode($stat); ?>;
info[2]= 1;
var cmbD = '';

Swal.fire({
title: 'Are you sure?',
text: "Do You Want To Proceed In Offline Mode?",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes'
}).then((result) => {
if (result.isConfirmed) {

    //------------- update offline mode active status -----------//
    $.ajax({
        type:"post",
        url:"../db/DbFunctions",
        data:{info:info,q:"addImgUpSt"},
        success:function(data){

        if(data == "success"){

            //----------------update serial No So status---------//

            $.ajax({
            type:"post",
            url:"../db/DbFunctions",
            data:{info:info,q:"upSrlNSo"},
            success:function(data){

            if(data == "success"){

                Snackbar.show({
                    text: 'Offline Mode Enable Success',
                    actionTextColor: '#fff',
                    backgroundColor: '#6ccb09',
                    pos: 'top-center',
                });

                setTimeout(function(){window.location.reload();}, 2000);

            }else{

                Snackbar.show({
                    text: data,
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a',
                    pos: 'top-center',
                });

            }

            }

            });

            //----------------end update serial No So status---------//

        }else{

            Snackbar.show({
                text: data,
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });

        }

        }
    });

    ///------------- end update offline mode active status -----------//

    }

});
}

function loadResonLst(){

var cmbD = '';

$.ajax({
type:"post",
url:"https://serviceportal.slt.lk/ApiPro/public/getReasonList",
success:function(data){

    cmbD += '<option value="">--Return Reason--</option>';

    $.each(data.data, function(key, data) {

        cmbD += '<option value="'+data.REASON+'">'+data.REASON+'</option>';

    });

    $('#rtreson').html(cmbD);
    $('#rtresonall').html(cmbD);

    }
});

}

function disPwlevl(){

var rtreson = $('#rtresonall').val();

if(rtreson == 'POWER LEVEL ISSUE'){

    $("#pwlevel").css("display", "block");

} 

}

function processOrder(){

chkiptv = document.getElementById('chkiptv'); 
chkbb = document.getElementById('chkbb'); 
chksodrtn = document.getElementById('chksodrtn');
chkFdpchg = document.getElementById('chkFdpchg');
var cfdp = $('#txtcfdp').val();
var cLoop = $('#txtcLoop').val();

var soid = <?php echo json_encode($sod); ?>;

var info =[];
info[0]= <?php echo json_encode($sod); ?>;
info[1]= <?php echo json_encode($stat); ?>;

if(chksodrtn.checked) {

    info[2]= '';

}else{

    info[2]= 2;

}

Swal.fire({
title: 'Are you sure?',
text: "Do You Want To Proceed?",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes'
}).then((result) => {
if (result.isConfirmed) {

if(chkiptv.checked) {

    var svtype = 'E-IPTV FTTH';
    var linetype = 1;

}

if(chkbb.checked) {

    var svtype = 'BB-INTERNET FTTH';
    var linetype = '';

}

if(chkiptv.checked) {

    var rtreson = $('#rtreson').val();

    if(rtreson == ''){

        Snackbar.show({
            text: 'Return Reason Required!',
            actionTextColor: '#fff',
            backgroundColor: '#e7515a',
            pos: 'top-center',
        });

    }else if(chkFdpchg.checked == true && (cfdp == '' || cLoop == '')){

        if(cfdp == ''){

            Snackbar.show({
            text: 'FDP Required!',
            actionTextColor: '#fff',
            backgroundColor: '#e7515a',
            pos: 'top-center',
            });

        }

        if(cLoop == ''){

            Snackbar.show({
            text: 'FDP LOOP Required!',
            actionTextColor: '#fff',
            backgroundColor: '#e7515a',
            pos: 'top-center',
            });

        }
        
    }else{

    //------------- update customer comfirmation status -----------//
    $.ajax({
        type:"post",
        url:"../db/DbFunctions",
        data:{info:info,q:"addImgUpSt"},
        success:function(data){

        if(data == "success"){

            $.ajax({
            type:"post",
            url:"https://serviceportal.slt.lk/ApiPro/public/updateCancelledSo",
            data:{soid:soid,svtype:svtype,linetype:linetype,reason:rtreson},
            success:function(data){

                if(data.error == false){

                    var stat = 2;

                    $.ajax({
                    type:"post",
                    url:"https://serviceportal.slt.lk/ApiPro/public/updateSoStatusWeb",
                    data:{soid:soid,status:stat},
                    success:function(data){

                        if(data.error == false){

                            upNewFdp();

                        }else{

                            Snackbar.show({
                                text: data.message,
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });

                        }
                    
                        }
                    }); 

                }else{

                    Snackbar.show({
                        text: data.message,
                        actionTextColor: '#fff',
                        backgroundColor: '#6ccb09',
                        pos: 'top-center',
                    });

                }
            
            }
        });

        }else{

            Snackbar.show({
                text: data,
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });

        }

        }
    });

    //------------- end update customer comfirmation status -----------//

    }

}

if(chkbb.checked) {

    var rtreson = $('#rtreson').val();

    if(rtreson == ''){

    Snackbar.show({
        text: 'Return Reason Required!',
        actionTextColor: '#fff',
        backgroundColor: '#e7515a',
        pos: 'top-center',
    });

    }else if(chkFdpchg.checked == true && (cfdp == '' || cLoop == '')){

    if(cfdp == ''){

        Snackbar.show({
        text: 'FDP Required!',
        actionTextColor: '#fff',
        backgroundColor: '#e7515a',
        pos: 'top-center',
        });

    }

    if(cLoop == ''){

        Snackbar.show({
        text: 'FDP LOOP Required!',
        actionTextColor: '#fff',
        backgroundColor: '#e7515a',
        pos: 'top-center',
        });

    }

    }else{

     //------------- update customer comfirmation status -----------//
     $.ajax({
        type:"post",
        url:"../db/DbFunctions",
        data:{info:info,q:"addImgUpSt"},
        success:function(data){

        if(data == "success"){

        $.ajax({
            type:"post",
            url:"https://serviceportal.slt.lk/ApiPro/public/updateCancelledSo",
            data:{soid:soid,svtype:svtype,linetype:linetype,reason:rtreson},
            success:function(data){

                if(data.error == false){

                    var stat = 2;

                    $.ajax({
                    type:"post",
                    url:"https://serviceportal.slt.lk/ApiPro/public/updateSoStatusWeb",
                    data:{soid:soid,status:stat},
                    success:function(data){

                        if(data.error == false){

                            upNewFdp();

                        }else{

                            Snackbar.show({
                                text: data.message,
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });

                        }
                    
                        }
                    });

                }else{

                    Snackbar.show({
                        text: data.message,
                        actionTextColor: '#fff',
                        backgroundColor: '#6ccb09',
                        pos: 'top-center',
                    });

                }
            
            }
        });
        
        }else{

            Snackbar.show({
                text: data.message,
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });

        }

       }
    });

    //------------- end update customer comfirmation status -----------//

    }

}

if(chksodrtn.checked) {

    var rtreson = $('#rtresonall').val();
    var pwLevel = $('#pwlevel').val();
    var rtcmtall = $('#rtcmtall').val();
    var uname = <?php echo json_encode($usr); ?>;

    if(rtreson == ''){

    Snackbar.show({
        text: 'Return Reason Required!',
        actionTextColor: '#fff',
        backgroundColor: '#e7515a',
        pos: 'top-center',
    });

    }else{

    //------------- update customer comfirmation status -----------//
    $.ajax({
        type:"post",
        url:"../db/DbFunctions",
        data:{info:info,q:"addImgUpSt"},
        success:function(data){

        if(data == "success"){

        if(rtreson == 'POWER LEVEL ISSUE'){

        if(pwLevel != ''){

            $.ajax({
            type:"post",
            url:"https://serviceportal.slt.lk/ApiPro/public/updateAttributes",
            data:{soid:soid,val:pwLevel,user:uname,attname:'POWER LEVEL'},
            success:function(data){

                //-----------Cancel main sod----------------//
                $.ajax({
                    type:"post",
                    url:"https://serviceportal.slt.lk/ApiPro/public/cancellMainSO",
                    data:{soid:soid,reason:rtreson,com:rtcmtall},
                    success:function(data1){

                        if(data.error == false){

                            Snackbar.show({
                                text: data1.message,
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });

                            upsodCAll();

                           // setTimeout(function(){window.location.reload();}, 2000);

                        }else{

                            Snackbar.show({
                                text: data1.message,
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });

                        }
                    
                    }
                });

                //-----------end Cancel main sod----------------//

                }
            });

        }else{

            Snackbar.show({
                text: 'Power Level Required!',
                actionTextColor: '#fff',
                backgroundColor: '#6ccb09',
                pos: 'top-center',
            });

        }

    }else{

        $.ajax({
            type:"post",
            url:"https://serviceportal.slt.lk/ApiPro/public/cancellMainSO",
            data:{soid:soid,reason:rtreson,com:rtcmtall},
            success:function(data){

                if(data.error == false){

                    Snackbar.show({
                        text: data.message,
                        actionTextColor: '#fff',
                        backgroundColor: '#6ccb09',
                        pos: 'top-center',
                    });

                    upsodCAll();

                    //setTimeout(function(){window.location.reload();}, 2000);

                }else{

                    Snackbar.show({
                        text: data.message,
                        actionTextColor: '#fff',
                        backgroundColor: '#6ccb09',
                        pos: 'top-center',
                    });

                }
            
            }
        });

        }

        }else{

            Snackbar.show({
                text: data.message,
                actionTextColor: '#fff',
                backgroundColor: '#6ccb09',
                pos: 'top-center',
            });

        }
    }
    });

    //------------- end update customer comfirmation status -----------//

    }

}

//------------- check false all checkboxes------------------//
if(chksodrtn.checked == false && chkbb.checked == false && chkiptv.checked == false) {

    var stat = 2;

    if(chkFdpchg.checked == true && (cfdp == '' || cLoop == '')){

    if(cfdp == ''){

        Snackbar.show({
        text: 'FDP Required!',
        actionTextColor: '#fff',
        backgroundColor: '#e7515a',
        pos: 'top-center',
        });

    }

    if(cLoop == ''){

        Snackbar.show({
        text: 'FDP LOOP Required!',
        actionTextColor: '#fff',
        backgroundColor: '#e7515a',
        pos: 'top-center',
        });

    }

    }else{

    //------------- update customer comfirmation status -----------//
    $.ajax({
        type:"post",
        url:"../db/DbFunctions",
        data:{info:info,q:"addImgUpSt"},
        success:function(data){

        if(data == "success"){

            $.ajax({
            type:"post",
            url:"https://serviceportal.slt.lk/ApiPro/public/updateSoStatusWeb",
            data:{soid:soid,status:stat},
            success:function(data){

                if(data.error == false){

                    upNewFdp();

                }else{

                    Snackbar.show({
                        text: data.message,
                        actionTextColor: '#fff',
                        backgroundColor: '#6ccb09',
                        pos: 'top-center',
                    });

                }
            
                }
            });

        }else{

            Snackbar.show({
                text: data,
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });

        }

        }
    });

    //------------- end update customer comfirmation status -----------//

    }

}

//------------- end check false all checkboxes------------------//

}

});

}

function upsodCAll(){

var info =[];
info[0]= <?php echo json_encode($sod); ?>;

$.ajax({
type: "POST",
url: "../db/DbFunctions",
data: {info: info, q: "upsodCAllStat"},
success: function (data) {

    if(data == 'success'){

        Snackbar.show({
        text: data,
        actionTextColor: '#fff',
        backgroundColor: '#6ccb09',
        pos: 'top-center',   
        });

        setTimeout(function(){window.close();}, 2000);

    }else{

        Snackbar.show({
            text: data,
            actionTextColor: '#fff',
            backgroundColor: '#e7515a',
            pos: 'top-center',
        });

    }

    }
});

}

function upNewFdp(){

var soid = <?php echo json_encode($sod); ?>;
var cfdp = $('#txtcfdp').val();
var cLoop = $('#txtcLoop').val();

    if(cfdp != '' &&  cLoop != ''){

    $.ajax({
        type:"post",
        url:"https://serviceportal.slt.lk/ApiPro/public/updateNewFdp",
        data:{soid:soid,fdp:cfdp,loop:cLoop},
        success:function(data){

            if(data.error == false){

                Snackbar.show({
                    text: data.message,
                    actionTextColor: '#fff',
                    backgroundColor: '#6ccb09',
                    pos: 'top-center',
                });

                setTimeout(function(){window.location.reload();}, 2000);

            }else{

                Snackbar.show({
                    text: data.message,
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a',
                    pos: 'top-center',
                });

            }
        
        }
    });

    }else{

        Snackbar.show({
            text: 'Success',
            actionTextColor: '#fff',
            backgroundColor: '#6ccb09',
            pos: 'top-center',
        });

        setTimeout(function(){window.location.reload();}, 2000);
    }

}


function chkIptv(){

chkiptv = document.getElementById('chkiptv');

if(chkiptv.checked) {
    
    $("#chkbb").attr("disabled", true);
    $("#chksodrtn").attr("disabled", true);
    $("#rtreson").css("display", "block");
    // $("#rtcmt").css("display", "block");
    $("#rtresonall").css("display", "none");
    $("#rtcmtall").css("display", "none");
    $("#pwlevel").css("display", "none");
    
}else{

    $("#chkbb").attr("disabled", false);
    $("#chksodrtn").attr("disabled", false);
    $("#rtreson").css("display", "none");
    // $("#rtcmt").css("display", "none");
    $("#rtresonall").css("display", "none");
    $("#rtcmtall").css("display", "none");
    $("#pwlevel").css("display", "none");
}

}

function chkBB(){

if(chkbb.checked) {

    $("#chkiptv").attr("disabled", true);
    $("#chksodrtn").attr("disabled", true);
    $("#rtreson").css("display", "block");
    // $("#rtcmt").css("display", "block");
    $("#rtresonall").css("display", "none");
    $("#rtcmtall").css("display", "none");
    $("#pwlevel").css("display", "none");

}else{

    $("#chkiptv").attr("disabled", false);
    $("#chksodrtn").attr("disabled", false);
    $("#rtreson").css("display", "none");
    // $("#rtcmt").css("display", "none");
    $("#rtresonall").css("display", "none");
    $("#rtcmtall").css("display", "none");
    $("#pwlevel").css("display", "none");
}

}

function chkSod(){

chksodrtn = document.getElementById('chksodrtn');

if(chksodrtn.checked) {

    $("#chkbb").attr("disabled", true);
    $("#chkiptv").attr("disabled", true);
    $("#chkFdpchg").attr("disabled", true);
    $("#rtreson").css("display", "none");
    // $("#rtcmt").css("display", "none");
    $("#rtresonall").css("display", "block");
    $("#rtcmtall").css("display", "block");
    $("#pwlevel").css("display", "none");

}else{

    $("#chkbb").attr("disabled", false);
    $("#chkiptv").attr("disabled", false);
    $("#chkFdpchg").attr("disabled", false);
    $("#rtreson").css("display", "none");
    // $("#rtcmt").css("display", "none");
    $("#rtresonall").css("display", "none");
    $("#rtcmtall").css("display", "none");
    $("#pwlevel").css("display", "none");

}

}

function imgUpload(imgid){

var soid = <?php echo json_encode($sod); ?>;
var imgN = $('#'+imgid+'imgN').val();
var imgF = document.getElementById(imgid+"img_file");
var imgDN = $('#'+imgid+'imgDN').val();
var lon = '';
var lat = '';

if(imgF.files.length == 0){

    Snackbar.show({
        text: 'Image Required!',
        actionTextColor: '#fff',
        backgroundColor: '#e7515a',
        pos: 'top-center',
    });

}else{

    for (i = 0; i < imgF.files.length; i++) {

    let imgFile = imgF.files[i];

    formdata = new FormData();
    formdata.append("location", soid);
    formdata.append("desc", imgN);
    formdata.append("image",imgF.files[i]);

    $.ajax({
        type:"post",
        url:"https://serviceportal.slt.lk/ApiPro/ImageApi/ApiImage.php",
        cache: false,
        contentType: false,
        processData: false,
        data: formdata, 
        success:function(data){

        var json = $.parseJSON(data);

        if(json.error == false){

            //-------------start save img record--------------//

            formdata2 = new FormData();
            formdata2.append("soid", soid);
            formdata2.append("imgdisname", imgDN);
            formdata2.append("lon", lon);
            formdata2.append("lat", lat);
            formdata2.append("imgname",imgN);

            $.ajax({
                type:"post",
                url:"https://serviceportal.slt.lk/ApiPro/public/updateImg",
                cache: false,
                contentType: false,
                processData: false,
                data: formdata2, 
                success:function(data){

                    if(data.error == false){

                        Snackbar.show({
                            text: json.message,
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                        });

                        setTimeout(function(){window.location.reload();}, 2000);

                    }else{

                        Snackbar.show({
                            text: json.message,
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                        });

                    }

                }
            });

            //-------------end save img record--------------//

        }else{

            Snackbar.show({
                text: json.message,
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });

        }

        }
    });

    }

}

}

function validateSerial(){

var tbl = document.getElementById('tbloflnSr');
var rowCount = $('#tbloflnSr tr').length;
var tbl2 = document.getElementById('tbloflnIptv');
var rowCount2 = $('#tbloflnIptv tr').length;
var ontsn = $('#txtont').val();

var stbres1=0;
var stbsrc1=0;
var stbres2=0;
var stbsrc2=0;

Swal.fire({
title: 'Are you sure?',
text: "Do You Want To Proceed?",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes'
}).then((result) => {
if (result.isConfirmed) {

//------------validate stb serial ------------//
for(var n=0; n < rowCount; n++){

var stbtext = tbl.rows[n].cells[1].innerHTML;
var stbsr = tbl.rows[n].cells[2].childNodes[0].value;

if(stbsr == ''){

    stbsrc1++;

}

var resstb = validateSTB(stbsr);

if(resstb == false){

    stbres1++;

}

}

if(stbsrc1>0){

Snackbar.show({
    text: 'Telephone Serial Required!',
    actionTextColor: '#fff',
    backgroundColor: '#e7515a',
    pos: 'top-center',
});

}

if(stbres1>0){

Snackbar.show({
    text: 'Invalid STB Serial!',
    actionTextColor: '#fff',
    backgroundColor: '#e7515a',
    pos: 'top-center',
});

}

//------------end validate stb serial ------------//

//------------validate iptv serial ------------//
for(var a=0; a < rowCount2; a++){

var stbtext = tbl2.rows[a].cells[1].innerHTML;
var stbsr = tbl2.rows[a].cells[2].childNodes[0].value;

if(stbsr == ''){

    stbsrc2++;

}

var resstb = validateSTB(stbsr);

if(resstb == false){

    stbres2++;

}

}

if(stbsrc2>0){

Snackbar.show({
    text: 'PeoTv STB MAC S/N Required!',
    actionTextColor: '#fff',
    backgroundColor: '#e7515a',
    pos: 'top-center',
});

}

if(stbres2>0){

Snackbar.show({
    text: 'Invalid PeoTv STB MAC S/N!',
    actionTextColor: '#fff',
    backgroundColor: '#e7515a',
    pos: 'top-center',
});

}

//------------end validate iptv serial ------------//

//--------------validate ont serial------//
if(ontsn == ''){

Snackbar.show({
    text: 'ONT Serial Required',
    actionTextColor: '#fff',
    backgroundColor: '#e7515a',
    pos: 'top-center',
});

}else{

var resont = validateONT(ontsn);

if(resont == false){

    Snackbar.show({
        text: 'Invalid ONT Serial',
        actionTextColor: '#fff',
        backgroundColor: '#e7515a',
        pos: 'top-center',
    });

}

}
//--------------end validate ont serial------//

if(stbres1 == 0 && stbsrc1 == 0 && stbres2 == 0 && stbsrc2 == 0 && resont == true){

saveSerial();

}

}

});

}

function saveSerial(){

var ontsn = $('#txtont').val();
var soid = <?php echo json_encode($sod); ?>;
var ontTyp = 'ONT_ROUTER_SERIAL_NUMBER';
var tbl = document.getElementById('tbloflnSr');
var rowCount = $('#tbloflnSr tr').length;
var tbl2 = document.getElementById('tbloflnIptv');
var rowCount2 = $('#tbloflnIptv tr').length;

//------------ins telephone sn--------------//
for(var n=0; n < rowCount; n++){

    var stbtext = tbl.rows[n].cells[1].innerHTML;
    var stbsr = tbl.rows[n].cells[2].childNodes[0].value;
    var stbTyp = 'VOICE_CPE_SERIAL_NUMBER_'+n;

    if(stbsr != ''){

        $.ajax({
        type:"post",
        url:"https://serviceportal.slt.lk/ApiPro/public/insertSN",
        data:{soid:soid,type:stbTyp,sn:stbsr},
        success:function(data){

            if(data.error == false){

                Snackbar.show({
                    text: data.message,
                    actionTextColor: '#fff',
                    backgroundColor: '#6ccb09',
                    pos: 'top-center',
                });

            }else{

                Snackbar.show({
                    text: data.message,
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a',
                    pos: 'top-center',
                });

            }
        
        }
    });

    }

}

//------------ end ins telephone sn--------------//

//------------ins iptv sn--------------//
for(var a=0; a < rowCount2; a++){

var stbtext = tbl2.rows[a].cells[1].innerHTML;
var stbsr = tbl2.rows[a].cells[2].childNodes[0].value;
var stbTyp = 'IPTV_CPE_SERIAL_NUMBER_'+n;

if(stbsr != ''){

    $.ajax({
    type:"post",
    url:"https://serviceportal.slt.lk/ApiPro/public/insertSN",
    data:{soid:soid,type:stbTyp,sn:stbsr},
    success:function(data){

        if(data.error == false){

            Snackbar.show({
                text: data.message,
                actionTextColor: '#fff',
                backgroundColor: '#6ccb09',
                pos: 'top-center',
            });

        }else{

            Snackbar.show({
                text: data.message,
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });

        }
    
    }
});

}

}

//------------end ins iptv sn--------------//

if(ontsn != ''){

    $.ajax({
        type:"post",
        url:"https://serviceportal.slt.lk/ApiPro/public/insertSN",
        data:{soid:soid,type:ontTyp,sn:ontsn},
        success:function(data){

            if(data.error == false){

                Snackbar.show({
                    text: data.message,
                    actionTextColor: '#fff',
                    backgroundColor: '#6ccb09',
                    pos: 'top-center',
                });

            }else{

                Snackbar.show({
                    text: data.message,
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a',
                    pos: 'top-center',
                });

            }
        
        }
    });

}

upsodst();

}

function upsodst(){

var info =[];
info[0]= <?php echo json_encode($sod); ?>;
info[1]= <?php echo json_encode($stat); ?>;
info[2]= 3;

//------------- update offline mode serial No status -----------//
    $.ajax({
    type:"post",
    url:"../db/DbFunctions",
    data:{info:info,q:"addImgUpSt"},
    success:function(data){

        if(data == "success"){

            $.ajax({
            type: "POST",
            url: "../db/DbFunctions",
            data: {info: info, q: "upSodStatus"},
            success: function (data) {

                if(data == 'success'){

                    Snackbar.show({
                    text: data,
                    actionTextColor: '#fff',
                    backgroundColor: '#6ccb09',
                    pos: 'top-center',   
                    });

                    setTimeout(function(){window.location.reload();}, 2000);

                }else{

                    Snackbar.show({
                        text: data,
                        actionTextColor: '#fff',
                        backgroundColor: '#e7515a',
                        pos: 'top-center',
                    });

                }

                }
            });

        }else{

            Snackbar.show({
                text: data,
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });

        }

        }
    });

//------------- end update offline mode serial No status -----------//

}

function validateONT(sn) {

if (sn.startsWith('4857', 0)) {
return true;
}

if (sn.startsWith('ZTE', 0)) {
return true;
}

if (sn.startsWith('ALCL', 0)) {
return true;
}
return false;

}

function validateSTB(mac) {

if (mac.startsWith('000430', 0)) {
return true;
}

if (mac.startsWith('0CF0B4', 0)) {
return true;
}

if (mac.startsWith('980637', 0)) {
return true;
}

if (mac.startsWith('FCD5D9', 0)) {
return true;
}

return false;

}

function fdptxtEnable(){

    chkFdpchg = document.getElementById('chkFdpchg');

    if(chkFdpchg.checked == true){

        document.getElementById("txtcfdp").disabled = false;
        document.getElementById("txtcLoop").disabled = false;

    }else{

        document.getElementById("txtcfdp").disabled = true;
        document.getElementById("txtcLoop").disabled = true;

    }
}

function CmptIntTask(){

var info =[];
info[0]= <?php echo json_encode($sod); ?>;
info[1]= <?php echo json_encode($stat); ?>;
info[2]= 4;

Swal.fire({
title: 'Are you Confirm?',
text: "Drop Wire Length & Pole Count Cannot Be Update After Proceed!",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes'
}).then((result) => {
if (result.isConfirmed) {

//------------- update offline mode complete intallation task status -----------//

    $.ajax({
        type:"post",
        url:"../db/DbFunctions",
        data:{info:info,q:"addImgUpSt"},
        success:function(data){

        if(data == "success"){

            $.ajax({
            type: "POST",
            url: "../db/DbFunctions",
            data: {info: info, q: "upSodConInstTask"},
            success: function (data) {

                if(data == 'success'){

                    Snackbar.show({
                    text: data,
                    actionTextColor: '#fff',
                    backgroundColor: '#6ccb09',
                    pos: 'top-center',   
                    });

                    setTimeout(function(){window.close();}, 2000);

                }else{

                    Snackbar.show({
                        text: data,
                        actionTextColor: '#fff',
                        backgroundColor: '#e7515a',
                        pos: 'top-center',
                    });

                }

                }
            });

        }else{

            Snackbar.show({
                text: data,
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'top-center',
            });

        }

        }
    });

    //------------- end update offline mode complete intallation task status -----------//
    
    }

});

}

//------------load tech Attributes list -------------//

function loadTAttLst(){

var soid = <?php echo json_encode($sod); ?>;

var cmbD = '';

$.ajax({
type:"post",
url:"https://serviceportal.slt.lk/ApiPro/public/getFTTHAttList",
data:{soid:soid},
success:function(data){

    cmbD += '<option value="">--Attribute Name--</option>';

    $.each(data.data, function(key, data) {

        cmbD += '<option value="'+data.ATT_NAME+'">'+data.ATT_NAME+'</option>';

    });

    $('#cmbtAtt').html(cmbD);

    }
});

}

</script>

<!-- popup box -->
<div id="myModal" class="modal">
    <div class="modal-dialog" style="max-width: 1200px;">
        <div class="modal-content" style="max-width: 1200px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title1"></h4>
            </div>
            <div class="modal-body" id="frm_body">

            </div>
        </div>
    </div>
</div>
<!-- end popup box -->
<!-- JAVASCRIPT --->
</body>
</html>




