<?php 
    if(isset($eligibilityContent))
    {
        $allow_spreadsheet = json_decode($eligibilityContent->content)->allow_spreadsheet ?? null;
        $content = json_decode($eligibilityContent->content)->eligibility_type;
    }
?>
<div class="form-group template-option-1">
    <label class="control-label">Name of Committee Score : </label>
    <div class=""><input type="text" class="form-control" value="<?php echo e($eligibility->name ?? old('name')); ?>" name="name"></div>
</div>
<div class="form-group custom-none">
    <label class="control-label">Eligibility Type : </label>
    <div class="">
        <select class="form-control custom-select template-type" name="extra[eligibility_type][type]">
            <option value="">Select Option</option>
            <option value="YN" <?php if(isset($content->type) && $content->type == "YN"): ?> selected <?php endif; ?>>Yes/No</option>
            <option value="NR" <?php if(isset($content->type) && $content->type == "NR"): ?> selected <?php endif; ?>>Numeric Ranking</option>
        </select>   
    </div>
</div>
<div class="template-type-1 <?php if(isset($content->type) && $content->type == "YN"): ?> <?php else: ?>  d-none <?php endif; ?>">
    <div class="form-group">
        <label class="">Option 1 : </label>
        <div class=""><input type="text" class="form-control" name="extra[eligibility_type][YN][]" <?php if(isset($content->type) && $content->type == "YN"): ?> value="<?php echo e($content->YN[0 ]); ?>" <?php endif; ?>></div>
    </div>
    <div class="form-group">
        <label class="">Option 2 : </label>
        <div class=""><input type="text" class="form-control" name="extra[eligibility_type][YN][]" <?php if(isset($content->type) && $content->type == "YN"): ?> value="<?php echo e($content->YN[1]); ?>" <?php endif; ?>  ></div>
    </div>
</div>
<div class="template-type-2 <?php if(isset($content->type) && $content->type == "NR"): ?> <?php else: ?>  d-none <?php endif; ?>">
    <?php if(isset($content)): ?>
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
<div class="form-group custom-none">
    <label class="control-label">Allow for Spreadsheet Upload : </label>
    <div class="">
        <select class="form-control custom-select" name="extra[allow_spreadsheet]">
            <option value="">Select Option</option>
            <option value="Y" <?php echo e(isset($allow_spreadsheet) && $allow_spreadsheet =='Y' ? 'selected':''); ?>>Yes</option>
            <option value="N" <?php echo e(isset($allow_spreadsheet) && $allow_spreadsheet =='N' ? 'selected':''); ?>>No</option>
        </select>
    </div>
</div><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Eligibility/Views/templates/committee_score.blade.php ENDPATH**/ ?>