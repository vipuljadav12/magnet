<div class="card-body">
    

    <div class=" mb-10">
        <div id="submission_filters" class="pull-left col-md-6 pl-0" style="float: left !important;"></div> 
        <div class="text-right">    
       
    </div>
    
   
    @if(!empty($dataArr))

    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100" id="datatable">
            <thead>
                <tr>
                    <th class="align-middle" rowspan="2">Submission ID</th>
                    <th class="align-middle" rowspan="2">Student Name</th>
                    <th class="align-middle" rowspan="2">Next Grade</th>
                    <th class="align-middle" rowspan="2">Powerschool Race</th>
                    <th class="align-middle" rowspan="2">Considerable Race</th>
                    <th class="align-middle" rowspan="2">Zoned School</th>
                    <th class="align-middle" rowspan="2">Zoned School<br>Majority Race</th>
                    <th class="align-middle text-center" colspan="2">First Choice</th>
                    <th class="align-middle text-center" colspan="2">Second Choice</th>
                </tr>
                <tr>
                    <th class="align-middle">Program Name</th>
                    <th class="align-middle">Majority Race</th>
                    <th class="align-middle">Program Name</th>
                    <th class="align-middle">Majority Race</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataArr as $value)
                    <tr>
                        <td class="text-center"><a href="{{url('/admin/Submissions/edit/'.$value['id'])}}">{{$value['id']}}</a></td>
                        <td class="">{{$value['first_name']." ".$value['last_name']}}</td>
                        <td class="notexport">{{$value['next_grade']}}</td>
                        <td class="text-center">{{$value['race']}}</td>
                        <td class="">{{$value['calculated_race']}}</td>
                        <td class="">{{$value['zoned_school']}}</td>
                        <td class="">{{$value['zone_school_majority_race']}}</td>
                        <td class="">{{$value['first_program']}}</td>
                        <td class="">{!! $value['first_majority_race'] !!}</td>
                        <td class="">{{$value['second_program']}}</td>
                        <td class="">{!! $value['second_majority_race'] !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="table-responsive text-center"><p>No records found.</div>
    @endif
</div>