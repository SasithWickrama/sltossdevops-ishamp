<?php
session_start();
//ini_set('display_errors', 1);
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){


    include "../db/DbOperations.php";
    $db = new DbOperations;
    $areas = $_SESSION["uarea"];
    $usr = $_SESSION["uid"];
    $con = $_SESSION["ucatagory"];


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
    <title>i-Shamp - Pending Service Orders</title>

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
                    <h4>MEGALINE -  FTTH - PEO TV PENDING</h4>

                </div>

            </div><hr/>

            <div class="row layout-top-spacing">
                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <select class="form-control  basic" name="rtom" id="rtom" required>
                        <option value="">Select RTOM ...</option>
                        <?php
echo '#'.$_SESSION["uarea"].'#';
                        if($_SESSION["uarea"] == 'ALL'){
                            $getArea = $db->con_area();
                            foreach ($getArea as $area ){
                                echo "<option value=\"$area[0]\">$area[0]</option>";
                            }
                        }else{
                            echo $_SESSION["uarea"];
                            $temp = explode(',',$_SESSION["uarea"]);
                            $n = sizeof($temp);
                            $i=1;

                            while ($n > $i){
                                $area = str_replace("'","",$temp[$i]);
                                if($area == 'ALL'){
                                    $getArea = $db->con_area();
                                    foreach ($getArea as $area ){
                                        echo "<option value=\"$area[0]\">$area[0]</option>";
                                    }
                                }else{
                                    echo "<option value=\"$area\">$area</option>";

                                }
                               // echo "<option value=\"$area\">$area</option>";
                                $i++;
                            }



                        }

                        ?>
                    </select>

                </div>

                <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <button class="btn btn-info mb-4" style="height: 40px;" id="SubmitButton"  name="SubmitButton" onclick="getSods()">GET DETAILS</button>
                </div>


                <!--  ==================  -->
                <div class="col-lg-12 col-12 layout-spacing" style="display: none" id="dataView">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area border-top-tab">
                            <ul class="nav nav-tabs mb-12 mt-3" id="borderTop" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="border-top-home-tab" data-toggle="tab" href="#ftth" role="tab" aria-controls="border-top-home" aria-selected="true"><span style="font-weight: bold; font-size: 16px;">FTTH</span> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="border-top-profile-tab" data-toggle="tab" href="#cab" role="tab" aria-controls="border-top-profile" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">MEGALINE</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="border-top-contact-tab" data-toggle="tab" href="#peoftth" role="tab" aria-controls="border-top-contact" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">PEO TV FTTH</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="border-top-setting-tab" data-toggle="tab" href="#peocab" role="tab" aria-controls="border-top-setting" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">PEO TV COPPER</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="border-top-setting-tab" data-toggle="tab" href="#opmcpat" role="tab" aria-controls="border-top-setting" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">OPMC PAT REJECT</span></a>
                                </li>
                            </ul>
                            <div class="tab-content" id="borderTopContent">
                                <div class="tab-pane fade show active" id="ftth" role="tabpanel" aria-labelledby="border-top-home-tab">
                                    <table class="table table-striped table-bordered" id="ftth-table" style="font-size:15px; font-weight: bold">

                                        <thead class="thead-light">

                                        <tr>
                                            <th style="display: none">RTOM</th>
                                            <th>LEA</th>
                                            <th>SOD</th>
                                            <th>CIRCUIT</th>
                                            <th>SERVICE</th>
                                            <th>ORDER TYPE</th>
                                            <th>TASK</th>
                                            <th>RECEIVED ON</th>
                                            <th>PACKAGE</th>
                                            <th>STATUS</th>
                                            <th style="display: none">CON_CUS_NAME</th>
                                            <th style="display: none">CON_TEC_CONTACT</th>
                                            <th style="display: none">ADDRESS</th>
                                            <th style="display: none">DP</th>
                                            <th style="display: none">PHONE_CLASS</th>
                                            <th style="display: none">PHONE_PURCH</th>
                                            <th style="display: none">SALES PERSON</th>
                                            <th style="display: none">IPTV COUNT</th>

                                        </tr>
                                        </thead>

                                        <tbody id="ftthtbl">



                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="cab" role="tabpanel" aria-labelledby="border-top-profile-tab">
                                    <table class="table table-striped table-bordered" id="cab-table" style="font-size:15px; font-weight: bold">

                                        <thead class="thead-light">

                                        <tr>
                                            <th style="display: none">RTOM</th>
                                            <th>LEA</th>
                                            <th>SOD</th>
                                            <th>CIRCUIT</th>
                                            <th>SERVICE</th>
                                            <th>ORDER TYPE</th>
                                            <th>TASK</th>
                                            <th>RECEIVED ON</th>
                                            <th>PACKAGE</th>
                                            <th>STATUS</th>
                                            <th style="display: none">CON_CUS_NAME</th>
                                            <th style="display: none">CON_TEC_CONTACT</th>
                                            <th style="display: none">ADDRESS</th>
                                            <th style="display: none">DP</th>
                                            <th style="display: none">PHONE_CLASS</th>
                                            <th style="display: none">PHONE_PURCH</th>
                                            <th style="display: none">SALES PERSON</th>
                                            <th style="display: none">IPTV COUNT</th>
                                        </tr>

                                        </thead>

                                        <tbody id="cabtbl">



                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="peoftth" role="tabpanel" aria-labelledby="border-top-contact-tab">
                                    <table class="table table-striped table-bordered" id="peoftth-table" style="font-size:15px; font-weight: bold">

                                        <thead class="thead-light">

                                        <tr>
                                            <th style="display: none">RTOM</th>
                                            <th>LEA</th>
                                            <th>SOD</th>
                                            <th>CIRCUIT</th>
                                            <th>SERVICE</th>
                                            <th>ORDER TYPE</th>
                                            <th>TASK</th>
                                            <th>RECEIVED ON</th>
                                            <th>PACKAGE</th>
                                            <th>STATUS</th>
                                            <th style="display: none">CON_CUS_NAME</th>
                                            <th style="display: none">CON_TEC_CONTACT</th>
                                            <th style="display: none">ADDRESS</th>
                                            <th style="display: none">MSAN</th>
                                            <th style="display: none">CARD PORT </th>
                                            <th style="display: none">PHONE_CLASS</th>
                                            <th style="display: none">SALES PERSON</th>
                                        </tr>

                                        </thead>

                                        <tbody id="peoftthtbl">



                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="peocab" role="tabpanel" aria-labelledby="border-top-setting-tab">
                                    <table class="table table-striped table-bordered" id="peocab-table" style="font-size:15px; font-weight: bold">

                                        <thead class="thead-light">

                                        <tr>
                                            <th style="display: none">RTOM</th>
                                            <th>LEA</th>
                                            <th>SOD</th>
                                            <th>CIRCUIT</th>
                                            <th>SERVICE</th>
                                            <th>ORDER TYPE</th>
                                            <th>TASK</th>
                                            <th>RECEIVED ON</th>
                                            <th>PACKAGE</th>
                                            <th>STATUS</th>
                                            <th style="display: none">CON_CUS_NAME</th>
                                            <th style="display: none">CON_TEC_CONTACT</th>
                                            <th style="display: none">ADDRESS</th>
                                            <th style="display: none">MSAN</th>
                                            <th style="display: none">CARD PORT </th>
                                            <th style="display: none">PHONE_CLASS</th>
                                            <th style="display: none">SALES PERSON</th>
                                        </tr>
                                        </thead>

                                        <tbody id="peocabtbl">



                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade" id="opmcpat" role="tabpanel" aria-labelledby="border-top-setting-tab">
                                    <table class="table table-striped table-bordered" id="opmcpat-table" style="font-size:15px; font-weight: bold">

                                        <thead class="thead-light">

                                        <tr>
                                            <th style="display: none">RTOM</th>
                                            <th>LEA</th>
                                            <th>SOD</th>
                                            <th>CIRCUIT</th>
                                            <th>SERVICE</th>
                                            <th>ORDER TYPE</th>
                                            <th>TASK</th>
                                            <th>RECEIVED ON</th>
                                            <th>PACKAGE</th>
                                            <th>STATUS</th>
                                            <th style="display: none">CON_CUS_NAME</th>
                                            <th style="display: none">CON_TEC_CONTACT</th>
                                            <th style="display: none">ADDRESS</th>
                                            <th style="display: none">MSAN</th>
                                            <th style="display: none">CARD PORT </th>
                                            <th style="display: none">PHONE_CLASS</th>
                                            <th style="display: none">SALES PERSON</th>
                                            <th style="display: none">IPTV COUNT</th>
                                        </tr>
                                        </thead>

                                        <tbody id="peocabtbl">



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
        var con = '<?php echo $con; ?>';
        var rt = document.getElementById('rtom').value;

        var dat = con+'_'+rt;
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
            // $('#cab-table').DataTable().clear().destroy();
            $('#peoftth-table').DataTable().clear().destroy();
           // $('#peocab-table').DataTable().clear().destroy();
            $('#opmcpat-table').DataTable().clear().destroy();

            $('#ftth-table').dataTable({
                ajax: 'dynamic_load?x=ftthpen&z='+dat,
                dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'btn' },
                        { extend: 'excel', className: 'btn' },
                    ]
                },
                columns: [{
                    data: 'RTOM',
                    visible: false,
                },
                    {
                        data: 'LEA'
                    },
                    {
                        "render": function(data, type, row, meta) {
                            if (row['CON_STATUS']  == 'ASSIGNED' ){
                                //return 'Triple Play';
                                data = '<a style="color: #770337; " href="sod_assign?sod=' + row['SO_NUM'] + '_' + row['CON_STATUS'] + '_' + row['CON_WORO_SEIT'] + '_FTTH' +'" target="_blank">' + row['SO_NUM'] + '</a>';
                            }

                            if (row['CON_STATUS']  == 'INPROGRESS'  ) {

                                if (row['FTTH_WIFI'] > '0') {
                                    data = '<a style="color: #770337; " href="sod_details_offline?sod=' + row['SO_NUM'] + '_' + row['CON_STATUS'] + '_' + row['CON_WORO_SEIT'] + '_FTTH' + '" target="_blank">' + row['SO_NUM'] + '</a>';
                                } else {
                                    data = '<a style="color: #770337; " href="sod_details?sod=' + row['SO_NUM'] + '_' + row['CON_STATUS'] + '_' + row['CON_WORO_SEIT'] + '_FTTH' + '" target="_blank">' + row['SO_NUM'] + '</a>';
                                }
                            }

                            if (row['CON_STATUS']  == 'PROV_CLOSED' ){

                                if (row['FTTH_WIFI'] > '0') {
                                    data = '<a style="color: #770337; " href="sod_details_offline?sod=' + row['SO_NUM'] + '_PROVCLOSED_' + row['CON_WORO_SEIT'] + '_FTTH' +'" target="_blank">' + row['SO_NUM'] + '</a>';
                                } else {
                                    data = '<a style="color: #770337; " href="sod_details?sod=' + row['SO_NUM'] + '_PROVCLOSED_' + row['CON_WORO_SEIT'] + '_FTTH' +'" target="_blank">' + row['SO_NUM'] + '</a>';
                                }
                            }

                            if (row['CON_STATUS']  == 'INSTALL_CLOSED' ){
                                if (row['FTTH_WIFI'] > '0') {
                                    data = '<a style="color: #770337; " href="sod_details_offline?sod=' + row['SO_NUM'] + '_INSTALLCLOSED_' + row['CON_WORO_SEIT'] + '_FTTH' +'" target="_blank">' + row['SO_NUM'] + '</a>';
                                } else {
                                    data = '<a style="color: #770337; " href="sod_details?sod=' + row['SO_NUM'] + '_INSTALLCLOSED_' + row['CON_WORO_SEIT'] + '_FTTH' +'" target="_blank">' + row['SO_NUM'] + '</a>';
                                }

                            }


                            if (row['CON_STATUS']  == 'RETURN_PENDING'){
                                data = '<a style="color: #770337; " href="sod_details?sod=' + row['SO_NUM'] + '_RETURNPENDING_' + row['CON_WORO_SEIT'] + '_FTTH' +'" target="_blank">' + row['SO_NUM'] + '</a>';
                            }
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
                        data: 'CON_WORO_TASK_NAME'
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
                        //data: 'CON_STATUS'
                        "render": function(data, type, row, meta) {

                            if (row['CON_STATUS']  == 'ASSIGNED'){
                                //return 'Triple Play';
                                return  '<a style="color: #0E9A00; font-weight: bold">'+row['CON_STATUS']+' </a>';
                            }
                            if (row['CON_STATUS']  == 'INPROGRESS'){
                                return  '<a style="color: #f8db22; font-weight: bold">'+row['CON_STATUS']+' </a>';
                            }
                            if (row['CON_STATUS']  == 'PROV_CLOSED'){
                                return  '<a style="color: #f10e74; font-weight: bold">'+row['CON_STATUS']+' </a>';
                            }
                            if (row['CON_STATUS']  == 'INSTALL_CLOSED'){
                                return  '<a style="color: #1843b0; font-weight: bold">'+row['CON_STATUS']+' </a>';
                            }
                            if (row['CON_STATUS']  == 'RETURN_PENDING'){
                                return  '<a style="color: #cb0919; font-weight: bold">'+row['CON_STATUS']+' </a>';
                            }
                        }
                    },
                    {
                        data: 'CON_CUS_NAME',
                        visible: false
                    },
                    {
                        data: 'CON_TEC_CONTACT',
                        visible: false
                    },
                    {
                        data: 'ADDRE',
                        visible: false
                    },
                    {
                        data: 'DP',
                        visible: false
                    },
                    {
                        data: 'CON_OSP_PHONE_CLASS',
                        visible: false
                    },
                    {
                        data: 'CON_PHN_PURCH',
                        visible: false
                    },
                    {
                        data: 'CON_SALES',
                        visible: false
                    },
                    {
                        data: 'IPTV',
                        visible: false
                    },

                ],
            });

            // $('#cab-table').dataTable({
            //     ajax: 'dynamic_load?x=cabpen&z='+dat,
            //     dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            //     buttons: {
            //         buttons: [
            //             { extend: 'copy', className: 'btn' },
            //             { extend: 'excel', className: 'btn' },
            //         ]
            //     },
            //     columns: [{
            //         data: 'RTOM',
            //         visible: false,
            //     },
            //         {
            //             data: 'LEA'
            //         },
            //         {
            //             "render": function(data, type, row, meta) {
            //                 if (row['CON_STATUS']  == 'ASSIGNED'){
            //                     //return 'Triple Play';
            //                     data = '<a style="color: #0E0EFF; " href="sod_assign?sod=' + row['SO_NUM'] + '_' + row['CON_STATUS'] + '_' + row['CON_WORO_SEIT'] + '_CAB' +'" target="_blank">' + row['SO_NUM'] + '</a>';
            //                 }
            //                 if (row['CON_STATUS']  == 'INPROGRESS'){
            //                     data = '<a style="color: #0E0EFF; " href="sod_details?sod=' + row['SO_NUM'] + '_' + row['CON_STATUS'] + '_' + row['CON_WORO_SEIT'] + '_CAB' +'" target="_blank">' + row['SO_NUM'] + '</a>';
            //                 }
            //                 if (row['CON_STATUS']  == 'OSP_CLOSED'){
            //                     data = '<a style="color: #0E0EFF; " href="sod_details?sod=' + row['SO_NUM'] + '_' + row['CON_STATUS'] + '_' + row['CON_WORO_SEIT'] + '_CAB' +'" target="_blank">' + row['SO_NUM'] + '</a>';
            //                 }
            //                 return data;
            //             }
            //         },
            //         {
            //             data: 'VOICENUMBER'
            //         },
            //         {
            //             data: 'S_TYPE'
            //         },
            //         {
            //             data: 'ORDER_TYPE'
            //         },
            //         {
            //             data: 'CON_WORO_TASK_NAME'
            //         },
            //         {
            //             data: 'CON_STATUS_DATE'
            //         },
            //         {
            //             data: 'PKG'
            //         },
            //         {
            //             "render": function(data, type, row, meta) {
            //
            //                 if (row['CON_STATUS']  == 'ASSIGNED'){
            //                     //return 'Triple Play';
            //                     return  '<a style="color: #0E9A00; font-weight: bold">'+row['CON_STATUS']+' </a>';
            //                 }
            //                 if (row['CON_STATUS']  == 'INPROGRESS'){
            //                     return  '<a style="color: #f8db22; font-weight: bold">'+row['CON_STATUS']+' </a>';
            //                 }
            //                 if (row['CON_STATUS']  == 'OSP_CLOSED'){
            //                     return  '<a style="color: #f10e74; font-weight: bold">'+row['CON_STATUS']+' </a>';
            //                 }
            //             }
            //         },
            //         {
            //             data: 'CON_CUS_NAME',
            //             visible: false
            //         },
            //         {
            //             data: 'CON_TEC_CONTACT',
            //             visible: false
            //         },
            //         {
            //             data: 'ADDRE',
            //             visible: false
            //         },
            //         {
            //             data: 'DP',
            //             visible: false
            //         },
            //         {
            //             data: 'CON_OSP_PHONE_CLASS',
            //             visible: false
            //         },
            //         {
            //             data: 'CON_PHN_PURCH',
            //             visible: false
            //         },
            //         {
            //             data: 'CON_SALES',
            //             visible: false
            //         },
            //         {
            //             data: 'IPTV',
            //             visible: false
            //         },
            //
            //
            //     ],
            // });

            $('#peoftth-table').dataTable({
                ajax: 'dynamic_load?x=peoftthpen&z='+dat,
                dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'btn' },
                        { extend: 'excel', className: 'btn' },
                    ]
                },
                columns: [{
                    data: 'RTOM',
                    visible: false,
                },
                    {
                        data: 'LEA'
                    },
                    {
                        "render": function(data, type, row, meta) {
                            if (row['CON_STATUS']  == 'ASSIGNED'){
                                //return 'Triple Play';
                                data = '<a style="color: #0E0EFF; " href="sod_assign?sod=' + row['SO_NUM'] + '_' + row['CON_STATUS'] + '_' + row['CON_WORO_SEIT'] + '_PEO' +'" target="_blank">' + row['SO_NUM'] + '</a>';
                            }
                            if (row['CON_STATUS']  == 'INPROGRESS'){
                                data = '<a style="color: #0E0EFF; " href="sod_detailsiptv?sod=' + row['SO_NUM'] + '_' + row['CON_STATUS'] + '_' + row['CON_WORO_SEIT'] + '_PEO' +'" target="_blank">' + row['SO_NUM'] + '</a>';
                            }
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
                        data: 'CON_WORO_TASK_NAME'
                    },
                    {
                        data: 'CON_STATUS_DATE'
                    },
                    {
                        data: 'PKG'
                    },
                    {
                        "render": function(data, type, row, meta) {

                            if (row['CON_STATUS']  == 'ASSIGNED'){
                                //return 'Triple Play';
                                return  '<a style="color: #0E9A00; font-weight: bold">'+row['CON_STATUS']+' </a>';
                            }
                            if (row['CON_STATUS']  == 'INPROGRESS'){
                                return  '<a style="color: #f8db22; font-weight: bold">'+row['CON_STATUS']+' </a>';
                            }
                            if (row['CON_STATUS']  == 'OSP_CLOSED'){
                                return  '<a style="color: #f10e74; font-weight: bold">'+row['CON_STATUS']+' </a>';
                            }
                        }
                    },
                    {
                        data: 'CON_CUS_NAME',
                        visible: false
                    },
                    {
                        data: 'CON_TEC_CONTACT',
                        visible: false
                    },
                    {
                        data: 'ADDRE',
                        visible: false
                    },
                    {
                        data: 'MSAN',
                        visible: false
                    },
                    {
                        data: 'CARDPORT',
                        visible: false
                    },
                    {
                        data: 'CON_PHN_PURCH',
                        visible: false
                    },
                    {
                        data: 'CON_SALES',
                        visible: false
                    },

                ],
            });

            // $('#peocab-table').dataTable({
            //     ajax: 'dynamic_load?x=peocopperpen&z='+dat,
            //     dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            //     buttons: {
            //         buttons: [
            //             { extend: 'copy', className: 'btn' },
            //             { extend: 'excel', className: 'btn' },
            //         ]
            //     },
            //     columns: [{
            //         data: 'RTOM',
            //         visible: false,
            //     },
            //         {
            //             data: 'LEA'
            //         },
            //         {
            //             "render": function(data, type, row, meta) {
            //                 if (row['CON_STATUS']  == 'ASSIGNED'){
            //                     //return 'Triple Play';
            //                     data = '<a style="color: #0E0EFF; " href="sod_assign?sod=' + row['SO_NUM'] + '_' + row['CON_STATUS'] + '_' + row['CON_WORO_SEIT'] + '_PEO' +'" target="_blank">' + row['SO_NUM'] + '</a>';
            //                 }
            //                 if (row['CON_STATUS']  == 'INPROGRESS'){
            //                     data = '<a style="color: #0E0EFF; " href="sod_details?sod=' + row['SO_NUM'] + '_' + row['CON_STATUS'] + '_' + row['CON_WORO_SEIT'] + '_PEO' +'" target="_blank">' + row['SO_NUM'] + '</a>';
            //                 }
            //                 if (row['CON_STATUS']  == 'OSP_CLOSED'){
            //                     data = '<a style="color: #0E0EFF; " href="sod_details?sod=' + row['SO_NUM'] + '_' + row['CON_STATUS'] + '_' + row['CON_WORO_SEIT'] + '_PEO' +'" target="_blank">' + row['SO_NUM'] + '</a>';
            //                 }
            //                 return data;
            //             }
            //         },
            //         {
            //             data: 'VOICENUMBER'
            //         },
            //         {
            //             data: 'S_TYPE'
            //         },
            //         {
            //             data: 'ORDER_TYPE'
            //         },
            //         {
            //             data: 'CON_WORO_TASK_NAME'
            //         },
            //         {
            //             data: 'CON_STATUS_DATE'
            //         },
            //         {
            //             data: 'PKG'
            //         },
            //         {
            //             "render": function(data, type, row, meta) {
            //
            //                 if (row['CON_STATUS']  == 'ASSIGNED'){
            //                     //return 'Triple Play';
            //                     return  '<a style="color: #0E9A00; font-weight: bold">'+row['CON_STATUS']+' </a>';
            //                 }
            //                 if (row['CON_STATUS']  == 'INPROGRESS'){
            //                     return  '<a style="color: #f8db22; font-weight: bold">'+row['CON_STATUS']+' </a>';
            //                 }
            //                 if (row['CON_STATUS']  == 'OSP_CLOSED'){
            //                     return  '<a style="color: #f10e74; font-weight: bold">'+row['CON_STATUS']+' </a>';
            //                 }
            //             }
            //         },
            //         {
            //             data: 'CON_CUS_NAME',
            //             visible: false
            //         },
            //         {
            //             data: 'CON_TEC_CONTACT',
            //             visible: false
            //         },
            //         {
            //             data: 'ADDRE',
            //             visible: false
            //         },
            //         {
            //             data: 'MSAN',
            //             visible: false
            //         },
            //         {
            //             data: 'CARDPORT',
            //             visible: false
            //         },
            //         {
            //             data: 'CON_PHN_PURCH',
            //             visible: false
            //         },
            //         {
            //             data: 'CON_SALES',
            //             visible: false
            //         },
            //
            //     ],
            // });

            $('#opmcpat-table').dataTable({
                ajax: 'dynamic_load?x=opmcpatrej&z='+dat,
                dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'btn' },
                        { extend: 'excel', className: 'btn' },
                    ]
                },
                columns: [{
                    data: 'RTOM',
                    visible: false,
                },
                    {
                        data: 'LEA'
                    },
                    {
                        "render": function(data, type, row, meta) {
                            if (row['CON_STATUS']  == 'PAT_OPMC_REJECTED'){
                                data = '<a style="color: #770337; " href="sod_details?sod=' + row['SO_NUM'] + '_PATOPMC_' + row['CON_WORO_SEIT'] + '_FTTH' +'" target="_blank">' + row['SO_NUM'] + '</a>';
                            }
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
                        data: 'CON_WORO_TASK_NAME'
                    },
                    {
                        data: 'CON_STATUS_DATE'
                    },
                    {
                        data: 'PKG'
                    },
                    {
                        "render": function(data, type, row, meta) {

                            if (row['CON_STATUS']  == 'PAT_OPMC_REJECTED'){
                                return  '<a style="color: #f10e74; font-weight: bold">'+row['CON_STATUS']+' </a>';
                            }
                        }
                    },
                    {
                        data: 'CON_CUS_NAME',
                        visible: false
                    },
                    {
                        data: 'CON_TEC_CONTACT',
                        visible: false
                    },
                    {
                        data: 'ADDRE',
                        visible: false
                    },
                    {
                        data: 'DP',
                        visible: false
                    },
                    {
                        data: 'CON_OSP_PHONE_CLASS',
                        visible: false
                    },
                    {
                        data: 'CON_PHN_PURCH',
                        visible: false
                    },
                    {
                        data: 'CON_SALES',
                        visible: false
                    },
                    {
                        data: 'IPTV',
                        visible: false
                    },

                ],
            });

        }



    }



</script>


<script>
    var ss = $(".basic").select2({

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


<!-- JAVASCRIPT --->
</body>
</html>


