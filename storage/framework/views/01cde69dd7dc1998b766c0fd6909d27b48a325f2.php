            <table>
                <tr>
                        <td class="text-center align-middle" style="font-size: 10px;">Report Owner:  <strong>Magnet Programs Coordinator</strong><br><br>Data Source:  <strong>MyPick Magnet System/ Student<br>Informations System</strong></td>
                        <td class="text-center align-middle" style="font-size: 10px;" colspan="4">Consent Order Reference: <strong>II.F.1</strong></td>
                        <td></td>
                        <td class="text-center align-middle" style="font-size: 10px;" colspan="6"><strong>Revision Date:</strong> </td>

                          

                    </tr>
                <thead>
                    
               
                        <tr>
                            <th class="text-center align-middle" style="font-size: 10px;" rowspan="2">Name of Magnet Program/School</th>
                            <th class="text-center align-middle" colspan="3">Number of Applicants</th>
                            <th class="text-center align-middle" colspan="3">Number of Students<br>Offered</th>
                            <th class="text-center align-middle" colspan="3">Number of Students Denied Due to <br>Committee Review</th>
                            <th class="text-center align-middle" colspan="3">Number of Students Denied Due to <br>Space</th>
                            <th class="text-center align-middle" colspan="3">Total Number of Students <br>Withdrew/Transferred (include reasons)</th>
                            <th class="text-center align-middle" colspan="3">Total Number of Applicants<br> Enrolled</th>
                            <th class="text-center" colspan="3">Total School Enrollment <br> October 1</th>
                        </tr>
                        <tr>
                            <?php $__currentLoopData = $race_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rk=>$rv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="align-middle"><?php echo e($rv); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $race_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rk=>$rv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="align-middle"><?php echo e($rv); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $race_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rk=>$rv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="align-middle"><?php echo e($rv); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $race_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rk=>$rv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="align-middle"><?php echo e($rv); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $race_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rk=>$rv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="align-middle"><?php echo e($rv); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $race_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rk=>$rv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="align-middle"><?php echo e($rv); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $race_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rk=>$rv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="align-middle"><?php echo e($rv); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $court_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($value['name']); ?></td>
                                <!-- Application Count -->
                                <td class="text-center"><?php echo e($value['applications']['Black']); ?></td>
                                <td class="text-center"><?php echo e($value['applications']['White']); ?></td>
                                <td class="text-center"><?php echo e($value['applications']['Other']); ?></td>

                                <!-- Offered Count -->
                                <td class="text-center"><?php echo e($value['offered']['Black']); ?></td>
                                <td class="text-center"><?php echo e($value['offered']['White']); ?></td>
                                <td class="text-center"><?php echo e($value['offered']['Other']); ?></td>

                                <!-- Ineligible Count -->
                                <td class="text-center"><?php echo e($value['ineligible']['Black']); ?></td>
                                <td class="text-center"><?php echo e($value['ineligible']['White']); ?></td>
                                <td class="text-center"><?php echo e($value['ineligible']['Other']); ?></td>

                                <!-- Denied Space Count -->
                                <td class="text-center"><?php echo e($value['denied_space']['Black']); ?></td>
                                <td class="text-center"><?php echo e($value['denied_space']['White']); ?></td>
                                <td class="text-center"><?php echo e($value['denied_space']['Other']); ?></td>

                                <!-- Withdrawn Count -->
                                <td class="text-center"><?php echo e($value['withdrawn']['Black']); ?></td>
                                <td class="text-center"><?php echo e($value['withdrawn']['White']); ?></td>
                                <td class="text-center"><?php echo e($value['withdrawn']['Other']); ?></td>

                                <!-- Enrolled Count -->
                                <td class="text-center"><?php echo e($value['enrolled_data']['Black']); ?></td>
                                <td class="text-center"><?php echo e($value['enrolled_data']['White']); ?></td>
                                <td class="text-center"><?php echo e($value['enrolled_data']['Other']); ?></td>

                                <!-- 1st Oc Enrolled Count -->
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                    <tbody>
                        

                    </tbody>
                </table>

<table>
    <tr><th colspan="4" align="center" style="text-align: center !important;">Total Number of Applicants</th></tr>
    <tr>
        <th>Applicants</th>
        <th>#<br>Black</th>
        <th>#<br>White</th>
        <th>#<br>Other</th>
    </tr>
    <tr>
        <th rowspan="2">Totals</th>
        <th><?php echo e($Black); ?></th>
        <th><?php echo e($White); ?></th>
        <th><?php echo e($Other); ?></th>
    </tr>
    <tr>
        <td colspan="3"><?php echo e($Black+$White+$Other); ?></td>
    </tr>
    <tr><td colspan="4"></td></tr>
    <tr><td colspan="4"></td></tr>

    <tr><td colspan="4">MyPick System Report Date: <strong><?php echo e(getDateTimeFormat(date("Y-m-d H:i:s"))); ?></strong></td></tr>
</table>