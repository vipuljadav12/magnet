@extends('layouts.admin.app')
@section('title')Edit Communication | {{config('APP_NAME',env("APP_NAME"))}} @endsection
@section('styles')
    
@endsection
@section('content')
<div class="card shadow">
    <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
        <div class="page-title mt-5 mb-5">Edit Communication</div>
    </div>
</div>
    @include("layouts.admin.common.alerts")
   
        <ul class="nav nav-tabs" id="myTab1" role="tablist">
            @foreach($statusArr as $key=>$value)
                @if($status == $key)
                    <li class="nav-item">
                        <a class="nav-link active maintab" id="communication-tab" data-toggle="tab" href="#communication" role="tab" aria-controls="communication" aria-selected="true">{{$value}}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link maintab" href="{{url('/admin/Waitlist/EditCommunication/application/'.$application_id.'/'.$key)}}">{{$value}}</a>
                    </li>
                @endif
            @endforeach

        </ul>
        <div class="tab-content bordered" id="myTab1Content">
            <div class="tab-pane fade show active" id="communication" role="tabpanel" aria-labelledby="communication-tab">
                <ul class="nav nav-tabs custom-nav-tabs" id="myTab2">
                                @if($status != "ContractLetterText")
                                    <li class="nav-item"><a class="nav-link active" id="active-screen-tab" data-toggle="tab" href="#active-screen">Letters</a></li>
                                @endif
                                <li class="nav-item"><a class="nav-link @if($status == "ContractLetterText") active @endif" id="active-email-tab" data-toggle="tab" href="#active-email">Emails</a></li>
                                @if($status != "ContractLetterText")
                                    <li class="nav-item"><a class="nav-link" id="screen-log-tab" data-toggle="tab" href="#screen-log">Letters Log</a></li>
                                    <li class="nav-item"><a class="nav-link" id="email-log-tab" data-toggle="tab" href="#email-log">Emails Log</a></li>
                                @endif
                            </ul>
                            <div class="tab-content tab-validate  bordered" id="myTab2Content">
                                @if($status != "ContractLetterText")
                                <div class="tab-pane fade show active" id="active-screen">
                                     <form class="" action="{{url('admin/Waitlist/EditCommunication/store/letter')}}" method="POST">
                                    {{csrf_field()}}
                                    <input type="hidden" name="application_id" value="{{$application_id}}">
                                    <input type="hidden" name="redirect_status" value="{{$status}}">
                                    <input type="hidden" name="status" value="{{$dbStatusArr[$status]}}">
                                    <div class="form-group d-none">
                                        <label for="">Letter Subject</label>
                                        <div class="">
                                            <input type="text" class="form-control" name="letter_subject" value="{{$data->letter_subject ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="width: 100%">Letter Body : @if(isset($data->letter_body) && $data->letter_body != '')<a href="{{url('/admin/Waitlist/EditCommunication/preview/letter/'.$status.'/'.$application_id)}}" target="_blank" class="btn btn-success" style="float: right !important;">Preview</a>@endif</label>
                                        
                                        <div class="editor-height-210">
                                            <textarea class="form-control" id="letter_body" name="letter_body">
                                            {{$data->letter_body ?? ''}}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group"> <input type="submit" class="btn btn-secondary" value="Save Changes"> @if($display_outcome > 0) @if($status != "ContractLetterText")<input type="submit" name="generate_letter_now" value="Generate Letters Now" class="btn btn-success">@endif @endif</div>
                                    </form>
                                    
                                </div>
                                @endif
                                
                                <div class="tab-pane fade @if($status == "ContractLetterText") show active @endif" id="active-email">
                                    <form class="" action="{{url('admin/Waitlist/EditCommunication/store/email')}}" method="POST">
                                    {{csrf_field()}}
                                    <input type="hidden" name="application_id" value="{{$application_id}}">
                                    <input type="hidden" name="redirect_status" value="{{$status}}">
                                    <input type="hidden" name="status" value="{{$dbStatusArr[$status]}}">

                                    <div class="form-group">
                                        <label style="width: 100%">Mail Subject : @if(isset($data->mail_subject) && $data->mail_body != '')<a href="{{url('/admin/Waitlist/EditCommunication/preview/email/'.$status.'/'.$application_id)}}" target="_blank" class="btn btn-success" style="float: right !important;">Preview</a>@endif</label>
                                        <div class="">
                                            <input type="text" class="form-control" name="mail_subject" id="mail_subjet" value="{{$data->mail_subject ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Mail Body : </label>
                                        <div class="editor-height-210">
                                            <textarea class="form-control" id="mail_body" name="mail_body">
                                           {{$data->mail_body ?? ''}}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group d-none" id="emaillist">
                                        
                                    </div>
                                    <div class="form-group"> <input type="submit" class="btn btn-secondary" value="Save Changes"> @if($display_outcome > 0) @if($status != "ContractLetterText")<a href="javascript:void(0)" class="btn btn-success" onclick="fetchEmails()" id="generate_email_link">Confirm Emails</a>  <input type="submit" name="send_email_now" value="Send Emails" class="btn btn-success d-none" id="generate_email_submit">@endif @endif</div>
                                    </form>
                                    
                                </div>
                                @if($status != "ContractLetterText")
                                    <div class="tab-pane fade" id="screen-log">
                                        @include("Waitlist::letter_log")
                                    </div>
                                    <div class="tab-pane fade" id="email-log">
                                        @include("Waitlist::email_log")
                                    </div>
                                @endif
                            </div>
            </div>
        </div>
     </form>
     
