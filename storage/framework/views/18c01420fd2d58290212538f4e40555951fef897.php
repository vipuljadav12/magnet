<div class="card shadow">
    <div class="card-header"><?php echo e($program->name); ?> for Current Enrollment</div>
    <input type="hidden" name="year" value="<?php echo e($enrollment->school_year ?? (date("Y")-1)."-".date("Y")); ?>">
	<?php
		$grades = isset($program->grade_lavel) && !empty($program->grade_lavel) ? explode(',', $program->grade_lavel) : array();
	?>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th class="align-middle w-10"></th>
                        <th class="align-middle w-20">Black</th>
                        <th class="align-middle w-20">White</th>
                        <th class="align-middle w-20">Other</th>
                        
                    </tr>
                </thead>
                <tbody>
                	<?php $__empty_1 = true; $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g=>$grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
	                    <tr>
	                        <td class="w-10">
                                Rising <?php echo e($grade); ?>

                                <label class="error text-danger d-none">Rising enrollment can not exceed total capacity.</label>
                            </td>
                            <td class="w-20">
                                <input type="text" class="form-control numbersOnly blackSeat" data-id="<?php echo e($grade); ?>"  name="grades[<?php echo e($grade); ?>][black_seats]" value="<?php echo e($availabilities[$grade]->black_seats ?? ""); ?>" <?php if($display_outcome > 0): ?> disabled <?php endif; ?>>
                            </td>
                            <td class="w-20">
                                <input type="text" class="form-control numbersOnly whiteSeat" data-id="<?php echo e($grade); ?>"  name="grades[<?php echo e($grade); ?>][white_seats]" value="<?php echo e($availabilities[$grade]->white_seats ?? ""); ?>" <?php if($display_outcome > 0): ?> disabled <?php endif; ?>>
                                
                                
                            </td>
	                        <td class="w-20">
                                <input type="text" class="form-control numbersOnly otherSeat" data-id="<?php echo e($grade); ?>"  name="grades[<?php echo e($grade); ?>][other_seats]" value="<?php echo e($availabilities[$grade]->other_seats ?? ""); ?>" <?php if($display_outcome > 0): ?> disabled <?php endif; ?>>   
                            </td>
	                        
	                    </tr>
	                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
	                    <tr>
	                     	<td class="text-center">No Grades</td>
	                    </tr>
	                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header"><?php echo e($program->name); ?> - Total Capacity for <?php echo e($enrollment->school_year ?? (date("Y")-1)."-".date("Y")); ?></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <tbody>
                	<?php $__empty_1 = true; $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g=>$grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
	                    <tr>
	                        <td class="w-10"><?php echo e($grade); ?></td>
	                        <td class="w-30">
	                        	<input type="text" class="form-control numbersOnly totalSeat"  name="grades[<?php echo e($grade); ?>][total_seats]" value="<?php echo e($availabilities[$grade]->total_seats ?? ""); ?>" data-id="<?php echo e($grade); ?>" >
	                        </td>
	                        <td class="w-30"></td>
	                        <td class="w-30"></td>
	                    </tr>
	                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
	                    <tr>
	                     	<td class="text-center">No Grades</td>
	                    </tr>
	                <?php endif; ?>
                    
                </tbody>
            </table>
        </div>
        <div class="text-right"> 
            <div class="box content-header-floating" id="listFoot">
                <div class="row">
                    <div class="col-lg-12 text-right hidden-xs float-right">
                        <button type="submit" class="btn btn-warning btn-xs" title="Save" id="optionSubmit"><i class="fa fa-save"></i> Save </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>