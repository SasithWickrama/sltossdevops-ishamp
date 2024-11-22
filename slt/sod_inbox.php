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
    <title>i-Shamp - Inbox</title>
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
                    <h4>SLT INBOX</h4>

                </div>

            </div><hr/>

            <div class="row layout-top-spacing">
                <!--  ==================  -->
                <div class="col-lg-12 col-12 layout-spacing"  id="dataView">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area border-top-tab">
                            <ul class="nav nav-tabs mb-12 mt-3" id="borderTop" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="border-top-profile-tab" data-toggle="tab" href="#ftth" role="tab" aria-controls="border-top-profile" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">FTTH</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="border-top-home-tab" data-toggle="tab" href="#cab" role="tab" aria-controls="border-top-home" aria-selected="true"><span style="font-weight: bold; font-size: 16px;">MEGALINE</span> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="border-top-pro-tab" data-toggle="tab" href="#peo" role="tab" aria-controls="border-top-profile" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">PEO TV</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="border-top-pro-tab" data-toggle="tab" href="#return" role="tab" aria-controls="border-top-profile" aria-selected="false"><span style="font-weight: bold; font-size: 16px;">RETURNED</span></a>
                                </li>
                            </ul>
                            <div class="tab-content" id="borderTopContent">
                                <div class="tab-pane fade" id="cab" role="tabpanel" aria-labelledby="border-top-home-tab">
                                    <table  class="display nowrap table table-striped table-bordered" id="cab-table" style="font-size:13px;">

                                        <thead class="thead-light">

                                        <tr>
                                            <th><input type="checkbox" id="chkAll"></th>
                                            <th>RTOM</th>
                                            <th>LEA</th>
                                            <th>SOD</th>
                                            <th>VOICE NUMBER</th>
                                            <th style="display:none">SERVICE TYPE</th>
                                            <th>ORDER</th>
                                            <th>RECIEVED DATE</th>
                                            <th>CUSTOMER</th>
                                            <th>CONTACT</th>
                                            <th>ADDRESS</th>
                                            <th>DP NAME</th>
                                            <th style="display:none">PHONE CLASS</th>
                                            <th style="display:none">PHN PURCH</th>
                                            <th>PACKAGE</th>
                                            <th>TASK NAME</th>
                                            <th>IPTV</th>
                                            <th>EX NO</th>
                                        </tr>

                                        </thead>

                                        <tbody id="ftthtbl">



                                        </tbody>
                                    </table>

                                    <!-- ===== -->
                                    <br/>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <select class="form-control  basic" name="cabcon" id="cabcon" required>
                                                <option value="">Select Contractor ...</option>
                                                <option value="SLT">SLT</option>
                                                <option value="SLTS">SLTS</option>
                                                <option value="SLTVC">SLTVC</option>


                                            </select>
                                        </div>


                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <input id="cabcomment" name="cabcomment" value="" class="form-control " type="text" placeholder="Comment..." style="height: 40px;">
                                        </div>

                                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <button class="btn btn-info mb-4" style="height: 40px;" id="cabButton"  name="cabButton" >ASSIGN</button>
                                        </div>
                                    </div>
                                    <!-- ===== -->
                                </div>

                                <div class="tab-pane fade  show active" id="ftth" role="tabpanel" aria-labelledby="border-top-profile-tab">
                                    <table class="display nowrap table table-striped table-bordered" id="ftth-table" style="font-size:13px;">

                                        <thead class="thead-light">

                                        <tr>
                                            <th><input type="checkbox" id="chkAllftth"></th>
                                            <th>RTOM</th>
                                            <th>LEA</th>
                                            <th>SOD</th>
                                            <th>VOICE NUMBER</th>
                                            <th style="display:none">SERVICE TYPE</th>
                                            <th>ORDER</th>
                                            <th>RECIEVED DATE</th>
                                            <th>CUSTOMER</th>
                                            <th>CONTACT</th>
                                            <th>ADDRESS</th>
                                            <th>DP NAME</th>
                                            <th style="display:none">PHONE CLASS</th>
                                            <th style="display:none">PHN PURCH</th>
                                            <th>PACKAGE</th>
                                            <th>TASK NAME</th>
                                            <th>IPTV</th>
                                            <th>EX NO</th>
                                        </tr>

                                        </thead>

                                        <tbody id="ftthtbl">

                                        </tbody>
                                    </table>

                                    <!-- ===== -->
                                    <br/>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <select class="form-control  basic" name="ftthcon" id="ftthcon" required>
                                                <option value="">Select Contractor ...</option>

                                                <?php
                                                $getCont = $db->getCont();
                                                foreach( $getCont as $row ) {
                                                    ?>
                                                    <option value="<?php echo $row[0]; ?>" ><?php echo $row[0]; ?> </option>


                                                <?php } ?>

                                            </select>
                                        </div>


                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <input id="ftthcomment" name="ftthcomment" value="" class="form-control " type="text" placeholder="Comment..." style="height: 40px;">
                                        </div>

                                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <button class="btn btn-info mb-4" style="height: 40px;" id="ftthButton"  name="ftthButton" >ASSIGN</button>
                                        </div>
                                    </div>
                                    <!-- ===== -->
                                </div>

                                <div class="tab-pane fade" id="peo" role="tabpanel" aria-labelledby="border-top-pro-tab">
                                    <table class="display nowrap table table-striped table-bordered" id="peo-table" style="font-size:13px;">

                                        <thead class="thead-light">

                                        <tr>
                                            <th><input type="checkbox" id="chkAllpeo"></th>
                                            <th>RTOM</th>
                                            <th>LEA</th>
                                            <th>SOD</th>
                                            <th>VOICE NUMBER</th>
                                            <th>SERVICE</th>
                                            <th>ORDER</th>
                                            <th>RECEIVED DATE</th>
                                            <th>CUSTOMER</th>
                                            <th>CONTACT</th>
                                            <th>ADDRESS</th>
                                            <th style="display:none">PHN PURCH</th>
                                            <th>PACKAGE</th>
                                            <th>TASK NAME</th>
                                            <th>EX NO</th>
                                        </tr>

                                        </thead>

                                        <tbody id="peotbl">


                                        </tbody>
                                    </table>
                                    <!-- ===== -->
                                    <br/>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <select class="form-control  basic" name="peocon" id="peocon" required>
                                                <option value="">Select Contractor ...</option>
                                                <?php
                                                $getCont = $db->getCont();
                                                foreach( $getCont as $row ) {
                                                    ?>
                                                    <option value="<?php echo $row[0]; ?>" ><?php echo $row[0]; ?> </option>


                                                <?php } ?>


                                            </select>
                                        </div>


                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <input id="peocomment" name="peocomment" value="" class="form-control " type="text" placeholder="Comment..." style="height: 40px;">
                                        </div>

                                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <button class="btn btn-info mb-4" style="height: 40px;" id="peoButton"  name="peoButton">ASSIGN</button>
                                        </div>
                                    </div>
                                    <!-- ===== -->
                                </div>

                                <div class="tab-pane fade" id="return" role="tabpanel" aria-labelledby="border-top-return-tab">
                                    <table class="display nowrap table table-striped table-bordered" id="return-table" style="font-size:13px;">

                                        <thead class="thead-light">

                                        <tr>
                                            <th>RTOM</th>
                                            <th>LEA</th>
                                            <th>SOD</th>
                                            <th>VOICE NUMBER</th>
                                            <th>ORDER</th>
                                            <th>SERVICE</th>
                                            <th>CONTRACTOR</th>
                                            <th>RETURN DATE</th>
                                            <th>RETURN REASON</th>
                                            <th>COMMENT</th>
                                        </tr>

                                        </thead>

                                        <tbody id="rtntbl">


                                        </tbody>
                                    </table>
                                    <!-- ===== -->
                                    <br/>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <select class="form-control  basic" name="peocon" id="peocon" required>
                                                <option value="">Select Contractor ...</option>
                                                <?php
                                                $getCont = $db->getCont();
                                                foreach( $getCont as $row ) {
                                                    ?>
                                                    <option value="<?php echo $row[0]; ?>" ><?php echo $row[0]; ?> </option>


                                                <?php } ?>


                                            </select>
                                        </div>


                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <input id="peocomment" name="peocomment" value="" class="form-control " type="text" placeholder="Comment..." style="height: 40px;">
                                        </div>

                                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                                            <button class="btn btn-info mb-4" style="height: 40px;" id="peoButton"  name="peoButton">ASSIGN</button>
                                        </div>
                                    </div>
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
        document.getElementById("quality").className = "menu single-menu ";
        document.getElementById("inbox").className = "menu single-menu active";
        document.getElementById("user").className = "menu single-menu ";
        document.getElementById("invoice").className = "menu single-menu ";
        document.getElementById("doc").className = "menu single-menu ";


        //$('#cab-table').dataTable({
        //    ajax: 'dynamic_load.php?x=cab_assign&y=<?php //echo $_SESSION["uarea"];?>//',
        //    dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
        //    scrollX: true,
        //    buttons: {
        //        buttons: [
        //            { extend: 'copy', className: 'btn' },
        //            { extend: 'excel', className: 'btn' },
        //            { extend: 'print', className: 'btn' }
        //        ]
        //    },
        //    columns: [{
        //            "render": function(data, type, row, meta) {
        //                return '<input type="checkbox" id="checkboxcab">';
        //
        //            }
        //        },
        //        {
        //            data: 'RTOM'
        //        },
        //        {
        //            data: 'LEA'
        //        },
        //        {
        //            data: 'SO_NUM'
        //        },
        //        {
        //            data: 'VOICENUMBER'
        //        },
        //        {
        //            data: 'S_TYPE',
        //            visible: false
        //        },
        //        {
        //            data: 'ORDER_TYPE'
        //        },
        //        {
        //            data: 'CON_STATUS_DATE'
        //        },
        //        {
        //            data: 'CON_CUS_NAME'
        //        },
        //        {
        //            data: 'CON_TEC_CONTACT'
        //        },
        //        {
        //            data: 'ADDRE'
        //        },
        //        {
        //            data: 'DP',
        //            visible: false
        //        },
        //        {
        //            data: 'CON_OSP_PHONE_CLASS',
        //            visible: false
        //        },
        //        {
        //            data: 'CON_PHN_PURCH',
        //            visible: false
        //        },
        //        {
        //            data: 'PKG'
        //        },
        //        {
        //            data: 'CON_WORO_TASK_NAME'
        //        },
        //        {
        //            data: 'IPTV'
        //        },
        //        {
        //            data: 'EX_NO'
        //
        //        },
        //
        //
        //
        //    ],
        //});

        $('#ftth-table').dataTable({
            ajax: 'dynamic_load.php?x=ftth_assign&y=<?php echo $_SESSION["uarea"];?>',
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
                "render": function(data, type, row, meta) {
                    return '<input type="checkbox" id="checkboxftth">';

                }
            },
                {
                    data: 'RTOM'
                },
                {
                    data: 'LEA'
                },
                {
                    data: 'SO_NUM'
                },
                {
                    data: 'VOICENUMBER'
                },
                {
                    data: 'S_TYPE',
                    visible: false
                },
                {
                    data: 'ORDER_TYPE'
                },
                {
                    data: 'CON_STATUS_DATE'
                },
                {
                    data: 'CON_CUS_NAME'
                },
                {
                    data: 'CON_TEC_CONTACT'
                },
                {
                    data: 'ADDRE'
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
                    //data: 'PKG'
                    "render": function(data, type, row, meta) {
                        if (row['PKG'] == 'VOICE_INT_IPTV'){
                            return 'Triple Play';
                        }
                        if (row['PKG'] == 'VOICE_INT'){
                            return 'Double Play-BB';
                        }
                        if (row['PKG'] == 'VOICE_IPTV'){
                            return 'Double Play - PeoTV';
                        }
                        if (row['PKG'] == 'VOICE'){
                            return 'Single Play';
                        }
                    }
                },
                {
                    data: 'CON_WORO_TASK_NAME'
                },
                {
                    data: 'IPTV'
                },
                {
                    data: 'EX_NO'
                },



            ],
        });

        $('#peo-table').dataTable({
            ajax: 'dynamic_load.php?x=peo_assign&y=<?php echo $_SESSION["uarea"];?>',
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
                "render": function(data, type, row, meta) {
                    return '<input type="checkbox" id="checkboxpeo">';

                }
            },
                {
                    data: 'RTOM'
                },
                {
                    data: 'LEA'
                },
                {
                    data: 'SO_NUM'
                },
                {
                    data: 'CON_PSTN_NUMBER'
                },
                {
                    data: 'S_TYPE',
                },
                {
                    data: 'ORDER_TYPE'
                },
                {
                    data: 'CON_STATUS_DATE'
                },
                {
                    data: 'CON_CUS_NAME'
                },
                {
                    data: 'CON_TEC_CONTACT'
                },
                {
                    data: 'ADDRE'
                },
                {
                    data: 'CON_PHN_PURCH',
                    visible: false
                },
                {
                    data: 'PKG'
                },
                {
                    data: 'CON_WORO_TASK_NAME'
                },
                {
                    data: 'EX_NO'
                },

            ],
        });

        $('#return-table').dataTable({
            ajax: 'dynamic_load.php?x=return_pending&y=<?php echo $_SESSION["uarea"];?>',
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            scrollX: true,
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'excel', className: 'btn' },
                    { extend: 'print', className: 'btn' }
                ]
            },
            columns: [
                {
                    data: 'RTOM'
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
                    data: 'VOICENUMBER'
                },
                {
                    data: 'ORDER_TYPE'
                },
                {
                    data: 'S_TYPE'
                },
                {
                    data: 'CON_NAME'
                },
                {
                    data: 'RETURNED_DATE'
                },
                {
                    data: 'RETURNED_REASON'
                },
                {
                    data: 'RETURNED_COMMENT'
                },

            ],
        });



    });
