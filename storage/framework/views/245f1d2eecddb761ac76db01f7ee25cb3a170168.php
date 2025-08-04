<div class="card-body">
    <div class=" mb-10">  
    <?php if(!empty($data['submissions'])): ?>
    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100" id="datatable">
            <thead>
                <tr>
                    <th class="align-middle">Submission ID</th>
                    <th class="align-middle">Student ID</th>
                    <th class="align-middle">Application Name</th>
                    <th class="align-middle">Student First Name</th>
                    <th class="align-middle">Student Last Name</th>
                    <th class="align-middle">Race</th>
                    <th class="align-middle">Birthday</th>
                    <th class="align-middle">Address</th>
                    <th class="align-middle">City</th>
                    <th class="align-middle">Zip Code</th>
                    <th class="align-middle">Current School</th>
                    <th class="align-middle">Current Grade</th>
                    <th class="align-middle">Next Grade</th>
                    <th class="align-middle">Special Accommodations</th>
                    <th class="align-middle">Parent First Name</th>
                    <th class="align-middle">Parent Last Name</th>
                    <th class="align-middle">Parent Email</th>
                    <th class="align-middle">Phone Number</th>
                    <th class="align-middle">Zoned School</th>
                    <th class="align-middle">Awarded School</th>
                    <th class="align-middle">First Sibling</th>
                    <th class="align-middle">Second Sibling</th>
                    <th class="align-middle">Confirmation Number</th>
                    <th class="align-middle">First Choice Program</th>
                    <th class="align-middle">Second Choice Program</th>
                    
                    <th class="align-middle">Created At</th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data['submissions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr id="row<?php echo e($value['submission_id']); ?>">
                        <td class="text-center"><?php echo e($value['id']); ?></td>
                        <td><?php echo e($value->student_id); ?></td>
                        <td><?php echo e(getApplicationName($value->application_id)); ?></td>
                        <td><?php echo e($value->first_name); ?></td>
                        <td><?php echo e($value->last_name); ?></td>
                        <td><?php echo e($value->calculated_race); ?></td>
                        <td><?php echo e($value->birthday); ?></td>
                        <td><?php echo e($value->address); ?></td>
                        <td><?php echo e($value->city); ?></td>
                        <td><?php echo e($value->zipcode); ?></td>
                        <td><?php echo e($value->current_school); ?></td>
                        <td><?php echo e($value->current_grade); ?></td>
                        <td><?php echo e($value->next_grade); ?></td>
                        <td><?php echo e($value->special_accommodations); ?></td>
                        <td><?php echo e($value->parent_first_name); ?></td>
                        <td><?php echo e($value->parent_last_name); ?></td>
                        <td><?php echo e($value->parent_email); ?></td>
                        <td><?php echo e($value->phone_number); ?></td>
                        <td><?php echo e($value->zoned_school); ?></td>
                        <td><?php echo e($value->awarded_school); ?></td>
                        <td><?php echo e($value->first_sibling); ?></td>
                        <td><?php echo e($value->second_sibling); ?></td>
                        <td><?php echo e($value->confirmation_no); ?></td>
                        <td><?php echo e(getProgramName($value->first_choice_program_id)); ?></td>
                        <td><?php echo e(getProgramName($value->second_choice_program_id)); ?></td>
                        
                        <td><?php echo e(getDateTimeFormat($value->created_at)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="table-responsive text-center"><p>No records found.</div>
    <?php endif; ?>
</div>