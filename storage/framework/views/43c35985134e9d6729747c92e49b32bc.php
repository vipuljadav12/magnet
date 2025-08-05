
<?php $__env->startSection('title'); ?>Add Eligibility <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
    .error {color:red;}
</style>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Add Eligibility</div>
            <div class=""><a href="<?php echo e($module_url); ?>" class="btn btn-sm btn-secondary" title="">Back</a></div>
        </div>
    </div>
    <form action="<?php echo e($module_url); ?>/store" method="POST" id="eligibility-add" name="eligibility-add">
        <?php echo e(csrf_field()); ?>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">Template 1</a></li>
            <li class="nav-item"><a class="nav-link" id="recommendation-tab" data-toggle="tab" href="#recommendation" role="tab" aria-controls="recommendation" aria-selected="true">Template 2</a></li>
            <!--<li class="nav-item"><a class="nav-link" id="preview-tab" data-toggle="tab" href="#preview" role="tab" aria-controls="preview" aria-selected="true">Template 3</a></li>-->            
        </ul>
        
        <div class="tab-content bordered" id="myTabContent">
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <?php if($errors->first('name')): ?>
                    <div class="mb-1 text-danger alert alert-danger">
                        
                       Something went wrong , Please try again..
                    </div>
                <?php endif; ?>
                <div class="">
                    <div class="">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="control-label">Select Eligibility Template : </label>
                                    <div class="">
                                        <select class="form-control custom-select template-select" name="template">
                                            <option value="">Select Option</option>
                                                <?php $__empty_1 = true; $__currentLoopData = $eligibilityTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$eligibilityTemplate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <option value="<?php echo e($eligibilityTemplate->id); ?>"><?php echo e($eligibilityTemplate->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="optionContent"></div>
                                <div class="form-group d-flex justify-content-between pt-5 d-none" id="override">
                                        
                                        <div class="d-flex flex-wrap"><label class="control-label pr-10">Override Enabed ?</label>&nbsp;
                                           <input id="chk_acd" type="checkbox" name="override" class="js-switch js-switch-1 js-switch-xs grade_override" data-size="Small" />
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label class="control-label">Store for : </label>
                                    <div class="">
                                        <select class="form-control custom-select" name="store_for">
                                            <option value="">Select Option</option>
                                            <option value="DO" <?php echo e(old('store_for')=='DO'?'selected':''); ?>>District Only</option>
                                            <option value="MS" <?php echo e(old('store_for')=='MS'?'selected':''); ?>>MyPick System</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="recommendation" role="tabpanel" aria-labelledby="recommendation-tab">
                <div class="">
                    <div class="card shadow">
                        <div class="card-header">Recommendation Form</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="control-label">Eligibility Name : </label>
                                <div class="">
                                    <input type="text" class="form-control" name="name" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Select Teachers to receive Recommendation Form (Select all that apply) : </label>
                                <div class="">
                                    <div class="d-flex flex-wrap">
                                        <?php 
                                            $subjects = config('variables.recommendation_subject');
                                        ?>
                                        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s=>$subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="mr-20">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="checkbox<?php echo e($s); ?>" name="extra[subjects][]" value="<?php echo e($s); ?>">  
                                                    <label for="checkbox<?php echo e($s); ?>" class="custom-control-label"><?php echo e($subject); ?></label></div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Select Calculation of Scores : </label>
                                <div class="">
                                    <select class="form-control custom-select" name="extra[calc_score]">
                                        <option value="">Select Option</option>
                                        <option value="1">Sum Scores</option>
                                        <option value="2">Average Scores</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label">Store for : </label>
                                <div class="">
                                    <select class="form-control custom-select" name="store_for">
                                        <option value="">Select Option</option>
                                        <option value="DO">District Only</option>
                                        <option value="MS">MyPick System</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group text-right"><a href="javascript:void(0);" class="btn btn-secondary btn-sm add-header" title="">Add Header</a></div>
                            <div class="form-list"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box content-header-floating" id="listFoot">
            <div class="row">
                <div class="col-lg-12 text-right hidden-xs float-right">
                    <input type="hidden" name="submit-from" id="submit-from-btn" value="general">
                    <button type="submit" class="btn btn-warning btn-xs" name="submit" value="Save"><i class="fa fa-save"></i> Save </button>
                   <button type="Submit" name="save_exit" value="save_exit" class="btn btn-success btn-xs submit"><i class="fa fa-save"></i> Save &amp; Exit</button>
                    <a class="btn btn-danger btn-xs" href="<?php echo e(url('/admin/Eligibility')); ?>"><i class="fa fa-times"></i> Cancel</a>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   
    <script type="text/javascript">
        var nameUnique = true
        $(function()
        {
            $(document).find("#recommendation").find("input[type=text], textarea").prop("disabled", true);
            $(document).find("#recommendation").find("select").prop("disabled", true);
        });
        $(document).on("click",".nav-link",function()
        {
            let currTab = $(document).find(".tab-pane.show").attr("id");
            $(document).find("#submit-from-btn").val(currTab);
            if(currTab == "recommendation")
            {
                $(document).find("#general").find("input[type=text], textarea").val("");
                $(document).find("#general").find("select").prop('selectedIndex',0);

                $(document).find("#general").find("select").prop("disabled", true);
                $(document).find("#general").find("input[type=text], textarea").prop("disabled", true);

                $(document).find("#recommendation").find("input[type=text], textarea").prop("disabled", false);
                $(document).find("#recommendation").find("select").prop("disabled", false);
            }
            else
            {
                $(document).find("#recommendation").find("input[type=text], textarea").val("");
                $(document).find("#recommendation").find("select").prop('selectedIndex',0);

                $(document).find("#recommendation").find("input[type=text], textarea").prop("disabled", true);
                $(document).find("#recommendation").find("select").prop("disabled", true);

                $(document).find("#general").find("select").prop("disabled", false);
                $(document).find("#general").find("input[type=text], textarea").prop("disabled", false);
            }
        });

        $(document).on("blur", "input[name='name']", function() {
             $.ajax({    //create an ajax request 
                type: 'POST',
                url: "<?php echo e(url('admin/Eligibility/checkEligiblityName')); ?>", 
                dataType: "json",
                data:{
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "name": encodeURIComponent($(this).val()),
                },
                success: function(response)
                {
                    var obj = $("input[name='name']").parent();
                    if(response==false)
                    {
                        nameUnique = false;
                        $('#name-error').remove();
                        $(obj).append('<label id="name-error" class="error" for="name">Eligibility name should be unique.')
                    }
                    else
                    {
                        nameUnique = true;
                        $('#name-error').remove();
                    }
                }

            });
         });

        jQuery.validator.addMethod("unique", 
            function(value, element) {

                    return nameUnique;
            },'Eligibility name should be unique.');


        $('#eligibility-add').validate({
                rules: {
                    name: {
                        required: true,
                        unique: true
                    }
                },
                messages: {
                    name: {
                        required: "Eligibility name is required.",
                        unique: "Eligibility name should be unique."
                    }
                }
            });
    </script>
    <?php echo $__env->make("Eligibility::js", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\app/Modules/Eligibility/Views/create.blade.php ENDPATH**/ ?>