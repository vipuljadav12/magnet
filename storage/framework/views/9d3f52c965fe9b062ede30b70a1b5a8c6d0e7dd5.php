<?php $__env->startSection('title'); ?>Population Changes of of <?php echo e(getApplicationName($application_id)); ?> <?php $__env->stopSection(); ?>
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
            <div class="page-title mt-5 mb-5">Population Changes - <span class="text-danger"><?php echo e(getApplicationName($application_id)); ?></span></div>
            <div class="text-right"><a href="<?php echo e(url('/admin/Process/Selection')); ?>" class="btn btn-secondary">Change Application</a></div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist"> 
                <li class="nav-item"><a class="nav-link" id="preview02-tab" data-toggle="tab" href="#preview02" role="tab" aria-controls="preview02" aria-selected="true">Settings</a></li> 
                <li class="nav-item"><a class="nav-link" id="preview03-tab" data-toggle="tab" href="#preview03" role="tab" aria-controls="preview03" aria-selected="true">Program Max Percent Swing</a></li> 
                <li class="nav-item"><a class="nav-link active" id="preview04-tab" data-toggle="tab" href="#preview04" role="tab" aria-controls="preview04" aria-selected="true">Population Changes</a></li> 
                <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/admin/Process/Selection/Results/Application/'.$application_id)); ?>">Submissions Result</a></li> 
            </ul> 
            <div class="tab-content bordered" id="myTabContent">
                <div class="tab-pane fade show" id="preview02" role="tabpanel" aria-labelledby="preview02-tab">
                    <?php echo $__env->make('ProcessSelection::Template.acceptance_window', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                </div> 
                <div class="tab-pane fade show" id="preview03" role="tabpanel" aria-labelledby="preview03-tab">
                    <?php echo $__env->make('ProcessSelection::Template.program_max', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                </div>
                <?php echo $__env->make('ProcessSelection::Template.population_changes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
            </div> 
        
            
        </div> 
    </div> 
    <?php if($display_outcome == 0): ?> 
        </form>  
    <?php endif; ?>   
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('scripts'); ?> 
    <div id="wrapperloading" style="display:none;">
        <div id="loading">
            <i class='fa fa-spinner fa-spin fa-4x'></i> <br> Committing submission status.<br>It will take approx 2 minutes to update all records. 
        </div>
    </div> 
    <script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/dataTables.buttons.min.js"></script>
    <script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/buttons.html5.min.js"></script>
    <?php echo $__env->make("ProcessSelection::common_js", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
    <script type="text/javascript"> 
        var dtbl_submission_list = $("#tbl_population_changes").DataTable(
                                    {   "aaSorting": [], 
                                        dom: 'Bfrtip', 
                                        fixedHeader: { relativeScroll: true }, 
                                        bPaginate: false,
                                        bSort: false, 
                                        buttons: [ { 
                                                    extend: 'excelHtml5', 
                                                    title: 'PopulationChanges',
                                                    text:'Export to Excel' 
                                                    } 
                                                    ] 
                                    });

            $("#ExportReporttoExcel").on("click", function() {
                dtbl_submission_list.button( '.buttons-excel' ).trigger();
            });

            
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