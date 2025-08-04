<?php
    $grade_average_data = \App\Modules\Submissions\Models\SubmissionAcademicGradeCalculation::where('submission_id',$submission->id)->first();
    $preliminary_score_data = \App\Modules\ProcessSelection\Models\PreliminaryScore::where('submission_id',$submission->id)->first();
    $interview_score_data =  \App\Modules\Submissions\Models\SubmissionInterviewScore::where('submission_id',$submission->id)->first();

    $preliminary_score = 0;
    //$choice_ary = array("first", "second");
    $tmp_choice = "first";
    if ($tmp_choice == 'first') {
        $cmp_eligibilities = $eligibilities;
        $cmp_available_methods = $available_methods;
    } else {
        $cmp_eligibilities = $eligibilities_2;
        $cmp_available_methods = $available_methods_2;
    }
    $eligibilities_ary = $cmp_eligibilities->pluck('eligibility_ype')->toArray();

    $program_id = $submission->{$tmp_choice.'_choice_program_id'};
?>

<form class="form" id="frm_priliminary" method="post" action="<?php echo e(url('admin/Submissions/update/priliminary/'.$submission->id.'/'.$program_id)); ?>">
    <?php echo e(csrf_field()); ?>

<div class="card shadow">
    <div class="card-header">Preliminary</div>
    <div class="card-body">
        <div class="form-group row">
            <?php 
                // AGC
                $agc_options = [];
                $agc_val = $grade_average_data->given_score ?? '';
                $preliminary_score += ($agc_val != '' ? $agc_val : 0);
                if (in_array('Academic Grade Calculation', $eligibilities_ary) && in_array('Academic Grade Calculation', $cmp_available_methods)) {
                    $is_eligibility = $cmp_eligibilities->where('eligibility_ype', 'Academic Grade Calculation')->first();
                    if (isset($is_eligibility)) {
                        $eligibility_data = getEligibilityContent1($is_eligibility->assigned_eigibility_name);
                        $agc_options = $eligibility_data->scoring->NR ?? [];
                    }
                }
            ?>
            <label class="control-label col-12 col-md-12 font-weight-bold">Grade Average Score: </label>
            <div class="col-12 col-md-12">
                <select class="form-control custom-select template-type" name="agc_score">
                    <option value="">Select Option</option>
                    <?php $__currentLoopData = $agc_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php if($agc_val == $v): ?> selected="" <?php endif; ?>><?php echo e($v); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <?php if(!empty($choice_ary)): ?>
            <?php $use_calc = $tmpAr = array() ?>
            <?php $__currentLoopData = $choice_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $choice => $cvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $program_id = $submission->{$choice.'_choice_program_id'};
                ?>
                <!-- For Committee Scores -->
                <div class="form-group row">
                    <?php
                        // Committee Score
                        $cs_val = getSubmissionCommitteeScore($submission->id, $program_id);
                        $preliminary_score += (is_numeric($cs_val) ? $cs_val : 0);

                        if (in_array('Committee Score', $eligibilities_ary) && in_array('Committee Score', $cmp_available_methods)) {
                            $cs_eligibility = $cmp_eligibilities->where('eligibility_ype', 'Committee Score')->first();
                            if (isset($cs_eligibility)) {
                                $is_val = $interview_score_data->data ?? 0;
                                $eligibility_data = getEligibilityContent1($cs_eligibility->assigned_eigibility_name);
                                $cs_options = $eligibility_data->eligibility_type->NR ?? [];
                            }
                        }
                    ?>
                    <label class="control-label col-12 col-md-12 font-weight-bold">Committee Score</label>
                    <div class="col-12 col-md-12">
                        <select class="form-control custom-select template-type" name="committee_score">
                            <option value="">Select Option</option>
                            <?php $__currentLoopData = $cs_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php if($cs_val == $v): ?> selected="" <?php endif; ?>><?php echo e($v); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <!-- For Test Scores -->
                <?php
                    if ($choice == 'first' || count($choice_ary) == 1) {
                        $value = $value;
                    } else{
                        $value = $value_2;
                    }
                    
                    $score_data = getTestScoreData($submission->id, $value, $submission->late_submission);
                    $tdata = getEligibilityConfigDynamic($program_id, $value->assigned_eigibility_name, 'use_calculation', $submission->application_id);
                    $use_calc = array_merge($use_calc, explode(",", $tdata));

                    $ts_eligibility = getEligibilityContent1($value->assigned_eigibility_name);
                    $ts_options = $ts_eligibility->eligibility_type->NR ?? [];

                ?>
                <?php if(!empty($score_data)): ?>
                    <?php $__currentLoopData = $score_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ckey => $cvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(in_array($ckey, $use_calc)): ?>
                            <?php 

                                $rank = (isset($cvalue['scorerank'][$ckey]) ? $cvalue['scorerank'][$ckey] : ''); 
                                $preliminary_score += (is_numeric($rank) ? $rank : 0);
                            ?>
                            <div class="form-group row">
                                <label class="control-label col-12 col-md-12 font-weight-bold"><?php echo e(isset($ckey) ? $ckey : ''); ?></label>
                                <div class="col-12 col-md-12">
                                    <select class="form-control custom-select template-type" name="test_score[<?php echo e($ckey); ?>]">
                                        <option value="">Select Option</option>
                                        <?php $__currentLoopData = $ts_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if($rank == $v): ?> selected="" <?php endif; ?>><?php echo e($v); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>


            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <div class="text-right"> 
            <button type="submit" form="frm_priliminary" class="btn btn-success">    
                <i class="fa fa-save"></i> Save
            </button>
        </div>
    </div>
