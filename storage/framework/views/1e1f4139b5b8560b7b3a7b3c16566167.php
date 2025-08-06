
<?php $__env->startSection('title'); ?>
    Dashboard
<?php $__env->stopSection(); ?>
<?php $__env->startSection('styles'); ?>
<style type="text/css">
    .modal-body{
        max-height: 550px;
        overflow-y: auto !important;
        /*background-color: */
    }
    .dt-buttons{float: right !important; padding-bottom: 5px;}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
        <div class="card shadow">
            <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                <div class="page-title mt-5 mb-5">Offer Management Dashboard</div>
                <div class="">
                    <select class="form-control custom-select w-250" id="switch_dashboard">
                    <option value="magnet">Super Admin - Application</option>
                    <option value="mcpss">District Admin - Application</option>
                    <option value="superoffer">Super Admin - Offer</option>
                    <option value="districtoffer" selected>District Admin - Offer</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-30" style="width: 20% !important; max-width: 20% !important;">
                <div class="border shadow p-20 text-center">
                    <div class="border border-3 border-secondary rounded-circle d-inline-block w-90 h-90 d-flex align-items-center justify-content-center ml-auto mr-auto mb-20 font-28 font-weight-bold"><i class="fas fa-user-check"></i></div>
                    <div class="font-16 font-weight-bold">Total Offered</div>
                    <hr class="border-3 max-width-100">
                    <div class="font-24 font-weight-bold"><?php echo e($data['offer_count']); ?></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-30" style="width: 20% !important; max-width: 20% !important;">
                <div class="border shadow p-20 text-center">
                    <div class="border border-3 border-secondary rounded-circle d-inline-block w-90 h-90 d-flex align-items-center justify-content-center ml-auto mr-auto mb-20 font-28 font-weight-bold"><i class="fas fa-user-clock"></i></div>
                    <div class="font-16 font-weight-bold">Total Waitlist</div>
                    <hr class="border-3 max-width-100">
                    <div class="font-24 font-weight-bold"><?php echo e($data['waitlist_count']); ?></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-30" style="width: 20% !important; max-width: 20% !important;">
                <div class="border shadow p-20 text-center">
                    <div class="border border-3 border-secondary rounded-circle d-inline-block w-90 h-90 d-flex align-items-center justify-content-center ml-auto mr-auto mb-20 font-28 font-weight-bold"><i class="fas fa-user-plus"></i></div>
                    <div class="font-16 font-weight-bold">Total Outstanding Offers</div>
                    <hr class="border-3 max-width-100">
                    <div class="font-24 font-weight-bold"><?php echo e($data['outstanding_offer']); ?></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-30" style="width: 20% !important; max-width: 20% !important;">
                <div class="border shadow p-20 text-center">
                    <div class="border border-3 border-secondary rounded-circle d-inline-block w-90 h-90 d-flex align-items-center justify-content-center ml-auto mr-auto mb-20 font-28 font-weight-bold"><i class="fas fa-user-minus"></i></div>
                    <div class="font-16 font-weight-bold">Total Denied Due to Ineligibility</div>
                    <hr class="border-3 max-width-100">
                    <div class="font-24 font-weight-bold"><?php echo e($data['ineligibility_count']); ?></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-30" style="width: 20% !important; max-width: 20% !important;">
                <div class="border shadow p-20 text-center">
                    <div class="border border-3 border-secondary rounded-circle d-inline-block w-90 h-90 d-flex align-items-center justify-content-center ml-auto mr-auto mb-20 font-28 font-weight-bold"><i class="fas fa-user-times"></i></div>
                    <div class="font-16 font-weight-bold">Total Denied Due to Incomplete Record</div>
                    <hr class="border-3 max-width-100">
                    <div class="font-24 font-weight-bold"><?php echo e($data['incomplete_count']); ?></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 mb-20">
                <div class="page-title mt-5 mb-5" style="padding-bottom: 10px !important">Available Seats Status</div>
                <div class="card shadow h-100 mb-0">
                    <div class="card-header">
                        <select class="form-control custom-select" id="change_program1">
                            <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value->id); ?>" <?php if($program_id == $value->id): ?> selected <?php endif; ?>><?php echo e($value->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="myChart1" width="1023" height="716" style="display: block; height: 573px; width: 819px;" class="chartjs-render-monitor"></canvas>
                        <div class="custom-legends" id="js-legend1"><ul class="0-legend"><li><span style="background-color:#00FFFF"></span>Outstanding Offers</li><li><span style="background-color:#00ca70"></span>Offered and Accepted</li></ul></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mb-20">
                <div class="page-title mt-5 mb-5" style="padding-bottom: 10px !important">All Offers Status</div>
                <div class="card shadow h-100 mb-0">
                    <div class="card-header">
                        <select class="form-control custom-select" id="change_program2">
                            <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value->id); ?>" <?php if($program_id == $value->id): ?> selected <?php endif; ?>><?php echo e($value->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                        </select>
                    </div>
                    <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="myChart2" width="1023" height="716" style="display: block; height: 573px; width: 819px;" class="chartjs-render-monitor"></canvas>
                        <div class="custom-legends" id="js-legend2"><ul class="1-legend"><li><span style="background-color:#4b78b8"></span>Total Outstanding Offer</li><li><span style="background-color:#00ca70"></span>Total Offered and Accepted</li><li><span style="background-color:#ffbf00"></span>Total Declined / Waitlisted for other</li><li><span style="background-color:#e95b54"></span>Total Offered and Declined</li></ul></div>
                    </div>
                </div>
            </div>
        </div>

