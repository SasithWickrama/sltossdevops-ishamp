<?php

session_start();
$token = md5(uniqid(rand(), TRUE));
$_SESSION['token'] = $token;

include "db/DbOperations.php";
$db = new DbOperations;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>i-Shamp - passwd</title>
    <link rel="icon" type="image/x-icon" href="assets/img/icon.PNG"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
    <link href="plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="form">


<div class="form-container outer">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">


                    <h3>Password Generate</h3><br/><hr/><br/>


                    <div  class="text-left">
                        <input type="hidden" name="token" value="<?php echo $token; ?>" />
                        <div class="form">

                            <div id="username-field" class="field-wrapper input">
                                <label for="username" style="font-size: small; font-weight: bold">USERNAME</label>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <input id="username" name="username" type="text" class="form-control" placeholder="username">
                            </div>
                            <br/>
                            <div id="con-field" class="field-wrapper input mb-2">
                                <label for="username" style="font-size: small; font-weight: bold">USER CATAGORY</label>
                                <select class="form-control   basic" id="usertype" name="usertype">
                                    <option value="" >--- SELECT CONTRACTOR ---</option>
                                    <option value="SLT" >SLT</option>
                                    <?php
                                    $getCont = $db->getCont();
                                    foreach( $getCont as $row ) {
                                        ?>
                                        <option value="<?php echo $row[0]; ?>" ><?php echo $row[0]; ?> </option>


                                    <?php } ?>
                                </select>
                            </div>
                            <br/>

                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper" id="reqpwd">
                                    <button class="btn btn-primary" onclick="generatePwd()">Generate</button>
                                </div>
                            </div>
                            <hr/>


                            <p class="signup-link"> <a href="login">LOGIN</a></p>

                            <hr/>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="assets/js/authentication/form-2.js"></script>
<script src="plugins/notification/snackbar/snackbar.min.js"></script>
<script src="assets/js/components/notification/custom-snackbar.js"></script>

<script>

    function generatePwd(){

        var uname = document.getElementById('username').value;
        var utype = document.getElementById('usertype').value;

            var q = 'sendPasswd';
            $.ajax({

                type: "POST",
                url: "passwdgen",
                data: {q: q, uname: uname, utype: utype},
                success: function (data) {
                    if(data.split("#")[0] == 'success'){
                        Snackbar.show({
                            text: data.split("#")[1],
                            actionTextColor: '#fff',
                            backgroundColor: '#6ccb09',
                            pos: 'top-center',
                        });

                        setTimeout(function(){window.location='login';}, 3000);
                    }else{

                        Snackbar.show({
                            text: data.split("#")[1],
                            actionTextColor: '#fff',
                            backgroundColor: '#ea081a',
                            pos: 'top-center',
                        });

                        setTimeout(function(){location.reload();}, 3000);
                    }

                }
            });




    }
</script>

</body>
</html>
