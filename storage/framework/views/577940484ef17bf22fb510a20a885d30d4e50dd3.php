<table>
    <thead>
        <?php
            $ts_index = array_search('Test Scores', $fields);
            $ts_count = count($ts_field_ary);
        ?>
        <!-- First Header row -->
        <?php if($ts_index !== false && $ts_count>0): ?>
            <tr>
                <?php
                    $ts_index = array_search('Test Scores', $fields);
                ?>
                <th colspan="<?php echo e($ts_index); ?>"></th>
                <th colspan="<?php echo e(($ts_count*2)); ?>">Test Scores</th>
            </tr>
        <?php endif; ?>
        <!-- Second Header row -->
        <tr>
            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($ts_count>0 && $field == 'Test Scores'): ?>
                    <?php for($i=0; $i<2; $i++): ?>
                        <?php $__currentLoopData = $ts_field_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts_field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $score_type = ($i==0 ? 'Value' : 'Rank');
                                $ts_field .= ' - '.$score_type;
                            ?>
                            <th>
                                <?php echo e(isset($ts_field) ? $ts_field : ''); ?>

                            </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endfor; ?>
                <?php else: ?>
                    <th><?php echo e(isset($field) ? $field : ''); ?></th>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
    </thead>
    <tbody>
        <!-- Data rows -->
        <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s_key => $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <?php $__currentLoopData = $submission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($ts_count>0 && $field == 'ts_data'): ?>
                        <?php for($i=0; $i<2; $i++): ?>
                            <?php $__currentLoopData = $ts_field_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts_field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $score_type = ($i==0 ? 'value' : 'rank');
                                ?>
                                <th>
                                    <?php echo e(($value[$score_type][$ts_field] ?? '')); ?>

                                </th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endfor; ?>
                    <?php else: ?>
                        <td><?php echo e(isset($value) ? $value : ''); ?></td>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>