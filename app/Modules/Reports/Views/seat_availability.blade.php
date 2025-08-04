@extends('layouts.admin.app')
@section('title')
	Seat Availability Report
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
.dtbl_hide {
    display: none;
}
</style>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Seat Availability Report</div></div>
    </div>
    <div class="card shadow">
        @include("Reports::display_report_options", ["selection"=>$selection, "enrollment"=>$enrollment, "enrollment_id"=>$enrollment_id])

    </div>

    <div class="">
        <div class="tab-pane fade show active" id="grade1" role="tabpanel" aria-labelledby="grade1-tab">
                        <div class="">
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
        loadSubmissionData();
        function loadSubmissionData(program='')
        {
            $("#wrapperloading").show();
            var  url = "{{url('admin/Reports/missing/'.$enrollment_id.'/')}}/seat_availability/response";
            $.ajax({
                type: 'get',
                dataType: 'JSON',
                url: url,
                async: false,
                data: {
                    program
                },
                success: function(response) {
                    $("#response").html(response.html);
                    var dtbl_submission_list = $("#tbl_data").DataTable(
                        {
                            dom: 'B',
                            buttons: [
                                { 
                                    extend: 'excel', 
                                    text: 'Export to Excel',
                                    title: getSelectedProgramTitle().replace('|', '-')
                                }
                            ],
                            'columnDefs': [ {
                                'targets': [0,1,2,3,4],
                                'orderable': false
                            }],
                            sorting: false
                        }
                    );
                    setProgramHeader();
                },
                error: function() {
                    alert('Something went wrong, please try again.');
                }
            });
            setTimeout(function() {
                $("#wrapperloading").hide();
            }, 100)
        }

        function setProgramHeader() {
            $(document).find('#program_header').html(getSelectedProgramTitle());
        }
        function getSelectedProgramTitle() {
            return $('#select_program option:selected').text();
        }

        $(document).on('change', '#select_program', function() {
            loadSubmissionData($(this).val());
        });

	</script>

@endsection