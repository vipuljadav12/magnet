@extends('Offers::app')

@section('content')
    <div class="container">
        <div class="mt-20">
            <div class="card bg-light p-20">
                <div class="">
                  <form method="post" action="{{url('/LateSubmission/Offers/store')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="submission_id" value="{{$submission->submission_id}}">
                    <input type="hidden" name="version" value="{{$version}}">
                    {!! $msg !!}
                    <div class="row @if($second_program == "") justify-content-center @endif">
                        <div class="col-12 col-lg-4 mb-10"><button type="submit" name="accept_btn" value="{{$approve_program_id}}" class="h-100 pt-10 pb-10 d-flex align-items-center justify-content-center btn-block text-center btn btn-success">Accept Magnet Application Offer</button></div>
                        <div class="col-12 col-lg-4 mb-10"><button type="submit" name="decline_btn" value="{{$approve_program_id}}" title="" class="h-100 pt-10 pb-10 d-flex align-items-center justify-content-center btn-block text-center btn btn-danger">Decline Magnet Application Offer</button></div>
                        @if($second_program != "")
                        <div class="col-12 col-lg-4 mb-10"><button type="submit" name="decline_waitlist" value="{{$approve_program_id}}" class="h-100 pt-10 pb-10 d-flex align-items-center justify-content-center btn-block text-center btn btn-warning">Decline Offer/Choose to be Waitlisted for {{$second_program}} - Grade {{$submission->next_grade}}</button></div>
                        @endif
                    </div>
                    <div class="">IMPORTANT : If you do not accept or decline online by {{getDateTimeFormat($last_online_date)}} or by calling <strong>Huntsville City Schools</strong> by {{getDateTimeFormat($last_offline_date)}}, your Magnet offer will automatically be DECLINED.</div>
                  </form>
                </div>
            </div>
        </div>
    </div>
@endsection