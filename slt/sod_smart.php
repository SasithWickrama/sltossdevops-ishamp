
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
                    <h4>SMART HOME</h4>

                </div>

            </div><hr/>

            <div class="row layout-top-spacing">
                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <select class="form-control  basic" name="rtom" id="rtom" required>
                        <option value="">Select RTOM ...</option>
                        <?php
                        $i=0;
                        while($n > $i)
                        {
                            echo "<option value=\"$temp[$i]\">$temp[$i]</option>";
                            $i++;
                        }

                        ?>
                    </select>
                </div>


                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <input id="basicFlatpickr" name="fromdate" value="" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select From Date..." style="height: 40px;">
                </div>

                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <input id="basicFlatpickr2" name="todate" value="" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select To Date..." style="height: 40px; ">
                </div>

                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <button class="btn btn-info mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="getSods()">GET DETAILS</button>
                </div>


                <!--  ==================  -->
                <div class="col-lg-12 col-12 layout-spacing"  id="dataView">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area border-top-tab">
                            <ul class="nav nav-tabs mb-12 mt-3" id="borderTop" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="border-top-home-tab" data-toggle="tab" href="#smart_pending" role="tab" aria-controls="border-top-home" aria-selected="true"><span style="font-weight: bold; font-size: 16px;">PENDING</span> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="border-top-profile-tab" data-toggle="tab" href="#smart_completed" role="tab" aria-controls="border-top-profile" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">COMPLETED</span></a>
                                </li>
                            </ul>
                            <div class="tab-content" id="borderTopContent">
                                <div class="tab-pane fade show active" id="smart_pending" role="tabpanel" aria-labelledby="border-top-home-tab">
                                    <table class="table table-striped table-bordered" id="smhpen-table" style="font-size:13px;">

                                        <thead class="thead-light">

                                        <tr>
                                            <th>RTOM</th>
                                            <th>LEA</th>
                                            <th>SOD</th>
                                            <th>CIRCUIT</th>
                                            <th>ORDER TYPE</th>
                                            <th>TASK</th>
                                            <th>CONTRACTOR</th>
                                            <th>RECEIVED ON</th>
                                            <th>CUSTOMER</th>

                                        </tr>

                                        </thead>

                                        <tbody id="ftthtbl">



                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="smart_completed" role="tabpanel" aria-labelledby="border-top-profile-tab">
                                    <table class="table table-striped table-bordered" id="smhcon-table" style="font-size:13px;">

                                        <thead class="thead-light">

                                        <tr>
                                        <tr>
                                            <th>RTOM</th>
                                            <th>LEA</th>
                                            <th>SOD</th>
                                            <th>CIRCUIT</th>
                                            <th>ORDER TYPE</th>
                                            <th>TASK</th>
                                            <th>CONTRACTOR</th>
                                            <th>RECEIVED ON</th>
                                            <th>COMPLETED ON</th>
                                            <th>CUSTOMER</th>
                                        </tr>
                                        </tr>

                                        </thead>

                                        <tbody id="cabtbl">



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
        var rtom = document.getElementById('rtom').value;
        var fromDate = document.getElementById('basicFlatpickr').value;
        var toDate = document.getElementById('basicFlatpickr2').value;

        var dat = rtom+'_'+fromDate+'_'+toDate
        if(rtom == ''){
            Snackbar.show({
                text: 'RTOM Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        }else if(fromDate == ''){
            Snackbar.show({
                text: 'From Date Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        }else if(toDate == ''){
            Snackbar.show({
                text: 'To Date Required',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        }else{
            $('#smhpen-table').DataTable().clear().destroy();
                $('#smhpen-table').dataTable({
                    ajax: 'dynamicLoad.php?x=smarthome_pending&y=<?php echo $areas;?>',
                    dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
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
                            data: 'LEA'
                        },
                        {
                            data: 'SO_ID'
                        },
                        {
                            data: 'CIRCUIT'
                        },
                        {
                            data: 'ORDER_TYPE'
                        },
                        {
                            data: 'TASKNAME'
                        },
                        {
                            data: 'CON_NAME'
                        },
                        {
                            data: 'DATE_IN'
                        },
                        {
                            data: 'CUSTOMER_NAME'
                        },


                    ],
                });

            $('#smhcon-table').DataTable().clear().destroy();
                $('#smhcon-table').dataTable({
                    ajax: 'dynamicLoad.php?x=smarthome_completed&y=<?php echo $areas;?>',
                    dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
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
                            data: 'LEA'
                        },
                        {
                            data: 'SO_ID'
                        },
                        {
                            data: 'CIRCUIT'
                        },
                        {
                            data: 'ORDER_TYPE'
                        },
                        {
                            data: 'TASKNAME'
                        },
                        {
                            data: 'CON_NAME'
                        },
                        {
                            data: 'DATE_IN'
                        },
                        {
                            data: 'DATE_COM'
                        },
                        {
                            data: 'CUSTOMER_NAME'
                        },


                    ],
                });
        }

    }



    $(document).ready(function() {
            $('#smhpen-table').dataTable({
                ajax: 'dynamicLoad.php?x=smarthome_pending&y=<?php echo $areas;?>',
                dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
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
                        data: 'LEA'
                    },
                    {
                        data: 'SO_ID'
                    },
                    {
                        data: 'CIRCUIT'
                    },
                    {
                        data: 'ORDER_TYPE'
                    },
                    {
                        data: 'TASKNAME'
                    },
                    {
                        data: 'CON_NAME'
                    },
                    {
                        data: 'DATE_IN'
                    },
                    {
                        data: 'CUSTOMER_NAME'
                    },


                ],
            });


            $('#smhcon-table').dataTable({
                ajax: 'dynamicLoad.php?x=smarthome_completed&y=<?php echo $areas;?>',
                dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'btn' },
                        { extend: 'excel', className: 'btn' },
                        { extend: 'print', className: 'btn' },


                    ]
                },
                columns: [{
                    data: 'RTOM'
                },
                    {
                        data: 'LEA'
                    },
                    {
                        data: 'SO_ID'
                    },
                    {
                        data: 'CIRCUIT'
                    },
                    {
                        data: 'ORDER_TYPE'
                    },
                    {
                        data: 'TASKNAME'
                    },
                    {
                        data: 'CON_NAME'
                    },
                    {
                        data: 'DATE_IN'
                    },
                    {
                        data: 'DATE_COM'
                    },
                    {
                        data: 'CUSTOMER_NAME'
                    },


                ],
            });

    });
</script>


<script>
    var ss = $(".basic").select2({
        tags: true,
    });

    var f1 = flatpickr(document.getElementById('basicFlatpickr'));
    var f2 = flatpickr(document.getElementById('basicFlatpickr2'));



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

