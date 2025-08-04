    <?php
ini_set("error_reporting","1");
    set_time_limit(0);
    ini_set('memory_limit','2048M');
    
    include("common_functions.php");     
    include("dbClass.php");
    $objDB = new MySQLCN;

    $courseType = array("31" => "Academic","36" => "Art","26" => "ArtA","16" => "Business","27" => "Career/technical","43" => "Career\Technical Education","39" => "Computer","10" => "Computer Application","42" => "Cooperative Career\Tech Ed","41" => "Coordinated Studies","2" => "Elective","3" => "English","17" => "Fam/Cons Science","11" => "Fine Arts","12" => "Foreign Language","14" => "Health","34" => "Hearing Impaired","22" => "KeyboardingKB","21" => "Learning Strategies","4" => "Math","37" => "Music","1" => "NA","23" => "No Valid Code","32" => "Non Credit","5" => "Physical Education","24" => "Planning Period","40" => "Reading","6" => "READINGRDG","18" => "ROTC","7" => "Science","8" => "Social Skills","9" => "Social Studies","28" => "Special Ed Math","29" => "Special Ed Science","30" => "Special Ed Soc Stds","33" => "Special Ed. Health","20" => "Special Education","19" => "Special EducationSPE","38" => "Spelling","35" => "Teacher Only","15" => "Teacher Planning","25" => "Technical");
	

 $acad_sessions = fetch_inow_details( 'acadsessions' );
 
    $sess_arr = $year_arr = array();
    $sectionId = [];
   foreach($acad_sessions as $acad_session){
                if(in_array($acad_session->Name, array("2020-2021", "2020-21")))//array("2018-2019", "2019-2020")))
                {
                    $sess_arr[] = $acad_session->Id;
                    $year_arr[$acad_session->Id] = $acad_session->Name;

                }
            }
       // $sectionId = array_unique($sectionId);



    $sections = $graded_items_hash = $grading_periods_hash = array();

    $rs = $objDB->select("SELECT student_id, id FROM submissions WHERE id in (2248)");
    //print_r($rs);exit;

    $arr = $arr1 = $sub_id = array();
    $submission_id = 0;
    for($i=0; $i < count($rs); $i++)
    {
        
        $SQL = "SELECT * FROM submission_grade WHERE submission_id = '".$rs[$i]['id']."'";
        $rs1  = $objDB->select($SQL);
        if(count($rs1) <= 0)
        {
            $SQL = "SELECT student_id, stateID FROM inow_students WHERE stateID = '".$rs[$i]['student_id']."'";
            $rs2 = $objDB->select($SQL);

            
            if(count($rs2) > 0)
            {
                $arr[] = $rs2[0]['student_id'];
                $arr1[] = $rs2[0]['stateID'];
                $sub_id[] = $rs[$i]['id'];
            }
        }
        
    }
   // dd($arr);

   // $arr = array("462732");
    //$arr1 = array("1967828292");

    $teacherArr = $gradeItemIdArr = $gradePeriodArr = $sectionArr = array();

