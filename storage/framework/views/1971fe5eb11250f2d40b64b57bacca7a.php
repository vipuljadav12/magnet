<?php $__env->startSection('title'); ?>
    Selection Report Master
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
</style>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Report</div>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <form class="">
                <div class="form-group">
                    <label for="">Select Application: </label>
                    <div class="">
                        <select class="form-control custom-select" id="application_id">
                            <option value="">Select Application</option>
                            <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value->id); ?>"><?php echo e($value->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Processing Type: </label>
                    <div class="">
                        <select class="form-control custom-select" id="processing_type">
                            <option value="None">Select Processing Type</option>
                            <option value="">Regular Processing</option>
                            <option value="Waitlist">Waitlist Processing</option>
                            <option value="late_submission">Late Submissions Processing</option>
                        </select>
                    </div>
                </div>
                
                <div class=""><a href="javascript:void(0);" onclick="showApplicationReport()" class="btn btn-success generate_report" title="Generate Report">Generate Report</a></div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        function showApplicationReport()
        {
            if($("#application_id").val() == "")
            {
                alert("Please select application");
            }
            else if($("#processing_type").val() == "None")
            {
                alert("Please select Processing Type");
            }
            else
            {
                var val = $("#processing_type").val();
                if(val == "")
                    var link = "<?php echo e(url('/')); ?>/admin/Reports/Selection/"+$("#application_id").val();
                else if(val == "Waitlist")
                    var link = "<?php echo e(url('/')); ?>/admin/Waitlist/Admin/Selection/"+$("#application_id").val();
                else
                    var link = "<?php echo e(url('/')); ?>/admin/LateSubmission/Admin/Selection/"+$("#application_id").val();
                document.location.href = link;
            }
        }
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Reports/Views/application_index.blade.php ENDPATH**/ ?>