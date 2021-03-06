<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    AM2_Writing_Helper
 * @subpackage AM2_Writing_Helper/public/partials
 */

//global $current_user;
//global $post;
if(isset($_GET['p']) && !empty($_GET['p'])){
	$_p = $_GET['p'];
	$p = get_post($_p);
}
else exit();
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="draftfeedback-container
			draftfeedback-feedback-form
			draftfeedback-admin-bar">
	<div class="draftfeedback-thanks draftfeedback-second-screen" id="draftfeedback-thanks">
		<h3>Thank you for your feedback!</h3>
		<p>
			Feel free to close this page and we'll email you when the draft is published for everyone to see. If you want to send anything else, press the button below.		</p>
		<input type="button" class="button button-primary" id="feedback-more" value="Send More Feedback">
		<input type="button" class="button draftfeedback-return" value="Back to post">
	</div>
	<div class="draftfeedback-intro draftfeedback-first-screen" id="draftfeedback-intro">
		<h3><?php echo get_the_author_meta('display_name', $p->post_author);?> would like your feedback. <!--<?php echo $p->post_author; ?> <?php echo $p->ID;?>--></h3>

		<p>
			This is a private, unpublished draft. Please review it and leave your feedback in the box below.		</p>

		<p>Note any typos you find, suggestions you have, or links to recommend.</p>
                
                <textarea name="feedback" rows="8" id="feedback-text" style=" margin-top: 0px; margin-bottom: 5px;"></textarea>
                <input type="hidden" name="post_id" value="<?php echo $p->ID;?>" />
		<input id="am2_submit_feedback" type="submit" class="button button-primary" name="Send Feedback" value="Send Feedback"/>
                <img class="am2_wh_loader" src="<?php echo plugins_url( 'images/ajax-loader.gif', dirname(__FILE__) )?>" style="display:none;width:auto; height:auto;"/>
		<input type="button" class="button draftfeedback-return" value="Back to post">    
	</div>
	<!--<form class="draftfeedback-first-screen" id="feedbackform" method="post">-->
		            
	<!--</form>-->
</div>
