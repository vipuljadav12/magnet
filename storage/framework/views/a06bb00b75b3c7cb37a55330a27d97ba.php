<div class="">
    <div class="col-lg-12 text-right hidden-xs float-right mb-5"><a href="<?php echo e(url('/admin/Enrollment/adm_data/import/'.$enrollment->id)); ?>" class="text-white btn btn-sm btn-success" title="">Import</a></div>
    <div class="card shadow">
        <div class="card-header">Racial Composition for Current Enrollment</div>
        <div class="card-body">
            <div class="table-responsive" style="height: 465px; overflow-y: auto;">
                <table class="table tbl_adm">
                    <thead>
                        <tr>
                            <th class="" style="position: sticky; top: 0; background-color: #fff !important; z-index: 200 !important"></th>
                            <th class="w-200" style="position: sticky; top: 0; background-color: #fff !important; z-index: 200 !important">Majority Race</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <?php
                                if (isset($adm_data)) {
                                    $data = $adm_data->where('school_id', $school->id)->first();
                                }
                            ?>

                            <input type="hidden" name="adm_data[<?php echo e($loop->index); ?>][school_id]" value="<?php echo e($school->id); ?>">
                            <td class=""><?php echo e($school->name); ?></td>
                            <td class="">
                                <select  name="adm_data[<?php echo e($loop->index); ?>][majority_race]" class="form-control adm_value">
                                    <option value="na" <?php echo e((isset($data->majority_race) && strtolower($data->majority_race) == "na") ?'selected':''); ?>>N/A</option>
                                    <option value="no majority" <?php echo e((isset($data->majority_race) && strtolower($data->majority_race) == "no majority") ?'selected':''); ?>>No Majority</option>
                                    <option value="black" <?php echo e((isset($data->majority_race) && strtolower($data->majority_race) == "black") ?'selected':''); ?>>Black</option>
                                    <option value="white" <?php echo e((isset($data->majority_race) && strtolower($data->majority_race) == "white") ?'selected':''); ?>>White</option>
                                </select>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" align="center">No school(s) available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Enrollment/Views/adm_data.blade.php ENDPATH**/ ?>