</script>


<script>
    $('#chkAll').click(function (e) {
        $('#cab-table tbody :checkbox').prop('checked', $(this).is(':checked'));
        e.stopImmediatePropagation();
    });

        $('#chkAllftth').click(function (e) {
        $('#ftth-table tbody :checkbox').prop('checked', $(this).is(':checked'));
        e.stopImmediatePropagation();
    });

        $('#chkAllpeo').click(function (e) {
        $('#peo-table tbody :checkbox').prop('checked', $(this).is(':checked'));
        e.stopImmediatePropagation();
    });

//     $('#chkAll').click(function(event) {
// console.log('testing');
//         if(this.checked) {
//             $('#checkboxcab').each(function() {
//                 this.checked = true;
//             });
//         } else {
//             $('#checkboxcab').each(function() {
//                 this.checked = false;
//             });
//         }
//
//     });

    // $('#chkAllftth').click(function(event) {
    //
    //     if(this.checked) {
    //         $('#checkboxftth').each(function() {
    //             this.checked = true;
    //         });
    //     } else {
    //         $('#checkboxftth').each(function() {
    //             this.checked = false;
    //         });
    //     }
    //
    // });
    //
    // $('#chkAllpeo').click(function(event) {
    //
    //     if(this.checked) {
    //         $('#checkboxpeo').each(function() {
    //             this.checked = true;
    //         });
    //     } else {
    //         $('#checkboxpeo').each(function() {
    //             this.checked = false;
    //         });
    //     }
    //
    // });

    var ss = $(".basic").select2({

    });



    $(document).on('click','#cabButton',function(){

        var conName = $('#cabcon').val();
        var table = document.getElementById('cab-table');
        var rowCount = $('#cab-table tr').length;

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

        }else if(conName == ''){
            Snackbar.show({
                text: 'Select Contractor',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        }else{

            for(var n=1; n < rowCount; n++){
                if (table.rows[n].cells[0].childNodes[0].checked == true){
                    var info =[];
                    info[0] = table.rows[n].cells[4].innerHTML;
                    info[1] = $('#cabcon').val();
                    info[2] = table.rows[n].cells[3].innerHTML;
                    info[3] = table.rows[n].cells[13].innerHTML;
                    info[4] = $('#cabcomment').val();

                    var q='1';
                    $.ajax({
                        type:"post",
                        url:"../db/DbFunctions",
                        data: {info:info,q:q},
                        success:function(data){
                            if(data == "success"){
                                Snackbar.show({
                                    text: 'Service Order assign success',
                                    actionTextColor: '#fff',
                                    backgroundColor: '#6ccb09',
                                    pos: 'top-center',
                                });
                                setTimeout(function () {
                                    location.reload()
                                }, 3000);

                            }else{
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

    $(document).on('click','#ftthButton',function(){

        var conName = $('#ftthcon').val();
        var table = document.getElementById('ftth-table');
        var rowCount = $('#ftth-table tr').length;

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

        }else if(conName == ''){
            Snackbar.show({
                text: 'Select Contractor',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        }else{

            for(var n=1; n < rowCount; n++){
                document.getElementById("loader").style.visibility = "visible";

                if (table.rows[n].cells[0].childNodes[0].checked == true){
                    var info =[];
                    info[0] = table.rows[n].cells[4].innerHTML;
                    info[1] = $('#ftthcon').val();
                    info[2] = table.rows[n].cells[3].innerHTML;
                    info[3] = table.rows[n].cells[13].innerHTML;
                    info[4] = $('#ftthcomment').val();
                    info[5] = 'FTTH';

                    var q='1';
                    $.ajax({
                        type:"post",
                        url:"../db/DbFunctions",
                        data: {info:info,q:q},
                        success:function(data){
                            if(data == "success"){
                                document.getElementById("loader").style.visibility = "hidden";
                                Snackbar.show({
                                    text: 'Service Order assign success',
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

    $(document).on('click','#peoButton',function(){
        var conName = $('#peocon').val();
        var table = document.getElementById('peo-table');
        var rowCount = $('#peo-table tr').length;

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

        }else if(conName == ''){
            Snackbar.show({
                text: 'Select Contractor',
                actionTextColor: '#fff',
                backgroundColor: '#e7515a',
                pos: 'bottom-right',
            });
        }else{

            for(var n=1; n < rowCount; n++){
                if (table.rows[n].cells[0].childNodes[0].checked == true){
                    var info =[];
                    info[0] = table.rows[n].cells[4].innerHTML;
                    info[1] = $('#peocon').val();
                    info[2] = table.rows[n].cells[3].innerHTML;
                    info[3] = table.rows[n].cells[13].innerHTML;
                    info[4] = $('#peocomment').val();
                    info[5] = 'PEO';
                    var q='1';
                    $.ajax({
                        type:"post",
                        url:"../db/DbFunctions",
                        data: {info:info,q:q},
                        success:function(data){
                            if(data == "success"){
                                Snackbar.show({
                                    text: 'Service Order assign success',
                                    actionTextColor: '#fff',
                                    backgroundColor: '#6ccb09',
                                    pos: 'top-center',
                                });
                                setTimeout(function () {
                                    location.reload()
                                }, 3000);

                            }else{
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

