<?php
    set_time_limit(0);
    ini_set('memory_limit','2048M');
    include("common_functions.php");
    
    include("dbClass.php");
    $objDB = new MySQLCN;
    $dob='2006-10-04';
$data = fetch_inow_details( 'students?dateOfBirth='.$dob );
echo "<pre>";
print_r($data);exit;
    $rs = $objDB->select("SELECT * FROM submissions WHERE id in (2174,3240,3245,3246,3249,3254,3255,3256,3258,3267,3275,3278,3286,3290,3292,3293,3294,3298,3300,3303,3304,3305,3306,3307,3308,3312,3325,3326,3327,3333,3334,3336,3339,3342,3343,3344,3345,3350,3351,3352,3354,3355,3357,3358,3359,3361,3362,3365,3369,3370,3371,3375,3378,3384,3389,3390,3391,3394,3399,3401,3402,3404,3407,3413,3421,3422,3423,3425,3427,3428,3429,3430,3436)");

    for($i=0 ;$i < count($rs); $i++)
    {
        $dob = $rs[$i]['birthday'];
        $stateID = $rs[$i]['student_id'];
        $data = fetch_inow_details( 'students?dateOfBirth='.$dob );

        foreach($data as $student)
        {
            if($student->StateIdNumber == $stateID)
            {
                $dataNew = array();
                $dataNew['first_name'] = $student->FirstName;
                $dataNew['last_name'] = $student->LastName;
                $dataNew['middle_name'] = $student->MiddleName;
                $dataNew['IsHispanic'] = ($student->IsHispanic != '' ? 1 : 0);
                $dataNew['studentFileNumber'] = $student->StudentNumber;
                $dataNew['stateID'] = $student->StateIdNumber;
                $dataNew['student_id'] = $student->Id;
                $dataNew['race'] = '';
                $dataNew['birthday'] = $dob;
                $dataNew['address'] = "";
                $dataNew['city'] = "";
                $dataNew['state'] = "";
                $dataNew['zip'] = "";
                $dataNew['gender'] = "";
                $dataNew['parent_first_name'] = "";
                $dataNew['parent_last_name'] = "";


                //$current_grade = intval($student->Grade);
                $dataNew['current_grade'] = 0;

                $rs1 = $objDB->select("SELECT * from student_1 where stateID = '".$stateID."'");
                if(count($rs1) <= 0)
                {
                    $SQL = "INSERT INTO student_1 SET ";
                    foreach($dataNew as $dnkey=>$dnvalue)
                    {
                        $SQL .= $dnkey.' = "'.addslashes($dnvalue).'",';
                    }
                    $SQL = trim($SQL, ",");
                    $SQL .= ", created_at='".date("Y-m-d H:i:s")."'";
                    $rs2 = $objDB->insert($SQL);  

                }
            }
        }

    }
    exit;
    $ethnicities = fetch_inow_details( 'students?dateOfBirth=2003-05-01' );
     echo "<pre>";
    print_r($ethnicities);exit;
    foreach( $ethnicities as $ethnicity ){
        $race_hash[ $ethnicity->Id ] = $ethnicity->Name;
    }

    // Get all student ethnicities
    $student_race_hash = array();
    $ethnicities = fetch_inow_details( 'persons/ethnicities' );
     echo "<pre>";
    print_r($ethnicities);exit;
    foreach( $ethnicities as $ethnicity ){
    	$SQL = "SELECT * FROM student_race WHERE studentId = '".$ethnicity->PersonId."' AND race = '".$race_hash[ $ethnicity->EthnicityId ]."'";
    	$rs = $objDB->select($SQL);

    	if(count($rs) > 0)
    	{
    		$SQL = "DELETE FROM student_race WHERE studentId = '".$ethnicity->PersonId."' AND race = '".$race_hash[ $ethnicity->EthnicityId ]."'";
    		$rs = $objDB->sql_query($SQL);
    	}
    		$SQL = "INSERT INTO student_race SET studentId = '".$ethnicity->PersonId."', race = '".$race_hash[ $ethnicity->EthnicityId ]."', is_primary = '".($ethnicity->IsPrimary == 1 ? "Y" : "N")."', percentage = '".$ethnicity->Percentage."'";
    		$rs = $objDB->sql_query($SQL);


    	
    }

/*    echo "<pre>";
    print_r($ethnicities);

    //print_r($student_race_hash);
  //exit;
    // Get all schools
    $schools_hash = array();
    $schools = fetch_inow_details('students/285487');//details?studentNumber=S34489');
    //$schools = fetch_inow_details('students/details?studentNumber=S34489');
    print_r($schools);exit;
*/
?>