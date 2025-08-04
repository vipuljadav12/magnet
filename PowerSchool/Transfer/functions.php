<?php
function getAccessToken($url, $clientID, $clientSecret) {

    $curl = curl_init();
    $authData = http_build_query(array(
        'client_id' => $clientID,
        'client_secret' => $clientSecret,
        'grant_type' => 'client_credentials'
    ));
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $authData);
    curl_setopt($curl, CURLOPT_URL, $url . '/oauth/access_token');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    //$request = curl_getinfo($curl);
    //var_dump($request);

    $result = curl_exec($curl);
    
    if (!$result) {
        echo 'Curl Error: ' . curl_error($curl) . '<br />';
        die("Connection Failure");
    }
    curl_close($curl);
    //print_r($result);exit;
    return $result;
}

function getPowerSchoolRecords($type, $accessTokenKey, $url, $sdata) {
    global $objDB;

  
    $response = false;
    $queryName = '';
    switch ($type) {
        case 'schools':
            $queryName = 'org.magnet_hcs.schools.hs_schools';
        break;
        case 'students':
            $queryName 
            = 'org.magnet_hcs.students.hs_students';
        break;
        case 'studentrace':
            $queryName = 'org.magnet_hcs.races.hs_races';
        break;
        case 'gen':
            $queryName = 'org.magnet_hcs.general.hs_general';
        break;
        case 'cc':
            $queryName = 'org.magnethcs.cc.hs_cc';
        break;
        case 'courses':
            $queryName = 'org.magnethcs.courses.hs_courses';
        break;
        case 'storedgrades':
            $queryName = 'org.magnethcs.storedgrades.hs_storedgrades';
        break;
        case 'student_storedgrades':
            $queryName = 'org.magnet_hcs.student_storedgrades.hs_student_storedgrades';
        break;
        case 'student_storedgrades1':
            $queryName = 'org.magnet_hcs.student_storedgrades.hs_student_storedgrades';
        break;
        case 'pgfinalgrades':
            $queryName = 'org.magnethcs.finalgrades.hs_finalgrades';
        break;
        case 'sections':
            $queryName = 'org.magnethcs.sections.hs_sections';
        break;
        case 'terms':
            $queryName = 'org.magnethcs.terms.hs_terms';
        break;
        case 'schoolstaff':
            $queryName = 'org.magnethcs.schoolstaff.hs_schoolstaff';
        break;
        case 'users':
            $queryName = 'org.magnethcs.teachers.hs_teachers';
        break;
        case 'fee':
            $queryName = 'org.magnethcs.fee.hs_fee';
        break;
        case 'fees':
            $queryName = 'org.magnethcs.fees.hs_fees';
        break;
        case 'feetype':
            $queryName = 'org.magnethcs.feetype.hs_feetype';
        break;
        case 'schoolfee':
            $queryName = 'org.magnethcs.schoolfee.hs_schoolfee';
        break;
        case 'coursefee':
            $queryName = 'org.magnet.coursefee.hs_coursefee';
        break;
    }
    if (!empty($type) && $type == "schools") {
        $resource = $url . '/ws/schema/query/' . $queryName.'?pagesize=0';
        $payload = '{}';
        
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n".
                    "Authorization: Bearer $accessTokenKey\r\n",
                'content' => $payload
            )
        );
        //echo "<pre>"; print_r($opts); exit;
        //Call the server's oauth gateway
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                            "Authorization: Bearer $accessTokenKey"
            ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_URL, $resource);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($curl);

