<?php
session_start();
$img = $_SESSION['ldap_img'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>CORK Admin - Multipurpose Bootstrap Dashboard Template </title>
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
            <div class="col-xl-12 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">

                <div class="user-profile layout-spacing">
                    <div class="widget-content widget-content-area">
                        <div class="page-title">
                            <h4>User Info</h4><hr/>

                        </div>
                        <div class="text-center user-info">
                            <?php   echo '<img class=\"flag-width\" src="data:image/png;base64,' . base64_encode($img) . '" style="border-radius: 50%; width:100px; height:100px"/>'; ?>
                            <br/><br/><br/>
                            <h6 class="card-category text-gray"><?php echo $_SESSION['ldap_tit'] ?></h6>
                            <h4 class="card-title"><?php echo $_SESSION['ldap_name'] ?></h4>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">
                            <div class="form-group">
                                <label class="bmd-label-floating" style="font-size: 15px;color: #00b0ff">Username</label><br/>
                                <label  ><?php echo $_SESSION['user'] ?></label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">
                            <div class="form-group">
                                <label class="bmd-label-floating" style="font-size: 15px;color: #00b0ff">Username</label><br/>
                                <label  ><?php echo $_SESSION['user'] ?></label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">
                            <div class="form-group">
                                <label class="bmd-label-floating" style="font-size: 15px;color: #00b0ff">Username</label><br/>
                                <label  ><?php echo $_SESSION['user'] ?></label>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
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

    document.getElementById("dash").className = "menu single-menu ";
    document.getElementById("sod").className = "menu single-menu ";
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