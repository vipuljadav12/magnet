<div class="card-header col-12">	
	<i class="<?php echo e($field->icon ?? ""); ?>"></i> <span><?php echo e(ucwords($field->name) ?? ""); ?></span>
</div>
<div class="col-12 m-t-5 editor-col-spaces p-10">
	<label class="m-b-5">Field Name</label>
	<br>
	<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<label class="text-info"><?php echo e($lang->language); ?></label>
		<input type="text" name="label_<?php echo e($lang->language_code); ?>" class="form-control editorInput" data-for="label_<?php echo e($lang->language_code); ?>" build-id="<?php echo e($build->id); ?>" value="<?php echo e(getContentLabelValue($build->id, 'label_'.$lang->language_code) ?? ""); ?>">
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>