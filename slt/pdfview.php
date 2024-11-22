
<?php
//ini_set('max_execution_time', 300);
//session_start();
//if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
//{
//    $user = $_SESSION["user"];
//    $contractor_name = $_SESSION["contractor"];
//    $area = $_SESSION["area"];
//    $temp = explode('/',$area);
//    $n = sizeof($temp);
//
//    $refno=date("ymdHis");
//
//    $fetfname = $_GET['fname'];
//}
//else
//{
//    echo '<script type="text/javascript"> document.location = "Login.php";</script>';
//}
//
$fetfname = $_GET['fname'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Quality Documents</title>
    <style type="text/css">
        html {
            overflow: auto;
        }

        html,
        body,
        div,
        iframe {
            margin: 0px;
            padding: 0px;
            height: 100%;
            border: none;
        }

        iframe {
            display: block;
            width: 100%;
            border: none;
            overflow-y: auto;
            overflow-x: hidden;
        }
    </style>
</head>

<body>
<iframe src="../Document/<?php echo $fetfname; ?>#Frames"
        frameborder="0"
        marginheight="0"
        marginwidth="0"
        width="100%"
        height="100%"
        scrolling="auto">
</iframe>

</body>

</html>
