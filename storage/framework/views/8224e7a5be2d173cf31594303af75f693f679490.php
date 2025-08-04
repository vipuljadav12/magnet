<?php $__env->startSection('title'); ?>
	Selection Report Master
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
    .alert1 {
    position: relative;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
    border-radius: 0.25rem;
}
.dt-buttons {position: absolute !important;}
.w-50{width: 50px !important}
.content-wrapper.active {z-index: 9999 !important}
</style>
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Report</div>
            <div class=""><a class=" btn btn-secondary btn-sm" href="<?php echo e(url('/admin/Reports/')); ?>" title="Go Back">Go Back</a></div>
        </div>
    </div>
    <div class="">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="needs1-tab" data-toggle="tab" href="#needs1" role="tab" aria-controls="needs1" aria-selected="true">Selection Report Master</a></li>
            </ul>
            <div class="tab-content bordered" id="myTabContent">
                <div class="tab-pane fade show active" id="needs1" role="tabpanel" aria-labelledby="needs1-tab">
                    <ul class="nav nav-tabs" id="myTab1" role="tablist1">
                        <?php $__currentLoopData = $gradeTab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($value==$existGrade): ?>
                                <li class="nav-item"><a class="nav-link active" id="grade1-tab" data-toggle="tab" href="#grade1" role="tab" aria-controls="grade1" aria-selected="true">Grade <?php echo e($value); ?></a></li>
                            <?php else: ?>
                                <li class="nav-item"><a class="nav-link" href="<?php echo e(url('admin/Reports/Waitlist/Selection/'.$application_id.'/'.$value)); ?>">Grade <?php echo e($value); ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <div class="tab-content bordered" id="myTabContent1">
                        <div class="tab-pane fade show active" id="grade1" role="tabpanel" aria-labelledby="grade1-tab">
                            <div class="">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="text-right mb-10 d-flex justify-content-end align-items-center">
                                            <input type="checkbox" class="js-switch js-switch-1 js-switch-xs status" data-size="Small"  id="hideRace" <?php if($settings->race == "Y"): ?> checked <?php endif; ?> />&nbsp;Hide Race&nbsp;&nbsp;<input type="checkbox" class="js-switch js-switch-1 js-switch-xs status" data-size="Small"  id="hideZone" <?php if($settings->zoned_school == "Y"): ?> checked <?php endif; ?> />&nbsp;Hide Zone School&nbsp;&nbsp;<input type="checkbox" class="js-switch js-switch-1 js-switch-xs status" data-size="Small"  id="hideCommittee" <?php if($settings->committee_score == "Y"): ?> checked <?php endif; ?>/>&nbsp;Hide Committee
                                            <?php if(count($test_scores_titles) > 0): ?>&nbsp;&nbsp;<input type="checkbox" class="js-switch js-switch-1 js-switch-xs status" data-size="Small"  id="hideTestScore" <?php if($settings->test_scores == "Y"): ?> checked <?php endif; ?>/>&nbsp;Hide Test Scores
                                            <?php endif; ?>
                                            &nbsp;&nbsp;<input type="checkbox" class="js-switch js-switch-1 js-switch-xs status" data-size="Small"  id="hideGrade" <?php if($settings->grade == "Y"): ?> checked <?php endif; ?> />&nbsp;Hide Grade
                                            <div class="d-none" style="padding-left: 5px;"><a href="<?php echo e(url('/CDI-All.xls')); ?>" class="btn btn-secondary">Export</a></div>
                                        </div>
                                        <?php $config_subjects = Config::get('variables.subjects') ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0 w-100" id="datatable">
                                                <thead>
                                                    <?php if(count($year) > 0): ?>
                                                        <?php $rawspan = ' rowspan=2' ?>
                                                    <?php else: ?>
                                                        <?php $rawspan = "" ?>
                                                    <?php endif; ?>
                                                    <tr>
                                                        <th class="align-middle text-center"<?php echo e($rawspan); ?>>Sub ID</th>
                                                        <th class="align-middle text-center"<?php echo e($rawspan); ?>>Submission Status</th>
                                                        <th class="align-middle hiderace text-center"<?php echo e($rawspan); ?>>Race</th>
                                                        <th class="align-middle text-center"<?php echo e($rawspan); ?>>Student Status</th>
                                                        <th class="align-middle text-center"<?php echo e($rawspan); ?>>First Name</th>
                                                        <th class="align-middle text-center"<?php echo e($rawspan); ?>>Last Name</th>
                                                        <th class="align-middle text-center"<?php echo e($rawspan); ?>>Next Grade</th>
                                                        <th class="align-middle text-center"<?php echo e($rawspan); ?>>Current School</th>
                                                        <th class="align-middle hidezone text-center"<?php echo e($rawspan); ?>>Zoned School</th>
                                                        <th class="align-middle text-center"<?php echo e($rawspan); ?>>First Choice</th>
                                                        <th class="align-middle text-center"<?php echo e($rawspan); ?>>Second Choice</th>
                                                        <th class="align-middle text-center"<?php echo e($rawspan); ?>>Sibling ID</th>
                                                        <th class="align-middle text-center"<?php echo e($rawspan); ?>>Lottery Number</th>
                                                        <th class="align-middle text-center"<?php echo e($rawspan); ?>>Priority</th>
                                                        <?php $__currentLoopData = $year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tyear => $tvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <th class="align-middle text-center grade-col" colspan="<?php echo e(count($subjects)); ?>"><?php echo e($tvalue); ?></th>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <th class="align-middle text-center committee_score-col"<?php echo e($rawspan); ?>>
                                                        <?php if($preliminary_score): ?>
                                                            Composite Score
                                                        <?php else: ?>
                                                            Committee Score
                                                        <?php endif; ?>
                                                        </th>
                                                        <?php $__currentLoopData = $test_scores_titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts=>$tv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <th class="align-middle text-center test_scores-col" colspan="2"><?php echo e($tv); ?></th>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tr>
                                                    <?php if(count($year) > 0 || count($test_scores_titles) > 0): ?>
                                                        <tr>
                                                            <?php $__currentLoopData = $year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tyear => $tvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <th class="align-middle text-center grade-col"><?php echo e($config_subjects[$value]); ?></th>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php $__currentLoopData = $test_scores_titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts=>$tv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <th class="align-middle text-center test_scores-col">Scores</th>
                                                                <th class="align-middle text-center test_scores-col">Rank</th>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tr>
                                                        
                                                    <?php endif; ?>
                                                    
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $firstdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class=""><?php echo e($value['id']); ?></td>
                                                            <td class="text-center"><?php echo e($value['submission_status']); ?></td>
                                                            <td class="hiderace"><?php echo e($value['race']); ?></td>
                                                            <td class="">
                                                                <?php if($value['student_id'] != ''): ?>
                                                                    Current
                                                                <?php else: ?>
                                                                    New
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class=""><?php echo e($value['first_name']); ?></td>
                                                            <td class=""><?php echo e($value['last_name']); ?></td>
                                                            
                                                            <td class="text-center"><?php echo e($value['next_grade']); ?></td>
                                                            <td class=""><?php echo e($value['current_school']); ?></td>
                                                            <td class="hidezone"><?php echo e($value['zoned_school']); ?></td>
                                                            <td class=""><?php echo e($value['first_program']); ?></td>
                                                            <td class="text-center"><?php echo e($value['second_program']); ?></td>
                                                            <td class="">
                                                                <?php if($value['first_sibling'] != ''): ?>
                                                                    <div class="alert1 alert-success p-10 text-center"><?php echo e($value['first_sibling']); ?></div>
                                                                <?php else: ?>
                                                                    <div class="alert1 alert-warning p-10 text-center">NO</div>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class=""><?php echo e($value['lottery_number']); ?></td>
                                                            <td class="text-center">
                                                                <div class="alert1 alert-success">
                                                                    <?php echo e($value['rank']); ?>

                                                                </div>
                                                            </td>
                                                            <?php $__currentLoopData = $year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tyear => $tvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sjkey=>$sjvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php $__currentLoopData = $value['score']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skey=>$svalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php if($svalue['subject'] == $config_subjects[$sjvalue] && $svalue['academic_year'] == $tvalue): ?>
                                                                            <td class="text-center grade-col"><?php echo e($svalue['grade']); ?></td> 
                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <td class="text-center committee_score-col">
                                                                <?php if($preliminary_score): ?>
                                                                    <?php $class="alert-success" ?>
                                                                    <?php $comValue = $value['composite_score'] ?>
                                                                <?php else: ?>
                                                                    <?php if($value['committee_score_status'] == "Pending"): ?>
                                                                        <?php $class = "alert-warning" ?>
                                                                        <?php if($value['committee_score'] != "NA"): ?>
                                                                        <?php $comValue = '<i class="fas fa-exclamation"></i>' ?>
                                                                        <?php else: ?>
                                                                        <?php $class = "" ?>
                                                                        <?php $comValue = "NA" ?>
                                                                        <?php endif; ?>
                                                                    <?php elseif($value['committee_score_status'] == "Fail"): ?>
                                                                        <?php $class = "alert-danger" ?>
                                                                        <?php $comValue = $value['committee_score'] ?>
                                                                    <?php else: ?>
                                                                        <?php $class = "alert-success" ?>
                                                                        <?php $comValue = $value['committee_score'] ?>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <div class="alert1 <?php echo e($class); ?>">
                                                                    <?php echo $comValue; ?>

                                                                </div>
                                                            </td>
                                                            <?php $__currentLoopData = $test_scores_titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts=>$tv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $tstScores = $value['test_scores'] ?>
                                                                <?php if(isset($tstScores[$tv])): ?>
                                                                    <td class="align-middle text-center test_scores-col"><?php echo e($tstScores[$tv]['value']); ?></td>
                                                                    <td class="align-middle text-center test_scores-col"><?php echo e($tstScores[$tv]['score']); ?></td>
                                                                <?php else: ?>
                                                                    <td class="align-middle text-center test_scores-col"></td>
                                                                    <td class="align-middle text-center test_scores-col"></td>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__currentLoopData = $seconddata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class=""><?php echo e($value['id']); ?></td>
                                                            <td class="text-center"><?php echo e($value['submission_status']); ?></td>
                                                            <td class="hiderace"><?php echo e($value['race']); ?></td>
                                                            <td class="">
                                                                <?php if($value['student_id'] != ''): ?>
                                                                    Current
                                                                <?php else: ?>
                                                                    New
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class=""><?php echo e($value['first_name']); ?></td>
                                                            <td class=""><?php echo e($value['last_name']); ?></td>
                                                             
                                                            <td class="text-center"><?php echo e($value['next_grade']); ?></td>
                                                            <td class=""><?php echo e($value['current_school']); ?></td>
                                                            <td class="hidezone"><?php echo e($value['zoned_school']); ?></td>
                                                            <td class=""><?php echo e($value['first_program']); ?></td>
                                                            <td class="text-center"><?php echo e($value['second_program']); ?></td>
                                                            <td class="">
                                                                <?php if($value['second_sibling'] != ''): ?>
                                                                    <div class="alert1 alert-success p-10 text-center"><?php echo e($value['second_sibling']); ?></div>
                                                                <?php else: ?>
                                                                    <div class="alert1 alert-warning p-10 text-center">NO</div>
                                                                <?php endif; ?>

                                                            </td>
                                                            <td class=""><?php echo e($value['lottery_number']); ?></td>
                                                             <td class="text-center">
                                                                <div class="alert1 alert-success">
                                                                    <?php echo e($value['rank']); ?>

                                                                </div>
                                                            </td>

                                                             <?php $__currentLoopData = $year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tyear => $tvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sjkey=>$sjvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php $__currentLoopData = $value['score']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skey=>$svalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php if($svalue['subject'] == $config_subjects[$sjvalue] && $svalue['academic_year'] == $tvalue): ?>
                                                                            <td class="text-center grade-col"><?php echo e($svalue['grade']); ?></td> 
                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            <td class="text-center committee_score-col">
                                                                <?php if($preliminary_score): ?>
                                                                    <?php $class="alert-success" ?>
                                                                    <?php $comValue = $value['composite_score'] ?>
                                                                <?php else: ?>
                                                                    <?php if($value['committee_score_status'] == "Pending"): ?>
                                                                        <?php $class = "alert-warning" ?>
                                                                        <?php if($value['committee_score'] != "NA"): ?>
                                                                                <?php $comValue = '<i class="fas fa-exclamation"></i>' ?>
                                                                        <?php else: ?>
                                                                                <?php $class = "" ?>
                                                                                <?php $comValue = "NA" ?>
                                                                        <?php endif; ?>
                                                                    <?php elseif($value['committee_score_status'] == "Fail"): ?>
                                                                        <?php $class = "alert-danger" ?>
                                                                        <?php $comValue = $value['committee_score'] ?>
                                                                    <?php else: ?>
                                                                        <?php $class = "alert-success" ?>
                                                                        <?php $comValue = $value['committee_score'] ?>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <div class="alert1 <?php echo e($class); ?>">
                                                                    <?php echo $comValue; ?>

                                                                </div>
                                                            </td>

                                                            <?php $__currentLoopData = $test_scores_titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts=>$tv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php $tstScores = $value['test_scores'] ?>
                                                                <?php if(isset($tstScores[$tv])): ?>
                                                                    <td class="align-middle text-center test_scores-col"><?php echo e($tstScores[$tv]['value']); ?></td>
                                                                    <td class="align-middle text-center test_scores-col"><?php echo e($tstScores[$tv]['score']); ?></td>
                                                                <?php else: ?>
                                                                    <td class="align-middle text-center test_scores-col"></td>
                                                                    <td class="align-middle text-center test_scores-col"></td>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/dataTables.buttons.min.js"></script>
