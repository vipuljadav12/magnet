<?php
    if(isset($eligibility))
    {
        // $allow_spreadsheet = json_decode($eligibility->content)->allow_spreadsheet ?? null;
        $mainContent = json_decode($eligibility->content);
        // print_r($mainContent);
    }
?>
<div class="card shadow">
<div class="card-header"><?php echo e($eligibility->name); ?></div>
<div class="card-body">
    <?php if(isset($mainContent->header)): ?>
        <?php $__currentLoopData = $mainContent->header; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h=>$header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card show">
                        <div class="card-header">
                            <?php echo e($header->name); ?>

                        </div>
                        <div class="card-body">
                            <div class="row" style="1border:1px solid red;">
                                <div class="col-6">
                                    <h6 class="text-center"><strong>Questions</strong></h6>
                                </div>
                                <div class="col-6">
                                    <h6 class="text-center"><strong>Options</strong></h6>
                                </div>
                                <?php $__empty_1 = true; $__currentLoopData = $header->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q=>$question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="col-6" style="1border:1px green solid;">
                                        <p class="form-control"><?php echo e($question->name); ?></p>
                                    </div>
                                    <div class="col-6">
                                        <?php
                                            $options = $question->options ?? null;
                                        ?>
                                        <?php if(isset($options)): ?>
                                            <select class="form-control">
                                                <?php $__empty_2 = true; $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o=>$option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                    <option><?php echo e($option); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                <?php endif; ?>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
</div><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Eligibility/Views/EligibilityView/template2.blade.php ENDPATH**/ ?>