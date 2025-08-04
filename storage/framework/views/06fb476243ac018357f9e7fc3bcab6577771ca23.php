<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-striped mb-0">
                <thead>
                <tr>
                    <th class="align-middle w-120">State ID</th>
                    <th class="align-middle w-120">Updated By</th>
                    <th class="align-middle w-120">Zoned School</th>
                    <th class="align-middle w-120 text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $data['address_overwrite']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="align-middle"><?php echo e($val->state_id); ?></td>
                        <td class="align-middle"><?php echo e(getUserName($val->user_id)); ?></td>
                        <td class="align-middle"><?php echo e($val->zoned_school); ?></td>
                        <td class="align-middle text-center"><a href="<?php echo e(url('/admin/AddressOverride/remove/oveerride/'.$val->id)); ?>"><i class="fa fa-trash text-danger"></i></a></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" align="center">No data found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>