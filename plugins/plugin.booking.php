<?php
/* Booking Calendar support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('rosemary_booking_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_booking_theme_setup' );
	function rosemary_booking_theme_setup() {
		// Add shortcode in the shortcodes list
		if (rosemary_exists_booking()) {
			add_action('rosemary_action_shortcodes_list',				'rosemary_booking_reg_shortcodes');
			add_action('rosemary_action_shortcodes_list_vc',			'rosemary_booking_reg_shortcodes_vc');
			if (is_admin()) {
				add_filter( 'rosemary_filter_importer_options',			'rosemary_booking_importer_set_options' );
				add_action( 'rosemary_action_importer_params',			'rosemary_booking_importer_show_params', 10, 1 );
				add_action( 'rosemary_action_importer_import',			'rosemary_booking_importer_import', 10, 2 );
				add_action( 'rosemary_action_importer_import_fields',	'rosemary_booking_importer_import_fields', 10, 1 );
				add_action( 'rosemary_action_importer_export',			'rosemary_booking_importer_export', 10, 1 );
				add_action( 'rosemary_action_importer_export_fields',	'rosemary_booking_importer_export_fields', 10, 1 );
			}
		}
		if (is_admin()) {
			add_filter( 'rosemary_filter_importer_required_plugins',	'rosemary_booking_importer_required_plugins', 10, 2 );
			add_filter( 'rosemary_filter_required_plugins',				'rosemary_booking_required_plugins' );
		}
	}
}


// Check if Booking Calendar installed and activated
if ( !function_exists( 'rosemary_exists_booking' ) ) {
	function rosemary_exists_booking() {
		return function_exists('wp_booking_start_session');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'rosemary_booking_required_plugins' ) ) {
	//add_filter('rosemary_filter_required_plugins',	'rosemary_booking_required_plugins');
	function rosemary_booking_required_plugins($list=array()) {
		$list[] = array(
					'name' 		=> 'Booking Calendar',
					'slug' 		=> 'wp-booking-calendar',
					'source'	=> rosemary_get_file_dir('plugins/install/wp-booking-calendar.zip'),
					'required' 	=> false
					);
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check in the required plugins
if ( !function_exists( 'rosemary_booking_importer_required_plugins' ) ) {
	//add_filter( 'rosemary_filter_importer_required_plugins',	'rosemary_booking_importer_required_plugins', 10, 2 );
	function rosemary_booking_importer_required_plugins($not_installed='', $importer=null) {
		if ($importer && in_array('booking', $importer->options['required_plugins']) && !rosemary_exists_booking() )
			$not_installed .= '<br>Booking Calendar';
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'rosemary_booking_importer_set_options' ) ) {
	//add_filter( 'rosemary_filter_importer_options',	'rosemary_booking_importer_set_options', 10, 1 );
	function rosemary_booking_importer_set_options($options=array()) {
		if (is_array($options)) {
			$options['file_with_booking'] = 'demo/booking.txt';			// Name of the file with Booking Calendar data
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'rosemary_booking_importer_show_params' ) ) {
	//add_action( 'rosemary_action_importer_params',	'rosemary_booking_importer_show_params', 10, 1 );
	function rosemary_booking_importer_show_params($importer) {
		?>
		<input type="checkbox" <?php echo in_array('booking', $importer->options['required_plugins']) ? 'checked="checked"' : ''; ?> value="1" name="import_booking" id="import_booking" /> <label for="import_booking"><?php esc_html_e('Import Booking Calendar', 'rosemary'); ?></label><br>
		<?php
	}
}

// Import posts
if ( !function_exists( 'rosemary_booking_importer_import' ) ) {
	//add_action( 'rosemary_action_importer_import',	'rosemary_booking_importer_import', 10, 2 );
	function rosemary_booking_importer_import($importer, $action) {
		if ( $action == 'import_booking' ) {
			$importer->import_dump('booking', esc_html__('Booking Calendar', 'rosemary'));
		}
	}
}

// Display import progress
if ( !function_exists( 'rosemary_booking_importer_import_fields' ) ) {
	//add_action( 'rosemary_action_importer_import_fields',	'rosemary_booking_importer_import_fields', 10, 1 );
	function rosemary_booking_importer_import_fields($importer) {
		?>
		<tr class="import_booking">
			<td class="import_progress_item"><?php esc_html_e('Booking Calendar', 'rosemary'); ?></td>
			<td class="import_progress_status"></td>
		</tr>
		<?php
	}
}

// Export posts
if ( !function_exists( 'rosemary_booking_importer_export' ) ) {
	//add_action( 'rosemary_action_importer_export',	'rosemary_booking_importer_export', 10, 1 );
	function rosemary_booking_importer_export($importer) {
		global $wpdb, $ROSEMARY_GLOBALS;
		$options = array();
		$rows = $wpdb->get_results( "SELECT * FROM ".esc_sql($wpdb->prefix)."booking_calendars", ARRAY_A );
		$options['booking_calendars'] = $rows;
		$rows = $wpdb->get_results( "SELECT * FROM ".esc_sql($wpdb->prefix)."booking_categories", ARRAY_A );
		$options['booking_categories'] = $rows;
		$rows = $wpdb->get_results( "SELECT * FROM ".esc_sql($wpdb->prefix)."booking_config", ARRAY_A );
		$options['booking_config'] = $rows;
		$rows = $wpdb->get_results( "SELECT * FROM ".esc_sql($wpdb->prefix)."booking_reservation", ARRAY_A );
		$options['booking_reservation'] = $rows;
		$rows = $wpdb->get_results( "SELECT * FROM ".esc_sql($wpdb->prefix)."booking_slots", ARRAY_A );
		$options['booking_slots'] = $rows;
		$ROSEMARY_GLOBALS['export_booking'] = serialize($options);
	}
}

// Display exported data in the fields
if ( !function_exists( 'rosemary_booking_importer_export_fields' ) ) {
	//add_action( 'rosemary_action_importer_export_fields',	'rosemary_booking_importer_export_fields', 10, 1 );
	function rosemary_booking_importer_export_fields($importer) {
		global $ROSEMARY_GLOBALS;
		?>
		<tr>
			<th align="left"><?php esc_html_e('Booking', 'rosemary'); ?></th>
			<td><?php rosemary_fpc(rosemary_get_file_dir('core/core.importer/export/booking.txt'), $ROSEMARY_GLOBALS['export_booking']); ?>
				<a download="booking.txt" href="<?php echo esc_url(rosemary_get_file_url('core/core.importer/export/booking.txt')); ?>"><?php esc_html_e('Download', 'rosemary'); ?></a>
			</td>
		</tr>
		<?php
	}
}


// Lists
//------------------------------------------------------------------------

// Return Booking categories list, prepended inherit (if need)
if ( !function_exists( 'rosemary_get_list_booking_categories' ) ) {
	function rosemary_get_list_booking_categories($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_booking_cats']))
			$list = $ROSEMARY_GLOBALS['list_booking_cats'];
		else {
			$list = array();
			if (rosemary_exists_booking()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT category_id, category_name FROM " . esc_sql($wpdb->prefix . 'booking_categories') );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->category_id] = $row->category_name;
					}
				}
			}
			$ROSEMARY_GLOBALS['list_booking_cats'] = $list = apply_filters('rosemary_filter_list_booking_categories', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}

// Return Booking calendars list, prepended inherit (if need)
if ( !function_exists( 'rosemary_get_list_booking_calendars' ) ) {
	function rosemary_get_list_booking_calendars($prepend_inherit=false) {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['list_booking_calendars']))
			$list = $ROSEMARY_GLOBALS['list_booking_calendars'];
		else {
			$list = array();
			if (rosemary_exists_booking()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT cl.calendar_id, cl.calendar_title, ct.category_name FROM " . esc_sql($wpdb->prefix . 'booking_calendars') . " AS cl"
												. " INNER JOIN " . esc_sql($wpdb->prefix . 'booking_categories') . " AS ct ON cl.category_id=ct.category_id"
										);
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->calendar_id] = $row->calendar_title . ' (' . $row->category_name . ')';
					}
				}
			}
			$ROSEMARY_GLOBALS['list_booking_calendars'] = $list = apply_filters('rosemary_filter_list_booking_calendars', $list);
		}
		return $prepend_inherit ? rosemary_array_merge(array('inherit' => esc_html__("Inherit", 'rosemary')), $list) : $list;
	}
}



// Shortcodes
//------------------------------------------------------------------------

// Add shortcode in the shortcodes list
if (!function_exists('rosemary_booking_reg_shortcodes')) {
	//add_filter('rosemary_action_shortcodes_list',	'rosemary_booking_reg_shortcodes');
	function rosemary_booking_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['shortcodes'])) {

			$booking_cats = rosemary_get_list_booking_categories();
			$booking_cals = rosemary_get_list_booking_calendars();

			$ROSEMARY_GLOBALS['shortcodes']['wp_booking_calendar'] = array(
				"title" => esc_html__("Booking Calendar", "rosemary"),
				"desc" => esc_html__("Insert Booking calendar", "rosemary"),
				"decorate" => true,
				"container" => false,
				"params" => array(
					"category_id" => array(
						"title" => esc_html__("Category", "rosemary"),
						"desc" => esc_html__("Select booking category", "rosemary"),
						"value" => "",
						"type" => "select",
						"options" => rosemary_array_merge(array(0 => esc_html__('- Select category -', 'rosemary')), $booking_cats)
					),
					"calendar_id" => array(
						"title" => esc_html__("Calendar", "rosemary"),
						"desc" => esc_html__("or select booking calendar (id category is empty)", "rosemary"),
						"dependency" => array(
							'category_id' => array('empty', '0')
						),
						"value" => "",
						"type" => "select",
						"options" => rosemary_array_merge(array(0 => esc_html__('- Select calendar -', 'rosemary')), $booking_cals)
					)
				)
			);
		}
	}
}


// Add shortcode in the VC shortcodes list
if (!function_exists('rosemary_booking_reg_shortcodes_vc')) {
	//add_filter('rosemary_action_shortcodes_list_vc',	'rosemary_booking_reg_shortcodes_vc');
	function rosemary_booking_reg_shortcodes_vc() {

		$booking_cats = rosemary_get_list_booking_categories();
		$booking_cals = rosemary_get_list_booking_calendars();


		// RoseMary Donations form
		vc_map( array(
				"base" => "wp_booking_calendar",
				"name" => esc_html__("Booking Calendar", "rosemary"),
				"description" => esc_html__("Insert Booking calendar", "rosemary"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_booking',
				"class" => "trx_sc_single trx_sc_booking",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "category_id",
						"heading" => esc_html__("Category", "rosemary"),
						"description" => esc_html__("Select Booking category", "rosemary"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(rosemary_array_merge(array(0 => esc_html__('- Select category -', 'rosemary')), $booking_cats)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "calendar_id",
						"heading" => esc_html__("Calendar", "rosemary"),
						"description" => esc_html__("Select Booking calendar", "rosemary"),
						"admin_label" => true,
						'dependency' => array(
							'element' => 'category_id',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip(rosemary_array_merge(array(0 => esc_html__('- Select calendar -', 'rosemary')), $booking_cals)),
						"type" => "dropdown"
					)
				)
			) );
			
		class WPBakeryShortCode_Wp_Booking_Calendar extends ROSEMARY_VC_ShortCodeSingle {}

	}
}
?>