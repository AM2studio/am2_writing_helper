(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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
            if(AM2Ajax.valid_request){
                $.post(AM2Ajax.ajaxurl,{
                    action: AM2Ajax.plugin_name + '_get_submit_form_markup',
                    am2WritingHelperNonce: AM2Ajax.am2WritingHelperNonce,
                    am2_sharedraft: AM2Ajax.am2_sharedraft,
                    post_id: AM2Ajax.post_id
                }, function(resp){
                    resp = resp.replace('{{author_name}}', AM2Ajax.post_author).replace('{{am2_post_id}}', AM2Ajax.post_id);
                    $('body').append(resp);
                });
            }
        });

})( jQuery );
