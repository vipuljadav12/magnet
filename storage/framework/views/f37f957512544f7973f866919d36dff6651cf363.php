<?php $__env->startSection('title'); ?>
	Gifted Student Verification Report
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
.dt-buttons {position: absolute !important; padding-top: 5px !important;}

</style>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Gifted Student Verification Report</div></div>
    </div>
    <div class="card shadow">
        <?php echo $__env->make("Reports::display_report_options", ["selection"=>$selection, "enrollment"=>$enrollment, "enrollment_id"=>$enrollment_id], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="">
        <div class="tab-pane fade show active" id="grade1" role="tabpanel" aria-labelledby="grade1-tab">
                        <div class="">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class=" mb-10">
                                        <div id="submission_filters" class="pull-left col-md-6 pl-0" style="float: left !important;"></div>
                                    </div>
                                    <?php if(!empty($firstdata)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0 w-100" id="datatable">
                                            <thead>
                                                 <tr>
                                                    <th class="align-middle">Submission ID</th>
                                                    <th class="align-middle">State ID</th>
                                                    <th class="align-middle">Enrollment Year</th>
                                                    <th class="align-middle">Student Name</th>
                                                    <th class="align-middle">Parent Name</th>
                                                    <th class="align-middle">Phone</th>
                                                    <th class="align-middle">Parent Email</th>
                                                    <th class="align-middle">Race</th>
                                                    <th class="align-middle">Date of Birth</th>
                                                    <th class="align-middle">Current School</th>
                                                    <th class="align-middle">Current Grade</th>
                                                    <th class="align-middle">Next Grade</th>
                                                    <th class="align-middle">First Program Choice</th>
                                                    <th class="align-middle">Second Program Choice</th>
                                                    <th class="align-middle">Submitted at</th>
                                                    <th class="align-middle">Form</th>
                                                    <th class="align-middle">Application Status</th>
                                                    <th class="align-middle">Zoned School</th>
                                                    <th class="align-middle">Student Type</th>
                                                    <th class="align-middle">Confirmaion No</th>
                                                    <th class="align-middle">Verification Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $firstdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="<?php echo e(url('admin/Submissions/edit',$submission->id)); ?>" title="edit">
                                                            <?php echo e($submission->id); ?></a>
                                                    </td>
                                                    <td class=""><?php echo e($submission->student_id); ?></td>
                                                    <td class=""><?php echo e($submission->school_year); ?></td>
                                                    <td class=""><?php echo e($submission->first_name); ?> <?php echo e($submission->last_name); ?></td>
                                                    <td class=""><?php echo e($submission->parent_first_name); ?> <?php echo e($submission->parent_last_name); ?></td>
                                                    <td class=""><?php echo e($submission->phone_number); ?></td>
                                                    <td class=""><?php echo e($submission->parent_email); ?></td>
                                                    <td class=""><?php echo e($submission->race); ?></td>
                                                    <td class=""><?php echo e(getDateFormat($submission->birthday)); ?></td>
                                                    <td class=""><?php echo e($submission->current_school); ?></td>
                                                    <td class=""><?php echo e($submission->current_grade); ?></td>
                                                    <td class=""><?php echo e($submission->next_grade); ?></td>
                                                    <td><?php echo e(getProgramName($submission->first_choice_program_id)); ?></td>
                                                    <td><?php echo e(getProgramName($submission->second_choice_program_id)); ?></td>
                                                    <td class=""><?php echo e(getDateTimeFormat($submission->created_at)); ?></td>
                                                    <td class=""><?php echo e(findSubmissionForm($submission->application_id)); ?></td>
                                                    <td class="">
                                                            <?php if($submission->submission_status == "Active"): ?>
                                                                <div class="alert1 alert-success p-10 text-center d-block"><?php echo e($submission->submission_status); ?></div> 
                                                            <?php elseif($submission->submission_status == "Application Withdrawn"): ?>
                                                                <div class="alert1 alert-danger p-10 text-center d-block"><?php echo e($submission->submission_status); ?></div> 
                                                            
                                                            <?php else: ?>
                                                                    <div class="alert1 alert-warning p-10 text-center d-block"><?php echo e($submission->submission_status); ?></div>
                                                            <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e($submission->zoned_school); ?></td>
                                                    <td class="text-center">
                                                        <?php if($submission->student_id != ""): ?>
                                                            <div class="alert1 alert-success p-10 text-center d-block">Current</div> 
                                                        <?php else: ?>
                                                            <div class="alert1 alert-warning p-10 text-center d-block">New</div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e($submission->confirmation_no); ?></td>
                                                    
                                                    <td class="text-center">
                                                        <?php
                                                            $extra = '';
                                                            $status = $submission->gifted_verification_status;
                                                            if ($status == 'V') {
                                                                $class = 'alert-success';
                                                                $title = 'Verified';
                                                            } else if ($status == 'UV') {
                                                                $class = 'alert-danger';
                                                                $title = 'Unable to Verified';
                                                            } else {
                                                                $class = 'alert-warning';
                                                                $title = 'Not Reviewed';
                                                            }
                                                            if ($submission->gifted_verification_status_at != '') {
                                                                $extra = '<br>By ' . getUserName($submission->gifted_verification_status_by) . '&nbsp;<br>' . getDateTimeFormat($submission->gifted_verification_status_at);
                                                            }
                                                        ?>
                                                        <a href="javascript:void(0);" title="" class="d-block mb-0 alert <?php echo e($class); ?> p-10 text-nowrap employeeverification" data-value="<?php echo e($submission->id); ?>" data-toggle="modal"><?php echo e($title); ?>&nbsp;</a><?php echo $extra; ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                        <div class="table-responsive text-center"><p>No Records found.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
    <div class="modal fade" id="employeeverification" tabindex="-1" role="dialog" aria-labelledby="employeeverificationLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeverificationLabel">Alert</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">If student is a gifted  then click on "Yes" button, if not then click on "No" button.</div>            
                <div class="modal-footer">
                    <button type="button" class="btn btn-success mcpssVerificationStatus" data-value="" data-dismiss="modal" onClick="giftedStudentStatusChange(this.getAttribute('data-value'), 'V')">Yes</button>
                    <button type="button" class="btn btn-danger mcpssVerificationStatus" data-value="" onClick="giftedStudentStatusChange(this.getAttribute('data-value'), 'UV')">No</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/dataTables.buttons.min.js"></script>
    <script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/buttons.html5.min.js"></script>
	<script type="text/javascript">

        var dtbl_submission_list = $("#datatable").DataTable({"aaSorting": [],
             dom: 'Bfrtip',
             buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Gifted Student Verification Report',
                        text:'Export to Excel',

                        //Columns to export
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    }
                ]
            });

        dtbl_submission_list.columns([1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 14, 15, 16, 17, 18, 19]).visible(false);
        function changeMissingReport(id)
        {
            if(id == "")
            {
                document.location.href = "<?php echo e(url('/admin/Reports/missing/cdi')); ?>";
            }
            else
            {
                document.location.href = "<?php echo e(url('/admin/Reports/missing/cdi/')); ?>/"+id;
            }
        }

        $(document).on('click','.employeeverification',function(){
            var submission_id = $(this).attr('data-value');
            $('.mcpssVerificationStatus').attr('data-value', submission_id);
            $('#employeeverification').modal('show');
        });

        function giftedStudentStatusChange(submission_id, $status){
            location.href = '<?php echo e(url('/admin/Reports/missing/')); ?>/'+submission_id+'/gifted_student/verification/'+$status;
        }


	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>