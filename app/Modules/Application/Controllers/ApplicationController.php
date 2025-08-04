<?php

namespace App\Modules\Application\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Form\Models\Form;
use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\Program\Models\Program;
use App\Modules\School\Models\Grade;
use App\Modules\Application\Models\Application;
use App\Modules\Application\Models\ApplicationProgram;
use App\Modules\Application\Models\ApplicationConfiguration;
use App\Modules\District\Models\District;
use Session;
use App\Traits\AuditTrail;
use App\Modules\Submissions\Models\{Submissions,SubmissionsStatusUniqueLog};
use App\Languages;

class ApplicationController extends Controller
{
    use AuditTrail;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $applications=Application::
        join('form','form.id','=','application.form_id')
        ->join('enrollments','enrollments.id','=','application.enrollment_id')
        ->where('application.status','!=','T')
        ->where('application.district_id',Session::get('district_id'))
        ->where('application.enrollment_id',Session::get('enrollment_id'))
        ->select('form.name as form_name','enrollments.school_year','application.*')
        ->get();
        // return $applications;
        return view("Application::index",compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = Languages::get();
        $district = District::where("id", Session::get("district_id"))->first();
        $application_url = url('/');//"http://".$district->district_slug.".".str_replace("www.", "", request()->getHttpHost());
        $forms=Form::where('district_id',Session::get('district_id'))->where('status','y')->orderBy('name','asc')->get();
        $enrollments=Enrollment::where('district_id',Session::get('district_id'))->where('id',Session::get('enrollment_id'))->where('status','Y')->orderBy('school_year','asc')->get();
        $programs=Program::where('district_id',Session::get('district_id'))->where('enrollment_id',Session::get('enrollment_id'))->where('status','y')->get();
        $temp_programs=[];
        foreach ($programs as $key => $program) 
        {
            $grade_lavels=explode(',', $program->grade_lavel);
            $temp_grade=[];
            foreach ($grade_lavels as $k => $grade_lavel) 
            {
                $temp_grade[]=Grade::where('name',$grade_lavel)->first();
            }
            $temp_programs[]=array_merge($program->toArray(),['grade_info'=>$temp_grade]);
        }
        return view('Application::create',compact('forms','enrollments','temp_programs','application_url','district','languages'));
    }

    /*public function create()
    {
        $languages = Languages::get();
        //dd($languages);
   
        $district = District::where("id", Session::get("district_id"))->first();
        $application_url = url('/');//"http://".$district->district_slug.".".str_replace("www.", "", request()->getHttpHost());
        $forms=Form::where('district_id',Session::get('district_id'))->where('status','y')->orderBy('name','asc')->get();
        $enrollments=Enrollment::where('district_id',Session::get('district_id'))->where('status','Y')->orderBy('school_year','asc')->get();

        $transfers = Transfer::where('district_id',Session::get('district_id'))->where('status','y')->get();
       
        return view('Application::create',compact('forms','enrollments','transfers','application_url','district', 'languages'));
    }*/



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $msg=['program_grade_id.required'=>'The program grade field is required. '];
        $request->validate([
            'form_id'=>'required',
            'application_name'=>'required',
            //'cdi_starting_date' => 'required',
            //'cdi_ending_date' => 'required',
            'enrollment_id'=>'required',
            'starting_date'=>'required|max:255|date',
            'ending_date'=>'required|max:255|date',
            'admin_starting_date'=>'required|max:255|date',
            'admin_ending_date'=>'required|max:255|date',
            //'recommendation_due_date'=>'required|max:255|date',
            'transcript_due_date'=>'required|max:255|date',
            'submission_type'=>'required',
            'program_grade_id'=>'required'
        ],$msg);
        $currentdate=date("Y-m-d h:m:s", time());

        $languages = Languages::get();
        $tmp = [];
        foreach($languages as $key=>$lang)
        {
            if($lang->default != 'Y')
            {
                $str = "application_name_".$lang->language_code;
                if(isset($request->$str))
                {                    
                    $tmp[$lang->language_code] = $request->$str;
                }
            }
        }
        $language_name = "";
        if(count($tmp) > 0)
        {
            $language_name = json_encode($tmp);
        }

