<?php 
    if(isset($eligibilityContent))
    {
        $content = json_decode($eligibilityContent->content) ?? null;
        // print_r($eligibilityContent->content);
    }
?>
<div class="form-group">
    <label class="control-label">Name of Academic Grades</label>
    <div class="">
        <input type="text" class="form-control" value="<?php echo e($eligibility->name ?? old('name')); ?>" name="name">
        <?php if($errors->first('name')): ?>
            <div class="mb-1 text-danger">
                
                Name is required.
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="form-group">
    <label class="control-label">How are academic grades reported?</label>
    <div class="">
        <select class="form-control custom-select" name="extra[academic_grade]">
            <?php 
                $grades = array(
                    "STD"=>"Standard Based",
                    "NUM"=>"1-100"
                );//array ends
            ?>
            <option value="">Select Option</option>
            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g=>$grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($g); ?>" <?php if(isset($content->academic_grade) && $content->academic_grade == $g): ?> selected <?php endif; ?>><?php echo e($grade); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="control-label">What academic terms will be used?</label>
    <div class="">
        <select class="form-control custom-select" name="extra[academic_term]">
            <?php 
                $terms = array(
                    "SEM"=>"Semesters",
                    "9W"=>"9 weeks / Quarter",
                    "YE"=>"Year End"
                );//array ends
            ?>
            <option value="">Select Option</option>
            <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t=>$term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($t); ?>" <?php if(isset($content->academic_term) && $content->academic_term == $t): ?> selected <?php endif; ?>><?php echo e($term); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>
<div class="form-group d-none">
    <label class="control-label">How many academic terms will be pulled?</label>
    <div class="d-flex flex-wrap">
        <?php for($i = 1 ; $i <= 4 ; $i++): ?>
            <div class="mr-20">
                <div class="custom-control"><!-- custom-checkbox-->
                    <input type="radio" class="custom-control-input" id="checkbox_terms_<?php echo e($i); ?>" value="<?php echo e($i); ?>" name="extra[terms_pulled][]" <?php if(isset($content->terms_pulled) && in_array($i, $content->terms_pulled)): ?> checked <?php endif; ?>>
                <label for="checkbox_terms_<?php echo e($i); ?>" class="custom-control-label"><?php echo e($i); ?></label></div>
            </div>
        <?php endfor; ?>
    </div>
</div>



<div class="form-group ifDD ">
    <label class="control-label">Which Academic Year Grades Need to Display ?</label>
    <div class="row">
        <?php 
            $academic_year_ary = [];
            $current_year = date('Y');
            for ($i=0; $i < 5; $i++) { 
                $tmp_year = $current_year .'-'. substr( $current_year+1, 2);
                array_push($academic_year_ary, $tmp_year);
                $current_year--;
            }
            $i = 0;
            $j = 0;

        $array = array();
        $array = array('Q1.1 Average'=>'Q1.1 Average','Q1.2 Exam'=>'Q1.2 Exam','Q1.3 Qtr Grade'=>'Q1.3 Qtr Grade','Q2.1 Average'=>'Q2.1 Average','Q2.2 Exam'=>'Q2.2 Exam','Q2.3 Qtr Grade'=>'Q2.3 Qtr Grade','Q3.1 Average'=>'Q3.1 Average','Q3.2 Exam'=>'Q3.2 Exam','Q3.3 Qtr Grade'=>'Q3.3 Qtr Grade','Q4.1 Average'=>'Q4.1 Average','Q4.2 Exam'=>'Q4.2 Exam','Q4.3 Qtr Grade'=>'Q4.3 Qtr Grade','Q4.4 Final Grade'=>'Q4.4 Final Grade', 'Sem 1 Avg'=>'Semester 1 Avgrage', 'Sem 2 Avg'=>'Semester 2 Avgrage', "Yearly Avg"=>'Year End', 'Q1 Grade'=>'Q1 Grade','F1 Grade'=>'F1 Grade', 'Q2 Grade' => 'Q2 Grade', 'Q3 Grade' => 'Q3 Grade', 'Q4 Grade' => 'Q4 Grade' )  
        // dd($content);
        ?>

        <?php $__currentLoopData = $academic_year_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 col-lg-3 mb-30">
                <div class="custom-outer-box">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input academic_year_checkbox_calc" id="academic_year_checkbox_calc_<?php echo e($i); ?>" value="<?php echo e($value); ?>" name="extra[academic_year_calc][]" <?php if(isset($content->academic_year_calc) && in_array($value, $content->academic_year_calc)): ?> checked <?php endif; ?>>
                    <label for="academic_year_checkbox_calc_<?php echo e($i); ?>" class="custom-control-label"><?php echo e($value); ?></label></div>

                    <div class="custom-sub-box academic_year_checkbox_calc_<?php echo e($i); ?>" <?php if(isset($content->academic_year_calc) && !in_array($value, $content->academic_year_calc)): ?> style="display: none;" <?php endif; ?>>
                        <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tkey=>$term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                            <div class="pl-20 custom-sub-child">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox_calc_<?php echo e($j); ?>" value="<?php echo e($tkey); ?>" name="extra[terms_calc][<?php echo e($value); ?>][]" <?php if(isset($content->terms_calc->$value) && in_array($tkey, $content->terms_calc->$value)): ?> checked <?php endif; ?>>
                                <label for="checkbox_calc_<?php echo e($j); ?>" class="custom-control-label"><?php echo e($term); ?></label></div>
                            </div>
                            <?php $j++ ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php $i++ ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>




<div class="form-group">
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
<style>
.custom-sub-box {position: relative}
.custom-sub-box:before {content: ""; position: absolute; left: 7px; top: -4px; background: #ccc; width: 2px; bottom: 11px;}
.custom-sub-child {position: relative}
.custom-sub-child:before {content: ""; position: absolute; left: 7px; top: 11px; background: #ccc; height: 2px; width: 20px;}
.custom-checkbox .custom-control-input:checked~.custom-control-label::before {background-color: #00346b;}
</style>
