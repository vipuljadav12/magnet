<style type="text/css">
    .mailpreview {
        padding: 26px;
        border: 2px solid #ccc;
        background: #fff !important;
        height: 500px;
        overflow: scroll;
    }
</style>
<form class="form" id="manual_process_form" method="post" action="<?php echo e(url('admin/Submissions/store/manual/process/'.$submission->id)); ?>">
    <?php echo e(csrf_field()); ?>

    <div class="card shadow">
        <div class="card-header">Manual Process</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-xl-6">
                        <div class="form-group col-12">
                            <label for="">First Choice Program : </label>
                            <div class="">
                                <select class="form-control custom-select" name="first_choice" id="manual_first_choice">
                                    <option value="<?php echo e($submission->first_choice_program_id); ?>"><?php echo e(getProgramName($submission->first_choice_program_id)); ?> - Grade <?php echo e($submission->next_grade); ?></option>
                                </select>
                            </div>
                        </div>

                </div>
                <div class="col-12 col-xl-6">
                        <div class="form-group col-12">
                            <label for="">First Choice Program Status : </label>
                            <div class="">
                                <select class="form-control custom-select" name="first_choice_final_status" id="first_choice_final_status" <?php if($offer_data->manually_updated == "Y"): ?> disabled <?php endif; ?>>
                                    <option value="">Select Status</option> 
                                    <option value="Offered" <?php if($offer_data->first_choice_final_status == "Offered"): ?> selected="" <?php endif; ?>>Offered</option>
                                    <option value="Waitlisted" <?php if($offer_data->first_choice_final_status == "Waitlisted"): ?> selected="" <?php endif; ?>>Waitlisted</option> 
                                </select>
                            </div>
                        </div>

                </div>
            </div> 

            <?php if($submission->second_choice != ''): ?>
             <div class="row">
                <div class="col-12 col-xl-6">
                        <div class="form-group col-12">
                            <label for="">Second Choice Program : </label>
                            <div class="">
                                <select class="form-control custom-select" name="second_choice" id="manual_second_choice">
                                        <option value="<?php echo e($submission->second_choice_program_id); ?>"><?php echo e(getProgramName($submission->second_choice_program_id)); ?> - Grade <?php echo e($submission->next_grade); ?></option>
                                </select>
                            </div>
                        </div>

                </div>
                <div class="col-12 col-xl-6">
                        <div class="form-group col-12">
                            <label for="">Second Choice Program Status : </label>
                            <div class="">
                                <select class="form-control custom-select" name="second_choice_final_status" id="second_choice_final_status" <?php if($offer_data->manually_updated == "Y"): ?> disabled <?php endif; ?>>
                                    <option value="">Select Status</option>
                                    <option value="Offered" <?php if($offer_data->second_choice_final_status == "Offered"): ?> selected="" <?php endif; ?>>Offered</option>
                                    <option value="Waitlisted" <?php if($offer_data->second_choice_final_status == "Waitlisted"): ?> selected="" <?php endif; ?>>Waitlisted</option>  
                                </select>
                            </div>
                        </div>

                </div>
            </div> 
            <?php endif; ?>
             <div class="card shadow">
                    <div class="card-header">Acceptance Window</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <label class="">Last day and time to accept ONLINE</label>

                                <div class="input-append date form_datetime">
                                <input class="form-control datetimepicker" name="last_date_online_acceptance" id="last_date_online_acceptance"  value="<?php echo e($last_date_online_acceptance); ?>" data-date-format="mm/dd/yyyy hh:ii">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="">Last day and time to accept OFFLINE</label>
                                <div class="input-append date form_datetime"> <input class="form-control datetimepicker" name="last_date_offline_acceptance" id="last_date_offline_acceptance"  value="<?php echo e($last_date_offline_acceptance); ?>" data-date-format="mm/dd/yyyy hh:ii"></div>
                            </div>
                        </div>    
                    </div>
                </div>
             <?php if($offer_data->manually_updated != "Y"): ?>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-secondary" title="Submit">Submit</button>
                </div>
            <?php endif; ?>

            <?php if($offer_data->manually_updated == "Y"): ?>
                <?php if($offer_data->communication_sent == "N"): ?>
                    <div id="emaildiv" class="mailpreview d-none"></div>
                    <div class="form-group text-right">
                        <a href="<?php echo e(url('/')); ?>/admin/Submissions/general/send/offer/email/ProcessSelection/<?php echo e($submission->id); ?>/preview" class="btn btn-success mr-10" title="Submit" id="previewemailnow" >Preview Offer Email</a>
                        <!--<button type="button" class="btn btn-secondary mr-10" title="Submit" id="previewemailnow" onclick="previewIndividualOfferEmail()">Preview Offer Email</button>
                        <button type="button" class="btn btn-success mr-10 mt-10 d-none" id="sendemailnow" title="Submit" onclick="sendIndividualOfferEmail()">Send Offer Email</button>-->
                    </div>
                <?php else: ?>
                 <div class="form-group text-right">
                        <button type="button" class="btn btn-danger mr-10" title="Submit">Send Offer Email</button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
        </div>
    </div>
</form>