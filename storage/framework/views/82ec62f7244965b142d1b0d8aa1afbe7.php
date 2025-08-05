
<?php $__env->startSection('title'); ?>
    Edit Application Dates | <?php echo e(config('app.name', 'LeanFrogMagnet'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">
                Edit Application Dates
            </div>
            <div class="">
                <a href="<?php echo e(url('admin/Application')); ?>" class="btn btn-sm btn-secondary" title="Go Back">Go Back</a>
                
            </div>
        </div>
    </div>
    <form action="<?php echo e(url('admin/Application/update', $application->id)); ?>" method="post" name="edit_application">
        <?php echo e(csrf_field()); ?>

        <ul class="nav nav-tabs" id="myTab2" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="active-screen-tab" data-toggle="tab" href="#active-screen"
                    role="tab" aria-controls="active-screen" aria-selected="true">Add Application Dates</a></li>
            <li class="nav-item"><a class="nav-link" id="active1-screen-tab" data-toggle="tab" href="#active1-screen"
                    role="tab" aria-controls="active1-screen" aria-selected="true">Active Screen</a></li>
            <li class="nav-item"><a class="nav-link" id="active-email-tab" data-toggle="tab" href="#active-email"
                    role="tab" aria-controls="active-email" aria-selected="false">Active Email</a></li>
            <li class="nav-item"><a class="nav-link" id="active1-email-tab" data-toggle="tab" href="#active1-email"
                    role="tab" aria-controls="active1-email" aria-selected="false">Pending Screen</a></li>
            <li class="nav-item"><a class="nav-link" id="active2-email-tab" data-toggle="tab" href="#active2-email"
                    role="tab" aria-controls="active2-email" aria-selected="false">Pending Email</a></li>



            <li class="nav-item"><a class="nav-link" id="cdi-grade-upload-tab" data-toggle="tab" href="#cdi-grade-upload"
                    role="tab" aria-controls="cdi-grade-upload" aria-selected="false">Grade Upload Screen</a></li>
            <li class="nav-item"><a class="nav-link" id="cdi-grade-confirm-tab" data-toggle="tab" href="#cdi-grade-confirm"
                    role="tab" aria-controls="cdi-grade-confirm" aria-selected="false">Grade Upload - Confirmation
                    Screen</a></li>

        </ul>
        <div class="tab-content bordered" id="myTab2Content">
            <?php echo $__env->make('layouts.admin.common.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="tab-pane fade show active" id="active-screen" role="tabpanel" aria-labelledby="active-screen-tab">
                <div class="">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <div class="form-group">
                                <label for="">Application Name</label>
                                <div class=""><input type="text" class="form-control" name="application_name"
                                        value="<?php echo e($application->application_name); ?>">
                                </div>
                                <?php if($errors->first('application_name')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('application_name')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($lang->default != 'Y'): ?>
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="">Application Name <span
                                                class="font-16 text-info"><strong>[<?php echo e($lang->language); ?>]</strong></span></label>
                                        <div class=""><input type="text" class="form-control"
                                                name="application_name_<?php echo e($lang->language_code); ?>"
                                                value="<?php echo e($lang_data->{$lang->language_code} ?? $application->application_name); ?>">
                                        </div>
                                        <?php if($errors->first('application_name_' . $lang->language_code)): ?>
                                            <div class="mb-1 text-danger">
                                                <?php echo e($errors->first('application_name_' . $lang->language_code)); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Parent Submission Form</label>
                                <div class="">
                                    <select class="form-control custom-select" name="form_id" id="form_id"
                                        style="pointer-events: none; background-color: #e9ecef;">
                                        <option value="">Select</option>
                                        <?php $__empty_1 = true; $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($form->id); ?>"
                                                <?php echo e($application->form_id == $form->id ? 'selected' : ''); ?>><?php echo e($form->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <?php if($errors->first('form_id')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('form_id')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Open Enrollment</label>
                                <div class="">
                                    <select class="form-control custom-select" name="enrollment_id" id="enrollment_id">
                                        
                                        <?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($enrollment->id); ?>"
                                                <?php echo e($application->enrollment_id == $enrollment->id ? 'selected' : ''); ?>>
                                                <?php echo e($enrollment->school_year); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <?php if($errors->first('enrollment_id')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('enrollment_id')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Starting Date [For Parent]</label>
                                <div class="">
                                    <input class="form-control datetimepicker" name="starting_date" id="starting_date"
                                        value="<?php echo e(date('m/d/Y H:i', strtotime($application->starting_date))); ?>"
                                        disabled="" data-date-format="mm/dd/yyyy hh:ii">
                                </div>
                                <?php if($errors->first('starting_date')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('starting_date')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Ending Date [For Parent]</label>
                                <div class="">
                                    <input class="form-control datetimepicker" name="ending_date" id="ending_date"
                                        value="<?php echo e(date('m/d/Y H:i', strtotime($application->ending_date))); ?>"
                                        disabled="" data-date-format="mm/dd/yyyy hh:ii">
                                </div>
                                <?php if($errors->first('ending_date')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('ending_date')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Starting Date [For Admin]</label>
                                <div class="">
                                    <input class="form-control datetimepicker" name="admin_starting_date"
                                        id="admin_starting_date"
                                        value="<?php echo e(date('m/d/Y H:i', strtotime($application->admin_starting_date))); ?>"
                                        disabled="" data-date-format="mm/dd/yyyy hh:ii">
                                </div>
                                <?php if($errors->first('admin_starting_date')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('admin_starting_date')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Ending Date [For admin]</label>
                                <div class="">
                                    <input class="form-control datetimepicker" name="admin_ending_date"
                                        id="admin_ending_date"
                                        value="<?php echo e(date('m/d/Y H:i', strtotime($application->admin_ending_date))); ?>"
                                        disabled="" data-date-format="mm/dd/yyyy hh:ii">
                                </div>
                                <?php if($errors->first('admin_ending_date')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('admin_ending_date')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>


                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Recommendation Due Date</label>
                                <div class="">
                                    <input class="form-control datetimepicker" name="recommendation_due_date"
                                        id="recommendation_due_date" disabled
                                        value="<?php echo e($application->recommendation_due_date != '' ? date('m/d/Y H:i', strtotime($application->recommendation_due_date)) : ''); ?>"
                                        data-date-format="mm/dd/yyyy hh:ii">
                                </div>
                                <?php if($errors->first('ending_date')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('ending_date')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Writing Prompt Due Date</label>
                                <div class="">
                                    <input class="form-control datetimepicker" name="writing_prompt_due_date"
                                        id="writing_prompt_due_date" disabled
                                        value="<?php echo e($application->writing_prompt_due_date != '' ? date('m/d/Y H:i', strtotime($application->writing_prompt_due_date)) : ''); ?>"
                                        data-date-format="mm/dd/yyyy hh:ii">
                                </div>
                                <?php if($errors->first('writing_prompt_due_date')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('writing_prompt_due_date')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Transcript Due Date</label>
                                <div class="">
                                    <input class="form-control" name="transcript_due_date" id="transcript_due_date"
                                        disabled
                                        value="<?php echo e(date('m/d/Y H:i', strtotime($application->transcript_due_date))); ?>"
                                        data-date-format="mm/dd/yyyy hh:ii">
                                </div>
                                <?php if($errors->first('transcript_due_date')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('transcript_due_date')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Magnet URL</label>
                                <div class="">
                                    <input class="form-control" name="magnet_url"
                                        value="<?php echo e($application->magnet_url); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Grade CDI Upload URL</label>
                                <div class="">
                                    <input class="form-control" disabled
                                        value="<?php echo e(url('/upload/' . $application->id . '/grade')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Application Logo</label>
                                <div class="">
                                    <select class="form-control custom-select" name="district_logo" id="district_logo">
                                        <option value="district_logo"
                                            <?php if($application->display_logo == 'district_logo'): ?> selected="" <?php endif; ?>>District Logo</option>
                                        <option value="magnet_program_logo"
                                            <?php if($application->display_logo == 'magnet_program_logo'): ?> selected="" <?php endif; ?>>Magnet Program Logo
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Submission Type</label>
                                <div class="">
                                    <select class="form-control custom-select" name="submission_type"
                                        id="submission_type">
                                        <option value="Regular" <?php if($application->submission_type == 'Regular'): ?> selected="" <?php endif; ?>>
                                            Regular Submission</option>
                                        <option value="Late" <?php if($application->submission_type == 'Late'): ?> selected="" <?php endif; ?>>Late
                                            Submission</option>
                                    </select>
                                </div>
                                <?php if($errors->first('submission_type')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('submission_type')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Recommendation Email Sent to Parent ?</label>
                                <div class="">
                                    <select class="form-control custom-select" name="recommendation_email_to_parent"
                                        id="recommendation_email_to_parent">
                                        <option value="Yes" <?php if($application->recommendation_email_to_parent == 'Yes'): ?> selected="" <?php endif; ?>>Yes
                                        </option>
                                        <option value="No" <?php if($application->recommendation_email_to_parent == 'No'): ?> selected="" <?php endif; ?>>No
                                        </option>
                                    </select>
                                </div>
                                <?php if($errors->first('recommendation_email_to_parent')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('recommendation_email_to_parent')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="">Fetch Grades</label>
                                <div class="">
                                    <select class="form-control custom-select" name="fetch_grades_cdi"
                                        id="fetch_grades_cdi">
                                        <option value="now" <?php if($application->fetch_grades_cdi == 'now'): ?> selected="" <?php endif; ?>>
                                            Immediate After Submission</option>
                                        <option value="later" <?php if($application->fetch_grades_cdi == 'later'): ?> selected="" <?php endif; ?>>At End
                                            of Application Period</option>
                                    </select>
                                </div>
                                <?php if($errors->first('submission_type')): ?>
                                    <div class="mb-1 text-danger">
                                        <?php echo e($errors->first('submission_type')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if($submission_count > 0): ?>
                        <?php $disabled = " disabled"; ?>
                    <?php else: ?>
                        <?php $disabled = ""; ?>
                    <?php endif; ?>

                    <div class="card shadow">
                        <div class="card-header">Available Programs</div>
                        <div class="card-body">
                            <div class="form-group" id="available_programs">
                                <?php $__empty_1 = true; $__currentLoopData = $temp_programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php $__empty_2 = true; $__currentLoopData = $program['grade_info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <?php if($application->form_id == $program['parent_submission_form']): ?>
                                            <div class="formid_<?php echo e($program['parent_submission_form']); ?>">
                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                    <input <?php echo e($disabled); ?> type="checkbox"
                                                        id="<?php echo e($program['id']); ?><?php echo e($grade['id']); ?>"
                                                        name="program_grade_id[]" class="custom-control-input"
                                                        value="<?php echo e($program['id']); ?>,<?php echo e($grade['id']); ?>"
                                                        <?php echo e(!empty($appProgTemp) && in_array($program['id'] . ',' . $grade['id'], $appProgTemp) ? 'checked' : ''); ?>>
                                                    
                                                    <label class="custom-control-label"
                                                        for="<?php echo e($program['id']); ?><?php echo e($grade['id']); ?>"><?php echo e($program['name']); ?>

                                                        - <?php echo e($grade['name']); ?></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane fade" id="active1-screen" role="tabpanel" aria-labelledby="active1-screen-tab">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="active_screen_languages[]" value="<?php echo e($lang->language_code); ?>">
                    <div class="form-group pb-0 mb-0 pt-20">
                        <label
                            class="control-label font-20 text-info"><strong><u><?php echo e($lang->language); ?></u></strong></label>
                    </div>
                    <div class="form-group">
                        <label style="width: 100%">Active Screen Title : <a
                                href="<?php echo e(url('/admin/Application/preview/active_screen/' . $application->id . '/' . $lang->language_code)); ?>"
                                target="_blank" class="btn btn-success"
                                style="float: right !important;">Preview</a></label>
                        <div class="editor-height-210">
                            <input type="text" class="form-control" class="form-control" name="active_screen_title[]"
                                value="<?php echo e($config_arr[$lang->language_code]['active_screen_title'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Active Screen Subject : </label>
                        <div class="editor-height-210">
                            <input type="text" class="form-control" class="form-control"
                                name="active_screen_subject[]"
                                value="<?php echo e($config_arr[$lang->language_code]['active_screen_subject'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Active Screen : </label>
                        <div class="editor-height-210">
                            <textarea class="form-control editor" id="editor00_<?php echo e($lang->language); ?>" name="active_screen[]">
                            <?php echo $config_arr[$lang->language_code]['active_screen'] ?? ''; ?>

                        </textarea>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="tab-pane fade" id="active-email" role="tabpanel" aria-labelledby="active-email-tab">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="active_email_languages[]" value="<?php echo e($lang->language_code); ?>">
                    <div class="form-group pb-0 mb-0 pt-20">
                        <label
                            class="control-label font-20 text-info"><strong><u><?php echo e($lang->language); ?></u></strong></label>
                    </div>
                    <div class="form-group">
                        <label style="width: 100%">Email Subject : <a
                                href="<?php echo e(url('/admin/Application/preview/active_email/' . $application->id . '/' . $lang->language_code)); ?>"
                                target="_blank" class="btn btn-success"
                                style="float: right !important;">Preview</a></label>
                        <div class="editor-height-210">
                            <input type="text" class="form-control" name="active_email_subject[]"
                                class="form-control"
                                value="<?php echo e($config_arr[$lang->language_code]['active_email_subject'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Active Email : </label>
                        <div class="editor-height-210">
                            <textarea class="form-control editor" id="editor01_<?php echo e($lang->language_code); ?>" name="active_email[]">
                            <?php echo $config_arr[$lang->language_code]['active_email'] ?? ''; ?>

                        </textarea>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="tab-pane fade" id="active1-email" role="tabpanel" aria-labelledby="active1-email-tab">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="pending_screen_languages[]" value="<?php echo e($lang->language_code); ?>">
                    <div class="form-group pb-0 mb-0 pt-20">
                        <label
                            class="control-label font-20 text-info"><strong><u><?php echo e($lang->language); ?></u></strong></label>
                    </div>
                    <div class="form-group">
                        <label style="width: 100%">Pending Screen Title : <a
                                href="<?php echo e(url('/admin/Application/preview/pending_screen/' . $application->id . '/' . $lang->language_code)); ?>"
                                target="_blank" class="btn btn-success"
                                style="float: right !important;">Preview</a></label>
                        <div class="editor-height-210">
                            <input type="text" class="form-control" class="form-control"
                                name="pending_screen_title[]"
                                value="<?php echo e($config_arr[$lang->language_code]['pending_screen_title'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Pending Screen Subject : </label>
                        <div class="editor-height-210">
                            <input type="text" class="form-control" class="form-control"
                                name="pending_screen_subject[]"
                                value="<?php echo e($config_arr[$lang->language_code]['pending_screen_subject'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Pending Screen : </label>
                        <div class="editor-height-210">
                            <textarea class="form-control editor" id="editor02_<?php echo e($lang->language_code); ?>" name="pending_screen[]">
                            <?php echo $config_arr[$lang->language_code]['pending_screen'] ?? ''; ?>

                        </textarea>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="tab-pane fade" id="active2-email" role="tabpanel" aria-labelledby="active2-email-tab">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="pending_email_languages[]" value="<?php echo e($lang->language_code); ?>">
                    <div class="form-group pb-0 mb-0 pt-20">
                        <label
                            class="control-label font-20 text-info"><strong><u><?php echo e($lang->language); ?></u></strong></label>
                    </div>
                    <div class="form-group">
                        <label style="width: 100%">Email Subject : <a
                                href="<?php echo e(url('/admin/Application/preview/pending_email/' . $application->id . '/' . $lang->language_code)); ?>"
                                target="_blank" class="btn btn-success"
                                style="float: right !important;">Preview</a></label>

                        <div class="editor-height-210">
                            <input type="text" class="form-control" class="form-control"
                                name="pending_email_subject[]"
                                value="<?php echo e($config_arr[$lang->language_code]['pending_email_subject'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Pending Email : </label>
                        <div class="editor-height-210">
                            <textarea class="form-control editor" id="editor03_<?php echo e($lang->language_code); ?>" name="pending_email[]">
                            <?php echo $config_arr[$lang->language_code]['pending_email'] ?? ''; ?>

                        </textarea>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="tab-pane fade" id="cdi-grade-upload" role="tabpanel" aria-labelledby="cdi-grade-upload-tab">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-group pb-0 mb-0 pt-20">
                        <label
                            class="control-label font-20 text-info"><strong><u><?php echo e($lang->language); ?></u></strong></label>
                    </div>
                    <div class="form-group">
                        <label>CDI Grade Upload Screen Text : </label>
                        <div class="editor-height-210">
                            <textarea class="form-control editor" id="grade_cdi_welcome_text_<?php echo e($lang->language_code); ?>"
                                name="grade_cdi_welcome_text[]">
                            <?php echo e($config_arr[$lang->language_code]['grade_cdi_welcome_text'] ?? ''); ?>

                        </textarea>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="tab-pane fade" id="cdi-grade-confirm" role="tabpanel" aria-labelledby="cdi-grade-confirm-tab">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-group pb-0 mb-0 pt-20">
                        <label
                            class="control-label font-20 text-info"><strong><u><?php echo e($lang->language); ?></u></strong></label>
                    </div>
                    <div class="form-group">
                        <label>CDI Grade Upload Confirm Screen Text : </label>
                        <div class="editor-height-210">
                            <textarea class="form-control editor" id="grade_cdi_confirm_text_<?php echo e($lang->language_code); ?>"
                                name="grade_cdi_confirm_text[]">
                            <?php echo e($config_arr[$lang->language_code]['grade_cdi_confirm_text'] ?? ''); ?>

                        </textarea>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="box content-header-floating" id="listFoot">
                <div class="row">
                    <div class="col-lg-12 text-right hidden-xs float-right">
                        <input type="hidden" name="submit-from" id="submit-from-btn" value="general">
                        <?php if(isCurrentEnrollmentValid()): ?>
                            <button type="submit" class="btn btn-warning btn-xs" name="submit" value="Save"
                                title="Save"><i class="fa fa-save"></i> Save </button>
                            <button type="submit" name="save_exit" value="save_exit"
                                class="btn btn-success btn-xs submit" title="Save & Exit"><i class="fa fa-save"></i> Save
                                &amp; Exit</button>
                        <?php else: ?>
                            <a href="javascript:void(0)" class="btn btn-warning btn-xs"
                                title="You can not edit application cause current enrollment is expired."
                                style="cursor: not-allowed;"><i class="fa fa-save"></i> Save </a>
                            <a href="javascript:void(0)" class="btn btn-success btn-xs submit"
                                title="You can not edit application cause current enrollment is expired."
                                style="cursor: not-allowed;"><i class="fa fa-save"></i> Save &amp; Exit</a>
                        <?php endif; ?>
                        <a class="btn btn-danger btn-xs" href="<?php echo e(url('/admin/Application')); ?>" title="Cancel"><i
                                class="fa fa-times"></i> Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(url('/')); ?>/resources/assets/admin/plugins/laravel-ckeditor/ckeditor.js">
    </script>
    <script type="text/javascript" src="<?php echo e(url('/resources/assets/admin/plugins/laravel-ckeditor/adapters/jquery.js')); ?>">
    </script>
    
    <script>
        var start_date;
        var end_date;

        jQuery.validator.addMethod("greaterThan",
            function(value, element, params) {

                if (!/Invalid|NaN/.test(new Date(value))) {
                    return new Date(value) > new Date($(params).val());
                }

                return isNaN(value) && isNaN($(params).val()) ||
                    (Number(value) > Number($(params).val()));
            }, 'Must be greater than {0}.');

        $('textarea.editor').each(function() {
            CKEDITOR.replace($(this).attr('id'), {
                toolbar: 'Basic',
                toolbarGroups: [{
                        name: 'document',
                        groups: ['mode', 'document']
                    }, // Displays document group with its two subgroups.
                    {
                        name: 'clipboard',
                        groups: ['clipboard', 'undo']
                    }, // Group's name will be used to create voice label.
                    {
                        name: 'basicstyles',
                        groups: ['cleanup', 'basicstyles']
                    },

                    '/', // Line break - next group will be placed in new line.
                    {
                        name: 'links'
                    }
                ],
                on: {
                    pluginsLoaded: function() {
                        var editor = this,
                            config = editor.config;

                        editor.ui.addRichCombo('my-combo', {
                            label: 'Insert Short Code',
                            title: 'Insert Short Code',
                            toolbar: 'basicstyles',

                            panel: {
                                css: [CKEDITOR.skin.getPath('editor')].concat(config
                                    .contentsCss),
                                multiSelect: false,
                                attributes: {
                                    'aria-label': 'Insert Short Code'
                                }
                            },

                            init: function() {
                                var chk = [];
                                $.ajax({
                                    url: '<?php echo e(url('/admin/shortCode/list')); ?>',
                                    type: "get",
                                    async: false,
                                    success: function(response) {
                                        chk = response;
                                    }
                                })
                                for (var i = 0; i < chk.length; i++) {
                                    this.add(chk[i], chk[i]);
                                }
                            },

                            onClick: function(value) {
                                editor.focus();
                                editor.fire('saveSnapshot');

                                editor.insertHtml(value);

                                editor.fire('saveSnapshot');
                            }
                        });
                    }
                }
            });
        });

        $('#enrollment_id').change(function() {
            setStartEndDate(this);
        });
        setStartEndDate($('#enrollment_id'));

        function setStartEndDate(select) {
            if ($(select).val() != '') {
                $.ajax({
                    type: "get",
                    url: '<?php echo e(url('admin/Application/start_end_date')); ?>',
                    data: {
                        id: $(select).val(),
                    },
                    success: function(response) {
                        if (response.error) {
                            console.error('Error:', response.error);
                            return;
                        }
                        // setStartEndDate(response.start,response.end);
                        start_date = response.start;
                        end_date = response.end;
                        admin_start_date = response.start;
                        admin_end_date = response.end;

                        $("#starting_date").datetimepicker({
                            numberOfMonths: 1,
                            minDate: new Date(start_date),
                            maxDate: new Date(end_date),
                            dateFormat: 'mm/dd/yyyy hh:ii',
                            autoclose: true,
                            onSelect: function(selected) {
                                $("#ending_date").datetimepicker("option", "minDate", selected)
                            }
                        }).removeAttr('disabled');
                        $("#ending_date").datetimepicker({
                            numberOfMonths: 1,
                            minDate: new Date(start_date),
                            maxDate: new Date(end_date),
                            dateFormat: 'mm/dd/yyyy hh:ii',
                            autoclose: true,
                            onSelect: function(selected) {
                                $("#starting_date").datetimepicker("option", "maxDate", selected)
                            }
                        }).removeAttr('disabled');

                        $("#admin_starting_date").datetimepicker({
                            numberOfMonths: 1,
                            minDate: new Date(start_date),
                            maxDate: new Date(end_date),
                            dateFormat: 'mm/dd/yyyy hh:ii',
                            autoclose: true,
                            onSelect: function(selected) {
                                $("#admin_ending_date").datetimepicker("option", "minDate",
                                    selected)
                            }
                        }).removeAttr('disabled');
                        $("#admin_ending_date").datetimepicker({
                            numberOfMonths: 1,
                            minDate: new Date(start_date),
                            maxDate: new Date(end_date),
                            dateFormat: 'mm/dd/yyyy hh:ii',
                            autoclose: true,
                            onSelect: function(selected) {
                                $("#admin_starting_date").datetimepicker("option", "maxDate",
                                    selected)
                            }
                        }).removeAttr('disabled');

                        $("#recommendation_due_date,#transcript_due_date,#writing_prompt_due_date")
                            .datetimepicker({
                                numberOfMonths: 1,
                                autoclose: true,
                                dateFormat: 'mm/dd/yyyy hh:ii',
                            }).removeAttr('disabled');
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        console.error('Response:', xhr.responseText);
                    }
                });
            } else {

                $(".date_picker").attr('disabled', 'disabled');
            }
        }

        //delete confermation
        var deletefunction = function(id) {
            swal({
                title: "Are you sure you would like to move this Application to trash?",
                text: "",
                // type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            }).then(function() {
                window.location.href = '<?php echo e(url('/')); ?>/admin/Application/delete/' + id;
            });
        };
        $("form[name='edit_application']").validate({
            rules: {
                form_id: {
                    required: true,
                },
                enrollment_id: {
                    required: true,
                },
                starting_date: {
                    required: true,
                    date: true,

                },
                ending_date: {
                    required: true,
                    date: true,
                    greaterThan: "#starting_date"

                },
                /* recommendation_due_date:{
                     required:true,
                     date:true,

                 },*/
                transcript_due_date: {
                    required: true,
                    date: true,

                },
                submission_type: {
                    required: true,
                },
                'program_grade_id[]': {
                    required: true,
                }
            },
            messages: {
                form_id: {
                    required: 'The Parent submission form field is required.'
                },
                enrollment_id: {
                    required: 'The Open Enrollment field is required.'
                },
                starting_date: {
                    required: 'The Start date field is required.',
                    date: 'The Date formate is not valid',
                },
                ending_date: {
                    required: 'The Ending date field is required.',
                    date: 'The Date formate is not valid',
                },
                recommendation_due_date: {
                    required: 'The Recommendation due date field is required.',
                    date: 'The Date formate is not valid',
                },
                transcript_due_date: {
                    required: 'The Transcript due date field is required.',
                    date: 'The Date formate is not valid',
                },
                submission_type: {
                    required: 'Submission Type field is required.',
                },
                'program_grade_id[]': {
                    required: 'The Program is required.',
                }
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.parents('.form-group'));
                error.css('color', 'red');
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        setPrograms();

        function setPrograms() {
            let form_id = $('#form_id').val();
            $('#available_programs').children('div').addClass('d-none');
            $('.formid_' + form_id).removeClass('d-none');
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Application/Views/edit.blade.php ENDPATH**/ ?>