</div>
</form>

<form class="form" id="frm_composite" method="post" action="<?php echo e(url('admin/Submissions/update/composite/'.$submission->id)); ?>">
    <?php echo e(csrf_field()); ?>

<div class="card shadow">
    <div class="card-header">Composite</div>
    <div class="card-body">
        <div class="form-group row">
            <label class="control-label col-12 col-md-12 font-weight-bold">Preliminary Score: </label>
            <div class="col-12 col-md-12">
                <input type="text" class="form-control" value="<?php echo e($preliminary_score); ?>" disabled="">
            </div>
        </div>

        <div class="form-group row">
            <?php 
                // Interview Score
                $is_val = $interview_score_data->data ?? 0;
                if (in_array('Interview Score', $eligibilities_ary) && in_array('Interview Score', $cmp_available_methods)) {
                    $is_eligibility = $cmp_eligibilities->where('eligibility_ype', 'Interview Score')->first();
                    if (isset($is_eligibility)) {
                        $eligibility_data = getEligibilityContent1($is_eligibility->assigned_eigibility_name);
                        $is_options = $eligibility_data->eligibility_type->NR ?? [];
                    }
                }
                // Composite Score
                $composite_score = $preliminary_score + $is_val;
            ?>
            <label class="control-label col-12 col-md-12 font-weight-bold">Interview Score: </label>
            <div class="col-12 col-md-12">
                <select class="form-control custom-select template-type" name="interview_score">
                    <option value="0">Select Option</option>
                    <?php $__currentLoopData = $is_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php if($is_val == $v): ?> selected="" <?php endif; ?> value="<?php echo e($v); ?>"><?php echo e($v); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-12 col-md-12 font-weight-bold">Composite Score: </label>
            <div class="col-12 col-md-12">
                <input type="text" class="form-control" value="<?php echo e($composite_score ?? 0); ?>" disabled="">
            </div>
        </div>
        <div class="text-right"> 
            <button type="submit" form="frm_composite" class="btn btn-success">    
                <i class="fa fa-save"></i> Save
            </button>
        </div>
    </div>
</div>
</form>