<?php
//ini_set('display_errors', 1);
session_start();
include "../db/DbOperations.php";
$db = new DbOperations;
$usr = $_SESSION["uid"];
$con = $_SESSION["ucatagory"];
$areas = $_SESSION["uarea"];

if($_SESSION["uarea"] == 'ALL'){
    $getTeamList= $db->getTeamList('ALL',$con);
}else{
    $getTeamList= $db->getTeamList($areas,$con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Techs Pro - Team Details</title>
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
                    <h4>TEAM REPORTS</h4>

                </div>

            </div><hr/>
            <div class="row layout-top-spacing">
                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <select class="form-control  basic" name="rtom" id="rtom" required>
                        <option value="">Select RTOM ...</option>
                        <?php
                        if($_SESSION["uarea"] == 'ALL'){
                                echo "<option value=\"ALL\">ALL</option>";
                        }else{
                            $getArea = $db->con_area_rt($_SESSION["uarea"]);
                            foreach ($getArea as $area ){
                                echo "<option value=\"$area[0]\">$area[0]</option>";
                            }

                        }

                        ?>
                    </select>

                </div>


                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <input id="basicFlatpickr3" name="fromdate" value="" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select From Date..." style="height: 40px;">
                </div>

                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <input id="basicFlatpickr4" name="todate" value="" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select To Date..." style="height: 40px; ">
                </div>


                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <button class="btn btn-info mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="getTeam()">GET DETAILS</button>
                </div>



                <!--  ==================  -->
                <div class="col-lg-12 col-12 layout-spacing" id="dataView" style="display: none">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area border-top-tab">

                            <div class="tab-content" id="borderTopContent">

                                <div class="tab-pane fade show active" id="ftth" role="tabpanel" aria-labelledby="border-top-home-tab">
                                    <table class="table table-striped table-bordered" id="teamrep-table" style="font-size:15px; font-weight: bold">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>RTOM</th>
                                            <th>CONTRACTOR</th>
                                            <th>SERVICE TYPE</th>
                                            <th>DATE</th>
                                            <th>TEAM COUNT</th>
                                            <th>USER</th>
                                            <th>STATUS</th>
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
    var ss = $(".basic").select2({
        tags: true,
    });

    // var f1 = flatpickr(document.getElementById('basicFlatpickr'),minDate: "today",);

    $("#basicFlatpickr").flatpickr({
        dateFormat: "m/d/Y",
        defaultDate: "today"
    });

    $("#basicFlatpickr3").flatpickr({
    });

    $("#basicFlatpickr4").flatpickr({
    });



    $(document).ready(function() {
        $('#team-table').dataTable({

        });

        document.getElementById("dash").className = "menu single-menu ";
        document.getElementById("sod").className = "menu single-menu ";
        document.getElementById("faults").className = "menu single-menu ";
        document.getElementById("quality").className = "menu single-menu ";
        document.getElementById("inbox").className = "menu single-menu ";
        document.getElementById("user").className = "menu single-menu active";
        document.getElementById("invoice").className = "menu single-menu ";
        document.getElementById("doc").className = "menu single-menu ";
    });
</script>


<script>
    function getTeam() {

        var rtom = document.getElementById('rtom').value;
        var fromDate = document.getElementById('basicFlatpickr3').value;
        var toDate = document.getElementById('basicFlatpickr4').value;
        var con = '<?php echo $con; ?>';

        var dat = rtom + '_' + fromDate + '_' + toDate + '_' + con
        if (rtom == '') {
            Snackbar.show({
                text: 'RTOM Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        } else if (fromDate == '') {
            Snackbar.show({
                text: 'From Date Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        } else if (toDate == '') {
            Snackbar.show({
                text: 'To Date Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        } else {
            document.getElementById('dataView').style.display = 'block';
            $('#teamrep-table').DataTable().clear().destroy();

            $('#teamrep-table').dataTable({
                ajax: 'dynamic_load?x=teamrep&z=' + dat,
                dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
                buttons: {
                    buttons: [
                        {extend: 'copy', className: 'btn'},
                        {extend: 'excel', className: 'btn'},
                    ]
                },
                columns: [{
                    data: 'AREA',
                }, {
                        data: 'CONTRACTOR'
                    },
                    {
                        data: 'S_TYPE'
                    },
                    {
                        data: 'DAT'
                    },
                    {
                        data: 'TEAM_COUNT'
                    },
                    {
                        data: 'EN_USER'
                    },
                    {
                        "render": function (data, type, row, meta) {
                            if (row['TEAM_FLAG'] == '0') {
                                return 'PENDING';
                            }
                            if (row['TEAM_FLAG'] == '1') {
                                return 'CONFIRMED';
                            }
                        }
                    },

                ],
            });

        }
    }
</script>


<!-- JAVASCRIPT --->
</body>
</html>



