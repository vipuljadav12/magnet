<div class='form-group form-group-input row col- buildBox<?php echo e($formContent->id); ?>' data-build-id="<?php echo e($formContent->id); ?>" id="<?php echo e($formContent->id); ?>">
    <div class="card-body table-responsive">
                <?php $disp_fields = getViewEnableFields($formContent->form_id) ?>
                <table class="table table-striped table-bordered">
            <tbody>
                <?php $__currentLoopData = $disp_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1=>$value1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="b-600 w-75"><?php echo e($value1->field_value); ?> :</td>
                            <td class="">
                            </td>
                        </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody></table>
                

            </div>
            <div>
        <a class="btn text-danger removeField"><i class="fa fa-times"></i></a>
    </div>
</div>