//    $url = $id."/students/629764/grades";//?gradingPeriodId=4966";
//print_r($arr);exit;
    foreach($arr as $ak=>$av)
        { //13
            $endpoint = "students/".$av."/acadSessions";
            $academic_sessions = fetch_inow_details($endpoint);
            $acd = $academic_sessions;
            
            foreach($acd as $key=>$value)
            { //12
                if(in_array($value->AcadSessionId, $sess_arr))
                { //11
                        $endpoint = $value->AcadSessionId."/students/".$av."/grades";
                        $grade_data = fetch_inow_details($endpoint);

                        foreach($grade_data as $gkey=>$gvalue)
                        { //10
                            $data = array();
                            $ins = array();
                            $submission_id = $sub_id[$ak];
                            //echo $submission_id;exit;
                            $data['stateID'] = $arr1[$ak]; //0
                            $data['academic_session'] = $value->AcadSessionId;
                            $data['NumericGrade'] = $gvalue->NumericGrade;

                            $sectionId = $gvalue->SectionId;
                            if(isset($sectionArr[$sectionId]))
                            {  //1
                                $tmp = $sectionArr[$sectionId];
                                $data['CourseId'] = $tmp['CourseId'];
                                $data['CourseNumber'] = $tmp['CourseNumber'];
                                $data['CourseTypeId'] = $tmp['CourseTypeId'];
                                $data['FullName'] = $tmp['FullName'];
                                $data['FullSectionNumber'] = $tmp['FullSectionNumber'];
                                $data['MaxGradeLevelId'] = $tmp['MaxGradeLevelId'];
                                $data['StateCourseNumber'] = $tmp['StateCourseNumber'];
                                $data['ShortName'] = $tmp['ShortName'];
                            } //1
                            else
                            { //2
                                $endpoint = $value->AcadSessionId."/sections/".$sectionId;
                                $section_data = fetch_inow_details($endpoint);

                                $data['CourseId'] = addslashes($section_data->CourseId);
                                $data['CourseNumber'] = addslashes($section_data->CourseNumber);
                                $data['CourseTypeId'] = addslashes($section_data->CourseTypeId);
                                $data['FullName'] = addslashes($section_data->FullName);
                                $data['FullSectionNumber'] = addslashes($section_data->FullSectionNumber);
                                $data['MaxGradeLevelId'] = addslashes($section_data->MaxGradeLevelId);
                                $data['StateCourseNumber'] = addslashes($section_data->StateCourseNumber);
                                $data['ShortName'] = addslashes($section_data->ShortName);
                            
                                $tmp = array();
                                $tmp['CourseId'] = addslashes($section_data->CourseId);
                                $tmp['CourseNumber'] = addslashes($section_data->CourseNumber);
                                $tmp['CourseTypeId'] = addslashes($section_data->CourseTypeId);
                                $tmp['FullName'] = addslashes($section_data->FullName);
                                $tmp['FullSectionNumber'] = addslashes($section_data->FullSectionNumber);
                                $tmp['MaxGradeLevelId'] = addslashes($section_data->MaxGradeLevelId);
                                $tmp['StateCourseNumber'] = addslashes($section_data->StateCourseNumber);
                                $tmp['ShortName'] = addslashes($section_data->ShortName);
                                $sectionArr[$sectionId] = $tmp;
                            } //2

                            $teacher_id = $section_data->PrimaryTeacherId;
                            if(isset($teacherArr[$teacher_id]))
                            { //3
                                $data['TeacherName']  = $teacherArr[$teacher_id];
                            } //3
                            else
                            { //4
                                $endpoint = "persons/".$teacher_id;
                                $teacher_data = fetch_inow_details($endpoint);
                                $data['TeacherName'] = addslashes($teacher_data->DisplayName);
                                $teacherArr[$teacher_id] = $data['TeacherName'];
                            } //4

                            $grade_item_id = $gvalue->GradedItemId;
                            if(isset($gradeItemIdArr[$grade_item_id]))
                            { //5
                                $tmp = $gradeItemIdArr[$grade_item_id];
                                $data['GradeDescription'] = $tmp['GradeDescription'];
                                $data['GradeName'] = $tmp['GradeName'];
                                $data['Sequence'] = $tmp['Sequence'];
                                $grade_period_id = $tmp['GradePeriodId'];

                            } //5
                            else
                            { //6
                                $endpoint = $value->AcadSessionId."/gradedItems/".$grade_item_id;
                                $grade_item_data = fetch_inow_details($endpoint);
                                $data['GradeDescription'] = addslashes($grade_item_data->Description);
                                $data['GradeName'] = addslashes($grade_item_data->Name);
                                $data['Sequence'] = addslashes($grade_item_data->Sequence);

                                $tmp = array();
                                $tmp['GradeDescription'] = $data['GradeDescription'];
                                $tmp['GradeName'] = $data['GradeName'];
                                $tmp['Sequence'] = $data['Sequence'];
                                $tmp['GradePeriodId'] = $grade_item_data->GradingPeriodId;
                                $gradeItemIdArr[$grade_item_id] = $tmp;
                                $grade_period_id = $grade_item_data->GradingPeriodId;
             
                            }    //6            

                           
                            if(isset($gradePeriodArr[$grade_period_id]))
                            { //7
                                $tmp = $gradePeriodArr[$grade_period_id];
                                $data['GradeTerm'] = $tmp['GradeTerm'];
                                $data['academicYear'] = $tmp['academicYear'];
                                $data['GradePeriodName'] = $tmp['GradePeriodName'];
                                $data['academicTerm'] = $tmp['academicTerm'];
                                $data['SchoolAnnouncement'] = $tmp['SchoolAnnouncement'];
                            } //7
                            else
                            { //8
                                $endpoint = $value->AcadSessionId."/gradingPeriods/".$grade_period_id;
                                $grade_period_data = fetch_inow_details($endpoint);
                                $data['GradeTerm'] = addslashes($grade_period_data->Description);
                                $tmp = explode(" ", $data['GradeTerm']);
                                $data['academicYear'] = $tmp[0]; //1
                                $data['GradePeriodName'] = addslashes($grade_period_data->Name);
                                $data['academicTerm'] = $data['GradePeriodName'];
                                $data['SchoolAnnouncement'] = addslashes($grade_period_data->SchoolAnnouncement);


                                $tmp = array();
                                $tmp['GradeTerm'] = $data['GradeTerm'];
                                $tmp['academicYear'] = $data['academicYear'];
                                $tmp['GradePeriodName'] = $data['GradePeriodName'];
                                $tmp['academicTerm'] = $data['academicTerm'];
                                $tmp['SchoolAnnouncement'] = $data['SchoolAnnouncement'];
                                $gradePeriodArr[$grade_period_id] = $tmp;
             
                            } //8

                            


                            $ins['stateID'] = $data['stateID'];
                            $ins['academicYear'] = $year_arr[$value->AcadSessionId];
                            $ins['academicTerm'] = $data['GradeName'];
                            $ins['GradeName'] = $data['academicTerm'];
                            $ins['courseTypeID'] = $data['CourseTypeId'];
                            $ins['sequence'] = $data['Sequence'];
                            $ins['courseType'] = (isset($courseType[$data['CourseTypeId']]) ? $courseType[$data['CourseTypeId']] : 0);
                            $ins['courseFullName'] = $data['FullName'];
                            $ins['courseName'] = $data['ShortName'];
                            $ins['sectionNumber'] = $data['StateCourseNumber'];
                            $ins['fullsection_number'] = $data['FullSectionNumber'];
                            $ins['numericGrade'] = $ins['actual_numeric_grade'] = $data['NumericGrade'];

                            dd($ins);
                            if(in_array($data['CourseTypeId'], array(3,4,9,7)) && $ins['academicTerm'] == "Yearly Avg")
                            { //9
                                
                               // $SQL = "DELETE FROM submission_grade WHERE  submission_id = '".$submission_id."' AND stateID = '".$ins['stateID']."' AND academicYear='".$ins['academicYear']."' AND GradeName = '".$ins['GradeName']."' AND courseType = '".$ins['courseType']."'";
                                //$rsDel = $objDB->sql_query($SQL);

                               

                                $SQL = "INSERT INTO submission_grade SET ";
                                foreach($ins as $mkey=>$mvalue)
                                {
                                    $SQL .= $mkey."='".$mvalue."',";
                                }
                                $SQL .= " submission_id = ".$submission_id;
                                $SQL .= ", created_at = '".date("Y-m-d H:i:s")."'";
                                $SQL = trim($SQL,",");
                                $rs = $objDB->insert($SQL);                                
                            } //9


                            

                        } //10
                } //11

            } //12
            
        } //13

echo "DONE - ".$arr[0];
?>