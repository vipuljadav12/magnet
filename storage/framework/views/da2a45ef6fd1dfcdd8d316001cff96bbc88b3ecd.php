<?php if(!empty($data)): ?>
    <table class="table table-striped mb-0 w-100" id="datatable">
        <thead>
            <tr>
                <th class="align-middle" rowspan="2">Submission ID</th>
                <th class="align-middle" rowspan="2">Name</th>
                <th class="align-middle" rowspan="2">Race</th>
                <th class="align-middle" colspan="3">First Program</th>
                <th class="align-middle" colspan="3">Second Program</th>
                <th class="align-middle">Lottery Number</th>

            </tr>
            <tr>
                <th class="align-middle">Name</th>
                <th class="align-middle">Commitee Score</th>
                <th class="align-middle">Priority</th>
                <th class="align-middle">Name</th>
                <th class="align-middle">Commitee Score</th>
                <th class="align-middle">Priority</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-left"><?php echo e($value['id']); ?></td>
                    <td class="align-middle"><?php echo e($value['name']); ?></td>
                    <td class=""><?php echo e($value['race']); ?></td>
                    <td class=""><?php echo e($value['first_program']); ?></td>
                    <td class=""><?php echo e($value['first_priority']); ?></td>
                    <td class="text-center"><?php echo e($value['first_commitee']); ?></td>
                    <td class=""><?php echo e($value['second_program']); ?></td>
                    <td class=""><?php echo e($value['second_priority']); ?></td>
                    <td class="text-center"><?php echo e($value['second_commitee']); ?></td>
                    <td class="text-center"><?php echo e($value['lottery_number']); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>