//        $result = file_get_contents($resource, false, stream_context_create($opts));
        //Get the JSON data
        $jsonData = json_decode($result, true);
     //   echo base64_decode('V3JvbmcgUXVlcnkgOiBJTlNFUlQgSU5UTyBwc19zY2hvb2xzIFNFVCBuYW1lID0gIkFjYWQgZm9yIEFjYWRlbWljcyAmIEFydHMgRVMiLGRjaWQgPSAiNjQiLHNjaG9vbF9pZCA9ICIyNSIsc2Nob29semlwID0gIjM1ODEwIixsb3dfZ3JhZGUgPSAiLTMiLGhpZ2hfZ3JhZGUgPSAiNSI8YnI+VW5rbm93biBjb2x1bW4gJ3NjaG9vbHppcCcgaW4gJ2ZpZWxkIGxpc3Qn');exit;//"<pre>"; print_r($jsonData); exit;
        
        //Collapse the array a bit if there is data
        $hsRecords = array();
        $exist = [];
        if (isset($jsonData['record'])) {
            foreach ($jsonData['record'] as $item) {
                $gdata = [];
                $gdata['name'] = $item['tables']['schools']['name'];
                $gdata['dcid'] = $item['tables']['schools']['dcid'];
                $gdata['school_id'] = $item['tables']['schools']['school_number'];
                $gdata['schoolzip'] = $item['tables']['schools']['schoolzip'];
                $gdata['low_grade'] = $item['tables']['schools']['low_grade'];
                $gdata['high_grade'] = $item['tables']['schools']['high_grade'];

                $SQL = "INSERT INTO ps_schools SET ";
                foreach($gdata as $k=>$v)
                {
                    $SQL .= $k.' = "'.$v.'",';
                }
                $SQL = trim($SQL, ",");
                $rs = $objDB->sql_query($SQL);
            }
        }

    }
    else if (!empty($type) && $type == "gen") {
        $resource = $url . '/ws/schema/query/' . $queryName.'?pagesize=0';
        $payload = '{}';
        

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n".
                    "Authorization: Bearer $accessTokenKey\r\n",
                'content' => $payload
            )
        );
        //echo "<pre>"; print_r($opts); exit;
        //Call the server's oauth gateway
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                            "Authorization: Bearer $accessTokenKey"
            ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_URL, $resource);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($curl);
        //Get the JSON data
        $jsonData = json_decode($result, true);
        echo "<pre>"; print_r($jsonData); exit;
        
        //Collapse the array a bit if there is data
        $hsRecords = array();
        $exist = [];
        if (isset($jsonData['record'])) {
            foreach ($jsonData['record'] as $item) {
                $gdata = [];
                $gdata['value2'] = $item['tables']['gen']['value2'];
                $gdata['dcid'] = $item['tables']['gen']['dcid'];
                $gdata['valuet'] = $item['tables']['gen']['valuet'];
                $gdata['cat'] = $item['tables']['gen']['cat'];
                $gdata['name'] = $item['tables']['gen']['name'];
                $gdata['id'] = $item['tables']['gen']['id'];
                $gdata['value'] = $item['tables']['gen']['value'];

                $SQL = "INSERT INTO ps_general SET ";
                foreach($gdata as $k=>$v)
                {
                    $SQL .= $k.' = "'.$v.'",';
                }
                $SQL = trim($SQL, ",");
                $rs = $objDB->sql_query($SQL);
            }
        }

    }
    elseif (!empty($type) && $type == "student_storedgrades1") {
        $resource = $url . '/ws/schema/query/' . $queryName.'?pagesize=0';
        
        $payload = json_encode(array("StudentID" => $sdata['student_id']));
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                            "Authorization: Bearer $accessTokenKey"
            ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_URL, $resource);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);


        $result = curl_exec($curl);
        $jsonData = json_decode($result, true);
   

        $yrArr = [];
        $yrArr[] = date("Y");
        $yrArr[] = date("Y")-1;
        $yrArr[] = date("Y")-2;

        $gradeData = "<thead><tr><th>Academic Year</th><th>Academic Term</th><th>Cours Type</th><th>Numeric Grade</th></tr></thead><tbody>";
        
        //Collapse the array a bit if there is data
        $hsRecords = array();
        $exist = [];
        if (isset($jsonData['record'])) {
            foreach ($jsonData['record'] as $item) {

                $term = $item['tables']['storedgrades']['termid'];
                if($term > 3100 && $term < 3200)
                    $term = 3100;

                $academicYear = ($term/100) + 1990;
                $yrid = $academicYear;// ."-".($academicYear+1);
                 
                //echo $yrid."<BR>";

                if($yrid != '' && in_array($yrid, $yrArr))
                {
                    //$yrid = (1990 + $term_data[0]['yearid'];
                    $term = $yrid . "-".($yrid+1);
                    $gdata = [];
                    $gdata['stateID'] = $sdata['student_id'];
                    $gdata['academicYear'] = $term;
                    $gdata['GradeName'] = $gdata['academicTerm'] = str_replace(" Grade", "", $item['tables']['storedgrades']['storecode'])." Grade";

                    if(strpos(strtolower($item['tables']['storedgrades']['course_name']), 'math') !== false  || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'geometry') !== false  || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'algebra') !== false  || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'precalculus') !== false ) {
                        $gdata['courseTypeID'] = 18;
                        $gdata['courseType'] = "Math";

                    }
                    else if(strpos(strtolower($item['tables']['storedgrades']['course_name']), 'read') !== false) {
                        $gdata['courseTypeID'] = 39;
                        $gdata['courseType'] = "Reading";
                    }
                    else if(strpos(strtolower($item['tables']['storedgrades']['course_name']), 'science') !== false  || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'biology') !== false  || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'anatomy') !== false  || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'chemistry') !== false   || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'physics') !== false   || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'zoology') !== false   || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'anatomy') !== false ) {
                        $gdata['courseTypeID'] = 30;
                        $gdata['courseType'] = "Science";
                    }
                    else if(strpos(strtolower($item['tables']['storedgrades']['course_name']), 'social') !== false || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'geography') !== false || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'history') !== false || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'civics') !== false) {
                        $gdata['courseTypeID'] = 35;
                        $gdata['courseType'] = "Social Studies";

                    }
                    else if(strpos(strtolower($item['tables']['storedgrades']['course_name']), 'english') !== false) {
                        $gdata['courseTypeID'] = 11;
                        $gdata['courseType'] = "English";
                    }

                    if(isset($gdata['courseType']))
                    {
                        if(!in_array($term."-".$gdata['courseType']."-".$item['tables']['storedgrades']['storecode'], $exist))
                        {
                            $gdata['courseFullName'] = $gdata['courseName'] = $item['tables']['storedgrades']['course_name'];
                            $gdata['numericGrade'] = $item['tables']['storedgrades']['percent'];
                            $exist[] = $term."-".$gdata['courseType']."-".$item['tables']['storedgrades']['storecode'];

                        }
                    }
                    else
                    {
                        $gdata['courseFullName'] = $gdata['courseName'] = $item['tables']['storedgrades']['course_name'];
                        $gdata['numericGrade'] = $item['tables']['storedgrades']['percent'];

                    }

