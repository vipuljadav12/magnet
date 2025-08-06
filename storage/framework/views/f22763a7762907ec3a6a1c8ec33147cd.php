<?php $__env->startSection('title'); ?>
	Report Section :: Magnet HCS
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
                    <label for="">Enrollment Year: </label>
                    <div class="">
                        <select class="form-control custom-select" id="enrollment2">
                            <option value="">Select Enrollment Year</option>
                            <?php $__currentLoopData = $enrollment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value->id); ?>"><?php echo e($value->school_year); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <option value="programstatus">Program Status Report</option>
                        </select>
                    </div>
                </div>
                <div class=""><a href="javascript:void(0);" onclick="showReport()" class="btn btn-success generate_report" title="Generate Report">Generate Report</a></div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
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
                var link = "<?php echo e(url('/')); ?>/admin/Reports/"+$("#reporttype").val()+"/"+$("#enrollment2").val();
                //alert(link);
                document.location.href = link;
            }
            else
            {
                var link = "<?php echo e(url('/')); ?>/admin/Reports/missing/"+$("#enrollment2").val()+"/"+$("#reporttype").val();
                document.location.href = link;
            }
        }
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Reports/Views/missing_index.blade.php ENDPATH**/ ?>