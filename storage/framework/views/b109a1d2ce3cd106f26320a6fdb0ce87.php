
<?php $__env->startSection('title'); ?>Eligibility Checking | <?php echo e(config('app.name', 'LeanFrogMagnet')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Eligibility Checking - <?php echo e(getApplicationName($application_id)); ?></div>
            <div class=""><a class=" btn btn-secondary btn-sm" href="<?php echo e(url('/admin/EligibilityChecker')); ?>" title="Go Back">Go Back</a></div>
            </div>
        </div>
    </div>
    
      <div class="tab-pane fade show" id="preview03" role="tabpanel" aria-labelledby="preview03-tab">  
        <div class="card shadow">
            <div class="card-body">
                    <div class="tab-pane fade show active" id="preview02" role="tabpanel" aria-labelledby="preview02-tab">
                        <div class="">
                            
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th class="align-middle">Program Name</th>
                                        <?php $__currentLoopData = $eligibility_templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="align-middle"><?php echo e($value->name); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                    </thead>
                                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkey=>$pvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class=""><?php echo e(getProgramName($pvalue->program_id)); ?></td>
                                            <?php $__currentLoopData = $eligibility_templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pekey=>$pevalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class=""><?php echo e($program_eligibilities[$pvalue->program_id][$pevalue->id]); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
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
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/EligibilityChecker/Views/eligibiility_data.blade.php ENDPATH**/ ?>