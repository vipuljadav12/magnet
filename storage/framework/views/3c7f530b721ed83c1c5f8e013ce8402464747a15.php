<?php $__env->startSection('title'); ?>
    <title>Huntsville City Schools</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('language_change'); ?>
<div class="mt-20 col-12 text-right top-links text-right"><div class=""><a href="javascript:void(0);" onclick="changeLanguage();" title="English">English</a> | <a href="javascript:void(0);" onClick="changeLanguage('spanish');"  title="Spanish">Spanish</a></div></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(!Session::has("from_admin")): ?>
         <?php echo $__env->make("layouts.front.common.district_header", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
    <?php endif; ?>

    <?php if(isset($applications) && !empty($applications)): ?>
        <div class="box-0 text-center">
            <div class="form-group text-center p-20 border mt-20 mb-20">
                <div class="card shadow">
                    <div class="card-body">
                        <p class="text-center"><strong><?php echo getWordGalaxy('Please select a form'); ?>:</strong></p>
                        <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(Session::has('default_language') && Session::get('default_language') != "english"): ?>
                                <?php
                                    $language_name = json_decode($application->language_name);
                                    $default_language = Session::get("default_language");
                                    
                                    if(isset($language_name->$default_language))
                                        $application_name = $language_name->$default_language;
                                    else
                                        $application_name = $application->application_name;
                                ?>
                            <?php else: ?>
                                <?php $application_name = $application->application_name ?>
                            <?php endif; ?>
                            <div class="col-sm-12 p-10 m-10">
                            <a href="<?php echo e(url('/application/'.$application->id)); ?>" class="btn btn-secondary submit-btn p-20 b-600"><?php echo e($application_name); ?></a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
          
    <?php else: ?>
        <div class="box-0 text-center p-20 border mt-20 mb-20">
            <div class="form-group">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="b-600 font-14 mb-10 text-danger"><?php echo getWordGalaxy('No Application is open for submission'); ?>.</div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>