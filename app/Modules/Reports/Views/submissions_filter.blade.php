@extends('layouts.admin.app')
@section('title')
	Magnet Marketing report
@endsection
@section('content')
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
.dt-buttons {position: absolute !important; padding-top: 5px !important;}
</style>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Magnet Marketing report</div>
        </div>
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
                            <option value="magnet_marketing_report" selected>Magnet Marketing report</option>   
                            <option value="waitlisted">Waitlisted Report</option>
                        </select>
                    </div>
                </div>
                <div class=""><a href="javascript:void(0);" onclick="showReport()" title="Generate Report" class="btn btn-success generate_report">Generate Report</a></div>
            </form>
        </div>
    </div>


    <div class="">
            
            <div class="tab-pane fade show active" id="grade1" role="tabpanel" aria-labelledby="grade1-tab">
                            <div class="">
                                <div class="row col-md-12">
                                    <div class="col-md-4 pt-5 pb-5">
                                        <div class="row col-md-12">
                                            <label class="control-label col-md-12 display-inline-block pl-0">Select Zoned School</label>
                                            <select id="zoned_school" class="form-control col-md-12 display-inline-block">
                                                <option value="">All Zoned School</option>
                                                @foreach($zoned_school as $value)
                                                    <option value="{{$value->name}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 pt-5 pb-5">
                                        <div class="row col-md-12">
                                            <label class="control-label col-md-12 display-inline-block pl-0">Select Grade Level</label>
                                            <select id="grade_level" class="form-control col-md-12 display-inline-block">
                                                <option value="">All Grade Level</option>
                                                @foreach($grade_level as $value)
                                                    <option value="{{$value}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 pt-5 pb-5">
                                        <div class="row col-md-12">
                                            <label class="control-label col-md-12 display-inline-block pl-0">Select Program</label>
                                            <select id="program_id" class="form-control col-md-12 display-inline-block">
                                                <option value="">All Programs</option>
                                                @foreach($programs as $value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-4 pt-5 pb-5">
                                        <div class="row col-md-12">
                                            <label class="control-label col-md-12 display-inline-block pl-0">How did you hear about us ?</label>
                                            <select id="hear_us" class="form-control col-md-12 display-inline-block">
                                                <option value="">All</option>
                                                @foreach($hearUsQuestion as $value)
                                                    <option value="{{$value}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pt-5 pb-5">
                                        <div class="row col-md-12">
                                            <label class="control-label col-md-12 display-inline-block pl-0">&nbsp;</label>
                                            <div class="col-md-12 display-inline-block">
                                                <input type="button" class="form-control btn btn-primary" id="fetch_result" onclick="loadSubmissionData()" value="Search" />
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="card shadow" id="response">

                                </div>
                            </div>
                        </div>
        </div>
@endsection
@section('scripts')
        <div id="wrapperloading" style="display:none;"><div id="loading"><i class='fa fa-spinner fa-spin fa-4x'></i> <br> Process is started.<br>It will take approx 2 minutes to finish. </div></div>

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

        function loadSubmissionData()
        {
            $("#wrapperloading").show();
            var  url = "{{url('admin/Reports/missing/')}}/magnet_marketing_report/response";

            
            $.ajax({
                type: 'post',
                data: {"program_id": $("#program_id").val(), "grade_level": $("#grade_level").val(), "hear_us": $("#hear_us").val(), "zoned_school": $("#zoned_school").val(), "_token": "{{ csrf_token() }}", "enrollment_id": {{$enrollment_id}}},
                dataType: 'JSON',
                url: url,
                success: function(response) {

                        $("#response").html(response.html);
                        $("#wrapperloading").hide();
                        var dtbl_submission_list = $("#datatable").DataTable({"aaSorting": [],
                         dom: 'Bfrtip',
                         buttons: [
                                {
                                    extend: 'excelHtml5',
                                    title: 'Submissions',
                                    text:'Export to Excel',

                                    
                                }
                            ]
                        });

                    
       
                }
            });

        }
        //loadSubmissionData({{$late_submission}});

        
        function exportMissing()
        {
            if($("#filter_option").val() == "")
                document.location.href="{{url('/admin/Reports/export/'.$enrollment_id.'/missinggrade')}}/{{$late_submission}}";
            else
                document.location.href="{{url('/admin/Reports/export/'.$enrollment_id.'/missinggrade')}}/{{$late_submission}}/"+$("#filter_option").val();

        }
	</script>

@endsection