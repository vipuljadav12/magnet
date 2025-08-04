<?php $__env->startSection('title'); ?>Submission Results of <?php echo e(getApplicationName($application_id)); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
    .buttons-excel{display: none !important;}
</style>
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
  <style id="compiled-css" type="text/css">
      #table-wrap {
  margin: 10px;
  height: 400px;
  overflow: auto;
}
    /* EOS */
  </style>
  <?php if($display_outcome == 0): ?>
    <form action="<?php echo e(url('admin/Process/Selection/store')); ?>" method="post" name="process_selection" id="process_selection">
    <?php echo e(csrf_field()); ?>

        <input type="hidden" name="application_id" value="<?php echo e($application_id); ?>" id="application_id">
    <?php endif; ?>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Submission Results - <span class="text-danger"><?php echo e(getApplicationName($application_id)); ?></span></div>
            <div class="text-right"><a href="<?php echo e(url('/admin/Process/Selection')); ?>" class="btn btn-secondary">Change Application</a></div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
    
    
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item"><a class="nav-link" id="preview02-tab" data-toggle="tab" href="#preview02" role="tab" aria-controls="preview02" aria-selected="true">Settings</a></li>
            <li class="nav-item"><a class="nav-link" id="preview03-tab" data-toggle="tab" href="#preview03" role="tab" aria-controls="preview03" aria-selected="true">Program Max Percent Swing</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/admin/Process/Selection/Population/Application/'.$application_id)); ?>">Population Changes</a></li>
            <li class="nav-item"><a class="nav-link active" id="preview04-tab" data-toggle="tab" href="#preview04" role="tab" aria-controls="preview04" aria-selected="true">Submissions Result</a></li>
        </ul>
        <div class="tab-content bordered" id="myTabContent">
            <div class="tab-pane fade show" id="preview02" role="tabpanel" aria-labelledby="preview02-tab">
                <?php echo $__env->make('ProcessSelection::Template.acceptance_window', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="tab-pane fade show" id="preview03" role="tabpanel" aria-labelledby="preview03-tab">
                <?php echo $__env->make('ProcessSelection::Template.program_max', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <?php echo $__env->make('ProcessSelection::Template.submissions_result', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        
    </div>
</div>
<?php if($display_outcome == 0): ?>
    </form> 
    <?php endif; ?>   
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <div id="wrapperloading" style="display:none;"><div id="loading"><i class='fa fa-spinner fa-spin fa-4x'></i> <br> Committing submission status.<br>It will take approx 2 minutes to update all records. </div></div>
<script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/dataTables.buttons.min.js"></script>
<script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/buttons.html5.min.js"></script>

<?php echo $__env->make("ProcessSelection::common_js", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script type="text/javascript">
        var dtbl_submission_list = $("#tbl_submission_results").DataTable({"aaSorting": [],
             dom: 'Bfrtip',
             bPaginate: false,
             bSort: false,
             buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Submissions-Results',
                        text:'Export to Excel',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    }
                ]
            });

            $("#ExportReporttoExcel").on("click", function() {
                dtbl_submission_list.button( '.buttons-excel' ).trigger();
            });

             $("#tbl_submission_results thead th").each( function ( i ) {
            // Disable dropdown filter for disalble_dropdown_ary (index=0)
            var disalble_dropdown_ary = [0, 1, 5, 6, 7, 8, 9];//13



                if ($.inArray(i, disalble_dropdown_ary) == -1) {
                    var column_title = $(this).text();
                    
                    var select = $('<select class="form-control col-md-3 custom-select custom-select2"><option value="">Select '+column_title+'</option></select>')
                        .appendTo( $('#submission_filters') )
                        .on( 'change', function () {
                            dtbl_submission_list.column( i )
                                .search($(this).val())
                                .draw();
                        } );
                    
                    if(i == 2)
                    {
                        var gArr = new Array('PreK', 'K', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10');
                        var kArr = new Array();
                        dtbl_submission_list.column( i ).data().unique().sort().each( function ( d, j ) {
                            kArr[kArr.length] = d;
                        });
                        for(m=0; m < gArr.length; m++)
                        {
                            if($.inArray(gArr[m], kArr) >= 0)
                            {
                                 select.append( '<option value="'+gArr[m]+'">'+gArr[m]+'</option>' )
                            }
                        }


                    }
                    else
                    {
                        dtbl_submission_list.column( i ).data().unique().sort().each( function ( d, j ) {

                            str = d.replace('<div class="alert1 alert-success p-10 text-center d-block">', "");
                            str = str.replace('<div class="alert1 alert-danger p-10 text-center d-block">', "");
                            str = str.replace('<div class="alert1 alert-warning p-10 text-center d-block">', "");
                            str = str.replace('</div>', "");
                            select.append( '<option value="'+str+'">'+str+'</option>' )
                        } );
                    }
                }
            } );
            // Hide Columns
            dtbl_submission_list.columns([3, 4]).visible(false);

            
            function updateFinalStatus()
            {
                $("#wrapperloading").show();
                $.ajax({
                    url:'<?php echo e(url('/admin/Process/Selection/Accept/list')); ?>',
                    type:"post",
                    data: {"_token": "<?php echo e(csrf_token()); ?>", "application_id": $("#application_id").val()},
                    success:function(response){
                        alert("Status Allocation Done.");
                        $("#wrapperloading").hide();
                        document.location.reload();

                    }
                })
            }


    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>