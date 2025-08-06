

<?php $__env->startSection('title'); ?>Priorities <?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <style type="text/css">
        .error {
            color: #e33d2d;
        }
    </style>
    <!-- DataTables -->
    <link href="<?php echo e(url('resources/assets/admin/plugins/DataTables/DataTables-1.10.21/css/dataTables.bootstrap4.min.css')); ?>"
        rel="stylesheet" type="text/css" />
    <link href="<?php echo e(url('resources/assets/admin/plugins/DataTables/Buttons-1.6.2/css/buttons.bootstrap4.min.css')); ?>"
        rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?php echo e(url('resources/assets/admin/plugins/DataTables/Responsive-2.2.5/css/responsive.bootstrap4.min.css')); ?>"
        rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Priority Master</div>
            <div class=""><a href="<?php echo e(url('admin/Priority')); ?>" class="btn btn-sm btn-secondary"
                    title="">Back</a></div>
        </div>
    </div>

    <!-- Show Error messsages -->
    

    <div class="card shadow">
        <div class="card-body">
            <?php echo $__env->make('layouts.admin.common.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="table-responsive">
                <table class="table table-striped mb-0" id="priority">
                    <thead>
                        <tr>
                            <th class="align-middle">Priority Name</th>
                            <th class="align-middle text-center w-120">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($priorities)): ?>
                            <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class=""><?php echo e($priority->name); ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo e(url('admin/Priority/restore/' . $priority->id)); ?>" class="font-18 ml-5 mr-5"
                                            title=""><i class=" fas fa-undo"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- InstanceEndEditable --> </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#priority").DataTable({
                // "scrollX": true
                'order': [],
                'columnDefs': [{
                    'targets': [1],
                    'orderable': false
                }]
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Priority/Views/trash.blade.php ENDPATH**/ ?>