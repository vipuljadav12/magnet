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

            $SQL = "SELECT * FROM submissions WHERE student_id != '' AND id in (4220,4219,4216,4214,4209,4208,4205,4204,4203,4202,4201,4200,4199,4192,4191,4190,4187,4186,4185,4184,4180,4178,4177,4176,4173,4170,4169,4163,4155,4154,4152,4142,4141,4135,4127,4124,4120,4118,4116,4112,4110,4109,4104,4099,4094,4092,4090,4085,4084,4083,4082,4081,4079,4078,4076,4075,4074,4073,4072,4070,4069,4067,4064,4062,4058,4054,4053,4051,4050,4047,4043,4041,4039,4038,4036,4027,4026,4021,4006,3998,3997,3992,3991,3988,3986,3985,3980,3973,3970,3969,3968,3967,3966,3965,3964,3963,3962,3957,3950,3946,3944,3940,3938,3937,3934,3933,3932,3931,3930,3927,3926,3919,3918,3917,3915,3914,3913,3910,3909,3908,3907,3906,3905,3904,3903,3901,3900,3896,3895,3879,3876,3857,3856,3855,3849,3833,3832,3831,3828,3826,3824,3818,3817,3810,3809,3799,3796,3790,3786,3784,3782,3776,3773,3770,3768,3760,3756,3750,3724,3722,3721,3709,3690,3686,3685,3684,3679,3678,3676,3671,3668,3664,3652,3650,3643,3639,3619,3612,3611,3609,3606,3604,3603,3602,3582,3577,3573,3569,3544,3537,3528,3524,3513,3511,3505,4434,4407,4398,4350,4294,4266,4259,4230,4221,4211,4210,4207,4206,4188,4164,4147,4146,4144,4137,4130,4121,4113,4091,4028,4020,4018,4013,4001,3959,3956,3948,3945,3929,3928,3890,3868,3867,3866,3862,3858,3821,3813,3811,3807,3769,3744,3728,3726,3713,3707,3702,3683,3680,3655,3605,3536,4421,4394,4384,4376,4368,4339,4324,4320,4311,4306,4288,4193,4128,4071,4046,4037,4003,3982,3954,3953,3951,3921,3870,3869,3843,3840,3838,3834,3825,3823,3816,3812,3800,3781,3772,3761,3753,3732,3727,3720,3681,3669,3600,3599,3594,3578,3541,3530,4374,4365,4298,4226,4093,3975,3814)";

            
            $rsSUB = $objDB->select($SQL);


            for($iSub=0; $iSub < count($rsSUB); $iSub++)
            {

                $SQL = "SELECT dcid, student_id FROM student WHERE stateID = '".$rsSUB[$iSub]['student_id']."'";
                $rsS = $objDB->select($SQL);
                $powerSchoolRecords = getPowerSchoolRecords(
                    $type, 
                    $accessTokenKey, 
                    $url, 
                    array(
                        "submission_id"=>$rsSUB[$iSub]['id'], 
                        "student_id"=>($rsS[0]['student_id'] ?? ''),
                        "submission" => $rsSUB,
                        "DB"=>$objDB
                    )
                );

                $SQL = "UPDATE submissions SET  grade_exists = 'Y' WHERE id = '".$rsSUB[$iSub]['id']."'";
                $rs1 = $objDB->sql_query($SQL);
            } 


        }

        
    }
} else {
    echo "Invalid Token";
}

