<?php $__env->startSection('title'); ?>
	Selection Report Master
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
    .alert1 {
    position: relative;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
    border-radius: 0.25rem;
}
.dt-buttons {position: absolute !important;}
.w-50{width: 50px !important}
.content-wrapper.active {z-index: 9999 !important}
</style>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Process Selection</div>
        </div>
    </div>

    
    <?php if(!empty($group_racial_composition)): ?>
    <style>
        .collapsible-link::before {
            content: '';
            width: 14px;
            height: 2px;
            background: #333;
            position: absolute;
            top: calc(50% - 1px);
            right: 1rem;
            display: block;
            transition: all 0.3s;
        }
    
        /* Vertical line */
        .collapsible-link::after {
            content: '';
            width: 2px;
            height: 14px;
            background: #333;
            position: absolute;
            top: calc(50% - 7px);
            right: calc(1rem + 6px);
            display: block;
            transition: all 0.3s;
        }
    
        .collapsible-link[aria-expanded='true']::after {
            transform: rotate(90deg) translateX(-1px);
        }
    
        .collapsible-link[aria-expanded='true']::before {
            transform: rotate(180deg);
        }
        
    </style>
        <div id="accordionExample" class="">
                                <!-- Accordion item 2 -->
                                <div class="card" style="width: 100%">
                                        <div id="headingTwo" class="card-header bg-white shadow-sm border-0" style="background: #f6f6f6 !important">
                                            <h6 class="mb-0 font-weight-bold"><a href="#" data-toggle="collapse" data-target="#PreK" aria-expanded="false" aria-controls="PreK" class="d-block position-relative collapsed text-dark text-uppercase collapsible-link py-2">Updated Racial Composition</a></h6>
                                        </div>
                                        <div id="PreK" aria-labelledby="headingPreK" data-parent="#accordionExample" class="collapse">
                                            <div class="card-body p-5 mt-20">
                                                <div class="table-responsive">
                                                 <table class="table table-striped mb-0 w-100">
                                                    <tr>
                                                        <th>Program Group</th>
                                                        <th class="text-center">Black</th>
                                                        <th class="text-center">White</th>
                                                        <th class="text-center">Other</th>
                                                    </tr>
                                                    <?php $__currentLoopData = $group_racial_composition; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(isset($value['black'])): ?>
                                                            <tr>
                                                                <td><?php echo e($key); ?></td>
                                                                <td class="text-center">
                                                                <?php if($value['black'] > 0): ?>
                                                                <?php echo e(number_format($value['black']*100/$value['total'], 2)); ?> (<?php echo e($value['black']); ?>)
                                                                <?php else: ?>
                                                                <?php endif; ?>
                                                                </td>
                                                                <td class="text-center">
                                                                <?php if($value['white'] > 0): ?>
                                                                <?php echo e(number_format($value['white']*100/$value['total'], 2)); ?> (<?php echo e($value['white']); ?>)
                                                                <?php else: ?>
                                                                <?php endif; ?>
                                                                </td>
                                                                <td class="text-center">
                                                                <?php if($value['other'] > 0): ?>
                                                                <?php echo e(number_format($value['other']*100/$value['total'], 2)); ?> (<?php echo e($value['other']); ?>)
                                                                <?php else: ?>
                                                                <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </table>
                                            </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
    <?php endif; ?>
    <div class="">
            <div class="">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php if(!empty($final_data)): ?>
                                            <table class="table table-striped mb-0 w-100" id="datatable">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle text-center">Sub ID</th>
                                                        <th class="align-middle text-center">Submission Status</th>
                                                        <th class="align-middle hiderace text-center">Race</th>
                                                        <th class="align-middle text-center">Student Status</th>
                                                        <th class="align-middle text-center">First Name</th>
                                                        <th class="align-middle text-center">Last Name</th>
                                                        <th class="align-middle text-center">Next Grade</th>
                                                        <th class="align-middle text-center">Current School</th>
                                                        <th class="align-middle hidezone text-center">Zoned School</th>
                                                        <th class="align-middle text-center">First Choice</th>
                                                        <th class="align-middle text-center">Second Choice</th>
                                                        <th class="align-middle text-center">Sibling ID</th>
                                                        <th class="align-middle text-center">Lottery Number</th>
                                                        <th class="align-middle text-center">Priority</th>
                                                        <?php if($preliminary_score): ?>
                                                            <th class="align-middle text-center committee_score-col">Composite Score</th>
                                                        <?php else: ?>
                                                            <th class="align-middle text-center committee_score-col">Committee Score</th>
                                                        <?php endif; ?>
                                                        <th class="align-middle text-center committee_score-col">Final Status</th>
                                                        <th class="align-middle text-center committee_score-col">Race Composition<br>Update</th>
                                                        <th class="align-middle text-center committee_score-col">Availability</th>
                                                    </tr>
                                                    
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $final_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class=""><?php echo e($value['id']); ?></td>
                                                            <td class="text-center"><?php echo e($value['submission_status']); ?></td>
                                                            <td class="hiderace"><?php echo e($value['race']); ?></td>
                                                            <td class="">
                                                                <?php if($value['student_id'] != ''): ?>
                                                                    Current
                                                                <?php else: ?>
                                                                    New
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class=""><?php echo e($value['first_name']); ?></td>
                                                            <td class=""><?php echo e($value['last_name']); ?></td>
                                                            
                                                            <td class="text-center"><?php echo e($value['next_grade']); ?></td>
                                                            <td class=""><?php echo e($value['current_school']); ?></td>
                                                            <td class="hidezone"><?php echo e($value['zoned_school']); ?></td>
                                                            <td class=""><?php echo e($value['first_program']); ?></td>
                                                            <td class="text-center"><?php echo e($value['second_program']); ?></td>
                                                            <td class="">
                                                                <?php if($value['choice'] == 1): ?>
                                                                    <?php $sibling_id = $value['first_sibling'] ?>
                                                                <?php else: ?>
                                                                    <?php $sibling_id = $value['second_sibling'] ?>
                                                                <?php endif; ?>
                                                                <?php if($sibling_id  != ''): ?>
                                                                    <div class="alert1 alert-success p-10 text-center"><?php echo e($sibling_id); ?></div>
                                                                <?php else: ?>
                                                                    <div class="alert1 alert-warning p-10 text-center">NO</div>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class=""><?php echo e($value['lottery_number']); ?></td>
                                                            <td class="text-center">
                                                                <div class="alert1 alert-success">
                                                                    <?php echo e($value['rank']); ?>

                                                                </div>
                                                            </td>
                                                            <td class="text-center committee_score-col">
                                                                <?php if($preliminary_score): ?>
                                                                    <div class="alert1 alert-success">
                                                                        <?php echo $value['composite_score']; ?>

                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="alert1 alert-success">
                                                                        <?php echo $value['committee_score']; ?>

                                                                    </div>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="text-center"><?php echo e($value['final_status']); ?></td>
                                                            <td class="text-center"><?php echo $value['update'] ?? ''; ?></td>
                                                            <td class="text-center"><?php echo e($value['availability'] ?? '-'); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                            <?php else: ?>
                                                <p class="text-center">Process Selection outcome accepted. You can view Selection Report from Process Log section.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/dataTables.buttons.min.js"></script>
<script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/buttons.html5.min.js"></script>

	<script type="text/javascript">
		//$("#datatable").DataTable({"aaSorting": []});
        var dtbl_submission_list = $("#datatable").DataTable({"aaSorting": [],
            "bSort" : false,
             "dom": 'Bfrtip',
             "autoWidth": true,
             "iDisplayLength": 50,
            // "scrollX": true,
             buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Reports',
                        text:'Export to Excel',
                        //Columns to export
                        exportOptions: {
                                columns: "thead th:not(.d-none)"
                        }
                    }
                ]
            });

	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/ProcessSelection/Views/test_index.blade.php ENDPATH**/ ?>