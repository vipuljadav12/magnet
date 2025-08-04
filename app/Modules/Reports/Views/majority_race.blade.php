@extends('layouts.admin.app')
@section('title')
	Majority Race Report
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
            <div class="page-title mt-5 mb-5">Majority Race Report</div>
        </div>
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


        
        $("#wrapperloading").show();
        var  url = "{{url()->current()}}/response";
        $.ajax({
            type: 'get',
           // data: {"_token": "{{ csrf_token() }}", "enrollment_id": $("#enrollment2").val()},
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
                            title: 'Majority Race Report',
                            text:'Export to Excel',
                        }
                    ]
                });
            }
        });
        $("#wrapperloading").hide();
    
	</script>

@endsection