<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <div class="">
       
        <div class="card shadow">
        <div class="card-header">Racial Composition</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label for="">Black</label>
                        <div class="">
                            <input disabled value="{{$enrollment_racial->black}}" type="text" maxlength="10" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label for="">White</label>
                        <div class="">
                            <input disabled value="{{$enrollment_racial->white}}" type="text" maxlength="10" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label for="">Other</label>
                        <div class="">
                            <input disabled value="{{$enrollment_racial->other}}" type="text" maxlength="10" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label for="">Swing (%)</label>
                        <div class="">
                            <input disabled value="{{$enrollment_racial->swing}}" type="text" maxlength="10" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="card shadow">
            <div class="card-header">Acceptance Window</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <label class="">Last day and time to accept ONLINE</label>

                        <div class="input-append date form_datetime">
                        <input class="form-control datetimepicker" name="last_date_online_acceptance" id="last_date_online_acceptance" value="{{$last_date_online_acceptance}}" data-date-format="mm/dd/yyyy hh:ii">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="">Last day and time to accept OFFLINE</label>
                        <div class="input-append date form_datetime"> <input class="form-control datetimepicker" name="last_date_offline_acceptance" id="last_date_offline_acceptance"  value="{{$last_date_offline_acceptance}}" data-date-format="mm/dd/yyyy hh:ii"></div>
                    </div>
                </div>
                <div class="text-right pt-20"><input type="submit" class="btn btn-success" title="Process Submissions Now" value="Process Submissions Now"></div>    
            </div>
        </div>
        
    </div>
