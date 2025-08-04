<div class="card-body">
    <div class=" mb-10">
        <div id="submission_filters" class="pull-left col-md-6 pl-0" style="float: left !important;"></div> 
        <div class="text-right">    
                                               
            <!-- <a href="javascript:void(0)" onclick="exportMissing()" title="Export Missing Grade" class="btn btn-secondary">Export Missing Grade</a>
            </div> -->
    </div>    
    @if(!empty($firstdata))
    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100" id="datatable">
            <thead>
                <tr>
                    <th class="align-middle">Submission ID</th>
                    <th class="align-middle">State ID</th>
                    <th class="align-middle">Student Type</th>
                    <th class="align-middle">Student Name</th>
                    <th class="align-middle">Next Grade</th>
                    <th class="align-middle">First Choice Program</th>
                    <th class="align-middle">Second Choice Program</th>
                    <th class="align-middle">Zoned School</th>
                    <th class="align-middle">How did<br>you hear<br>about us?</th>
            </thead>
            <tbody>
                @foreach($firstdata as $key=>$value)
                    <tr id="row{{$value['submission_id']}}">
                        <td class="text-center"><a href="{{url('/admin/Submissions/edit/'.$value['id'])}}">{{$value['id']}}</a></td>
                        <td class="">{{$value['student_id']}}</td>
                        <td class="notexport">{{($value['student_id'] != "" ? "Current" : "Non-Current")}}</td>
                        <td class="">{{$value['first_name'] . " " . $value['last_name']}}</td>
                        <td class="text-center">{{$value['next_grade']}}</td>
                        <td class="text-center">{{getProgramName($value['first_choice_program_id'])}}</td>
                        <td class="text-center">{{getProgramName($value['second_choice_program_id'])}}</td>

                        <td class="">{{$zoned_school ?? $value['zoned_school']}}</td>
                        <td class="text-center notexport">
                            @php
                                if($value['additional_questions'] != "")
                                {
                                    $data = json_decode($value['additional_questions']);
                                    foreach($data as $k=>$v)
                                    {
                                        if($k == "How did you hear about our programs?")
                                            echo $v;
                                    }
                                }
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="table-responsive text-center"><p>No records found.</div>
    @endif
</div>