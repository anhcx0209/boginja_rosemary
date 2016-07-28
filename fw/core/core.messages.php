<?php
/**
 * RoseMary Framework: messages subsystem
 *
 * @package	rosemary
 * @since	rosemary 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('rosemary_messages_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_messages_theme_setup' );
	function rosemary_messages_theme_setup() {
		// Core messages strings
		add_action('rosemary_action_add_scripts_inline', 'rosemary_messages_add_scripts_inline');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('rosemary_get_error_msg')) {
	function rosemary_get_error_msg() {
		global $ROSEMARY_GLOBALS;
		return !empty($ROSEMARY_GLOBALS['error_msg']) ? $ROSEMARY_GLOBALS['error_msg'] : '';
	}
}

if (!function_exists('rosemary_set_error_msg')) {
	function rosemary_set_error_msg($msg) {
		global $ROSEMARY_GLOBALS;
		$msg2 = rosemary_get_error_msg();
		$ROSEMARY_GLOBALS['error_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}

if (!function_exists('rosemary_get_success_msg')) {
	function rosemary_get_success_msg() {
		global $ROSEMARY_GLOBALS;
		return !empty($ROSEMARY_GLOBALS['success_msg']) ? $ROSEMARY_GLOBALS['success_msg'] : '';
	}
}

if (!function_exists('rosemary_set_success_msg')) {
	function rosemary_set_success_msg($msg) {
		global $ROSEMARY_GLOBALS;
		$msg2 = rosemary_get_success_msg();
		$ROSEMARY_GLOBALS['success_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}

if (!function_exists('rosemary_get_notice_msg')) {
	function rosemary_get_notice_msg() {
		global $ROSEMARY_GLOBALS;
		return !empty($ROSEMARY_GLOBALS['notice_msg']) ? $ROSEMARY_GLOBALS['notice_msg'] : '';
	}
}

if (!function_exists('rosemary_set_notice_msg')) {
	function rosemary_set_notice_msg($msg) {
		global $ROSEMARY_GLOBALS;
		$msg2 = rosemary_get_notice_msg();
		$ROSEMARY_GLOBALS['notice_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('rosemary_set_system_message')) {
	function rosemary_set_system_message($msg, $status='info', $hdr='') {
		update_option('rosemary_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('rosemary_get_system_message')) {
	function rosemary_get_system_message($del=false) {
		$msg = get_option('rosemary_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			rosemary_del_system_message();
		return $msg;
	}
}

if (!function_exists('rosemary_del_system_message')) {
	function rosemary_del_system_message() {
		delete_option('rosemary_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('rosemary_messages_add_scripts_inline')) {
	function rosemary_messages_add_scripts_inline() {
		global $ROSEMARY_GLOBALS;
		echo '<script type="text/javascript">'
			
			. "if (typeof ROSEMARY_GLOBALS == 'undefined') var ROSEMARY_GLOBALS = {};"
			
			// Strings for translation
			. 'ROSEMARY_GLOBALS["strings"] = {'
				. 'bookmark_add: 		"' . addslashes(esc_html__('Add the bookmark', 'rosemary')) . '",'
				. 'bookmark_added:		"' . addslashes(esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'rosemary')) . '",'
				. 'bookmark_del: 		"' . addslashes(esc_html__('Delete this bookmark', 'rosemary')) . '",'
				. 'bookmark_title:		"' . addslashes(esc_html__('Enter bookmark title', 'rosemary')) . '",'
				. 'bookmark_exists:		"' . addslashes(esc_html__('Current page already exists in the bookmarks list', 'rosemary')) . '",'
				. 'search_error:		"' . addslashes(esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'rosemary')) . '",'
				. 'email_confirm:		"' . addslashes(esc_html__('On the e-mail address <b>%s</b> we sent a confirmation email.<br>Please, open it and click on the link.', 'rosemary')) . '",'
				. 'reviews_vote:		"' . addslashes(esc_html__('Thanks for your vote! New average rating is:', 'rosemary')) . '",'
				. 'reviews_error:		"' . addslashes(esc_html__('Error saving your vote! Please, try again later.', 'rosemary')) . '",'
				. 'error_like:			"' . addslashes(esc_html__('Error saving your like! Please, try again later.', 'rosemary')) . '",'
				. 'error_global:		"' . addslashes(esc_html__('Global error text', 'rosemary')) . '",'
				. 'name_empty:			"' . addslashes(esc_html__('The name can\'t be empty', 'rosemary')) . '",'
				. 'name_long:			"' . addslashes(esc_html__('Too long name', 'rosemary')) . '",'
				. 'email_empty:			"' . addslashes(esc_html__('Too short (or empty) email address', 'rosemary')) . '",'
				. 'email_long:			"' . addslashes(esc_html__('Too long email address', 'rosemary')) . '",'
				. 'email_not_valid:		"' . addslashes(esc_html__('Invalid email address', 'rosemary')) . '",'
				. 'subject_empty:		"' . addslashes(esc_html__('The subject can\'t be empty', 'rosemary')) . '",'
				. 'subject_long:		"' . addslashes(esc_html__('Too long subject', 'rosemary')) . '",'
				. 'text_empty:			"' . addslashes(esc_html__('The message text can\'t be empty', 'rosemary')) . '",'
				. 'text_long:			"' . addslashes(esc_html__('Too long message text', 'rosemary')) . '",'
				. 'send_complete:		"' . addslashes(esc_html__("Send message complete!", 'rosemary')) . '",'
				. 'send_error:			"' . addslashes(esc_html__('Transmit failed!', 'rosemary')) . '",'
				. 'login_empty:			"' . addslashes(esc_html__('The Login field can\'t be empty', 'rosemary')) . '",'
				. 'login_long:			"' . addslashes(esc_html__('Too long login field', 'rosemary')) . '",'
				. 'login_success:		"' . addslashes(esc_html__('Login success! The page will be reloaded in 3 sec.', 'rosemary')) . '",'
				. 'login_failed:		"' . addslashes(esc_html__('Login failed!', 'rosemary')) . '",'
				. 'password_empty:		"' . addslashes(esc_html__('The password can\'t be empty and shorter then 4 characters', 'rosemary')) . '",'
				. 'password_long:		"' . addslashes(esc_html__('Too long password', 'rosemary')) . '",'
				. 'password_not_equal:	"' . addslashes(esc_html__('The passwords in both fields are not equal', 'rosemary')) . '",'
				. 'registration_success:"' . addslashes(esc_html__('Registration success! Please log in!', 'rosemary')) . '",'
				. 'registration_failed:	"' . addslashes(esc_html__('Registration failed!', 'rosemary')) . '",'
				. 'geocode_error:		"' . addslashes(esc_html__('Geocode was not successful for the following reason:', 'wspace')) . '",'
				. 'googlemap_not_avail:	"' . addslashes(esc_html__('Google map API not available!', 'rosemary')) . '",'
				. 'editor_save_success:	"' . addslashes(esc_html__("Post content saved!", 'rosemary')) . '",'
				. 'editor_save_error:	"' . addslashes(esc_html__("Error saving post data!", 'rosemary')) . '",'
				. 'editor_delete_post:	"' . addslashes(esc_html__("You really want to delete the current post?", 'rosemary')) . '",'
				. 'editor_delete_post_header:"' . addslashes(esc_html__("Delete post", 'rosemary')) . '",'
				. 'editor_delete_success:	"' . addslashes(esc_html__("Post deleted!", 'rosemary')) . '",'
				. 'editor_delete_error:		"' . addslashes(esc_html__("Error deleting post!", 'rosemary')) . '",'
				. 'editor_caption_cancel:	"' . addslashes(esc_html__('Cancel', 'rosemary')) . '",'
				. 'editor_caption_close:	"' . addslashes(esc_html__('Close', 'rosemary')) . '"'
				. '};'
			
			. '</script>';
	}
}
?>