<?php $__env->startSection('title'); ?>District | <?php echo e(config('APP_NAME',env("APP_NAME"))); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('styles'); ?>
    <!-- DataTables -->
    <link href="<?php echo e(asset('resources/assets/admin/plugins/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('resources/assets/admin/plugins/datatables/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?php echo e(asset('resources/assets/admin/plugins/datatables/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">District</div>
            <div class="">
                <a href="<?php echo e(url('admin/District/create')); ?>" class="btn btn-sm btn-secondary" title="">Add District</a>
                <a href="<?php echo e(url('admin/District/trash')); ?>" class="btn btn-sm btn-danger" title="">Trash</a>
            </div>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <?php echo $__env->make("layouts.admin.common.alerts", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="table-responsive">
                <table id="datatable" class="table table-striped mb-0">
                    <thead>
                    <tr>
                        <th class="align-middle w-120 text-center">District Logo</th>
                        <th class="align-middle">District Name</th>
                        <th class="align-middle">District Slug</th>
                        
                        <th class="align-middle text-center">Status</th>
                        <th class="align-middle text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="align-middle text-center">
                                <img src="<?php echo e(url('/resources/filebrowser/').'/'.$district->district_slug.'/logo/'.$district->district_logo); ?>" alt="img" title="" width="70" id="img" class="img-thumbnail mr-3">
                            </td>
                            <td><?php echo e($district->name); ?></td>
                            
                            
                            <td>
                                <a href="<?php echo e("http://".'/'.$district->district_slug.'.'.Request::getHost()); ?>" target="_blank"><?php echo e($district->district_slug); ?>.<?php echo e(Request::getHost()); ?></a>
                            </td>
                            <td class="text-center">
                                <input id="<?php echo e($district->id); ?>" type="checkbox"  class="js-switch js-switch-1 js-switch-xs status" data-size="Small" <?php echo e($district->status=='Y'?'checked':''); ?> />
                            </td>
                            <td class="text-center">
                                <a href="<?php echo e(url('admin/District/edit',$district->id)); ?>" class="font-18 ml-5 mr-5" title=""><i class="far fa-edit"></i></a>
                                <a href="javascript:void(0)" onclick="deletefunction(<?php echo e($district->id); ?>)" class="font-18 ml-5 mr-5 text-danger" title=""><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    
    <script src="<?php echo e(asset('resources/assets/common/js/jquery.validate.min.js')); ?>"></script>
    <script src="<?php echo e(asset('resources/assets/common/js/additional-methods.min.js')); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
                $(".alert").delay(2000).fadeOut(1000);
                $('#datatable').DataTable({
                    'columnDefs': [ {
                        'targets': [3,4], // column index (start from 0)
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
            var click=$(this).prop('checked')==true ? 'Y' : 'N' ;
            $.ajax({
                type: "get",
                url: '<?php echo e(url('admin/District/status')); ?>',
                data: {
                    id:$(this).attr('id'),
                    status:click
                },
                complete: function(data) {
                    console.log('success');
                }
            });
        });

        //delete confermation
        var deletefunction = function(id){
            swal({
                title: "Are you sure you would like to move this District to trash?",
                text: "",
                // type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            }).then(function() {
                window.location.href = '<?php echo e(url('/')); ?>/admin/District/delete/'+id;
            });
        };
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>