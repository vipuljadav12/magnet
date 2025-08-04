@extends('layouts.front.app')
@section('title')
    <title>Huntsville City Schools</title>
@endsection

@section('language_change')
<div class="mt-20 col-12 text-right top-links text-right"><div class=""><a href="javascript:void(0);" onclick="changeLanguage();" title="English">English</a> | <a href="javascript:void(0);" onClick="changeLanguage('spanish');"  title="Spanish">Spanish</a></div></div>
@endsection
@section('content')
    @if(!Session::has("from_admin"))
        @include("layouts.front.common.district_header")
    @endif
    
    @if(!empty($application_data))
        <form class="p-20 border mt-20 mb-20" action="{{url('/step-1')}}" method="post" name="studentstatus_frm" id="studentstatus_frm">
            {{csrf_field()}}
            <input type="hidden" name="page_id" value="1">
            <input type="hidden" name="form_id" value="{{$application_data->form_id}}">
            <input type="hidden" name="application_id" value="{{$application_data->id}}">
            <div class="box-0">
                <p class="text-center"><strong>{!! getWordGalaxy('Begin the application here') !!}</strong></p>
                <div class="form-group row">
                    <label class="control-label col-12 col-md-4 col-xl-3 text-right">{!! getWordGalaxy('Student Status') !!} : </label>
                    <div class="col-12 col-md-6 col-xl-6">
                        <select class="form-control custom-select student-status" name="student_status" id="student_status">
                            <option value="">{!! getWordGalaxy('Choose an Option') !!}</option>
                            
                            <option value="exist">{{ ((isset(getConfig()['existing_student']) && getConfig()['existing_student'] != '') ? strip_tags(getConfig()['existing_student']) : "Enrolled ".$district->short_name." Student (PreK - 11th Grade)") }}</option>
                            <option value="new">{{ ((isset(getConfig()['new_student']) && getConfig()['new_student'] != '')? strip_tags(getConfig()['new_student']) : "New ".$district->short_name." Student") }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-12 col-md-4 col-xl-3"></label>
                    <div class="col-12 col-md-6 col-xl-6">
                        <button type="submit" class="btn btn-secondary submit-btn" title="">{{getWordGalaxy('Submit')}}</button>
                    </div>
                </div>
            </div> 
        </form>  
    @else
        <div class="box-0 text-center p-20 border mt-20 mb-20">
            <div class="form-group">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="b-600 font-14 mb-10 text-danger">No Application is open for submission.</div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section("scripts")
	<script type="text/javascript">
		$('#studentstatus_frm').validate({
                rules: {
                    student_status: {
                        required: true,                       
                    }
                },
                messages: {
                    student_status: {
                        required: "Select Student Status"
                    }
                }
            });
	</script>
@endsection