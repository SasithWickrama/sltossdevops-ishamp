<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){

    $areas = $_SESSION["uarea"];
    include "../db/DbOperations.php";
    $db = new DbOperations;

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
    <title>TechsPro - Service Order SMART HOME</title>
    <!--  BEGIN HEAD  -->
    <?php
    include "header.php"
    ?>
    <!--  END NAVBAR  -->

    <style>
        hr {
            display: block;
            margin-top: 0.1em;
            margin-bottom: 0.1em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 1px;
            background-color: #1ba87e;
        }

        a:hover{
            color: #236aef;
        }

        div.dataTables_wrapper {
            margin: 0 auto;
        }

    </style>
    <style>
        .loader {
            /* border: 16px solid #f3f3f3;
             border-radius: 50%;
             border-top: 16px solid #3498db;
             width: 120px;
             height: 120px;
             -webkit-animation: spin 2s linear infinite;
             animation: spin 2s linear infinite;*/

            position: absolute;
            width: 100%;
            height:100%;
            left: 0;
            top: 0;
            align-items: center;
            background-color: #000;
            z-index: 999;
            opacity: 0.5;
        }
        .loading-icon{ position:absolute;border-top:4px solid #fff;border-right:4px solid #fff;border-bottom:4px solid #fff;border-left:4px solid #767676;border-radius:60px;width:60px;height:60px;margin:0 auto;position:absolute;left:50%;margin-left:-20px;top:50%;margin-top:-20px;z-index:4;-webkit-animation:spin 1s linear infinite;-moz-animation:spin 1s linear infinite;animation:spin 1s linear infinite;}

        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>

    <style>

        #loading-overlay {
            position: absolute;
            width: 100%;
            height:100%;
            left: 0;
            top: 0;
            display: none;
            align-items: center;
            background-color: #000;
            z-index: 999;
            opacity: 0.5;
        }
        .loading-icon{ position:absolute;border-top:4px solid #fff;border-right:4px solid #fff;border-bottom:4px solid #fff;border-left:4px solid #767676;border-radius:60px;width:60px;height:60px;margin:0 auto;position:absolute;left:50%;margin-left:-20px;top:50%;margin-top:-20px;z-index:4;-webkit-animation:spin 1s linear infinite;-moz-animation:spin 1s linear infinite;animation:spin 1s linear infinite;}

        @-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
        @-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
        @keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }
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
                    <h4>NEW CONNECTION LIST</h4>

                </div>

            </div><hr/>

            <div class="row layout-top-spacing">
                <!--  ==================  -->
                <div class="col-lg-12 col-12 layout-spacing"  id="dataView">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area border-top-tab">
                            <ul class="nav nav-tabs mb-12 mt-3" id="borderTop" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="border-top-profile-tab" data-toggle="tab" href="#patsuccess" role="tab" aria-controls="border-top-profile" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">ACCEPTED</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="border-top-home-tab" data-toggle="tab" href="#patreject" role="tab" aria-controls="border-top-home" aria-selected="true"><span style="font-weight: bold; font-size: 16px;">REJECTED</span> </a>
                                </li>

                            </ul>
                            <div class="tab-content" id="borderTopContent">
                                <div class="tab-pane fade show active" id="patsuccess" role="tabpanel" aria-labelledby="border-top-home-tab">
                                    <table  class="display nowrap table table-striped table-bordered" id="pat-confirm" style="font-size:13px;">

                                        <thead class="thead-light">

                                        <tr>
                                            <th>RTOM</th>
                                            <th>SOD</th>
                                            <th>CIRCUIT</th>
                                            <th>SERVICE</th>
                                            <th>ORDER TYPE</th>
                                            <th>STATUS</th>
                                            <th>CONTRACTOR</th>
                                            <th>PAT USER</th>
                                            <th>COMPLETED ON</th>
                                        </tr>

                                        </thead>

                                        <tbody id="ftthtbl">



                                        </tbody>
                                    </table>


                                </div>

                                <div class="tab-pane fade " id="patreject" role="tabpanel" aria-labelledby="border-top-profile-tab">
                                    <table class="display nowrap table table-striped table-bordered" id="pat-reject" style="font-size:13px;">

                                        <thead class="thead-light">

                                        <tr>
                                            <th>RTOM</th>
                                            <th>SOD</th>
                                            <th>CIRCUIT</th>
                                            <th>SERVICE</th>
                                            <th>ORDER TYPE</th>
                                            <th>STATUS</th>
                                            <th>CONTRACTOR</th>
                                            <th>PAT USER</th>
                                            <th>COMPLETED ON</th>
                                        </tr>

                                        </thead>

                                        <tbody id="ftthtbl">

                                        </tbody>
                                    </table>


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

    $(document).ready(function() {
        document.getElementById("dash").className = "menu single-menu ";
        document.getElementById("sod").className = "menu single-menu ";
        document.getElementById("faults").className = "menu single-menu ";
        document.getElementById("quality").className = "menu single-menu ";
        document.getElementById("inbox").className = "menu single-menu ";
        document.getElementById("user").className = "menu single-menu ";
        document.getElementById("invoice").className = "menu single-menu ";
        document.getElementById("doc").className = "menu single-menu ";
        document.getElementById("pat").className = "menu single-menu active";


        $('#pat-confirm').dataTable({
            ajax: 'dynamic_load.php?x=patsuccess',
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            scrollX: true,
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'excel', className: 'btn' },
                    { extend: 'print', className: 'btn' }
                ]
            },
            columns: [{
                    data: 'RTOM'
                },
                {
                    "render": function(data, type, row, meta) {
                        data = '<a style="color: #0E0EFF; " href="pat_result_details?sod=' + row['SO_NUM'] + '" target="_blank">' + row['SO_NUM'] + '</a>';
                        return data;
                    }
                },
                {
                    data: 'VOICENUMBER'
                },
                {
                    data: 'S_TYPE'
                },
                {
                    data: 'ORDER_TYPE'
                },
                {
                    data: 'CON_STATUS'
                },
                {
                    data: 'CON_NAME'
                },
                {
                    data: 'PAT_USER'
                },
                {
                    data: 'CON_STATUS_DATE'
                },

            ],
        });

        $('#pat-reject').dataTable({
            ajax: 'dynamic_load.php?x=patreject',
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            scrollX: true,
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'excel', className: 'btn' },
                    { extend: 'print', className: 'btn' }
                ]
            },
            columns: [{
                data: 'RTOM'
            },
                {
                    "render": function(data, type, row, meta) {
                        data = '<a style="color: #0E0EFF; " href="pat_result_details?sod=' + row['SO_NUM'] + '" target="_blank">' + row['SO_NUM'] + '</a>';
                        return data;
                    }
                },
                {
                    data: 'VOICENUMBER'
                },
                {
                    data: 'S_TYPE'
                },
                {
                    data: 'ORDER_TYPE'
                },
                {
                    data: 'CON_STATUS'
                },
                {
                    data: 'CON_NAME'
                },
                {
                    data: 'PAT_USER'
                },
                {
                    data: 'CON_STATUS_DATE'
                },


            ],
        });


    });
</script>





<!-- JAVASCRIPT --->
<div class="loader" id="loader" style="visibility:hidden">
    <div class="loading-icon"></div>

</div>
</body>
</html>


