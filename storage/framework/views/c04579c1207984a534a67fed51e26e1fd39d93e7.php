    
<?php $__env->startSection('title'); ?>
	Edit Submission
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
  .error {
        color: red;
    }
</style>
	<div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Offer Email Preview</div>
            <div class=""><a class=" btn btn-secondary btn-sm" href="<?php echo e(url('admin/Submissions/edit/'.$id)); ?>" title="Go Back">Go Back</a></div>
        </div>
    </div>
            <div class="tab-pane fade show active" id="grades0" role="tabpanel" aria-labelledby="grades0-tab">
              <div class="card shadow">
                <div class="card-body">
                  
                  <form action="<?php echo e(url('/admin/Submissions/general/send/offer/email/'.$type.'/'.$id)); ?>" method="post">
                    <?php echo e(csrf_field()); ?>

                    <textarea class="form-control" id="mail_body" name="mail_body" style="height: 600px;"><?php echo $msg; ?>

                    </textarea>
                    
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success mr-10 mt-10" title="Submit">Send Offer Email</button>
                    </div>
                  </form>
              </div>
              </div>
            </div>
        

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(url('/')); ?>/resources/assets/admin/plugins/laravel-ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo e(url('/resources/assets/admin/plugins/laravel-ckeditor/adapters/jquery.js')); ?>"></script>
    <script type="text/javascript">
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
                                    url:'<?php echo e(url('/admin/shortCode/list')); ?>',
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
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>