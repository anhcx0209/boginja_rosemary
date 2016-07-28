<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'rosemary_template_form_custom_theme_setup' ) ) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_template_form_custom_theme_setup', 1 );
	function rosemary_template_form_custom_theme_setup() {
		rosemary_add_template(array(
			'layout' => 'form_custom',
			'mode'   => 'forms',
			'title'  => esc_html__('Custom Form', 'rosemary')
			));
	}
}

// Template output
if ( !function_exists( 'rosemary_template_form_custom_output' ) ) {
	function rosemary_template_form_custom_output($post_options, $post_data) {
		global $ROSEMARY_GLOBALS;
		?>
		<form <?php echo ($post_options['id'] ? ' id="'.esc_attr($post_options['id']).'"' : ''); ?> data-formtype="<?php echo esc_attr($post_options['layout']); ?>" method="post" action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : $ROSEMARY_GLOBALS['ajax_url']); ?>">
			<?php echo trim($post_options['content']); ?>
			<div class="result sc_infobox"></div>
		</form>
		<?php
	}
}
?>