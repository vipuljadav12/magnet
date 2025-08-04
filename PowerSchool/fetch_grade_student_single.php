<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
include('functions.php');
include_once('dbClass.php');
$type = 'student_storedgrades1';
$url = 'https://huntsvillecs.powerschool.com';
$clientID = 'c9d982cd-011e-4ed4-991b-bca6540b4988';
$clientSecret = '7888e8d5-86b2-4e5b-afc3-3cd0a482115e';

$objDB = new MySQLCN; 

echo "T".base64_decode("V3JvbmcgUXVlcnkgOiBTRUxFQ1QgKiBGUk9NIHBzX3Rlcm1zIFdIRVJFIGRjaWQgPSAnMzAwMCc8YnI+VGFibGUgJ2hjc19saXZlLnBzX3Rlcm1zJyBkb2Vzbid0IGV4aXN0");
exit;

$accessToken = getAccessToken($url, $clientID, $clientSecret);
$accessTokenArray = json_decode($accessToken);

if (!empty($accessTokenArray)) {
    $accessTokenKey = $accessTokenArray->access_token;
    $accessTokenType = $accessTokenArray->token_type;
    $accessTokenExpiresIn = $accessTokenArray->expires_in;
    
    if (isset($accessTokenKey) && !empty($accessTokenKey)) {
        $SQL = "SELECT dcid FROM student WHERE stateID = ".$_REQUEST['id'];
            $rsS = $objDB->select($SQL);
            //print_r($rsS);exit;
            $powerSchoolRecords = getPowerSchoolRecords($type, $accessTokenKey, $url, array("student_id"=>$rsS[0]['dcid'], "stateID"=>$_REQUEST['id']));
            echo $powerSchoolRecords;
    }
} else {
    echo "Invalid Token";
}