<!-- Modals end -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript" src="<?php echo e(url('/resources/assets/admin/js/Chart.min.js')); ?>"></script>     

<script type="text/javascript">
    
    /* switch dashboard start */
    $('#switch_dashboard').change(function() {
        if ($(this).val() == "magnet") {
            window.location = "<?php echo e(url('admin/magnet_dashboard')); ?>";
        }
    });
    /* switch dashboard end */

    /*Chart 1*/ 
    var label1 = [<?php echo $arr['grades']; ?>];    
    var data1 = {
        labels: label1,
    //    datasets: [{
    //        data: [9, 8, 10, 12, 9, 11],
    //        backgroundColor: '#00ca70',
    //        borderWidth: 2
    //    }]
        datasets: [{
                label: 'Total Available Seats',
                backgroundColor: '#ffbf00',
                borderColor: '#ffbf00',
                fill: false,
                data: [<?php echo e(implode(",", $arr['availableArr'])); ?>],
                borderWidth: 2
            },{
            label: 'Outstanding Offers',
            backgroundColor: '#4b78b8',
            borderColor: '#4b78b8',
            fill: false,
            data: [<?php echo e(implode(",", $arr['outstandingArr'])); ?>],
            borderWidth: 2
        },{
            label: 'Offered and Accepted',
            backgroundColor: '#00ca70',
            borderColor: '#00ca70',
            fill: false,
            data: [<?php echo e(implode(",", $arr['offerArr'])); ?>],
            borderWidth: 2
        }]
    };    

    var option1 = {
        responsive: true,
        legend : {
            display: false
        },
        scales: {
            xAxes: [{
                stacked: true,
                gridLines: false,
            }],
            yAxes: [{
                stacked: true,
                ticks: {
                    min: 0,
                    //stepSize: 10,
                    //max: 50
                }
            }]
        },
    }
    var ctx1 = document.getElementById('myChart1').getContext('2d');
    var myChart1 = new Chart(ctx1, {
        type: 'bar',
        data: data1,
        options: option1,
    });
    //legends
    document.getElementById('js-legend1').innerHTML = myChart1.generateLegend();    
    /*Chart 2*/
    var data2 = {
        labels: ['Total Outstanding Offer','Total Offered and Accepted','Total Declined / Waitlisted for other','Total Offered and Declined'],
        datasets: [{
            label: '',
            data: [<?php echo e($arr1['OutstandingOffered']); ?>,<?php echo e($arr1['OfferedAccepted']); ?>, <?php echo e($arr1['OfferedWaitlisted']); ?>, <?php echo e($arr1['OfferedDeclined']); ?>],
            backgroundColor: ['#4b78b8','#00ca70','#ffbf00','#e95b54'],
            borderWidth: 2
        }]
    }    
    var ctx2 = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'doughnut',
        data: data2,
        options: {
            responsive: true,
            legend : {
                display: false
            }
        },
        plugins: [{
            beforeDraw: function(chart, options) {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;

                ctx2.restore();
                var fontSize = (height / 114).toFixed(2);
                ctx2.font = fontSize + "em Open Sans";
                ctx2.textBaseline = "middle";

                var text = "<?php echo e($arr1['OutstandingOffered']); ?>",
                    textX = Math.round((width - ctx2.measureText(text).width) / 2),
                    textY = height / 2;

                ctx2.fillText(text, textX, textY);
            }
        }]
    });    
    //legends
    document.getElementById('js-legend2').innerHTML = myChart2.generateLegend();    
    //// center text
