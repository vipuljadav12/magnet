<div class="card-body">
    

    <div class=" mb-10">
        <div id="submission_filters" class="pull-left col-md-6 pl-0" style="float: left !important;"></div> 
        <div class="text-right">    
       
    </div>
    
   
    <?php if(!empty($dataArr)): ?>

    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100" id="datatable">
            <thead>
                <tr>
                    <th class="align-middle" rowspan="2">Submission ID</th>
                    <th class="align-middle" rowspan="2">Student Name</th>
                    <th class="align-middle" rowspan="2">Next Grade</th>
                    <th class="align-middle" rowspan="2">Powerschool Race</th>
                    <th class="align-middle" rowspan="2">Considerable Race</th>
                    <th class="align-middle" rowspan="2">Zoned School</th>
                    <th class="align-middle" rowspan="2">Zoned School<br>Majority Race</th>
                    <th class="align-middle text-center" colspan="2">First Choice</th>
                    <th class="align-middle text-center" colspan="2">Second Choice</th>
                </tr>
                <tr>
                    <th class="align-middle">Program Name</th>
                    <th class="align-middle">Majority Race</th>
                    <th class="align-middle">Program Name</th>
                    <th class="align-middle">Majority Race</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $dataArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center"><a href="<?php echo e(url('/admin/Submissions/edit/'.$value['id'])); ?>"><?php echo e($value['id']); ?></a></td>
                        <td class=""><?php echo e($value['first_name']." ".$value['last_name']); ?></td>
                        <td class="notexport"><?php echo e($value['next_grade']); ?></td>
                        <td class="text-center"><?php echo e($value['race']); ?></td>
                        <td class=""><?php echo e($value['calculated_race']); ?></td>
                        <td class=""><?php echo e($value['zoned_school']); ?></td>
                        <td class=""><?php echo e($value['zone_school_majority_race']); ?></td>
                        <td class=""><?php echo e($value['first_program']); ?></td>
                        <td class=""><?php echo $value['first_majority_race']; ?></td>
                        <td class=""><?php echo e($value['second_program']); ?></td>
                        <td class=""><?php echo $value['second_majority_race']; ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="table-responsive text-center"><p>No records found.</div>
    <?php endif; ?>
</div>