        $data=[
            'district_id'=>Session::get('district_id'),
            'form_id'=>$request->form_id,
            'enrollment_id'=>$request->enrollment_id,
            'application_name'=>$request->application_name,
            'starting_date'=>date('Y-m-d H:i:s', strtotime($request->starting_date)),
            'ending_date'=>date('Y-m-d H:i:s', strtotime($request->ending_date)),
            'admin_starting_date'=>date('Y-m-d H:i:s', strtotime($request->admin_starting_date)),
            'admin_ending_date'=>date('Y-m-d H:i:s', strtotime($request->admin_ending_date)),
            //'cdi_starting_date'=>date('Y-m-d', strtotime($request->starting_date)),
            //'cdi_ending_date'=>date('Y-m-d', strtotime($request->ending_date)),
            'recommendation_due_date'=>date('Y-m-d H:i:s', strtotime($request->recommendation_due_date)),
            'writing_prompt_due_date'=>($request->writing_prompt_due_date !='' ? date('Y-m-d H:i:s', strtotime($request->writing_prompt_due_date)) : ''),
            'transcript_due_date'=>date('Y-m-d H:i:s', strtotime($request->transcript_due_date)),
            'recommendation_email_to_parent'=>$request->recommendation_email_to_parent,
            'created_at'=>$currentdate,
            'updated_at'=>$currentdate,
            'display_logo' => $request->display_logo,
            'magnet_url'=>$request->magnet_url,
            'submission_type'=>$request->submission_type,
            'fetch_grades_cdi' => $request->fetch_grades_cdi,
            'language_name'=>$language_name
        ];
        if($request->recommendation_due_date == '')
            unset($data['recommendation_due_date']);
     
        $application=Application::create($data);
        $app_data = Application::where('id',$application->id)->first();
        $this->modelCreate($app_data,"application");

        $applicationProgram=[];
        if (isset($request->program_grade_id)) 
        {
             foreach($request->program_grade_id as $key => $value) 
            {
                $gradeProgram=explode(',', $value);
                $applicationProgram[]=[
                    'application_id'=>$application->id,
                    'grade_id'=>$gradeProgram[1],
                    'program_id'=>$gradeProgram[0],
                ];
            }
        }
        $applicationProgram=ApplicationProgram::insert($applicationProgram);

        foreach($languages as $key=>$value)
        {   
            $conf_data = array();
            $conf_data['language'] = $value->language_code;
            $conf_data['application_id'] = $application->id;

            $conf_data['active_screen_title'] = $request->active_screen_title[$key];
            $conf_data['active_screen_subject'] = $request->active_screen_subject[$key];
            $conf_data['active_screen'] = $request->active_screen[$key];
            $conf_data['active_email_subject'] = $request->active_email_subject[$key];
            $conf_data['active_email'] = $request->active_email[$key];
            $conf_data['pending_screen'] = $request->pending_screen[$key];
            /*$conf_data['pending_screen_title'] = $request->pending_screen_title[$key];
            $conf_data['pending_screen_subject'] = $request->pending_screen_subject[$key];*/
            $conf_data['pending_email_subject'] = $request->pending_email_subject[$key];
            $conf_data['pending_email'] = $request->pending_email[$key];

            $conf_data['grade_cdi_welcome_text'] = $request->grade_cdi_welcome_text[$key];
            $conf_data['grade_cdi_confirm_text'] = $request->grade_cdi_confirm_text[$key];
            $rs = ApplicationConfiguration::updateOrCreate(["application_id"=>$application->id, "language" => $value], $conf_data);

            $this->modelCreate($rs, "application-configuration");
        }
     
        // $rs = ApplicationConfiguration::create($conf_data);