/*                    echo "<pre>";
                    print_r($gdata);
                    exit;
*/
                    if(isset($gdata['numericGrade']) && $gdata['numericGrade'] != '')
                    {

                        $gradeData .= '<tr><td>'.$gdata['academicYear']."</td><td>".$gdata['academicTerm']."</td><td>".$gdata['courseFullName']."</td><td class='text-center'>".$gdata['numericGrade']."</td></tr>";

                    }


                    

                }


            }
        }
        echo $gradeData."</tbody>";
    }
    else if (!empty($type) && $type == "student_storedgrades") {
        $resource = $url . '/ws/schema/query/' . $queryName.'?pagesize=0';
        $payload = '{}';
        if ($type == 'student_storedgrades') {
            $payload = '{"StudentID" : '.$sdata['student_id'].'}';
        }
        
        //Set options for POST call
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n".
                    "Authorization: Bearer $accessTokenKey\r\n",
                'content' => $payload
            )
        );
        //echo "<pre>"; print_r($opts); exit;
        //Call the server's oauth gateway
         $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                            "Authorization: Bearer $accessTokenKey"
            ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_URL, $resource);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($curl);
        //Get the JSON data
        $jsonData = json_decode($result, true);


        $fields = array_keys($jsonData['record'][0]['tables']['storedgrades']);
        /*foreach($fields as $val)
        {
            echo $val."^";
        }
        echo "<br>";*/
        foreach ($jsonData['record'] as $item) {
            $tmp = $item['tables']['storedgrades'];
            /*foreach($fields as $val)
            {
                echo $tmp[$val]."^";
            }
            echo "<br>";*/
        }
        // exit;

        
        //Collapse the array a bit if there is data
        $hsRecords = array();
        $exist = [];
        if (isset($jsonData['record'])) {
            
            foreach ($jsonData['record'] as $item) {


                $term = $item['tables']['storedgrades']['termid'];
                $newterm = floor($term/100) * 100;
                $term = $newterm;

                $academicYear = ($term/100) + 1990;
                $yrid = $academicYear;// ."-".($academicYear+1);
                
                 
                /* Dynamic year calc start */
                $assigned_eigibility_name_ary = [];
                $academic_years = [];
                $academic_year_grades = [];
                // Get eligibility template
                $qry = "SELECT id FROM eligibility_template WHERE name = "."'Academic Grades'";
                $eligibility_template = $sdata['DB']->select($qry);
                $eligibility_tempid = $eligibility_template[0]['id'];
                // Program Eligibility
                $program_ary = "(" . $sdata['submission'][0]['first_choice_program_id'] .",". $sdata['submission'][0]['second_choice_program_id'] . ")";
                $qry = "SELECT assigned_eigibility_name 
                        FROM program_eligibility 
                        WHERE program_id IN " . $program_ary . "
                        AND eligibility_type = " . $eligibility_tempid . "
                        AND application_id = " . $sdata['submission'][0]['application_id'];
                $program_eligibility = $sdata['DB']->select($qry);
                // Calc
                foreach ($program_eligibility as $key => $value) {
                    if (isset($value['assigned_eigibility_name']) && ($value['assigned_eigibility_name']!='') && !in_array($value['assigned_eigibility_name'], $assigned_eigibility_name_ary)) {
                        $assigned_eigibility_name_ary[] = $value['assigned_eigibility_name'];
                        // Eligibility content
                        $qry = "SELECT content FROM eligibility_content WHERE eligibility_id = " . $value['assigned_eigibility_name'];
                        $eligibility_content = $sdata['DB']->select($qry);
                        // Academic grades
                        if (isset($eligibility_content[0]['content']) && ($eligibility_content[0]['content']!='')) {
                            $content = json_decode($eligibility_content[0]['content'], true);
                            if (isset($content['terms_calc']) && !empty($content['terms_calc'])) {
                                foreach ($content['terms_calc'] as $academic_year => $academic_year_grade) {
                                    $tmp_split = explode('-', $academic_year);
                                    $academic_years[] = $tmp_split[0];
                                    $academic_years[] = $tmp_split[0]+1;
                                    if (isset($academic_year_grade) && !empty($academic_year_grade)) {
                                        foreach ($academic_year_grade as $ay_grade) {
                                            $academic_year_grades[] = $ay_grade;
                                        }
                                    }
                                }
                            }
                        }

                    }
                }
                $academic_years = array_unique($academic_years);
                $academic_year_grades = array_unique($academic_year_grades);
                //echo '<pre>';print_r($academic_years);print_r($academic_year_grades);exit;
                /* Dynamic year calc end */


                if($yrid != '' && in_array($yrid, $academic_years))
                {
                    //$yrid = (1990 + $term_data[0]['yearid'];
                   $term = $yrid . "-".(($yrid+1)-2000);
                   // $term = $yrid . "-".($yrid+1);
                    $gdata = [];
                    $gdata['submission_id'] = $sdata['submission_id'];
                    $gdata['stateID'] = $sdata['student_id'];
                    $gdata['academicYear'] = $term;
                    $gdata['GradeName'] = $gdata['academicTerm'] = str_replace(" Grade", "", $item['tables']['storedgrades']['storecode'])." Grade";

                    if($item['tables']['storedgrades']['credit_type'] == 'C,MTH' || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'math') !== false || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'algebra') !== false || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'geometry') !== false  || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'precalculus') !== false){
                        $gdata['courseTypeID'] = 4;
                        $gdata['courseType'] = "Math";

                    }
                    else if($item['tables']['storedgrades']['credit_type'] == "C,SS" || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'geography') !== false || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'civics') !== false || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'citizenship') !== false || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'history') !== false) {
                        $gdata['courseTypeID'] = 9;
                        $gdata['courseType'] = "Social Studies";
                    }
                    else if($item['tables']['storedgrades']['credit_type'] == "C,SC"  || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'chemistry') !== false   || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'science') !== false   || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'biology') !== false) {
                        $gdata['courseTypeID'] = 7;
                        $gdata['courseType'] = "Science";
                    }
                    else if($item['tables']['storedgrades']['credit_type'] == "C,ELA"  || strpos(strtolower($item['tables']['storedgrades']['course_name']), 'english') !== false) {
                        $gdata['courseTypeID'] = 3;
                        $gdata['courseType'] = "English";
                    }

                    if($item['tables']['storedgrades']['percent'] > 0)
                    {
                        if(isset($gdata['courseType']))
                        {
                            if(!in_array($term."-".$gdata['courseType']."-".$item['tables']['storedgrades']['storecode'], $exist))
                            {
                                $gdata['courseFullName'] = $gdata['courseName'] = $item['tables']['storedgrades']['course_name'];
                                $gdata['numericGrade'] =$gdata['actual_numeric_grade'] = $item['tables']['storedgrades']['percent'];
                                $exist[] = $term."-".$gdata['courseType']."-".$item['tables']['storedgrades']['storecode'];

                            }
                        }
                        else
                        {
                            $gdata['courseFullName'] = $gdata['courseName'] = $item['tables']['storedgrades']['course_name'];
                            $gdata['numericGrade'] = $gdata['actual_numeric_grade'] = $item['tables']['storedgrades']['percent'];

                        }

                    }



                    if(isset($gdata['numericGrade']) && $gdata['numericGrade'] != '' && in_array($gdata['academicTerm'], $academic_year_grades) && isset($gdata['courseTypeID']))
                    {

                        //$gdata['academicTerm'] .= " Grade";

                        $SQL = "DELETE FROM submission_grade WHERE submission_id = '".$gdata['submission_id']."' AND courseType = '".(isset($gdata['courseType']) ? $gdata['courseType'] : "")."' AND academicYear = '".$gdata['academicYear']."' AND academicTerm = '".$gdata['academicTerm']."'";
                        $rd = $objDB->sql_query($SQL);

                        $SQL = "INSERT INTO submission_grade SET ";
                        foreach($gdata as $k=>$v)
                        {
                            $SQL .= $k.' = "'.$v.'",';
                        }
                        $SQL = trim($SQL, ",");
                       // echo "<BR><BR>".$SQL;exit;
                        $rs = $objDB->sql_query($SQL);

                    }


                    

                }
                // else
                // {
                //     echo $term."<br>";
                // }


            }
        }
        echo "Done";
        exit;
    }
    else if (!empty($type) && $type == "students") 
    {
         $resource = $url . '/ws/schema/query/' . $queryName.'?pagesize=0';
        
        $payload = '{}';
        
        // echo base64_decode('V3JvbmcgUXVlcnkgOiBTRUxFQ1QgKiBGUk9NIHBzX3NjaG9vbHMgV0hFUkUgc2Nob29sX2lkID0gJzE3Mic8YnI+VGFibGUgJ2hjc19saXZlLnBzX3NjaG9vbHMnIGRvZXNuJ3QgZXhpc3Q=');
        // exit;
        //Set options for POST call
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n".
                    "Authorization: Bearer $accessTokenKey\r\n",
                'content' => $payload
            )
        );
        //echo "<pre>"; print_r($opts); exit;
        //Call the server's oauth gateway
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                            "Authorization: Bearer $accessTokenKey"
            ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_URL, $resource);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($curl);

        //$result = file_get_contents($resource, false, stream_context_create($opts));
        //Get the JSON data
        $jsonData = json_decode($result, true);
              //` echo "<pre>"; print_r($jsonData); exit;
        
        //Collapse the array a bit if there is data
        $hsRecords = array();
        $exist = [];

            foreach ($jsonData['record'] as $item) {

                if($item['tables']['students']['enroll_status'] == "0")
                {
                                    $data = [];
                $race = $item['tables']['students']['ethnicity'];
                $schoo_id = $item['tables']['students']['schoolid'];
               
                $SQL = "SELECT * FROM ps_schools WHERE school_id = '".$schoo_id."'";
                $rs = $objDB->sql_query($SQL);

                if(count($rs) > 0)
                {
                    $data['current_school'] = $rs[0]['name'];
                }

                $SQL = "SELECT * FROM ps_general WHERE value = '".$race."'";
                $rs = $objDB->sql_query($SQL);

                if(count($rs) > 0)
                {
                    if($item['tables']['students']['fedethnicity'] == '1')
                        $hispanic = " - Hispanic";
                    else
                        $hispanic = " - Non-Hispanic";
                    $data['race'] = $rs[0]['name'].$hispanic;
                }

                //$data['current_school'] = $item['tables']['students']['schoolid'];

                $data['birthday'] = $item['tables']['students']['dob'];
                $data['enroll_status'] = $item['tables']['students']['enroll_status'];
                $data['first_name'] = $item['tables']['students']['first_name'];
                $data['last_name'] = $item['tables']['students']['last_name'];
                $data['gender'] = $item['tables']['students']['gender'];
                $data['stateID'] = $item['tables']['students']['student_number'];
                $data['address'] = $item['tables']['students']['street'];
                $data['city'] = $item['tables']['students']['city'];
                $data['state'] = $item['tables']['students']['state'];
                $data['phone'] = $item['tables']['students']['home_phone'];
                 $data['zip'] = $item['tables']['students']['zip'];

                $grade_level = $item['tables']['students']['grade_level'];
                if(in_array($grade_level, array("-4", "-3", "-2", "-1", "99")))
                    $current_grade = "PreK";
                elseif(in_array($grade_level, array("0")))
                    $current_grade = "K";
                else
                    $current_grade = $grade_level;

                
                $data['current_grade'] = $current_grade;
                $data['middle_name'] = addslashes($item['tables']['students']['middle_name']);
                $data['student_id'] = $item['tables']['students']['id'];
                $data['dcid'] = $item['tables']['students']['dcid'];

                $SQL = "SELECT * FROM student WHERE stateID = '".$data['stateID']."'";
                $rs = $objDB->select($SQL);

                if(count($rs) > 0)
                {
                    $SQL = "UPDATE student SET ";
                }
                else
                {
                    $SQL = "INSERT INTO student SET ";
                }
                foreach($data as $k=>$v)
                        {
                               $SQL .= $k.' = "'.addslashes($v).'",';
                        }
                $SQL = trim($SQL, ",");
                if(count($rs) > 0)
                {
                    $SQL .= ", updated_at = '".date("Y-m-d H:i:s")."'";
                    $SQL .= " WHERE stateID = '".$data['stateID']."'";
                }
                else
                {
                $SQL .= ", created_at = '".date("Y-m-d H:i:s")."'";
                }
                $rs = $objDB->sql_query($SQL);
            }




            } ///s
    }

//    return $response;
}