<!--<script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/jszip.min.js"></script>
<script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/pdfmake.min.js"></script>
<script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/vfs_fonts.js"></script>-->
<script src="<?php echo e(url('/resources/assets/admin')); ?>/js/bootstrap/buttons.html5.min.js"></script>

	<script type="text/javascript">
		//$("#datatable").DataTable({"aaSorting": []});
        var dtbl_submission_list = $("#datatable").DataTable({"aaSorting": [],
            "bSort" : false,
             "dom": 'Bfrtip',
             "autoWidth": true,
            // "scrollX": true,
             buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Reports',
                        text:'Export to Excel',
                        //Columns to export
                        exportOptions: {
                                columns: "thead th:not(.d-none)"
                        }
                    }
                ]
            });

        $("#hideGrade").change(function(){
            if($(this).prop("checked") == true)
            {
                $('.grade-col').addClass("d-none");
                dtbl_submission_list.$('.grade-col').addClass("d-none");
                var update = "Y";
            }
            else
            {
                $('.grade-col').removeClass("d-none");
                dtbl_submission_list.$('.grade-col').removeClass("d-none");
                var update = "N";
            }
            $.ajax({
                    url : "<?php echo e(url('/admin/Reports/setting/update/grade/')); ?>/"+update,
                    type: "GET"
            });
        })

        $("#hideCommittee").change(function(){
            if($(this).prop("checked") == true)
            {
                $('.committee_score-col').addClass("d-none");
                dtbl_submission_list.$('.committee_score-col').addClass("d-none");
                var update = "Y";
            }
            else
            {
                $('.committee_score-col').removeClass("d-none");
                dtbl_submission_list.$('.committee_score-col').removeClass("d-none");

                var update = "N";

            }
            $.ajax({
                    url : "<?php echo e(url('/admin/Reports/setting/update/committee_score/')); ?>/"+update,
                    type: "GET"
            });

        })        

        $("#hideRace").change(function(){
            if($(this).prop("checked") == true)
            {
                $('.hiderace').addClass("d-none");
                dtbl_submission_list.$('.hiderace').addClass("d-none");

                var update = "Y";        
            }
            else
            {
                $('.hiderace').removeClass("d-none");
                dtbl_submission_list.$('.hiderace').removeClass("d-none");
                var update = "N";
            }
            $.ajax({
                    url : "<?php echo e(url('/admin/Reports/setting/update/race/')); ?>/"+update,
                    type: "GET"
            });
        })        

        $("#hideZone").change(function(){
            if($(this).prop("checked") == true)
            {
                $('.hidezone').addClass("d-none");
                dtbl_submission_list.$('.hidezone').addClass("d-none");
                var update = "Y";            
            }
            else
            {
                $('.hidezone').removeClass("d-none");
                dtbl_submission_list.$('.hidezone').removeClass("d-none");
                var update = "N";
            }
            $.ajax({
                    url : "<?php echo e(url('/admin/Reports/setting/update/zoned_school/')); ?>/"+update,
                    type: "GET"
            });
        })

        $("#hideTestScore").change(function(){
            if($(this).prop("checked") == true)
            {
                $('.test_scores-col').addClass("d-none");
                dtbl_submission_list.$('.test_scores-col').addClass("d-none");
                var update = "Y";            
            }
            else
            {
                $('.test_scores-col').removeClass("d-none");
                dtbl_submission_list.$('.test_scores-col').removeClass("d-none");
                var update = "N";
            }
            $.ajax({
                    url : "<?php echo e(url('/admin/Reports/setting/update/test_scores/')); ?>/"+update,
                    type: "GET"
            });
        })

        $(document).ready(function(){
            var hideArr = new Array();
            <?php if($settings->race == "Y"): ?> 
                $('.hiderace').addClass("d-none");
               dtbl_submission_list.$('.hiderace').addClass("d-none");

            <?php endif; ?>       

            <?php if($settings->zoned_school == "Y"): ?>         
                $('.hidezone').addClass("d-none");
               dtbl_submission_list.$('.hidezone').addClass("d-none");

            <?php endif; ?>       

            <?php if($settings->grade == "Y"): ?> 
                $('.grade-col').addClass("d-none");
                dtbl_submission_list.$('.grade-col').addClass("d-none");

            <?php endif; ?>       

            <?php if($settings->committee_score == "Y"): ?> 
                $('.committee_score-col').addClass("d-none");
                dtbl_submission_list.$('.committee_score-col').addClass("d-none");
                 

            <?php endif; ?>

            <?php if($settings->test_scores == "Y"): ?> 
                $('.test_scores-col').addClass("d-none");
                dtbl_submission_list.$('.test_scores-col').addClass("d-none");
                 

            <?php endif; ?>   
        });    
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>