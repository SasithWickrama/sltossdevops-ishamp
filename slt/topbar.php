<?php
$area = $_SESSION["area"];
$role = $_SESSION["urole"];
$utype = $_SESSION["utype"];
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
                        <a href="index" class="nav-link"> TechsPro </a>
                    </li>
                </ul>

                <ul class="list-unstyled menu-categories" id="topAccordion">
                <!-- Dashboead -->
                    <li class="menu single-menu active" id="dash">
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
                                <a href="sod_megaftth"> Megline / FTTH </a>
                            </li>
                            <li class="active">
                                <a href="sod_search"> Search </a>
                            </li>
<!--                            <li class="active">-->
<!--                                <a href="sod_smart"> Smart Home </a>-->
<!--                            </li>-->
<!--                            <li class="active">-->
<!--                                <a href=""> Fleet Management </a>-->
<!--                            </li>-->
<!--                            <li class="active">-->
<!--                                <a href="">Collect CPE</a>-->
<!--                            </li>-->
<!--                            <li class="active">-->
<!--                                <a href="">Reports</a>-->
<!--                            </li>-->

                        </ul>
                    </li>
                <!-- Faults -->
                    <li class="menu single-menu" id="faults">
                        <a href="#components" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" disabled="">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                <span style="font-size: 16px; font-weight: bold">Faults</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
<!--                        <ul class="collapse submenu list-unstyled" id="components" data-parent="#topAccordion">-->
<!--                            <li class="active">-->
<!--                                <a href=""> Consumer </a>-->
<!--                            </li>-->
<!--                            <li class="active">-->
<!--                                <a href=""> Enterprise  </a>-->
<!--                            </li>-->
<!--                            <li class="active">-->
<!--                                <a href=""> Reports  </a>-->
<!--                            </li>-->
<!---->
<!--                        </ul>-->
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
<!--                                <a href="qty_assign"> Assign </a>-->
<!--                            </li>-->
<!--                            <li class="active">-->
<!--                                <a href="qty_details"> Details </a>-->
<!--                            </li>-->
<!--                            <li class="active">-->
<!--                                <a href="qty_reports"> Reports </a>-->
<!--                            </li>-->
<!---->
<!--                        </ul>-->
                    </li>
                <!-- Inbox -->
                    <li class="menu single-menu " id="inbox" >
                        <a href="#tables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                <span style="font-size: 16px; font-weight: bold">Inbox</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="tables"  data-parent="#topAccordion">
                            <li class="active">

                            <a href="sod_inbox">Assign Service Orders </a>
                            </li>
                            <li class="active">

                            <a href=""> Incentive Service Orders </a>
                            </li>
                            <li class="active">
                            <a href=""> Data Service Orders </a>
                            </li>
                            <?php if($role == 'PAT' && $utype = 'SLT_OPMC'){ ?>
                            <li class="active">
                                <a href="opmc_pat"> PAT </a>
                            </li>
                            <?php } ?>

                        </ul>
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
<!--                            <li class="sub-sub-submenu-list active">-->
<!--                                <a href="#datatable" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> Contractor Details <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>-->
<!--                                <ul class="collapse list-unstyled sub-submenu" id="datatable" data-parent="#datatable">-->
<!--                                    <li class="active">-->
<!---->
<!--                                    <a href="con_user_list"> User Details </a>-->
<!--                                    </li>-->
<!--                                    <li class="active">-->
<!---->
<!--                                    <a href="team_details"> Teams </a>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!---->
<!--                            <li class="sub-sub-submenu-list active">-->
<!--                                <a href="#datatable" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> OPMC Staff <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>-->
<!--                                <ul class="collapse list-unstyled sub-submenu" id="datatable" data-parent="#datatable">-->
<!--                                    <li class="active">-->
<!---->
<!--                                    <a href=""> Group Details</a>-->
<!--                                    </li>-->
<!--                                    <li class="active">-->
<!---->
<!--                                    <a href=""> Technician Details </a>-->
<!--                                    </li>-->
<!--                                    <li class="active">-->
<!---->
<!--                                    <a href=""> SA / SF Details </a>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </li>-->
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
<!--                            <li class="sub-sub-submenu-list active">-->
<!--                                <a href="#datatable" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> Incentive Invoice <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>-->
<!--                                <ul class="collapse list-unstyled sub-submenu" id="datatable" data-parent="#datatable">-->
<!--                                    <li class="active">-->
<!---->
<!--                                    <a href=""> Generate </a>-->
<!--                                    </li>-->
<!--                                    <li class="active">-->
<!---->
<!--                                    <a href=""> Details</a>-->
<!--                                    </li>-->
<!--                                    <li class="active">-->
<!---->
<!--                                    <a href=""> Teams </a>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!---->
<!--                            <li class="sub-sub-submenu-list active">-->
<!--                                <a href="#datatable" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> OPMC Staff <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>-->
<!--                                <ul class="collapse list-unstyled sub-submenu" id="datatable" data-parent="#datatable">-->
<!--                                    <li class="active">-->
<!---->
<!--                                    <a href=""> Group Details</a>-->
<!--                                    </li>-->
<!--                                    <li class="active">-->
<!---->
<!--                                    <a href=""> Technician Details </a>-->
<!--                                    </li>-->
<!--                                    <li class="active">-->
<!---->
<!--                                    <a href=""> SA / SF Details </a>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!--                        </ul>-->
                    </li>
                <!-- Documents -->
                    <li class="menu single-menu" id="doc">
                        <a href="#page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                <span style="font-size: 16px; font-weight: bold">Docs</span>
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
                        <?php if($role == 'PAT_PRO' && $utype == 'SLT_PROJECT'){ ?>
                        <ul class="collapse submenu list-unstyled" id="page"  data-parent="#topAccordion">

                            <li class="active">
                                <a href="pat"> PAT Pending </a>
                            </li>
                            <li class="active">
                                <a href="pat_result"> PAT Results </a>
                            </li>
                            <li class="active">
                                <a href="bom_list"> BOM List </a>
                            </li>


                        </ul>
                        <?php }?>
                    </li>

                </ul>
            </nav>
        </div>