@extends("layouts.admin.app")
@section('title')
Edit Text | {{config('app.name', 'LeanFrogMagnet'))}}
@endsection 
@section('content')
<div class="card shadow">
    <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
        <div class="page-title mt-5 mb-5">Edit Text</div>
        <div class="">
            <a href="{{url('admin/Configuration')}}" class="btn btn-sm btn-secondary" title="Go Back">Go Back</a>

        </div>
    </div>
</div>
@include("layouts.admin.common.alerts")
<form action="{{url('admin/Configuration/update',$configuration->id)}}" method="post" id="editTranslation">
    {{csrf_field()}}
    <div class="card shadow">
        <div class="card-body">
            <div class="form-group">
                <label for="">Short Code : </label>
                <div class="">
                     <input type="text" id="config_name" class="form-control" value="{{$configuration->config_name}}" name="config_name" readonly="readonly"> 
                    
                </div>
                @if ($errors->any())
                <div class="text-danger">
                  <strong>{{ $errors->first('config_name') }}</strong>
                </div>

                @endif    
            </div>

            @foreach($languages as $lang)
                <input type="hidden" name="languages[]" value="{{$lang->language_code}}">
                <div class="form-group pb-0 mb-0 pt-20">
                    <label class="control-label font-20 text-info"><strong><u>{{$lang->language}}</u></strong></label>
                </div>
                <div class="form-group">
                
                    <div class="">
                        @if($configuration->config_type == "input")
                        <input class="form-control" name="config_value_{{$lang->language_code}}" id="config_value_{{$lang->language_code}}" value="{{ $configuration->config_value ?? ''}}" />    
                        @else
                        <textarea class="form-control editor" name="config_value_{{$lang->language_code}}" id="config_value_{{$lang->language_code}}">{!! $config_arr[$lang->language_code] ?? '' !!}</textarea>
                         @endif
                    </div>
                     
                </div>

            @endforeach
 
            
            <div class="box content-header-floating" id="listFoot">
                <div class="row">
                    <div class="col-lg-12 text-right hidden-xs float-right">
                        <button type="submit" class="btn btn-warning btn-xs submitBtn" name="save"  value="save">
                            <i class="fa fa-save"></i> Save
                        </button>
                        <button type="submit" class="btn btn-success btn-xs" name="save_exit" value="save_exit">
                            <i class="fa fa-save"></i> Save &amp; Exit</button>
                        <a class="btn btn-danger btn-xs" href="{{url('/admin/Configuration')}}"><i class="fa fa-times"></i> Cancel</a>
                    </div>
                </div>
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
    @if($configuration->config_type == "text")
 $( 'textarea.editor').each( function() {

        CKEDITOR.replace( $(this).attr('id'), {
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
    } );

    });
 @endif

</script> 
@endsection