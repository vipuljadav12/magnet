<?php if(!empty($choice_ary)): ?>

    <?php $__currentLoopData = $choice_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $choice => $cvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
            // dd($value_2->assigned_eigibility_name);
            if ($choice == 'first') {
                $eligibility_data = getEligibilityConfigDynamic($submission->first_choice_program_id, $value->assigned_eigibility_name, "email", $submission->application_id);
            } else{
                $eligibility_data = getEligibilityConfigDynamic($submission->second_choice_program_id, $value->assigned_eigibility_name, "email", $submission->application_id);
            }
            
        ?>
            <div class="card shadow">
                <div class="card-header"><?php echo e($value->eligibility_ype); ?> <?php echo e($cvalue); ?> [<?php echo e(getProgramName($submission->{$choice.'_choice_program_id'})); ?>]</div>
                <div class="card-body">
                    <?php echo $eligibility_data; ?>


                    <div class="input-group">
                           <a href="<?php echo e(url('/admin/Submissions/resend/audition/'.$submission->id.'/'.$choice)); ?>" class="btn btn-sm btn-primary" title="" onclick="sendAuditionEmail(this)"><i class="far fa-paper-plane"></i> Resend Email</a>
                        </div>
                </div>
                
            </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>