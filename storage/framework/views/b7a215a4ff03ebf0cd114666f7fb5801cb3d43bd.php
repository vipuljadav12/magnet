<?php $__env->startSection('title'); ?>
    <title><?php echo e($program_name); ?></title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
    input[type="checkbox"]:after {
    width: 17px;
    height: 17px;
    margin-top: -2px;
    font-size: 14px;
    line-height: 1.2;
}
input[type="checkbox"]:checked:after {
    font-family: 'Font Awesome 5 Free';
    color: #00346b;
    font-weight: 900;
    width: 17px;
    height: 17px;
}
</style>
    
    <div class="mt-20">
      <div class="card bg-light p-20">
        <div class="row">
          <div class="col-sm-6 col-xs-12">
            <div class="text-left font-20 b-600"><?php echo e($program_name); ?></div>
          </div>
        </div>
      </div>
    </div>
    <form action="<?php echo e(url('/answer/save')); ?>" method="POST" id="recommendationForm">
    <?php echo e(csrf_field()); ?>

        <input type="hidden" name="program_id" value="<?php echo e($program_id); ?>">
        <input type="hidden" name="submission_id" value="<?php echo e($submission->id); ?>">
        <input type="hidden" name="subject" value="<?php echo e($subject); ?>">
        <div class="mt-20">
          <div class="card bg-light p-20">
            <div class="row">
              <div class="col-sm-12 col-xs-12 mb-10">
                <div class="text-left font-16 b-600">Confirmation No: <span><?php echo e($submission->confirmation_no); ?></span></div>
              </div>
              <div class="col-sm-12 col-xs-12 mb-10">
                <div class="text-left font-16 b-600">Student: <span><?php echo e($submission->first_name. ' ' . $submission->last_name); ?></span></div>
              </div>
              <div class="col-sm-12 col-xs-12 mb-10">
                <div class="text-left font-16 b-600">School: <span><?php echo e($submission->current_school); ?></span></div>
              </div>
              <div class="col-sm-12 col-xs-12 mb-10">
                <div class="text-left font-16 b-600">Title: <span><?php echo e(config('variables.recommendation_subject')[$subject]); ?></span></div>
              </div>
              <div class="col-sm-12 col-xs-12 mb-10">
                <div class="text-left font-16 b-600">Teacher: 
                    <span class="d-inline-block">
                        <input type="text" class="form-control max-250" name="teacher_name" placeholder="Teacher Name">
                    </span>
                </div>
              </div>
              <div class="col-sm-12 col-xs-12 mb-10">
                <div class="text-left font-16 b-600">Email: <span class="d-inline-block">
                  <input type="text" class="form-control max-250" name="teacher_email" placeholder="Email ID">
                  </span></div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="p-20 border mt-20 mb-20">
            <?php if($header_text != ""): ?>
                <?php echo $header_text; ?>

            <?php else: ?>
                <div class="h6 mb-10">Dear Staff:</div>
                <div class="h6 mb-20">Your recommendation is an important consideration in the decision process of the screening committee for acceptance into the college Academy.</div>
            <?php endif; ?>
            <?php if(isset($content->header) && !empty($content->header)): ?>
            <?php $__currentLoopData = $content->header; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="h4 mb-20"><?php echo e($header->name); ?></div>
                <div class="box-0">
                    <input type="hidden" name="extra[answer][<?php echo e($key); ?>][name]" value="<?php echo e($header->name); ?>">
                    <?php $__currentLoopData = $header->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q=>$question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group row">
                            <label class="control-label col-12 col-md-3 col-xl-3 b-600 text-right mt-1"><?php echo e($question); ?></label>
                            <div class="col-12 col-md-8 col-xl-8">
                                <select class="form-control custom-select recommQuestion" name="extra[answer][<?php echo e($key); ?>][answers][<?php echo e($question); ?>]">
                                    <option value="0">Choose an option</option>
                                    <?php $__currentLoopData = $header->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($option != ''): ?>
                                            <option value="<?php echo e($header->points->{$o}); ?>"><?php echo e($header->points->{$o} . '. ' . $option); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    
                    <?php $__currentLoopData = $header->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ko => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($option != ''): ?>
                            <input type="hidden" name="extra[answer][<?php echo e($key); ?>][options][]" value="<?php echo e($option); ?>">
                            <input type="hidden" name="extra[answer][<?php echo e($key); ?>][points][]" value="<?php echo e($header->points->{$ko}); ?>">
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <div class="form-group row">
                <label class="control-label col-12 col-md-3 col-xl-3 b-600 text-right mt-1" for="qry02">Additional comment</label>
                <div class="col-12 col-md-8 col-xl-8">
                    <textarea class="form-control" name="comment" rows=8></textarea>    
                </div>
            </div>
            <div class="form-group row mb-0 d-none">
                <div class="col-12 col-md-11 col-xl-11 text-right">
                    <label class="mr-10">Average Score</label>
                    <span class="d-inline-block">
                        <input type="hidden" class="average_score" name="avg_score">
                        <input class="form-control max-250 average_score" id="average_score" value="0.00" disabled>
                    </span> 
                </div>
            </div>
        </div>
        <?php if(isset($content->description)): ?>
        <div class="mt-20">
            <div class="card bg-light p-20">
                <div class="row">
                    <?php $__currentLoopData = $content->description; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-sm-12 col-xs-12 mb-10">
                            <div class="text-left font-16 b-600"><input type="checkbox" class="" name="extra[description][]" value="<?php echo e($value); ?>"> <span><?php echo e($value); ?></span></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="mt-20">
            <div class="p-20 pb-0">
                <div class="text-center font-20 b-600 mb-10">This Recommendation is confidential</div>
                <div class="col-12 col-md-6 col-xl-12 text-center mb-30"> 
                    <input type="submit" class="btn btn-secondary btn-xxl" value="Submit Recommendation">
                    
                </div>
                <div class="col-12 col-md-6 col-xl-12 text-center">
                  <p>This electronic form must be completed by <?php echo e(getDateTimeFormat($recommendation_due_date ?? '')); ?>.</p>
                </div>
            </div>
        </div>

        <?php if(strip_tags($footer_text) != ''): ?>
            <div class="mt-0 mb-20">
                <div class="card bg-light p-20">
                    <div class="text-center">
                        <p class="m-0"><?php echo $footer_text; ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </form>


    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
    $('#recommendationForm').validate({
        rules: {
            teacher_name: {
                required: true,                       
            },
            teacher_email: {
                required: true,                       
            }
        },
        messages: {
            teacher_name: {
                required: "Teacher Name is required."
            },
            teacher_email: {
                required: "Teacher Email Address is required."
            }
        },
        submitHandler: function (form, e) {
            errorCheck();

            var count = $(document).find('.error').length;

            if(count == 0){
                form.submit();
            }
        }
    });

    $(document).on('change', '.recommQuestion', function(){

        var value = $(this).val();
            
        if(value == 0){
            $(this).addClass('error').css('border-color','red');
        }else{
            $(this).removeClass('error').css('border-color','');
        }

        averageScore();
    });

    function averageScore(){
        var total = 0;
        var score = 0;
        var avg = 0;

        $(document).find('.recommQuestion').each(function(){
            var value = $(this).val();
            total++;
            score = parseInt(score)  + parseInt(value);
        }); 
        
        avg = score/total;
        $(document).find('.average_score').val(avg.toFixed(2));                
    }

    function errorCheck(){
        $(document).find('.recommQuestion').each(function(){
            var value = $(this).val();
            
            if(value == 0){
                $(this).addClass('error').css('border-color','red');
            }else{
                $(this).removeClass('error').css('border-color','');
            }
        });
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>