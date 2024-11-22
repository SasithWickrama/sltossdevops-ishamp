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
                    <h4>BOM LIST</h4>

                </div>

            </div><hr/>

            <div class="row layout-top-spacing">
                <!--  ==================  -->
                <div class="col-lg-12 col-12 layout-spacing" id="dataView">
                    <div class="statbox widget box box-shadow">

                        <div class="widget-content widget-content-area border-top-tab">
                            <div class="tab-pane fade  show active" id="ftth" role="tabpanel" aria-labelledby="border-top-profile-tab">
                                <table class="display nowrap table table-striped table-bordered" id="ftth-table" style="font-size:13px;">

                                    <thead class="thead-light">

                                    <tr>
                                        <th>BOM REF</th>
                                        <th>RTOM </th>
                                        <th>CONTRACTOR</th>
                                        <th>ACTION</th>
                                    </tr>

                                    </thead>

                                    <tbody id="ftthtbl">

                                    </tbody>
                                </table>

                                <!-- ===== -->
                                <br/>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.3/xlsx.full.min.js"></script>

<?php

include "script.php"
?>



<script>
    var ss = $(".basic").select2({
        tags: true,
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

        var con = '<?php echo $con; ?>';

        $('#ftth-table').dataTable({
            ajax: 'dynamic_load?x=ftthbomload&z='+con,
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'excel', className: 'btn' },
                ]
            },
            columns: [{
                    data: 'BOM_REF'
                },
                {
                    data: 'RTOM'
                },
                {
                    data: 'CON'
                },
                {
                    "render": function(data, type, row, meta) {
                        return   '<button class="btn btn-info mb-4" style="height: 35px;" onclick="bomDwnload(\''+row['BOM_REF']+'\')">DOWNLOAD</button>';

                    }
                }

            ],
        });
    });

function bomDwnload(val){
            var info =[];
            info[0]= val;

            $.ajax({
                type:"post",
                url:"../db/DbFunctions",
                data:{info:info,q:"ftthbomdownload"},
                success:function(data){
                    downloadURI("../files/"+data,data)
                }
            });
        }


    function downloadURI(uri, name)
    {
        var link = document.createElement("a");
        link.download = name;
        link.href = uri;
        link.click();
    }

</script>


<!-- JAVASCRIPT --->
<div class="loader" id="loader" style="visibility:hidden">
    <div class="loading-icon"></div>

</div>
</body>
</html>


