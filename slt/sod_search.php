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
    <title>i-Shamp - Search</title>
    <!--  BEGIN HEAD  -->
    <?php
    include "header.php"
    ?>

    <!--  END NAVBAR  -->

    <style>
        hr {
            display: block;
            margin-top: 0.3em;
            margin-bottom: 0.3em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 1px;
            background-color: #1ba87e;
        }

        a:hover{
            color: #236aef;
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
                    <h4>SEARCH</h4>

                </div>

            </div><hr/>

            <div class="row layout-top-spacing">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <input  id="circuit" name="circuit"  class="form-control " type="text" placeholder="Telephone No..." style="height: 40px; ">
                </div>

                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <button class="btn btn-info mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="getSods()">GET DETAILS</button>
                </div>


                <!--  ==================  -->
                <div class="col-lg-12 col-12 layout-spacing" style="display: none" id="dataView">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area border-top-tab">
                            <div class="tab-content" id="borderTopContent">
                                <div class="tab-pane fade show active" id="ftth" role="tabpanel" aria-labelledby="border-top-home-tab">
                                    <table class="table table-striped table-bordered" id="ftth-table" style="font-size:13px;">

                                        <thead class="thead-light">

                                        <tr>
                                            <th>RTOM</th>
                                            <th>LEA</th>
                                            <th>SOD</th>
                                            <th>CIRCUIT</th>
                                            <th>SERVICE</th>
                                            <th>ORDER TYPE</th>
                                            <th>RECEIVED ON</th>
                                            <th>PACKAGE</th>
                                            <th>STATUS</th>
                                            <th>CONTRACTOR</th>

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

    function getSods(){
        var tpno = document.getElementById('circuit').value;

        if(tpno == ''){
            Snackbar.show({
                text: 'Telephone Number Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        }else{
            document.getElementById('dataView').style.display = 'block';
            $('#ftth-table').DataTable().clear().destroy();

            $('#ftth-table').dataTable({
                ajax: 'dynamic_load?x=search&z='+tpno,
                dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'btn' },
                        { extend: 'excel', className: 'btn' },
                    ]
                },
                columns: [{
                    data: 'RTOM',
                },
                    {
                        data: 'LEA'
                    },
                    {
                        "render": function(data, type, row, meta) {
                            data = '<a style="color: #0E0EFF; " href="sod_details?sod=' + row['SO_NUM'] + '" target="_blank">' + row['SO_NUM'] + '</a>';
                            return data;
                        }
                    },
                    {
                        data: 'CON_PSTN_NUMBER'
                    },
                    {
                        data: 'S_TYPE'
                    },
                    {
                        data: 'ORDER_TYPE'
                    },
                    {
                        data: 'CON_STATUS_DATE'
                    },
                    {
                        "render": function(data, type, row, meta) {
                            if (row['PKG']  == 'VOICE_INT_IPTV'){
                                return 'Triple Play';
                            }
                            if (row['PKG']  == 'VOICE_INT'){
                                return 'Double Play - BB';
                            }
                            if (row['PKG']  == 'VOICE_IPTV'){
                                return 'Double Play - PeoTV';
                            }
                        }
                    },
                    {
                        data: 'CON_STATUS'
                    },
                    {
                        data: 'CON_NAME'
                    },


                ],
            });


        }



    }
</script>


<script>

    document.getElementById("dash").className = "menu single-menu ";
    document.getElementById("sod").className = "menu single-menu active";
    document.getElementById("faults").className = "menu single-menu ";
    document.getElementById("quality").className = "menu single-menu ";
    document.getElementById("inbox").className = "menu single-menu ";
    document.getElementById("user").className = "menu single-menu ";
    document.getElementById("invoice").className = "menu single-menu ";
    document.getElementById("doc").className = "menu single-menu ";
</script>


<!-- JAVASCRIPT --->
</body>
</html>
