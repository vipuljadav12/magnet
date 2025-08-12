<div class="card shadow">
    <div class="card-header"><?php echo e($eligibility->name); ?></div>
    <div class="card-body">
        <div class="form-group custom-none">

            <div class="">
                <select class="form-control custom-select template-type" name="extra[eligibility_type][type]">
                    <option value="">Select Option</option>
                    <?php if(json_decode($eligibility->content)->eligibility_type->type=='YN'): ?>
                        <?php $__empty_1 = true; $__currentLoopData = json_decode($eligibility->content)->eligibility_type->YN; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <option><?php echo e($yn); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php $__empty_1 = true; $__currentLoopData = json_decode($eligibility->content)->eligibility_type->NR; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <option><?php echo e($nr); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Eligibility/Views/EligibilityView/audition.blade.php ENDPATH**/ ?>