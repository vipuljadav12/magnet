<?php

namespace App\Modules\ProcessSelection\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\School\Models\Grade;
use App\Modules\ProcessSelection\Models\{Availability, ProgramSwingData, PreliminaryScore, ProcessSelection};
use App\Modules\setEligibility\Models\setEligibility;
use App\Modules\Form\Models\Form;
use App\Modules\Program\Models\{Program, ProgramEligibility, ProgramGradeMapping};
use App\Modules\DistrictConfiguration\Models\DistrictConfiguration;
use App\Modules\Enrollment\Models\{Enrollment, EnrollmentRaceComposition};
use App\Modules\Application\Models\ApplicationProgram;
use App\Modules\Application\Models\Application;
use App\Modules\LateSubmission\Models\{LateSubmissionProcessLogs, LateSubmissionAvailabilityLog, LateSubmissionAvailabilityProcessLog, LateSubmissionIndividualAvailability};

use App\Modules\Waitlist\Models\{WaitlistProcessLogs, WaitlistAvailabilityLog, WaitlistAvailabilityProcessLog, WaitlistIndividualAvailability};
use App\Modules\ProcessSelection\Export\{ProgramAvailabilityExport, WaitlistExport};
use App\Modules\Submissions\Models\{Submissions, SubmissionGrade, SubmissionConductDisciplinaryInfo, SubmissionsFinalStatus, SubmissionsStatusLog, SubmissionsStatusUniqueLog, SubmissionCommitteeScore, SubmissionCompositeScore, SubmissionsSelectionReportMaster, SubmissionsRaceCompositionReport, LateSubmissionFinalStatus, SubmissionsWaitlistFinalStatus, SubmissionInterviewScore, SubmissionsLatestFinalStatus};
use App\SubmissionRaw;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ProcessSelectionController extends Controller
{
    /* This function will generate Racial composition according to program group 
    set in Applicaiton Filter level at "Selection" tab of program */

    public $group_racial_composition = array();
    public $program_group = array();
    public $enrollment_race_data = array();
    public $waitlistRaceArr = array();
    public $availabilityArray = array();
    public $firstOffered = array();
    public $offered_submission_id = array();
    public $offered_race = "";
    public $offer_program_id = 0;

    public function validateAllNecessity($application_id)
    {
        $enrollment_racial = EnrollmentRaceComposition::where("enrollment_id", Session::get("enrollment_id"))->first();
        $error_msg = "";
        if (empty($enrollment_racial) || ($enrollment_racial->black == '' || $enrollment_racial->black == '0'))
            $error_msg .= "<li>Racial Composition for <strong>Black</strong> not at set Enrollment Level.</li>";
        if (empty($enrollment_racial) || ($enrollment_racial->white == '' || $enrollment_racial->white == '0'))
            $error_msg .= "<li>Racial Composition for <strong>White</strong> not at set Enrollment Level.</li>";
        if (empty($enrollment_racial) || ($enrollment_racial->other == '' || $enrollment_racial->other == '0'))
            $error_msg .= "<li>Racial Composition for <strong>Other</strong> not at set Enrollment Level.</li>";
        if (empty($enrollment_racial) || ($enrollment_racial->swing == '' || $enrollment_racial->swing == '0'))
            $error_msg .= "<li><strong>Swing %</strong> is not configured at set Enrollment Level.</li>";

        /* Find out Preliminary Processing is enabled or not */
        $rsApplication = Application::where("enrollment_id", Session::get("enrollment_id"))->where("form_id", $application_id)->first();
        /* Find out Minimum Committee Score is set or not */
        if ($rsApplication->preliminary_processing == "Y") {
            $count = PreliminaryScore::join("submissions", "submissions.id", "submission_preliminary_score.submission_id")->where("submissions.enrollment_id", Session::get("enrollment_id"))->count();
            if ($count == 0) {
                $error_msg .= "<li>Preliminary Score calculation is pending.</li>";
            }
        } else {
            $rsPrograms = Program::where("enrollment_id", Session::get("enrollment_id"))->where("parent_submission_form", $application_id)->select("id as program_id")->get();
            $prgArr = [];
            foreach ($rsPrograms as $rkey => $rsvalue) {
                $committee_eligibility = ProgramEligibility::join("eligibility_template", "eligibility_template.id", "program_eligibility.eligibility_type")->join("program", "program.id", "program_eligibility.program_id")->where("program.parent_submission_form", $application_id)->where("program_eligibility.status", "Y")->where("program.id", $rsvalue->program_id)->where("eligibility_template.name", "Committee Score")->select("program.id")->get()->toArray();
                if (count($committee_eligibility) > 0) {
                    $prgArr[] = $rsvalue->program_id;
                    $rs = DB::table('seteligibility_extravalue')->where('program_id', $rsvalue->program_id)->where('eligibility_type', 7)->first();
                    if (!empty($rs)) {
                        $data = json_decode($rs->extra_values);
                        if (!isset($data->minimum_score)) {
                            $error_msg .= "<li>Minimum Committee Score not setup for <strong>" . getProgramName($rsvalue->program_id) . "</strong></li>";
                        }
                    } else {
                        $error_msg .= "<li>Minimum Committee Score not setup for <strong>" . getProgramName($rsvalue->program_id) . "</strong></li>";
                    }
                }
            }

            foreach ($prgArr as $k => $v) {
                $count = Submissions::where("form_id", $application_id)
                    ->where("first_choice_program_id", $v)->where("enrollment_id", Session::get("enrollment_id"))->where("late_submission", "N")
                    ->get()->whereIn('submission_status', array('Active', 'Pending'))->count();
                $count1 = Submissions::where("form_id", $application_id)->where("enrollment_id", Session::get("enrollment_id"))->where("late_submission", "N")
                    ->where("second_choice_program_id", $v)->whereIn('submission_status', array('Active', 'Pending'))
                    ->get()->count();
                $cmt_count = SubmissionCommitteeScore::where("program_id", $v)->get()->count();
                if (($count + $count1) > $cmt_count) {
                    //echo $v . " - " .$count . " - ".$count1." - ".$cmt_count;exit;
                    $error_msg .= "<li><strong>" . getProgramName($v) . "</strong> has <strong>" . (($count + $count1) - $cmt_count) . "</strong> has missing committee score.</li>";
                }
            }
        }
        return $error_msg;
    }

    public function groupByRacism($af_programs)
    {
        $af = [
            'application_filter_1' => 'applicant_filter1',
            'application_filter_2' => 'applicant_filter2',
            'application_filter_3' => 'applicant_filter3'
        ];
        $seat_type = [
            'black_seats' => 'Black',
            'white_seats' => 'White',
            'other_seats' => 'Other'
        ];
        $group_race_array = $program_group = [];
        foreach ($af_programs as $key => $value) {
            $programs = Program::where("district_id", Session::get("district_id"))->where("enrollment_id", Session::get("enrollment_id"))->where('status', '!=', 'T')->where(function ($q) use ($value) {
                $q->where('applicant_filter1', $value);
                $q->orWhere('applicant_filter2', $value);
                $q->orWhere('applicant_filter3', $value);
                $q->orWhere('name', $value);
            })->get();
            $filtered_programs = [];
            $avg_data = [];
            if (count($programs) <= 0) {
                $programs = Program::where("district_id", Session::get("district_id"))->where("enrollment_id", Session::get("enrollment_id"))->where('status', '!=', 'T')->where("name", $value)->get();
            }
            if (!empty($programs)) {
                $programs_avg = [];
                foreach ($programs as $pkey => $program) {
                    if ($program->selection_by == "Program Name")
                        $selection_by = "name";
                    else
                        $selection_by = strtolower(str_replace(' ', '_', $program->selection_by));
                    if (
                        isset($af[$selection_by]) &&
                        ($program->{$af[$selection_by]} != '') &&
                        $program->{$af[$selection_by]} == $value
                    ) {
                        $filtered_programs[] = $program;
                        array_push($programs_avg, $program->id);
                        $program_group[$program->id] = $value;
                    } elseif ($selection_by == "name" || $selection_by == "program_name" || $selection_by == "") {
                        if ($program->name == $value) {
                            $filtered_programs[] = $program;
                            array_push($programs_avg, $program->id);
                            $program_group[$program->id] = $value;
                        }
                    }
                }

                if (!empty($programs_avg)) {
                    $total = 0;
                    $availabilities =  Availability::whereIn("program_id", $programs_avg)->where('district_id', Session('district_id'))->get(array_keys($seat_type));
                    $anyZero = 0;
                    foreach ($seat_type as $stype => $svalue) {
                        $sum = $availabilities->sum($stype);
                        $total += $sum;
                        /*if($sum == 0)
                            $avg_data['no_previous'] = "Y";
                        else
                            $avg_data['no_previous'] = "N";
                        */
                        if ($sum == 0)
                            $anyZero++;
                        $avg_data[strtolower($svalue)] = $sum;
                    }
                    $avg_data['total'] = $total;
                    if ($anyZero == count($seat_type))
                        $avg_data['no_previous'] = "Y";
                    else
                        $avg_data['no_previous'] = "N";
                }
                $group_race_array[$value] = $avg_data;
            }
        }
        return array("group_race" => $group_race_array, "program_group" => $program_group);
    }

    public function application_index($type = '')
    {
        /* 

        $rs = SubmissionRaw::get();
        foreach($rs as $key=>$value)
        {
            $data = json_decode($value->formdata);

            foreach($data as $k=>$v)
            {
                if($k == "13")
                    echo $v."^";
                elseif($k=="second_sibling")
                    echo "Secod--".$v."^";
                elseif($k=="first_sibling")
                    echo "first--".$v."^";

            }
            echo "<br>";
        }
        exit;
        */
        $applications = Form::where("status", "y")->get();
        return view("ProcessSelection::application_index", compact("applications"));
    }

    public function validateApplication($application_id)
    {
        //echo "OK";exit;
        $error_msg = $this->validateAllNecessity($application_id);
        if ($error_msg == "")
            $error_msg = "OK";
        echo $error_msg;
    }

    public function fetch_programs_group($application_id)
    {
        $af = ['applicant_filter1', 'applicant_filter2', 'applicant_filter3'];
        $programs = Program::where('status', '!=', 'T')->where('district_id', Session::get('district_id'))->where("enrollment_id", Session::get('enrollment_id'))->where("program.parent_submission_form", $application_id)->get();

        $preliminary_score = false;
        $application_data = Application::where("form_id", $application_id)->first();
        if ($application_data->preliminary_processing == "Y")
            $preliminary_score = true;

        // Application Filters
        $af_programs = [];
        if (!empty($programs)) {
            foreach ($programs as $key => $program) {
                $cnt = 0;
                foreach ($af as $key => $af_field) {
                    if ($program->$af_field == '')
                        $cnt++;
                    if (($program->$af_field != '') && !in_array($program->$af_field, $af_programs)) {
                        array_push($af_programs, $program->$af_field);
                    }
                }
                if ($cnt == count($af)) {
                    array_push($af_programs, $program->name);
                }
            }
        }
        return $af_programs;
    }

    public function processTest($application_id, $type = "")
    { //echo $_SERVER['REMOTE_ADDR'] ;exit;
        /* Test Code Ends */
        $process_selection = ProcessSelection::where("enrollment_id", Session::get("enrollment_id"))->where("form_id", $application_id)->where("type", "regular")->first();

        $preliminary_score = false;
        $application_data = Application::where("form_id", $application_id)->where("enrollment_id", Session::get("enrollment_id"))->first();
        if (!empty($application_data) && $application_data->preliminary_processing == "Y")
            $preliminary_score = true;
        if (!empty($process_selection) && $process_selection->commited == "Yes") {
            $final_data = $group_racial_composition = $incomplete_arr = $failed_arr = [];
            return view("ProcessSelection::test_index", compact("final_data", "incomplete_arr", "failed_arr", "group_racial_composition", "preliminary_score"));
        }
        $processType = Config::get('variables.process_separate_first_second_choice');
        $gradeWiseProcessing = Config::get('variables.grade_wise_processing');

        if ($type == "9999") {
            $error_msg = $this->validateAllNecessity($application_id);
            if ($error_msg != '') {
                return view("ProcessSelection::error_msg", compact("error_msg", "type"));
            }
        }

        /* save enrollment wise race composition with swing % Data */
        $enrollment_racial = EnrollmentRaceComposition::where("enrollment_id", Session::get("enrollment_id"))->first();
        $swing = $enrollment_racial->swing;




        /* Create Application Filter Group Array for Program */

        $af_programs = $this->fetch_programs_group($application_id);
        $tmp = $this->groupByRacism($af_programs);

        $this->group_racial_composition = $group_race_array = $tmp['group_race'];
        $this->program_group = $program_group_array = $tmp['program_group'];

        $tmpGroup = array_values($program_group_array);
        $arr = array_unique($tmpGroup);
        $race_enroll_arr = [];
        foreach ($arr as $key => $value) {
            $rs = ProgramSwingData::where("enrollment_id", Session::get("enrollment_id"))->where("application_id", $application_id)->where("program_name", $value)->first();
            $program_swing = $swing;
            if (!empty($rs)) {
                if (is_numeric($rs->swing_percentage) && $rs->swing_percentage > 0) {
                    $program_swing = $rs->swing_percentage;
                }
            }
            $tmp = [];
            $tmp['min'] = $enrollment_racial->black - $program_swing;
            $tmp['max'] = $enrollment_racial->black + $program_swing;
            $race_enroll_arr[$value]['black'] = $tmp;

            $tmp = [];
            $tmp['min'] = $enrollment_racial->white - $program_swing;
            $tmp['max'] = $enrollment_racial->white + $program_swing;
            $race_enroll_arr[$value]['white'] = $tmp;

            $tmp = [];
            $tmp['min'] = $enrollment_racial->other - $program_swing;
            $tmp['max'] = $enrollment_racial->other + $program_swing;
            $race_enroll_arr[$value]['other'] = $tmp;
        }
        $this->enrollment_race_data = $race_enroll_arr;
        //echo "<pre>";
        //print_r($this->enrollment_race_data);
        //exit;

        $this->availabilityArray = array();
        $allProgram = Availability::distinct()->where("district_id", Session::get("district_id"))->get(['program_id']);
        foreach ($allProgram as $key => $value) {
            $avail_grade = Availability::where("district_id", Session::get("district_id"))->where("program_id", $value->program_id)->get();
            foreach ($avail_grade as $gkey => $gvalue) {
                $this->availabilityArray[$value->program_id][$gvalue->grade] = $gvalue->available_seats;
            }
        }
        /* from here */
        $firstData = Submissions::distinct()->where("enrollment_id", Session::get("enrollment_id"))->whereIn("submission_status", array('Active', 'Pending'))->where("form_id", $application_id)->get(["first_choice"]);
        $secondData = Submissions::distinct()->where("enrollment_id", Session::get("enrollment_id"))->whereIn("submission_status", array('Active', 'Pending'))->where("form_id", $application_id)->get(["second_choice"]);

        /* Get Subject and Acardemic Term like Q1.1 Q1.2 etc set for Academic Grade Calculation 
                For all unique First Choice and Second Choice
         */
        $subjects = $terms = $programArr = $test_scores_titles = array();
        $eligibilityArr = array();

        foreach ($firstData as $key => $value) {
            if ($value->first_choice != "" && !in_array($value->first_choice, $programArr)) {
                $programArr[] = $value->first_choice;
                $data = getSetEligibilityDataDynamic($value->first_choice, 12);
                if (isset($data->ts_scores)) {
                    foreach ($data->ts_scores as $ts => $tv) {
                        if (!in_array($tv, $test_scores_titles)) {
                            $test_scores_titles[] = $tv;
                        }
                    }
                }
            }
        }
        foreach ($secondData as $key => $value) {
            if ($value->second_choice != "" && !in_array($value->second_choice, $programArr)) {
                $programArr[] = $value->second_choice;
                $data = getSetEligibilityDataDynamic($value->second_choice, 12);
                if (isset($data->ts_scores)) {
                    foreach ($data->ts_scores as $ts => $tv) {
                        if (!in_array($tv, $test_scores_titles)) {
                            $test_scores_titles[] = $tv;
                        }
                    }
                }
            }
        }

        /* Get Set Eligibility Data Set for first choice program and second choice program
         */

        $setEligibilityData = $setCommitteScoreEligibility = array();
        foreach ($firstData as $value) {
            if (!in_array($value->first_choice, array_keys($setCommitteScoreEligibility))) {
                $data = getSetEligibilityDataDynamic($value->first_choice, 7);
                if (isset($data->minimum_score))
                    $setCommitteScoreEligibility[$value->first_choice] = $data->minimum_score;
                else
                    $setCommitteScoreEligibility[$value->first_choice] = 2;
            }
        }

        foreach ($secondData as $value) {
            if (!in_array($value->second_choice, array_keys($setCommitteScoreEligibility))) {
                $data = getSetEligibilityDataDynamic($value->second_choice, 7);
                if (isset($data->minimum_score))
                    $setCommitteScoreEligibility[$value->second_choice] = $data->minimum_score;
                else
                    $setCommitteScoreEligibility[$value->second_choice] = 2;
            }
        }

        /* Code to fetch all selection properties of each program
        and Create array after soring. So we can get idea what is 
        selection ranking for each program */
        $programSortArr = [];
        foreach ($programArr as $key => $val) {
            $rsProgram = Program::where("id", getApplicationProgramId($val))->first();
            if (!empty($rsProgram)) {
                $tmp = array();
                if ($rsProgram->rating_priority != '')
                    $tmp['rating_priority'] = $rsProgram->rating_priority;
                if ($rsProgram->committee_score != '')
                    $tmp['committee_score'] = $rsProgram->committee_score;
                if ($rsProgram->audition_score != '')
                    $tmp['audition_score'] = $rsProgram->audition_score;
                if ($rsProgram->rating_priority != '')
                    $tmp['rating_priority'] = $rsProgram->rating_priority;
                if ($rsProgram->combine_score != '')
                    $tmp['combine_score'] = $rsProgram->combine_score;
                if ($rsProgram->lottery_number != '')
                    $tmp['lottery_number'] = $rsProgram->lottery_number;
                if ($rsProgram->final_score != '')
                    $tmp['final_score'] = $rsProgram->final_score;
                asort($tmp);
                $programSortArr[$rsProgram->id] = $tmp;
            }
        }
        /* Get CDI Set Eligibility Data Set for first choice program and second choice program
         */

        $setCDIEligibilityData = array();

        $committee_eligibility = ProgramEligibility::join("eligibility_template", "eligibility_template.id", "program_eligibility.eligibility_type")->join("program", "program.id", "program_eligibility.program_id")->where("program.parent_submission_form", $application_id)->where("program.enrollment_id", Session::get("enrollment_id"))->where("eligibility_template.name", "Committee Score")->where("program_eligibility.status", "Y")->select("program.id")->get()->toArray();
        $committee_program_id = [];
        foreach ($committee_eligibility as $key => $value) {
            $committee_program_id[] = $value['id'];
        }

        /* Get CDI Data */
        $submissions = Submissions::where('submissions.district_id', Session::get('district_id'))
            ->whereIn('submission_status', array("Active"))
            //->where("id", 1055)
            //->where('next_grade', 'K')
            ->where("form_id", $application_id)
            ->get();

        $firstdata = $seconddata = array();
        $incomplete_arr = $failed_arr = $interview_arr = array();

        $programGrades = array();
        $committee_count = 0;
        foreach ($submissions as $key => $value) {
            $interview_passed = true;
            $composite_score = 0;
            if ($preliminary_score) {
                $interview_score = SubmissionInterviewScore::where("submission_id", $value->id)->first();
                if (!empty($interview_score)) {
                    if ($interview_score->data == 0) {
                        $interview_passed = false;
                    }
                } else
                    $interview_passed = false;

                generateCompositeScore($value->id);
                $rs = SubmissionCompositeScore::where("submission_id", $value->id)->first();
                if (!empty($rs)) {
                    $composite_score = $rs->score;
                }
            }
            if ($value->first_choice != "" && $value->second_choice != "") {
                $failed = false;
                $tmpfirstdata = [];
                $firstfailed = $firstincomplete = false;
                $incomplete = false;

                $tmp = app('App\Modules\Reports\Controllers\ReportsController')->convertToArray($value);
                $choice = getApplicationProgramName($value->first_choice);
                $tmp['first_program'] = getApplicationProgramName($value->first_choice);
                $tmp['first_choice'] = $value->first_choice;
                $tmp['first_choice_program_id'] = $value->first_choice_program_id;
                $tmp['second_choice_program_id'] = $value->second_choice_program_id;
                $tmp['second_choice'] = $value->second_choice;
                $tmp['second_program'] = "";
                $tmp['test_scores'] = app('App\Modules\Reports\Controllers\ReportsController')->getProgramTestScores($value->first_choice_program_id, $value->id, $test_scores_titles);
                $tmp['rank'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "first");

                $tmp['committee_score'] = getSubmissionCommitteeScore($value->id, $value->first_choice_program_id);

                if (!in_array($value->first_choice_program_id, $committee_program_id)) {
                    $tmp['committee_score'] = "NA";
                } else {
                    $committee_count++;
                }

                if ($tmp['committee_score'] == null) {
                    $firstincomplete = true;
                    $incomplete = true;
                } elseif (is_numeric($tmp['committee_score']) && $tmp['committee_score'] >= $setCommitteScoreEligibility[$value->first_choice]) {
                    $tmp['committee_score_status'] = 'Pass';
                } elseif ($tmp['committee_score'] != "NA") {
                    $tmp['committee_score_status'] = 'Fail';
                    $firstfailed = true;
                    $failed = true;
                }
                $tmp['choice'] = 1;
                $tmp['composite_score'] = $composite_score;

                if ($value->submission_status == "Pending") {
                    $incomplete_arr[] = $tmp;
                    $firstincomplete = true;
                } elseif (!$interview_passed) {
                    $interview_arr[] = $tmp;
                } else {
                    if ($failed)
                        $failed_arr[] = $tmp;
                    elseif ($incomplete)
                        $incomplete_arr[] = $tmp;
                    else {
                        $tmpfirstdata = $tmp;
                    }
                }


                $failed = false;
                $incomplete = false;
                $tmp['test_scores'] = app('App\Modules\Reports\Controllers\ReportsController')->getProgramTestScores($value->second_choice_program_id, $value->id, $test_scores_titles);

                $tmp['committee_score'] = getSubmissionCommitteeScore($value->id, $value->second_choice_program_id);

                if (!in_array($value->second_choice_program_id, $committee_program_id)) {
                    $tmp['committee_score'] = "NA";
                }

                if ($tmp['committee_score'] == null)
                    $incomplete = true;
                elseif (is_numeric($tmp['committee_score']) && $tmp['committee_score'] >= $setCommitteScoreEligibility[$value->second_choice]) {
                    $tmp['committee_score_status'] = 'Pass';
                } elseif ($tmp['committee_score'] != "NA") {
                    $tmp['committee_score_status'] = 'Fail';
                    $failed = true;
                }

                $tmp['rank'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "second");


                $tmp['second_program'] = getApplicationProgramName($value->second_choice);
                $tmp['first_program'] = "";
                $tmp['choice'] = 2;
                /*
                if($failed && !$firstfailed)
                {
                    $tmp['committee_score_status'] = "Fail";
                    $failed_arr[] = $tmp;
                }
                elseif($incomplete && !$firstincomplete)
                {
                    $tmp['committee_score_status'] = "NA";
                    $incomplete_arr[] = $tmp;
                }
                elseif(!$firstfailed && !$firstincomplete)
                {
                    $firstdata[$value->first_choice_program_id][] = $tmpfirstdata;
                    $seconddata[$value->second_choice_program_id][] = $tmp;
                }*/
                if (!$firstfailed && !$firstincomplete) {
                    $firstdata[$value->first_choice_program_id][] = $tmpfirstdata;
                }

                if ($value->submission_status == "Pending") {
                    $incomplete_arr[] = $tmp;
                } elseif (!$interview_passed) {
                    $interview_arr[] = $tmp;
                } else {
                    if ($failed) {
                        $failed_arr[] = $tmp;
                    } elseif ($incomplete) {
                        $incomplete_arr[] = $tmp;
                    } else {
                        $seconddata[$value->second_choice_program_id][] = $tmp;
                    }
                }
            } elseif ($value->first_choice != "") {
                $failed = false;
                $incomplete = false;

                $tmp = app('App\Modules\Reports\Controllers\ReportsController')->convertToArray($value);
                $tmp['composite_score'] = $composite_score;
                $choice = getApplicationProgramName($value->first_choice);
                $tmp['first_program'] = getApplicationProgramName($value->first_choice);
                $tmp['first_choice_program_id'] = $value->first_choice_program_id;
                $tmp['second_choice_program_id'] = $value->second_choice_program_id;
                $tmp['second_program'] = "";
                $tmp['first_choice'] = $value->first_choice;
                $tmp['second_choice'] = $value->second_choice;
                $tmp['rank'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "first");
                $tmp['test_scores'] = app('App\Modules\Reports\Controllers\ReportsController')->getProgramTestScores($value->first_choice_program_id, $value->id, $test_scores_titles);

                $tmp['committee_score'] = getSubmissionCommitteeScore($value->id, $value->first_choice_program_id);
                if (!in_array($value->first_choice_program_id, $committee_program_id)) {
                    $tmp['committee_score'] = "NA";
                } else {
                    $committee_count++;
                }

                if ($tmp['committee_score'] == null)
                    $incomplete = true;
                elseif (is_numeric($tmp['committee_score']) && $tmp['committee_score'] >= $setCommitteScoreEligibility[$value->first_choice]) {
                    $tmp['committee_score_status'] = 'Pass';
                } elseif ($tmp['committee_score'] != "NA") {
                    $tmp['committee_score_status'] = 'Fail';
                    $failed = true;
                }

                $tmp['choice'] = 1;
                $tmp['rank'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "first");

                if ($value->submission_status == "Pending") {
                    $incomplete_arr[] = $tmp;
                } elseif (!$interview_passed) {
                    $interview_arr[] = $tmp;
                } else {
                    if ($failed)
                        $failed_arr[] = $tmp;
                    elseif ($incomplete)
                        $incomplete_arr[] = $tmp;
                    else
                        $firstdata[$value->first_choice_program_id][] = $tmp;
                }
            } else {
                $failed = false;
                $incomplete = false;

                $tmp = app('App\Modules\Reports\Controllers\ReportsController')->convertToArray($value);
                $tmp['composite_score'] = $composite_score;
                $tmp['test_scores'] = $test_scores;
                $tmp['second_program'] = getApplicationProgramName($value->second_choice);
                $tmp['first_choice_program_id'] = $value->first_choice_program_id;
                $tmp['second_choice_program_id'] = $value->second_choice_program_id;
                $tmp['first_program'] = "";
                $tmp['first_choice'] = $value->first_choice;
                $tmp['second_choice'] = $value->second_choice;
                $tmp['test_scores'] = app('App\Modules\Reports\Controllers\ReportsController')->getProgramTestScores($value->second_choice_program_id, $value->id, $test_scores_titles);

                $tmp['rank'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "second");
                $tmp['magnet_employee'] = $value->mcp_employee;
                $tmp['magnet_program_employee'] = $value->magnet_program_employee;
                $tmp['committee_score'] = getSubmissionCommitteeScore($value->id, $value->second_choice_program_id);
                if (!in_array($value->second_choice_program_id, $committee_program_id)) {
                    $tmp['committee_score'] = "NA";
                } else {
                    $committee_count++;
                }

                if ($tmp['committee_score'] == null)
                    $incomplete = true;
                elseif (!$interview_passed) {
                    $interview_arr[] = $tmp;
                } elseif (is_numeric($tmp['committee_score']) && $tmp['committee_score'] >= $setCommitteScoreEligibility[$value->second_choice]) {
                    $tmp['committee_score_status'] = 'Pass';
                } elseif ($tmp['committee_score'] != "NA") {
                    $tmp['committee_score_status'] = 'Fail';
                    $failed = true;
                }

                $tmp['choice'] = 2;
                $tmp['rank'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "second");

                if ($value->submission_status == "Pending") {
                    $incomplete_arr[] = $tmp;
                } else {

                    if ($failed)
                        $failed_arr[] = $tmp;
                    elseif ($incomplete)
                        $incomplete_arr[] = $tmp;
                    else
                        $seconddata[$value->second_choice_program_id][] = $tmp;
                }
            }
        }


        //echo "<pre>Failed<BR><BR>";
        //print_r($failed_arr);
        //echo "<pre>Incomplete<BR><BR>";
        //print_r($incomplete_arr);
        //exit;
        /*
echo "<pre>First Data<br><br>";
print_r($firstdata);

echo "<pre>Second Data<br><br>";
print_r($seconddata);
exit;*/
        /* Update failed and income statuses to database */
        if ($type == "update") {
            foreach ($interview_arr as $flkey => $flvalue) {
                $insert = [];
                $insert['submission_id'] = $flvalue['id'];
                $insert['first_choice_final_status'] = "Denied due to Ineligibility";
                $insert['first_waitlist_for'] = $flvalue['first_choice_program_id'];
                $insert['first_choice_eligibility_reason'] = "Denied due to 0 Interview Score";
                if ($flvalue['second_choice_program_id'] != 0 && $flvalue['second_choice_program_id'] != "") {
                    $insert['second_waitlist_for'] = $flvalue['second_choice_program_id'];
                    $insert['second_choice_final_status'] = "Denied due to Ineligibility";
                    $insert['second_choice_eligibility_reason'] = "Denied due to 0 Interview Score";
                }
                $insert['enrollment_id'] = Session::get("enrollment_id");
                $insert['application_id'] = $application_id;
                $rs = SubmissionsFinalStatus::updateOrCreate(["submission_id" => $flvalue['id']], $insert);
            }

            foreach ($failed_arr as $flkey => $flvalue) {
                $committee_score_status = $flvalue['committee_score_status'];
                if ($committee_score_status == "Fail") {
                    $insert = [];
                    $insert['submission_id'] = $flvalue['id'];
                    $insert['first_choice_final_status'] = "Denied due to Ineligibility";
                    $insert['first_waitlist_for'] = $flvalue['first_choice_program_id'];
                    $insert['first_choice_eligibility_reason'] = "Denied due to Ineligible Records";
                    if ($flvalue['second_choice_program_id'] != 0 && $flvalue['second_choice_program_id'] != "") {
                        $insert['second_waitlist_for'] = $flvalue['second_choice_program_id'];
                        $insert['second_choice_final_status'] = "Denied due to Ineligibility";
                        $insert['second_choice_eligibility_reason'] = "Denied due to Ineligible Records";
                    }
                    $insert['enrollment_id'] = Session::get("enrollment_id");
                    $insert['application_id'] = $application_id;
                    $rs = SubmissionsFinalStatus::updateOrCreate(["submission_id" => $flvalue['id']], $insert);
                }
            }

            foreach ($incomplete_arr as $flkey => $flvalue) {
                $insert = [];
                $insert['submission_id'] = $flvalue['id'];
                $insert['first_choice_final_status'] = "Denied due to Incomplete Records";
                $insert['first_waitlist_for'] = $flvalue['first_choice_program_id'];
                $insert['first_choice_eligibility_reason'] = "Incomplete Committee Score";
                if ($flvalue['second_choice_program_id'] != 0 && $flvalue['second_choice_program_id'] != "") {
                    $insert['second_waitlist_for'] = $flvalue['second_choice_program_id'];
                    $insert['second_choice_final_status'] = "Denied due to Incomplete Records";
                    $insert['second_choice_eligibility_reason'] = "Incomplete Committee Score";
                }
                $insert['application_id'] = $application_id;
                $insert['enrollment_id'] = Session::get("enrollment_id");
                $rs = SubmissionsFinalStatus::updateOrCreate(["submission_id" => $flvalue['id']], $insert);
            }
        }

        /* Sort all submission based on selection rank set 
        by each program array */
        $ids = array('PreK', 'K', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $firstPrgData = $secondPrgData = [];
        $loopArr = array("first", "second");
        if (!$processType) {
            $dataStoreArr = array("first", "first");
        } else {
            $dataStoreArr = array("first", "second");
        }


        $append_second = $append_first = [];
        foreach ($loopArr as $lkey => $lvalue) {
            $str = $lvalue . "data";
            $arrvar = ${$str};
            foreach ($arrvar as $key => $value) {

                $parray = $value;
                if (isset($programSortArr[$key])) {
                    $array = $value;
                    $sortingParams = [];
                    $first_column = "";
                    $i = 0;
                    foreach ($programSortArr[$key] as $pk => $pv) {
                        if ($i == 0)
                            $first_column = $pk;
                        $i++;
                    }

                    $first_col_arr = array_column($array, $first_column);

                    $tmpStr = $dataStoreArr[$lkey] . "PrgData";

                    if ($first_column != "committee_score" && $first_column != "combine_score" && (in_array($key, $committee_program_id) || $key == 19 || $key == 42 || $key == 66)) {
                        foreach ($array as $pk => $pv) {
                            $pv['final_score'] = 0;
                            ${"append_" . $lvalue}[] = $pv;
                        }

                        foreach ($programSortArr[$key] as $pk => $pv) {
                            if ($pk == "rating_priority") {
                                $sort_field = "rank";
                                $sort_type = SORT_ASC;
                            } else {
                                $sort_field = $pk;
                                $sort_type = SORT_DESC;
                            }


                            $sortingParams[] = array_column(${"append_" . $dataStoreArr[$lkey]}, $sort_field);
                            $sortingParams[] = $sort_type;
                        }
                        $sortingParams[] = &${"append_" . $dataStoreArr[$lkey]};
                        array_multisort(...$sortingParams);
                    } else {

                        foreach ($array as $pk => $pv) {
                            $pv['final_score'] = 0;
                            ${$tmpStr}[] = $pv;
                        }
                    }
                }
            }
        }
        $firstdata = $firstPrgData;
        if (!empty($firstdata)) {
            $committee_score  = $priority = $lottery_number = $choices = $next_grade = array();
            foreach ($firstdata as $key => $value) {
                try {
                    if ($preliminary_score)
                        $committee_score['committee_score'][] = $value['composite_score'];
                    else
                        $committee_score['committee_score'][] = $value['committee_score'];
                } catch (\Exception $e) {
                    echo $value['id'];
                    exit;
                }
                $priority['rank'][] = $value['rank'];
                $lottery_number['lottery_number'][] = $value['lottery_number'];
                $choices['choice'][] = $value['choice'];
                //$next_grade['next_grade'][] = $value['next_grade'];

            }
            if (!$processType) {
                array_multisort($committee_score['committee_score'], SORT_DESC, $priority['rank'], SORT_ASC, $lottery_number['lottery_number'], SORT_DESC, $choices['choice'], SORT_ASC, $firstdata);
            } else {
                array_multisort($committee_score['committee_score'], SORT_DESC, $priority['rank'], SORT_ASC, $lottery_number['lottery_number'], SORT_DESC, $firstdata);
            }
        }
        if ($committee_count > 0) {
            $firstdata = array_merge($append_first, $firstdata);
            if (!$processType) {
                $firstdata = array_merge($firstdata, $append_second);
            }
        }

        if ($gradeWiseProcessing) {
            $tmp = [];
            foreach ($ids as $ik => $iv) {
                foreach ($firstdata as $fk => $fv) {
                    if ($fv['next_grade'] == $iv) {
                        $tmp[] = $fv;
                    }
                }
            }


            $firstdata = $tmp;
        }


        if ($processType) {
            $seconddata = $secondPrgData;
            if (!empty($seconddata)) {
                $committee_score  = $priority = $lottery_number = array();
                foreach ($seconddata as $key => $value) {
                    if ($preliminary_score)
                        $committee_score['committee_score'][] = $value['composite_score'];
                    else
                        $committee_score['committee_score'][] = $value['committee_score'];
                    $priority['rank'][] = $value['rank'];
                    $lottery_number['lottery_number'][] = $value['lottery_number'];
                }
                array_multisort($committee_score['committee_score'], SORT_DESC, $priority['rank'], SORT_ASC, $lottery_number['lottery_number'], SORT_DESC, $seconddata);
            }
            $seconddata = array_merge($seconddata, $append_second);
        } else {
            $seconddata = [];
        }



        $tmpAvailability = $this->availabilityArray;
        //        echo "<pre>";
        //        print_r($availabilityArray);exit;
        $waitlistOfferArray  = $offeredRank = $this->firstOffered = array();
        $final_data = [];
        foreach ($firstdata as $key => $value) {
            if ($value['choice'] == 1)
                $program_id = $value['first_choice_program_id'];
            else
                $program_id = $value['second_choice_program_id'];

            $offered = false;
            $this->offered_race = "";
            $this->offered_submission_id = "";
            $this->offer_program_id = 0;
            if (in_array($value['id'], $this->firstOffered)) {
                $value['final_status'] = "Waitlist By Already Offered";
            } else {
                if (isset($this->availabilityArray[$program_id][$value['next_grade']]) && $this->availabilityArray[$program_id][$value['next_grade']] > 0) {
                    $race = strtolower($value['race']);
                    $group_name = $this->program_group[$program_id];

                    $offer_type = "normal";
                    if ($this->group_racial_composition[$group_name]['no_previous'] == 'Y') {
                        $offer_type = $this->check_race_previous_data($group_name, $race);
                        //echo $value['id']." - " .getProgramName($program_id)." - ".$offer_type."<BR>";//exit;
                    }
                    if (isset($this->group_racial_composition[$group_name][$race])) {
                        $total_seats = $this->group_racial_composition[$group_name]['total'];
                        $race_percent = $this->group_racial_composition[$group_name][$race];
                    }


                    $total_seats++;
                    $race_percent++;

                    $new_percent = number_format($race_percent * 100 / $total_seats, 2);


                    if ($this->check_all_race_range($group_name, $race, $value['id']) || in_array($offer_type, array('OnlyThisOffered', 'OfferedWaitlisted'))) {

                        $update = $this->generate_race_composition_update($this->group_racial_composition[$group_name], $this->group_racial_composition[$group_name]['total'], $race, "N");
                        $update .= "<br>-----------<br>";
                        $this->group_racial_composition[$group_name]['total'] = $total_seats;
                        $this->group_racial_composition[$group_name][$race] = $race_percent;

                        $value['final_status'] = "Offered";

                        $this->offered_race = $race;
                        $this->offered_submission_id = $value['id'];
                        $value['update'] = $this->generate_race_composition_update($this->group_racial_composition[$group_name], $total_seats, $race);

                        $value['availability'] = $this->availabilityArray[$program_id][$value['next_grade']];

                        $this->firstOffered[] = $value['id'];
                        $this->offered = true;
                        $this->offer_program_id = $group_name;
                        $tmp_stock = $this->availabilityArray[$program_id][$value['next_grade']];
                        $tmp_stock--;
                        $this->availabilityArray[$program_id][$value['next_grade']] = $tmp_stock;

                        /*if(in_array($value['id'], $this->waitlistRaceArr))
                        {
                            $tmp_final_arr = [];
                            foreach($final_data as $flkey=>$flvalue)
                            {
                                if($flvalue['id'] == $value['id'] && $flvalue['choice'] != $value['choice'])
                                {
                                    $flvalue['final_status'] = "Waitlisted By Already Offered";
                                }
                                $tmp_final_arr[] = $flvalue;

                            }
                            if (($key_index = array_search($value['id'], $this->waitlistRaceArr)) !== false) {
                                unset($this->waitlistRaceArr[$key_index]);
                            }
                            $final_data = $tmp_final_arr;
                        }*/
                    } else {
                        $value['final_status'] = "Waitlist By Race";

                        $total_seats = $this->group_racial_composition[$group_name]['total'];
                        $value['update'] = $this->generate_race_composition_update($this->group_racial_composition[$group_name], $total_seats, $race, "W");
                        $value['availability'] = $this->availabilityArray[$program_id][$value['next_grade']];
                    }
                } else {
                    $value['final_status'] = "No Availability";
                }
            }

            $final_data[] = $value;
            if ($offered && in_array($offer_type, array('normal', 'OfferedWaitlisted'))) {
                $final_data = $this->loopWaitlistForOffer($final_data);
                // $tmpArr = [];
                // foreach($final_data as $fkey=>$fvalue)
                // {
                //     if($fvalue['choice'] == 1)
                //         $program_id = $fvalue['first_choice_program_id'];
                //     else
                //         $program_id = $fvalue['second_choice_program_id'];
                //     $group_name = $this->program_group[$program_id];
                //     if($fvalue['final_status'] == "Waitlist By Race" && $offer_program_id == $group_name)
                //     { //1
                //         if(!in_array($fvalue['id'], $firstOffered))
                //         {
                //             if(isset($availabilityArray[$program_id][$fvalue['next_grade']]) && $availabilityArray[$program_id][$fvalue['next_grade']] > 0)
                //             {

                //                 $race = strtolower($fvalue['race']);
                //                 $group_name = $this->program_group[$program_id];

                //                 $total_seats = $this->group_racial_composition[$group_name]['total'];
                //                 $race_percent = $this->group_racial_composition[$group_name][$race];
                //                 $total_seats++;
                //                 $race_percent++;
                //                 $new_percent = number_format($race_percent*100/$total_seats, 2);

                //                 if($this->check_all_race_range($group_name, $race, $fvalue['id']))
                //                 {
                //                     $this->group_racial_composition[$group_name]['total'] = $total_seats;
                //                     $this->group_racial_composition[$group_name][$race] = $race_percent;

                //                     $fvalue['final_status'] = "Offered";
                //                     if(isset($fvalue['update']))
                //                         $update = $fvalue['update']."<br>-----------<br>Offered ID: ".$offered_submission_id." (".$offered_race.")<br>";
                //                     else
                //                         $update = "";
                //                     $fvalue['update'] = $update.$this->generate_race_composition_update($this->group_racial_composition[$group_name], $total_seats, $race);


                //                     $firstOffered[] = $fvalue['id'];
                //                     $fvalue['availability'] = $availabilityArray[$program_id][$fvalue['next_grade']];

                //                     $tmp_stock = $availabilityArray[$program_id][$fvalue['next_grade']];
                //                     $tmp_stock--;
                //                     $availabilityArray[$program_id][$fvalue['next_grade']] = $tmp_stock;
                //                 }
                //                 else
                //                 {
                //                     if(isset($fvalue['update']))
                //                         $update = $fvalue['update']."<br>-----------<br>Offered ID: ".$offered_submission_id." (".$offered_race.")<br>";
                //                     else
                //                         $update = "";
                //                     $total_seats = $this->group_racial_composition[$group_name]['total'];
                //                     $fvalue['update'] = $update.$this->generate_race_composition_update($this->group_racial_composition[$group_name], $total_seats, $race, "W");
                //                     $fvalue['availability'] = $availabilityArray[$program_id][$fvalue['next_grade']];


                //                 }
                //             }
                //             else
                //             {
                //                 $fvalue['final_status'] = "No Availability";
                //                 $fvalue['availability'] = 0;//$availabilityArray[$program_id][$fvalue['next_grade']];

                //             }

                //         }
                //         else
                //         {
                //             $fvalue['final_status'] = "Waitlist By Already Offered";
                //         }
                //     } //1
                //     $tmpArr[] = $fvalue;
                // }
                // $tmpArr1 = [];
                // foreach($tmpArr as $tkey=>$tvalue)
                // {
                //     if($tvalue['final_status'] == "Waitlisted By Race" && in_array($tvalue['id'], $firstOffered))
                //     {
                //         $tvalue['final_status'] = "Waitlisted By Already Offered";
                //     }
                //     $tmpArr1[] = $tvalue;
                // }
                // $final_data = $tmpArr1;
            }
        }
        //dd($final_data);
        if ($type == "update") {
            SubmissionsSelectionReportMaster::where("enrollment_id", Session::get("enrollment_id"))->where("application_id", $application_id)->where("type", "regular")->delete();
            SubmissionsRaceCompositionReport::where("enrollment_id", Session::get("enrollment_id"))->where("application_id", $application_id)->where("type", "regular")->delete();
            //  



            foreach ($final_data as $key => $value) {
                if ($value['final_status'] == "Offered") {
                    $insert = [];
                    if ($value['choice'] == 1) {
                        $insert['first_waitlist_for'] = $value['first_choice_program_id'];
                        $insert['first_choice_final_status'] = "Offered";
                        $awarded_school = getProgramName($insert['first_waitlist_for']);
                        $insert['first_choice_eligibility_reason'] = "";
                    } else {
                        $insert['second_waitlist_for'] = $value['second_choice_program_id'];
                        $insert['second_choice_final_status'] = "Offered";
                        $awarded_school = getProgramName($insert['second_waitlist_for']);
                        $insert['second_choice_eligibility_reason'] = "";
                    }
                    do {
                        $code = mt_rand(100000, 999999);
                        $user_code = SubmissionsFinalStatus::where('offer_slug', $code)->first();
                        $user_code1 = LateSubmissionFinalStatus::where('offer_slug', $code)->first();
                        $user_code2 = SubmissionsWaitlistFinalStatus::where('offer_slug', $code)->first();
                    } while (!empty($user_code) && !empty($user_code1) && !empty($user_code2));
                    $insert['submission_id'] = $value['id'];
                    $insert['offer_slug'] = $code;
                    $insert['application_id'] = $application_id;
                    $insert['enrollment_id'] = Session::get("enrollment_id");
                    $rs = Submissions::where("id", $value['id'])->update(array("awarded_school" => $awarded_school));



                    $rs = SubmissionsFinalStatus::updateOrCreate(["submission_id" => $value['id']], $insert);
                } else {
                    $insert = [];
                    if ($value['choice'] == 1) {
                        $insert['first_waitlist_for'] = $value['first_choice_program_id'];
                        $insert['first_choice_final_status'] = "Waitlisted";
                        $insert['first_choice_eligibility_reason'] = "";
                    } else {
                        $insert['second_waitlist_for'] = $value['second_choice_program_id'];
                        $insert['second_choice_final_status'] = "Waitlisted";
                        $insert['second_choice_eligibility_reason'] = "";
                    }
                    $insert['submission_id'] = $value['id'];
                    $insert['application_id'] = $application_id;
                    $insert['enrollment_id'] = Session::get("enrollment_id");
                    $rs = SubmissionsFinalStatus::updateOrCreate(["submission_id" => $value['id']], $insert);
                }
                $reportData = [];
                $reportData['submission_id'] = $value['id'];
                $reportData['application_id'] = $application_id;
                $reportData['first_choice'] = $value['first_program'];
                $reportData['second_choice'] = $value['second_program'];
                $reportData['priority'] = $value['rank'];
                $reportData['committee_score'] = $value['committee_score'];
                $reportData['composite_score'] = $value['composite_score'];
                $reportData['enrollment_id'] = Session::get("enrollment_id");
                if (!$preliminary_score)
                    $reportData['score_type'] = "composite_score";
                else
                    $reportData['score_type'] = "committee_score";
                $reportData['final_status'] = $value['final_status'];
                $reportData['race_composition_update'] = (isset($value['update']) ? $value['update'] : "");
                $reportData['available_seats'] = (isset($value['availability']) ? $value['availability'] : 0);
                $rp = SubmissionsSelectionReportMaster::create($reportData);
                //1023
            }

            $rsUpdate = SubmissionsFinalStatus::where("first_choice_final_status", "Offered")->where("second_choice_final_status", "Waitlisted")->update(array("second_choice_final_status" => "Pending", "second_waitlist_for" => 0));

            $data = $this->group_racial_composition;
            foreach ($data as $key => $value) {
                $composition_data = [];
                $composition_data['application_id'] = $application_id;
                $composition_data['program_group'] = $key;
                $composition_data['black'] = $value['black'];
                $composition_data['white'] = $value['white'];
                $composition_data['other'] = $value['other'];
                $composition_data['enrollment_id'] = Session::get("enrollment_id");
                $composition_data['version'] = 0;
                $rs = SubmissionsRaceCompositionReport::updateOrCreate(["application_id" => $application_id, "program_group" => $key], $composition_data);
            }
            return true; //echo "done";
            //exit;
        } else {
            $group_racial_composition = $this->group_racial_composition;
            return view("ProcessSelection::test_index", compact("final_data", "incomplete_arr", "failed_arr", "group_racial_composition", "preliminary_score"));
        }
        //exit;

    }



    public function loopWaitlistForOffer($final_data)
    {
        $tmpArr = [];
        $isOffered = false;
        foreach ($final_data as $fkey => $fvalue) {
            if ($fvalue['choice'] == 1)
                $program_id = $fvalue['first_choice_program_id'];
            else
                $program_id = $fvalue['second_choice_program_id'];
            $group_name = $this->program_group[$program_id];
            if ($isOffered) {
                $tmpArr[] = $fvalue;
            } else {
                if ($fvalue['final_status'] == "Waitlist By Race" && $this->offer_program_id == $group_name) { //1
                    if (!in_array($fvalue['id'], $this->firstOffered)) {
                        if (isset($this->availabilityArray[$program_id][$fvalue['next_grade']]) && $this->availabilityArray[$program_id][$fvalue['next_grade']] > 0) {

                            $race = strtolower($fvalue['race']);
                            $group_name = $this->program_group[$program_id];

                            $total_seats = $this->group_racial_composition[$group_name]['total'];
                            $race_percent = $this->group_racial_composition[$group_name][$race];
                            $total_seats++;
                            $race_percent++;
                            $new_percent = number_format($race_percent * 100 / $total_seats, 2);

                            if ($this->check_all_race_range($group_name, $race, $fvalue['id'])) {
                                $this->group_racial_composition[$group_name]['total'] = $total_seats;
                                $this->group_racial_composition[$group_name][$race] = $race_percent;

                                $fvalue['final_status'] = "Offered";
                                if (isset($fvalue['update']))
                                    $update = $fvalue['update'] . "<br>-----------<br>Offered ID: " . $this->offered_submission_id . " (" . $this->offered_race . ")<br>";
                                else
                                    $update = "";
                                $fvalue['update'] = $update . $this->generate_race_composition_update($this->group_racial_composition[$group_name], $total_seats, $race);


                                $this->firstOffered[] = $fvalue['id'];
                                $fvalue['availability'] = $this->availabilityArray[$program_id][$fvalue['next_grade']];

                                $tmp_stock = $this->availabilityArray[$program_id][$fvalue['next_grade']];
                                $tmp_stock--;
                                $this->availabilityArray[$program_id][$fvalue['next_grade']] = $tmp_stock;
                                $isOffered = true;
                            } else {
                                if (isset($fvalue['update']))
                                    $update = $fvalue['update'] . "<br>-----------<br>Offered ID: " . $this->offered_submission_id . " (" . $this->offered_race . ")<br>";
                                else
                                    $update = "";
                                $total_seats = $this->group_racial_composition[$group_name]['total'];
                                $fvalue['update'] = $update . $this->generate_race_composition_update($this->group_racial_composition[$group_name], $total_seats, $race, "W");
                                $fvalue['availability'] = $this->availabilityArray[$program_id][$fvalue['next_grade']];
                            }
                        } else {
                            $fvalue['final_status'] = "No Availability";
                            $fvalue['availability'] = 0; //$availabilityArray[$program_id][$fvalue['next_grade']];

                        }
                    } else {
                        $fvalue['final_status'] = "Waitlist By Already Offered";
                    }
                } //1
                $tmpArr[] = $fvalue;
            }
        }

        if ($isOffered)
            return $this->loopWaitlistForOffer($tmpArr);
        else
            return $tmpArr;
    }



    public function processTestSelectionRport($application_id, $existGrade, $gradeArr)
    {
        /* Test Code Ends */
        $process_selection = ProcessSelection::where("enrollment_id", Session::get("enrollment_id"))->where("form_id", $application_id)->where("type", "regular")->first();

        $preliminary_score = false;
        $application_data = Application::where("form_id", $application_id)->where("enrollment_id", Session::get("enrollment_id"))->first();
        if (!empty($application_data) && $application_data->preliminary_processing == "Y")
            $preliminary_score = true;
        if (!empty($process_selection) && $process_selection->commited == "Yes") {
            $final_data = $group_racial_composition = $incomplete_arr = $failed_arr = [];
            return view("ProcessSelection::test_index", compact("final_data", "incomplete_arr", "failed_arr", "group_racial_composition", "preliminary_score"));
        }
        $processType = Config::get('variables.process_separate_first_second_choice');
        $gradeWiseProcessing = Config::get('variables.grade_wise_processing');



        /* save enrollment wise race composition with swing % Data */
        $enrollment_racial = EnrollmentRaceComposition::where("enrollment_id", Session::get("enrollment_id"))->first();
        $swing = $enrollment_racial->swing;




        /* Create Application Filter Group Array for Program */

        $af_programs = $this->fetch_programs_group($application_id);
        $tmp = $this->groupByRacism($af_programs);

        $this->group_racial_composition = $group_race_array = $tmp['group_race'];
        $this->program_group = $program_group_array = $tmp['program_group'];

        $tmpGroup = array_values($program_group_array);
        $arr = array_unique($tmpGroup);
        $race_enroll_arr = [];
        foreach ($arr as $key => $value) {
            $rs = ProgramSwingData::where("enrollment_id", Session::get("enrollment_id"))->where("application_id", $application_id)->where("program_name", $value)->first();
            $program_swing = $swing;
            if (!empty($rs)) {
                if (is_numeric($rs->swing_percentage) && $rs->swing_percentage > 0) {
                    $program_swing = $rs->swing_percentage;
                }
            }
            $tmp = [];
            $tmp['min'] = $enrollment_racial->black - $program_swing;
            $tmp['max'] = $enrollment_racial->black + $program_swing;
            $race_enroll_arr[$value]['black'] = $tmp;

            $tmp = [];
            $tmp['min'] = $enrollment_racial->white - $program_swing;
            $tmp['max'] = $enrollment_racial->white + $program_swing;
            $race_enroll_arr[$value]['white'] = $tmp;

            $tmp = [];
            $tmp['min'] = $enrollment_racial->other - $program_swing;
            $tmp['max'] = $enrollment_racial->other + $program_swing;
            $race_enroll_arr[$value]['other'] = $tmp;
        }
        $this->enrollment_race_data = $race_enroll_arr;
        //echo "<pre>";
        //print_r($this->enrollment_race_data);
        //exit;

        $this->availabilityArray = array();
        $allProgram = Availability::distinct()->where("enrollment_id", Session::get("enrollment_id"))->where("district_id", Session::get("district_id"))->get(['program_id']);
        foreach ($allProgram as $key => $value) {
            $avail_grade = Availability::where("district_id", Session::get("district_id"))->where("program_id", $value->program_id)->get();
            foreach ($avail_grade as $gkey => $gvalue) {
                $this->availabilityArray[$value->program_id][$gvalue->grade] = $gvalue->available_seats;
            }
        }
        //  dd($allProgram,$availabilityArray);
        /* from here */
        $firstData = Submissions::distinct()->where("enrollment_id", Session::get("enrollment_id"))->whereIn("submission_status", array('Active', 'Pending'))->where("form_id", $application_id)->get(["first_choice"]); // ->where("next_grade", $existGrade)
        $secondData = Submissions::distinct()->where("enrollment_id", Session::get("enrollment_id"))->whereIn("submission_status", array('Active', 'Pending'))->where("form_id", $application_id)->get(["second_choice"]);

        /* Get Subject and Acardemic Term like Q1.1 Q1.2 etc set for Academic Grade Calculation 
                For all unique First Choice and Second Choice
         */
        $subjects = $terms = $programArr = $test_scores_titles = array();
        $eligibilityArr = array();

        foreach ($firstData as $key => $value) {
            if ($value->first_choice != "" && !in_array($value->first_choice, $programArr)) {
                $programArr[] = $value->first_choice;
                $data = getSetEligibilityDataDynamic($value->first_choice, 12);
                if (isset($data->ts_scores)) {
                    foreach ($data->ts_scores as $ts => $tv) {
                        if (!in_array($tv, $test_scores_titles)) {
                            $test_scores_titles[] = $tv;
                        }
                    }
                }
            }
        }
        foreach ($secondData as $key => $value) {
            if ($value->second_choice != "" && !in_array($value->second_choice, $programArr)) {
                $programArr[] = $value->second_choice;
                $data = getSetEligibilityDataDynamic($value->second_choice, 12);
                if (isset($data->ts_scores)) {
                    foreach ($data->ts_scores as $ts => $tv) {
                        if (!in_array($tv, $test_scores_titles)) {
                            $test_scores_titles[] = $tv;
                        }
                    }
                }
            }
        }

        /* Get Set Eligibility Data Set for first choice program and second choice program
         */

        $setEligibilityData = $setCommitteScoreEligibility = array();
        foreach ($firstData as $value) {
            if (!in_array($value->first_choice, array_keys($setCommitteScoreEligibility))) {
                $data = getSetEligibilityDataDynamic($value->first_choice, 7);
                if (isset($data->minimum_score))
                    $setCommitteScoreEligibility[$value->first_choice] = $data->minimum_score;
                else
                    $setCommitteScoreEligibility[$value->first_choice] = 2;
            }
        }

        foreach ($secondData as $value) {
            if (!in_array($value->second_choice, array_keys($setCommitteScoreEligibility))) {
                $data = getSetEligibilityDataDynamic($value->second_choice, 7);
                if (isset($data->minimum_score))
                    $setCommitteScoreEligibility[$value->second_choice] = $data->minimum_score;
                else
                    $setCommitteScoreEligibility[$value->second_choice] = 2;
            }
        }

        /* Code to fetch all selection properties of each program
        and Create array after soring. So we can get idea what is 
        selection ranking for each program */
        $programSortArr = [];
        foreach ($programArr as $key => $val) {
            $rsProgram = Program::where("id", getApplicationProgramId($val))->first();
            if (!empty($rsProgram)) {
                $tmp = array();
                if ($rsProgram->rating_priority != '')
                    $tmp['rating_priority'] = $rsProgram->rating_priority;
                if ($rsProgram->committee_score != '')
                    $tmp['committee_score'] = $rsProgram->committee_score;
                if ($rsProgram->audition_score != '')
                    $tmp['audition_score'] = $rsProgram->audition_score;
                if ($rsProgram->rating_priority != '')
                    $tmp['rating_priority'] = $rsProgram->rating_priority;
                if ($rsProgram->combine_score != '')
                    $tmp['combine_score'] = $rsProgram->combine_score;
                if ($rsProgram->lottery_number != '')
                    $tmp['lottery_number'] = $rsProgram->lottery_number;
                if ($rsProgram->final_score != '')
                    $tmp['final_score'] = $rsProgram->final_score;
                asort($tmp);
                $programSortArr[$rsProgram->id] = $tmp;
            }
        }
        /* Get CDI Set Eligibility Data Set for first choice program and second choice program
         */

        $setCDIEligibilityData = array();

        $committee_eligibility = ProgramEligibility::join("eligibility_template", "eligibility_template.id", "program_eligibility.eligibility_type")->join("program", "program.id", "program_eligibility.program_id")->where("program.parent_submission_form", $application_id)->where("program.enrollment_id", Session::get("enrollment_id"))->where("eligibility_template.name", "Committee Score")->where("program_eligibility.status", "Y")->select("program.id")->get()->toArray();
        $committee_program_id = [];
        foreach ($committee_eligibility as $key => $value) {
            $committee_program_id[] = $value['id'];
        }

        /* Get CDI Data */
        $submissions = Submissions::where('submissions.district_id', Session::get('district_id'))
            ->whereIn('submission_status', array("Active"))
            //->where("id", 1055)
            //     ->where("next_grade", $existGrade)
            ->where("form_id", $application_id)
            ->get();

        $firstdata = $seconddata = array();
        $incomplete_arr = $failed_arr = $interview_arr = array();

        $programGrades = array();
        $committee_count = 0;
        foreach ($submissions as $key => $value) {
            $interview_passed = true;
            $composite_score = 0;
            if ($preliminary_score) {
                $interview_score = SubmissionInterviewScore::where("submission_id", $value->id)->first();
                if (!empty($interview_score)) {
                    if ($interview_score->data == 0) {
                        $interview_passed = false;
                    }
                } else
                    $interview_passed = false;

                generateCompositeScore($value->id);
                $rs = SubmissionCompositeScore::where("submission_id", $value->id)->first();
                if (!empty($rs)) {
                    $composite_score = $rs->score;
                }
            }
            if ($value->first_choice != "" && $value->second_choice != "") {
                $failed = false;
                $tmpfirstdata = [];
                $firstfailed = $firstincomplete = false;
                $incomplete = false;

                $tmp = app('App\Modules\Reports\Controllers\ReportsController')->convertToArray($value);
                $choice = getApplicationProgramName($value->first_choice);
                $tmp['first_program'] = getApplicationProgramName($value->first_choice);
                $tmp['first_choice'] = $value->first_choice;
                $tmp['first_choice_program_id'] = $value->first_choice_program_id;
                $tmp['second_choice_program_id'] = $value->second_choice_program_id;
                $tmp['second_choice'] = $value->second_choice;
                $tmp['second_program'] = "";
                $tmp['test_scores'] = app('App\Modules\Reports\Controllers\ReportsController')->getProgramTestScores($value->first_choice_program_id, $value->id, $test_scores_titles);
                $tmp['rank'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "first");

                $tmp['committee_score'] = getSubmissionCommitteeScore($value->id, $value->first_choice_program_id);

                if (!in_array($value->first_choice_program_id, $committee_program_id)) {
                    $tmp['committee_score'] = "NA";
                } else {
                    $committee_count++;
                }

                if ($tmp['committee_score'] == null) {
                    $firstincomplete = true;
                    $incomplete = true;
                } elseif (is_numeric($tmp['committee_score']) && $tmp['committee_score'] >= $setCommitteScoreEligibility[$value->first_choice]) {
                    $tmp['committee_score_status'] = 'Pass';
                } elseif ($tmp['committee_score'] != "NA") {
                    $tmp['committee_score_status'] = 'Fail';
                    $firstfailed = true;
                    $failed = true;
                }
                $tmp['choice'] = 1;
                $tmp['composite_score'] = $composite_score;

                if ($value->submission_status == "Pending") {
                    $incomplete_arr[] = $tmp;
                    $firstincomplete = true;
                } elseif (!$interview_passed) {
                    $interview_arr[] = $tmp;
                } else {
                    if ($failed)
                        $failed_arr[] = $tmp;
                    elseif ($incomplete)
                        $incomplete_arr[] = $tmp;
                    else {
                        $tmpfirstdata = $tmp;
                    }
                }


                $failed = false;
                $incomplete = false;
                $tmp['test_scores'] = app('App\Modules\Reports\Controllers\ReportsController')->getProgramTestScores($value->second_choice_program_id, $value->id, $test_scores_titles);

                $tmp['committee_score'] = getSubmissionCommitteeScore($value->id, $value->second_choice_program_id);

                if (!in_array($value->second_choice_program_id, $committee_program_id)) {
                    $tmp['committee_score'] = "NA";
                }

                if ($tmp['committee_score'] == null)
                    $incomplete = true;
                elseif (is_numeric($tmp['committee_score']) && $tmp['committee_score'] >= $setCommitteScoreEligibility[$value->second_choice]) {
                    $tmp['committee_score_status'] = 'Pass';
                } elseif ($tmp['committee_score'] != "NA") {
                    $tmp['committee_score_status'] = 'Fail';
                    $failed = true;
                }

                $tmp['rank'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "second");


                $tmp['second_program'] = getApplicationProgramName($value->second_choice);
                $tmp['first_program'] = "";
                $tmp['choice'] = 2;
                /*
                if($failed && !$firstfailed)
                {
                    $tmp['committee_score_status'] = "Fail";
                    $failed_arr[] = $tmp;
                }
                elseif($incomplete && !$firstincomplete)
                {
                    $tmp['committee_score_status'] = "NA";
                    $incomplete_arr[] = $tmp;
                }
                elseif(!$firstfailed && !$firstincomplete)
                {
                    $firstdata[$value->first_choice_program_id][] = $tmpfirstdata;
                    $seconddata[$value->second_choice_program_id][] = $tmp;
                }*/
                if (!$firstfailed && !$firstincomplete) {
                    $firstdata[$value->first_choice_program_id][] = $tmpfirstdata;
                }

                if ($value->submission_status == "Pending") {
                    $incomplete_arr[] = $tmp;
                } elseif (!$interview_passed) {
                    $interview_arr[] = $tmp;
                } else {
                    if ($failed) {
                        $failed_arr[] = $tmp;
                    } elseif ($incomplete) {
                        $incomplete_arr[] = $tmp;
                    } else {
                        $seconddata[$value->second_choice_program_id][] = $tmp;
                    }
                }
            } elseif ($value->first_choice != "") {
                $failed = false;
                $incomplete = false;

                $tmp = app('App\Modules\Reports\Controllers\ReportsController')->convertToArray($value);
                $tmp['composite_score'] = $composite_score;
                $choice = getApplicationProgramName($value->first_choice);
                $tmp['first_program'] = getApplicationProgramName($value->first_choice);
                $tmp['first_choice_program_id'] = $value->first_choice_program_id;
                $tmp['second_choice_program_id'] = $value->second_choice_program_id;
                $tmp['second_program'] = "";
                $tmp['first_choice'] = $value->first_choice;
                $tmp['second_choice'] = $value->second_choice;
                $tmp['rank'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "first");
                $tmp['test_scores'] = app('App\Modules\Reports\Controllers\ReportsController')->getProgramTestScores($value->first_choice_program_id, $value->id, $test_scores_titles);

                $tmp['committee_score'] = getSubmissionCommitteeScore($value->id, $value->first_choice_program_id);
                if (!in_array($value->first_choice_program_id, $committee_program_id)) {
                    $tmp['committee_score'] = "NA";
                } else {
                    $committee_count++;
                }

                if ($tmp['committee_score'] == null)
                    $incomplete = true;
                elseif (is_numeric($tmp['committee_score']) && $tmp['committee_score'] >= $setCommitteScoreEligibility[$value->first_choice]) {
                    $tmp['committee_score_status'] = 'Pass';
                } elseif ($tmp['committee_score'] != "NA") {
                    $tmp['committee_score_status'] = 'Fail';
                    $failed = true;
                }

                $tmp['choice'] = 1;
                $tmp['rank'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "first");

                if ($value->submission_status == "Pending") {
                    $incomplete_arr[] = $tmp;
                } elseif (!$interview_passed) {
                    $interview_arr[] = $tmp;
                } else {
                    if ($failed)
                        $failed_arr[] = $tmp;
                    elseif ($incomplete)
                        $incomplete_arr[] = $tmp;
                    else
                        $firstdata[$value->first_choice_program_id][] = $tmp;
                }
            } else {
                $failed = false;
                $incomplete = false;

                $tmp = app('App\Modules\Reports\Controllers\ReportsController')->convertToArray($value);
                $tmp['composite_score'] = $composite_score;
                $tmp['test_scores'] = $test_scores;
                $tmp['second_program'] = getApplicationProgramName($value->second_choice);
                $tmp['first_choice_program_id'] = $value->first_choice_program_id;
                $tmp['second_choice_program_id'] = $value->second_choice_program_id;
                $tmp['first_program'] = "";
                $tmp['first_choice'] = $value->first_choice;
                $tmp['second_choice'] = $value->second_choice;
                $tmp['test_scores'] = app('App\Modules\Reports\Controllers\ReportsController')->getProgramTestScores($value->second_choice_program_id, $value->id, $test_scores_titles);

                $tmp['rank'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "second");
                $tmp['magnet_employee'] = $value->mcp_employee;
                $tmp['magnet_program_employee'] = $value->magnet_program_employee;
                $tmp['committee_score'] = getSubmissionCommitteeScore($value->id, $value->second_choice_program_id);
                if (!in_array($value->second_choice_program_id, $committee_program_id)) {
                    $tmp['committee_score'] = "NA";
                } else {
                    $committee_count++;
                }

                if ($tmp['committee_score'] == null)
                    $incomplete = true;
                elseif (!$interview_passed) {
                    $interview_arr[] = $tmp;
                } elseif (is_numeric($tmp['committee_score']) && $tmp['committee_score'] >= $setCommitteScoreEligibility[$value->second_choice]) {
                    $tmp['committee_score_status'] = 'Pass';
                } elseif ($tmp['committee_score'] != "NA") {
                    $tmp['committee_score_status'] = 'Fail';
                    $failed = true;
                }

                $tmp['choice'] = 2;
                $tmp['rank'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "second");

                if ($value->submission_status == "Pending") {
                    $incomplete_arr[] = $tmp;
                } else {

                    if ($failed)
                        $failed_arr[] = $tmp;
                    elseif ($incomplete)
                        $incomplete_arr[] = $tmp;
                    else
                        $seconddata[$value->second_choice_program_id][] = $tmp;
                }
            }
        }


        //echo "<pre>Failed<BR><BR>";
        //print_r($failed_arr);
        //echo "<pre>Incomplete<BR><BR>";
        //print_r($incomplete_arr);
        //exit;
        /*
echo "<pre>First Data<br><br>";
print_r($firstdata);

echo "<pre>Second Data<br><br>";
print_r($seconddata);
exit;*/
        /* Update failed and income statuses to database */


        /* Sort all submission based on selection rank set 
        by each program array */
        $ids = array('PreK', 'K', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $firstPrgData = $secondPrgData = [];
        $loopArr = array("first", "second");
        if (!$processType) {
            $dataStoreArr = array("first", "first");
        } else {
            $dataStoreArr = array("first", "second");
        }


        $append_second = $append_first = [];
        foreach ($loopArr as $lkey => $lvalue) {
            $str = $lvalue . "data";
            $arrvar = ${$str};
            foreach ($arrvar as $key => $value) {

                $parray = $value;
                if (isset($programSortArr[$key])) {
                    $array = $value;
                    $sortingParams = [];
                    $first_column = "";
                    $i = 0;
                    foreach ($programSortArr[$key] as $pk => $pv) {
                        if ($i == 0)
                            $first_column = $pk;
                        $i++;
                    }

                    $first_col_arr = array_column($array, $first_column);

                    $tmpStr = $dataStoreArr[$lkey] . "PrgData";

                    if ($first_column != "committee_score" && $first_column != "combine_score" && (in_array($key, $committee_program_id) || $key == 19 || $key == 42 || $key == 66)) {
                        foreach ($array as $pk => $pv) {
                            $pv['final_score'] = 0;
                            ${"append_" . $lvalue}[] = $pv;
                        }

                        foreach ($programSortArr[$key] as $pk => $pv) {
                            if ($pk == "rating_priority") {
                                $sort_field = "rank";
                                $sort_type = SORT_ASC;
                            } else {
                                $sort_field = $pk;
                                $sort_type = SORT_DESC;
                            }


                            $sortingParams[] = array_column(${"append_" . $dataStoreArr[$lkey]}, $sort_field);
                            $sortingParams[] = $sort_type;
                        }
                        $sortingParams[] = &${"append_" . $dataStoreArr[$lkey]};
                        array_multisort(...$sortingParams);
                    } else {

                        foreach ($array as $pk => $pv) {
                            $pv['final_score'] = 0;
                            ${$tmpStr}[] = $pv;
                        }
                    }
                }
            }
        }
        $firstdata = $firstPrgData;
        if (!empty($firstdata)) {
            $committee_score  = $priority = $lottery_number = $choices = $next_grade = array();
            foreach ($firstdata as $key => $value) {
                try {
                    if ($preliminary_score)
                        $committee_score['committee_score'][] = $value['composite_score'];
                    else
                        $committee_score['committee_score'][] = $value['committee_score'];
                } catch (\Exception $e) {
                    echo $value['id'];
                    exit;
                }
                $priority['rank'][] = $value['rank'];
                $lottery_number['lottery_number'][] = $value['lottery_number'];
                $choices['choice'][] = $value['choice'];
                //$next_grade['next_grade'][] = $value['next_grade'];

            }
            if (!$processType) {
                array_multisort($committee_score['committee_score'], SORT_DESC, $priority['rank'], SORT_ASC, $lottery_number['lottery_number'], SORT_DESC, $choices['choice'], SORT_ASC, $firstdata);
            } else {
                array_multisort($committee_score['committee_score'], SORT_DESC, $priority['rank'], SORT_ASC, $lottery_number['lottery_number'], SORT_DESC, $firstdata);
            }
        }
        if ($committee_count > 0) {
            $firstdata = array_merge($append_first, $firstdata);
            if (!$processType) {
                $firstdata = array_merge($firstdata, $append_second);
            }
        }

        if ($gradeWiseProcessing) {
            $tmp = [];
            foreach ($ids as $ik => $iv) {
                foreach ($firstdata as $fk => $fv) {
                    if ($fv['next_grade'] == $iv) {
                        $tmp[] = $fv;
                    }
                }
            }


            $firstdata = $tmp;
        }


        if ($processType) {
            $seconddata = $secondPrgData;
            if (!empty($seconddata)) {
                $committee_score  = $priority = $lottery_number = array();
                foreach ($seconddata as $key => $value) {
                    if ($preliminary_score)
                        $committee_score['committee_score'][] = $value['composite_score'];
                    else
                        $committee_score['committee_score'][] = $value['committee_score'];
                    $priority['rank'][] = $value['rank'];
                    $lottery_number['lottery_number'][] = $value['lottery_number'];
                }
                array_multisort($committee_score['committee_score'], SORT_DESC, $priority['rank'], SORT_ASC, $lottery_number['lottery_number'], SORT_DESC, $seconddata);
            }
            $seconddata = array_merge($seconddata, $append_second);
        } else {
            $seconddata = [];
        }



        $tmpAvailability = $this->availabilityArray;
        //        echo "<pre>";
        //        print_r($availabilityArray);exit;
        $waitlistOfferArray  = $offeredRank = $this->firstOffered = array();
        $final_data = [];
        foreach ($firstdata as $key => $value) {
            if ($value['choice'] == 1)
                $program_id = $value['first_choice_program_id'];
            else
                $program_id = $value['second_choice_program_id'];

            $offered = false;
            $this->offered_race = "";
            $this->offered_submission_id = "";
            $this->offer_program_id = 0;
            if (in_array($value['id'], $this->firstOffered)) {
                $value['final_status'] = "Waitlist By Already Offered";
            } else {
                if (isset($this->availabilityArray[$program_id][$value['next_grade']]) && $this->availabilityArray[$program_id][$value['next_grade']] > 0) {
                    $race = strtolower($value['race']);
                    $group_name = $this->program_group[$program_id];

                    $offer_type = "normal";
                    if ($this->group_racial_composition[$group_name]['no_previous'] == 'Y') {
                        $offer_type = $this->check_race_previous_data($group_name, $race);
                        //echo $value['id']." - " .getProgramName($program_id)." - ".$offer_type."<BR>";//exit;
                    }

                    $total_seats = $this->group_racial_composition[$group_name]['total'];
                    $race_percent = $this->group_racial_composition[$group_name][$race];
                    $total_seats++;
                    $race_percent++;

                    $new_percent = number_format($race_percent * 100 / $total_seats, 2);


                    if ($this->check_all_race_range($group_name, $race, $value['id']) || in_array($offer_type, array('OnlyThisOffered', 'OfferedWaitlisted'))) {

                        $update = $this->generate_race_composition_update($this->group_racial_composition[$group_name], $this->group_racial_composition[$group_name]['total'], $race, "N");
                        $update .= "<br>-----------<br>";
                        $this->group_racial_composition[$group_name]['total'] = $total_seats;
                        $this->group_racial_composition[$group_name][$race] = $race_percent;

                        $value['final_status'] = "Offered";

                        $offered_race = $race;
                        $offered_submission_id = $value['id'];
                        $value['update'] = $this->generate_race_composition_update($this->group_racial_composition[$group_name], $total_seats, $race);

                        $value['availability'] = $this->availabilityArray[$program_id][$value['next_grade']];

                        $this->firstOffered[] = $value['id'];
                        $offered = true;
                        $this->offer_program_id = $group_name;
                        $tmp_stock = $this->availabilityArray[$program_id][$value['next_grade']];
                        $tmp_stock--;
                        $this->availabilityArray[$program_id][$value['next_grade']] = $tmp_stock;

                        /*if(in_array($value['id'], $this->waitlistRaceArr))
                        {
                            $tmp_final_arr = [];
                            foreach($final_data as $flkey=>$flvalue)
                            {
                                if($flvalue['id'] == $value['id'] && $flvalue['choice'] != $value['choice'])
                                {
                                    $flvalue['final_status'] = "Waitlisted By Already Offered";
                                }
                                $tmp_final_arr[] = $flvalue;

                            }
                            if (($key_index = array_search($value['id'], $this->waitlistRaceArr)) !== false) {
                                unset($this->waitlistRaceArr[$key_index]);
                            }
                            $final_data = $tmp_final_arr;
                        }*/
                    } else {
                        $value['final_status'] = "Waitlist By Race";

                        $total_seats = $this->group_racial_composition[$group_name]['total'];
                        $value['update'] = $this->generate_race_composition_update($this->group_racial_composition[$group_name], $total_seats, $race, "W");
                        $value['availability'] = $this->availabilityArray[$program_id][$value['next_grade']];
                    }
                } else {
                    $value['final_status'] = "No Availability";
                }
            }

            $final_data[] = $value;
            if ($offered && in_array($offer_type, array('normal', 'OfferedWaitlisted'))) {
                $final_data = $this->loopWaitlistForOffer($final_data);
            }
        }

        // foreach($final_data as $value)
        // {
        //     if($value['id'] == 4028)
        //     {
        //         echo $value['id']." - ".$value['choice'] . " - ".$value['final_status'];
        //         exit;
        //     }
        // }
        $group_racial_composition = $this->group_racial_composition;
        return view("ProcessSelection::test_index_selection", compact("application_id", "final_data", "incomplete_arr", "failed_arr", "group_racial_composition", "preliminary_score", "existGrade", "gradeArr"));
    }


    //public $eligibility_grade_pass = array();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = Form::where("status", "y")->get();

        $displayother = SubmissionsFinalStatus::where("enrollment_id", Session::get("enrollment_id"))->count();
        $tmp = DistrictConfiguration::where("district_id", Session::get("district_id"))->where("name", "last_date_online_acceptance")->first();

        return view("ProcessSelection::index", compact("applications"));
    }

    public function index_step2($application_id = 0)
    {
        //$this->updated_racial_composition($application_id);exit;
        $applications = Application::where("enrollment_id", Session::get("enrollment_id"))->get();
        $additional_data = $this->get_additional_info($application_id);
        $displayother = $additional_data['displayother'];
        $display_outcome = $additional_data['display_outcome'];
        $enrollment_racial = $additional_data['enrollment_racial'];
        $swingData = $additional_data['swingData'];
        $prgGroupArr = $additional_data['prgGroupArr'];
        $last_date_online_acceptance = $additional_data['last_date_online_acceptance'];
        $last_date_offline_acceptance = $additional_data['last_date_offline_acceptance'];

        return view("ProcessSelection::index_step2", compact("application_id", "last_date_online_acceptance", "last_date_offline_acceptance", "applications", "displayother", "display_outcome", "enrollment_racial", "swingData", "prgGroupArr"));
    }

    public function get_additional_info($application_id = 0)
    {
        $process_selection = ProcessSelection::where("enrollment_id", Session::get("enrollment_id"))->where("form_id", $application_id)->first();

        $display_outcome = 0;
        $displayother = 0;

        if (!empty($process_selection)) {
            $displayother = 1;

            if ($process_selection->commited == "Yes") {
                $display_outcome = 1;
                $last_date_online_acceptance = date('m/d/Y H:i', strtotime($process_selection->last_date_online_acceptance));
                $last_date_offline_acceptance = date('m/d/Y H:i', strtotime($process_selection->last_date_offline_acceptance));
            } else {
                $last_date_online_acceptance = "";
                $last_date_offline_acceptance = "";
            }
        } else {
            $last_date_online_acceptance = "";
            $last_date_offline_acceptance = "";
        }

        /* Swing Data Calculation */
        //$application_data = Application::where("form_id", $application_id)->first();
        $prgGroupArr = $swingData = [];


        $programs = Program::where("enrollment_id", Session::get("enrollment_id"))->where("district_id", Session::get("district_id"))->where("parent_submission_form", $application_id)->where('status', 'Y')->get();
        foreach ($programs as $key => $value) {
            if ($value->applicant_filter1 != '')
                $prgGroupArr[] = $value->applicant_filter1;
            if ($value->applicant_filter2 != '')
                $prgGroupArr[] = $value->applicant_filter2;
            if ($value->applicant_filter3 != '')
                $prgGroupArr[] = $value->applicant_filter3;
            if ($value->applicant_filter1 == '' && $value->applicant_filter2 == '' && $value->applicant_filter3 == '') {
                $prgGroupArr[] = $value->name;
            }
        }
        $prgGroupArr = array_unique($prgGroupArr);
        foreach ($prgGroupArr as $key => $value) {
            $rs = ProgramSwingData::where("enrollment_id", Session::get("enrollment_id"))->where("application_id", $application_id)->where("program_name", $value)->where("district_id", Session::get("district_id"))->first();
            if (!empty($rs)) {
                $swingData[$value] = $rs->swing_percentage;
            }
        }


        $enrollment_racial = EnrollmentRaceComposition::where("enrollment_id", Session::get("enrollment_id"))->first();
        return array("display_outcome" => $display_outcome, "displayother" => $displayother, "enrollment_racial" => $enrollment_racial, "prgGroupArr" => $prgGroupArr, "swingData" => $swingData, "last_date_online_acceptance" => $last_date_online_acceptance, "last_date_offline_acceptance" => $last_date_offline_acceptance);
    }

    public function settings_index()
    {
        $applications = Application::where("enrollment_id", Session::get("enrollment_id"))->get();

        return view("ProcessSelection::settings_index", compact("applications"));
    }

    public function settings_step_two($application_id = 0)
    {
        // Fetch All Forms - Applications
        $display_outcome = SubmissionsStatusUniqueLog::where("enrollment_id", Session::get("enrollment_id"))->count();

        $applications = Application::where("enrollment_id", Session::get("enrollment_id"))->get();
        //$application_data = Application::where("id", $application_id)->first();

        $prgGroupArr = $swingData = [];

        $programs = Program::where("enrollment_id", Session::get("enrollment_id"))->where("enrollment_id", Session::get("enrollment_id"))->where("district_id", Session::get("district_id"))->where("parent_submission_form", $application_id)->where('status', 'Y')->get();
        foreach ($programs as $key => $value) {
            if ($value->applicant_filter1 != '')
                $prgGroupArr[] = $value->applicant_filter1;
            if ($value->applicant_filter2 != '')
                $prgGroupArr[] = $value->applicant_filter2;
            if ($value->applicant_filter3 != '')
                $prgGroupArr[] = $value->applicant_filter3;
            if ($value->applicant_filter1 == '' && $value->applicant_filter2 == '' && $value->applicant_filter3 == '') {
                $prgGroupArr[] = $value->name;
            }
        }
        $prgGroupArr = array_unique($prgGroupArr);
        foreach ($prgGroupArr as $key => $value) {
            $rs = ProgramSwingData::where("enrollment_id", Session::get("enrollment_id"))->where("application_id", $application_id)->where("program_name", $value)->where("district_id", Session::get("district_id"))->first();
            if (!empty($rs)) {
                $swingData[$value] = $rs->swing_percentage;
            }
        }


        $enrollment_racial = EnrollmentRaceComposition::where("enrollment_id", Session::get("enrollment_id"))->first();



        return view("ProcessSelection::settings_step_two", compact("prgGroupArr", "enrollment_racial", "applications", "application_id", "swingData"));
    }


    public function storeSettings(Request $request)
    {
        $req = $request->all();

        $swing_data = $req['swing_data'];
        foreach ($swing_data as $key => $value) {
            if ($req['swing_value'][$key] != '') {
                $data = array();
                $data['application_id'] = $req['application_id'];
                $data['enrollment_id'] = Session::get('enrollment_id');
                $data['district_id'] = Session::get('district_id');
                $data['program_name'] = $value;
                $data['swing_percentage'] = $req['swing_value'][$key];
                $data['user_id'] = Auth::user()->id;
                $rs = ProgramSwingData::updateOrCreate(["application_id" => $data['application_id'], "enrollment_id" => $data['enrollment_id'], "program_name" => $data['program_name']], $data);
            } else {
                $rs = ProgramSwingData::where("application_id", $req['application_id'])->where("enrollment_id", Session::get('enrollment_id'))->where("program_name", $value)->delete();
            }
        }
        Session::flash("success", "Submission Updated successfully.");

        return redirect("/admin/Process/Selection/settings/" . $req['application_id']);
    }

    public function store(Request $request)
    {
        $req = $request->all();

        $process_selection = ProcessSelection::where("enrollment_id", Session::get("enrollment_id"))->where("form_id", $req['application_id'])->first();
        $process = true;
        if (!empty($process_selection) && $process_selection->commited == 'Yes') {
            $process = false;
        }

        if ($process) {
            /* Store Program Swing Data only when Processed Selection is not accepted */
            $swing_data = $req['swing_data'];
            foreach ($swing_data as $key => $value) {
                if ($req['swing_value'][$key] != '') {
                    $data = array();
                    $data['application_id'] = $req['application_id'];
                    $data['enrollment_id'] = Session::get('enrollment_id');
                    $data['district_id'] = Session::get('district_id');
                    $data['program_name'] = $value;
                    $data['swing_percentage'] = $req['swing_value'][$key];
                    $data['user_id'] = Auth::user()->id;
                    $rs = ProgramSwingData::updateOrCreate(["application_id" => $data['application_id'], "enrollment_id" => $data['enrollment_id'], "program_name" => $data['program_name']], $data);
                } else {
                    $rs = ProgramSwingData::where("application_id", $req['application_id'])->where("enrollment_id", Session::get('enrollment_id'))->where("program_name", $value)->delete();
                }
            }
            $test = $this->processTest($req['application_id'], "update");
        }


        $data = array();
        if ($req['last_date_online_acceptance'] != '') {
            $data['last_date_online_acceptance'] = date("Y-m-d H:i:s", strtotime($req['last_date_online_acceptance']));
            $data['last_date_offline_acceptance'] = date("Y-m-d H:i:s", strtotime($req['last_date_offline_acceptance']));
            $data['district_id'] = Session::get("district_id");
            $data['enrollment_id'] = Session::get("enrollment_id");
            $data['form_id'] = $req['application_id'];
            $data['district_id'] = Session::get("district_id");
            $rs = ProcessSelection::updateOrCreate(['application_id' => $data['form_id'], 'enrollment_id' => $data['enrollment_id']], $data);
        }
        echo "done";
    }

    public function generate_race_composition_update($group_data, $total_seats, $race, $type = "S")
    {
        $update = "";
        $tst = $group_data;
        $total_seats = $tst['total'];
        foreach ($tst as $tstk => $tstv) {
            if ($tstk != "total" && $tstk != "no_previous") {
                if ($tstv > 0)
                    $tst_percent = number_format($tstv * 100 / $total_seats, 2);
                else
                    $tst_percent = 0;
                if ($tstk == $race) {
                    if ($type == "W")
                        $clname = "text-danger";
                    elseif ($type == "S")
                        $clname = "text-success";
                    else
                        $clname = "";
                } else
                    $clname = "";
                $update .= "<div><span><strong>" . ucfirst($tstk) . "</strong> :</span> <span class='" . $clname . "'>" . $tst_percent . "% (" . $tstv . ")</span></div>";
            }
        }
        return $update;
    }

    // from here pending

    public function population_change_application($application_id = 1)
    {
        // Processing
        $pid = $application_id;
        $from = "form";

        $additional_data = $this->get_additional_info($application_id);
        $displayother = $additional_data['displayother'];
        $display_outcome = $additional_data['display_outcome'];
        $enrollment_racial = $additional_data['enrollment_racial'];
        $swingData = $additional_data['swingData'];
        $prgGroupArr = $additional_data['prgGroupArr'];
        $last_date_online_acceptance = $additional_data['last_date_online_acceptance'];
        $last_date_offline_acceptance = $additional_data['last_date_offline_acceptance'];



        $applications = Application::where("enrollment_id", Session::get("enrollment_id"))->get();

        // Population Changes
        $programs = [];
        $district_id = \Session('district_id');

        $ids = array('"PreK"', '"K"', '"1"', '"2"', '"3"', '"4"', '"5"', '"6"', '"7"', '"8"', '"9"', '"10"', '"11"', '"12"');
        $ids_ordered = implode(',', $ids);

        $rawOrder = DB::raw(sprintf('FIELD(submissions.next_grade, %s)', "'" . implode(',', $ids) . "'"));

        $submissions = Submissions::where('district_id', $district_id)->where(function ($q) {
            $q->where("first_choice_final_status", "Offered")
                ->orWhere("second_choice_final_status", "Offered");
        })
            ->where("submissions.enrollment_id", Session::get("enrollment_id"))
            ->where('district_id', $district_id)->where("submissions.form_id", $application_id)->join("submissions_final_status", "submissions_final_status.submission_id", "submissions.id")
            ->orderByRaw('FIELD(next_grade,' . implode(",", $ids) . ')')
            ->get(['first_choice_program_id', 'second_choice_program_id', 'next_grade', 'calculated_race', 'first_choice_final_status', 'second_choice_final_status', 'first_waitlist_for', 'second_waitlist_for']);


        $choices = ['first_choice_program_id', 'second_choice_program_id'];
        if (isset($submissions)) {
            foreach ($choices as $choice) {
                foreach ($submissions as $key => $value) {
                    if (!isset($programs[$value->$choice])) {
                        if ($value->$choice != 0)
                            $programs[$value->$choice] = [];
                    }
                    if ($value->$choice != 0 && !in_array($value->next_grade, $programs[$value->$choice])) {
                        array_push($programs[$value->$choice], $value->next_grade);
                    }
                }
            }
        }
        ksort($programs);
        $data_ary = [];
        $race_ary = [];

        foreach ($programs as $program_id => $grades) {
            foreach ($grades as $grade) {
                $availability = Availability::where("enrollment_id", Session::get("enrollment_id"))->where('program_id', $program_id)
                    ->where('grade', $grade)->first(['total_seats', 'available_seats']);
                $race_count = [];
                if (!empty($availability)) {
                    foreach ($choices as $choice) {
                        if ($choice == "first_choice_program_id") {
                            $submission_race_data = $submissions->where($choice, $program_id)->where('first_choice_final_status', "Offered")
                                ->where('next_grade', $grade);
                        } else {
                            $submission_race_data = $submissions->where($choice, $program_id)->where('second_choice_final_status', "Offered")
                                ->where('next_grade', $grade);
                        }

                        $race = $submission_race_data->groupBy('calculated_race')->map->count();
                        //echo "<pre>";
                        //print_r($race);
                        if (count($race) > 0) {
                            $race_ary = array_merge($race_ary, $race->toArray());

                            if (count($race_count) > 0) {
                                foreach ($race as $key => $value) {

                                    if (isset($race_count[$key])) {
                                        $race_count[$key] = $race_count[$key] + $value;
                                    } else {
                                        $race_count[$key] = $value;
                                    }
                                }
                            } else {


                                $race_count = $race;
                            }
                        }
                    }

                    $data = [
                        'program_id' => $program_id,
                        'grade' => $grade,
                        'total_seats' => $availability->total_seats ?? 0,
                        'available_seats' => $availability->available_seats ?? 0,
                        'race_count' => $race_count,
                    ];
                    $data_ary[] = $data;
                    // sorting race in ascending
                    ksort($race_ary);
                }
            }
            // exit;
        }

        //exit;
        // Submissions Result
        return view("ProcessSelection::population_change", compact('data_ary', 'race_ary', 'pid', 'from', "display_outcome", "application_id", "enrollment_racial", "last_date_online_acceptance", "last_date_offline_acceptance", "prgGroupArr", "swingData"));
    }


    public function submissions_results_application($application_id = 1)
    {
        $pid = $application_id;
        $from = "form";
        $programs = [];
        $district_id = \Session('district_id');
        $submissions = Submissions::where('district_id', $district_id)
            ->where('submissions.enrollment_id', SESSION::get('enrollment_id'))
            ->where("submissions.form_id", $application_id)->join("submissions_final_status", "submissions_final_status.submission_id", "submissions.id")
            ->get(['submissions.id', 'first_name', 'last_name', 'current_school', 'first_offered_rank', 'second_offered_rank', 'first_choice_program_id', 'second_choice_program_id', 'next_grade', 'race', 'calculated_race', 'first_choice_final_status', 'second_choice_final_status']);

        $final_data = array();
        foreach ($submissions as $key => $value) {
            $tmp = array();
            $tmp['id'] = $value->id;
            $tmp['name'] = $value->first_name . " " . $value->last_name;
            $tmp['grade'] = $value->next_grade;
            $tmp['school'] = $value->current_school;
            $tmp['choice'] = 1;
            $tmp['race'] = $value->calculated_race;
            $tmp['program'] = getProgramName($value->first_choice_program_id) . " - Grade " . $value->next_grade;
            $tmp['program_name'] = getProgramName($value->first_choice_program_id);
            $tmp['offered_status'] = $value->first_choice_final_status;
            if ($value->first_choice_final_status == "Offered")
                $tmp['outcome'] = "<div class='alert1 alert-success text-center'>Offered</div>";
            elseif ($value->first_choice_final_status == "Denied due to Ineligibility")
                $tmp['outcome'] = "<div class='alert1 alert-info text-center'>Denied due to Ineligibility</div>";
            elseif ($value->first_choice_final_status == "Waitlisted")
                $tmp['outcome'] = "<div class='alert1 alert-warning text-center'>Waitlist</div>";
            elseif ($value->first_choice_final_status == "Denied due to Incomplete Records")
                $tmp['outcome'] = "<div class='alert1 alert-danger text-center'>Denied due to Incomplete Records</div>";
            else
                $tmp['outcome'] = "";

            $final_data[] = $tmp;

            if ($value->second_choice_program_id != 0) {
                $tmp = array();
                $tmp['id'] = $value->id;
                $tmp['name'] = $value->first_name . " " . $value->last_name;
                $tmp['grade'] = $value->next_grade;
                $tmp['school'] = $value->current_school;
                $tmp['race'] = $value->calculated_race;
                $tmp['choice'] = 2;
                $tmp['program'] = getProgramName($value->second_choice_program_id) . " - Grade " . $value->next_grade;
                $tmp['program_name'] = getProgramName($value->second_choice_program_id);
                $tmp['offered_status'] = $value->second_choice_final_status;

                if ($value->second_choice_final_status == "Offered")
                    $tmp['outcome'] = "<div class='alert1 alert-success text-center'>Offered</div>";
                elseif ($value->second_choice_final_status == "Denied due to Ineligibility")
                    $tmp['outcome'] = "<div class='alert1 alert-info text-center'>Denied due to Ineligibility</div>";
                elseif ($value->second_choice_final_status == "Waitlisted")
                    $tmp['outcome'] = "<div class='alert1 alert-warning text-center'>Waitlist</div>";
                elseif ($value->second_choice_final_status == "Denied due to Incomplete Records")
                    $tmp['outcome'] = "<div class='alert1 alert-danger text-center'>Denied due to Incomplete Records</div>";
                else
                    $tmp['outcome'] = "";
                if ($tmp['outcome'] != "")
                    $final_data[] = $tmp;
            }
        }
        $grade = $outcome = array();
        foreach ($final_data as $key => $value) {
            $grade['grade'][] = $value['grade'];
            $outcome['outcome'][] = $value['outcome'];
        }
        array_multisort($grade['grade'], SORT_ASC, $outcome['outcome'], SORT_DESC, $final_data);

        $additional_data = $this->get_additional_info($application_id);
        $displayother = $additional_data['displayother'];
        $display_outcome = $additional_data['display_outcome'];
        $enrollment_racial = $additional_data['enrollment_racial'];
        $swingData = $additional_data['swingData'];
        $prgGroupArr = $additional_data['prgGroupArr'];
        $last_date_online_acceptance = $additional_data['last_date_online_acceptance'];
        $last_date_offline_acceptance = $additional_data['last_date_offline_acceptance'];

        return view("ProcessSelection::submissions_result", compact('final_data', 'pid', 'from', 'display_outcome', "application_id", "displayother", "last_date_online_acceptance", "last_date_offline_acceptance", "prgGroupArr", "swingData", "enrollment_racial"));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function manual_pending_complete($application_id = 1)
    {
        $data = Submissions::where("form_id", $application_id)->where("submissions.enrollment_id", 21)->where("submission_status", 'Pending')->get();
        $version = 0;
        //dd($data);
        foreach ($data as $key => $value) {

            $insert = [];
            $insert['submission_id'] = $value->id;
            $insert['enrollment_id'] = $value->enrollment_id;
            $insert['application_id'] = $value->application_id;
            $insert['first_choice_final_status'] = ($value->first_choice != '' ? "Denied due to Incomplete Records" : "Pending");
            $insert['second_choice_final_status'] = ($value->second_choice != '' ? "Denied due to Incomplete Records" : "Pending");
            $insert['first_waitlist_number'] = 0;
            $insert['second_waitlist_number'] = 0;
            $insert['incomplete_reason'] = "";
            $insert['first_choice_eligibility_reason'] = "";
            $insert['second_choice_eligibility_reason'] = "";
            $insert['first_offered_rank'] = 0;
            $insert['second_offered_rank'] = 0;
            //            $insert['first_waitlist_for'] = $value->first_waitlist_for;
            //            $insert['second_waitlist_for'] = $value->second_waitlist_for;
            //            $insert['offer_slug'] = $value->offer_slug;
            //            $insert['first_offer_update_at'] = $value->first_offer_update_at;
            //            $insert['second_offer_update_at'] = $value->second_offer_update_at;
            // $insert['contract_status'] = $value->contract_status;
            // $insert['contract_signed_on'] = $value->contract_signed_on;
            // $insert['contract_name'] = $value->contract_name;
            // $insert['offer_status_by'] = $value->offer_status_by;
            // $insert['contract_status_by'] = $value->contract_status_by;
            // $insert['contract_mode'] = $value->contract_mode;
            //   $insert['first_offer_status'] = ($value->first_choice != '' ? "Denied due to Incomplete Records" : "Pending");
            //  $insert['second_offer_status'] = ($value->second_choice != '' ? "Denied due to Incomplete Records" : "Pending");
            // $insert['manually_updated'] = $value->manually_updated;
            // $insert['communication_sent'] = $value->communication_sent;
            // $insert['communication_text'] = $value->communication_text;
            $insert['version'] = $version;
            $rs = SubmissionsLatestFinalStatus::create($insert);

            $status = "Denied due to Incomplete Records";
            $rs = Submissions::where("id", $value->id)->select("submission_status")->first();
            $old_status = $value->submission_status;

            $comment = "By Accept and Commit Event";
            $rs = SubmissionsStatusLog::create(array("submission_id" => $value->id, "enrollment_id" => Session::get("enrollment_id"), "new_status" => $status, "old_status" => $old_status, "updated_by" => Auth::user()->id, "comment" => ""));
            $rs = SubmissionsStatusUniqueLog::updateOrCreate(["submission_id" => $value->id], array("submission_id" => $value->id, "new_status" => $status, "old_status" => $old_status, "updated_by" => Auth::user()->id));
            $rs = Submissions::where("id", $value->id)->update(["submission_status" => $status]);
        }
        echo "Done";
    }

    public function selection_accept(Request $request)
    {
        $application_id = $request->application_id;
        $data = SubmissionsFinalStatus::where("submissions_final_status.application_id", $application_id)->where("submissions.enrollment_id", Session::get("enrollment_id"))->join("submissions", "submissions.id", "submissions_final_status.submission_id")->whereIn("submissions.submission_status", array('Active'))->get();


        foreach ($data as $key => $value) {

            $insert = [];
            $insert['submission_id'] = $value->submission_id;
            $insert['enrollment_id'] = $value->enrollment_id;
            $insert['application_id'] = $value->application_id;
            $insert['first_choice_final_status'] = $value->first_choice_final_status;
            $insert['second_choice_final_status'] = $value->second_choice_final_status;
            $insert['first_waitlist_number'] = $value->first_waitlist_number;
            $insert['second_waitlist_number'] = $value->second_waitlist_number;
            $insert['incomplete_reason'] = $value->incomplete_reason;
            $insert['first_choice_eligibility_reason'] = $value->first_choice_eligibility_reason;
            $insert['second_choice_eligibility_reason'] = $value->second_choice_eligibility_reason;
            $insert['first_offered_rank'] = $value->first_offered_rank;
            $insert['second_offered_rank'] = $value->second_offered_rank;
            $insert['first_waitlist_for'] = $value->first_waitlist_for;
            $insert['second_waitlist_for'] = $value->second_waitlist_for;
            $insert['offer_slug'] = $value->offer_slug;
            $insert['first_offer_update_at'] = $value->first_offer_update_at;
            $insert['second_offer_update_at'] = $value->second_offer_update_at;
            $insert['contract_status'] = $value->contract_status;
            $insert['contract_signed_on'] = $value->contract_signed_on;
            $insert['contract_name'] = $value->contract_name;
            $insert['offer_status_by'] = $value->offer_status_by;
            $insert['contract_status_by'] = $value->contract_status_by;
            $insert['contract_mode'] = $value->contract_mode;
            $insert['first_offer_status'] = $value->first_offer_status;
            $insert['second_offer_status'] = $value->second_offer_status;
            $insert['manually_updated'] = $value->manually_updated;
            $insert['communication_sent'] = $value->communication_sent;
            $insert['communication_text'] = $value->communication_text;
            $insert['version'] = $value['version'];
            $rs = SubmissionsLatestFinalStatus::create($insert);

            $status = $value->first_choice_final_status;
            if ($value->second_choice_final_status == "Offered")
                $status = "Offered";
            elseif ($status != "Offered" && $value->second_choice_final_status == "Waitlisted")
                $status = "Waitlisted";
            $submission_id = $value->submission_id;
            $rs = Submissions::where("id", $submission_id)->select("submission_status")->first();
            $old_status = $rs->submission_status;

            $comment = "By Accept and Commit Event";
            if ($status == "Offered") {
                $submission = Submissions::where("id", $value->submission_id)->first();
                if ($value->first_choice_final_status == "Offered") {
                    $program_name = getProgramName($submission->first_choice_program_id);
                } else if ($value->second_choice_final_status == "Offered") {
                    $program_name = getProgramName($submission->second_choice_program_id);
                } else {
                    $program_name = "";
                }

                $program_name .= " - Grade " . $submission->next_grade;
                $comment = "System has Offered " . $program_name . " to Parent";
            } else if ($status == "Denied due to Ineligibility") {
                if ($value->first_choice_eligibility_reason != '') {
                    if ($value->first_choice_eligibility_reason == "Both") {
                        $comment = "System has denied the application because of Grades and CDI Ineligibility";
                    } else if ($value->first_choice_eligibility_reason == "Grade") {
                        $comment = "System has denied the application because of Grades Ineligibility";
                    } else {
                        $comment = $value->first_choice_eligibility_reason;
                    }
                }
            } else if ($status == "Denied due to Incomplete Records") {
                if ($value->incomplete_reason != '') {
                    if ($value->incomplete_reason == "Both") {
                        $comment = "System has denied the application because of Grades and CDI Ineligibility";
                    } else if ($value->incomplete_reason == "Grade") {
                        $comment = "System has denied the application because of Incomplete Grades";
                    } else {
                        $comment = "System has denied the application because of Incomplete Records";
                    }
                }
            }
            $rs = SubmissionsStatusLog::create(array("submission_id" => $submission_id, "enrollment_id" => Session::get("enrollment_id"), "new_status" => $status, "old_status" => $old_status, "updated_by" => Auth::user()->id, "comment" => $comment));
            $rs = SubmissionsStatusUniqueLog::updateOrCreate(["submission_id" => $submission_id], array("submission_id" => $submission_id, "new_status" => $status, "old_status" => $old_status, "updated_by" => Auth::user()->id));
            $rs = Submissions::where("id", $submission_id)->update(["submission_status" => $status]);
        }

        /* all Pending to Incompelete */
        $data = Submissions::where("form_id", $application_id)->where("submissions.enrollment_id", Session::get("enrollment_id"))->where("submission_status", 'Pending')->get();
        foreach ($data as $key => $value) {

            $insert = [];
            $insert['submission_id'] = $value->id;
            $insert['enrollment_id'] = $value->enrollment_id;
            $insert['application_id'] = $value->application_id;
            $insert['first_choice_final_status'] = ($value->first_choice != '' ? "Denied due to Incomplete Records" : "Pending");
            $insert['second_choice_final_status'] = ($value->second_choice != '' ? "Denied due to Incomplete Records" : "Pending");
            $insert['first_waitlist_number'] = 0;
            $insert['second_waitlist_number'] = 0;
            $insert['incomplete_reason'] = "";
            $insert['first_choice_eligibility_reason'] = "";
            $insert['second_choice_eligibility_reason'] = "";
            $insert['first_offered_rank'] = 0;
            $insert['second_offered_rank'] = 0;
            //            $insert['first_waitlist_for'] = $value->first_waitlist_for;
            //            $insert['second_waitlist_for'] = $value->second_waitlist_for;
            //            $insert['offer_slug'] = $value->offer_slug;
            //            $insert['first_offer_update_at'] = $value->first_offer_update_at;
            //            $insert['second_offer_update_at'] = $value->second_offer_update_at;
            // $insert['contract_status'] = $value->contract_status;
            // $insert['contract_signed_on'] = $value->contract_signed_on;
            // $insert['contract_name'] = $value->contract_name;
            // $insert['offer_status_by'] = $value->offer_status_by;
            // $insert['contract_status_by'] = $value->contract_status_by;
            // $insert['contract_mode'] = $value->contract_mode;
            //   $insert['first_offer_status'] = ($value->first_choice != '' ? "Denied due to Incomplete Records" : "Pending");
            //  $insert['second_offer_status'] = ($value->second_choice != '' ? "Denied due to Incomplete Records" : "Pending");
            // $insert['manually_updated'] = $value->manually_updated;
            // $insert['communication_sent'] = $value->communication_sent;
            // $insert['communication_text'] = $value->communication_text;
            $insert['version'] = $version;
            $rs = SubmissionsLatestFinalStatus::create($insert);

            $status = "Denied due to Incomplete Records";
            $rs = Submissions::where("id", $value->id)->select("submission_status")->first();
            $old_status = $value->submission_status;

            $comment = "By Accept and Commit Event";
            $rs = SubmissionsStatusLog::create(array("submission_id" => $value->id, "enrollment_id" => Session::get("enrollment_id"), "new_status" => $status, "old_status" => $old_status, "updated_by" => Auth::user()->id, "comment" => ""));
            $rs = SubmissionsStatusUniqueLog::updateOrCreate(["submission_id" => $value->id], array("submission_id" => $submission_id, "new_status" => $status, "old_status" => $old_status, "updated_by" => Auth::user()->id));
            $rs = Submissions::where("id", $value->id)->update(["submission_status" => $status]);
        }

        $rs = ProcessSelection::where("enrollment_id", Session::get("enrollment_id"))->where("application_id", $application_id)->update(array("commited" => "Yes"));
        echo "Done";
        exit;
    }

    public function selection_revert(Request $request)
    {
        $req = $request->all();
        $quotations = SubmissionsStatusLog::join("submissions", "submissions.id", "submissions_status_log.submission_id")->where("submissions.enrollment_id", Session::get("enrollment_id"))->where("submissions.application_id", $req['application_id'])->orderBy('submissions_status_log.created_at', 'ASC')
            ->get()
            ->unique('submission_id');
        $sub_id = [];
        foreach ($quotations as $key => $value) {
            $sub_id[] = $value->submission_id;
            $rs = Submissions::where("id", $value->submission_id)->update(array("submission_status" => $value->old_status));
        }
        SubmissionsStatusUniqueLog::whereIn("submission_id", $sub_id)->delete();
        SubmissionsFinalStatus::whereIn("submission_id", $sub_id)->delete();
        SubmissionsRaceCompositionReport::where("application_id", $req['application_id'])->delete();
        SubmissionsSelectionReportMaster::where("application_id", $req['application_id'])->delete();

        $rs = ProcessSelection::where("application_id", $req['application_id'])->delete(); //update(["commited"=>"No"]);

        //SubmissionsStatusUniquesLog::truncate();

    }

    public function check_race_previous_data($group_name, $race)
    {
        $data = $this->group_racial_composition[$group_name];

        $zero = 0;

        foreach ($data as $key => $value) {
            if ($key != 'total' && $key != "no_previous" && $key != $race) {
                if ($value == 0) {
                    $zero++;
                }
            }
        }
        if ($zero > 0) {
            return "OnlyThisOffered";
        } else {
            if ($data[$race] == 0) {
                return "OnlyThisOffered";
            } else {
                $is_lower = $is_self_lower = false;
                foreach ($data as $key => $value) {
                    if ($key != 'total' && $key != "no_previous") {
                        if ($key != $race)
                            $tmp = $value;
                        else
                            $tmp = $value + 1;
                        $total = $data['total'] + 1;
                        $new_percent = number_format($tmp * 100 / $total, 2);
                        if ($new_percent < $this->enrollment_race_data[$group_name][$key]['min'] || $new_percent > $this->enrollment_race_data[$group_name][$key]['max'])
                            $is_lower = true;
                    }
                }
                //                exit;
                if ($is_lower)
                    return "SkipOffered";
                elseif ($is_self_lower)
                    return "OnlyThisOffered";
                else {
                    //$this->group_racial_composition[$group_name]['no_previous'] = 'N'; 
                    return "OfferedWaitlisted";
                }
            }
        }
    }


    public function check_all_race_range($group_name, $race, $id)
    {

        $tmp_enroll = $this->enrollment_race_data[$group_name];
        $tmp = $this->group_racial_composition[$group_name];
        $total_seats = $tmp['total'];
        $race_percent = $tmp[$race];
        if ($total_seats > 0)
            $original_race_percent = number_format($race_percent * 100 / $total_seats, 2);
        else
            $original_race_percent = 0;
        $total_seats++;
        $race_percent++;
        $new_percent = number_format($race_percent * 100 / $total_seats, 2);

        if ($new_percent >= $tmp_enroll[$race]['min'] && $new_percent <= $tmp_enroll[$race]['max']) {
            $in_range = true;
            $max = 0;
            foreach ($tmp as $key => $value) {
                if ($key != $race && $key != "total" && $key != "no_previous") {
                    $total = $tmp['total'] + 1;
                    $new_percent = number_format($value * 100 / $total, 2);
                    if ($new_percent < $tmp_enroll[$key]['min'])
                        $in_range = false;
                    elseif ($new_percent > $tmp_enroll[$key]['max']) {
                        $in_range = false;
                        $max++;
                    }
                }
            }
            if (!$in_range) {
                if ($max > 0)
                    return true;
                else
                    return false;
            } else
                return true;
        } else {
            if ($original_race_percent < $tmp_enroll[$race]['min'])
                return true;
            else
                return false;
        }
    }

    /* Function to find out updated Racial Commposition */
    public function updated_racial_composition($application_id, $from = "")
    {
        /* Create Application Filter Group Array for Program */
        $af = ['applicant_filter1', 'applicant_filter2', 'applicant_filter3'];
        $programs = Program::where('status', '!=', 'T')->where('district_id', Session::get('district_id'))->where("enrollment_id", Session::get('enrollment_id'))->join("application_programs", "application_programs.program_id", "program.id")->where("program.parent_submission_form", $application_id)->get();

        // Application Filters
        $af_programs = [];
        if (!empty($programs)) {
            foreach ($programs as $key => $program) {
                $cnt = 0;
                foreach ($af as $key => $af_field) {
                    if ($program->$af_field == '')
                        $cnt++;
                    if (($program->$af_field != '') && !in_array($program->$af_field, $af_programs)) {
                        array_push($af_programs, $program->$af_field);
                    }
                }
                if ($cnt == count($af)) {
                    array_push($af_programs, $program->name);
                }
            }
        }

        $tmp = $this->groupByRacism($af_programs);


        $this->group_racial_composition = $group_race_array = $tmp['group_race'];
        $this->program_group = $program_group_array = $tmp['program_group'];



        $group_racial_composition = [];
        foreach ($this->program_group as $key => $value) {
            $program_id = $key;
            $group_racial_composition[$value] = $this->calculate_offered_from_all($key, $value);
            //print_r($$group_racial_composition[$value]);exit;
        }


        /* Get Withdraw Student Count */
        $tmp = $this->program_group;
        $tmp_group = $this->group_racial_composition;


        foreach ($tmp as $k => $v) {
            if ($from == "desktop" && !is_int($from)) {
                $black = WaitlistProcessLogs::where("program_id", $k)->join("process_selection", "process_selection.id", "waitlist_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("black_withdrawn");
                $white = WaitlistProcessLogs::where("program_id", $k)->join("process_selection", "process_selection.id", "waitlist_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("white_withdrawn");
                $other = WaitlistProcessLogs::where("program_id", $k)->join("process_selection", "process_selection.id", "waitlist_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("other_withdrawn");

                $black1 = LateSubmissionProcessLogs::where("program_id", $k)->join("process_selection", "process_selection.id", "late_submission_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("black_withdrawn");
                $white1 = LateSubmissionProcessLogs::where("program_id", $k)->join("process_selection", "process_selection.id", "late_submission_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("white_withdrawn");
                $other1 = LateSubmissionProcessLogs::where("program_id", $k)->join("process_selection", "process_selection.id", "late_submission_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("other_withdrawn");
            } else {
                $black = WaitlistProcessLogs::where("program_id", $k)->sum("black_withdrawn");
                $white = WaitlistProcessLogs::where("program_id", $k)->sum("white_withdrawn");
                $other = WaitlistProcessLogs::where("program_id", $k)->sum("other_withdrawn");

                $black1 = LateSubmissionProcessLogs::where("program_id", $k)->sum("black_withdrawn");
                $white1 = LateSubmissionProcessLogs::where("program_id", $k)->sum("white_withdrawn");
                $other1 = LateSubmissionProcessLogs::where("program_id", $k)->sum("other_withdrawn");
            }


            $tmp_data = $tmp_group[$v];
            $black_data = $tmp_data['black'] - $black - $black1;
            $white_data = $tmp_data['white'] - $white - $white1;
            $other_data = $tmp_data['other'] - $other - $other1;

            if ($black_data < 0)
                $black_data = 0;
            if ($white_data < 0)
                $white_data = 0;
            if ($other_data < 0)
                $other_data = 0;

            $tmp_data['black'] = $black_data;
            $tmp_data['white'] = $white_data;
            $tmp_data['other'] = $other_data;
            $tmp_data['total'] = $black_data + $white_data + $other_data;


            $tmp_group[$v] = $tmp_data;
        }
        $this->group_racial_composition = $tmp_group;
        return $this->group_racial_composition;
    }

    public function calculate_offered_from_all($program_id, $group_name)
    {

        $group_data = $this->group_racial_composition[$group_name];

        /* From regular submissions Results */
        $submission = SubmissionsFinalStatus::where("submissions.enrollment_id", Session::get("enrollment_id"))->where(function ($q) use ($program_id) {
            $q->where("first_offer_status", "Accepted")->where("first_waitlist_for", $program_id);
        })->orWhere(function ($q) use ($program_id) {
            $q->where("second_offer_status", "Accepted")->where("second_waitlist_for", $program_id);
        })->join("submissions", "submissions.id", "submissions_final_status.submission_id")->groupBy('submissions.calculated_race')->select("calculated_race", DB::raw("count(calculated_race) as CNT"))->get();

        $total = $group_data['total'];


        foreach ($submission as $sk => $sv) {
            $group_data[strtolower($sv->calculated_race)]  = $group_data[strtolower($sv->calculated_race)] + $sv->CNT;
            $total += $sv->CNT;
        }


        /* From regular submissions Results LateSubmissionFinalStatus,SubmissionsWaitlistFinalStatus*/
        $submission = LateSubmissionFinalStatus::where("submissions.enrollment_id", Session::get("enrollment_id"))->where(function ($q) use ($program_id) {
            $q->where("first_offer_status", "Accepted")->where("first_waitlist_for", $program_id);
        })->orWhere(function ($q) use ($program_id) {
            $q->where("second_offer_status", "Accepted")->where("second_waitlist_for", $program_id);
        })->join("submissions", "submissions.id", "late_submissions_final_status.submission_id")->groupBy('submissions.calculated_race')->select("calculated_race", DB::raw("count(calculated_race) as CNT"))->get();

        foreach ($submission as $sk => $sv) {
            $group_data[strtolower($sv->calculated_race)]  = $group_data[strtolower($sv->calculated_race)] + $sv->CNT;
            $total += $sv->CNT;
        }

        /* From regular submissions Results LateSubmissionFinalStatus,SubmissionsWaitlistFinalStatus*/
        $submission = SubmissionsWaitlistFinalStatus::where("submissions.enrollment_id", Session::get("enrollment_id"))->where(function ($q) use ($program_id) {
            $q->where("first_offer_status", "Accepted")->where("first_waitlist_for", $program_id);
        })->orWhere(function ($q) use ($program_id) {
            $q->where("second_offer_status", "Accepted")->where("second_waitlist_for", $program_id);
        })->join("submissions", "submissions.id", "submissions_waitlist_final_status.submission_id")->groupBy('submissions.calculated_race')->select("calculated_race", DB::raw("count(calculated_race) as CNT"))->get();
        foreach ($submission as $sk => $sv) {
            $group_data[strtolower($sv->calculated_race)]  = $group_data[strtolower($sv->calculated_race)] + $sv->CNT;
            $total += $sv->CNT;
        }



        $group_data['total'] = $total;
        $this->group_racial_composition[$group_name] = $group_data;
        return $group_data;
    }

    public function get_waitlist_count($application_id, $program_id, $grade)
    {
        //$grade_id = Grade::where("name", $grade)->first();
        $rs = ProgramGradeMapping::where("enrollment_id", Session::get("enrollment_id"))->where("program_id", $program_id)->where("grade", $grade)->first();
        if (!empty($rs)) {
            $application_program_id = $rs->id;

            $rs = ProcessSelection::where("enrollment_id", Session::get("enrollment_id"))->where("form_id", $application_id)->where("commited", "Yes")->whereRaw("FIND_IN_SET(" . $application_program_id . ", selected_programs)")->orderBy("created_at", "desc")->first();

            $table_name = "submissions_final_status";

            $version = 0;
            if (!empty($rs)) {
                if ($rs->type == "regular") {
                    $table_name = "submissions_final_status";
                    $version = 0;
                } elseif ($rs->type == "waitlist") {
                    $table_name = "submissions_waitlist_final_status";
                    $version = $rs->version;
                } elseif ($rs->type == "late_submission") {
                    $table_name = "late_submissions_final_status";
                    $version = $rs->version;
                }
            }
            $table_name = "submissions_latest_final_status";

            $waitlist_count1 = Submissions::where("submissions.enrollment_id", Session::get("enrollment_id"))->where('district_id', Session::get("district_id"))->where('submissions.form_id', $application_id)->where('first_choice_final_status', 'Waitlisted')->whereIn('first_offer_status', array('Pending', 'Waitlisted'))->where('next_grade', $grade)->join($table_name, $table_name . ".submission_id", "submissions.id")->where("first_choice_program_id", $program_id)->whereIn("submissions.submission_status", array("Waitlisted", "Declined / Waitlist for other"))->count();


            $waitlist_count2 = Submissions::where("submissions.enrollment_id", Session::get("enrollment_id"))->where('district_id', Session::get("district_id"))->where('submissions.form_id', $application_id)->where('second_choice_final_status', 'Waitlisted')->whereIn('second_offer_status', array('Pending', 'Waitlisted'))->where('next_grade', $grade)->join($table_name, $table_name . ".submission_id", "submissions.id")->where("second_choice_program_id", $program_id)->whereIn("submissions.submission_status", array("Waitlisted", "Declined / Waitlist for other"))->count();

            $waitlist_count5 = 0;


            $waitlist_count3 = Submissions::where("submissions.enrollment_id", Session::get("enrollment_id"))->where('district_id', Session::get("district_id"))->where('submissions.form_id', $application_id)->where('first_choice_final_status', 'Waitlisted')->where('second_choice_final_status', '<>', 'Waitlisted')->where('second_offer_status', 'Declined & Waitlisted')->where('next_grade', $grade)->join($table_name, $table_name . ".submission_id", "submissions.id")->where("second_choice_program_id", $program_id)->whereIn("submissions.submission_status", array("Waitlisted", "Declined / Waitlist for other"))->count();

            //$waitlist_count3 = Submissions::whereIn("submission_status", array("Waitlisted", "Declined / Waitlist for other"))->where("first_choice_program_id", $program_id)->where('next_grade', $grade)->count();
            //$waitlist_count2 = Submissions::whereIn("submission_status", array("Waitlisted", "Declined / Waitlist for other"))->where("second_choice_program_id", $program_id)->where('next_grade', $grade)->count();



            $waitlist_count4 = 0;

            if ($program_id == 27 && $grade == 6) {
            }


            return $waitlist_count1 + $waitlist_count2 + $waitlist_count3 + $waitlist_count4 +  $waitlist_count5;
        } else
            return 0;
    }

    public function get_available_count($application_id, $program_id, $grade)
    {
        $total_offered = $this->get_offered_count_programwise($program_id, $grade);
        $rs = Availability::where("program_id", $program_id)->where("grade", $grade)->first();
        if (!empty($rs))
            return array("total_seats" => $rs->total_seats, "available_seats" => $rs->available_seats, "offered_seats" => $total_offered);
        else
            return array("total_seats" => 0, "available_seats" => 0, "offered_seats" => $total_offered);
    }

    public function get_offered_count_programwise($program_id, $grade)
    {
        /* From regular submissions Results */
        $count1 = SubmissionsFinalStatus::where("submissions.enrollment_id", Session::get("enrollment_id"))->where("next_grade", $grade)->where(function ($q1) use ($program_id) {
            $q1->where(function ($q) use ($program_id) {
                $q->where("first_offer_status", "Accepted")->where("first_waitlist_for", $program_id);
            })->orWhere(function ($q) use ($program_id) {
                $q->where("second_offer_status", "Accepted")->where("second_waitlist_for", $program_id);
            });
        })->join("submissions", "submissions.id", "submissions_final_status.submission_id")->count();


        /* From regular submissions Results LateSubmissionFinalStatus,SubmissionsWaitlistFinalStatus*/
        $count2 = LateSubmissionFinalStatus::where("submissions.enrollment_id", Session::get("enrollment_id"))->where("next_grade", $grade)->where(function ($q1) use ($program_id) {
            $q1->where(function ($q) use ($program_id) {
                $q->where("first_offer_status", "Accepted")->where("first_waitlist_for", $program_id);
            })->orWhere(function ($q) use ($program_id) {
                $q->where("second_offer_status", "Accepted")->where("second_waitlist_for", $program_id);
            });
        })->join("submissions", "submissions.id", "late_submissions_final_status.submission_id")->count();

        /* From regular submissions Results LateSubmissionFinalStatus,SubmissionsWaitlistFinalStatus*/
        $count3 = SubmissionsWaitlistFinalStatus::where("submissions.enrollment_id", Session::get("enrollment_id"))->where("next_grade", $grade)->where(function ($q1) use ($program_id) {
            $q1->where(function ($q) use ($program_id) {
                $q->where("first_offer_status", "Accepted")->where("first_waitlist_for", $program_id);
            })->orWhere(function ($q) use ($program_id) {
                $q->where("second_offer_status", "Accepted")->where("second_waitlist_for", $program_id);
            });
        })->join("submissions", "submissions.id", "submissions_waitlist_final_status.submission_id")->count();


        return $count1 + $count2 + $count3;
    }


    public function exportProgramGradeSeat()
    {
        $programs = Program::where("district_id", Session::get("district_id"))->where("enrollment_id", Session::get("enrollment_id"))->where('status', 'Y')->get();
        $tmpdata = [];
        foreach ($programs as $key => $value) {

            $grade_level = explode(",", $value->grade_lavel);

            foreach ($grade_level as $val) {
                $innerData = [];
                $innerData['name'] = $value->name;
                $innerData['grade'] = $val;

                $data = $this->get_available_count(0, $value->id, $val);
                $innerData['available_seats'] = $data['available_seats'];
                $innerData['offered'] = $data['offered_seats'];

                $black = WaitlistProcessLogs::where("program_id", $value->id)->where("grade", $val)->join("process_selection", "process_selection.id", "waitlist_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("black_withdrawn");
                $white = WaitlistProcessLogs::where("program_id", $value->id)->where("grade", $val)->join("process_selection", "process_selection.id", "waitlist_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("white_withdrawn");
                $other = WaitlistProcessLogs::where("program_id", $value->id)->where("grade", $val)->join("process_selection", "process_selection.id", "waitlist_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("other_withdrawn");

                $black1 = LateSubmissionProcessLogs::where("program_id", $value->id)->where("grade", $val)->join("process_selection", "process_selection.id", "late_submission_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("black_withdrawn");
                $white1 = LateSubmissionProcessLogs::where("program_id", $value->id)->where("grade", $val)->join("process_selection", "process_selection.id", "late_submission_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("white_withdrawn");
                $other1 = LateSubmissionProcessLogs::where("program_id", $value->id)->where("grade", $val)->join("process_selection", "process_selection.id", "late_submission_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("other_withdrawn");

                $innerData['black_withdrawn']  = $black + $black1;
                $innerData['white_withdrawn'] = $white1 + $white;
                $innerData['other_withdrawn'] = $other + $other1;
                $data = Form::where("status", "y")->get();
                $waitCount = 0;
                foreach ($data as $dk => $dy) {
                    $waitCount += $this->get_waitlist_count($dy->id, $value->id, $val);
                }

                $add1 = WaitlistProcessLogs::where("program_id", $value->id)->where("grade", $val)->join("process_selection", "process_selection.id", "waitlist_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("additional_seats");

                $add2 = LateSubmissionProcessLogs::where("program_id", $value->id)->where("grade", $val)->join("process_selection", "process_selection.id", "late_submission_process_logs.process_log_id")->where("process_selection.commited", "Yes")->sum("additional_seats");
                $innerData['additional_seats'] = $add1 + $add2;

                $innerData['waitlist_count'] = $waitCount;
                $innerData['total_available'] = $innerData['available_seats'] + $innerData['black_withdrawn'] + $innerData['white_withdrawn'] + $innerData['other_withdrawn'] - $innerData['offered'] + $innerData['additional_seats'];
                $tmpData[] = $innerData;

                if ($value->id == 134 && $val == 9) {
                    dd($innerData);
                }
            }
        }

        ob_end_clean();
        ob_start();
        return Excel::download(new ProgramAvailabilityExport(collect($tmpData)), 'ProgramAvailabilityExport.xlsx');
    }

    public function exportWaitlisted()
    {
        $waitlistData = Submissions::where("enrollment_id", Session::get('enrollment_id'))->whereIn("submission_status", ['Waitlisted', 'Declined / Waitlist for other'])->get();
        $final_data = [];
        foreach ($waitlistData as $key => $value) {
            $tmp = [];
            $tmp['id'] = $value->id;
            $tmp['name'] = $value->first_name . " " . $value->last_name;
            $tmp['race'] = $value->calculated_race;
            $tmp['first_program'] = getProgramName($value->first_choice_program_id);
            $tmp['first_commitee'] = getSubmissionCommitteeScore($value->id, $value->first_choice_program_id);
            $tmp['first_priority'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "first");

            if ($value->second_choice_program_id > 0) {
                $tmp['second_program'] = getProgramName($value->first_choice_program_id);
                $tmp['second_commitee'] = getSubmissionCommitteeScore($value->id, $value->second_choice_program_id);
                $tmp['second_priority'] = app('App\Modules\Reports\Controllers\ReportsController')->priorityCalculate($value, "second");
            } else {
                $tmp['second_program'] = "";
                $tmp['second_commitee'] = "";
                $tmp['second_priority'] = "";
            }

            $tmp['lottery_number'] = $value->lottery_number;

            $final_data[] = $tmp;
        }

        ob_end_clean();
        ob_start();
        return Excel::download(new WaitlistExport(collect($final_data)), 'WaitlistExport.xlsx');
    }
}
