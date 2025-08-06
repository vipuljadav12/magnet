
<?php $__env->startSection('title'); ?>Configure Export Submission | <?php echo e(config('app.name', 'LeanFrogMagnet')); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow">
    <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
        <div class="page-title mt-5 mb-5">Configure Export Submission</div>
    </div>
</div>

<?php
    $fields_ary = config('variables.submission_export_fields') ?? [];
?>

<div class="card shadow">
    <div class="card-body">
        <?php echo $__env->make("layouts.admin.common.alerts", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <form action="<?php echo e(url($module_base)); ?>/update" method="post" id="exportSubmission">
            <?php echo e(csrf_field()); ?>

            <div class="form-group">
                <label for="">Fields to Export : </label>
                <div class="">
                    <div class="row flex-wrap program_grade">
                        <?php $__currentLoopData = $fields_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f_title => $f_key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $checked = '';
                                if (in_array($f_title, $export_fields)) {
                                    $checked = 'checked';
                                }
                                $key = str_replace(' ', '', $f_title);
                            ?>
                            <div class="col-12 col-sm-4 col-lg-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input fields" name="fields[]" value="<?php echo e($f_title); ?>" id="<?php echo e($key); ?>" <?php echo e($checked); ?>>
                                    <label class="custom-control-label" for="<?php echo e($key); ?>"><?php echo e($f_title); ?></label>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <div class=""><input type="submit" class="btn btn-success generate_report" value="Save"></div>
        </form>
    </div>
</div>

</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/ConfigureExportSubmission/Views/index.blade.php ENDPATH**/ ?>