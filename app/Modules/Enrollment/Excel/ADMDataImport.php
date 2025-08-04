<?php
namespace App\Modules\Enrollment\Excel;

use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Modules\Enrollment\Models\ADMData;
use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\School\Models\School;
use Session;

class ADMDataImport implements ToCollection,WithBatchInserts,WithHeadingRow,SkipsOnFailure
{
  use Importable, SkipsFailures;

  protected $allErrors=[];

  public function collection(Collection $rows)
  {
    //dd($rows);
    foreach ($rows as $key => $row) 
    {
      $errors=[];
      $school = School::where('id', $row['school_id'])
        ->where('district_id', Session::get("district_id"))
        ->first();
      if (isset($school)) {
        $enrollment = Enrollment::where('status','Y')
          ->where("district_id",$school->district_id)
          ->get()
          ->last();
      } else {
        $errors[]="Entered School ID is not valid.";
      }
      $ins = array();
      // $gs_total = 0;

      $insert = false;
      if($row['majority_race'] != '')
      {
        $majority_race = strtolower($row['majority_race']);
        $majority_race = str_replace('/','',$majority_race);
        if($row['majority_race'] != '' && $majority_race == 'white'){
          $insert = true;
          $ins['white'] = "65";
          $ins['black'] = "10";
          $ins['other'] = "10";
          $ins['majority_race'] = "white";
        }
        if($row['majority_race'] != '' && $majority_race== 'black'){
          $insert = true;
          $ins['white'] = "10";
          $ins['black'] = "65";
          $ins['other'] = "10";
          $ins['majority_race'] = "black";
        }
        if($row['majority_race'] != '' && $majority_race == 'other'){
          $insert = true;
          $ins['white'] = "10";
          $ins['black'] = "10";
          $ins['other'] = "65";
          $ins['majority_race'] = "other";
        }
        if($row['majority_race'] != '' &&  ($majority_race == 'no majority' || $majority_race == 'na')){
            $insert = true;
            $ins['white'] = "10";
            $ins['black'] = "10";
            $ins['other'] = "10";
            $ins['majority_race'] = ($majority_race == 'no majority' ? 'no majority' : 'na');
        }
        if($row['majority_race'] == ''){
          $errors[] = "Enter value for field Majority race.";
        }
        if (empty($errors) && $insert) {
          $ins['school_id'] = $school->id;
          $ins['enrollment_id'] = Session::get('upADM_Enroll_id');
         // $ins['available_seats'] = $gs_total;
          //$ins['year'] = $enrollment->school_year ?? (date("Y")-1)."-".date("Y");
          $key_data = [
              'school_id' => $school->id,
              'enrollment_id' => Session::get('upADM_Enroll_id')
          ];

          
          $result = ADMData::updateOrCreate($key_data, $ins);
        } else {
          $row['errors'] = $errors;
          $this->allErrors[]=$row;
        }
      } 
              
    }
    
  }
  public function batchSize(): int
  {
    return 1;
  }
  public function errors()
  {
      return $this->allErrors;
  }
}
