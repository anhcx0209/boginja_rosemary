<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('rosemary_revslider_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_revslider_theme_setup' );
	function rosemary_revslider_theme_setup() {
		if (rosemary_exists_revslider()) {
			add_filter( 'rosemary_filter_list_sliders',					'rosemary_revslider_list_sliders' );
			if (is_admin()) {
				add_filter( 'rosemary_filter_importer_options',			'rosemary_revslider_importer_set_options' );
				add_action( 'rosemary_action_importer_params',			'rosemary_revslider_importer_show_params', 10, 1 );
				add_action( 'rosemary_action_importer_clear_tables',	'rosemary_revslider_importer_clear_tables', 10, 2 );
				add_action( 'rosemary_action_importer_import',			'rosemary_revslider_importer_import', 10, 2 );
				add_action( 'rosemary_action_importer_import_fields',	'rosemary_revslider_importer_import_fields', 10, 1 );
			}
		}
		if (is_admin()) {
			add_filter( 'rosemary_filter_importer_required_plugins',	'rosemary_revslider_importer_required_plugins', 10, 2 );
			add_filter( 'rosemary_filter_required_plugins',				'rosemary_revslider_required_plugins' );
		}
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'rosemary_exists_revslider' ) ) {
	function rosemary_exists_revslider() {
		return function_exists('rev_slider_shortcode');
		//return class_exists('RevSliderFront');
		//return is_plugin_active('revslider/revslider.php');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'rosemary_revslider_required_plugins' ) ) {
	//add_filter('rosemary_filter_required_plugins',	'rosemary_revslider_required_plugins');
	function rosemary_revslider_required_plugins($list=array()) {
		$list[] = array(
					'name' 		=> 'Revolution Slider',
					'slug' 		=> 'revslider',
					'source'	=> rosemary_get_file_dir('plugins/install/revslider.zip'),
					'required' 	=> false
				);

		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check RevSlider in the required plugins
if ( !function_exists( 'rosemary_revslider_importer_required_plugins' ) ) {
	//add_filter( 'rosemary_filter_importer_required_plugins',	'rosemary_revslider_importer_required_plugins', 10, 2 );
	function rosemary_revslider_importer_required_plugins($not_installed='', $importer=null) {
		if ($importer && in_array('revslider', $importer->options['required_plugins']) && !rosemary_exists_revslider() )
			$not_installed .= '<br>Revolution Slider';
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'rosemary_revslider_importer_set_options' ) ) {
	//add_filter( 'rosemary_filter_importer_options',	'rosemary_revslider_importer_set_options', 10, 1 );
	function rosemary_revslider_importer_set_options($options=array()) {
		if (is_array($options)) {
			$options['folder_with_revsliders'] = 'demo/revslider';			// Name of the folder with Revolution slider data
			$options['import_sliders'] = true;								// Import Revolution Sliders
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'rosemary_revslider_importer_show_params' ) ) {
	//add_action( 'rosemary_action_importer_params',	'rosemary_revslider_importer_show_params', 10, 1 );
	function rosemary_revslider_importer_show_params($importer) {
		?>
		<input type="checkbox" <?php echo in_array('revslider', $importer->options['required_plugins']) ? 'checked="checked"' : ''; ?> value="1" name="import_revslider" id="import_revslider" /> <label for="import_revslider"><?php esc_html_e('Import Revolution Sliders', 'rosemary'); ?></label><br>
		<?php
	}
}

// Clear tables
if ( !function_exists( 'rosemary_revslider_importer_clear_tables' ) ) {
	//add_action( 'rosemary_action_importer_clear_tables',	'rosemary_revslider_importer_clear_tables', 10, 2 );
	function rosemary_revslider_importer_clear_tables($importer, $clear_tables) {
		if (rosemary_strpos($clear_tables, 'revslider')!==false && $importer->last_slider==0) {
			if ($importer->options['debug']) dfl(esc_html__('Clear Revolution Slider tables', 'rosemary'));
			global $wpdb;
			$res = $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "revslider_sliders");
			if ( is_wp_error( $res ) ) dfl( esc_html__( 'Failed truncate table "revslider_sliders".', 'rosemary' ) . ' ' . ($res->get_error_message()) );
			$res = $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "revslider_slides");
			if ( is_wp_error( $res ) ) dfl( esc_html__( 'Failed truncate table "revslider_slides".', 'rosemary' ) . ' ' . ($res->get_error_message()) );
			$res = $wpdb->query("TRUNCATE TABLE " . esc_sql($wpdb->prefix) . "revslider_static_slides");
			if ( is_wp_error( $res ) ) dfl( esc_html__( 'Failed truncate table "revslider_static_slides".', 'rosemary' ) . ' ' . ($res->get_error_message()) );
		}
	}
}

// Import posts
if ( !function_exists( 'rosemary_revslider_importer_import' ) ) {
	//add_action( 'rosemary_action_importer_import',	'rosemary_revslider_importer_import', 10, 2 );
	function rosemary_revslider_importer_import($importer, $action) {
		if ( $action == 'import_revslider' ) {
			if (file_exists(WP_PLUGIN_DIR.'/revslider/revslider.php')) {
				require_once WP_PLUGIN_DIR.'/revslider/revslider.php';
				$dir = rosemary_get_folder_dir($importer->options['folder_with_revsliders']);
				if ( is_dir($dir) ) {
					$hdir = @opendir( $dir );
					if ( $hdir ) {
						if ($importer->options['debug']) dfl( esc_html__('Import Revolution sliders', 'rosemary') );
						// Collect files with sliders
						$sliders = array();
						while (($file = readdir( $hdir ) ) !== false ) {
							$pi = pathinfo( ($dir) . '/' . ($file) );
							if ( substr($file, 0, 1) == '.' || is_dir( ($dir) . '/' . ($file) ) || $pi['extension']!='zip' )
								continue;
							$sliders[] = array('name' => $file, 'path' => ($dir) . '/' . ($file));
						}
						@closedir( $hdir );
						// Process next slider
						$slider = new RevSlider();
						for ($i=0; $i<count($sliders); $i++) {
							if ($i+1 <= $importer->last_slider) continue;
							if ($importer->options['debug']) dfl( sprintf(esc_html__('Process slider "%s"', 'rosemary'), $sliders[$i]['name']) );
							if (!is_array($_FILES)) $_FILES = array();
							$_FILES["import_file"] = array("tmp_name" => $sliders[$i]['path']);
							$response = $slider->importSliderFromPost();
							if ($response["success"] == false) {
								$msg = sprintf(esc_html__('Revolution Slider "%s" import error', 'rosemary'), $sliders[$i]['name']);
								$importer->response['error'] = $msg;
								dfl( $msg );
								dfo( $response );
							} else {
								if ($importer->options['debug']) dfl( sprintf(esc_html__('Slider "%s" imported', 'rosemary'), $sliders[$i]['name']) );
							}
							break;
						}
						// Write last slider into log
						rosemary_fpc($importer->import_log, $i+1 < count($sliders) ? '0|100|'.($i+1) : '');
						$importer->response['result'] = min(100, round(($i+1) / count($sliders) * 100));
					}
				}
			} else {
				dfl( sprintf(esc_html__('Can not locate plugin Revolution Slider: %s', 'rosemary'), WP_PLUGIN_DIR.'/revslider/revslider.php') );
			}
		}
	}
}

// Display import progress
if ( !function_exists( 'rosemary_revslider_importer_import_fields' ) ) {
	//add_action( 'rosemary_action_importer_import_fields',	'rosemary_revslider_importer_import_fields', 10, 1 );
	function rosemary_revslider_importer_import_fields($importer) {
		?>
		<tr class="import_revslider">
			<td class="import_progress_item"><?php esc_html_e('Revolution Slider', 'rosemary'); ?></td>
			<td class="import_progress_status"></td>
		</tr>
		<?php
	}
}


// Lists
//------------------------------------------------------------------------

// Add RevSlider in the sliders list, prepended inherit (if need)
if ( !function_exists( 'rosemary_revslider_list_sliders' ) ) {
	//add_filter( 'rosemary_filter_list_sliders',					'rosemary_revslider_list_sliders' );
	function rosemary_revslider_list_sliders($list=array()) {
		$list["revo"] = esc_html__("Layer slider (Revolution)", 'rosemary');
		return $list;
	}
}

// Return Revo Sliders list, prepended inherit (if need)
if ( !function_exists( 'rosemary_get_list_revo_sliders' ) ) {
	function rosemary_get_list_revo_sliders($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_revo_sliders']))
			$list = $ROSEMARY_GLOBALS['list_revo_sliders'];
		else {
			$list = array();
			if (rosemary_exists_revslider()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT alias, title FROM " . esc_sql($wpdb->prefix) . "revslider_sliders" );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->alias] = $row->title;
					}
				}
			}
			$ROSEMARY_GLOBALS['list_revo_sliders'] = $list = apply_filters('rosemary_filter_list_revo_sliders', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}
?>