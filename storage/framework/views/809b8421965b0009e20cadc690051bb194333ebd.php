<style type="text/css">
	
</style>
<div class="row editorBox">
	<?php echo $__env->make("Form::editor.title", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="col-12 m-t-5 optionBox">
		<label class="m-b-5">Text</label>
		<br>
		<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<label class="text-info"><?php echo e($lang->language); ?></label>
			<div class="m-t-5">
				<?php
					$currentOptions = getContentValue($build->id,"checkbox_1_".$lang->language_code);
					if($currentOptions == "")
						$currentOptions = getContentValue($build->id,"checkbox_1");

				?>
				<textarea name="checkbox_1_<?php echo e($lang->language_code); ?>" class="form-control editorInput termtext" data-for="checkbox_1_<?php echo e($lang->language_code); ?>" build-id="<?php echo e($build->id); ?>"><?php echo e($currentOptions); ?></textarea>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


		
	</div>
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">Title Texts</label>
		<br>
		<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<label class="text-info m-t-5"><?php echo e($lang->language); ?></label>
			<div class="">
				<input type="text" name="placeholder_<?php echo e($lang->language_code); ?>" class="form-control editorInput"  data-for="placeholder_<?php echo e($lang->language_code); ?>" build-id="<?php echo e($build->id); ?>" value="<?php echo e(getContentValue($build->id,'placeholder_'.$lang->language_code) ?? getContentValue($build->id,'placeholder')); ?>">
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
	
	<?php echo $__env->make("Form::editor.common", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>