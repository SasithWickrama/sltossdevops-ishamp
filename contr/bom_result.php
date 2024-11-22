<?php
//ini_set('display_errors', 1);
session_start();
include "../db/DbOperations.php";
$db = new DbOperations;
$areas = $_SESSION["uarea"];
$usr = $_SESSION["uid"];
$con = $_SESSION["ucatagory"];



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>TechsPro - BOM Create</title>
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
                    <h4>BOM PENDING CONNECTIONS</h4>

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
                    <select class="form-control  basic" name="stat" id="stat" required>
                        <option value="COMPLETED" selected>COMPLETED</option>
                    </select>

                </div>

<!--                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">-->
<!--                    <input id="basicFlatpickr" name="fromdate" value="" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select From Date..." style="height: 40px;">-->
<!--                </div>-->
<!---->
<!--                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">-->
<!--                    <input id="basicFlatpickr2" name="todate" value="" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select To Date..." style="height: 40px; ">-->
<!--                </div>-->

                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <button class="btn btn-info mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="getSods()">GET DETAILS</button>
                </div>


                <!--  ==================  -->
                <div class="col-lg-12 col-12 layout-spacing" style="display: none" id="dataView">
                    <div class="statbox widget box box-shadow">
<!--                        <div class="widget-content widget-content-area border-top-tab">-->
<!--                                <div class="tab-pane fade show active" id="ftth" role="tabpanel" aria-labelledby="border-top-home-tab">-->
<!--                                    <table class="table table-striped table-bordered" id="ftth-table" style="font-size:13px;">-->
<!---->
<!--                                        <thead class="thead-light">-->
<!---->
<!--                                        <tr>-->
<!--                                            <th><input type="checkbox" id="chkAllftth"></th>-->
<!--                                            <th>RTOM</th>-->
<!--                                            <th>SOD</th>-->
<!--                                            <th>CIRCUIT</th>-->
<!--                                            <th>SERVICE</th>-->
<!--                                            <th>ORDER TYPE</th>-->
<!--                                            <th>STATUS</th>-->
<!--                                            <th>STATUS DATE</th>-->
<!--                                        </tr>-->
<!--                                        </thead>-->
<!---->
<!--                                        <tbody id="ftthtbl">-->
<!---->
<!---->
<!---->
<!--                                        </tbody>-->
<!--                                    </table>-->
<!--                                </div>-->
<!--                        </div>-->
                        <div class="widget-content widget-content-area border-top-tab">
                                <div class="tab-pane fade  show active" id="ftth" role="tabpanel" aria-labelledby="border-top-profile-tab">
                                    <table class="display nowrap table table-striped table-bordered" id="ftth-table" style="font-size:13px;">

                                        <thead class="thead-light">

                                        <tr>
                                            <th><input type="checkbox" id="chkAllftth"></th>
                                            <th>RTOM</th>
                                            <th>SOD</th>
                                            <th>CIRCUIT</th>
                                            <th>SERVICE</th>
                                            <th>ORDER TYPE</th>
                                            <th>STATUS</th>
                                            <th>STATUS DATE</th>
                                        </tr>

                                        </thead>

                                        <tbody id="ftthtbl">

                                        </tbody>
                                    </table>

                                    <!-- ===== -->
                                    <br/>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <input id="ftthcomment" name="ftthcomment" value="" class="form-control " type="text"  style="height: 40px;" disabled>
                                        </div>

                                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <button class="btn btn-info mb-4" style="height: 40px;" id="ftthButton"  name="ftthButton" >GENERATE</button>
                                        </div>
                                    </div>
                                    <!-- ===== -->
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
        var rtom = document.getElementById('rtom').value;
        // var fromDate = document.getElementById('basicFlatpickr').value;
        // var toDate = document.getElementById('basicFlatpickr2').value;
        //var stat = document.getElementById('stat').value;
        var con = '<?php echo $con; ?>';
        var data = rtom+'_'+con;
        var today = new Date().toJSON().slice(0,10).replace(/-/g,'-');

        var ref = 'BOM/'+rtom+'/'+today+'-'+Math.floor(Math.random() * 1000000000);


        document.getElementById('ftthcomment'). value = ref;

        if(rtom == ''){
            Snackbar.show({
                text: 'RTOM Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        }else{
            document.getElementById('dataView').style.display = 'block';
            $('#ftth-table').DataTable().clear().destroy();

            $('#ftth-table').dataTable({
                ajax: 'dynamic_load?x=ftthbom&z='+data,
                dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'btn' },
                        { extend: 'excel', className: 'btn' },
                    ]
                },
                columns: [{
                    "render": function(data, type, row, meta) {
                        return '<input type="checkbox" id="checkboxftth">';

                    }
                },
                    {
                        data: 'RTOM'
                    },
                    {
                        data: 'SO_NUM'
                    },
                    {
                        data: 'VOICENUMBER'
                    },
                    {
                        data: 'S_TYPE',
                    },
                    {
                        data: 'ORDER_TYPE'
                    },
                    {
                        data: 'CON_STATUS'
                    },
                    {
                        data: 'CON_STATUS_DATE'
                    },

                ],
            });

        }
    }



