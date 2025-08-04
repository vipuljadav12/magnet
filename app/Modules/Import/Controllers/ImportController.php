<?php 

namespace App\Modules\Import\Controllers;

use Session;
use Response;
use Validator;
use App\Traits\AuditTrail; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Import\Rule\ExcelRule;
use App\Modules\Import\ImportFiles\GiftedStudentsImport;
use App\Modules\Import\ImportFiles\AgtNewCenturyImport;
use Maatwebsite\Excel\HeadingRowImport;
use App\StudentData;
use App\Modules\Program\Models\Program;

use App\Modules\Import\Models\AgtToNch;
class ImportController extends Controller
{
    use AuditTrail;

    public function importGiftedStudents(){
        return view('Import::import_gifted_students');
    }

    public function saveGiftedStudents(Request $request)
    {
        $rules = [
            'upload_csv'=> ['required', new ExcelRule($request->file('upload_csv'))],
        ];
        $message = [
            'upload_csv.required'=>'File is required',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if($validator->fails()){
            Session::flash('error','Please select proper file');
            return redirect()->back()->withErrors($validator)->withInput();
        }else
        {   
            $rs = StudentData::where("field_name", "like", "%gifted%")->delete();

            $file = $request->file('upload_csv');
            $headings = (new HeadingRowImport)->toArray($file);
            $excelHeader=$headings[0][0];
            $fixheader=['currentenrollmentstatus','stateidnumber','lastname','firstname','gr','school','primaryexceptionality','casemanager','specialeducationstatus','enrichmentstudent',''];
            $fixheader1=['currentenrollmentstatus','stateidnumber','lastname','firstname','gr','school','primaryexceptionality','casemanager','specialeducationstatus','enrichmentstudent'];

            if(!(CheckExcelHeader($excelHeader,$fixheader)) && !(CheckExcelHeader($excelHeader,$fixheader1)))
            {
                Session::flash('error','Please select proper file | File header is improper');
                return redirect()->back();
            }
            
            $import = new GiftedStudentsImport;
            $import->import($file);
            Session::flash('success','Gifted Students Imported successfully');
        }
        return  redirect()->back(); 
    }

    public function importAGTNewCentury()
    {
        $programs=Program::where('status','!=','T')->where('district_id', \Session::get('district_id'))->where('enrollment_id', \Session::get('enrollment_id'))->get();
        return view('Import::import_agt_nch', compact("programs"));
    }

    public function storeImportAGTNewCentury(Request $request)
    {
        $rules = [
            'program_name' => ['required'],
            'upload_agt_nch'=> ['required', new ExcelRule($request->file('upload_agt_nch'))],
        ];
        $message = [
            'program_name.required'=>'Program is required',
            'upload_agt_nch.required'=>'File is required',
        ];
        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()){
            Session::flash('error','Something wrong. Please check all fields.');
            return redirect()->back()->withErrors($validator)->withInput();
        }else
        {
            $file = $request->file('upload_agt_nch');
            $headings = (new HeadingRowImport)->toArray($file);
            $excelHeader=array_filter($headings[0][0]);


            $fixheader=['student_id','name', 'grade_level'];
            //dd($fixheader,$excelHeader);

            if(!(CheckExcelHeader($excelHeader,$fixheader)))
            {
                Session::flash('error','Please select proper file | File header is improper');
                return redirect()->back();
            }

            $import = new AgtNewCenturyImport;
            $import->program_name = $request->program_name;
            $import->import($file);
            Session::flash('success','AGT priority to New Century Imported successfully');
        }
        return  redirect()->back(); 
        
    }

}    