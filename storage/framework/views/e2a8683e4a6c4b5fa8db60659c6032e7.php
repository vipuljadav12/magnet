<?php 
    if(isset($eligibilityContent))
    {
        $allow_spreadsheet = json_decode($eligibilityContent->content)->allow_spreadsheet ?? null;
        $content = json_decode($eligibilityContent->content)->eligibility_type;
    }
?>
<div class="form-group template-option-1">
    <label class="control-label">Name of Test Score : </label>
    <div class="">
    	<input type="text" class="form-control" value="<?php echo e($eligibility->name ?? old('name')); ?>" name="name">
    </div>
</div>
<div class="form-group">
    <label class="control-label">How Many Textbox for Scores Required : </label>
    <div class="">
        <input type="text" class="form-control" name="extra[eligibility_type][box_count]" <?php if(isset($content->box_count)): ?> value="<?php echo e($content->box_count[0]); ?>" <?php endif; ?>>
    </div>
</div>

<div class="form-group custom-none">
    <label class="control-label">Eligibility Type : </label>
    <div class="">
        <select class="form-control custom-select template-type" name="extra[eligibility_type][type]">
            <option value="">Select Option</option>
            <option value="NR" <?php if(isset($content->type) && $content->type == "NR"): ?> selected <?php endif; ?>>Numeric Ranking</option>
        </select>   
    </div>
</div>
<div class="template-type-2 <?php if(isset($content->type) && $content->type == "NR"): ?> <?php else: ?>  d-none <?php endif; ?>">
    <?php if(isset($content) && isset($content->NR)): ?>
        <?php $__currentLoopData = $content->NR; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="form-group">
                <label class="">Numeric Ranking <?php echo e($k+1); ?> : </label>
                <div class="">
                    <input type="text" class="form-control" name="extra[eligibility_type][NR][]" value="<?php echo e($n); ?>">
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="form-group">
            <label class="">Numeric Ranking 1 : </label>
            <div class=""><input type="text" class="form-control" name="extra[eligibility_type][NR][]"></div>
        </div>
        <div class="form-group">
            <label class="">Numeric Ranking 2 : </label>
            <div class=""><input type="text" class="form-control" name="extra[eligibility_type][NR][]"></div>
        </div>
        <div class="form-group">
            <label class="">Numeric Ranking 3 : </label>
            <div class=""><input type="text" class="form-control" name="extra[eligibility_type][NR][]"></div>
        </div>
        <div class="form-group">
            <label class="">Numeric Ranking 4 : </label>
            <div class=""><input type="text" class="form-control" name="extra[eligibility_type][NR][]"></div>
        </div>
    <?php endif; ?>
    <div class="mb-20"><a href="javascript:void(0);" class="font-18 add-ranking-13" title=""><i class="far fa-plus-square"></i></a></div>
</div>

<?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Eligibility/Views/templates/test_score.blade.php ENDPATH**/ ?>