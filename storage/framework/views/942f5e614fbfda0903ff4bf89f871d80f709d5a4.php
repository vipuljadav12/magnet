<div class="row editorBox">
	<?php echo $__env->make("Form::editor.title", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">Title Text</label>
		<input type="text" name="label" class="form-control editorInput" data-for="label" build-id="<?php echo e($build->id); ?>" value="<?php echo e(getContentValue($build->id,"label") ?? ""); ?>">
	</div>
	
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">First Option Title Text</label>
		<input type="text" name="first_option_text_title" class="form-control editorInput" data-for="first_option_text_title" build-id="<?php echo e($build->id); ?>" value="<?php echo e(getContentValue($build->id,"first_option_text_title") ?? ""); ?>">
	</div>
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">Second Option Title Text</label>
		<input type="text" name="second_option_text_title" class="form-control editorInput" data-for="second_option_text_title" build-id="<?php echo e($build->id); ?>" value="<?php echo e(getContentValue($build->id,"second_option_text_title") ?? ""); ?>">
	</div>
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">Second Program Display</label>
		<select class="form-control editorInput " name="second_display" data-for="second_display"  build-id="<?php echo e($build->id); ?>">
			<option value="yes" <?php if(getContentValue($build->id,"second_display") != null && getContentValue($build->id,"second_display") == "yes"): ?> selected <?php endif; ?>>Yes</option>
			<option value="no" <?php if(getContentValue($build->id,"second_display") != null && getContentValue($build->id,"second_display") == "no"): ?> selected <?php endif; ?>>No</option>

		</select>
	</div>
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">Sibling Display</label>
		<select class="form-control editorInput " name="sibling_display" data-for="sibling_display"  build-id="<?php echo e($build->id); ?>">
			<option value="yes" <?php if(getContentValue($build->id,"sibling_display") != null && getContentValue($build->id,"sibling_display") == "yes"): ?> selected <?php endif; ?>>Yes</option>
			<option value="no" <?php if(getContentValue($build->id,"sibling_display") != null && getContentValue($build->id,"sibling_display") == "no"): ?> selected <?php endif; ?>>No</option>

		</select>
	</div>
	

	<?php echo $__env->make("Form::editor.common", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>