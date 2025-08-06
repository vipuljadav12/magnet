
<?php $__env->startSection('title'); ?> Trash School <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card shadow">
    <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
        <div class="page-title mt-5 mb-5">Trash School </div>
        <div class="">
            <a href="<?php echo e(url('admin/School')); ?>" class="btn btn-sm btn-danger" title="">Back</a>

        </div>
    </div>
</div>
<div class="card shadow">
 <?php echo $__env->make("layouts.admin.common.alerts", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
 <div class="card-body">
    <div class="table-responsive">
        <table id="datatable" class="table table-bordered">
            <thead>
                <tr>
                    <th class="align-middle">School Name</th>
                    <th class="align-middle">Grade</th>
                    <th class="align-middle">Magnet</th>
                    <th class="align-middle">Zoning API Name</th>
                    <th class="align-middle">SIS Name</th>
                    <th class="align-middle text-center">Action</th>
                </tr>
            </thead>
            <tbody>
               <?php if(isset($schools)): ?>
               <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                <td class=""><?php echo e($school->name); ?></td>
                <td class=""><?php echo e($school->grade); ?></td>
                <td class=""><?php echo e($school->magnet); ?></td>
                <td class=""><?php echo e($school->zoning_api_name); ?></td>
                <td class=""><?php echo e($school->sis_name); ?></td>

                <td class="text-center">

                    <a href="<?php echo e(url('admin/School/restore',$school->id)); ?>" class="font-18 ml-5 mr-5" title="Restore"><i class="fas fa-undo"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<!-- InstanceEndEditable -->
<?php $__env->startSection('scripts'); ?>

<script src="<?php echo e(asset('resources/assets/admin/js/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('resources/assets/admin/js/additional-methods.min.js')); ?>"></script>
<!-- Sweet Alert -->
<script src="<?php echo e(url('/resources/assets/admin/plugins/sweet-alert2/sweetalert2.min.js')); ?>"></script>

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".alert").delay(2000).fadeOut(1000);
        $('#datatable').DataTable({
            'columnDefs': [ {
                    'targets': [5], // column index (start from 0)
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
    $('.status').change(function() {
        var status=$(this).prop('checked')==true ? 'Y' : 'N' ;
        $.ajax({
            type: "get",
            url: '<?php echo e(url('admin/School/changestatus')); ?>',
            data: {
                id:$(this).attr('id'),
                status:status
            },
            complete: function(data) {
                console.log('success');
            }
        });
    });    
</script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/School/Views/trash.blade.php ENDPATH**/ ?>