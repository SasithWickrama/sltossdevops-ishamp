<?php
session_start();
$img = $_SESSION['ldap_img'];

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
{
    $user = $_SESSION["user"];
    $contractor_name = $_SESSION["contractor"];
    $area = $_SESSION["area"];
    $temp = explode('/',$area);
    $n = sizeof($temp);

    $areasArr = array();
    $areaArr = explode('/',$area);
    for($i=0; $i<sizeof($areaArr); $i++){
        $areasArr[$i]= "$areaArr[$i]";
    }
    $areas = implode(",",$areasArr);

}
else
{
    echo '<script type="text/javascript"> document.location = "login.php";</script>';
}
?>

<div class="header-container">
    <header class="header navbar navbar-expand-sm">

        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a>

        <div class="nav-logo align-self-center">
            <img src="../assets/img/logo2.png" width="118" height="35">
        </div>

        <ul class="navbar-item flex-row mr-auto">
            <li class="nav-item align-self-center search-animated">
                </li>
        </ul>

        <ul class="navbar-item flex-row nav-dropdowns">

            <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="user-profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media">
                        <?php   echo '<img class=\"flag-width\" src="data:image/png;base64,' . base64_encode($img) . '" style="border-radius: 50%; width:30px; height:30px"/>'; ?>
                        <div class="media-body align-self-center">
                            <h6><span>Welcome,</span> <?php echo $_SESSION['ldap_name'] ?></h6>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </a>
                <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="user-profile-dropdown">
                    <div class="">
                        <div class="dropdown-item">
                            <a class="" href="user_profile.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> My Profile</a>
                        </div>
                        <div class="dropdown-item">
                            <a class="" href="../login"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Sign Out</a>
                        </div>
                    </div>
                </div>

            </li>
        </ul>
    </header>
</div>
