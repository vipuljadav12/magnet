

<?php $__env->startSection('content'); ?>
        <div class="mt-20">
        <div class="card bg-light p-20">
            <div class="text-center font-20 b-600 mb-10">
            
            		<?php if(isset(getConfig()[$msg_type.'_title'])): ?>
	            		<?php
	            			$msg_title = getConfig()[$msg_type.'_title'];
	            			$msg_title = str_replace("###CONFIRMATION_NO###", (isset($confirmation_no) ? $confirmation_no : ""), $msg_title);
	            			$msg_title = str_replace("###STARTOVER###", "<a hrer='".url('/')."' class='btn btn-primary'>".getWordGalaxy('START OVER')."</a>", $msg_title);

	            		?>
	            		<?php echo $msg_title; ?>

	            	<?php endif; ?>


        		</div>
            <div class="">
            	<?php if(isset(getConfig()[$msg_type])): ?>
            		<?php
            			$msg = getConfig()[$msg_type];
            			$msg = str_replace("###CONFIRMATION_NO###", (isset($confirmation_no) ? $confirmation_no : ""), $msg);
            			$msg = str_replace("###STARTOVER###", "<a hrer='".url('/')."' class='btn btn-primary'>".getWordGalaxy('START OVER')."</a>", $msg);

            		?>
            		<?php echo $msg; ?>

            	<?php endif; ?>

                <?php if($msg_type != "before_application_open_text" && $msg_type != "after_application_open_text" && $msg_type != "no_grade_info" && $msg_type != "writingprompt_success" && $msg_type != "recommendation_success" && $msg_type != "recommendation_date_passed"): ?>
                    <?php if(Session::has("from_admin")): ?>
                        <a href="<?php echo e(url('/phone/submission')); ?>" class="btn btn-info"><?php echo getWordGalaxy('START OVER'); ?></a>
                    <?php else: ?>
                        <a href="<?php echo e(url('/')); ?>" class="btn btn-info"><?php echo getWordGalaxy('START OVER'); ?></a>
                    <?php endif; ?>
                <?php elseif($msg_type == "no_grade_info"): ?>
                    <a href="<?php echo e(url('/')); ?>" class="btn btn-info"><?php echo getWordGalaxy('EXIT'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
  $(document).ready(function () {
    function disableBack() {window.history.forward()}

    window.onload = disableBack();
    window.onpageshow = function (evt) {if (evt.persisted) disableBack()}
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\resources\views/layouts/errors/msgs.blade.php ENDPATH**/ ?>