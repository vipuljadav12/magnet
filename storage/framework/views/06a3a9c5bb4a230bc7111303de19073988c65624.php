<?php if(!empty($data)): ?>
    <table class="table table-striped mb-0 w-100" id="datatable">
        <thead>
            <tr>
                <th class="align-middle" rowspan="2">Program Name</th>
                <th class="align-middle" rowspan="2">Initial Availability</th>
                <th class="align-middle" colspan="3">Withdrawn</th>
                <th class="align-middle" rowspan="2">Offered</th>
                <th class="align-middle" rowspan="2">Additional Seats</th>
                <th class="align-middle" rowspan="2">Waitlisted</th>
                <th class="align-middle" rowspan="2">Total Available</th>

            </tr>
            <tr>
                    <th class="align-middle">Black</th>
                     <th class="align-middle">White</th>
                     <th class="align-middle">Other</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-left"><?php echo e($value['name'] ." - Grade ".$value['grade']); ?></td>
                    <td class="align-middle"><?php echo e($value['available_seats']); ?></td>
                    <td class=""><?php echo e($value['black_withdrawn']); ?></td>
                    <td class=""><?php echo e($value['white_withdrawn']); ?></td>
                    <td class=""><?php echo e($value['other_withdrawn']); ?></td>
                    <td class="text-center"><?php echo e($value['offered']); ?></td>
                    <td class="text-center"><?php echo e($value['additional_seats']); ?></td>
                    <td class="text-center"><?php echo e($value['waitlist_count']); ?></td>
                    <td class="text-center"><?php echo e($value['total_available']); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>