        if (isset($application) && isset($application))
        {
            Session::flash("success", "Application added successfully.");
        }else{
            Session::flash("error", "Please Try Again.");
        }
        if (isset($request->save_exit))
        {
                return redirect('admin/Application');
        }
        return redirect('admin/Application/edit/'.$application->id);
        
    }
   

    public function edit($id)
    {
        $languages = Languages::get();
        $district = District::where("id", Session::get("district_id"))->first();
        $forms=Form::where('district_id',Session::get('district_id'))->where('status','y')->orderBy('name','asc')->get();
        $enrollments=Enrollment::where('district_id',Session::get('district_id'))->where('id',Session::get('enrollment_id'))->where('status','Y')->orderBy('school_year','asc')->get();
        $programs=Program::where('district_id',Session::get('district_id'))->where('enrollment_id',Session::get('enrollment_id'))->where('status','y')->get();
        $temp_programs=[];
        foreach ($programs as $key => $program) 
        {
            $grade_lavels=explode(',', $program->grade_lavel);
            $temp_grade=[];
            foreach ($grade_lavels as $k => $grade_lavel) 
            {
                $temp_grade[]=Grade::where('name',$grade_lavel)->first();//grade::where('id',$grade_lavel)->first();
            }
            $temp_programs[]=array_merge($program->toArray(),['grade_info'=>$temp_grade]);
        }
        $application=Application::where('application.id',$id)
            // ->select('form.name as form_name','enrollments.school_year','application.*')
            ->first();

        $lang_data = json_decode($application->language_name);
        $config_arr = [];
        foreach($languages as $key=>$value)
        {
            if($value->default == "Y")
            {
                $lan = $value->language_code;
                $rs = ApplicationConfiguration::where("application_id", $id)->where(function($query) use($lan) 
                    { 
                        $query->where("language", $lan)
                            ->orWhereNull("language");
                    })->first();

            }
            else
            {
                $rs = ApplicationConfiguration::where("application_id", $id)->where("language", $value->language_code)->first();
            }
            
           

            $config_arr[$value->language_code]['active_screen_title'] = "";
            $config_arr[$value->language_code]['active_screen_subject'] = "";
            $config_arr[$value->language_code]['active_screen'] = "";
            $config_arr[$value->language_code]['active_email_subject'] = "";
            $config_arr[$value->language_code]['active_email'] = "";
            $config_arr[$value->language_code]['pending_screen'] = "";
            $config_arr[$value->language_code]['pending_screen_title'] = "";
            $config_arr[$value->language_code]['pending_screen_subject'] = "";
            $config_arr[$value->language_code]['pending_email_subject'] = "";
            $config_arr[$value->language_code]['pending_email'] = "";
            $config_arr[$value->language_code]['grade_cdi_welcome_text'] = "";
            $config_arr[$value->language_code]['grade_cdi_confirm_text'] = "";

            if(!empty($rs))
            {
                $config_arr[$value->language_code]['active_screen_title'] = $rs->active_screen_title;
                $config_arr[$value->language_code]['active_screen_subject'] = $rs->active_screen_subject;
                $config_arr[$value->language_code]['active_screen'] = $rs->active_screen;
                $config_arr[$value->language_code]['active_email_subject'] = $rs->active_email_subject;
                $config_arr[$value->language_code]['active_email'] = $rs->active_email;
                $config_arr[$value->language_code]['pending_screen'] = $rs->pending_screen;
                $config_arr[$value->language_code]['pending_screen_title'] = $rs->pending_screen_title;
                $config_arr[$value->language_code]['pending_screen_subject'] = $rs->pending_screen_subject;
                $config_arr[$value->language_code]['pending_email_subject'] = $rs->pending_email_subject;
                $config_arr[$value->language_code]['pending_email'] = $rs->pending_email;
                $config_arr[$value->language_code]['grade_cdi_welcome_text'] = $rs->grade_cdi_welcome_text;
                $config_arr[$value->language_code]['grade_cdi_confirm_text'] = $rs->grade_cdi_confirm_text;
            }
        }

        $applicationPrograms=ApplicationProgram::where('application_id',$id)->get();
        $appProgTemp=[];
        if (isset($applicationPrograms))
        {
            foreach ($applicationPrograms as $key=>$applicationProgram)
            {
                $appProgTemp[]=$applicationProgram->program_id.','.$applicationProgram->grade_id;
            }
        }
        $application_configuration = ApplicationConfiguration::where("application_id", $id)->first(); // remove

        $submission_count = Submissions::where("application_id", $id)->count();
        return view('Application::edit',compact('forms','enrollments','temp_programs','appProgTemp','application','application_configuration','district', 'submission_count','languages','lang_data','config_arr'));
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
        // return $request;
        //
         $msg=['program_grade_id.required'=>'The program grade field is required. '];
        $request->validate([
            'form_id'=>'required',
            'application_name'=>'required',
            'enrollment_id'=>'required',
            'starting_date'=>'required|max:255|date',
            'ending_date'=>'required|max:255|date',
            'admin_starting_date'=>'required|max:255|date',
            'admin_ending_date'=>'required|max:255|date',
            //'cdi_starting_date'=>'required',
            //'cdi_ending_date'=>'required',
            //'recommendation_due_date'=>'required|max:255|date',
            'transcript_due_date'=>'required|max:255|date',
            //'program_grade_id'=>'required',
            'submission_type'=>'required'

        ],$msg);

        $languages = Languages::get();
        $tmp = [];
        foreach($languages as $key=>$lang)
        {
            if($lang->default != 'Y')
            {
                $str = "application_name_".$lang->language_code;
                if(isset($request->$str))
                {                    
                    $tmp[$lang->language_code] = $request->$str;
                }
            }
        }
        $language_name = "";
        if(count($tmp) > 0)
        {
            $language_name = json_encode($tmp);
        }

        $currentdate=date("Y-m-d h:m:s", time());
        $data=[
            'district_id'=>Session::get('district_id'),
            'form_id'=>$request->form_id,
            'application_name'=>$request->application_name,
            'enrollment_id'=>$request->enrollment_id,
            'starting_date'=> date('Y-m-d H:i:s', strtotime($request->starting_date)), //date('Y-m-d', strtotime($request->starting_date)),
            'ending_date'=> date('Y-m-d H:i:s', strtotime($request->ending_date)), //date('Y-m-d', strtotime($request->ending_date)),
            'admin_starting_date'=> date('Y-m-d H:i:s', strtotime($request->admin_starting_date)), //date('Y-m-d', strtotime($request->starting_date)),
            'admin_ending_date'=> date('Y-m-d H:i:s', strtotime($request->admin_ending_date)), //date('Y-m-d', strtotime($request->ending_date)),
            'recommendation_due_date'=> date('Y-m-d H:i:s', strtotime($request->recommendation_due_date)), //date('Y-m-d', strtotime($request->recommendation_due_date)),
            'transcript_due_date'=> date('Y-m-d H:i:s', strtotime($request->transcript_due_date)),
            'writing_prompt_due_date'=>($request->writing_prompt_due_date !='' ? date('Y-m-d H:i:s', strtotime($request->writing_prompt_due_date)) : NULL),
             //date('Y-m-d', strtotime($request->transcript_due_date)),
            //'cdi_starting_date'=> date('Y-m-d', strtotime($request->cdi_starting_date)),
            //'cdi_ending_date'=> date('Y-m-d', strtotime($request->cdi_ending_date)), //date('Y-m-d', strtotime($request->transcript_due_date)),
            'recommendation_email_to_parent'=>$request->recommendation_email_to_parent,
            'created_at'=>$currentdate,
            'display_logo'=>$request->display_logo,
            'updated_at'=>$currentdate,
            'magnet_url'=>$request->magnet_url,
            'submission_type'=>$request->submission_type,
            'fetch_grades_cdi' => $request->fetch_grades_cdi,
            'language_name'=>$language_name
        ];
         if($request->recommendation_due_date == '')
            unset($data['recommendation_due_date']);
        // return $data
        $initObj = Application::where('id',$id)->first();
        $application=Application::where('id',$id)->update($data);
        $newObj = Application::where('id',$id)->first();

        $this->modelChanges($initObj,$newObj,"application");
        
        $applicationProgram=[];
        $gdArr = array();

        $old_entries = ApplicationProgram::where('application_id', $id)->get(['id']);
        $old_ids = [];
        foreach ($old_entries as $key => $value) {
            $old_ids[] = $value->id;
        }
        if (isset($request->program_grade_id))
        {
            foreach($request->program_grade_id as $key => $value)
            {
                $gradeProgram=explode(',', $value);
                $dt = ApplicationProgram::where('application_id', $id)->where('grade_id', $gradeProgram[1])->where('program_id', $gradeProgram[0])->first();
                if(empty($dt))
                {
                    $applicationProgram[]=[
                        'application_id'=>$id,
                        'grade_id'=>$gradeProgram[1],
                        'program_id'=>$gradeProgram[0],
                    ];
                }else{
                    $ary_key = array_search($dt->id, $old_ids);
                    if (isset($ary_key)) {
                        unset($old_ids[$ary_key]);
                    }
                    unset($ary_key);
                }
                // array_diff($old_ids);
            }
        }
        // removing ids present in olds ids array
        $rs = Submissions::where("application_id", $id)->count();
        if (isset($old_ids) && $rs <= 0) {
            foreach ($old_ids as $key => $value) {
                $rs = Submissions::where("first_choice", $value)->orWhere("second_choice", $value)->first();
                if (!isset($rs)) {
                    ApplicationProgram::where('id', $value)->delete();
                }
            }
        }

        $applicationProgram=ApplicationProgram::insert($applicationProgram);


        foreach($languages as $key=>$value)
        {   
            $conf_data = array();
            $conf_data['language'] = $value->language_code;
            $conf_data['application_id'] = $id;

            $conf_data['active_screen_title'] = $request->active_screen_title[$key];
            $conf_data['active_screen_subject'] = $request->active_screen_subject[$key];
            $conf_data['active_screen'] = $request->active_screen[$key];
            $conf_data['active_email_subject'] = $request->active_email_subject[$key];
            $conf_data['active_email'] = $request->active_email[$key];
            $conf_data['pending_screen'] = $request->pending_screen[$key];
            $conf_data['pending_screen_title'] = $request->pending_screen_title[$key];
            $conf_data['pending_screen_subject'] = $request->pending_screen_subject[$key];
            $conf_data['pending_email_subject'] = $request->pending_email_subject[$key];
            $conf_data['pending_email'] = $request->pending_email[$key];
            $conf_data['grade_cdi_welcome_text'] = $request->grade_cdi_welcome_text[$key];
            $conf_data['grade_cdi_confirm_text'] = $request->grade_cdi_confirm_text[$key];
            
            $key_data = ["application_id"=>$id, "language" => $value->language_code];
            $initObj = ApplicationConfiguration::where($key_data)->first();
            $rs = ApplicationConfiguration::updateOrCreate($key_data, $conf_data);

            $newObj = ApplicationConfiguration::where($key_data)->first();
            if (!isset($initObj)) {
                $this->modelCreate($newObj,"application-configuration");
            } else {
                $this->modelChanges($initObj,$newObj,"application-configuration");
            }
        }

        if (isset($application) && isset($application))
        {
            Session::flash("success", "Application Updated successfully.");
        }else{
            Session::flash("error", "Please Try Again.");
        }
        if (isset($request->save_exit))
        {
            return redirect('admin/Application');
        }
        return redirect('admin/Application/edit/'.$id);
        
    }
    public function trash()
    {
        $applications=Application::
        join('form','form.id','=','application.form_id')
        ->join('enrollments','enrollments.id','=','application.enrollment_id')
        ->where('application.status','T')
        ->where('application.district_id',Session::get('district_id'))
        ->where('application.enrollment_id',Session::get('enrollment_id'))
        ->select('form.name as form_name','enrollments.school_year','application.*')
        ->get();
        // return $applications;
        // return 'asd';
        return view("Application::trash",compact('applications'));
    }
    public function restore($id)
    {
        $result=Application::where('id',$id)->update(['status'=> 'Y']);
       if (isset($result))
        {
            Session::flash("success", "Application restore successfully.");
        }else{
            Session::flash("error", "Please Try Again.");
        }
        return redirect('admin/Application');
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

    public function start_end_date(Request $request)
    {
        $enrollment=Enrollment::where('id',$request->id)->first();
        return response()->json(['start'=>$enrollment->begning_date,'end'=>$enrollment->ending_date]);
        # code...
    }
    public function status(Request $request)
    {
        $result=Application::where('id',$request->id)->update(['status'=> $request->status]);
        if(isset($result))
        {
            return json_encode(true);
        }
        else {
            return json_encode(false);
        }
    }
    
    public function delete($id)
    {
        $result=Application::where('id',$id)->update(['status'=> 'T']);
       if (isset($result))
        {
            Session::flash("success", "Application deleted successfully.");
        }else{
            Session::flash("error", "Please Try Again.");
        }
        return redirect('admin/Application');
    }

    public function previewSection($type, $application_id, $lang=NULL)
    {
        $district = District::where("id", Session::get('district_id'))->first();
        $data = ApplicationConfiguration::where("application_id", $application_id);
        if (isset($lang)) {
            $data = $data->where('language', $lang);
        }
        $data = $data->first();
        if(empty($data))
        {
            $data = ApplicationConfiguration::where("application_id", $application_id)->where('language', "english")->first();
        }
        $application_data = Application::where("id", $application_id)->first();
         if($type == "active_screen" || $type == "pending_screen")
            {
                //here i'll write code for active email
                
                $confirm_msg = $data->{$type};

                if($type=="active_screen")
                {
                    $student_type = "active";
                    $msg_type = "exists_success_application_msg";
                    $confirm_title = $data->active_screen_title;
                    $confirm_subject = $data->active_screen_subject;
                }
                else
                {
                    $student_type = "pending";
                    $msg_type = "new_success_application_msg";
                    $confirm_title = $data->pending_screen_title;
                    $confirm_subject = $data->pending_screen_subject;
                }
                
                $confirmation_no = "{confirmation_no}";
                return view('layouts.errors.confirm_screen',compact("district","msg_type","confirmation_no","confirm_msg","confirm_subject","confirm_title","student_type","application_data")); 
            }
            else
            {
                //here i'll write pending email code
                $emailArr = array();
                $emailArr['type'] = $type;
                $emailArr['msg'] = $data->{$type};

                $student_type = "pending";
                //$this->sentSuccessEmail("pending_email");                
                $msg_type = "new_success_application_msg";
                
                if($type=="active_email")
                {
                    $emailArr['email_text'] = $data->active_email;
                    $emailArr['subject'] = $data->active_email_subject;
                }
                else
                {
                    $emailArr['email_text'] = $data->pending_email;
                    $emailArr['subject'] = $data->pending_email_subject; 
                }
                $emailArr['logo'] = getDistrictLogo();
                $data = $emailArr;
                return view('emails.preview_application_index',compact("data", "type", "application_id"));                    

            }

        
    }

    public function sendTestMail(Request $request)
    {
        $req = $request->all();
        $email = $req['email'];
        $type = $status = $req['status'];
        $application_id = $req['application_id'];
        $district_id = Session::get('district_id');

        $data = ApplicationConfiguration::where("application_id", $application_id)->first();
        $submissions = Submissions::where('district_id', $district_id)->first();

        // return $submissions->last_name;

        $emailArr = array();
        $emailArr['type'] = $type;  
        // $emailArr['msg'] = $data->{$type};
        $emailArr['email'] = $email;

        if($type=="active_email")
        {
            $emailArr['msg'] = $data->active_email;
            $emailArr['subject'] = str_replace("{confirm_number}", $submissions->confirmation_no, $data->active_email_subject);
        }
        else
        {
            $emailArr['msg'] = $data->pending_email;
            $emailArr['subject'] = str_replace("{confirm_number}", $submissions->confirmation_no, $data->pending_email_subject); 
        }

        $emailArr['parent_name'] = $submissions->parent_first_name." ".$submissions->parent_last_name;
        $emailArr['parent_first_name'] = $submissions->parent_first_name;
        $emailArr['parent_last_name'] = $submissions->parent_last_name;
        $emailArr['birth_date'] = getDateFormat($submissions->birthday);
        $emailArr['student_name'] = $submissions->first_name." ".$submissions->last_name;
        $emailArr['parent_email'] = $submissions->parent_email;
        $emailArr['student_id'] = $submissions->student_id;
        $emailArr['confirmation_no'] = $emailArr['confirm_number'] = $submissions->confirmation_no;
        $emailArr['name'] = $submissions->first_name." ".$submissions->last_name;
        $emailArr['first_name'] = $submissions->first_name;
        $emailArr['last_name'] = $submissions->last_name;
        $emailArr['transcript_due_date'] = $submissions->created_at;
        $emailArr['logo'] = getDistrictLogo();

        sendMail($emailArr);
        echo "Done";
    }
}
