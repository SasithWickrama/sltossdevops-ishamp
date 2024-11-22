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
                    <h4>QUALITY CHECK ASSIGN</h4>

                </div>

            </div><hr/>

            <div class="row layout-top-spacing">
                <!--  ==================  -->
                <div class="col-lg-12 col-12 layout-spacing"  id="dataView">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area border-top-tab">
                            <div class="tab-content" id="borderTopContent">
                                <div class="tab-pane fade show active" id="cab" role="tabpanel" aria-labelledby="border-top-home-tab">
                                    <table  class="table table-striped table-bordered" id="ftth-table" style="font-size:13px; font-weight: bold">

                                        <thead class="thead-light">

                                        <tr>
                                            <th>RTOM</th>
                                            <th>LEA</th>
                                            <th>SO NUM</th>
                                            <th>VOICE NUMBER</th>
                                            <th>ADDRESS</th>
                                            <th>DP LOOP</th>
                                            <th>CONTRACTOR</th>
                                            <th>STATUS</th>
                                            <th>USER</th>
                                            <th></th>
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
        document.getElementById("quality").className = "menu single-menu active";
        document.getElementById("inbox").className = "menu single-menu ";
        document.getElementById("user").className = "menu single-menu ";
        document.getElementById("invoice").className = "menu single-menu ";
        document.getElementById("doc").className = "menu single-menu ";

        $('#ftth-table').dataTable({
            ajax: 'dynamic_load.php?x=qty_assign&z=<?php echo $_SESSION["uarea"];?>',
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
                    data: 'CON_WORO_AREA'
                },
                {
                    data: 'CON_EX_AREA'
                },
                {
                    data: 'CON_SERO_ID'
                },
                {
                    data: 'CON_PSTN_NUMBER'
                },
                {
                    data: 'ADDRESS',
                },
                {
                    data: 'DPLOOP'
                },
                {
                    data: 'CON_NAME'
                },
                {
                    data: 'QC_STAT'
                },
                {
                    data: ''
                },
                {
                    data: ''
                },



            ],
        });


        $.get("server.php?x=1&y=<?php echo $areas; ?>", function(data, status) {

            selectdata = data;
            $.each(data, function(key, value) {
                selectoption = selectoption + '<option value=' + value['SID'] + '>' + value['SID'] +'-'+ value['MNAME'] +
                    '</option>';
            });


            $('#simple-table').dataTable({
                ajax: 'server.php?x=2&y=<?php echo $areas; ?>',
                // initComplete: function(settings, json) {

                //     //console.log(result);
                //     //$('#simple-table').DataTable().column(6).nodes().each(function(node, index, dt) {
                //     $('.tbluser').find('option').remove();
                //     $('.tbluser').append('<option value=\'\'></option>');
                //     $.each(selectdata, function(key, value) {
                //         $('.tbluser').append('<option value=' + value['SID'] + '>' + value['SID'] +
                //             '</option>');
                //     });
                //     // });


                // },
                columns: [{
                    data: 'RTOM'
                },
                    {
                        data: 'LEA'
                    },
                    {
                        //data: 'SO_ID'
                        "render": function(data, type, row, meta) {
                            return "<a href=\"collect_cpe_detail.php?id=" + row['SO_ID'] + "\" target=\"_blank\">" + row['SO_ID'] + "</a>";
                        }

                    },
                    {
                        // data: 'CIRCUIT'
                        "render": function(data, type, row, meta) {
                            if (row['SER_TYPE'] == 'AB-CAB' || row['SER_TYPE'] == 'AB-FTTH'){
                                return row['REGID'];
                            }else{
                                return row['CIRCUIT'];
                            }


                            // });


                        }
                    },
                    {
                        data: 'SER_TYPE'
                    },
                    {
                        data: 'DATE_IN'
                    },
                    {
                        "render": function(data, type, row, meta) {

                            //   $.get("server.php?x=1", function(data, status) {
                            var select = "<select  class=\"tbluser\" style='width: 250px;height: 30px;border-radius: 5px;'><option value=''></option><option value='012585'>012585</option>"+selectoption+"<select>";
                            return select;
                            // });


                        }
                    },

                ],
            });

            // var selectdata = data;
            //
            //
            // $('#simple-table').dataTable({
            //
            //     ajax: 'server.php?x=2&y=R-KE',
            //     initComplete: function(settings, json) {
            //
            //         //console.log(result);
            //         $('.tbluser').find('option').remove();
            //         $('.tbluser').append('<option value=\'\'></option>');
            //         $.each(selectdata, function(key, value) {
            //             $('.tbluser').append('<option value=' + value['SID'] + '>' + value['SID']+'-'+ value['MNAME'] +
            //                 '</option>');
            //         });
            //     },
            //     columns: [{
            //         data: 'RTOM'
            //     },
            //         {
            //             data: 'LEA'
            //         },
            //         {
            //             data: 'SO_ID'
            //         },
            //         {
            //             data: 'CIRCUIT'
            //         },
            //         {
            //             data: 'SER_TYPE'
            //         },
            //         {
            //             data: 'DATE_IN'
            //         },
            //         {
            //             "render": function(data, type, row, meta) {
            //               var select = "<select id=\"" + row['SO_ID'] + "\" class=\"tbluser\">";
            //                 select = select + "<select>";
            //                 return select;
            //             }
            //         },
            //
            //     ],
            //
            // });


        });


    });
</script>


<script>

    var ss = $(".basic").select2({
        tags: true,
    });

</script>


<!-- JAVASCRIPT --->
</body>
</html>


