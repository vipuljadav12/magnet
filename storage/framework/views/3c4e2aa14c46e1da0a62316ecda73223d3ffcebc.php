<div class="card-body">

    <div class=" ">
        <div class="">    
            <select class="form-control" id="select_program">
                <option value="">Select Program</option>
                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <?php
                        $grades = explode(',', $program->grade_lavel);
                    ?>
                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $option_val = $program->id.','.$grade.','.$program->parent_submission_form;
                        ?>
                        <option value="<?php echo e($option_val); ?>" <?php if($selected_program==$option_val): ?> selected <?php endif; ?>><?php echo e($program->name.' | Grade - '.$grade); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    
    <?php if($selected_program!=''): ?>
        <?php if(!empty($data['process_data'])): ?>
            <div class="table-responsive mt-2">
                <?php
                    $conf = config('variables.seat_availability_conf');
                ?>
                <table class="table table-striped mb-0 w-100" id="tbl_data" style="margin-top: 45px !important;">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="5" id="program_header"></th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Type</th>
                            <th class="text-center align-middle">Withdrawn Seats</th>
                            <th class="text-center align-middle">Offered</th>
                            <th class="text-center align-middle">Accepted</th>
                            <th class="text-center align-middle">Final Available</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data['process_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program_id => $process_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $available_seats = $process_data['available_seats'];
                            ?>
                            <?php if(isset($process_data['type']) && !empty($process_data['type'])): ?>
                                <tr>
                                    <td class="align-middle">Initial Availability</td>
                                    <td class="align-middle">-</td>
                                    <td class="text-center align-middle">-</td>
                                    <td class="text-center align-middle">-</td>
                                    <td class="text-center align-middle"><?php echo e($available_seats); ?></td>
                                </tr>
                                <?php $__currentLoopData = $process_data['type']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $version_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $version_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $version=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $offered = $value['Offered']??0;
                                            $accepted = $value['Accepted']??0;

                                            $withdrawn = 0;
                                            $withdrawn += $black_withdrawn = $value['withdrawn_seats']->black_withdrawn ?? 0;
                                            $withdrawn += $white_withdrawn = $value['withdrawn_seats']->white_withdrawn ?? 0;
                                            $withdrawn += $other_withdrawn = $value['withdrawn_seats']->other_withdrawn ?? 0;
                                            $withdrawn += $additional_withdrawn = $value['withdrawn_seats']->black_withdrawn ?? 0;
                                            
                                            $available_seats = $available_seats + $withdrawn - $accepted;
                                        ?>
                                        <tr>
                                            <td class="align-middle">
                                                <?php echo e($conf[$type]['title'] ?? ''); ?><span class="dtbl_hide">,</span> <br/><?php echo e(getDateTimeFormat($value['updated_at']??'')); ?>

                                            </td>
                                            <td class="align-middle">
                                                Black - <?php echo e($black_withdrawn); ?><span class="dtbl_hide">,</span> <br/>White - <?php echo e($white_withdrawn); ?><span class="dtbl_hide">,</span> <br/>Other - <?php echo e($other_withdrawn); ?><span class="dtbl_hide">,</span> <br/>Additional - <?php echo e($additional_withdrawn); ?><span class="dtbl_hide">,</span> <br/><b>Total - <?php echo e($withdrawn ?? 0); ?></b>
                                            </td>
                                            <td class="text-center align-middle"><?php echo e($offered); ?></td>
                                            <td class="text-center align-middle"><?php echo e($accepted); ?></td>
                                            <td class="text-center align-middle"><?php echo e($available_seats); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="table-responsive text-center"><p>No records found.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>