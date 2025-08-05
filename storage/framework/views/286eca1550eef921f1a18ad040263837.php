<?php 
    if(isset($eligibilityContent))
    {
        $content = json_decode($eligibilityContent->content) ?? null;
        $scoring = json_decode($eligibilityContent->content)->scoring ?? null;
        // print_r($scoring);
        // print_r($content->GPA);
    }
?>
<div class="form-group">
    <label class="control-label">Name of Academic Grade Calculation</label>
    <div class="">
		<input type="text" class="form-control" value="<?php echo e($eligibility->name ?? old('name')); ?>" name="name">
        <?php if($errors->first('name')): ?>
            <div class="mb-1 text-danger">
                
                Name is required.
            </div>
        <?php endif; ?>
	</div>
</div>    
       
<div class="form-group  template-option-4">
    <label class="control-label">What calculation method will be used for the grade calculation? :</label>
    <div class="">
        <select class="form-control custom-select " id="selectScoreTypeAGC" name="extra[scoring][type]">
            <?php 
                $types = array(
                    "GA"=>"Grade Average",
                    "GPA"=>"GPA",
                    "YWA"=>"Yearwise Average",
                    "CLSG" => "Grade Avg By Subject", //"Count of Letter/ Standards Grades",
                    "DD" => "Data Display"
                );//array ends
            ?>
            <option value="">Select Option</option>
            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($t); ?>" <?php if(isset($scoring->type) && $scoring->type == $t): ?> selected <?php endif; ?>><?php echo e($type); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>
<div class="ifGPA   <?php if(isset($scoring->type) && $scoring->type == "GPA"): ?> <?php else: ?> d-none <?php endif; ?>">
    <div class="form-group">
        <label class="">If GPA is used, what is the scale for : </label>
        <div class="d-flex flex-wrap">
                <div class="w-90 mb-10 mr-10">
                    <label class="">A (4)</label>
                    <input class="form-control" type="text" name="extra[GPA][A]" value="<?php echo e($content->GPA->A ?? ""); ?>">
                </div>
                <div class="w-90 mb-10 mr-10">
                    <label class="">B (3)</label>
                    <input class="form-control" type="text" name="extra[GPA][B]" value="<?php echo e($content->GPA->B ?? ""); ?>">
                </div>
                <div class="w-90 mb-10 mr-10">
                    <label class="">C (2)</label>
                    <input class="form-control" type="text" name="extra[GPA][C]" value="<?php echo e($content->GPA->C ?? ""); ?>">
                </div>
                <div class="w-90 mb-10 mr-10">
                    <label class="">D (1)</label>
                    <input class="form-control" type="text" name="extra[GPA][D]" value="<?php echo e($content->GPA->D ?? ""); ?>">
                </div>
        </div>
    </div>    
</div>   
<div class="template-type-0011 ifNotDD <?php if(isset($scoring->type) && $scoring->type != "DD"): ?> <?php else: ?> d-none <?php endif; ?>">
    <div class="form-group">
        <label class="control-label">What else will be assigned to the grade calculation?</label>
        <div class="">
            <select class="form-control custom-select template-type-select-new selectScoreMethodAGC" id="selectScoreMethodAGC" name="extra[scoring][method]">
                <?php 
                    $methods = array(
                        "YN"=>"Yes/No",
                        "NR"=>"Numeric Ranking",
                        "DD" => "Data Display"
                    );//array ends
                ?>
                <option value="">Select Option</option>
                <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m=>$method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($m); ?>" <?php if(isset($scoring->method) && $scoring->method == $m): ?> selected <?php endif; ?>><?php echo e($method); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>            
        </div>
    </div>    
</div>
<div class="<?php if(isset($scoring->method) && $scoring->method == "YN"): ?> <?php else: ?>  d-none <?php endif; ?> scoreTypeDiv scoreTypeYN">
    <div class="form-group">
        <label class="">Option 1 : </label>
        <div class=""><input type="text" class="form-control" name="extra[scoring][YN][]" <?php if(isset($scoring->method) && $scoring->method == "YN"): ?> value="<?php echo e($scoring->YN[0] ?? ""); ?>" <?php endif; ?>></div>
    </div>
    <div class="form-group">
        <label class="">Option 2 : </label>
        <div class=""><input type="text" class="form-control" name="extra[scoring][YN][]" <?php if(isset($scoring->method) && $scoring->method == "YN"): ?> value="<?php echo e($scoring->YN[1] ?? ""); ?>" <?php endif; ?>></div>
    </div>
</div>
<div class=" <?php if(isset($scoring->method) && $scoring->method == "NR"): ?> <?php else: ?>  d-none <?php endif; ?> scoreTypeDiv scoreTypeNR">
    <?php if(isset($scoring)): ?>
        <?php $__currentLoopData = $scoring->NR; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="form-group">
                <label class="">Numeric Ranking <?php echo e($k+1); ?> : </label>
                <div class="">
                    <input type="text" class="form-control" name="extra[scoring][NR][]" value="<?php echo e($n); ?>">
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="form-group">
            <label class="">Numeric Ranking 1 : </label>
            <div class=""><input type="tex  t" class="form-control" name="extra[scoring][NR][]"></div>
        </div>
        <div class="form-group">
            <label class="">Numeric Ranking 2 : </label>
            <div class=""><input type="text" class="form-control" name="extra[scoring][NR][]"></div>
        </div>
        <div class="form-group">
            <label class="">Numeric Ranking 3 : </label>
            <div class=""><input type="text" class="form-control" name="extra[scoring][NR][]"></div>
        </div>
        <div class="form-group">
            <label class="">Numeric Ranking 4 : </label>
            <div class=""><input type="text" class="form-control" name="extra[scoring][NR][]"></div>
        </div>
    <?php endif; ?>
    <div class="mb-20"><a href="javascript:void(0);" class="font-18 add-more-numeric-ranking-st" title=""><i class="far fa-plus-square"></i></a></div>
