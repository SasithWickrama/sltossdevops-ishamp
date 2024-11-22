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
    $getOthers= $db->getOthers($sod);
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

        #over_map { position: absolute; top: 40px; right: 70px; z-index: 99; background-color:rgba(0,0,0,0.6); color:#ffffff;padding:5px; border-radius:5px;font-family: Times New Roman, Times, serif; font-size:11.25px; width:10%;}

        #over_map2 { position: absolute; top: 40px; right: 70px; z-index: 99; background-color:rgba(0,0,0,0.6); color:#ffffff;padding:5px; border-radius:5px;font-family: Times New Roman, Times, serif; font-size:11.25px; width:9.5%;}

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
                <?php if($rjctImg > 0){ ?>
                    <div class="col-lg-2 col-md-6 col-sm-8">
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-8">
                        <button class="btn-danger" style="width: 130px; height: 35px; border-radius: 5px; font-weight: bold;" onclick="patStat('REJECT')">REJECTED</button>
                    </div>

                <?php } else { ?>
                    <div class="col-lg-2 col-md-6 col-sm-8">
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-8">
                        <button class="btn-success" style="width: 130px; height: 35px; border-radius: 5px; font-weight: bold;" onclick="patStat('CONFIRM')">CONFIRMED</button>
                    </div>


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
                                <a href="#" style="font-weight: bold; font-size:large">IMAGE DETAILS</a>
                            </div>

                            <div class="card-body ">

                                <?php

                                $dirname = "https://serviceportal.slt.lk/ApiPro/ImageApi/uploads/";

                                $getPatWkDImg = $db->getPatWkDImg();
                                $getPatCusFRImg = $db->getPatCusFRImg();
                                $getPatAcsImg = $db->getPatAcsImg();
                                $getPatSpanImg = $db->getPatSpanImg();

                                ?>

                                <div class="widget-content widget-content-area border-top-tab">

                                    <ul class="nav nav-tabs mb-12 mt-3" id="borderTop" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="border-top-home-tab" data-toggle="tab" href="#wkdn" role="tab" aria-controls="border-top-home" aria-selected="true"><span style="font-weight: bold; font-size: 16px;">Work Done</span> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="border-top-profile-tab" data-toggle="tab" href="#cusres" role="tab" aria-controls="border-top-profile" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">Customer Feedbacks/Requests</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="border-top-contact-tab" data-toggle="tab" href="#accessory" role="tab" aria-controls="border-top-contact" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">Accessories</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="border-top-setting-tab" data-toggle="tab" href="#Spans" role="tab" aria-controls="border-top-setting" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">Spans</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="border-top-setting-tab" data-toggle="tab" href="#MapData" role="tab" aria-controls="border-top-setting" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">Map Data</span></a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="borderTopContent">

                                        <input style="display:none;" type="text" id="soId" value="<?php echo $sod; ?>"/>

                                        <div class="tab-pane fade show active" id="wkdn" role="tabpanel" aria-labelledby="border-top-home-tab">

                                            <?php

                                            $getwkdStgCount = $db->getwkdStgCount($sod);

                                            for($stg=1; $stg <= $getwkdStgCount[0];  $stg++) {

                                            $wdc = 0;

                                            if(($stg==1 ) || ($stg==2 && $status == 'PAT_CORRECTED')){

                                            $getPatWkDImgCount = $db->getPatWkDImgCount($sod,$stg);

                                            ?>

                                            <div class="row" style="font-size: 15px; font-weight: bold">

                                                <div class="col-lg-3 col-md-4 col-sm-8">
                                                    <div class="col-md-12"><label style="color:#000000;"><b><?php echo 'STAGE '.$stg; ?></b></label></div>
                                                </div>

                                            </div>

                                            <?php

                                            foreach( $getPatWkDImg as $row ) {

                                            $loadPatWKDImg = $db->loadImg($sod,$row[0],$stg);

                                            foreach( $loadPatWKDImg as $rowimg ) {

                                            $wdc++;

                                            $img_url='';

                                            $img_url = $dirname.$sod."/".$rowimg[0].'.png';

                                            if($wdc%4 == 1){

                                            ?>

                                            <div class="row" style="font-size: 15px; font-weight: bold">

                                                <?php

                                                }

                                                ?>

                                                <div class="col-lg-3 col-md-4 col-sm-8">
                                                    <div class="col-lg-12 col-md-12 col-sm-8  mr-auto center"><label style="color: #0dcaf0" title="<?php echo $row[4]; ?>"><?php echo $rowimg[2]; ?></label></div>
                                                    <div class="col-lg-6 col-md-6 col-sm-8  mr-auto image-set">
                                                        <a data-magnify="gallery" data-src="" data-group="a" title="<?php echo $rowimg[2]; ?>" href="<?php echo $img_url; ?>">
                                                            <img class="modal2-content <?php if($rowimg[3] == 5){ echo 'rjborder';}  if($rowimg[3] == 10){ echo 'acptborder';} ?>" id="1" src="<?php echo $img_url; ?>" width="200" height="200" onerror="this.src='../assets/img/no-image.png'">
                                                        </a>
                                                    </div>
                                                    <div class="mt-0"></div>

                                                    <?php

                                                    if($rowimg[0] != ''){

                                                        ?>
                                                        <div id = "<?php echo $rowimg[0].'rwaddcmt'; ?>">
                                                            <div class="col-lg-10 col-md-12 col-sm-8  mr-auto center">

                                                                <?php if($status == 'COMPLETED' && $stg==1){ ?>
                                                                    <input type="text" class="textboxstyle" id="<?php echo $rowimg[0].'cmt'; ?>"/>
                                                                <?php } ?>
                                                                <?php if($status == 'PAT_CORRECTED' && $stg==2){ ?>
                                                                    <input type="text" class="textboxstyle" id="<?php echo $rowimg[0].'cmt'; ?>"/>
                                                                <?php } ?>

                                                                <input type="text" class="textboxstyle" style="display:none" value="<?php echo $rowimg[0]; ?>" id="<?php echo $rowimg[0].'imgName'; ?>"/>
                                                                <input type="text" class="textboxstyle" style="display:none" value="<?php echo $rowimg[2]; ?>" id="<?php echo $rowimg[0].'imgDName'; ?>"/>
                                                                <input type="text" class="textboxstyle" style="display:none" value="<?php echo $row[0]; ?>" id="<?php echo $rowimg[0].'imgId'; ?>"/>
                                                            </div>

                                                            <div class="mt-0"></div>

                                                            <div class="col-lg-12 col-md-12 col-sm-8  mr-auto center" id="<?php echo $rowimg[0].'rwbtnvwcmt'; ?>">

                                                                <a class="btn btn-sm btn-primary" target="_blank" href="../map/patImgmap.php?imgId=<?php echo $rowimg[0];?>" title="View Map"><i class="fa fa-map"></i></a>

                                                                <?php if($rowimg[1] != ''){ ?>
                                                                    <button class="btn btn-sm btn-warning" onclick="loadFatCmt(<?php echo $rowimg[0] ?>);" title="view comment"><i class="fa fa-file"></i></button>
                                                                <?php } ?>

                                                                <?php if($status == 'COMPLETED' && $stg==1){ ?>
                                                                    <button class="btn btn-sm btn-success" onclick="ImgAccept(<?php echo $rowimg[0] ?>);" title="Accept"><i class="fa fa-check"></i></button>
                                                                    <button class="btn btn-sm btn-danger" onclick="ImgReject(<?php echo $rowimg[0] ?>);" title="Reject"><i class="fa fa-close"></i></button>
                                                                <?php } ?>
                                                                <?php if($status == 'PAT_CORRECTED' && $stg==2){ ?>
                                                                    <button class="btn btn-sm btn-success" onclick="ImgAccept(<?php echo $rowimg[0] ?>);" title="Accept"><i class="fa fa-check"></i></button>
                                                                    <button class="btn btn-sm btn-danger" onclick="ImgReject(<?php echo $rowimg[0] ?>);" title="Reject"><i class="fa fa-close"></i></button>
                                                                <?php } ?>

                                                            </div>

                                                        </div>

                                                        <?php

                                                    }

                                                    ?>

                                                </div>

                                                <?php

                                                if($wdc%4 == 0){

                                                ?>

                                            </div>

                                            </br>

                                        <hr/>

                                            </br>

                                        <?php

                                        }

                                        if($getPatWkDImgCount[0] == $wdc && $wdc%4 != 0){

                                        ?>

                                        </div>

                                        </br>

                                        <hr/>

                                        </br>

                                        <?php

                                        }

                                        }

                                        }

                                        }

                                        }

                                        ?>

                                    </div>

                                    <div class="tab-pane fade show" id="cusres" role="tabpanel" aria-labelledby="border-top-home-tab">

                                        <?php

                                        $getcfrStgCount = $db->getcfrStgCount($sod);

                                        for($stg=1; $stg <= $getcfrStgCount[0];  $stg++) {

                                        $cusfr = 0;

                                        if(($stg==1 ) || ($stg==2 && $status == 'PAT_CORRECTED')){

                                        $getPatCusFRImgCount = $db->getPatCusFRImgCount($sod,$stg);

                                        ?>

                                        <div class="row" style="font-size: 15px; font-weight: bold">

                                            <div class="col-lg-3 col-md-4 col-sm-8">
                                                <div class="col-md-12"><label style="color:#000000;"><b><?php echo 'STAGE '.$stg; ?></b></label></div>
                                            </div>

                                        </div>

                                        <?php

                                        foreach( $getPatCusFRImg as $row ) {

                                        $loadPatCsrfImg = $db->loadImg($sod,$row[0],$stg);

                                        foreach( $loadPatCsrfImg as $rowimg ) {

                                        $cusfr++;

                                        $img_url='';

                                        $img_url = $dirname.$sod."/".$rowimg[0].'.png';

                                        if($cusfr%4 == 1){

                                        ?>

                                        <div class="row" style="font-size: 15px; font-weight: bold">

                                            <?php

                                            }

                                            ?>

                                            <div class="col-lg-3 col-md-4 col-sm-8">
                                                <div class="col-lg-12 col-md-12 col-sm-8  mr-auto center"><label style="color: #0dcaf0" title="<?php echo $row[4]; ?>"><?php echo $rowimg[2]; ?></label></div>
                                                <div class="col-lg-2 col-md-6 col-sm-8  mr-auto image-set">
                                                    <a data-magnify="gallery" data-src="" data-group="a" title="<?php echo $rowimg[2]; ?>" href="<?php echo $img_url; ?>">
                                                        <img class="modal2-content <?php if($rowimg[3] == 5){ echo 'rjborder';}  if($rowimg[3] == 10){ echo 'acptborder';} ?>" id="1" src="<?php echo $img_url; ?>" width="200" height="200" onerror="this.src='../assets/img/no-image.png'">
                                                    </a>
                                                </div>
                                                <div class="mt-0"></div>

                                                <?php if($rowimg[0] != ''){ ?>

                                                    <div id = "<?php echo $rowimg[0].'rwaddcmt'; ?>">
                                                        <div class="col-lg-10 col-md-12 col-sm-8  mr-auto center">

                                                            <?php if($status == 'COMPLETED' && $stg==1){ ?>
                                                                <input type="text" class="textboxstyle" id="<?php echo $rowimg[0].'cmt'; ?>"/>
                                                            <?php } ?>
                                                            <?php if($status == 'PAT_CORRECTED' && $stg==2){ ?>
                                                                <input type="text" class="textboxstyle" id="<?php echo $rowimg[0].'cmt'; ?>"/>
                                                            <?php } ?>

                                                            <input type="text" class="textboxstyle" style="display:none" value="<?php echo $rowimg[0]; ?>" id="<?php echo $rowimg[0].'imgName'; ?>"/>
                                                            <input type="text" class="textboxstyle" style="display:none" value="<?php echo $rowimg[2]; ?>" id="<?php echo $rowimg[0].'imgDName'; ?>"/>
                                                            <input type="text" class="textboxstyle" style="display:none" value="<?php echo $row[0]; ?>" id="<?php echo $rowimg[0].'imgId'; ?>"/>
                                                        </div>

                                                        <div class="mt-0"></div>

                                                        <div class="col-lg-10 col-md-12 col-sm-8  mr-auto center" id="<?php echo $rowimg[0].'rwbtnvwcmt'; ?>">

                                                            <a class="btn btn-sm btn-primary" target="_blank" href="../map/patImgmap.php?imgId=<?php echo $rowimg[0];?>" title="View Map"><i class="fa fa-map"></i></a>

                                                            <?php if($rowimg[1] != ''){ ?>
                                                                <button class="btn btn-sm btn-warning" onclick="loadFatCmt(<?php echo $rowimg[0] ?>);" title="view comment"><i class="fa fa-file"></i></button>
                                                            <?php } ?>

                                                            <?php if($status == 'COMPLETED' && $stg==1){ ?>
                                                                <button class="btn btn-sm btn-success" onclick="ImgAccept(<?php echo $rowimg[0] ?>);" title="Accept"><i class="fa fa-check"></i></button>
                                                                <button class="btn btn-sm btn-danger" onclick="ImgReject(<?php echo $rowimg[0] ?>);" title="Reject"><i class="fa fa-close"></i></button>
                                                            <?php } ?>
                                                            <?php if($status == 'PAT_CORRECTED' && $stg==2){ ?>
                                                                <button class="btn btn-sm btn-success" onclick="ImgAccept(<?php echo $rowimg[0] ?>);" title="Accept"><i class="fa fa-check"></i></button>
                                                                <button class="btn btn-sm btn-danger" onclick="ImgReject(<?php echo $rowimg[0] ?>);" title="Reject"><i class="fa fa-close"></i></button>
                                                            <?php } ?>

                                                        </div>

                                                    </div>

                                                <?php } ?>

                                            </div>

                                            <?php

                                            if($cusfr%4 == 0){

                                            ?>

                                        </div>

                                        </br>

                                    <hr/>

                                        </br>

                                    <?php

                                    }

                                    if($getPatCusFRImgCount[0] == $cusfr && $cusfr%4 != 0){

                                    ?>

                                    </div>

                                    </br>

                                    <hr/>

                                    </br>

                                    <?php

                                    }

                                    }

                                    }

                                    }

                                    }

                                    ?>

                                </div>

                                <div class="tab-pane fade show" id="accessory" role="tabpanel" aria-labelledby="border-top-home-tab">

                                    <?php

                                    $getAcsStgCount = $db->getAcsStgCount($sod);

                                    for($stg=1; $stg <= $getAcsStgCount[0];  $stg++) {

                                    if(($stg==1 ) || ($stg==2 && $status == 'PAT_CORRECTED')){

                                    $acs = 0;

                                    $getPatAcsImgCount = $db->getPatAcsImgCount($sod,$stg);

                                    ?>

                                    <div class="row" style="font-size: 15px; font-weight: bold">

                                        <div class="col-lg-3 col-md-4 col-sm-8">
                                            <div class="col-md-12"><label style="color:#000000;"><b><?php echo 'STAGE '.$stg; ?></b></label></div>
                                        </div>

                                    </div>

                                    <?php

                                    foreach( $getPatAcsImg as $row ) {

                                    $loadPatAcsImg = $db->loadImg($sod,$row[0],$stg);

                                    foreach( $loadPatAcsImg as $rowimg ) {

                                    $acs++;

                                    $img_url='';

                                    $img_url = $dirname.$sod."/".$rowimg[0].'.png';

                                    if($acs%4 == 1){

                                    ?>

                                    <div class="row" style="font-size: 15px; font-weight: bold">

                                        <?php

                                        }

                                        ?>

                                        <div class="col-lg-3 col-md-4 col-sm-8">
                                            <div class="col-lg-12 col-md-12 col-sm-8  mr-auto center"><label style="color: #0dcaf0" title="<?php echo $row[4]; ?>"><?php echo $rowimg[2]; ?></label></div>
                                            <div class="col-lg-2 col-md-6 col-sm-8  mr-auto image-set">
                                                <a data-magnify="gallery" data-src="" data-group="a" title="<?php echo $rowimg[2]; ?>" href="<?php echo $img_url; ?>">
                                                    <img class="modal2-content <?php if($rowimg[3] == 5){ echo 'rjborder';}  if($rowimg[3] == 10){ echo 'acptborder';} ?>" id="1" src="<?php echo $img_url; ?>" width="200" height="200" onerror="this.src='../assets/img/no-image.png'">
                                                </a>
                                            </div>

                                            <div class="mt-0"></div>

                                            <?php if($rowimg[0] != ''){ ?>

                                                <div id = "<?php echo $rowimg[0].'rwaddcmt'; ?>">
                                                    <div class="col-lg-10 col-md-12 col-sm-8  mr-auto center">

                                                        <?php if($status == 'COMPLETED' && $stg==1){ ?>
                                                            <input type="text" class="textboxstyle" id="<?php echo $rowimg[0].'cmt'; ?>"/>
                                                        <?php } ?>
                                                        <?php if($status == 'PAT_CORRECTED' && $stg==2){ ?>
                                                            <input type="text" class="textboxstyle" id="<?php echo $rowimg[0].'cmt'; ?>"/>
                                                        <?php } ?>

                                                        <input type="text" class="textboxstyle" style="display:none" value="<?php echo $rowimg[0]; ?>" id="<?php echo $rowimg[0].'imgName'; ?>"/>
                                                        <input type="text" class="textboxstyle" style="display:none" value="<?php echo $rowimg[2]; ?>" id="<?php echo $rowimg[0].'imgDName'; ?>"/>
                                                        <input type="text" class="textboxstyle" style="display:none" value="<?php echo $row[0]; ?>" id="<?php echo $rowimg[0].'imgId'; ?>"/>
                                                    </div>

                                                    <div class="mt-0"></div>

                                                    <div class="col-lg-10 col-md-12 col-sm-8  mr-auto center" id="<?php echo $rowimg[0].'rwbtnvwcmt'; ?>">

                                                        <a class="btn btn-sm btn-primary" target="_blank" href="../map/patImgmap.php?imgId=<?php echo $rowimg[0];?>" title="View Map"><i class="fa fa-map"></i></a>

                                                        <?php if($rowimg[1] != ''){ ?>
                                                            <button class="btn btn-sm btn-warning" onclick="loadFatCmt(<?php echo $rowimg[0] ?>);" title="view comment"><i class="fa fa-file"></i></button>
                                                        <?php } ?>

                                                        <?php if($status == 'COMPLETED' && $stg==1){ ?>
                                                            <button class="btn btn-sm btn-success" onclick="ImgAccept(<?php echo $rowimg[0] ?>);" title="Accept"><i class="fa fa-check"></i></button>
                                                            <button class="btn btn-sm btn-danger" onclick="ImgReject(<?php echo $rowimg[0] ?>);" title="Reject"><i class="fa fa-close"></i></button>
                                                        <?php } ?>
                                                        <?php if($status == 'PAT_CORRECTED' && $stg==2){ ?>
                                                            <button class="btn btn-sm btn-success" onclick="ImgAccept(<?php echo $rowimg[0] ?>);" title="Accept"><i class="fa fa-check"></i></button>
                                                            <button class="btn btn-sm btn-danger" onclick="ImgReject(<?php echo $rowimg[0] ?>);" title="Reject"><i class="fa fa-close"></i></button>
                                                        <?php } ?>

                                                    </div>

                                                </div>

                                            <?php } ?>

                                        </div>

                                        <?php

                                        if($acs%4 == 0){

                                        ?>

                                    </div>

                                    </br>

                                <hr/>

                                    </br>

                                <?php

                                }

                                if($getPatAcsImgCount[0] == $acs && $acs%4 != 0){

                                ?>

                                </div>

                                </br>

                            <hr/>

                                </br>

                            <?php

                            }

                            }

                            }

                            }

                            }

                            ?>

                            </div>

                            <div class="tab-pane fade show" id="Spans" role="tabpanel" aria-labelledby="border-top-home-tab">

                                <?php

                                $getSpanStgCount = $db->getSpanStgCount($sod);

                                for($stg=1; $stg <= $getSpanStgCount[0];  $stg++) {

                                $spn = 0;

                                if(($stg==1 ) || ($stg==2 && $status == 'PAT_CORRECTED')){

                                $getPatSpanImgCount = $db->getPatSpanImgCount($sod,$stg);

                                ?>

                                <div class="row" style="font-size: 15px; font-weight: bold">

                                    <div class="col-lg-3 col-md-4 col-sm-8">
                                        <div class="col-md-12"><label style="color:#000000;"><b><?php echo 'STAGE '.$stg; ?></b></label></div>
                                    </div>

                                </div>

                                <?php

                                foreach( $getPatSpanImg as $row ) {

                                $loadPatSpanImg = $db->loadImg($sod,$row[0],$stg);

                                foreach( $loadPatSpanImg as $rowimg ) {

                                $spn++;

                                $img_url='';

                                $img_url = $dirname.$sod."/".$rowimg[0].'.png';

                                if($spn%4 == 1){

                                ?>

                                <div class="row" style="font-size: 15px; font-weight: bold">

                                    <?php

                                    }

                                    ?>

                                    <div class="col-lg-3 col-md-4 col-sm-8">
                                        <div class="col-lg-12 col-md-12 col-sm-8  mr-auto center"><label style="color: #0dcaf0" title="<?php echo $row[4]; ?>"><?php echo $rowimg[2]; ?></label></div>
                                        <div class="col-lg-2 col-md-6 col-sm-8  mr-auto image-set">
                                            <a data-magnify="gallery" data-src="" data-group="a" title="<?php echo $rowimg[2]; ?>" href="<?php echo $img_url; ?>">
                                                <img class="modal2-content <?php if($rowimg[3] == 5){ echo 'rjborder';}  if($rowimg[3] == 10){ echo 'acptborder';} ?>" id="1" src="<?php echo $img_url; ?>" width="200" height="200" onerror="this.src='../assets/img/no-image.png'">
                                            </a>
                                        </div>

                                        <div class="mt-0"></div>

                                        <?php if($rowimg[0] != ''){ ?>

                                            <div id = "<?php echo $rowimg[0].'rwaddcmt'; ?>">
                                                <div class="col-lg-10 col-md-12 col-sm-8  mr-auto center">

                                                    <?php if($status == 'COMPLETED' && $stg==1){ ?>
                                                        <input type="text" class="textboxstyle" id="<?php echo $rowimg[0].'cmt'; ?>"/>
                                                    <?php } ?>
                                                    <?php if($status == 'PAT_CORRECTED' && $stg==2){ ?>
                                                        <input type="text" class="textboxstyle" id="<?php echo $rowimg[0].'cmt'; ?>"/>
                                                    <?php } ?>

                                                    <input type="text" class="textboxstyle" style="display:none" value="<?php echo $rowimg[0]; ?>" id="<?php echo $rowimg[0].'imgName'; ?>"/>
                                                    <input type="text" class="textboxstyle" style="display:none" value="<?php echo $rowimg[2]; ?>" id="<?php echo $rowimg[0].'imgDName'; ?>"/>
                                                    <input type="text" class="textboxstyle" style="display:none" value="<?php echo $row[0]; ?>" id="<?php echo $rowimg[0].'imgId'; ?>"/>
                                                </div>

                                                <div class="mt-0"></div>

                                                <div class="col-lg-10 col-md-12 col-sm-8  mr-auto center" id="<?php echo $rowimg[0].'rwbtnvwcmt'; ?>">

                                                    <a class="btn btn-sm btn-primary" target="_blank" href="../map/patImgmap.php?imgId=<?php echo $rowimg[0];?>" title="View Map"><i class="fa fa-map"></i></a>

                                                    <?php if($rowimg[1] != ''){ ?>
                                                        <button class="btn btn-sm btn-warning" onclick="loadFatCmt(<?php echo $rowimg[0] ?>);" title="view comment"><i class="fa fa-file"></i></button>
                                                    <?php } ?>

                                                    <?php if($status == 'COMPLETED' && $stg==1){ ?>
                                                        <button class="btn btn-sm btn-success" onclick="ImgAccept(<?php echo $rowimg[0] ?>);" title="Accept"><i class="fa fa-check"></i></button>
                                                        <button class="btn btn-sm btn-danger" onclick="ImgReject(<?php echo $rowimg[0] ?>);" title="Reject"><i class="fa fa-close"></i></button>
                                                    <?php } ?>
                                                    <?php if($status == 'PAT_CORRECTED' && $stg==2){ ?>
                                                        <button class="btn btn-sm btn-success" onclick="ImgAccept(<?php echo $rowimg[0] ?>);" title="Accept"><i class="fa fa-check"></i></button>
                                                        <button class="btn btn-sm btn-danger" onclick="ImgReject(<?php echo $rowimg[0] ?>);" title="Reject"><i class="fa fa-close"></i></button>
                                                    <?php } ?>

                                                </div>

                                            </div>

                                        <?php } ?>

                                    </div>

                                    <?php

                                    if($spn%4 == 0){

                                    ?>

                                </div>

                                </br>

                            <hr/>

                                </br>

                            <?php

                            }

                            if($getPatSpanImgCount[0] == $spn && $spn%4 != 0){

                            ?>

                            </div>

                            </br>

                            <hr/>

                            </br>

                            <?php

                            }

                            }

                            }

                            }

                            }

                            ?>

                        </div>

                                <div class="tab-pane fade show" id="MapData" role="tabpanel" aria-labelledby="border-top-home-tab">



                                    <div class="row" style="font-size: 15px; font-weight: bold">

                                        <div class="col-lg-6 col-md-6 col-sm-8">
                                            <div class="col-lg-12 col-md-12 col-sm-8  mr-auto center"><label style="color: #0dcaf0" title="Pole route in geo map">Pole route in geo map</label></div>
                                            <div id="map" class="map"></div>
                                            <div id="over_map">
                                                <?php

                                                $loadPatMapDImg = $db->loadPolPathImg($sod);

                                                $img_url='';

                                                $img_url = $dirname.$sod."/".$loadPatMapDImg[0].'.png';

                                                ?>

                                                <div class="image-set">
                                                    <a data-magnify="gallery" data-src="" data-group="a" title="<?php echo $loadPatMapDImg[2]; ?>" href="<?php echo $img_url; ?>">
                                                        <img class="modal2-content" width="50" height="50" src="<?php echo $img_url; ?>" onerror="this.src='../assets/img/no-image.png'">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-8">
                                            <div class="col-lg-12 col-md-12 col-sm-8  mr-auto center"><label style="color: #0dcaf0" title="Pole route in geo map">Drop wire length calculation</label></div>
                                            <div id="map2" class="map"></div>
                                            <div id="over_map2">
                                                <button onclick="viewDwLength();" class="btn btn-warning btn-sm" title="View Drop Wire Length"><span class="fa fa-file"></span></button>
                                            </div>
                                        </div>

                                    </div>

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

    function patStat(stat){

        var r = confirm("Are you sure you want Complete the PAT results");
        if (r == true) {
            var info =[];

            info[0]="<?php echo $sod; ?>";
            info[1]=stat;


            var q = 'patStatus';
            $.ajax({

                type: "POST",
                url: "../db/DbFunctions",
                data: {info: info, q: q},
                success: function (data) {

                    if (data == 'success') {

                        Snackbar.show({
                            text: 'Pat Result Completed Success',
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                        });
                        setTimeout(function () {
                            window.location='pat_result'
                        }, 3000);


                    } else {
                        Snackbar.show({
                            text: 'Pat Result Completed failed',
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
      footToolbar: ['zoomIn', 'zoomOut', 'fullscreen', 'rotateRight'],
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

    function loadFatCmt(imgN){
        
        var info =[];
        info[0] = $('#soId').val();
        info[1] = imgN;
            
        $.ajax({
            type:"post",
            url:"../db/DbFunctions",
            data:{info:info,q:"loadFatCmt"},
            success:function(data){

                   $('#frm_body').html('<table class="table table-bordered">'+
                   '<tr>'+
                   '<th>Comment</th>'+
                   '<th>Comment User</th>'+
                   '<th>Comment Date</th>'+
                   '</tr>'+
                   '<tr>'+
                   '<td>'+data['IMAGE_COMMENT']+'</td>'+
                   '<td>'+data['IMAGE_COMUSER']+'</td>'+
                   '<td>'+data['IMAGE_COM_DATE']+'</td>'+
                   '</tr>'+
                   '</table>');

                   $("#myModal").modal('show');

            }
        });

    }

    function initMap() {
    
    var marker;

	map = new google.maps.Map(document.getElementById('map'), {
    center: new google.maps.LatLng(7.927079, 80.761244),
    zoom: 7
    });

    map2 = new google.maps.Map(document.getElementById('map2'), {
    center: new google.maps.LatLng(7.927079, 80.761244),
    zoom: 7
    });

    viewPolRoute();

    viewDwdistance();
       
    }

    const  plmarkerArray1 = [];
    const  plmarkerArray2 = [];

    function viewPolRoute(){

        var soId = document.getElementById('soId').value;
        var st = document.getElementById('status').value;

        for (let i = 0; i < plmarkerArray1.length; i++) {
            plmarkerArray1[i].setMap(null);
        }

        $.get("../db/server.php?q=loadpl&soId="+soId+"&st="+st+"", function(data1, status) {

            var pinImage = new google.maps.MarkerImage("../assets/img/EXpole.png",
                new google.maps.Size(30, 30),
                new google.maps.Point(0, 0),
                new google.maps.Point(15, 15),
                new google.maps.Size(30, 30)
            );

            $.each(data1.datapl, function(key, data) {

                var latLng = new google.maps.LatLng(data.LAT, data.LON);

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: data.EQ_NAME,
                    icon: pinImage,
                    id:data.IMAGEID
                });

                var details = '<!DOCTYPE html>'+
                    '<html>'+
                    '<head>'+
                    '</head>'+
                    '<body>'+
                    '<table class="table" style="width:100%">'+
                    '<tr>'+
                    '<td><b>Image Name</b></td>'+
                    '<td>'+data.IMAGE_DISNAME+'</td>'+
                    '</tr>'+
                    '<tr style="display:none">'+
                    '<td><b>Image Id</b></td>'+
                    '<td>'+data.IMAGEID+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td rowspan=2><b>GPS LOCATION</b></td>'+
                    '<td>Longitute:'+data.LON+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>Latitude:'+data.LAT+'</td>'+
                    '</tr>'+
                    '</table>'+
                    '</body>'+
                    '</html>';

                bindInfoWindow(marker, map, new google.maps.InfoWindow() ,details);

                plmarkerArray1.push(marker);

            });

        });

        $.get("../db/server.php?q=loadfdp&soId="+soId+"&st="+st+"", function(data1, status) {

            var pinImage = new google.maps.MarkerImage("../assets/img/FDP.png",
                new google.maps.Size(30, 30),
                new google.maps.Point(0, 0),
                new google.maps.Point(15, 15),
                new google.maps.Size(30, 30)
            );

            $.each(data1.datapl, function(key, data) {

                var latLng = new google.maps.LatLng(data.LAT, data.LON);

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: data.EQ_NAME,
                    icon: pinImage,
                    id:data.IMAGEID
                });

                var details = '<!DOCTYPE html>'+
                    '<html>'+
                    '<head>'+
                    '</head>'+
                    '<body>'+
                    '<table class="table" style="width:100%">'+
                    '<tr>'+
                    '<td><b>Image Name</b></td>'+
                    '<td>'+data.IMAGE_DISNAME+'</td>'+
                    '</tr>'+
                    '<tr style="display:none">'+
                    '<td><b>Image Id</b></td>'+
                    '<td>'+data.IMAGEID+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td rowspan=2><b>GPS LOCATION</b></td>'+
                    '<td>Longitute:'+data.LON+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>Latitude:'+data.LAT+'</td>'+
                    '</tr>'+
                    '</table>'+
                    '</body>'+
                    '</html>';

                bindInfoWindow(marker, map, new google.maps.InfoWindow() ,details);

                plmarkerArray1.push(marker);

            });

        });


        $.get("../db/server.php?q=loadcusl&soId="+soId+"&st="+st+"", function(data1, status) {

            var pinImage = new google.maps.MarkerImage("../assets/img/cusl.png",
                new google.maps.Size(30, 30),
                new google.maps.Point(0, 0),
                new google.maps.Point(15, 15),
                new google.maps.Size(30, 30)
            );

            $.each(data1.datapl, function(key, data) {

                var latLng = new google.maps.LatLng(data.LAT, data.LON);

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: data.EQ_NAME,
                    icon: pinImage,
                    id:data.IMAGEID
                });

                var details = '<!DOCTYPE html>'+
                    '<html>'+
                    '<head>'+
                    '</head>'+
                    '<body>'+
                    '<table class="table" style="width:100%">'+
                    '<tr>'+
                    '<td><b>Image Name</b></td>'+
                    '<td>'+data.IMAGE_DISNAME+'</td>'+
                    '</tr>'+
                    '<tr style="display:none">'+
                    '<td><b>Image Id</b></td>'+
                    '<td>'+data.IMAGEID+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td rowspan=2><b>GPS LOCATION</b></td>'+
                    '<td>Longitute:'+data.LON+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>Latitude:'+data.LAT+'</td>'+
                    '</tr>'+
                    '</table>'+
                    '</body>'+
                    '</html>';

                bindInfoWindow(marker, map, new google.maps.InfoWindow() ,details);

                plmarkerArray1.push(marker);

            });

        });

        $.ajax({ type: "POST",url: "../map/kmlcreate/cblAutoFloatStret.php", data: {soId:soId,st:st},success: function(result){

                cablevw = new geoXML3.parser({
                    map: map
                });

                cablevw.parse('../map/kmlfiles/cblAutoSt.kml');

            }});

    }

    function viewDwdistance(){

        var soId = document.getElementById('soId').value;
        var st = document.getElementById('status').value;

        for (let i = 0; i < plmarkerArray2.length; i++) {
            plmarkerArray2[i].setMap(null);
        }

        $.get("../db/server.php?q=loadpl&soId="+soId+"&st="+st+"", function(data1, status) {

            var pinImage = new google.maps.MarkerImage("../assets/img/EXpole.png",
                new google.maps.Size(30, 30),
                new google.maps.Point(0, 0),
                new google.maps.Point(15, 15),
                new google.maps.Size(30, 30)
            );

            $.each(data1.datapl, function(key, data) {

                var latLng = new google.maps.LatLng(data.LAT, data.LON);

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map2,
                    title: data.EQ_NAME,
                    icon: pinImage,
                    id:data.IMAGEID
                });

                var details = '<!DOCTYPE html>'+
                    '<html>'+
                    '<head>'+
                    '</head>'+
                    '<body>'+
                    '<table class="table" style="width:100%">'+
                    '<tr>'+
                    '<td><b>Image Name</b></td>'+
                    '<td>'+data.IMAGE_DISNAME+'</td>'+
                    '</tr>'+
                    '<tr style="display:none">'+
                    '<td><b>Image Id</b></td>'+
                    '<td>'+data.IMAGEID+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td rowspan=2><b>GPS LOCATION</b></td>'+
                    '<td>Longitute:'+data.LON+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>Latitude:'+data.LAT+'</td>'+
                    '</tr>'+
                    '</table>'+
                    '</body>'+
                    '</html>';

                bindInfoWindow(marker, map, new google.maps.InfoWindow() ,details);

                plmarkerArray2.push(marker);

            });

        });

        $.get("../db/server.php?q=loadfdp&soId="+soId+"&st="+st+"", function(data1, status) {

            var pinImage = new google.maps.MarkerImage("../assets/img/FDP.png",
                new google.maps.Size(30, 30),
                new google.maps.Point(0, 0),
                new google.maps.Point(15, 15),
                new google.maps.Size(30, 30)
            );

            $.each(data1.datapl, function(key, data) {

                var latLng = new google.maps.LatLng(data.LAT, data.LON);

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map2,
                    title: data.EQ_NAME,
                    icon: pinImage,
                    id:data.IMAGEID
                });

                var details = '<!DOCTYPE html>'+
                    '<html>'+
                    '<head>'+
                    '</head>'+
                    '<body>'+
                    '<table class="table" style="width:100%">'+
                    '<tr>'+
                    '<td><b>Image Name</b></td>'+
                    '<td>'+data.IMAGE_DISNAME+'</td>'+
                    '</tr>'+
                    '<tr style="display:none">'+
                    '<td><b>Image Id</b></td>'+
                    '<td>'+data.IMAGEID+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td rowspan=2><b>GPS LOCATION</b></td>'+
                    '<td>Longitute:'+data.LON+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>Latitude:'+data.LAT+'</td>'+
                    '</tr>'+
                    '</table>'+
                    '</body>'+
                    '</html>';

                bindInfoWindow(marker, map, new google.maps.InfoWindow() ,details);

                plmarkerArray2.push(marker);

            });

        });


        $.get("../db/server.php?q=loadcusl&soId="+soId+"&st="+st+"", function(data1, status) {

            var pinImage = new google.maps.MarkerImage("../assets/img/cusl.png",
                new google.maps.Size(30, 30),
                new google.maps.Point(0, 0),
                new google.maps.Point(15, 15),
                new google.maps.Size(30, 30)
            );

            $.each(data1.datapl, function(key, data) {

                var latLng = new google.maps.LatLng(data.LAT, data.LON);

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map2,
                    title: data.EQ_NAME,
                    icon: pinImage,
                    id:data.IMAGEID
                });

                var details = '<!DOCTYPE html>'+
                    '<html>'+
                    '<head>'+
                    '</head>'+
                    '<body>'+
                    '<table class="table" style="width:100%">'+
                    '<tr>'+
                    '<td><b>Image Name</b></td>'+
                    '<td>'+data.IMAGE_DISNAME+'</td>'+
                    '</tr>'+
                    '<tr style="display:none">'+
                    '<td><b>Image Id</b></td>'+
                    '<td>'+data.IMAGEID+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td rowspan=2><b>GPS LOCATION</b></td>'+
                    '<td>Longitute:'+data.LON+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>Latitude:'+data.LAT+'</td>'+
                    '</tr>'+
                    '</table>'+
                    '</body>'+
                    '</html>';

                bindInfoWindow(marker, map, new google.maps.InfoWindow() ,details);

                plmarkerArray2.push(marker);

            });

        });

        $.ajax({ type: "POST",url: "../map/kmlcreate/dwDistance.php", data: {soId:soId,st:st},success: function(result){

                cablevw = new geoXML3.parser({
                    map: map2
                });

                cablevw.parse('../map/kmlfiles/dwDistance.kml');

            }});

    }

    function bindInfoWindow(marker, map, infowindow, strDescription) {
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(strDescription);
            infowindow.open(map, marker);
        });
    }

    function viewDwLength(){

        var soId = document.getElementById('soId').value;
        var st = document.getElementById('status').value;

        var info =[];
        info[0] = soId;
        info[1] = st;

        $.ajax({
            type:"post",
            url:"../db/DbFunctions",
            data:{info:info,q:"loadDwLen"},
            success:function(data){

                var des = '';

                des +='<table class="table table-bordered">'+
                    '<tr>'+
                    '<th>Start Location</th>'+
                    '<th>End Location</th>'+
                    '<th>Distance</th>'+
                    '</tr>';

                var dataArr = data.split('*');

                var dwtot=0;

                for(var a=0; a<dataArr.length-1; a++){

                    var imgArr = dataArr[a].split('*');

                    var imgdArr = imgArr[0].split(',');

                    dwtot += parseFloat(imgdArr[2]);

                    des +='<tr>'+
                        '<td>'+imgdArr[0]+'</td>'+
                        '<td>'+imgdArr[1]+'</td>'+
                        '<td>'+imgdArr[2]+' meters'+'</td>'+
                        '</tr>';

                }

                des +='<tr style="font-weight:bold;"><td colspan="2">Total Drop wire Length</td><td>'+dwtot+' meters'+'</td></tr>'

                des +='</table>';

                $('#frm_body').html(des);

                $("#myModal").modal('show');

            }
        });

    }

  </script>

<!-- popup box -->
<div id="myModal" class="modal" width="960">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 850px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
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





