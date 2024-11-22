<?php

    session_start();

    $rjimgc = $_SESSION['RjctImg'];

    if($rjimgc == '' || $rjimgc<0){

        $rjimgc = 0;

    }

    if($_POST['q'] == 'rjctImg'){

        $_SESSION['RjctImg'] = $rjimgc+1;

    }

    if($_POST['q'] == 'acptImg'){

        $_SESSION['RjctImg'] = $rjimgc-1;

    }

?>
