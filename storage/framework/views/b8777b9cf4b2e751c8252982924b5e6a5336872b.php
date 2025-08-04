<style type="text/css">
	
</style>
<div class="row editorBox">
	<?php echo $__env->make("Form::editor.title", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
	<div class="col-12 m-t-5">
		<label class="m-b-5">Dependent Field</label>
		<input type="text" name="dependent_field" class="form-control editorInput" data-for="dependent_field" build-id="<?php echo e($build->id); ?>" value="<?php echo e(getContentValue($build->id,"dependent_field") ?? ""); ?>">
	</div>
	
	<div class="col-12 m-t-5 optionBox">
		<label class="m-b-5">Options</label>
		<div class="m-t-5">
			<?php
				$currentOptions = getContentRadio($build->id);
				$count = 0;
			?>
			<?php if(isset($currentOptions) && !empty($currentOptions)): ?>
				<?php $__currentLoopData = $currentOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c=>$currentOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>					
					<div class="row m-t-5">
						<div class="col-6">
							<input type="text" name="<?php echo e($currentOption->field_property); ?>" class="form-control editorInput radioboxList"  data-for="<?php echo e($currentOption->field_property); ?>" build-id="<?php echo e($build->id); ?>" value="<?php echo e(getContentValue($build->id,$currentOption->field_property) ?? ""); ?>">
						</div>
						<div class="col-6">
							<a class="btn text-primary addMoreRadio"><i class="fa fa-plus"></i></a>
							<a class="btn text-primary removeMoreRadio"  content-id="<?php echo e($currentOption->id); ?>"><i class="fa fa-minus"></i></a>
						</div>
					</div>
					<?php $count = $count + 1; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
			<?php if($count == 0): ?>
				<div class="row m-t-5">
					<div class="col-6">
						<input type="text" name="radio_1" class="form-control  editorInput radioList"  data-for="radio_1" build-id="<?php echo e($build->id); ?>" value="<?php echo e(getContentValue($build->id,"radio_1") ?? ""); ?>">
					</div>
					<div class="col-6">
						<a class="btn text-primary addMoreRadio"><i class="fa fa-plus"></i></a>
						<a class="btn text-primary d-none removeMoreRadio"><i class="fa fa-minus"></i></a>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	
	<?php echo $__env->make("Form::editor.common", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>