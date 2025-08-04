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
            else
            {
                var link = "<?php echo e(url('/')); ?>/admin/Reports/Waitlist/Selection/"+$("#application_id").val();
                document.location.href = link;
            }
        }
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>