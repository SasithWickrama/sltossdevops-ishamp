<?php
//ini_set('display_errors', 1);
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){


    include "../db/DbOperations.php";
    $db = new DbOperations;
    $areas = $_SESSION["uarea"];
    $usr = $_SESSION["uid"];
    $con = $_SESSION["ucatagory"];

    $dat = explode("_",$_GET['sod']);
    $getConDetail = $db->getConDetail($dat[0],$dat[2],$dat[3]);

    $getConDetail = $db->getConDetail($dat[0],$dat[2],$dat[3]);



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
    <title>TechsPro - Service Order Details</title>
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
                <div class="page-title">
                    <h4>CONNECTION DETAIL - <span style="color: blue"><?php echo $getConDetail[3];?></span></h4>

                </div>
                <div class="page-title">
                    <button class="btn btn-info" id="assignButton" style="height: 35px;"  onclick="assignSod()">ACCEPT</button>
                </div>

            </div><hr/>

            <div class="row layout-top-spacing">
                <div class="col-lg-12 col-12 layout-spacing" >
                    <div class="statbox widget box box-shadow">
                    <!--  ==================  -->
                    <?php if($dat[1] == 'ASSIGNED') { ?>
                     <div class="card">
                     <div class="card-header ">
                         <a href="#" style="font-weight: bold; font-size:large">SERVICE ORDER DETAILS</a>
                     </div>
                     <div class="card-body ">
                         <div class="row" style="padding-left: 10px;">
                             <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                 <label style="color: #0dcaf0">SERVICE ORDER</label><br/>
                                 <label style="color: black"><?php echo $getConDetail[2] ;?></label>

                             </div>
                             <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                 <label style="color: #0dcaf0">RTOM</label><br/>
                                 <label style="color: black"><?php echo $getConDetail[0] ;?></label>

                             </div>

                             <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                 <label style="color: #0dcaf0">SERVICE</label><br/>
                                 <label style="color: black"><?php echo $getConDetail[5] ;?></label>

                             </div>
                             <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                 <label style="color: #0dcaf0">ORDER</label><br/>
                                 <label style="color: black"><?php echo $getConDetail[4] ;?></label>

                             </div>

                         </div><hr/>

                         <div class="row" style="padding-left: 10px;">
                             <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                 <label style="color: #0dcaf0">LEA</label><br/>
                                 <label style="color: black"><?php echo $getConDetail[1] ;?></label>

                             </div>

                                 <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                     <label style="color: #0dcaf0">STATUS</label><br/>
                                     <label style="color: black"><?php echo $getConDetail[8] ;?></label>

                                 </div>

                             <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                 <label style="color: #0dcaf0">STATUS DATE</label><br/>
                                 <label style="color: black"><?php echo $getConDetail[19] ;?></label>

                             </div>
                             <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                 <label style="color: #0dcaf0">RECEIVED DATE</label><br/>
                                 <label style="color: black"><?php echo $getConDetail[9] ;?></label>

                             </div>

                         </div><hr/>

                         <div class="row" style="padding-left: 10px;">
                             <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                 <label style="color: #0dcaf0">TASK</label><br/>
                                 <label style="color: black"><?php echo $getConDetail[16] ;?></label>

                             </div>
                             <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                 <label style="color: #0dcaf0">PACKAGE</label><br/>
                                 <?php if ($getConDetail[12]  == 'VOICE_INT_IPTV'){ ?>
                                     <label style="color: black">Triple Play</label>
                                 <?php } ?>
                                 <?php if ($getConDetail[12]  == 'VOICE_INT'){ ?>
                                     <label style="color: black">Double Play - BB</label>
                                 <?php } ?>
                                 <?php if ($getConDetail[12]  == 'VOICE_IPTV'){ ?>
                                     <label style="color: black">Double Play - PeoTV</label>
                                 <?php } ?>
                             </div>
                             <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                 <label style="color: #0dcaf0">SALES PERSON</label><br/>
                                 <label style="color: black"><?php echo $getConDetail[15] ;?></label>

                             </div>
                             <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                 <label style="color: #0dcaf0">SALES PERSON CONTACT </label><br/>
                                 <label style="color: black"><?php echo $getConDetail[20] ;?></label>

                             </div>

                         </div><hr/>

                         <div class="row" style="padding-left: 10px;">
                                 <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                     <label style="color: #0dcaf0">CUSTOMER</label><br/>
                                     <label style="color: black"><?php echo $getConDetail[6] ;?></label>

                                 </div>
                                 <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                     <label style="color: #0dcaf0">CONTACT</label><br/>
                                     <label style="color: black"><?php echo $getConDetail[7] ;?></label>

                                 </div>
                                 <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                     <label style="color: #0dcaf0">ADDRESS</label><br/>
                                     <label style="color: black"><?php echo $getConDetail[10] ;?></label>

                                 </div>
                                 <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                     <label style="color: #0dcaf0"></label><br/>
                                     <label style="color: black"></label>

                                 </div>
                         </div><hr/>

                     </div>
                     </div>
                    <?php } ?>
                    <!--  =================  -->
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

    var f1 = flatpickr(document.getElementById('basicFlatpickr'));
    var f2 = flatpickr(document.getElementById('basicFlatpickr2'));



    $(document).ready(function() {
        document.getElementById("dash").className = "menu single-menu ";
        document.getElementById("sod").className = "menu single-menu active";
        document.getElementById("datasod").className = "menu single-menu ";
        document.getElementById("quality").className = "menu single-menu ";
        document.getElementById("user").className = "menu single-menu ";
        document.getElementById("invoice").className = "menu single-menu ";
        document.getElementById("doc").className = "menu single-menu ";
    });
</script>



<script>
    function assignSod(){

        document.getElementById("assignButton").disabled = true;

        var s1= '<?php echo $dat[0]; ?>';
        var s2= '<?php echo $dat[2]; ?>';
        var s3= '<?php echo $dat[3]; ?>';

        var dat = s1+'_INPROGRESS_'+s2+'_'+s3;
        var q = 'conInprogress';

        $.ajax({

            type:"post",
            url:"../db/DbFunctions",
            data:"&sod="+s1+"&q="+q,
            success:function(data){

                if(data == "success"){
                    Snackbar.show({
                        text: 'Status update success',
                        actionTextColor: '#fff',
                        backgroundColor: '#6ccb09',
                        pos: 'top-center',
                    });
                    document.getElementById("assignButton").disabled = true;
                    if(s3 == 'PEO'){
                        setTimeout(function(){window.location='sod_detailsiptv?sod='+dat;}, 3000);
                    }else{
                        setTimeout(function(){window.location='sod_details?sod='+dat;}, 3000);
                    }


                }else{
                    Snackbar.show({
                        text: data,
                        actionTextColor: '#fff',
                        backgroundColor: '#e7515a',
                        pos: 'top-center',
                    });
                    document.getElementById("assignButton").disabled = true;
                    setTimeout(function(){location.reload();}, 3000);

                }
            }
        });


    }

</script>


<!-- JAVASCRIPT --->
</body>
</html>



