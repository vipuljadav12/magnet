<?php
set_time_limit(0);
ini_set('memory_limit', '-1');
include('functions.php');
include_once('dbClass.php');
$type = 'student_storedgrades';
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
        $data_fetch = false;
        if(isset($_GET['id']))
        {
            $data_fetch = true;
            $SQL = "SELECT * FROM submissions WHERE id in (".$_GET['id'].")";
            $rs = $objDB->select($SQL);    
        }
        else
        {
            $SQL = "SELECT * FROM submissions WHERE student_id != '' AND grade_exists = 'N' LIMIT 1";
            $rs = $objDB->select($SQL);

            $application_id = $rs[0]['application_id'];

            $SQL = "SELECT fetch_grades_cdi, ending_date FROM application WHERE id = '".$application_id."'";
            
            $rs_application = $objDB->select($SQL);
            if(count($rs_application) > 0)
            {
                $data_fetch = false;
                if($rs_application[0]['fetch_grades_cdi'] == "now")
                    $data_fetch = true;
                else
                {
                    if(strtotime(date("Y-m-d H:i:s")) > strtotime($rs_application[0]['ending_date']))
                    {
                        $data_fetch = true;
                    }
                }
            }

        }

        

        if($data_fetch)
        {
            
            for($i=0; $i < count($rs); $i++)
            {

                $SQL = "SELECT dcid, student_id FROM student WHERE stateID = '".$rs[$i]['student_id']."'";
                $rsS = $objDB->select($SQL);
                $powerSchoolRecords = getPowerSchoolRecords(
                    $type, 
                    $accessTokenKey, 
                    $url, 
                    array(
                        "submission_id"=>$rs[$i]['id'], 
                        "student_id"=>($rsS[0]['student_id'] ?? ''),
                        "submission" => $rs,
                        "DB"=>$objDB
                    )
                );

                $SQL = "UPDATE submissions SET  grade_exists = 'Y' WHERE id = '".$rs[$i]['id']."'";
                $rs1 = $objDB->sql_query($SQL);
            } 
        }
        
    }
} else {
    echo "Invalid Token";
}