</div>
<div class="<?php if(isset($scoring->method) && $scoring->method == "YN"): ?> <?php else: ?>  d-none <?php endif; ?> scoreTypeDiv scoreTypeDD"></div>

<div class="form-group ifDD <?php if(isset($scoring->type) && ($scoring->type == "DD" || $scoring->type == "GA")): ?> <?php else: ?> d-none <?php endif; ?>">
    <label class="control-label">What Academic Year Need to Use for Grades Calculation ?</label>
    <div class="d-flex flex-wrap">
        <?php 
            $academic_year_ary = [];
            $current_year = date('Y');
            for ($i=0; $i < 5; $i++) { 
                $tmp_year = $current_year .'-'. substr( $current_year+1, 2);
                array_push($academic_year_ary, $tmp_year);
                $current_year--;
            }
            $i = 0;
        ?>
        <?php $__currentLoopData = $academic_year_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mr-20 col-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="academic_year_checkbox_calc_<?php echo e($i); ?>" value="<?php echo e($value); ?>" name="extra[academic_year_calc][]" <?php if(isset($content->academic_year_calc) && in_array($value, $content->academic_year_calc)): ?> checked <?php endif; ?>>
                <label for="academic_year_checkbox_calc_<?php echo e($i); ?>" class="custom-control-label"><?php echo e($value); ?></label></div>
            </div>
            <?php $i++ ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<div class="form-group ifDD <?php if(isset($scoring->type) && ($scoring->type == "DD" || $scoring->type == "GA")): ?> <?php else: ?> d-none <?php endif; ?>">
    <label class="control-label">Which Academic Term Need to Use for Grades Calculation ?</label>
    <div class="d-flex flex-wrap">
        
        <?php $array = array('Q1.1 Average'=>'Q1.1 Average','Q1.2 Exam'=>'Q1.2 Exam','Q1.3 Qtr Grade'=>'Q1.3 Qtr Grade','Q2.1 Average'=>'Q2.1 Average','Q2.2 Exam'=>'Q2.2 Exam','Q2.3 Qtr Grade'=>'Q2.3 Qtr Grade','Q3.1 Average'=>'Q3.1 Average','Q3.2 Exam'=>'Q3.2 Exam','Q3.3 Qtr Grade'=>'Q3.3 Qtr Grade','Q4.1 Average'=>'Q4.1 Average','Q4.2 Exam'=>'Q4.2 Exam','Q4.3 Qtr Grade'=>'Q4.3 Qtr Grade','Q4.4 Final Grade'=>'Q4.4 Final Grade', 'Sem 1 Avg'=>'Semester 1 Avgrage', 'Sem 2 Avg'=>'Semester 2 Avgrage', "Yearly Avg"=>'Year End', 'Q1 Grade'=>'Q1 Grade','F1 Grade'=>'F1 Grade', 'Q2 Grade' => 'Q2 Grade', 'Q3 Grade' => 'Q3 Grade', 'Q4 Grade' => 'Q4 Grade' )  ?>
        
        <?php $i = 0 ?>
            <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mr-20 col-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="checkbox_calc_<?php echo e($i); ?>" value="<?php echo e($value); ?>" name="extra[terms_calc][]" <?php if(isset($content->terms_calc) && in_array($value, $content->terms_calc)): ?> checked <?php endif; ?>>
                    <label for="checkbox_calc_<?php echo e($i); ?>" class="custom-control-label"><?php echo e($value); ?></label></div>
                </div>
                <?php $i++ ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<div class="form-group ifDD <?php if(isset($scoring->type) && $scoring->type == "DD"): ?> <?php else: ?> d-none <?php endif; ?>">
    <label class="control-label">What course types will be used?</label>
    <div class="d-flex flex-wrap">
        <?php 
            $subjects = array("re"=>"Reading","eng"=>"English","math"=>"Math","sci"=>"Science","ss"=>"Social Studies","o"=>"other");
        ?>
        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s=>$subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mr-20">
                <div class="custom-control custom-checkbox">
                    <input  value="<?php echo e($s); ?>" type="checkbox" class="custom-control-input" id="checkbox<?php echo e($s); ?>" name="extra[subjects][]" <?php if(isset($content->subjects) && in_array($s, $content->subjects)): ?> checked <?php endif; ?> >
                    <label for="checkbox<?php echo e($s); ?>" class="custom-control-label"><?php echo e($subject); ?></label></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
    </div>
</div>
<?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Eligibility/Views/templates/academic_grade_calculation.blade.php ENDPATH**/ ?>