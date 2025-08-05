<?php        
    if(isset($eligibility))
    {
        $content = json_decode($eligibility->content) ?? null;
        $scoring = json_decode($eligibility->content)->scoring ?? null;
        /*print_r($scoring);
        echo "<br><hr>";
        print_r($content);exit;*/
    }
    $label = "";
    if(isset($scoring->method))
        if($scoring->method == "YN")
            $label = " - Yes/No";
        elseif($scoring->method == "DD")
            $label = " - Data Display";
        elseif($scoring->method == "NR")
            $label = " - Numeric Ranking";
?>

<?php if(isset($scoring->type) && $scoring->type == "GA"): ?>
<div class="card shadow">
    <div class="card-header">Grade Average<?php echo e($label); ?></div>
    <div class="card-body">
        <div class="form-group row">
            <label class="control-label col-12 col-md-12">Grade Average Score : </label>
            <div class="<?php if(isset($scoring->method) && $scoring->method == "DD"): ?> col-12 col-md-12 <?php else: ?> col-6 col-md-6 <?php endif; ?>">
                <input type="text" class="form-control" value="">
            </div>
            <?php if(isset($scoring->method) && $scoring->method != "DD"): ?>
            <div class="col-6">
                <select class="form-control custom-select">
                    <?php if($scoring->method == "YN"): ?>
                        <?php $__currentLoopData = $scoring->YN; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value=""><?php echo e($single ?? ""); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <?php if($scoring->method == "NR"): ?>
                        <?php $__currentLoopData = $scoring->NR; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value=""><?php echo e($single ?? ""); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if(isset($scoring->type) && $scoring->type == "DD"): ?>

    <?php if(isset($content->terms_pulled[0]) && isset($content->subjects)): ?>
        <?php $total_year = $content->terms_pulled[0] ?>
        <?php $subjects = Config::get('variables.subjects') ?>
        <?php for($i=1; $i <= $total_year; $i++): ?>
            <div class="card shadow">
                    <div class="card-header">Year - <?php echo e((date("Y")-$i)."-".(date("Y")-($i-1))); ?></div>
                    <div class="card-body d-flex">
                        <?php $__currentLoopData = $content->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $content->terms_calc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-group row mr-10">
                                    <label class="control-label col-12 col-md-12"><?php echo e($subjects[$value]); ?> - <?php echo e($value1); ?> </label>
                                    <div class="col-12 col-md-12">
                                        <input type="text" class="form-control" value="">
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            
        <?php endfor; ?>
    <?php endif; ?>

<?php endif; ?>
<?php if(isset($scoring->type) && $scoring->type == "GPA"): ?>
<div class="card shadow">
    <div class="card-header">GPA<?php echo e($label); ?></div>
    <div class="card-body">
        <div class="form-group row">
            
            <div class="card-body d-flex align-items-start">
                <div class="form-group row mr-10">
                    <label class="control-label col-12 col-md-12">A </label>
                    <div class="col-12 col-md-12 mb-10">
                        <input type="text" class="form-control" value="<?php echo e($content->GPA->A ?? ""); ?>">
                    </div>
                    <?php if(isset($scoring->method) && $scoring->method != "DD"): ?>
                        <div class="col-12">
                            <select class="form-control custom-select">
                                <?php if($scoring->method == "YN"): ?>
                                    <?php $__currentLoopData = $scoring->YN; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value=""><?php echo e($single ?? ""); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <?php if($scoring->method == "NR"): ?>
                                    <?php $__currentLoopData = $scoring->NR; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value=""><?php echo e($single ?? ""); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group row mr-10">
                    <label class="control-label col-12 col-md-12">B </label>
                    <div class="col-12 col-md-12">
                        <input type="text" class="form-control" value="<?php echo e($content->GPA->B ?? ""); ?>">
                    </div>
                </div>
                <div class="form-group row mr-10">
                    <label class="control-label col-12 col-md-12">C </label>
                    <div class="col-12 col-md-12">
                        <input type="text" class="form-control" value="<?php echo e($content->GPA->C ?? ""); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="control-label col-12 col-md-12">D </label>
                    <div class="col-12 col-md-12">
                        <input type="text" class="form-control" value="<?php echo e($content->GPA->D ?? ""); ?>">
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<?php endif; ?>
<?php if(isset($scoring->type) && $scoring->type == "CLSG"): ?>
<div class="card shadow">
    <div class="card-header">Counts of Letters / Standard Grades<?php echo e($label); ?></div>
    <div class="card-body">
        <div class="form-group row">
            <label class="control-label col-12 col-md-12">Counts of Letters / Standard Grades : :</label>
            <div class="<?php if(isset($scoring->method) && $scoring->method == "DD"): ?> col-12 col-md-12 <?php else: ?> col-6 col-md-6 <?php endif; ?>">
                <input type="text" class="form-control" value="">
            </div>
            <?php if(isset($scoring->method) && $scoring->method != "DD"): ?>
            <div class="col-6">
                <select class="form-control custom-select">
                    <?php if($scoring->method == "YN"): ?>
                        <?php $__currentLoopData = $scoring->YN; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value=""><?php echo e($single ?? ""); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <?php if($scoring->method == "NR"): ?>
                        <?php $__currentLoopData = $scoring->NR; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value=""><?php echo e($single ?? ""); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Eligibility/Views/EligibilityView/academic_grade_calculation.blade.php ENDPATH**/ ?>