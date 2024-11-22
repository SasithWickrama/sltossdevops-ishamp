<?php
$area = $_SESSION["area"];
$role =$_SESSION["urole"];
$areasArr = array();
$areaArr = explode('/',$area);
for($i=0; $i<sizeof($areaArr); $i++){
    $areasArr[$i]= "$areaArr[$i]";
}
$areas = implode(",",$areasArr);


?>
<div class="topbar-nav header navbar" role="banner">
            <nav id="topbar">
                <ul class="navbar-nav theme-brand flex-row  text-center">
                    <li class="nav-item theme-text">
                        <a href="index" class="nav-link">  </a>
                    </li>
                </ul>

                <ul class="list-unstyled menu-categories" id="topAccordion">
                <!-- Dashboard -->
                    <li class="menu single-menu " id="dash">
                        <a href="index" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle autodroprown">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span style="font-size: 16px; font-weight: bold">Dashboard</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
<!--                        <ul class="collapse submenu list-unstyled" id="dashboard" data-parent="#topAccordion">-->
<!--                            <li class="active">-->
<!--                                <a href="index"> Analytics </a>-->
<!--                            </li>-->
<!--                        </ul>-->

                    </li>
                <!-- Service Order -->
                    <li class="menu single-menu" id="sod">
                        <a href="#app" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                <span style="font-size: 16px; font-weight: bold">Service Order</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="app" data-parent="#topAccordion">
                            <li class="active">
                                <a href="solist"> Pending Orders</a>
                            </li>
                            <li class="active">
                                <a href="con_sod_list"> Service Order Reports</a>
                            </li>
                            <li class="active">
                                <a href="sod_search"> Search</a>
                            </li>

                        </ul>
                    </li>
                <!-- Faults -->
                    <li class="menu single-menu" id="datasod">
                        <a href="#components" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                <span style="font-size: 16px; font-weight: bold">Data Service</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="components" data-parent="#topAccordion">
                            <li class="active">
                                <a href="con_data_list?id=pen"> Pending </a>
                            </li>
                            <li class="active">
                                <a href="con_data_list?id=com"> Completed </a>
                            </li>
                            <li class="active">
                                <a href="sod_search?id=data"> Search</a>
                            </li>
                        </ul>
                    </li>
                <!-- Quality -->
                    <li class="menu single-menu" id="quality">
                        <a href="#uiKit" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                <span style="font-size: 16px; font-weight: bold">Quality</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
<!--                        <ul class="collapse submenu list-unstyled" id="uiKit" data-parent="#topAccordion">-->
<!--                            <li class="active">-->
<!--                                <a href="con_qty_detail?id=rej"> Rejected </a>-->
<!--                            </li>-->
<!--                            <li class="active">-->
<!--                                <a href="con_qty_detail?id=cor"> Reject Correctd </a>-->
<!--                            </li>-->
<!---->
<!--                        </ul>-->
                    </li>
                <!-- Users -->
                    <li class="menu single-menu" id="user">
                        <a href="#forms" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <span style="font-size: 16px; font-weight: bold">Users</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
<!--                        <ul class="collapse submenu list-unstyled" id="tables"  data-parent="#topAccordion" >-->
<!--                            <li class="active">-->
<!---->
<!--                                <a href="con_user"> User Details</a>-->
<!--                            </li>-->
<!--                            <li class="active">-->
<!---->
<!--                                <a href="con_team?id=1"> Team Details</a>-->
<!--                            </li>-->
<!--                            <li class="active">-->
<!---->
<!--                                <a href="con_team?id=2"> Team Details Report</a>-->
<!--                            </li>-->
<!--                            <li class="active">-->
<!---->
<!--                                <a href="mob_team">Mobile User Details</a>-->
<!--                            </li>-->
<!---->
<!--                        </ul>-->
                    </li>
                <!-- Invoice -->
                    <li class="menu single-menu" id="invoice">
                        <a href="#page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                <span style="font-size: 16px; font-weight: bold">Invoices</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
<!--                        <ul class="collapse submenu list-unstyled" id="tables"  data-parent="#topAccordion" >-->
<!--                            <li class="active">-->
<!---->
<!--                                <a href=""> Generate</a>-->
<!--                            </li>-->
<!--                            <li class="active">-->
<!---->
<!--                                <a href=""> List</a>-->
<!--                            </li>-->
<!---->
<!--                        </ul>-->
                    </li>
                <!-- Documents -->
                    <li class="menu single-menu" id="doc">
                        <a href="#page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                <span style="font-size: 16px; font-weight: bold">Documentation</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="page"  data-parent="#topAccordion">
                            <li class="active">

                            <a href="documentation_doc?id=1"> Material Specifications </a>
                            </li>
                            <li class="active">

                            <a href="documentation_doc?id=2"> Guidelines/Standards </a>
                            </li>

                            <li class="active">

                            <a href="documentation_doc?id=3"> Other Documents </a>
                            </li>


                        </ul>
                    </li>
                    <!-- PAT -->
                    <li class="menu single-menu" id="pat">
                        <a href="#page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                <span style="font-size: 16px; font-weight: bold">PAT</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="page"  data-parent="#topAccordion">
                            <li class="active">
                                <a href="pat_result"> PAT Results </a>
                            </li>
                            <li class="active">
                                <a href="bom_result"> BOM Pending </a>
                            </li>
                            <li class="active">
                                <a href="bom_list"> BOM List </a>
                            </li>


                        </ul>
                    </li>
                </ul>
            </nav>
        </div>