</script>


<script>
    var ss = $(".basic").select2({

    });

    // var f1 = flatpickr(document.getElementById('basicFlatpickr'));
    // var f2 = flatpickr(document.getElementById('basicFlatpickr2'));


    $(document).ready(function() {
        document.getElementById("dash").className = "menu single-menu ";
        document.getElementById("sod").className = "menu single-menu active";
        document.getElementById("datasod").className = "menu single-menu ";
        document.getElementById("quality").className = "menu single-menu ";
        document.getElementById("user").className = "menu single-menu ";
        document.getElementById("invoice").className = "menu single-menu ";
        document.getElementById("doc").className = "menu single-menu ";
    });

    $('#chkAllftth').click(function (e) {
        console.log('helloo');
        $('#ftth-table tbody :checkbox').prop('checked', $(this).is(':checked'));
        e.stopImmediatePropagation();
    });

    $(document).on('click','#ftthButton',function(){

        var conName = $('#ftthcon').val();
        var table = document.getElementById('ftth-table');
        var ref = document.getElementById('ftthcomment').value;
        var rowCount = $('#ftth-table tr').length;
        var con = '<?php echo $con; ?>';
        var rtom = document.getElementById('rtom').value;

        var chkCount = 0;
        for(var n=1; n < rowCount; n++){

            if (table.rows[n].cells[0].childNodes[0].checked == true){

                chkCount++;
            }

        }

        if(chkCount == 0){
            Snackbar.show({
                text: 'Select at least one record',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });

        }else{

            for(var n=1; n < rowCount; n++){
                document.getElementById("loader").style.visibility = "visible";

                if (table.rows[n].cells[0].childNodes[0].checked == true){
                    var info =[];
                    info[0] = table.rows[n].cells[2].innerHTML;
                    info[1] = table.rows[n].cells[3].innerHTML;
                    info[2] = ref;
                    info[3] = con;
                    info[4] = rtom;

                    var q='bomCreate';
                    $.ajax({
                        type:"post",
                        url:"../db/DbFunctions",
                        data: {info:info,q:q},
                        success:function(data){
                            if(data == "success"){
                                document.getElementById("loader").style.visibility = "hidden";
                                Snackbar.show({
                                    text: 'Bom Create success',
                                    actionTextColor: '#fff',
                                    backgroundColor: '#6ccb09',
                                    pos: 'top-center',
                                });
                                setTimeout(function () {
                                    location.reload()
                                }, 3000);

                            }else{
                                document.getElementById("loader").style.visibility = "hidden";
                                Snackbar.show({
                                    text:data,
                                    actionTextColor: '#fff',
                                    backgroundColor: '#e7515a',
                                    pos: 'top-center',
                                });
                                setTimeout(function () {
                                    location.reload()
                                }, 3000);
                            }

                        }
                    });
                }
            }//end for loop
        }

    });
</script>


<!-- JAVASCRIPT --->
<div class="loader" id="loader" style="visibility:hidden">
    <div class="loading-icon"></div>

</div>
</body>
</html>

