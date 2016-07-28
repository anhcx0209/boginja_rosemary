<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'rosemary_template_form_2_theme_setup' ) ) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_template_form_2_theme_setup', 1 );
	function rosemary_template_form_2_theme_setup() {
		rosemary_add_template(array(
			'layout' => 'form_2',
			'mode'   => 'forms',
			'title'  => esc_html__('Contact Form 2', 'rosemary')
			));
	}
}

// Template output
if ( !function_exists( 'rosemary_template_form_2_output' ) ) {
	function rosemary_template_form_2_output($post_options, $post_data) {
		global $ROSEMARY_GLOBALS;
		$address_1 = rosemary_get_theme_option('contact_address_1');
		$address_2 = rosemary_get_theme_option('contact_address_2');
		$phone = rosemary_get_theme_option('contact_phone');
		$email = rosemary_get_theme_option('contact_email');
		?>
		<div class="sc_columns columns_wrap">
			<div class="sc_form_fields column-2_3">
				<form <?php echo ($post_options['id'] ? ' id="'.esc_attr($post_options['id']).'"' : ''); ?> data-formtype="<?php echo esc_attr($post_options['layout']); ?>" method="post" action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : $ROSEMARY_GLOBALS['ajax_url']); ?>">
					<div class="sc_form_info">
						<div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_username"><?php esc_html_e('Name', 'rosemary'); ?></label><input id="sc_form_username" type="text" name="username" placeholder="<?php esc_attr_e('Name', 'rosemary'); ?>"></div><div class="sc_form_item sc_form_field label_over">
						<label class="required" for="sc_form_email"><?php esc_html_e('E-mail', 'rosemary'); ?></label><input id="sc_form_email" type="text" name="email" placeholder="<?php esc_attr_e('E-mail', 'rosemary'); ?>"></div>
					</div>
					<div class="sc_form_item sc_form_message label_over"><label class="required" for="sc_form_message"><?php esc_html_e('Message', 'rosemary'); ?></label><textarea id="sc_form_message" name="message" placeholder="<?php esc_attr_e('Message', 'rosemary'); ?>"></textarea></div>
					<div class="sc_form_item sc_form_button"><button><?php esc_html_e('Send Message', 'rosemary'); ?></button></div>
					<div class="result sc_infobox"></div>
				</form>
			</div><div class="sc_form_address column-1_3">
				<div class="sc_form_address_field">
					<span class="item_icon icon-location"></span><span class="sc_form_address_data"><?php echo trim($address_1) ?></span>
				</div>
				<div class="sc_form_address_field">
					<span class="item_icon icon-phone-1"></span><span class="sc_form_address_data"><?php echo trim($phone) ?></span>
				</div>
				<div class="sc_form_address_field">
					<span class="item_icon icon-mail"></span><span class="sc_form_address_data"><a href="<?php echo esc_url('mailto:' . $email) ?>"><?php echo trim($email); ?></a></span>
				</div>
			</div>
		</div>
		<?php
	}
}
?>