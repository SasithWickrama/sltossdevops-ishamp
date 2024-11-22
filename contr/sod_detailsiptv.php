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

                <?php $getSodImgupSt = $db->getSodImgupSt($sod,$stat); ?>

                <div class="page-title">
                    <h4>CONNECTION DETAIL - <span style="color: blue; font-size: larger; font-weight: bold"><?php echo $circuit; ?></span><span style="color: #f39c12;font-weight:bold "><?php if($getSodImgupSt[0] == 'Y'){ echo ' (OFFLINE)'; }?></span></h4>
                </div>


                    <button class="btn btn-success mb-4" style="height: 40px;"  onclick="closeSod()">COMPLETED</button>




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





                                        </div>


                                        <!--    ==============================   -->
                                    </div>

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

    function deleteMeterial(sod,udesig,metid){

        var info =[];

        info[0]=sod;
        info[1]=udesig;
        info[2]=metid;

        var q = 'deleteMet';
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
                    setTimeout(function () {
                        location.reload();
                    }, 3000);


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

    function checkOffline(){

        var info =[];
        info[0]= <?php echo json_encode($sod); ?>;
        info[1]= <?php echo json_encode($stat); ?>;

        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Select Offline Image Upload!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {

                var des = '';

                des +='<div class="card">'+
                    '<div class="card-header ">'+
                    '<h2 style="font-weight: bold; font-size:large">CUSTOMER CONFIRMATION</h2>'+
                    '</div>'+

                    '<div class="card-body ">'+
                    '<div class="row" style="font-size: 15px; padding-left: 20px; font-weight: bold">'+
                    '<table class="table table-stripe">'+
                    '<tr><td colspan="2">Service Return</td></tr>'+
                    '<tr><td><input type="checkbox" id="chkiptv" onclick="checkreturn();"> IPTV</td><td><input type="checkbox" id="chkbb"> BB-INTERNET</td></tr>'+
                    '<tr><td colspan="2"><input type="checkbox" id="chksodrtn"> SOD RETURN</td></tr>'+
                    '<tr><td colspan="2"><button class="btn btn-success btn-sm float-right"><i class="fa fa-gear"></i> PROCEED</button></td></tr>'+
                    '</table></div></div></div>';

                $('#frm_body').html(des);

                $("#myModal").modal('show');

                // $.ajax({
                // type:"post",
                // url:"../db/DbFunctions",
                // data:{info:info,q:"loadServices"},
                // success:function(data){



                // des +='<div class="card">'+
                //         '<div class="card-header ">'+
                //             '<h2 style="font-weight: bold; font-size:large">CUSTOMER CONFIRMATION</h2>'+
                //         '</div>'+

                //         '<div class="card-body ">'+
                //         '<div class="row" style="font-size: 15px; padding-left: 20px; font-weight: bold">'+
                //         '<table>';

                //         $.each(data, function(key, data) {

                //         des +='<tr><td>'+data[1]+'</td><td></td></tr>';


                //         });

                //         des +='</table></div></div></div>';

                //     $('#frm_body').html(des);

                //     $("#myModal").modal('show');

                //     }

                // });

                // $.ajax({
                // type:"post",
                // url:"../db/DbFunctions",
                // data:{info:info,q:"addImgUpSt"},
                // success:function(data){

                //     if(data == "success"){

                //         Snackbar.show({
                //             text: 'Status Save Success',
                //             actionTextColor: '#fff',
                //             backgroundColor: '#6ccb09',
                //             pos: 'top-center',
                //         });

                //         setTimeout(function(){window.location.reload();}, 2000);

                //     }else{

                //         Snackbar.show({
                //             text: data,
                //             actionTextColor: '#fff',
                //             backgroundColor: '#e7515a',
                //             pos: 'top-center',
                //         });

                //     }

                //     }
                // });


            }

        });
    }

    function imgUpload(imgid){

        var soid = <?php echo json_encode($sod); ?>;
        var imgN = $('#'+imgid+'imgN').val();
        var imgF = document.getElementById(imgid+"img_file");
        var imgDN = $('#'+imgid+'imgDN').val();
        var lon = '';
        var lat = '';

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

</script>

<!-- popup box -->
<div id="myModal" class="modal">
    <div class="modal-dialog" style="max-width: 700px;">
        <div class="modal-content" style="max-width: 700px;">
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