@endsection
@section('scripts')
<script type="text/javascript" src="{{url('/')}}/resources/assets/admin/plugins/laravel-ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="{{url('/resources/assets/admin/plugins/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script type="text/javascript" src="{{url('/')}}/resources/assets/admin/js/additional-methods.min.js"></script>
<script type="text/javascript">

    if($("#letter_body").length > 0)
    {
    CKEDITOR.replace('letter_body',{
             toolbar : 'Basic',
            toolbarGroups: [
                    { name: 'document',    groups: [ 'mode', 'document' ] },            // Displays document group with its two subgroups.
                    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },           // Group's name will be used to create voice label.
                    { name: 'basicstyles', groups: [ 'cleanup', 'basicstyles'] },
                
                    '/',                                                                // Line break - next group will be placed in new line.
                    { name: 'links' }
                ],
                on: {
                pluginsLoaded: function() {
                    var editor = this,
                        config = editor.config;
                    
                    editor.ui.addRichCombo( 'my-combo', {
                        label: 'Insert Short Code',
                        title: 'Insert Short Code',
                        toolbar: 'basicstyles',
                
                        panel: {               
                            css: [ CKEDITOR.skin.getPath( 'editor' ) ].concat( config.contentsCss ),
                            multiSelect: false,
                            attributes: { 'aria-label': 'Insert Short Code' }
                        },
            
                        init: function() {   
                            var chk = []; 
                            $.ajax({
                                url:'{{url('/admin/shortCode/list')}}',
                                type:"get",
                                async: false,
                                success:function(response){
                                    chk = response;
                                }
                            }) 
                            for(var i=0;i<chk.length;i++){
                                this.add( chk[i], chk[i] );
                            }
                        },
            
                        onClick: function( value ) {
                            editor.focus();
                            editor.fire( 'saveSnapshot' );
                           
                            editor.insertHtml( value );
                        
                            editor.fire( 'saveSnapshot' );
                        }
                    } );        
                }        
            }
        });
}

         CKEDITOR.replace('mail_body',{
             toolbar : 'Basic',
            toolbarGroups: [
                    { name: 'document',    groups: [ 'mode', 'document' ] },            // Displays document group with its two subgroups.
                    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },           // Group's name will be used to create voice label.
                    { name: 'basicstyles', groups: [ 'cleanup', 'basicstyles'] },
                
                    '/',                                                                // Line break - next group will be placed in new line.
                    { name: 'links' }
                ],
                on: {
                pluginsLoaded: function() {
                    var editor = this,
                        config = editor.config;
                    
                    editor.ui.addRichCombo( 'my-combo', {
                        label: 'Insert Short Code',
                        title: 'Insert Short Code',
                        toolbar: 'basicstyles',
                
                        panel: {               
                            css: [ CKEDITOR.skin.getPath( 'editor' ) ].concat( config.contentsCss ),
                            multiSelect: false,
                            attributes: { 'aria-label': 'Insert Short Code' }
                        },
            
                        init: function() {   
                            var chk = []; 
                            $.ajax({
                                url:'{{url('/admin/shortCode/list')}}',
                                type:"get",
                                async: false,
                                success:function(response){
                                    chk = response;
                                }
                            }) 
                            for(var i=0;i<chk.length;i++){
                                this.add( chk[i], chk[i] );
                            }
                        },
            
                        onClick: function( value ) {
                            editor.focus();
                            editor.fire( 'saveSnapshot' );
                           
                            editor.insertHtml( value );
                        
                            editor.fire( 'saveSnapshot' );
                        }
                    } );        
                }        
            }
        });

        function fetchEmails()
        {
            if($("#mail_body").val() != "" && $("#mail_subjet").val() != "")
            {
                $("#emaillist").removeClass("d-none");
                $("#emaillist").html("<p class='text-center'>Loading Emails</p>");
                var status = "{{$dbStatusArr[$status]}}";

                 $.ajax({
                    url:'{{url('/admin/Waitlist/EditCommunication/get/emails/')}}',
                    type:"post",
                    data: {'status':status, "_token": "{{csrf_token()}}", "application_id": "{{$application_id}}"},
                    async: false,
                    success:function(response){
                        var data = JSON.parse(response);
                        var html = '<table id="datatable" class="table table-striped mb-0">';
                        html += '<thead>';
                        html += '<tr>';
                        html += '<th class="align-middle w-120 text-center">Submission ID</th>';
                        html += '<th class="align-middle w-120 text-center">Student Name</th>';
                        html += '<th class="align-middle w-120 text-center">Parent Name</th>';
                        html += '<th class="align-middle w-120 text-center">Parent Email</th>';
                        html += '<th class="align-middle w-120 text-center">Grade</th>';
                        html += '</tr>';
                        html += '</thead>';
                        for(i=0; i < data.length; i++)
                        {
                            html += '<tr>';
                            html += '<td class="align-middle w-120 text-center">'+data[i]['id']+'</td>';
                            html += '<td class="align-middle w-120 text-center">'+data[i]['student_name']+'</td>';
                            html += '<td class="align-middle w-120 text-center">'+data[i]['parent_name']+'</td>';
                            html += '<td class="align-middle w-120 text-center">'+data[i]['parent_email']+'</td>';
                            html += '<td class="align-middle w-120 text-center">'+data[i]['grade']+'</td>';
                            html += '</tr>';
                        }
                        html += '</table>';

                        $("#emaillist").html(html);
                        $("#datatable").DataTable();
                        $("#generate_email_submit").removeClass('d-none');
                        $("#generate_email_link").addClass('d-none');

                    }
                })

             }
             else
             {
                alert("Select all fields");
             }
        }
</script>
@endsection