<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
include('functions.php');
include_once('dbClass.php');
$type = 'students';
$url = 'https://huntsvillecs.powerschool.com';
$clientID = 'c9d982cd-011e-4ed4-991b-bca6540b4988';
$clientSecret = '7888e8d5-86b2-4e5b-afc3-3cd0a482115e';

$objDB = new MySQLCN; 



$accessToken = getAccessToken($url, $clientID, $clientSecret);
$accessTokenArray = json_decode($accessToken);

if (!empty($accessTokenArray)) {
    $accessTokenKey = $accessTokenArray->access_token;
    $accessTokenType = $accessTokenArray->token_type;
    $accessTokenExpiresIn = $accessTokenArray->expires_in;
    
    if (isset($accessTokenKey) && !empty($accessTokenKey)) {
            $powerSchoolRecords = getPowerSchoolRecords($type, $accessTokenKey, $url, array());

    }
} else {
    echo "Invalid Token";
}
?>