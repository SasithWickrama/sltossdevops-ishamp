<?php
//ini_set('display_errors', 1);
session_start();
include "../db/DbOperations.php";
$db = new DbOperations;
$usr = $_SESSION["uid"];
$con = $_SESSION["ucatagory"];
$areas = $_SESSION["uarea"];

$getMobTeamList = $db->getMobTeamList($con,$areas);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Techs Pro - Mobile Team Details</title>
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
        #img1:hover {
            cursor: pointer;
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
                        <h4>MOBILE TEAM DETAILS UPDATE</h4>

                    </div>

                </div><hr/>

                <div class="row layout-top-spacing">
                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <label>Contractor</label>
                        <input type="text" class="form-control  basic" value="<?php echo $con; ?>" style="height: 40px;" disabled>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <label>Known Name</label>
                        <input type="text" id="name" class="form-control  basic" style="height: 40px;" >
                    </div>

                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <label>Contact</label>
                        <input type="text" id="contact" class="form-control  basic" style="height: 40px;" >
                    </div>

                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <label>Team</label>
                        <select class="form-control  basic" name="team" id="team" >
                            <option value="">Select TEAM ...</option>
                            <?php
                            if($_SESSION["uarea"] == 'ALL'){
                                $getTeam = $db->getTeam('ALL');
                                foreach ($getTeam as $team ){
                                    echo "<option value=\"$team[1]\">$team[0]-($team[2])</option>";
                                }
                            }else{
                                $getTeam = $db->getTeam($_SESSION["uarea"]);
                                foreach ($getTeam as $team ){
                                    echo "<option value=\"$team[1]\">$team[0]-($team[2])</option>";
                                }


                            }
                            ?>
                        </select>

                    </div>

                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <label>&nbsp;</label><br/>
                        <button class="btn btn-info mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="addval()">&nbsp;&nbsp;&nbsp;ADD&nbsp;&nbsp;&nbsp;</button>
                        </div>

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">

                    </div>


                </div>




                    <!--  ==================  -->
                    <div class="col-lg-12 col-12 layout-spacing" style="padding-left: 0px">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area border-top-tab">

                                <div class="tab-content" id="borderTopContent">
                                    <div class="tab-pane fade show active" id="ftth" role="tabpanel" aria-labelledby="border-top-home-tab">
                                        <table class="table table-striped table-bordered" id="team-table" style="font-size:15px;">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>KNOWN NAME</th>
                                                <th>CONTACT NO</th>
                                                <th>CONTRACTOR</th>
                                                <th>TEAM</th>

                                            </tr>
                                            </thead>

                                            <tbody id="ftthtbl">
                                            <?php foreach ($getMobTeamList as $team){?>

                                                <tr style="font-weight: bold;">
                                                    <td><?php echo $team[0]; ?></td>
                                                    <td><?php echo $team[1]; ?></td>
                                                    <td><?php echo $team[3]; ?></td>
                                                    <td><?php echo $team[2]; ?></td>

                                                </tr>
                                            <?php } ?>



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
        document.getElementById("datasod").className = "menu single-menu ";
        document.getElementById("quality").className = "menu single-menu ";
        document.getElementById("user").className = "menu single-menu active";
        document.getElementById("invoice").className = "menu single-menu ";
        document.getElementById("doc").className = "menu single-menu ";
    });
</script>


<script>
    function addval(){
        var info = [];
        info[0] = document.getElementById("name").value;
        info[1] = <?php echo(json_encode($con)); ?>;
        info[2] = document.getElementById("contact").value;
        info[3] = document.getElementById("team").value;

        if(info[0] == ''){
            Snackbar.show({
                text: 'Name Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        }else if(info[2] == ''){
            Snackbar.show({
                text: 'Team Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        }else {
            var r = confirm("Are you sure you want to Add ");
            if (r == true) {

                var q = 'addmobuser';
                $.ajax({

                    type: "post",
                    url: "../db/DbFunctions.php",
                    data: {info: info, q: q},
                    success: function (data) {

                        if (data == "success") {

                            Snackbar.show({
                                text: 'Team User Update Successful',
                                actionTextColor: '#fff',
                                backgroundColor: '#6ccb09',
                                pos: 'top-center',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 3000);

                        } else {
                            Snackbar.show({
                                text: data,
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
    }

    function delval(area,con,tdate,stype){
        var info = [];
        info[0]=area;
        info[1]=con;
        info[2]=tdate;
        info[3]=stype;
        var r = confirm("Are you sure you want to Delete ");
        if (r == true) {
            var q = 'delteam';
            $.ajax({

                type:"post",
                url:"../db/DbFunctions.php",
                data: {info: info, q: q},
                success:function(data){

                    if(data == "success"){

                        Snackbar.show({
                            text: 'Team Delete Successful',
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                        });
                        setTimeout(function(){location.reload();}, 3000);

                    }else{
                        Snackbar.show({
                            text: data,
                            actionTextColor: '#fff',
                            backgroundColor: '#e7515a',
                            pos: 'top-center',
                        });
                        setTimeout(function(){location.reload();}, 3000);
                    }


                }
            });
        }else {
            location.reload();
            return false;
        }
    }

    function confirmval(area,con,tdate,stype){

        var info = [];
        info[0]=area;
        info[1]=con;
        info[2]=tdate;
        info[3]=stype;
        var r = confirm("Are you sure you want to Confirm ");
        if (r == true) {
            var q = 'confirmteam';
            $.ajax({

                type:"post",
                url:"../db/DbFunctions.php",
                data: {info: info, q: q},
                success:function(data){

                    if(data == "success"){

                        Snackbar.show({
                            text: 'Team Confirm Successful',
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                        });
                        setTimeout(function(){location.reload();}, 3000);

                    }else{
                        Snackbar.show({
                            text: data,
                            actionTextColor: '#fff',
                            backgroundColor: '#e7515a',
                            pos: 'top-center',
                        });
                        setTimeout(function(){location.reload();}, 3000);
                    }


                }
            });
        }else {
            location.reload();
            return false;
        }
    }

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



