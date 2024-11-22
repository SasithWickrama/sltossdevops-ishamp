
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
            <?php if ($_GET['id'] == '1'){ ?>

                <br/><div class="page-header">
                    <div class="page-title">
                        <h4>Material Specifications</h4>

                    </div>

                </div><hr1/>

                <div class="row layout-top-spacing">

                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget-four">
                            <div class="widget-content">
                                <div class="vistorsBrowser"">
                                    <h6><a href="pdfview?fname=FWS Specification_V2.pdf"  target="_blank" >Fiber Wall Socket Specification </a></h6>
                                    <h6><a href="pdfview?fname=Optical fiber drop wire 1C specification_V3_10_12_2018.pdf"  target="_blank">Optical fiber drop wire 1C Specification </a></h6>
                                    <h6><a href="pdfview?fname=Patch Cord SpecificationV3.pdf"  target="_blank">Fiber Patch Cord Specification </a></h6>
                                    <h6><a href="pdfview?fname=Specification-FAC.pdf"  target="_blank">FAC Specification</a></h6>
                                    <h6><a href="pdfview?fname=Specification - Fiber Sleeve.pdf"  target="_blank">Fiber Fusion Splice Sleeve Specification</a></h6>
                                    <h6><a href="pdfview?fname=Specification_V2 --Fibre Drop Wire Retainer.pdf"  target="_blank">Fiber Drop Wire Retainer Specification </a></h6>
                                    <h6><a href="pdfview?fname=FTTH E2E - Fiber Distribution Point(FDP) - 05.10.2018.pdf"  target="_blank">Fiber Distribution Point(FDP)</a></h6>
                                    <h6><a href="pdfview?fname=FTTH E2E -Splitter.pdf"  target="_blank">Splitter</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 002-Specification-ConcretePolesSLTReinforced.pdf"  target="_blank">Concrete Poles – SLT Reinforced</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 012 - Specification - Polythene Insulated PVC Sheathed Telephone Distribution Cable (PVC Twin).pdf"  target="_blank">Polythene Insulated PVC Sheathed Telephone Distribution Cable (PVC Twin)</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 013 - Specification - Steel Band and Buckle.pdf"  target="_blank">Steel Band and Buckle</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 014 - Specification-  L Hook.pdf"  target="_blank">L Hook</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 021 - Specification - C Hook.pdf"  target="_blank">C Hook</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 032 - Specification - Aerial Cable Fittings for Circular Spun Cast Pole.pdf"  target="_blank">Aerial Cable Fittings for Circular Spun Cast Pole</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 049 - Specification - Aerial Cable Fittings Revised Specification.pdf"  target="_blank">Aerial Cable Fittings Revised Specification</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 026 - Specification - Cable Guy Grip.pdf"  target="_blank">Cable Guy Grip</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 015- Specification - Staple Wire Cable Clip (5mm).pdf"  target="_blank">Staple Wire Cable Clip (5mm)</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 019 - Specification - Staple Wire Cable Clip (4mm).pdf"  target="_blank">Staple Wire Cable Clip (4mm)</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 027 - Specification - Duct Sealing Kit.pdf"  target="_blank">Duct Sealing Kit</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 033 - Specification - Rosette Wire.pdf"  target="_blank">Rosette Wire</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 034 - Specification - Splice Closure.pdf"  target="_blank">Splice Closure</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 046 - Specification for RJ-9,RJ-11, RJ-45.pdf"  target="_blank">RJ-9,RJ-11, RJ-45</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 037 - Specification - UTP Cables - CAT5E.pdf"  target="_blank">UTP Cables - CAT5E</a></h6>
                                    <h6><a href="pdfview?fname=OQMS SGD 042 - Specification - UTP Cables – CAT6.pdf"  target="_blank">UTP Cables – CAT6</a></h6>


                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            <?php } ?>

            <?php if ($_GET['id'] == '2'){ ?>

                <br/><div class="page-header">
                    <div class="page-title">
                        <h3>Guidelines/Standards</h3>
                    </div>

                </div>

                <div class="row layout-top-spacing">

                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget-four">
                            <div class="widget-content">
                                <div class="vistorsBrowser">
                                    <h6><a href="pdfview?fname=FTTH HOME PASS  V5_03_02_2022.pdf"  target="_blank">FTTH Home Pass guideline </a></h6>
                                    <h6><a href="pdfview?fname=Installation standards_Issue_ANPS GNC 001.pdf"  target="_blank">FTTH Home Connect guideline</a></h6>
                                    <h6><a href="pdfview?fname=Guideline for New Connection provisioning _ FTTH and Copper_Issue 6.pdf"  target="_blank">Copper new connection installation guideline </a></h6>
                                    <h6><a href="pdfview?fname=Sample Inspection through Image Analyzing V1.pdf"  target="_blank">CD Image Photo PAT for new connections </a></h6>
                                    <h6><a href="pdfview?fname=PSTN Telephone Test Number Facility.pdf"  target="_blank">Guideline on Voice Service Test Facility at Customer Premises </a></h6>
                                    <h6><a href="pdfview?fname=Guideline on Best Practices of FDP Installation and Maintenance.pdf"  target="_blank">Guideline on Best Practices of FDP Installation and Maintenance </a></h6>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            <?php } ?>

            <?php if ($_GET['id'] == '3'){ ?>

                <br/><div class="page-header">
                    <div class="page-title">
                        <h3>Other Documents</h3>
                    </div>

                </div>

                <div class="row layout-top-spacing">

                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget-four">
                            <div class="widget-content">
                                <div class="vistorsBrowser">
                                    <h6><a href="pdfview?fname=Short listed supplier list for fiber OSP materials.pdf"  target="_blank">Short listed supplier list for fiber OSP materials</a></h6>


                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            <?php } ?>
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

    document.getElementById("dash").className = "menu single-menu ";
    document.getElementById("sod").className = "menu single-menu ";
    document.getElementById("faults").className = "menu single-menu ";
    document.getElementById("quality").className = "menu single-menu ";
    document.getElementById("inbox").className = "menu single-menu ";
    document.getElementById("user").className = "menu single-menu ";
    document.getElementById("invoice").className = "menu single-menu ";
    document.getElementById("doc").className = "menu single-menu active";
</script>
<!-- JAVASCRIPT --->
</body>
</html>