<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'rosemary_template_form_1_theme_setup' ) ) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_template_form_1_theme_setup', 1 );
	function rosemary_template_form_1_theme_setup() {
		rosemary_add_template(array(
			'layout' => 'form_1',
			'mode'   => 'forms',
			'title'  => esc_html__('Contact Form 1', 'rosemary')
			));
	}
}

// Template output
if ( !function_exists( 'rosemary_template_form_1_output' ) ) {
	function rosemary_template_form_1_output($post_options, $post_data) {
		global $ROSEMARY_GLOBALS;
		?>
		<form <?php echo ($post_options['id'] ? ' id="'.esc_attr($post_options['id']).'"' : ''); ?> data-formtype="<?php echo esc_attr($post_options['layout']); ?>" method="post" action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : $ROSEMARY_GLOBALS['ajax_url']); ?>">
			<div class="sc_columns columns_wrap">
			<div class="column-1_2">
				<div class="sc_form_item sc_form_field label_over">
					<label class="required" for="sc_form_username"><?php esc_html_e('Имя', 'rosemary'); ?></label>
					<input id="sc_form_username" type="text" name="username" placeholder="<?php esc_attr_e('Имя', 'rosemary'); ?>">
				</div>
				<div class="sc_form_item sc_form_field label_over">
					<label class="required" for="sc_form_phone"><?php esc_html_e('Телефон', 'rosemary'); ?></label>
					<input id="sc_form_phone" type="text" name="phone" placeholder="<?php esc_attr_e('Телефон', 'rosemary'); ?>">
				</div>
			</div><div class="column-1_2">
				<div class="sc_form_item sc_form_message label_over">
					<label class="required" for="sc_form_message"><?php esc_html_e('Сообщение', 'rosemary'); ?></label>
					<textarea id="sc_form_message" name="message" placeholder="<?php esc_attr_e('Сообщение', 'rosemary'); ?>"></textarea>
				</div>
			</div>
			</div>
			<div class="sc_form_item sc_form_button"><button><?php esc_html_e('Отправить', 'rosemary'); ?></button></div>
			<div class="result sc_infobox"></div>
		</form>
		<?php
	}
}
?>