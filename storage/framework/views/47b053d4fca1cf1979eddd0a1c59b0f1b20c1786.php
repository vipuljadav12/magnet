<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/resources/assets/front/css/jquery.countdownTimer.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <div class="mt-20">
    <div class="card bg-light p-20">
      <div class="row">
          <div class="col-sm-6 col-xs-12 font-16 b-600">Student Name: <span><?php echo e($data['submission']->first_name." ".$data['submission']->last_name); ?></span></div>
          <div class="col-sm-6 text-right font-16 col-xs-12 b-600">Student's Submission ID: <span><?php echo e($data['submission']->confirmation_no); ?></span></div>
      </div>
      <div class="row">
          <div class="col-sm-6 col-xs-12 font-16 b-600 mt-10">Program Name: <span><?php echo e(getProgramName($data['program_id'])); ?></span></div>
          <div class="col-sm-6 text-right font-16 col-xs-12 b-600 mt-10">Next Grade: <span><?php echo e($data['submission']->next_grade); ?></span></div>
      </div>

      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <div class="text-left font-20 b-600"></div>
        </div>
        <div class="col-sm-6 col-xs-12 text-sm-right text-xs-center mt-20 font-16 b-600">Time Remaining: <span id="hs_timer" class="text-danger"></span></div>
      </div>
      
    </div>
  </div>
  <form class="p-20 border mt-20 mb-20" id="frm_wp_exam_store" method="post" action="<?php echo e(url('WritingPrompt/store/exam')); ?>">
  <?php echo e(csrf_field()); ?>

    <div class="row pt-20">
        <div class="col-12">
        <p><?php echo isset($data['intro_txt']) ? $data['intro_txt'] : ''; ?></p>
      </div>
      </div>
    <div class="box-0">

      <?php if(!empty($data['wp_question'])): ?>
        <?php $__currentLoopData = $data['wp_question']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $wp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="form-group row">
            <input type="hidden" name="writing_prompt[<?php echo e($key); ?>]" value="<?php echo e($wp); ?>">
            <label class="control-label col-12 col-md-12 col-xl-12 b-600" for="qry01"><?php echo e($wp); ?> : </label>
            <div class="col-12 col-md-12 col-xl-12">
              <textarea class="form-control" name="writing_sample[<?php echo e($key); ?>]" rows="7" id="qry01"></textarea>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>
      
      <div class="form-group row">
        <div class="col-12 col-md-12 col-xl-12"> <button type="submit" class="btn btn-secondary btn-xxl" title="" style="height: 55px; width: 140px;">Submit</a> </div>
      </div>
    </div>
  </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript" src="<?php echo e(url('/resources/assets/front/js/jquery.countdownTimer.js')); ?>"></script> 
<script type="text/javascript">

  <?php
    $total_minutes = $data['duration'] ?? 0; 
    $res = ($total_minutes/60);
    $hours = intval($res);
    $minutes = ($res-$hours) * 60;
  ?>

  var hours = "<?php echo e(isset($hours) ? $hours : '0'); ?>";
  var minutes = "<?php echo e(isset($minutes) ? $minutes : '0'); ?>";
  // var time_duration = "<?php echo e(isset($data['wp_config']->duration) ? $data['wp_config']->duration : '0'); ?>";

  $(function(){
    $('#hs_timer').countdowntimer({
      hours : hours,
      minutes : minutes,
      seconds : 0,
      size : "sm",
      // tickInterval : 5‚
      // timeSeparator : "-"‚
      timeUp : timeisUp
    });

    function timeisUp() {
      $('#frm_wp_exam_store').submit();
    }

  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>