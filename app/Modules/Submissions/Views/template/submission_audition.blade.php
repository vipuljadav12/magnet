@if(!empty($choice_ary))

    @foreach($choice_ary as $choice => $cvalue)

        @php
            // dd($value_2->assigned_eigibility_name);
            if ($choice == 'first') {
                $eligibility_data = getEligibilityConfigDynamic($submission->first_choice_program_id, $value->assigned_eigibility_name, "email", $submission->application_id);
            } else{
                $eligibility_data = getEligibilityConfigDynamic($submission->second_choice_program_id, $value->assigned_eigibility_name, "email", $submission->application_id);
            }
            
        @endphp
            <div class="card shadow">
                <div class="card-header">{{$value->eligibility_ype}} {{$cvalue}} [{{getProgramName($submission->{$choice.'_choice_program_id'})}}]</div>
                <div class="card-body">
                    {!! $eligibility_data !!}

                    <div class="input-group">
                           <a href="{{url('/admin/Submissions/resend/audition/'.$submission->id.'/'.$choice)}}" class="btn btn-sm btn-primary" title="" onclick="sendAuditionEmail(this)"><i class="far fa-paper-plane"></i> Resend Email</a>
                        </div>
                </div>
                
            </div>
    @endforeach
@endif