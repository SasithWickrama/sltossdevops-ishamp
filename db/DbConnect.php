<?php

class DbConnect{

    function connect(){

        include "Constants.php";

        //============
        $db = "(DESCRIPTION =
            (ADDRESS = (PROTOCOL = TCP)(HOST = ".DB_HOST.")(PORT = ".DB_PORT."))
            (CONNECT_DATA =(SERVER = DEDICATED)(SERVICE_NAME = hadwh))
        )";

        try {
            $conn = new PDO("oci:dbname=".$db, DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }

    }

    function connectOssRpt(){

        include "Constants.php";

        //============
        $db = "(DESCRIPTION =
            (ADDRESS_LIST =
              (ADDRESS = (PROTOCOL = TCP)(HOST =  ".DB_HOST.")(PORT = ".DB_PORT."))
            )
            (CONNECT_DATA = (SID=clty))
          )
        ";

        try {
            $conn = new PDO("oci:dbname=".$db, DB_USER_OSSRPT, DB_PASSWORD_OSSRPT);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

}


$servername = "localhost";
$username = "username";
$password = "password";



