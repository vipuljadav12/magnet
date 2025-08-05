<?php 
    if(isset($eligibilityContent))
    {
        // $allow_spreadsheet = json_decode($eligibilityContent->content)->allow_spreadsheet ?? null;
        $mainContent = json_decode($eligibilityContent->content);
        // dd($mainContent,$eligibilityContent);
    }
?>
    <div class="form-group">
        <label class="control-label">Eligibility Name : </label>
        <div class="">
            <input type="text" class="form-control" name="name" value="<?php echo e($eligibility->name ?? old('name')); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label">Select Teachers to receive Recommendation Form (Select all that apply) : </label>
        <div class="">
            <div class="d-flex flex-wrap">
                <?php 
                    // $subjects = array("eng"=>"English","math"=>"Math","sci"=>"Science","ss"=>"Social Studies","o"=>"other");


                    // $subjects = array("eng"=>"English Teacher","math"=>"Math Teacher","sci"=>"Science Teacher","ss"=>"Social Studies Teacher","school_con"=>"School Counselor", "homeroom"=>"Homeroom Teacher", "principal"=>"Principal", "gift"=>"Gifted Teacher");
                    $subjects = config('variables.recommendation_subject');
                ?>
                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s=>$subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mr-20">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkbox<?php echo e($s); ?>" <?php if(isset($mainContent->subjects) && in_array($s, $mainContent->subjects)): ?> checked <?php endif; ?> name="extra[subjects][]" value="<?php echo e($s); ?>">  
                            <label for="checkbox<?php echo e($s); ?>" class="custom-control-label"><?php echo e($subject); ?></label></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label">Select Calculation of Scores : </label>
        <div class="">
            <select class="form-control custom-select" name="extra[calc_score]">
                <option value="">Select Option</option>
                <option value="1" <?php if(isset($mainContent->calc_score) && $mainContent->calc_score == 1): ?> selected  <?php endif; ?>>Sum Scores</option>
                <option value="2" <?php if(isset($mainContent->calc_score) && $mainContent->calc_score == 2): ?> selected  <?php endif; ?>>Average Scores</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label">Store for : </label>
        <div class="">
            <select class="form-control custom-select" name="store_for">
                <option >Select Option</option>
                <option value="DO" <?php echo e(isset($eligibility->store_for) && $eligibility->store_for=='DO'?'selected':''); ?>>District Only</option>
                <option value="MS" <?php echo e(isset($eligibility->store_for) && $eligibility->store_for=='MS'?'selected':''); ?>>MyPick System</option>
            </select>
        </div>
    </div>

    <div class="form-group text-right"><a href="javascript:void(0);" class="btn btn-secondary btn-sm add-header" title="">Add Header</a></div>
    <div class="form-list">
        <?php if(isset($mainContent->header)): ?>
        
            <?php $__currentLoopData = $mainContent->header; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h=>$header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card shadow">
                    <div class="card-header">
                        <div class="form-group">
                        <label class="control-label">
                            <a href="javascript:void(0);" class="mr-10 handle" title=""><i class="fas fa-arrows-alt"></i></a>
                            Header Name <?php echo e($h); ?>: 
                         </label>
                        <div class="">
                            <input type="text" class="form-control headerInput" name="extra[header][<?php echo e($h); ?>][name]" value="<?php echo e($header->name); ?>" id="header_<?php echo e($h); ?>">
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group text-right">
                            <a href="javascript:void(0);" class="btn btn-secondary btn-sm add-option" title="" data-header="<?php echo e($h); ?>">Add Option</a>
                        </div>
                        <div class="option-list mt-10">
                            <?php if(isset($header->options)): ?>
                                <?php $__empty_2 = true; $__currentLoopData = $header->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o=>$option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <div class="form-group border p-10">
                                        <div class="row">
                                            <div class="col-12 col-md-7 d-flex flex-wrap align-items-center">
                                                <a href="javascript:void(0);" class="mr-10 handle2" title=""><i class="fas fa-arrows-alt"></i></a>
                                                <label for="" class="mr-10">Option <?php echo e($o); ?>: </label>
                                                <div class="flex-grow-1"><input type="text" class="form-control" name="extra[header][<?php echo e($h); ?>][options][<?php echo e($o); ?>]" value="<?php echo e($option ?? ""); ?>"></div>
                                            </div>
                                            <div class="col-10 col-md-5 d-flex flex-wrap align-items-center">
                                                <label for="" class="mr-10">Point : </label>
                                                <div class="flex-grow-1"><input type="text" class="form-control" name="extra[header][<?php echo e($h); ?>][points][<?php echo e($o); ?>]" value="<?php echo e($header->points->$o ?? ""); ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="form-group text-right">
                            <a href="javascript:void(0);" class="btn btn-secondary btn-sm add-question" title="" data-header="<?php echo e($h); ?>">Add Question</a>
                        </div>
                        <div class="question-list mt-10">
                            <?php if(isset($header->questions)): ?>
                                <?php $__empty_2 = true; $__currentLoopData = $header->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q=>$question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <div class="form-group border p-15">
                                        <label class="control-label d-flex flex-wrap justify-content-between">
                                            <span><a href="javascript:void(0);" class="mr-10 handle1" title=""><i class="fas fa-arrows-alt"></i></a>Question <?php echo e($q); ?> : </span>
                                        </label>
                                        <div class="">
                                            <input type="text" class="form-control" value="<?php echo e($question ?? ''); ?>" name="extra[header][<?php echo e($h); ?>][questions][<?php echo e($q); ?>]" >
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>

    <div class="form-group text-right"><a href="javascript:void(0);" class="btn btn-secondary btn-sm add-description" title="">Add Description</a></div>
    <div class="card shadow">
        <div class="card-header">
            
                <label class="control-label">
                    <a href="javascript:void(0);" class="mr-10 handle" title=""><i class="fas fa-arrows-alt"></i></a>
                    Recommendation Description : 
                </label>
            
        </div>
        <div class="card-body">
            <div class="description-list mt-10">
                
                <?php if(isset($mainContent->description)): ?>
                    <?php $__currentLoopData = $mainContent->description; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d=>$desc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group border p-15">
                            <div class="">
                                <textarea class="form-control" name="extra[description][]"><?php echo e($desc ?? ''); ?></textarea>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="form-group border p-15">
                        <div class="">
                            <textarea class="form-control" name="extra[description][]"></textarea>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Eligibility/Views/templates/recommendation_form.blade.php ENDPATH**/ ?>