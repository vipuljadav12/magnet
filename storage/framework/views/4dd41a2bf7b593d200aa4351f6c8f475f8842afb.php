<?php if(isset($formContents) && !empty($formContents)): ?>
	<?php $__currentLoopData = $formContents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f=>$formContent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		
		
		<?php echo $__env->make("Form::container.".getFieldBox($formContent->field_id)->type,compact("formContent"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>