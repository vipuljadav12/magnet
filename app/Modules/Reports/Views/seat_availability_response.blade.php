<div class="card-body">

    <div class=" ">
        <div class="">    
            <select class="form-control" id="select_program">
                <option value="">Select Program</option>
                @foreach($programs as $program) 
                    @php
                        $grades = explode(',', $program->grade_lavel);
                    @endphp
                    @foreach($grades as $grade)
                        @php
                            $option_val = $program->id.','.$grade.','.$program->parent_submission_form;
                        @endphp
                        <option value="{{$option_val}}" @if($selected_program==$option_val) selected @endif>{{$program->name.' | Grade - '.$grade}}</option>
                    @endforeach
                @endforeach
            </select>
        </div>
    </div>
    
    @if($selected_program!='')
        @if(!empty($data['process_data']))
            <div class="table-responsive mt-2">
                @php
                    $conf = config('variables.seat_availability_conf');
                @endphp
                <table class="table table-striped mb-0 w-100" id="tbl_data" style="margin-top: 45px !important;">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="5" id="program_header"></th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Type</th>
                            <th class="text-center align-middle">Withdrawn Seats</th>
                            <th class="text-center align-middle">Offered</th>
                            <th class="text-center align-middle">Accepted</th>
                            <th class="text-center align-middle">Final Available</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['process_data'] as $program_id => $process_data)
                            @php
                                $available_seats = $process_data['available_seats'];
                            @endphp
                            @if(isset($process_data['type']) && !empty($process_data['type']))
                                <tr>
                                    <td class="align-middle">Initial Availability</td>
                                    <td class="align-middle">-</td>
                                    <td class="text-center align-middle">-</td>
                                    <td class="text-center align-middle">-</td>
                                    <td class="text-center align-middle">{{$available_seats}}</td>
                                </tr>
                                @foreach($process_data['type'] as $type => $version_data)
                                    @foreach($version_data as $version=>$value)
                                        @php
                                            $offered = $value['Offered']??0;
                                            $accepted = $value['Accepted']??0;

                                            $withdrawn = 0;
                                            $withdrawn += $black_withdrawn = $value['withdrawn_seats']->black_withdrawn ?? 0;
                                            $withdrawn += $white_withdrawn = $value['withdrawn_seats']->white_withdrawn ?? 0;
                                            $withdrawn += $other_withdrawn = $value['withdrawn_seats']->other_withdrawn ?? 0;
                                            $withdrawn += $additional_withdrawn = $value['withdrawn_seats']->black_withdrawn ?? 0;
                                            
                                            $available_seats = $available_seats + $withdrawn - $accepted;
                                        @endphp
                                        <tr>
                                            <td class="align-middle">
                                                {{$conf[$type]['title'] ?? ''}}<span class="dtbl_hide">,</span> <br/>{{getDateTimeFormat($value['updated_at']??'')}}
                                            </td>
                                            <td class="align-middle">
                                                Black - {{$black_withdrawn}}<span class="dtbl_hide">,</span> <br/>White - {{$white_withdrawn}}<span class="dtbl_hide">,</span> <br/>Other - {{$other_withdrawn}}<span class="dtbl_hide">,</span> <br/>Additional - {{$additional_withdrawn}}<span class="dtbl_hide">,</span> <br/><b>Total - {{$withdrawn ?? 0}}</b>
                                            </td>
                                            <td class="text-center align-middle">{{$offered}}</td>
                                            <td class="text-center align-middle">{{$accepted}}</td>
                                            <td class="text-center align-middle">{{$available_seats}}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="table-responsive text-center"><p>No records found.</div>
        @endif
    @endif
</div>