/*    Chart.pluginService.register({
      beforeDraw: function(chart) {
        var width = chart.chart.width,
            height = chart.chart.height,
            ctx = chart.chart.ctx;

        ctx2.restore();
        var fontSize = (height / 114).toFixed(2);
        ctx2.font = fontSize + "em Open Sans";
        ctx2.textBaseline = "middle";

        var text = "<?php echo e($arr1['OutstandingOffered'] + $arr1['OfferedAccepted'] + $arr1['OfferedWaitlisted'] + $arr1['OfferedDeclined']); ?>",
            textX = Math.round((width - ctx2.measureText(text).width) / 2),
            textY = height / 2;

        ctx2.fillText(text, textX, textY);
        ctx2.save();
      }
    });*/   


    document.getElementById("change_program1").onchange = function () {
        myChart1.destroy();
        var cc = $(this).val();
        $.ajax({
            type: 'get',
            dataType: 'JSON',
            url: "<?php echo e(url('admin/districtadmin/offer/chart1/')); ?>/"+cc,
            success: function(response) {

                var tmp = response.grades.split(",");
                var grades = new Array();
                for($i=0; $i < tmp.length; $i++)
                {
                    var str  = tmp[$i].replace('"', "");
                    grades[$i] = str.replace('"', "");
                } 
                var availableArr = $.map(response.availableArr, function(value, index) {
                    return [value];
                });
                var offerArr = $.map(response.offerArr, function(value, index) {
                    return [value];
                });
                var outstandingArr = $.map(response.outstandingArr, function(value, index) {
                    return [value];
                });

                    var data1 = {
                        labels: grades,
                        datasets: [{
                            label: 'Total Available Seats',
                            backgroundColor: '#ffbf00',
                            borderColor: '#ffbf00',
                            fill: false,
                            data: availableArr,
                            borderWidth: 2
                        },{
                            label: 'Outstanding Offers',
                            backgroundColor: '#4b78b8',
                            borderColor: '#4b78b8',
                            fill: false,
                            data: outstandingArr,
                            borderWidth: 2
                        },{
                            label: 'Offered and Accepted',
                            backgroundColor: '#00ca70',
                            borderColor: '#00ca70',
                            fill: false,
                            data: offerArr,
                            borderWidth: 2
                        }]
                    };
                    console.log(data1);
                    var ctx1 = document.getElementById('myChart1').getContext('2d');

                     var option1 = {
                            responsive: true,
                            legend : {
                                display: false
                            },
                            scales: {
                                xAxes: [{
                                    stacked: true,
                                    gridLines: false,
                                }],
                                yAxes: [{
                                    stacked: true,
                                    ticks: {
                                        min: 0,
                                        //stepSize: 10,
                                        //max: 50
                                    }
                                }]
                            },
                        }
                    myChart1 = new Chart(ctx1, {
                        type: 'bar',
                        data: data1,
                        options: option1,
                    });
   
            }
        });

        
        }


    document.getElementById("change_program2").onchange = function () {
        myChart2.destroy();     
        var cc = $(this).val();
        $.ajax({
            type: 'get',
            dataType: 'JSON',
            url: "<?php echo e(url('admin/districtadmin/offer/chart2/')); ?>/"+cc,
            success: function(response) {
                var data2 = {
                    labels: ['Total Outstanding Offer','Total Offered and Accepted','Total Declined / Waitlisted for other','Total Offered and Declined'],
                    datasets: [{
                        label: '',
                        data: [response.OutstandingOffered, response.OfferedAccepted, response.OfferedWaitlisted, response.OfferedDeclined],
                        backgroundColor: ['#4b78b8','#00ca70','#ffbf00','#e95b54'],
                        borderWidth: 2
                    }]
                } 

                myChart2 = new Chart(ctx2, {
                    type: 'doughnut',
                    data: data2,
                    options: {
                        responsive: true,
                        legend : {
                            display: false
                        }
                    },
                    plugins: [{
                        afterDraw: function(chart, options) {
                            var width = chart.chart.width,
                                height = chart.chart.height,
                                ctx = chart.chart.ctx;

                            ctx2.restore();
                            var fontSize = (height / 114).toFixed(2);
                            ctx2.font = fontSize + "em Open Sans";
                            ctx2.textBaseline = "middle";

                            var text = response.OutstandingOffered,
                                textX = Math.round((width - ctx2.measureText(text).width) / 2),
                                textY = height / 2;
                            // text = 'new';
                            ctx2.fillText(text, textX, textY);
                            ctx2.save();
                        }
                    }]
                }); 

                /* Chart.pluginService.register({
                      beforeDraw: function(chart) {
                        var width = chart.chart.width,
                            height = chart.chart.height,
                            ctx = chart.chart.ctx;

                        ctx2.restore();
                  
                        var text = response.OutstandingOffered + response.OfferedAccepted + response.OfferedWaitlisted + response.OfferedDeclined,
                            textX = Math.round((width - ctx2.measureText(text).width) / 2),
                            textY = height / 2;

                        ctx2.fillText(text, textX, textY);
                        ctx2.save();
                      }
                    }); */  
            }
        });

        
        }

    

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\vipuljadav\www\projects\laravel\MagnetHCS\resources\views/layouts/admin/dashboard_district_admin_offer.blade.php ENDPATH**/ ?>