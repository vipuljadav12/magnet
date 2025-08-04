<div class="row editorBox">
	<?php echo $__env->make("Form::editor.title", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">Placeholder Texts</label>
		<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<label class="text-info"><?php echo e($lang->language); ?></label>
			<input type="text" name="placeholder_<?php echo e($lang->language_code); ?>" class="form-control editorInput" data-for="placeholder_<?php echo e($lang->language_code); ?>" build-id="<?php echo e($build->id); ?>" value="<?php echo e(getContentLabelValue($build->id, 'placeholder_'.$lang->language_code) ?? ""); ?>">
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

		
	</div>
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">Number of Characters</label>
		<div class="d-flex align-items-center m-t-5">
			<input type="text" name="min" class="form-control w-30 editorInput"  data-for="min" build-id="<?php echo e($build->id); ?>" value="<?php echo e(getContentValue($build->id,"min") ?? ""); ?>">
			<div class="ml-5 mr-5">to</div>
			<input type="text" name="max" class="form-control editorInput w-30"  data-for="max" build-id="<?php echo e($build->id); ?>" value="<?php echo e(getContentValue($build->id,"max") ?? ""); ?>">
		</div>
	</div>
	
	<?php echo $__env->make("Form::editor.common", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
	
</div>