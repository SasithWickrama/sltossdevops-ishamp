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

    $sod = $_GET['sod'];

    $getSn = $db->getSn($sod);
    $getLog = $db->getLog($sod);

    $b = $i1 = $i2 = $i3 = $v2= '0';
    $bb = $iptv1 = $iptv2 = $iptv3 = $voice2 = '';

    $row = $db->getSodAll($sod);

    $ftth_data= $db->ftth_data($sod);
    $getBearerMap = $db->getBearerMap($sod);
    $getFtthDW = $db->getFtthDW($sod);
    $getPoleCount = $db->getPoleCount($sod);
    $getPoles= $db->getPoles($sod);
    $getPolemet= $db->getPolemet($sod);
    //$getOthers= $db->getOthers($sod);
    $getOtherMet= $db->getOtherMet($sod);


    $getSnAssign= $db->getSnAssign($sod);


    $sval = '000000';




    $rtom= $row[0];
    $circuit= $row[2];
    $order = $row[4];
    $task = $row[13];

    $lea  =$row[20];

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

    $stat = $row[24];
    $stype  =  $row[3];

    if($stat == 'RETURN_SLT' || $stat == 'RETURN_CLOSED'){
        if($row[13] == 'CONSTRUCT_OSP'){
            $getRetReason = $db->getRetReason($sod,'const');
        }
        if($row[13] == 'RECONSTRUCT_OSP'){
            $getRetReason = $db->getRetReason($sod,'reconst');
        }
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
            width: 50%; /* Full width */
            height: 50%; /* Full height */
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

            <br/>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-8">
                            <h4>CONNECTION DETAIL - <span style="color: blue; font-size: larger; font-weight: bold"><?php echo $circuit;?></span></h4>
                    </div>
                <?php if($row[24] == 'ASSIGNED' || $row[24] == 'INPROGRESS'){ ?>
                    <div class="col-lg-2 col-md-6 col-sm-8">
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-8">

                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-8">
                    <button class="btn-info" style="width: 130px; height: 35px; border-radius: 5px; font-weight: bold;" onclick="returnbck('CHANGE')">CHANGE CON</button>
                </div>
                <?php } ?>
                <?php if($row[24] == 'RETURN_SLT'){ ?>
                    <div class="col-lg-1 col-md-6 col-sm-8">
                        <button class="btn-danger" style="width: 130px; height: 35px; border-radius: 5px; font-weight: bold;" onclick="returnbck('OSS')">RETURN TO OSS</button>
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-1">
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-8">
                        <button class="btn-success" style="width: 130px; height: 35px; border-radius: 5px; font-weight: bold;" onclick="returnbck('SAME')">SAME CON</button>
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-1">
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-8">
                        <button class="btn-info" style="width: 130px; height: 35px; border-radius: 5px; font-weight: bold;" onclick="returnbck('CHANGE')">CHANGE CON</button>
                    </div>
                        <?php } ?>
                <?php if($row[24] == 'COMPLETED' || $row[24] == 'INSTALL_CLOSED'){ ?>
                    <div class="col-lg-2 col-md-6 col-sm-8">
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-8">
                        <button class="btn-success" style="width: 30px; height: 30px; border-radius: 50%" disabled></button>
                    </div>

                <?php } ?>
                </div>
            <hr/>

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

                                        <?php if ($stype == 'AB-FTTH') { ?>
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
                                            <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                <label style="color: #0dcaf0">CONTRACTOR</label><br/>
                                                <label><?php echo $row[25]; ?></label>
                                            </div>

                                            <?php if($stype == 'AB-FTTH'){ ?>
                                                <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                    <label style="color: #0dcaf0">OLT MANUFACTURER</label><br/>
                                                    <label><?php echo $ftth_data[6]; ?></label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                    <label style="color: #0dcaf0">DESCRIPTION</label><br/>
                                                    <label><?php echo $row[18]; ?></label>
                                                </div>
                                            <?php }else {  ?>
                                                <div class="col-lg-6 col-md-6 col-sm-8  mr-auto">
                                                    <label style="color: #0dcaf0">DESCRIPTION</label><br/>
                                                    <label><?php echo $row[18]; ?></label>
                                                </div>

                                            <?php }?>

                                        </div>
                                        <hr/>
                                        <?php } ?>

                                        <?php if ($stype == 'E-IPTV FTTH') { ?>
                                            <div class="row" style="font-size: 15px; font-weight: bold">
                                                <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                    <label style="color: #0dcaf0">PACKAGE</label><br/>
                                                    <label id="pkg"><?php echo $row[23]; ?></label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                    <label style="color: #0dcaf0">CONTRACTOR</label><br/>
                                                    <label><?php echo $row[25]; ?></label>
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
                                                    <label style="color: #0dcaf0">MSAN</label><br/>
                                                    <label><?php echo $row[9]; ?></label>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                    <label style="color: #0dcaf0">PORT</label><br/>
                                                    <label><?php echo $row[10]; ?></label>
                                                </div>

                                                <?php if($stype == 'AB-FTTH'){ ?>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">OLT MANUFACTURER</label><br/>
                                                        <label><?php echo $ftth_data[6]; ?></label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">DESCRIPTION</label><br/>
                                                        <label><?php echo $row[18]; ?></label>
                                                    </div>
                                                <?php }else {  ?>
                                                    <div class="col-lg-6 col-md-6 col-sm-8  mr-auto">
                                                        <label style="color: #0dcaf0">DESCRIPTION</label><br/>
                                                        <label><?php echo $row[18]; ?></label>
                                                    </div>

                                                <?php }?>

                                            </div>
                                            <hr/>
                                        <?php } ?>



                                    </div>


                                    <!--    ==============================   -->
                                </div>

                                <br/>
                                <?php if ($stype == 'AB-FTTH') { ?>
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
                                <!--    ==============================   -->

                                <?php if($stat == 'RETURN_SLT' || $stat == 'RETURN_CLOSED'){ ?>
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

                                <!--  ================================ -->

                                <?php if($stat=='ASSIGNED' || $stat=='INPROGRESS' || $stat=='RETURN_SLT'){  ?>
                                    <div class="card">
                                        <div class="card-header ">
                                            <a href="#" style="font-weight: bold; font-size:large">CHANGE CONTRACTOR</a>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                                    <select class="form-control  basic" name="conname" id="conname" required>
                                                        <option value="">Select Contractor ...</option>
                                                        <?php
                                                        $getCont = $db->getCont();
                                                        foreach( $getCont as $row ) {
                                                            ?>
                                                            <option value="<?php echo $row[0]; ?>" ><?php echo $row[0]; ?> </option>


                                                        <?php } ?>


                                                    </select>
                                                </div>


                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                                    <input id="comment"  value="" class="form-control " type="text" placeholder="Comment..." style="height: 40px;">
                                                </div>

                                            </div>
                                        </div><br/>




                                        <!--    ==============================   -->
                                    </div>

                                    <br/>
                                <?php }?>

                            </div>

                            <!--- -->
                            <div class="tab-pane fade" id="sn" role="tabpanel" aria-labelledby="border-top-profile-tab">
                                <div class="card">
                                    <div class="card-header ">
                                        <a href="#" style="font-weight: bold; font-size:large">MOBILE TEAM DETAILS</a>
                                    </div>

                                    <div class="card-body ">

                                        <div class="row">
                                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                                <label style="color: #0dcaf0">MOBILE TEAM</label><br/>
                                                <label id="rtom"><?php echo $getSnAssign[11]; ?></label>

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
                                        </div><hr/>

                                    </div>

                                </div>
                                <br/>
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
                            </div>

                            <!--- -->
                            <div class="tab-pane fade" id="met" role="tabpanel" aria-labelledby="border-top-contact-tab">
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
                                                        <div class="col-lg-6 col-md-6 col-sm-8  mr-auto">
                                                        </div>
                                                    </div>
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

                                                </div><br/><br/><br/>

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
                                                        <div class="col-lg-4 col-md-6 col-sm-8  mr-auto">
                                                        </div>
                                                    </div>

                                                <?php } ?><br/><hr/><br/>



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
                                                                <div class="col-lg-4 col-md-6 col-sm-8  mr-auto">
                                                                </div>
                                                            </div>

                                                        <?php } ?>

                                                    </div>

                                                </div><br/>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--- -->
                            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="border-top-contact-tab">
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
                                                <div class="col-lg-12 col-md-12 col-sm-8  mr-auto center"><label style="color: #0dcaf0" title="<?php echo $loadImg[2]; ?>"><?php echo $loadImg[2]; ?></label></div>
                                                <input type="hidden" value="<?php echo $upimgN; ?>" id="<?php echo $row[0].'imgN'; ?>">
                                                <input type="hidden" value="<?php echo $row[1]; ?>" id="<?php echo $row[0].'imgDN'; ?>">
                                                <input type="hidden" value="<?php echo $loadImg[0]; ?>" id="<?php echo $row[0].'limg'; ?>">
                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto image-set">
                                                    <a data-magnify="gallery" data-src="" data-group="a" title="<?php echo $loadImg[2]; ?>" href="<?php echo $img_url; ?>">
                                                        <img class="modal2-content" id="1" src="<?php echo $img_url; ?>" width="200" height="200" onerror="this.src='../assets/img/no-image.png'">
                                                    </a>
                                                </div>









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

                            </div></div>

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
    var ss = $(".basic").select2({
        tags: true,
    });


    function returnbck(val){

        //==================
        if ( val == 'OSS') {
            var r = confirm("Are you sure you want Return to OSS");
            if (r == true) {
                var info = [];

                info[0] = "<?php echo $sod; ?>";
                info[1] = "<?php echo $task; ?>";

                var q = 'returnStatus';
                $.ajax({

                    type: "POST",
                    url: "../db/DbFunctions",
                    data: {info: info, q: q},
                    success: function (data) {

                        if (data == 'success') {

                            Snackbar.show({
                                text: 'Success',
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });
                            setTimeout(function () {
                                window.location = 'sod_inbox'
                            }, 3000);


                        } else {
                            Snackbar.show({
                                text: 'failed',
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
            } else {
                location.reload();
                return false;
            }
        }
        //================
        if ( val == 'SAME') {
            var r = confirm("Are you sure you want Return to Same Contractor");
            if (r == true) {
                var info = [];

                info[0] = "<?php echo $sod; ?>";
                info[1] = "<?php echo $task; ?>";

                var q = 'returnSameCon';
                $.ajax({

                    type: "POST",
                    url: "../db/DbFunctions",
                    data: {info: info, q: q},
                    success: function (data) {

                        if (data == 'success') {

                            Snackbar.show({
                                text: 'Success',
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });
                            setTimeout(function () {
                                window.location = 'sod_inbox'
                            }, 3000);


                        } else {
                            Snackbar.show({
                                text: 'failed',
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
            } else {
                location.reload();
                return false;
            }
        }
        //================
        if ( val == 'CHANGE') {
            var r = confirm("Are you sure you want Change the Contractor");
            if (r == true) {
                var info = [];

                info[0] = "<?php echo $sod; ?>";
                info[1] = document.getElementById('conname').value
                info[2] = document.getElementById('comment').value
                info[3] = "<?php echo $task; ?>";
                if(info[1] == ''){
                    Snackbar.show({
                        text: 'Conractor cannot be empty',
                        actionTextColor: '#fff',
                        backgroundColor: '#e7515a',
                        pos: 'top-center',
                    });
                }else{
                    alert('hiii')
                    var q = 'returnChangeCon';
                    $.ajax({

                        type: "POST",
                        url: "../db/DbFunctions",
                        data: {info: info, q: q},
                        success: function (data) {

                            if (data == 'success') {

                                Snackbar.show({
                                    text: 'Success',
                                    actionTextColor: '#fff',
                                    backgroundColor: '#6ccb09',
                                    pos: 'top-center',
                                });
                                setTimeout(function () {
                                    window.location = 'sod_inbox'
                                }, 3000);


                            } else {
                                Snackbar.show({
                                    text: 'failed',
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

            } else {
                location.reload();
                return false;
            }
        }
    }


    $(document).ready(function() {
        document.getElementById("dash").className = "menu single-menu ";
        document.getElementById("sod").className = "menu single-menu active";
        document.getElementById("faults").className = "menu single-menu ";
        document.getElementById("quality").className = "menu single-menu ";
        document.getElementById("inbox").className = "menu single-menu ";
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
</script>

<div id="myModal" class="modal">
    <img class="modal-content" id="img01">
</div>
<!-- JAVASCRIPT --->
</body>
</html>





