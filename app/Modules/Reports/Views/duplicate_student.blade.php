@extends('layouts.admin.app')
@section('title')
    Duplicate Student Report
@endsection
@section('styles')
<style type="text/css">
    .alert1 {
        position: relative;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
        border-radius: 0.25rem;
    }
    .custom-select2{
    margin: 5px !important;
}
.dt-buttons {position: absolute !important; padding-top: 5px !important;}

</style>
<link href="{{url('/resources/assets/admin/css/buttons.dataTables.min.css')}}" rel="stylesheet" />

@endsection
@section('content')

<div class="card shadow">
    <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
        <div class="page-title mt-5 mb-5"> Student Duplicate Report</div>
        <div class=""><a class=" btn btn-secondary btn-sm" href="{{url('/admin/Reports/missing')}}" title="Go Back">Go Back</a></div>

    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <form class="">
            <div class="form-group d-none">
                <label for="">Enrollment Year : </label>
                <div class="">
                    <select class="form-control custom-select" id="enrollment">
                        <option value="">Select Enrollment Year</option>
                        @foreach($enrollment as $key=>$value)
                            <option value="{{$value->id}}" @if($enrollment_id == $value->id) selected @endif>{{$value->school_year}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="">Report : </label>
                <div class="">
                    <select class="form-control custom-select" id="reporttype">
                        <option value="">Select Report</option>
                        <option value="offerstatus">Offer Status Report</option>
                        <option value="student" selected>Student Duplicate Report</option>
                        <option value="courtreport">Court Report</option>
                        <option value="magnet_marketing_report">Magnet Marketing report</option>  
                        <option value="programstatus">Program Status Report</option>
                    </select>
                </div>
            </div>
            <div class=""><a href="javascript:void(0);" onclick="showReport()" title="Generate Report" class="btn btn-success generate_report">Generate Report</a></div>
        </form>
    </div>
</div>
<div class="card shadow">
        <div class="card-body">
            <div class="row col-md-12 pull-left pb-10">
                <select class="form-control custom-select" onchange="reloadData(this.value)"> 
                    <option value="0" @if($type==0) selected @endif>Submissions</option>
                    <option value="1" @if($type==1) selected @endif>Late Submissions</option>
                </select>
            </div>

            <div class="row col-md-12 pull-left" id="submission_filters"></div>

            @if(!empty($dispData))
            <div class="table-responsive">
                <table class="table table-striped mb-0" id="datatable">
                    <thead>
                        <tr>
                            <th class="align-middle">#</th>
                            <th class="align-middle">Submission ID</th>
                            <th class="align-middle">State ID</th>
                            <th class="align-middle">First Name</th>
                            <th class="align-middle">Last Name</th>
                            <th class="align-middle">Next Grade</th>
                            <th class="align-middle">Current School</th>
                            <th class="align-middle">Program Choice 1</th>
                            <th class="align-middle">Program Choice 2</th>
                            <th class="align-middle">Status</th>
                            <th class="align-middle">Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @foreach($dispData as $key=>$value)
                            @php $count = 0 @endphp
                            @foreach($value as $skey=>$svalue)
                                <tr>
                                    {{-- @if($count == 0) --}}
                                        <td class="text-center" style="vertical-align: middle;" rowspan="{{count($value)}}">{{$key+1}}</td>
                                    {{-- @endif --}}
                                    <td class="text-center"><a href="{{url('/')}}/admin/Submissions/edit/{{$svalue['submission_id']}}">{{$svalue['submission_id']}}</a></td>
                                    <td class="text-center">{{$svalue['student_id']}}</td>
                                    <td class="text-center">{{$svalue['first_name']}}</td>
                                    <td class="text-center">{{$svalue['last_name']}}</td>
                                    <td class="text-center">{{$svalue['next_grade']}}</td>
                                    <td class="text-center">{{$svalue['current_school']}}</td>
                                    <td class="text-center">{{$svalue['first_program']}}</td>
                                    <td class="text-center">{{$svalue['second_program']}}</td>
                                    <td class="text-center">
                                        @if($svalue['submission_status']  == "Active" || $svalue['submission_status'] == "Offered and Accepted")
                                            @php $class = "alert-success" @endphp
                                        @elseif($svalue['submission_status'] == "Auto Decline")
                                            @php $class = "alert-secondary" @endphp
                                        @elseif($svalue['submission_status'] == "Application Withdrawn" || $svalue['submission_status'] == "Offered and Declined" || $svalue['submission_status'] == "Denied due to Ineligibility")
                                            @php $class = "alert-danger" @endphp
                                        @elseif($svalue['submission_status'] == "Denied due to Incomplete Records")
                                            @php $class = "alert-info" @endphp
                                        @else
                                            @php $class = "alert-warning" @endphp
                                        @endif
                                        <div class="alert1 {{$class}} p-10 text-center d-block">{{$svalue['submission_status']}}</div>
                                    </td>
                                    <td class="text-center">{{$svalue['created_at']}}</td>
                                </tr>
                                @php $count++ @endphp
                            @endforeach
                        @endforeach

                    </tbody>
                </table>
            </div>
            @else
                <div class="table-responsive text-center"><p>No Records found.</div>
            @endif
        </div>
    </div>
    

@endsection
@section('scripts')
 <div id="wrapperloading" style="display:none;"><div id="loading"><i class='fa fa-spinner fa-spin fa-4x'></i> <br> Committing submission status.<br>It will take approx 2 minutes to update all records. </div></div>
<script src="{{url('/resources/assets/admin')}}/js/bootstrap/dataTables.buttons.min.js"></script>
<script src="{{url('/resources/assets/admin')}}/js/bootstrap/buttons.html5.min.js"></script>
<script src="{{url('/resources/assets/admin')}}/js/bootstrap/dataTables.rowsGroup.js"></script>
{{-- <script type="text/javascript" src="{{ url('/') }}/resources/assets/admin/plugins/datatables/dataTables.rowsGroup.js"></script> --}}

<script type="text/javascript">
    // var dtbl_submission_list = $("#datatable").DataTable({
    //     "columnDefs": [
    //         {"className": "dt-center", "targets": "_all"}
    //     ],
    //     "rowsGroup":[0]
    // });

    var dtbl_submission_list = $("#datatable").DataTable({"aaSorting": [],
        dom: 'Bfrtip',
        // bPaginate: false,
         bSort: false,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'DuplicateStudents',
                text:'Export to Excel'
            }
        ],
        "rowsGroup":[0]
    });   

    function showReport()
    {
        if($("#enrollment2").val() == "")
        {
            alert("Please select enrollment year");
        }
        else if($("#reporttype").val() == "")
        {
            alert("Please select report type");
        }
        else if($("#reporttype").val() == "courtreport")
        {
            var link = "{{url('/')}}/admin/Reports/"+$("#reporttype").val()+"/"+$("#enrollment2").val();
            document.location.href = link;
        }
        else
        {
            var link = "{{url('/')}}/admin/Reports/missing/"+$("#enrollment2").val()+"/"+$("#reporttype").val();
            document.location.href = link;
        }
    }

    function reloadData(val)
    {
        var link = "{{url('/')}}/admin/Reports/missing/{{Session::get("enrollment_id")}}/duplicatestudent/"+val;
        document.location.href = link;
    }
</script>

@endsection