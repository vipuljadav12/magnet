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

    @if(isset($applications) && !empty($applications))
        <div class="box-0 text-center">
            <div class="form-group text-center p-20 border mt-20 mb-20">
                <div class="card shadow">
                    <div class="card-body">
                        <p class="text-center"><strong>Please select a form:</strong></p>
                        @foreach($applications as $key=>$application)
                            <div class="col-sm-12 p-10 m-10">
                            <a href="{{url('/application/'.$application->id)}}" class="btn btn-secondary submit-btn p-20 b-600">{{$application->application_name}}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
          
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
