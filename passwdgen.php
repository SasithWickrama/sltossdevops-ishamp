<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include "db/DbOperations.php";
$db = new DbOperations;


$result="";


function randomPassword() {
    $alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

if(isset($_POST["q"]) && $_POST["q"]== 'sendPasswd' ) {

    $passwd = randomPassword();
    $hash = md5($passwd);

    $getUserMob=$db->getUser($_POST["uname"],$_POST["utype"]);



    if($getUserMob[0] != ''){

        $update_pwd = $db->update_passwd($hash, $getUserMob[0]);
        $db->logPasswd($_POST["uname"],$getUserMob[0],$passwd);

        $msg = "your username : $getUserMob[1] and Password : ".$passwd;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.25.36.45:22550/sltdevops/apiServices/sms',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "tpno": "'.$getUserMob[0].'",
            "msg": "'.$msg.'" ,
            "senduser": "OSS"
        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = "success#Password sent to registered Mobile no . You will Recieve a SMS shortly.";

        //
//        $wsdl = 'http://172.25.37.196:8080/Smssystem/smsSending?WSDL';
//
//        $trace = true;
//        $exceptions = false;
//
//        $xml_array['tps'] = $getUserMob[0];
//        $xml_array['msg'] = "your username : $getUserMob[1] and Password : ".$passwd;
//        $xml_array['sender'] = 'OSS';
//        $xml_array['owner'] = 'SLTCMS';
//        $xml_array['pwd'] = '!23qweASD';
//
//        try
//        {
//            $client = new SoapClient($wsdl, array('trace' => $trace, 'exceptions' => $exceptions));
//            $response = $client->smsdirectx($xml_array);
//            $result = "success#Password sent to registered Mobile no . You will Recieve a SMS shortly.";
//
//        }
//        catch (Exception $e)
//        {
//            $result = 'failed#Last response: '. $client->__getLastResponse();
//        }

        //return $response;




}else{
        $result = "failed#Invalid Login Details.";
    }


}

echo  $result;
?>