<?php
//ini_set('display_errors', 1);
session_start();
include "../db/DbOperations.php";
$db = new DbOperations;
$usr = $_SESSION["uid"];
$con = $_SESSION["ucatagory"];
$areas = $_SESSION["uarea"];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Techs Pro - User Details</title>
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
                    <h4>USER DETAILS</h4>

                </div>

            </div><hr/>
            <div class="row layout-top-spacing">
                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <select class="form-control  basic" name="rtom" id="rtom" required>
                        <option value="">Select RTOM ...</option>
                        <?php
                        if($_SESSION["uarea"] == 'ALL'){
                            $getArea = $db->con_area();
                            foreach ($getArea as $area ){
                                echo "<option value=\"$area[0]\">$area[0]</option>";
                            }
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
                    <button class="btn btn-info mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="getUser()">GET DETAILS</button>
                </div>



                <!--  ==================  -->
                <div class="col-lg-12 col-12 layout-spacing" id="dataView" style="display: none">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area border-top-tab">

                            <div class="tab-content" id="borderTopContent">

                                <div class="tab-pane fade show active" id="ftth" role="tabpanel" aria-labelledby="border-top-home-tab">
                                    <table class="table table-striped table-bordered" id="teamrep-table" style="font-size:13px;">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>USER ID</th>
                                            <th>USER NAME</th>
                                            <th>MOBILE</th>
                                            <th>EMAIL</th>
                                            <th>AREA</th>
                                            <th>ROLE</th>
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



    $(document).ready(function() {
        $('#team-table').dataTable({

        });

        document.getElementById("dash").className = "menu single-menu ";
        document.getElementById("sod").className = "menu single-menu ";
        document.getElementById("datasod").className = "menu single-menu ";
        document.getElementById("quality").className = "menu single-menu ";
        document.getElementById("user").className = "menu single-menu active";
        document.getElementById("invoice").className = "menu single-menu ";
        document.getElementById("doc").className = "menu single-menu ";
    });
</script>


<script>

    function getUser() {

        var rtom = document.getElementById('rtom').value;
        var con = '<?php echo $con; ?>';

        var dat = rtom + '_' + con
        if (rtom == '') {
            Snackbar.show({
                text: 'RTOM Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        } else {
            document.getElementById('dataView').style.display = 'block';
            $('#teamrep-table').DataTable().clear().destroy();

            $('#teamrep-table').dataTable({
                ajax: 'dynamic_load?x=userdetails&z=' + dat,
                dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
                buttons: {
                    buttons: [
                        {extend: 'copy', className: 'btn'},
                        {extend: 'excel', className: 'btn'},
                    ]
                },
                columns: [{
                    data: 'CON_MGT_UNAME',
                },
                    {
                        data: 'CON_MGT_USER'
                    },
                    {
                        data: 'CON_MGT_MOBILE'
                    },
                    {
                        data: 'CON_MGT_EMAIL'
                    },
                    {
                        data: 'CON_MGT_RTOMAREA'
                    },
                    {
                        data: 'CON_MGT_NAME'
                    },

                ],
            });

        }
    }
</script>


<!-- JAVASCRIPT --->
</body>
</html>



