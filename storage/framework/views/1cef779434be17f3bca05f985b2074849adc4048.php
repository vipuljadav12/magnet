<?php if(!empty($choice_ary)): ?>
    <?php $__currentLoopData = $choice_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $choice => $cvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
            $program_id = $submission->{$choice.'_choice_program_id'};

            if ($choice == 'first' || count($choice_ary) == 1) {
                $data = getTestScoreData($submission->id, $value, $submission->late_submission);
            } else{
                $data = getTestScoreData($submission->id, $value_2, $submission->late_submission);
                $value = $value_2;
            }

           
            $eligibility_data = getEligibilityContent1($value->assigned_eigibility_name);
            $option = [];
            if($eligibility_data->eligibility_type->type == "NR")
            {
                $options = $eligibility_data->eligibility_type->NR;
            }
            // if (!empty($data)) {
            //     $data = json_decode($data, true);
            // }
        ?>

        <form class="form" id="frm_test_score_<?php echo e($choice); ?>" method="post" action="<?php echo e(url('admin/Submissions/update/TestScore/'.$submission->id.'/'.$program_id)); ?>">
            <?php echo e(csrf_field()); ?>

            <div class="card shadow">
                <div class="card-header"><?php echo e($value->eligibility_ype); ?> <?php echo e($cvalue); ?> [<?php echo e(getProgramName($submission->{$choice.'_choice_program_id'})); ?>]</div>
                <div class="card-body">
                    <div class="">
                        <?php if(!empty($data)): ?>
                            <?php
                                ${$choice.'_count'} = 0;
                            ?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ckey => $cvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <?php if($_SERVER['REMOTE_ADDR'] == "120.72.90.155"): ?>
            
               

            <?php endif; ?>
                                <div class="form-group row">
                                    <label class="control-label col-2 col-md-2 font-weight-bold"><?php echo e(isset($ckey) ? $ckey : ''); ?></label>
                                    <div class="col-5 col-md-5">
                                        <input type="hidden" name="test_score_name[]" value="<?php echo e($ckey); ?>">
                                        <input id="ts_<?php echo e($choice.'_'.${$choice.'_count'}); ?>" type="text" name="test_score_value[]" class="form-control" value="<?php echo e($cvalue['score'][$ckey] ?? ''); ?>">
                                    </div>
                                    <div class="col-5 col-md-5">
                                        <div class="form-group custom-none">
                                            <div class="">
                                                <select class="form-control custom-select template-type" name="test_score_rank[]">
                                                    <option value="">Select Option</option>
                                                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($v); ?>" <?php if(isset($cvalue['scorerank'][$ckey]) && $cvalue['scorerank'][$ckey] == $v): ?> selected="selected" <?php endif; ?>><?php echo e($v); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <?php
                                    ${$choice.'_count'}++;
                                ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="text-right"> 
                        <button type="submit" form="frm_test_score_<?php echo e($choice); ?>" class="btn btn-success">    
                            <i class="fa fa-save"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
<?php endif; ?>

<?php $__env->startSection('submission_test_score_script'); ?>
<?php $__env->stopSection(); ?>
