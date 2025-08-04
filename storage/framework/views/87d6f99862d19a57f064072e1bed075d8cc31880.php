<div class='form-group form-group-input row buildBox<?php echo e($formContent->id); ?>' data-build-id="<?php echo e($formContent->id); ?>" id="<?php echo e($formContent->id); ?>">
        <?php
            $required = getContentValue($formContent->id,"required");
            $required = isset($required) ?  "required" : "";

            $term_text = getContentValue($formContent->id,"checkbox_1");

            

        ?>
    <div class="col-11 row">
        
        <div class="col-12">
            <input type="checkbox" class="chkbox-style form-check-input1" id="table00" name="selectCheck" style="">
            <label for="table00" class="label-xs check-secondary"></label>
        
        
        
            <div class="" id="input<?php echo e($formContent->id); ?>"><?php echo e($term_text); ?></div>
        </div>
    </div>

   
    <div class="col-1">
    	<a class="btn text-danger removeField"><i class="fa fa-times"></i></a>
    </div>
</div>