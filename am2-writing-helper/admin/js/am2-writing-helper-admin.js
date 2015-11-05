(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-specific JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
        
        $(document).ready(function(){
            $('#invitetoshare #add-request-custom').on('click', function(){
               console.log(AM2Ajax);  
               
               $('.am2_wh_loader').show();
               $('#am2_wh_status_mails > div').hide();
               
               $.post(AM2Ajax.ajaxurl,{
                   action: AM2Ajax.plugin_name + '_send_invites',
                   am2WritingHelperNonce: AM2Ajax.am2WritingHelperNonce, 
                   invite_data : { 
                       invite_list: $('#invitetoshare #invitelist').val(),
                       custom_text: $('#invitetoshare #modify-email > textarea').val(),
                       post_id: $('#invitetoshare input[name="am2_current_post_id"]').val()
                    }
               },function(resp){
                   $('#am2_writing_helper .am2_wh_success').html('Successfully sent to: ');                   
                   
                   var success = [];
                   var fail = [];
                   
                   for(var obj in resp){
                      console.log(obj);
                      
                      $('.am2_wh_loader').hide();
                      
                      if(resp[obj] == true)
                          success.push(obj);                          
                      else
                          fail.push(obj);
                   }
                   
                   $('#am2_writing_helper .am2_wh_success').append(success.join(', '));
                   $('#am2_wh_status_mails > div').show();
                   //$('#am2_writing_helper .am2_wh_fail').append(fail.join(', '));
               }) ;
            });
            
            $('#invitetoshare .am2_wh_revoke_link').on('click', function(){
                var reviewers_hash = $(this).data('reviewers-hash');
                var $this = $(this);
                console.log(reviewers_hash);                              
               
               $.post(AM2Ajax.ajaxurl,{
                   action: AM2Ajax.plugin_name + '_revoke_link',
                   am2WritingHelperNonce: AM2Ajax.am2WritingHelperNonce, 
                   invite_data : { 
                       reviewers_hash: reviewers_hash,
                       post_id: $('#invitetoshare input[name="am2_current_post_id"]').val()
                    }
               },function(resp){
                   if(resp.status === 'success'){
                       $this.closest('.am2_feedback').remove();
                   }
               }) ;
            });
        });
        

})( jQuery );
