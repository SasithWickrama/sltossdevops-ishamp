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
    $rjctImg = $_SESSION["RjctImg"];

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
    $status= $row[24];

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

    if($row[24] =='PAT_REJECTED'){
        $getrejImgcount = $db->getrejImgcount($sod);
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
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.ico"/>
    <title>TechsPro - PAT Details</title>
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

        .textboxstyle{
            height: 20px;
            border: 1px solid #bfc9d4;
            color: #3b3f5c;
            font-size: 13px;
            padding: 5px 8px;
            letter-spacing: 1px;
            height: calc(1.2em + 1.2rem + 1px);
            padding: .75rem 1.25rem;
            border-radius: 6px;
        }

        .btnstyle {
            width:105px;
        }

        .mt-0 {
            padding: 5px; !important;
        }

        .map {
            height: 500PX;
            width: 100%;
            overflow: hidden;
            float: left;
            border: thin solid #333;
        }

        /* img:hover {
        -webkit-transform: scaleX(-1);
        transform: scaleX(-1);
        } */

        .rjborder{
            border-style: solid;
            border-color:  #e74c3c;
        }

        .acptborder{
            border-style: solid;
            border-color: #28b463;
        }

    </style>
</head>
<body class="alt-menu sidebar-noneoverflow">

<script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACf3KGqbKylkAoI4MkjKTdwlbdoCMD-rY&libraries=geometry,drawing&callback=initMap">

    var cablevw;

</script>

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

            <div class="page-header">
                <div class="page-title">
                    <h4>CONNECTION DETAIL - <span style="color: blue; font-size: larger; font-weight: bold"><?php echo $circuit;?></span></h4>
                </div>
                <?php if($row[24] == 'PAT_REJECTED'){ ?>
                    <button class="btn btn-danger mb-4" style="height: 40px;"   disabled>REJECTED</button>
                <?php } ?>
                <?php if($row[24] == 'PAT_PASSED'){ ?>
                    <button class="btn btn-success mb-4" style="height: 40px;" disabled>PASSED</button>
                <?php } ?>
            </div>

            <hr/>

            <div class="row layout-top-spacing">
                <div class="col-lg-12 col-12 layout-spacing" >
                    <div class="statbox widget box box-shadow">

                        <div class="card">
                            <div class="card-header ">
                                <a href="#" style="font-weight: bold; font-size:large">SERVICE ORDER DETAILS</a>
                            </div>

                            <div class="card-body">

                                <div class="row" style="font-size: 15px; font-weight: bold">
                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                        <label style="color: #0dcaf0">SERVICE ORDER</label><br/>
                                        <label><?php echo $row[1]; ?></label>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                        <label style="color: #0dcaf0">CONTACT NO</label><br/>
                                        <label><?php echo $row[7]; ?></label>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                        <label style="color: #0dcaf0">DP LOOP</label><br/>
                                        <label><?php echo $row[9]; ?></label>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                        <label style="color: #0dcaf0">ADDRESS</label><br/>
                                        <label><?php echo $row[8]; ?></label>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                        <label style="color: #0dcaf0">PACKAGE</label><br/>
                                        <label id="pkg"><?php echo $pkg; ?></label>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <br/>

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
                                                <!-- <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                    <button class="btn btn-info mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="updateMeterial('<?php echo $getFtthDW[0]; ?>','<?php echo $getFtthDW[2]; ?>','<?php echo $getFtthDW[6]; ?>')">UPDATE</button>
                                                </div> -->
                                                <div class="col-lg-4 col-md-6 col-sm-8  mr-auto">
                                                </div>
                                            </div>
                                        <?php } ?>


                                    </div>

                                </div><hr/><br/>
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
                                                <!-- <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                    <label>&nbsp;</label><br/>
                                                    <button class="btn btn-danger mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="deleteMeterial('<?php echo $poles[0]; ?>','<?php echo $poles[2]; ?>','<?php echo $poles[6]; ?>')">DELETE</button>
                                                </div> -->
                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                </div>
                                            </div>

                                        <?php } ?><hr/><br/>



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
                                                        <!-- <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                        </div>
                                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto">
                                                            <label>&nbsp;</label><br/>
                                                            <button class="btn btn-danger mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="deleteMeterial('<?php echo $othetmet[0]; ?>','<?php echo $othetmet[2]; ?>','<?php echo $othetmet[6]; ?>')">DELETE</button>
                                                        </div> -->
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

                        <br/>

                        <div class="card">
                            <div class="card-header ">
                                <a href="#" style="font-weight: bold; font-size:large">IMAGE DETAILS - STAGE 1</a>
                                <span style="padding-right: 900px"></span>
                                <a style="font-weight: bold; font-size:medium; color: red">REJECTED IMAGES : <?php echo $getrejImgcount[0];?></a>
                                <span style="padding-right: 80px"></span>
                            </div>

                            <div class="card-body ">
                                <?php

                                $dirname = "https://serviceportal.slt.lk/disk2/ishampImages/";
                                $getAllImg = $db->getAllImg();
                                $imgc = 0;

                                foreach( $getAllImg as $row ) {
                                $img_url='';
                                $imgc++;
                                $loadImg = $db->loadImg2($sod,$row[0],'1');
                                $img_url = $dirname.$sod."/".$loadImg[0][0].'.png';
                                if($imgc%4 == 1){ ?>

                                <div class="row" style="font-size: 15px; font-weight: bold">
                                    <?php } ?>
                                    <div class="col-lg-3 col-md-4 col-sm-8">
                                        <div class="col-lg-12 col-md-12 col-sm-8  mr-auto center"><label style="color: #0dcaf0" title="<?php echo $row[4]; ?>"><?php echo $loadImg[2]; ?></label></div>
                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto image-set">
                                            <a data-magnify="gallery" data-src="" data-group="a" title="<?php echo $loadImg[2]; ?>" href="<?php echo $img_url; ?>">
                                                <img class="modal2-content <?php if($loadImg[3] == 5){ echo 'rjborder';}  if($loadImg[3] == 10){ echo 'acptborder';} ?>" id="1" src="<?php echo $img_url; ?>" width="200" height="200" onerror="this.src='../assets/img/no-image.png'">
                                            </a>
                                        </div>
                                    </div>

                                    <?php  if($imgc%4 == 0){ ?>

                                </div>
                                </br>
                            <hr/>
                                </br>

                            <?php }

                            if(sizeof($getAllImg) == $imgc && $imgc%4 != 0){ ?>
                            </div>
                            </br>
                            <hr/>
                            </br>





                            <?php } }

                            ?>
                        </div>

                        <div class="card">
                            <div class="card-header ">
                                <a href="#" style="font-weight: bold; font-size:large">IMAGE DETAILS - STAGE 2</a>
                            </div>

                            <div class="card-body ">
                                <?php

                                $dirname = "https://serviceportal.slt.lk/ApiPro/ImageApi/uploads/";
                                $getAllImg = $db->loadImgSt2($sod,'2');

                                $imgc = 0;

                                foreach( $getAllImg as $row ) {
                                $img_url='';
                                $imgc++;
                                $loadImg = $db->loadImg2($sod,$row[1],'2');
                                $img_url = $dirname.$sod."/".$loadImg[0].'.png';
                                if($imgc%4 == 1){ ?>

                                <div class="row" style="font-size: 15px; font-weight: bold">
                                    <?php } ?>
                                    <div class="col-lg-3 col-md-4 col-sm-8">
                                        <div class="col-lg-12 col-md-12 col-sm-8  mr-auto center"><label style="color: #0dcaf0" title="<?php echo $row[4]; ?>"><?php echo $loadImg[2]; ?></label></div>
                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto image-set">
                                            <a data-magnify="gallery" data-src="" data-group="a" title="<?php echo $loadImg[2]; ?>" href="<?php echo $img_url; ?>">
                                                <img class="modal2-content <?php if($loadImg[3] == 5){ echo 'rjborder';}  if($loadImg[3] == 10){ echo 'acptborder';} ?>" id="1" src="<?php echo $img_url; ?>" width="200" height="200" onerror="this.src='../assets/img/no-image.png'">
                                            </a>
                                        </div>
                                    </div>

                                    <?php  if($imgc%4 == 0){ ?>

                                </div>
                                </br>
                            <hr/>
                                </br>

                            <?php }

                            if(sizeof($getAllImg) == $imgc && $imgc%4 != 0){ ?>
                            </div>
                            </br>
                            <hr/>
                            </br>





                            <?php } }

                            ?>
                        </div>


                    </div>

                </div>

                <div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php
    include "footer.php"
    ?>
    <!-- FOOTER -->
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


    function patReCorrect(){

        var r = confirm("Are you sure you want Complete results");
        if (r == true) {
            var info =[];

            info[0]="<?php echo $sod; ?>";



            var q = 'patReCorrect';
            $.ajax({

                type: "POST",
                url: "../db/DbFunctions",
                data: {info: info, q: q},
                success: function (data) {

                    if (data == 'success') {

                        Snackbar.show({
                            text: 'Result Completed Success',
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                        });
                        setTimeout(function () {
                            window.location='pat_result'
                        }, 3000);


                    } else {
                        Snackbar.show({
                            text: 'Result Completed failed',
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
    //------- save accept cmt -------//
    function ImgAccept(imgN){

        var cmt = $('#'+imgN+'cmt').val();
        var imgName = $('#'+imgN+'imgName').val();
        var imgId = $('#'+imgN+'imgId').val();

        var info =[];
        info[0] = $('#soId').val();
        info[1] = imgId;
        info[2] = cmt;
        info[3] = imgName;

        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Accept This Image!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type:"post",
                    url:"../db/DbFunctions",
                    data:{info:info,q:"addAcptCmt"},
                    success:function(data){

                        if(data == "success"){

                            Snackbar.show({
                                text: 'Image Accept Success',
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });

                            $.ajax({
                                url: "set_session.php",
                                type: "post",
                                data: { imgId: imgN,q:'acptImg' }
                            });

                            setTimeout(function(){window.location.reload();}, 3000);

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
        });


    }

    //------- save reject cmt -------//
    function ImgReject(imgN){

        var cmt = $('#'+imgN+'cmt').val();
        var imgName = $('#'+imgN+'imgName').val();
        var imgDName = $('#'+imgN+'imgDName').val();
        var imgId = $('#'+imgN+'imgId').val();

        var info =[];
        info[0] = $('#soId').val();
        info[1] = imgId;
        info[2] = cmt;
        info[3] = imgName;
        info[4] = imgDName;

        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Reject This Image!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {

                if(cmt == ''){

                    Snackbar.show({
                        text: 'Comment Required',
                        actionTextColor: '#fff',
                        backgroundColor: '#e7515a',
                        pos: 'bottom-right',
                    });

                }else{

                    $.ajax({
                        type:"post",
                        url:"../db/DbFunctions",
                        data:{info:info,q:"addRjCmt"},
                        success:function(data){

                            if(data == "success"){

                                Snackbar.show({
                                    text: 'Image Reject Success',
                                    actionTextColor: '#fff',
                                    backgroundColor: '#6ccb09',
                                    pos: 'top-center',
                                });

                                $.ajax({
                                    url: "set_session.php",
                                    type: "post",
                                    data: { imgId: imgN,q:'rjctImg' }
                                });

                                setTimeout(function(){window.location.reload();}, 3000);

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

            }

        });

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

    //--------- image display modal -------//
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

<!-- popup box -->
<div id="myModal" class="modal">
    <img class="modal-content" id="img01">
</div>
<!-- end popup box -->

<!-- JAVASCRIPT --->
</body>
</html>

