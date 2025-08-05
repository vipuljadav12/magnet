<?php

namespace App\Modules\Configuration\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Configuration\Models\Configuration;
use Illuminate\Support\Facades\Validator;
use App\Traits\AuditTrail;
use App\Languages;
use Illuminate\Support\Facades\Session;

class ConfigurationController extends Controller
{
  use AuditTrail;
  public function index()
  {
    $configurations = Configuration::where('status', '!=', 't')->where('district_id', Session::get('district_id'))->get();
    return view("Configuration::index", compact('configurations'));
  }

  public function create()
  {
    return view("Configuration::create");
  }

  public function store(Request $request)
  {
    $req = $request->all();
    $rules = array(
      'config_name' => 'required',
      'config_value' => 'required',
    );
    $message = array(
      'config_name.required' => 'Description is required.',
      'config_value.required' => 'Text is required.',
    );
    $validator = Validator::make($req, $rules, $message);
    if ($validator->fails()) {
      Session::flash('error', 'Somthing is wrong');
      $messages = $validator->messages();
      return redirect()->back()->withErrors($validator)->withInput();
    } else {
      $district_id = Session::get("district_id");
      $data = [
        'config_name'  => $req['config_name'],
        'config_value' => $req['config_value'],
        'district_id'  => $district_id
      ];
      $exist = Configuration::where("config_name", $data["config_name"])->where("district_id", $district_id)->first();
      if (isset($exist->id)) {

        $initObj = Configuration::where('id', $exist->id)->first();

        $exist->config_value = $data['config_value'];
        $exist->save();

        $newObj = Configuration::where('id', $exist->id)->first();
        $this->modelChanges($initObj, $newObj, "configuration");

        Session::flash("success", "Data Updated successfully");
      } else {
        $Configuration = Configuration::create($data);
        $newObj = Configuration::where('id', $Configuration->id)->first();
        $this->modelCreate($newObj, "configuration");
      }

      if (isset($Configuration)) {
        Session::flash("success", "Text Description Added successfully");
      } else {
        Session::flash("error", "Something went wrong please try again.");
      }
      if (isset($req['save'])) {
        return redirect('admin/Configuration/create');
      } else {
        return redirect('/admin/Configuration/');
      }
    }
  }

  public function edit($id)
  {
    $configuration = Configuration::where('id', $id)->first();
    $config_name = $configuration->config_name;
    $languages = Languages::get();

    $config_arr = [];
    foreach ($languages as $key => $value) {
      $config_arr[$value->language_code] = "";
      $rs = Configuration::where("district_id", Session::get("district_id"))->where("language", $value->language_code)->where("config_name", $config_name)->first();
      if (!empty($rs)) {
        $config_arr[$value->language_code] = $rs->config_value;
      }
    }
    return view("Configuration::edit", compact('config_arr', "languages", "configuration"));
  }

  public function update(Request $request, $id)
  {
    $req = $request->all();
    // return $req;
    $languages = $req['languages'];
    foreach ($languages as $key => $lang) {
      $key_data = ["district_id" => Session::get("district_id"), "language" => $lang, "config_name" => $req['config_name']];
      $initObj = Configuration::where($key_data)->first();

      $data = [];
      $data['language'] = $lang;
      $data['config_name'] = $req['config_name'];
      $data['config_value'] = $req['config_value_' . $lang];
      $data['district_id'] = Session::get("district_id");
      $rs = Configuration::updateOrCreate($key_data, $data);

      $newObj = Configuration::where($key_data)->first();
      if (!isset($initObj)) {
        $this->modelCreate($newObj, "configuration");
      } else {
        $this->modelChanges($initObj, $newObj, "configuration");
      }
    }

    Session::flash("success", "Text Description Updated successfully");

    if (isset($req['save'])) {
      return redirect('admin/Configuration/edit/' . $id);
    } else {
      return redirect('/admin/Configuration/');
    }
  }

  public function changeStatus(Request $request)
  {
    $configuration = Configuration::where('id', $request->id)->update(['status' => $request->status]);
    if (isset($configuration)) {
      return json_encode(true);
    } else {
      return json_encode(false);
    }
  }
  public function delete($id)
  {
    $configuration = Configuration::where('id', $id)->delete();
    if (isset($configuration)) {
      Session::flash('success', "Text Description delete successfully.");
    } else {
      Session::flash('error', 'Please try again');
    }
    return  redirect('admin/Configuration');
  }
}
