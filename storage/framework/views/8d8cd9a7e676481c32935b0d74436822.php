
<?php $__env->startSection('title'); ?>Eligibility Checking | <?php echo e(config('app.name', 'LeanFrogMagnet')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Eligibility Checking</div></div>
        </div>
    </div>
    
      <div class="tab-pane fade show" id="preview03" role="tabpanel" aria-labelledby="preview03-tab">  
        <div class="card shadow">
            <div class="card-body">
                    <div class="tab-pane fade show active" id="preview02" role="tabpanel" aria-labelledby="preview02-tab">
                        <div class="">
                            
                            <div class="form-group">
                                <label for="">Select Application Form : </label>
                                <div class="">
                                    <select class="form-control custom-select" id="form_field" name="form_field">
                                        <option value="">Select</option>
                                        <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value->id); ?>"><?php echo e($value->application_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            
                            <div class="text-right"><input type="button" class="btn btn-success" title="Select Form" value="Select Application" id="selectform_settings"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">

    $("#selectform_settings").click(function()
    {
        if($("#form_field").val() == "")
        {
            alert("Please select application")
            $("#form_field").focus();
            return false;
        }
        document.location.href = "<?php echo e(url('/admin/EligibilityChecker/application/')); ?>/"+$("#form_field").val();
    })
     
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/EligibilityChecker/Views/index.blade.php ENDPATH**/ ?>