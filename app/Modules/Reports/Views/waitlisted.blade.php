@extends('layouts.admin.app')
@section('title')
    Program Status Report
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
.dt-buttons{position: absolute;}
</style>
@endsection
@section('content')

<div class="card shadow">
    <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
        <div class="page-title mt-5 mb-5">Program Status Report</div></div>
</div>

<div class="card shadow">
    <div class="card-body">
        <form class="">
            <div class="form-group">
                <label for="">Enrollment Year : </label>
                <div class="">
                    <select class="form-control custom-select" id="enrollment2">
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
                        <option value="duplicatestudent">Student Duplicate Report</option>
                        <option value="courtreport">Court Report</option>                        
                        <option value="magnet_marketing_report">Magnet Marketing report</option>  
                        <option value="programstatus" selected>Program Status Report</option>  
                    </select>
                </div>
            </div>
            <div class=""><a href="javascript:void(0);" onclick="showReport()" title="Generate Report" class="btn btn-success generate_report">Generate Report</a></div>
        </form>
    </div>
</div>

<div class="">
    <div class="tab-content bordered" id="myTabContent">
        <div class="tab-pane fade show active" id="needs1" role="tabpanel" aria-labelledby="needs1-tab">
            
            <div class="tab-content" id="myTabContent1">
                <div class="tab-pane fade show active" id="grade1" role="tabpanel" aria-labelledby="grade1-tab">
                    <div class="">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label">Select Program : </label>
                                    <div class="">
                                        <select class="form-control custom-select valid" id="program" aria-invalid="false">
                                            <option value="">Select an Option</option>
                                            @forelse($data['programs'] as $program)
                                                <option value="{{$program->id}}">{{$program->name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Select Specific Grade : </label>
                                    <div class="">
                                        <select class="form-control custom-select valid" id="grade" aria-invalid="false">
                                            <option value="">Select an Option</option>
                                            @forelse($data['grades'] as $grade)
                                                <option value="{{$grade->name}}">{{$grade->name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Select Status : </label>
                                    <div class="">
                                        <select class="form-control custom-select valid" id="status" aria-invalid="false">
                                            <option value="">Select an Option</option>
                                            @forelse($data['submission_status'] as $status)
                                                <option value="{{$status}}">{{$status}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <button title="Generate Report" onclick="generateReport()" class="btn btn-success">Generate</button>
                                </div>
                                <div class="" id="response"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="wrapperloading" style="display:none;"><div id="loading"><i class='fa fa-spinner fa-spin fa-4x'></i> <br> Process is started.<br>It will take approx 2 minutes to finish. </div></div>
@endsection
@section('scripts')
<script src="{{url('/resources/assets/admin')}}/js/bootstrap/dataTables.buttons.min.js"></script> 
<script src="{{url('/resources/assets/admin')}}/js/bootstrap/buttons.html5.min.js"></script> 
<script type="text/javascript">
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

    function generateReport() {
        if($("#enrollment2").val() == "")
        {
            $("#response").html('');
            alert("Please select enrollment year");
            return false;
        }
        $("#wrapperloading").show();
        var  url = "{{url()->current()}}/response";
        $.ajax({
            type: 'post',
            data: {"program": $("#program").val(), "grade": $("#grade").val(), "status": $("#status").val(), "_token": "{{ csrf_token() }}", "enrollment_id": $("#enrollment2").val()},
            dataType: 'JSON',
            url: url,
            async: false,
            success: function(response) {
                $("#response").html(response.html);
                var dtbl_submission_list = $("#datatable").DataTable({"aaSorting": [],
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            title: 'Waitlisted Report',
                            text:'Export to Excel',
                        }
                    ]
                });
            }
        });
        $("#wrapperloading").hide();
    }
</script>
@endsection