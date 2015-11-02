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
               $.post(AM2Ajax.ajaxurl,{
                   action: AM2Ajax.plugin_name + '_send_invites',
                   am2WritingHelperNonce: AM2Ajax.am2WritingHelperNonce, 
                   invite_data : { 
                       invite_list: $('#invitetoshare #invitelist').val(),
                       custom_text: $('#invitetoshare #modify-email > textarea').val(),
                       post_id: $('#invitetoshare input[name="am2_current_post_id"]').val()
                    }
               },function(resp){
                   console.log(resp);
               }) ;
            });
        });
        

})( jQuery );
