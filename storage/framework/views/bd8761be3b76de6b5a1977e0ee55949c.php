
<?php $__env->startSection('title'); ?>Trash Program  | <?php echo e(config('app.name', 'LeanFrogMagnet')); ?>  <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Trash Program</div>
            <div class=""><a href="<?php echo e(url('admin/Program')); ?>" class="btn btn-sm btn-secondary" title="Go Back">Go Back</a></div>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <?php echo $__env->make("layouts.admin.common.alerts", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="table-responsive">
                <table id="datatable" class="table table-striped mb-0">
                    <thead>
                    <tr>
                        <th class="align-middle">Program Name</th>
                        <th class="align-middle">Grade Levels Available</th>
                        <th class="align-middle">Parent Submission Form</th>
                        <th class="align-middle">Ranking System</th>
                        <th class="align-middle">Selection Method</th>
                        <th class="align-middle">Select Priority</th>
                        <th class="align-middle text-center w-90">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class=""><?php echo e($program->name); ?></td>
                            <td class=""><?php echo e($program->grade_lavel); ?></td>
                            <td class=""><?php echo e($program->parent_submission_form); ?></td>
                            <td class="">Committee Score</td>
                            <td class="">Lottery Method</td>
                            <td class="">2</td>
                            <td class="text-center">
                                <a href="<?php echo e(url('admin/Program/restore',$program->id)); ?>" class="font-18 ml-5 mr-5" title="Restore"><i class="fas fa-undo"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".alert").delay(2000).fadeOut(1000);
            $('#datatable').DataTable({
                'columnDefs': [ {
                    'targets': [6], // column index (start from 0)
                    'orderable': false, // set orderable false for selected columns
                }]
            });
            //Buttons examples
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis'],
            });
            table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        });
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Program/Views/trash.blade.php ENDPATH**/ ?>