<?php
/**
 * RoseMary Framework: shortcodes manipulations
 *
 * @package	rosemary
 * @since	rosemary 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('rosemary_sc_theme_setup')) {
	add_action( 'rosemary_action_init_theme', 'rosemary_sc_theme_setup', 1 );
	function rosemary_sc_theme_setup() {
		// Add sc stylesheets
		add_action('rosemary_action_add_styles', 'rosemary_sc_add_styles', 1);
	}
}

if (!function_exists('rosemary_sc_theme_setup2')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_theme_setup2' );
	function rosemary_sc_theme_setup2() {

		if ( !is_admin() || isset($_POST['action']) ) {
			// Enable/disable shortcodes in excerpt
			add_filter('the_excerpt', 					'rosemary_sc_excerpt_shortcodes');
	
			// Prepare shortcodes in the content
			if (function_exists('rosemary_sc_prepare_content')) rosemary_sc_prepare_content();
		}

		// Add init script into shortcodes output in VC frontend editor
		add_filter('rosemary_shortcode_output', 'rosemary_sc_add_scripts', 10, 4);

		// AJAX: Send contact form data
		add_action('wp_ajax_send_form',			'rosemary_sc_form_send');
		add_action('wp_ajax_nopriv_send_form',	'rosemary_sc_form_send');

		// Show shortcodes list in admin editor
		add_action('media_buttons',				'rosemary_sc_selector_add_in_toolbar', 11);

	}
}


// Add shortcodes styles
if ( !function_exists( 'rosemary_sc_add_styles' ) ) {
	//add_action('rosemary_action_add_styles', 'rosemary_sc_add_styles', 1);
	function rosemary_sc_add_styles() {
		// Shortcodes
		rosemary_enqueue_style( 'rosemary-shortcodes-style',	rosemary_get_file_url('shortcodes/theme.shortcodes.css'), array(), null );
	}
}


// Add shortcodes init scripts
if ( !function_exists( 'rosemary_sc_add_scripts' ) ) {
	//add_filter('rosemary_shortcode_output', 'rosemary_sc_add_scripts', 10, 4);
	function rosemary_sc_add_scripts($output, $tag='', $atts=array(), $content='') {

		global $ROSEMARY_GLOBALS;
		
		if (empty($ROSEMARY_GLOBALS['shortcodes_scripts_added'])) {
			$ROSEMARY_GLOBALS['shortcodes_scripts_added'] = true;
			//rosemary_enqueue_style( 'rosemary-shortcodes-style', rosemary_get_file_url('shortcodes/theme.shortcodes.css'), array(), null );
			rosemary_enqueue_script( 'rosemary-shortcodes-script', rosemary_get_file_url('shortcodes/theme.shortcodes.js'), array('jquery'), null, true );
		}
		
		return $output;
	}
}


/* Prepare text for shortcodes
-------------------------------------------------------------------------------- */

// Prepare shortcodes in content
if (!function_exists('rosemary_sc_prepare_content')) {
	function rosemary_sc_prepare_content() {
		if (function_exists('rosemary_sc_clear_around')) {
			$filters = array(
				array('rosemary', 'sc', 'clear', 'around'),
				array('widget', 'text'),
				array('the', 'excerpt'),
				array('the', 'content')
			);
			if (function_exists('rosemary_exists_woocommerce') && rosemary_exists_woocommerce()) {
				$filters[] = array('woocommerce', 'template', 'single', 'excerpt');
				$filters[] = array('woocommerce', 'short', 'description');
			}
			if (is_array($filters) && count($filters) > 0) {
				foreach ($filters as $flt)
					add_filter(join('_', $flt), 'rosemary_sc_clear_around', 1);	// Priority 1 to clear spaces before do_shortcodes()
			}
		}
	}
}

// Enable/Disable shortcodes in the excerpt
if (!function_exists('rosemary_sc_excerpt_shortcodes')) {
	function rosemary_sc_excerpt_shortcodes($content) {
		if (!empty($content)) {
			$content = do_shortcode($content);
			//$content = strip_shortcodes($content);
		}
		return $content;
	}
}



/*
// Remove spaces and line breaks between close and open shortcode brackets ][:
[trx_columns]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
[/trx_columns]

convert to

[trx_columns][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][/trx_columns]
*/
if (!function_exists('rosemary_sc_clear_around')) {
	function rosemary_sc_clear_around($content) {
		if (!empty($content)) $content = preg_replace("/\](\s|\n|\r)*\[/", "][", $content);
		return $content;
	}
}






/* Shortcodes support utils
---------------------------------------------------------------------- */

// RoseMary shortcodes load scripts
if (!function_exists('rosemary_sc_load_scripts')) {
	function rosemary_sc_load_scripts() {
		rosemary_enqueue_script( 'rosemary-shortcodes-script', rosemary_get_file_url('core/core.shortcodes/shortcodes_admin.js'), array('jquery'), null, true );
		rosemary_enqueue_script( 'rosemary-selection-script',  rosemary_get_file_url('js/jquery.selection.js'), array('jquery'), null, true );
	}
}

// RoseMary shortcodes prepare scripts
if (!function_exists('rosemary_sc_prepare_scripts')) {
	function rosemary_sc_prepare_scripts() {
		global $ROSEMARY_GLOBALS;
		if (!isset($ROSEMARY_GLOBALS['shortcodes_prepared'])) {
			$ROSEMARY_GLOBALS['shortcodes_prepared'] = true;
			$json_parse_func = 'eval';	// 'JSON.parse'
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					try {
						ROSEMARY_GLOBALS['shortcodes'] = <?php echo trim($json_parse_func); ?>(<?php echo json_encode( rosemary_array_prepare_to_json($ROSEMARY_GLOBALS['shortcodes']) ); ?>);
					} catch (e) {}
					ROSEMARY_GLOBALS['shortcodes_cp'] = '<?php echo is_admin() ? (!empty($ROSEMARY_GLOBALS['to_colorpicker']) ? $ROSEMARY_GLOBALS['to_colorpicker'] : 'wp') : 'custom'; ?>';	// wp | tiny | custom
				});
			</script>
			<?php
		}
	}
}

// Show shortcodes list in admin editor
if (!function_exists('rosemary_sc_selector_add_in_toolbar')) {
	//add_action('media_buttons','rosemary_sc_selector_add_in_toolbar', 11);
	function rosemary_sc_selector_add_in_toolbar(){

		if ( !rosemary_options_is_used() ) return;

		rosemary_sc_load_scripts();
		rosemary_sc_prepare_scripts();

		global $ROSEMARY_GLOBALS;

		$shortcodes = $ROSEMARY_GLOBALS['shortcodes'];
		$shortcodes_list = '<select class="sc_selector"><option value="">&nbsp;'.esc_html__('- Select Shortcode -', 'rosemary').'&nbsp;</option>';

		if (is_array($shortcodes) && count($shortcodes) > 0) {
			foreach ($shortcodes as $idx => $sc) {
				$shortcodes_list .= '<option value="'.esc_attr($idx).'" title="'.esc_attr($sc['desc']).'">'.esc_html($sc['title']).'</option>';
			}
		}

		$shortcodes_list .= '</select>';

		echo ($shortcodes_list);
	}
}

// RoseMary shortcodes builder settings
require_once rosemary_get_file_dir('core/core.shortcodes/shortcodes_settings.php');

// VC shortcodes settings
if ( class_exists('WPBakeryShortCode') ) {
	require_once rosemary_get_file_dir('core/core.shortcodes/shortcodes_vc.php');
}

// RoseMary shortcodes implementation
rosemary_autoload_folder( 'shortcodes/trx' );
?>