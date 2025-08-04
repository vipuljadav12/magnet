<?php 
$eligibility_data = getEligibilityContent1($value->assigned_eigibility_name); 
    $data = getSubmissionInterviewScore($submission->id);

?>
    <?php if($eligibility_data->eligibility_type->type=="YN"): ?>
        <?php $options = $eligibility_data->eligibility_type->YN; ?>
    <?php else: ?>
        <?php $options = $eligibility_data->eligibility_type->NR; ?>
    <?php endif; ?> 
<form class="form" id="#insterview_score_form" method="post" action="<?php echo e(url('admin/Submissions/update/InterviewScore/'.$submission->id)); ?>">
    <?php echo e(csrf_field()); ?>

    <div class="card shadow">
        <div class="card-header"><?php echo e($value->eligibility_name); ?></div>
        <div class="card-body">
            <div class="form-group custom-none">
                <div class="">
                    <select class="form-control custom-select template-type" name="data">
                        <option value="">Select Option</option>
                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php if(isset($data->data) && $data->data == $v): ?> selected="" <?php endif; ?>><?php echo e($v); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="text-right"> 
                <button class="btn btn-success">    
                    <i class="fa fa-save"></i>
                </button>
            </div>
        </div>
    </div>
</form>


