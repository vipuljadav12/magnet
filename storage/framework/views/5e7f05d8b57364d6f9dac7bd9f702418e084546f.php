<?php $__env->startSection('title'); ?>Edit Program  | <?php echo e(config('APP_NAME',env("APP_NAME"))); ?>  <?php $__env->stopSection(); ?>
<?php $__env->startSection('styles'); ?>
    <script type="text/javascript">var BASE_URL = '<?php echo e(url('/')); ?>';</script>
    <style>
        input[type="checkbox"].styled-checkbox + label.label-xs {padding-left: 1.5rem;}
        .tooltip1 {
            position: relative;
            display: inline-block;
        }
        .tooltip1 .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
            margin-left: -60px;
            bottom: 115%;
            left: 50%;
        }
        .tooltip1:hover .tooltiptext {
            visibility: visible;
        }
        .tooltip1 .tooltiptext::after {
            content: " ";
            position: absolute;
            top: 100%; /* At the bottom of the tooltip */
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: black transparent transparent transparent;
        }
        .tooltip1 .tooltiptext-btm {top: 115%; bottom: auto;}
        .tooltip1 .tooltiptext-btm::after {
            content: "";
            position: absolute;
            top: -9px;
            bottom: auto;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: transparent transparent black transparent;
        }
        .select2-container .select2-choice {border-radius: 0 !important;  height: 30px !important}
        .select2-container{width: 100% !important;  border: 0 !important;}

    <?php if($exception_choice != ''): ?>
        /*Checkbox tree*/
        .custom-sub-box {position: relative}
        .custom-sub-box:before {content: ""; position: absolute; left: 7px; top: -4px; background: #ccc; width: 2px; bottom: 11px;}
        .custom-sub-child {position: relative}
        .custom-sub-child:before {content: ""; position: absolute; left: 7px; top: 11px; background: #ccc; height: 2px; width: 20px;}
        .custom-checkbox .custom-control-input:checked~.custom-control-label::before {background-color: #00346b;}
    <?php endif; ?>
    /*Card close*/
    .card_close {
        width: 12px;
        height: 13px;
        position: absolute;
        right: 5px;
        top: 3px;
        color:  red;
    }


    </style>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.css">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Edit Program</div>
            <div class=""><a href="<?php echo e(url('admin/Program')); ?>" class="btn btn-sm btn-secondary" title="Go Back">Go Back</a></div>
        </div>
    </div>
    <?php echo $__env->make("layouts.admin.common.alerts", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <form action="<?php echo e(url('admin/Program/update',$program->id)); ?>" method="post" name="edit_district" enctype= "multipart/form-data">
        <?php echo e(csrf_field()); ?>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a></li>
            <li class="nav-item"><a class="nav-link" id="eligibility-tab" data-toggle="tab" href="#eligibility" role="tab" aria-controls="eligibility" aria-selected="false">Eligibility</a></li>
            <!--<li class="nav-item"><a class="nav-link" id="config-tab" data-toggle="tab" href="#config" role="tab" aria-controls="config" aria-selected="false">Configurations</a></li>-->
            <li class="nav-item"><a class="nav-link" id="process-tab" data-toggle="tab" href="#process" role="tab" aria-controls="process" aria-selected="false">Selection</a></li>

            <li class="nav-item"><a class="nav-link" id="exception-tab" data-toggle="tab" href="#exception" role="tab" aria-controls="exception" aria-selected="false">Exception</a></li>
            <!--<li class="nav-item"><a class="nav-link" id="recommendation-tab" data-toggle="tab" href="#recommendation" role="tab" aria-controls="recommendation" aria-selected="true">Add Recommendation</a></li>-->
        </ul>
        <div class="tab-content bordered" id="myTabContent">
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <div class="">
                    <div class="card shadow">
                        <div class="card-header">Program Set Up</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label">Program Name : </label>
                                        <div class="">
                                            <input type="text" class="form-control" name="name" value="<?php echo e($program->name); ?>">
                                        </div>
                                        <?php if($errors->first('name')): ?>
                                            <div class="mb-1 text-danger">
                                                <?php echo e($errors->first('name')); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Applicant Group Filter 1 : </label>
                                        <div class="">
                                            <input type="text" class="form-control" name="applicant_filter1" value="<?php echo e($program->applicant_filter1); ?>">
                                        </div>
                                        <?php if($errors->first('applicant_filter1')): ?>
                                            <div class="mb-1 text-danger">
                                                <?php echo e($errors->first('applicant_filter1')); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Applicant Group Filter 2 : </label>
                                        <div class="">
                                            <input type="text" class="form-control" name="applicant_filter2" value="<?php echo e($program->applicant_filter2); ?>">
                                        </div>
                                        <?php if($errors->first('applicant_filter2')): ?>
                                            <div class="mb-1 text-danger">
                                                <?php echo e($errors->first('applicant_filter2')); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Applicant Group Filter 3 : </label>
                                        <div class="">
                                            <input type="text" class="form-control" name="applicant_filter3" value="<?php echo e($program->applicant_filter3); ?>">
                                        </div>
                                        <?php if($errors->first('applicant_filter3')): ?>
                                            <div class="mb-1 text-danger">
                                                <?php echo e($errors->first('applicant_filter3')); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Available Grade Level (Check all that apply) :</strong> </label>
                                        <div class="row flex-wrap program_grade">
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="table25" name="grade_lavel[]" value="PreK" <?php echo e(in_array('PreK',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table25" class="custom-control-label">PreK</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]" value="K" class="custom-control-input" id="table06" <?php echo e(in_array('K',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table06" class="custom-control-label">K</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]" value="1" class="custom-control-input" id="table07" <?php echo e(in_array('1',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table07" class="custom-control-label">1</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]" value="2" class="custom-control-input" id="table08" <?php echo e(in_array('2',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table08" class="custom-control-label">2</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]" value="3" class="custom-control-input" id="table09" <?php echo e(in_array('3',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table09" class="custom-control-label">3</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]" value="4" class="custom-control-input" id="table10" <?php echo e(in_array('4',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table10" class="custom-control-label">4</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]" value="5" class="custom-control-input" id="table11" <?php echo e(in_array('5',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table11" class="custom-control-label">5</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]" value="6" class="custom-control-input" id="table12" <?php echo e(in_array('6',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table12" class="custom-control-label">6</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]" value="7" class="custom-control-input" id="table13" <?php echo e(in_array('7',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table13" class="custom-control-label">7</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]" value="8" class="custom-control-input" id="table14" <?php echo e(in_array('8',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table14" class="custom-control-label">8</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]" value="9" class="custom-control-input" id="table15" <?php echo e(in_array('9',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table15" class="custom-control-label">9</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]" value="10" class="custom-control-input" id="table16" <?php echo e(in_array('10',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table16" class="custom-control-label">10</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]" value="11" class="custom-control-input" id="table17" <?php echo e(in_array('11',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table17" class="custom-control-label">11</label></div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-lg-2">
                                                <div class="custom-control custom-checkbox"><input type="checkbox" name="grade_lavel[]"value="12" class="custom-control-input" id="table18" <?php echo e(in_array('12',explode(',',$program->grade_lavel))?'checked':''); ?>>
                                                    <label for="table18" class="custom-control-label">12</label></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><strong>Parent Submission Form :</strong> </label>
                                        <div class="">
                                            <select class="form-control custom-select" name="parent_submission_form">
                                                <option value="">Choose an Option</option>
                                                    <?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value->id); ?>" <?php if($program->parent_submission_form == $value->id): ?> selected="" <?php endif; ?>><?php echo e($value->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                        </div>
                                    </div>
                                    
                                    <div class="form-group d-flex justify-content-between">
                                        <label for="" class="control-label">Sibling Enabled : </label>
                                        <div class=""><input id="chk_100" type="checkbox" class="js-switch js-switch-1 js-switch-xs" data-size="Small" name="sibling_enabled"  <?php echo e($program->sibling_enabled=='Y'?'checked':''); ?> /></div>
                                    </div>
                                    <div class="form-group d-flex justify-content-between <?php if($program->sibling_enabled == "N"): ?> d-none <?php endif; ?>" id="sibling_check">
                                        <label for="" class="control-label">Sibling Program Check : </label>
                                        <div class=""><input id="chk_03" type="checkbox" class="js-switch js-switch-1 js-switch-xs" data-size="Small" name="silbling_check"  <?php echo e($program->silbling_check=='Y'?'checked':''); ?> /></div>
                                    </div>

                                    <div class="form-group <?php if($sibling_priority_count == 0): ?> d-none <?php endif; ?>">
                                        <label class="control-label"><strong>Select Sibling School(s) :</strong> </label>
                                        <div class="">
                                            <select class="form-control custom-sel2" name="sibling_schools[]" multiple="">
                                                <option value="">Choose an Option</option>
                                                <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($value->name != ''): ?>
                                                        <option value="<?php echo e($value->name); ?>" <?php echo e(in_array($value->name, explode(',', $program->sibling_schools)) ? 'selected':''); ?>><?php echo e($value->name); ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group d-flex justify-content-between">
                                        <label for="" class="control-label">Existing Program Check : </label>
                                        <div class=""><input id="chk_existpr" type="checkbox" class="js-switch js-switch-1 js-switch-xs" data-size="Small" name="existing_magnet_program_alert"  <?php echo e($program->existing_magnet_program_alert=='Y'?'checked':''); ?> /></div>
                                    </div>
                                    <div class="form-group"  <?php if($program->existing_magnet_program_alert=='N'): ?> style="display: none" <?php endif; ?> id="exclude_grade_list">
                                        <?php $exclude_grd = explode(',',$program->grade_lavel) ?>
                                        <?php $tmpArr = array("PreK", "K", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12") ?>

                                        <label class="control-label"><strong>Exclude Current Grade for Magnet Pop Up (Check all that apply) :</strong> </label>
                                        <div class="row flex-wrap program_grade">
                                            <?php $__currentLoopData = $tmpArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <div class="col-12 col-sm-3 col-lg-2">
                                                    <div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="tableex<?php echo e($value); ?>" name="exclude_grade_lavel[]" value="<?php echo e($value); ?>" <?php echo e(in_array($value,explode(',',$program->exclude_grade_lavel))?'checked':''); ?>>
                                                    <label for="tableex<?php echo e($value); ?>" class="custom-control-label"><?php echo e($value); ?></label></div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><strong>Select School :</strong> </label>
                                        <div class="">
                                            <select class="form-control custom-select" name="magnet_school">
                                                <option value="">Select Magnet School</option>
                                                <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($value->name); ?>" <?php echo e($program->magnet_school==$value->name ? 'selected':''); ?>><?php echo e($value->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header">Priority Set Up</div>
                        <div class="card-body" style="min-height: 250px !important">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Select Priority :</strong> </label>
                                        <div class="d-flex flex-wrap">
                                            <div class="mr-20 w-90">
                                                <div class="custom-control custom-radio"><input type="radio" name="priority[]" value="none" class="custom-control-input" id="table28" <?php echo e(in_array('none',explode(',',$program->priority))?'checked':''); ?>>
                                                    <label for="table28" class="custom-control-label">None</label></div>
                                            </div>
                                            <?php $__empty_1 = true; $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p=>$priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <div class="mr-20 w-90">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="priority[]" value="<?php echo e($priority->id); ?>" class="custom-control-input" id="priority<?php echo e($p); ?>" <?php echo e(in_array($priority->id,explode(',',$program->priority))?'checked':''); ?>>
                                                        <label for="priority<?php echo e($p); ?>" class="custom-control-label"><?php echo e($priority->name); ?></label></div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <?php endif; ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-12 col-lg-6">
                                    <div class="card p-3">
                                        <input type="hidden" name="feeder_data" value="<?php echo e(($program->feeder_data ?? '')); ?>">
                                        <div class="feeder_cards row">
                                            <div class="ml-4 mb-3 card px-3 pt-3 col-md-5 feeder_card d-none">
                                                <div class="">
                                                    <label class="control-label"><strong>Select Field to Match for Feeder :</strong>  <span class="feeder_field">Current School</span> </label>
                                                </div>
                                                <div class="">
                                                    <label class="control-label"><strong>Select School For Feeder Priorities (Select All that Apply) :</strong> </label>
                                                    <div class="feeder_priorities"></div>
                                                </div>
                                                <a href="javascript:void(0)" class="card_close" title="Remove"><i class="fa fa-times"></i></a>
                                            </div>
                                        </div>
                                        <div class="form-group <?php if($feeder_priority_count == 0): ?> d-none <?php endif; ?>">
                                            <label class="control-label"><strong>Select Field to Match for Feeder :</strong> </label>
                                            <div class="col-md-12">
                                                <select class="custom-sel2" id="feeder_field" >
                                                    <option value="">Choose an Option</option>
                                                    <option value="current_school" <?php if($program->feeder_field == "current_school"): ?> selected <?php endif; ?>>Current School</option>
                                                    <option value="zoned_school" <?php if($program->feeder_field == "zoned_school"): ?> selected <?php endif; ?>>Zoned School</option>
                                                    <option value="upload" <?php if($program->feeder_field == "upload"): ?> selected <?php endif; ?>>Upload</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group <?php if($feeder_priority_count == 0): ?> d-none <?php endif; ?>">
                                            <label class="control-label"><strong>Select School For Feeder Priorities (Select All that Apply) :</strong> </label>
                                            <div id="feeder_schools" class="col-md-12">
                                                <?php $feeder_priorities_check = explode(",", $program->feeder_priorities) ?>
                                                <select class="custom-sel2" id="select_feeder_priorities"  multiple="">
                                                    
                                                    <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($value->name != ''): ?>
                                                            <option value="<?php echo e(trim($value->name)); ?>"><?php echo e($value->name); ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div id="upload_programs" class="col-md-12 d-none">
                                                <?php $upload_program_check = explode(",", $program->upload_program_check) ?>
                                                <select class="custom-sel2" id="select_upload_program_check"  multiple="">
                                                    
                                                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($value->name != ''): ?>
                                                            <option value="<?php echo e($value->name); ?>"><?php echo e($value->name); ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 hidden-xs text-right">
                                            <button type="button" class="btn btn-success btn-xs feeder_clone_add" title="Add">Add</button>
                                        </div>
                                    </div>


                                    <div class="form-group <?php if($magnet_priority_count == 0): ?> d-none <?php endif; ?>">
                                        <label class="control-label"><strong>Select Program For Magnet Priorities (Select All that Apply) :</strong> </label>
                                        <div class="">
                                            <select class="form-control custom-sel2" name="magnet_priorities[]" multiple="">
                                                <option value="">Choose an Option</option>
                                                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($value->name != ''): ?>
                                                        <option value="<?php echo e($value->name); ?>" <?php echo e(in_array($value->name, explode(',', $program->magnet_priorities)) ? 'selected':''); ?>><?php echo e($value->name); ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="eligibility" role="tabpanel" aria-labelledby="eligibility-tab">
                <?php echo $__env->make("Program::Template.eligibility_edit", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="tab-pane fade" id="process" role="tabpanel" aria-labelledby="process-tab">
                <?php echo $__env->make("Program::Template.selection", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div class="tab-pane fade" id="exception" role="tabpanel" aria-labelledby="exception-tab">
                <?php echo $__env->make("Program::Template.exception", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
           
        </div>

        <div class="box content-header-floating" id="listFoot">
            <div class="row">
                <div class="col-lg-12 text-right hidden-xs float-right">
                    <button type="Submit" class="btn btn-warning btn-xs submit" title="Save"><i class="fa fa-save"></i> Save </button>
                    <button type="Submit" name="save_exit" value="save_exit" class="btn btn-success btn-xs submit" title="Save & Exit"><i class="fa fa-save"></i> Save &amp; Exit</button>
                    <a class="btn btn-danger btn-xs" href="<?php echo e(url('/admin/Program')); ?>" title="Cancel"><i class="fa fa-times"></i> Cancel</a>
                </div>
            </div>
        </div>

        

            <?php echo $__env->make("Program::Template.eligibility_modal_grade", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php $__empty_1 = true; $__currentLoopData = $eligibilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$eligibility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if($eligibility['name']=='Recommendation Form111'): ?>
                <div class="modal fade" id="modal_4" tabindex="-1" role="dialog" aria-labelledby="modal_4Label" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="modal-title" id="modal_4Label">Edit Eligibility - Recommendation Form 1</div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            </div>
                            <div class="modal-body">
                                <div class="card shadow mb-20 d-none">
                                    <div class="card-header">Used in Determination Method</div>
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap">
                                            <div class="d-flex mb-10 mr-30">
                                                <div class="mr-10">Basic Method Only Active : </div>
                                                <input id="chk_3" type="checkbox" class="js-switch js-switch-1 js-switch-xs" data-size="Small">
                                            </div>
                                            <div class="d-flex mb-10 mr-30">
                                                <div class="mr-10">Combined Scoring Active : </div>
                                                <input id="chk_4" type="checkbox" class="js-switch js-switch-1 js-switch-xs" data-size="Small" checked>
                                            </div>
                                            <div class="d-flex mb-10">
                                                <div class="mr-10">Final Scoring Active : </div>
                                                <input id="chk_5" type="checkbox" class="js-switch js-switch-1 js-switch-xs" data-size="Small">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="">
                                            <div class="form-group">
                                                <label class="control-label">Select Prior Developed Recommendation Form: : </label>
                                                <div class="">
                                                    <select class="form-control custom-select" name="eligibility_grade_lavel[<?php echo e($eligibility['id']); ?>][]">
                                                        <option value="HCS STEM Teacher Recommendation">HCS STEM Teacher Recommendation</option>
                                                        <option value="HCS Principal Recommendation">HCS Principal Recommendation</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
        

    </form>

        <!-- Exception tab content start -->
    <div class="exception_tab_content d-none">
        <?php if($exception_choice != ''): ?>
            <?php
                $exp_url = url('')."/admin/Program/store/".$exception_choice."_exception/".$program->id;
            ?>
            <form method="post" id="frm_exception" name="frm_exception" action="<?php echo e($exp_url); ?>">
                <?php echo e(csrf_field()); ?>

            </form>
        <?php endif; ?>
    </div>
    <!-- Exception tab content end -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('resources/assets/common/js/jquery.validate.min.js')); ?>"></script>
    <script src="<?php echo e(asset('resources/assets/common/js/additional-methods.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('resources/assets/admin/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.js"></script>

    <script type="text/javascript">
        $(".alert").delay(2000).fadeOut(1000);
        $(".custom-sel2").select2();

        $(document).on("click",".add-option-list-custome",function(){
            var i = $(this).parent().siblings(".option-list-custome").children(".form-group").length + 1;
            var a = '<div class="form-group">'+
                '<label class="control-label">Option '+i+' : </label>'+
                '<div class=""><input type="text" class="form-control" value=""></div>'+
                '</div>';
            $(this).parent().siblings(".option-list-custome").append(a);
        });
        $(".chk_6").on("change", function(){
            if($(this).is(":checked")) {
                $(".custom-field-list").show();
            }
            else {
                $(".custom-field-list").hide();
            }
        })
        $("#chk_100").on("change", function(){
            if($(this).is(":checked")) {
                $("#sibling_check").removeClass("d-none");
            }
            else {
                $("#sibling_check").addClass("d-none");
            }
        })
        $(".chk_7").on("change", function(){
            if($(this).is(":checked")) {
                $(".option-list-outer").show();
            }
            else {
                $(".option-list-outer").hide();
            }
        })

        $("#chk_existpr").on("change", function(){
            if($(this).is(":checked")) {
                $("#exclude_grade_list").show();
            }
            else {
                $("#exclude_grade_list").hide();
            }
        })

        $(document).on("click", ".add-new" , function(){
            var cc = $("#first").clone().addClass('list').removeAttr("id");
            $("#inowtable tbody").append(cc);
        });
        function del(id){
            $(id).parents(".list").remove();
        }
        //$(document).ready(function(){
        //$('#cp2').colorpicker({
        //
        //});

        $(function () {
            $('#cp2').colorpicker().on('changeColor', function (e) {
                $('#chgcolor')[0].style.backgroundColor = e.color.toHex();
            });
        });
        $("#chk_03").on("change",function(){
            if($("#chk_03").is(":checked")) {
                $("#zone").show();
            }
            else {
                $("#zone").hide();
            }
        });

        //});
    </script>
    <script>
        $(".template-select").on("change",function(){
            var a = $(this).val();
            if(a == 4){
                $(".option4").addClass("d-none");
            }
            else {
                $(".option4").removeClass("d-none");
            }
        });
        $(".template-type").on("change",function(){
            var a = $(this).val();
            if(a == 1){
                $(".template-type-1").removeClass("d-none");
                $(".template-type-2").addClass("d-none");
            }
            else if(a == 2){
                $(".template-type-1").addClass("d-none");
                $(".template-type-2").removeClass("d-none");
            }
            else {
                $(".template-type-1").addClass("d-none");
                $(".template-type-2").addClass("d-none");
            }
        });
        $(document).on("click",".first-click",function(){
            var a = $(".template-select").val();
            if(a == 1) {
                $(".interview-list").removeClass('d-none');
                $(".audition-list").addClass('d-none');
                $(".committee-list").addClass('d-none');
                $(".academic-list").addClass('d-none');
            }
            else if(a == 2) {
                $(".interview-list").addClass('d-none');
                $(".audition-list").removeClass('d-none');
                $(".committee-list").addClass('d-none');
                $(".academic-list").addClass('d-none');
            }
            else if(a == 3) {
                $(".interview-list").addClass('d-none');
                $(".audition-list").addClass('d-none');
                $(".committee-list").removeClass('d-none');
                $(".academic-list").addClass('d-none');
            }
            else if(a == 4) {
                $(".interview-list").addClass('d-none');
                $(".audition-list").addClass('d-none');
                $(".committee-list").addClass('d-none');
                $(".academic-list").removeClass('d-none');
            }
            else {
                $(".interview-list").addClass('d-none');
                $(".audition-list").addClass('d-none');
                $(".committee-list").addClass('d-none');
                $(".academic-list").addClass('d-none');
            }
        });
        function custsort() {
            $(".form-list").sortable({
                handle: ".handle"
            });
            $(".form-list").disableSelection();
        };
        function custsort1() {
            $(".question-list").sortable({
                handle: ".handle1"
            });
            $(".question-list").disableSelection();
        };
        function custsort2() {
            $(".option-list").sortable({
                handle: ".handle2"
            });
            $(".option-list").disableSelection();
        };


        $(document).on("click", ".add-ranking" , function(){
            var i = $(this).parents(".template-type-2").find(".form-group").length + 1;
            var a = '<div class="form-group">'+
                '<label class="">Numeric Ranking '+i+' : </label>'+
                '<div class=""><input type="text" class="form-control"></div>'+
                '</div>';
            var cc = $(this).parents(".template-type-2").find(".mb-20");
            $(a).insertBefore(cc);
        });
        $(document).on("click", ".add-question" , function(){
            var i = $(this).parent().parent(".card-body").find(".question-list").children(".form-group").length + 1;
            var question =  '<div class="form-group border p-15">'+
                '<label class="control-label d-flex flex-wrap justify-content-between"><span><a href="javascript:void(0);" class="mr-10 handle1" title=""><i class="fas fa-arrows-alt"></i></a>Question '+i+' : </span>'+
                '<a href="javascript:void(0);" class="btn btn-secondary btn-sm add-option" title="">Add Option</a>'+
                '</label>'+
                '<div class=""><input type="text" class="form-control" value=""></div>'+
                '<div class="option-list mt-10"></div>'+
                '</div>';
            $(this).parent().parent(".card-body").find(".question-list").append(question);
            custsort1();
        });
        $(document).on("click", ".add-header" , function(){
            var i = $(".form-list").children(".card").length + 1;
            var header =    '<div class="card shadow">'+
                '<div class="card-header">'+
                '<div class="form-group">'+
                '<label class="control-label"><a href="javascript:void(0);" class="mr-10 handle" title=""><i class="fas fa-arrows-alt"></i></a> Header Name '+i+': </label>'+
                '<div class=""><input type="text" class="form-control" value=""></div>'+
                '</div>'+
                '</div>'+
                '<div class="card-body">'+
                '<div class="form-group text-right"><a href="javascript:void(0);" class="btn btn-secondary btn-sm add-question" title="">Add Question</a></div>'+
                '<div class="question-list p-15"></div>'+
                '</div>'+
                '</div>';
            $(this).parents(".card-body").find(".form-list").append(header);
            custsort();
        });
        $(document).on("click", ".add-option" , function(){
            var i = $(this).parent().parent(".form-group").children(".option-list").children(".form-group").length + 1;
            var option =    '<div class="form-group border p-10">'+
                '<div class="row">'+
                '<div class="col-12 col-md-7 d-flex flex-wrap align-items-center">'+
                '<a href="javascript:void(0);" class="mr-10 handle2" title=""><i class="fas fa-arrows-alt"></i></a>'+
                '<label for="" class="mr-10">Option '+i+' : </label>'+
                '<div class="flex-grow-1"><input type="text" class="form-control"></div>'+
                '</div>'+
                '<div class="col-10 col-md-5 d-flex flex-wrap align-items-center">'+
                '<label for="" class="mr-10">Point : </label>'+
                '<div class="flex-grow-1"><input type="text" class="form-control"></div>'+
                '</div>'+
                '</div>'+
                '</div>';
            $(this).parent().parent(".form-group").children(".option-list").append(option);
            custsort2();
        });

        ///method slection in selection tab
        $(function () {
            selectionMethod($('#table27:checked'));
            selectionMethod($('#table23:checked'));
            selectionMethod($('#table24:checked'));
        });
        $("input[name='selection_method']").click(function () {
            selectionMethod(this);
        });

        function selectionMethod(method) {
            if (($(method).attr('id') == 'table24' && $(method).is(":checked"))) {
                $('#seat_availability_enter_by').find("option[value='Manual Entry']").css('display','');
            } else if (($(method).attr('id') == 'table23' && $(method).is(":checked")) || $(method).attr('id') == 'table27' && $(method).is(":checked")) {

                $('#seat_availability_enter_by').find("option[value='Manual Entry']").css('display','none');
            }
        }

        /* Ranking system start */
        var current_over_new_id;
        var committee_score_id;
        var rating_priority_id;
        var lottery_number_id;
        var combine_score_id;
        var audition_score_id;
        var final_score_id;
        $(function () {
            current_over_new_id= $('#current_over_new').children("option:selected").text();
            committee_score_id= $('#committee_score').children("option:selected").text();
            rating_priority_id = $('#rating_priority').children("option:selected").text();
            lottery_number_id = $('#lottery_number').children("option:selected").text();
            combine_score_id = $('#combine_score').children("option:selected").text();
            audition_score_id = $('#audition_score').children("option:selected").text();
            final_score_id = $('#final_score').children("option:selected").text();
            $('option').each(function () {
                $(this).removeClass('d-none');
            });
            $("option[value=" + current_over_new_id + "] ,option[value=" + rating_priority_id + "] ,option[value=" + committee_score_id + "],option[value=" + lottery_number_id + "],option[value=" + combine_score_id + "],option[value=" + audition_score_id + "],option[value=" + final_score_id + "] ").each(function () {
                $(this).addClass('d-none');
            });
        });

        $('.ranking_system').on('change',function () {
            rakingSystem(this);
        });
        function rakingSystem(attr)
        {
            if($(attr).attr('id')=='current_over_new') {
                current_over_new_id = $("#current_over_new option:selected").text();
            }
            else if($(attr).attr('id')=='committee_score') {
                committee_score_id = $("#committee_score option:selected").text();
            }
            else if($(attr).attr('id')=='rating_priority')
            {
                rating_priority_id = $("#rating_priority option:selected").text();
            }
            else if($(attr).attr('id')=='final_score')
            {
                final_score_id = $("#final_score option:selected").text();
            }
            else if($(attr).attr('id')=='lottery_number')
            {
                lottery_number_id = $("#lottery_number option:selected").text();
            }
            else if($(attr).attr('id')=='combine_score')
            {
                combine_score_id = $("#combine_score option:selected").text();
            }
            else if($(attr).attr('id')=='audition_score')
            {
                audition_score_id = $("#audition_score option:selected").text();
            }
            // console.log('here');
            $('option').each(function () {
                $(this).removeClass('d-none');
            });
            $("option[value=" + current_over_new_id + "] ,option[value=" + rating_priority_id + "] ,option[value=" + committee_score_id + "],option[value=" + lottery_number_id + "],option[value=" + combine_score_id + "],option[value=" + audition_score_id + "],option[value=" + final_score_id + "] ").each(function () {
                $(this).addClass('d-none');
            });
        }
        /* Ranking system end */

        //eligibility tab
        $(function () {
            <?php for($i = 0; $i <= 1; $i++): ?>
                <?php
                // For late submission
                $extra_val = '';
                if ($i===1) { $extra_val = '_ls'; }
                ?>

                // For switch
                disableCombinedScoring($('#combined_scoring<?php echo e($extra_val); ?>'), "<?php echo e($extra_val); ?>");
                $('#combined_scoring<?php echo e($extra_val); ?>').on('change',function () {
                    if ($('#basic_method_only<?php echo e($extra_val); ?>').prop('checked')!=true)
                    {
                        $('#basic_method_only<?php echo e($extra_val); ?>').trigger('click');
                    }
                    disableCombinedScoring(this, "<?php echo e($extra_val); ?>");
                });

                disableBasicMethod($('#basic_method_only<?php echo e($extra_val); ?>'), "<?php echo e($extra_val); ?>");
                $('#basic_method_only<?php echo e($extra_val); ?>').on('change',function () {
                    if ($('#combined_scoring<?php echo e($extra_val); ?>').prop('checked')!=true)
                    {
                        $('#combined_scoring<?php echo e($extra_val); ?>').trigger('click');
                    }
                    disableBasicMethod(this, "<?php echo e($extra_val); ?>");
                });

                // For weight enable/disable
                $('.determination_method<?php echo e($extra_val); ?>').each(function () {
                    disableWeight1($(this).children("option:selected"), "<?php echo e($extra_val); ?>");
                });
                $('.determination_method<?php echo e($extra_val); ?>').change(function () {
                    if ($(this).val() == 'Basic') {
                        $(this).parent().parent().find('.weight<?php echo e($extra_val); ?>').attr('disabled', 'disabled');
                    }
                    else{
                        $(this).parent().parent().find('.weight<?php echo e($extra_val); ?>').removeAttr('disabled');
                    }
                });

            <?php endfor; ?>

            function disableCombinedScoring(checkbox, extra_val='') {
                if ($(checkbox).prop('checked')!=true)
                {
                    $("input[name='weight"+extra_val+"[]']").attr('disabled','disabled').val('');
                    $("select[name='determination_method"+extra_val+"[]']").each(function () {
                        $(this).find("option[value='Combined']").addClass('d-none').prop("selected", false);
                    });
                    $("#combined_eligibility"+extra_val).find("option").addClass('d-none').prop("selected", false);
                }
                else{
                    $('.determination_method'+extra_val).each(function () {
                        if ($(this).val() != 'Basic') {
                            $(this).parent().parent().find('.weight'+extra_val).removeAttr('disabled');
                        }
                    });
                    $("select[name='determination_method"+extra_val+"[]']").each(function () {
                        $(this).find("option[value='Combined']").removeClass('d-none');
                    });
                    $("#combined_eligibility"+extra_val).find("option").removeClass('d-none');
                }
                checkChangeInIcon();
            }
            function disableBasicMethod(checkbox, extra_val='') {
                if ($(checkbox).prop('checked')!=true)
                {
                    $("select[name='determination_method"+extra_val+"[]']").each(function () {
                        $(this).find("option[value='Basic']").addClass('d-none').prop("selected", false);
                    });
                    $("#combined_eligibility"+extra_val).find("option").addClass('d-none').prop("selected", false);
                    // Enable weight input
                    $('.weight'+extra_val).attr('disabled', false);
                }
                else{
                    $("select[name='determination_method"+extra_val+"[]']").each(function () {
                        $(this).find("option[value='Basic']").removeClass('d-none');
                    });
                }
                checkChangeInIcon();
            }
            function disableWeight1(select, extra_val='') {
                if ($(select).val() == 'Basic') {
                    // alert($(select).val())
                    $(select).parent().parent().parent().find('.weight'+extra_val).attr('disabled', 'disabled');
                }
                else{
                    $(select).parent().parent().parent().find('.weight'+extra_val).removeAttr('disabled');
                }
            }
        });

        $(".program_grade").find(".custom-control-input").each(function()
        {
            $(this).change(function() { gradeLavel(this);})
            gradeLavel($('#'+$(this).attr("id")+':checked'));
        })
 
        function gradeLavel(check) {

            if($(check).prop('checked')==true)
            {
                // $('.prek').removeClass('d-none');
                // alert($(check).val());
                $("."+$(check).val()).each(function () {
                    $(this).removeClass('d-none');
                });

            }
            else{
                $("."+$(check).val()).each(function () {
                    $(this).addClass('d-none');
                });
            }
        }

        var deletefunction = function(id){
            swal({
                title: "Are you sure you would like to delete this Program ?",
                text: "",
                // type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            }).then(function() {
                window.location.href = '<?php echo e(url('/')); ?>/admin/Program/delete/'+id;
            });
        };

        function changeApplication(value)
        {
            document.location.href = "<?php echo e(url('/admin/Program/edit/'.$program->id)); ?>/"+value;
        }
    </script>

    <script src="<?php echo e(asset('resources/assets/admin/js/program_eligibility.js?'.rand())); ?>"></script>

    <script type="text/javascript">

        checkChangeInIcon();
        function checkChangeInIcon() {
            $(".tbl_eligibility_determination_method").find("tr").each(function() {
                changeIcon($(this), 1);    
            });
            $(".tbl_eligibility_determination_method_ls").find("tr").each(function() {
                // For late submission    
                changeIcon($(this), 1, 1);    
            });
            // $(".table-striped").find("tr").each(function() {
            //     changeIcon($(this), 1);    
            // })
        }

        $("#feeder_field").click(function(){
            if($(this).val() == "upload")
            {
                $("#feeder_schools").addClass("d-none");
                $("#upload_programs").removeClass("d-none");
            }
            else
            {
                $("#feeder_schools").removeClass("d-none");
                $("#upload_programs").addClass("d-none");
            }
        })
        
        /*Feeder clone start*/
        // Initialize feeder data
        var db_feeder_field_ary = '<?php echo (old('feeder_data') ?? $program->feeder_data); ?>';
        if (db_feeder_field_ary == '') {
            var obj = {};
        } else {
            var obj = $.parseJSON(db_feeder_field_ary);
        }
        if (typeof obj.feeder_fields != 'undefined') {
            var feeder_field_ary = obj.feeder_fields;
        } else {
            var feeder_field_ary = [];
        }
        if (typeof obj.feeder_priorities != 'undefined') {
            var feeder_priorities_ary = obj.feeder_priorities;
        } else {
            var feeder_priorities_ary = [];
        }
        // Initially create cards
        generateFeederCard();
        $('.feeder_clone_add').click(function() {
            let feeder_field = $('#feeder_field').val();
            if ($("#feeder_field").val() == 'upload') {
                var feeder_priorities = $('#select_upload_program_check').val();
            } else {
                var feeder_priorities = $('#select_feeder_priorities').val();
            }
            if (feeder_field == '') {
                alert('Select Field to Match for Feeder.');
            } else if (feeder_priorities == '') {
                alert('Select School For Feeder Priorities.');
            } else {
                feeder_field_ary.push(feeder_field);
                feeder_priorities_ary.push(feeder_priorities);
                generateFeederCard((feeder_field_ary.length - 1));
                unsetFeederData();
            }
        });
        function unsetFeederData() {
            $('#feeder_field').select2('val', '');
            $('#select_feeder_priorities').select2('val', '');
            $('#select_upload_program_check').select2('val', '');
        }
        function generateFeederCard(index='') {
            let tmp_feeder_field_ary = [];
            let tmp_feeder_priorities_ary = []; 
            if (index!='') {
                tmp_feeder_field_ary.push(feeder_field_ary[index]);
                tmp_feeder_priorities_ary.push(feeder_priorities_ary[index]);
            } else {
                $('.feeder_cards .feeder_card').not('.feeder_card:first').remove();
                tmp_feeder_field_ary = feeder_field_ary;
                tmp_feeder_priorities_ary = feeder_priorities_ary;
            }
            let cust_ind = 0;
            $.each(tmp_feeder_field_ary, function(i, field_value) {
                cust_ind = (index=='') ? cust_ind : index;
                let default_feeder_card_clone = $('.feeder_cards .feeder_card').first().clone();
                default_feeder_card_clone.removeClass('d-none');
                default_feeder_card_clone.data('index', cust_ind);
                default_feeder_card_clone.find('.feeder_field').text(field_value);
                let ul = $('<ul/>');
                $.each(tmp_feeder_priorities_ary[i], function(i2, priority_value) {
                    let li = $('<li/>').html(priority_value);
                    ul.append(li);
                });
                default_feeder_card_clone.find('.feeder_priorities').append(ul);
                $('.feeder_cards').append(default_feeder_card_clone);
                cust_ind++;
            });
        }
        $(document).on('click', '.card_close', function() {
            let index = $(this).closest('.feeder_card').data('index');
            $(this).closest('.feeder_card').remove();
            feeder_field_ary = $.grep(feeder_field_ary, function(e, i) {
                return i != index;
            });
            feeder_priorities_ary = $.grep(feeder_priorities_ary, function(e, i) {
                return i != index;
            });
            generateFeederCard();
        });
        $('form[name="edit_district"]').submit(function() {
            let jsonData = JSON.stringify({'feeder_fields': feeder_field_ary, 'feeder_priorities': feeder_priorities_ary});
            $('input[name="feeder_data"]').val(jsonData);
        });
        /*Feeder clone end*/
    </script>
        <!-- Exception tab script -->
    <?php echo $__env->yieldContent('exception_script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>