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
		<h3>{{author_name}} would like your feedback.</h3>

		<p>
			This is a private, unpublished draft. Please review it and leave your feedback in the box below.		</p>

		<p>Note any typos you find, suggestions you have, or links to recommend.</p>
	</div>
	<form class="draftfeedback-first-screen" id="feedbackform" method="post">
		<textarea name="feedback" rows="4" id="feedback-text" style=" margin-top: 0px; margin-bottom: 5px;"></textarea>
                <input type="hidden" name="am2_post_id" value="{{am2_post_id}}" />
		<input type="submit" class="button button-primary" name="Send Feedback" value="Send Feedback">
		<input type="button" class="button draftfeedback-return" value="Back to post">
                
	</form>
</div>
