<?php
/**
 * RoseMary Framework: Testimonial post type settings
 *
 * @package	rosemary
 * @since	rosemary 1.0
 */

// Theme init
if (!function_exists('rosemary_testimonial_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_testimonial_theme_setup' );
	function rosemary_testimonial_theme_setup() {
	
		// Add item in the admin menu
		add_action('admin_menu',			'rosemary_testimonial_add_meta_box');

		// Save data from meta box
		add_action('save_post',				'rosemary_testimonial_save_data');

		// Add shortcodes [trx_testimonials] and [trx_testimonials_item]
		add_action('rosemary_action_shortcodes_list',		'rosemary_testimonials_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_testimonials_reg_shortcodes_vc');

		// Meta box fields
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['testimonial_meta_box'] = array(
			'id' => 'testimonial-meta-box',
			'title' => esc_html__('Testimonial Details', 'rosemary'),
			'page' => 'testimonial',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				"testimonial_author" => array(
					"title" => esc_html__('Testimonial author',  'rosemary'),
					"desc" => wp_kses( __("Name of the testimonial's author", 'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "testimonial_author",
					"std" => "",
					"type" => "text"),
				"testimonial_position" => array(
					"title" => esc_html__("Author's position",  'rosemary'),
					"desc" => wp_kses( __("Position of the testimonial's author", 'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "testimonial_author",
					"std" => "",
					"type" => "text"),
				"testimonial_email" => array(
					"title" => esc_html__("Author's e-mail",  'rosemary'),
					"desc" => wp_kses( __("E-mail of the testimonial's author - need to take Gravatar (if registered)", 'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "testimonial_email",
					"std" => "",
					"type" => "text"),
				"testimonial_link" => array(
					"title" => esc_html__('Testimonial link',  'rosemary'),
					"desc" => wp_kses( __("URL of the testimonial source or author profile page", 'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "testimonial_link",
					"std" => "",
					"type" => "text")
			)
		);
		
		if (function_exists('rosemary_require_data')) {
			// Prepare type "Testimonial"
			rosemary_require_data( 'post_type', 'testimonial', array(
				'label'               => esc_html__( 'Testimonial', 'rosemary' ),
				'description'         => esc_html__( 'Testimonial Description', 'rosemary' ),
				'labels'              => array(
					'name'                => esc_html__( 'Testimonials', 'rosemary' ),
					'singular_name'       => esc_html__( 'Testimonial', 'rosemary' ),
					'menu_name'           => esc_html__( 'Testimonials', 'rosemary' ),
					'parent_item_colon'   => esc_html__( 'Parent Item:', 'rosemary' ),
					'all_items'           => esc_html__( 'All Testimonials', 'rosemary' ),
					'view_item'           => esc_html__( 'View Item', 'rosemary' ),
					'add_new_item'        => esc_html__( 'Add New Testimonial', 'rosemary' ),
					'add_new'             => esc_html__( 'Add New', 'rosemary' ),
					'edit_item'           => esc_html__( 'Edit Item', 'rosemary' ),
					'update_item'         => esc_html__( 'Update Item', 'rosemary' ),
					'search_items'        => esc_html__( 'Search Item', 'rosemary' ),
					'not_found'           => esc_html__( 'Not found', 'rosemary' ),
					'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'rosemary' ),
				),
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail'),
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => true,
				'menu_icon'			  => 'dashicons-cloud',
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => '52.4',
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'capability_type'     => 'page',
				)
			);
			
			// Prepare taxonomy for testimonial
			rosemary_require_data( 'taxonomy', 'testimonial_group', array(
				'post_type'			=> array( 'testimonial' ),
				'hierarchical'      => true,
				'labels'            => array(
					'name'              => esc_html__( 'Testimonials Group', 'rosemary' ),
					'singular_name'     => esc_html__( 'Group', 'rosemary' ),
					'search_items'      => esc_html__( 'Search Groups', 'rosemary' ),
					'all_items'         => esc_html__( 'All Groups', 'rosemary' ),
					'parent_item'       => esc_html__( 'Parent Group', 'rosemary' ),
					'parent_item_colon' => esc_html__( 'Parent Group:', 'rosemary' ),
					'edit_item'         => esc_html__( 'Edit Group', 'rosemary' ),
					'update_item'       => esc_html__( 'Update Group', 'rosemary' ),
					'add_new_item'      => esc_html__( 'Add New Group', 'rosemary' ),
					'new_item_name'     => esc_html__( 'New Group Name', 'rosemary' ),
					'menu_name'         => esc_html__( 'Testimonial Group', 'rosemary' ),
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'testimonial_group' ),
				)
			);
		}
	}
}


// Add meta box
if (!function_exists('rosemary_testimonial_add_meta_box')) {
	//add_action('admin_menu', 'rosemary_testimonial_add_meta_box');
	function rosemary_testimonial_add_meta_box() {
		global $ROSEMARY_GLOBALS;
		$mb = $ROSEMARY_GLOBALS['testimonial_meta_box'];
		add_meta_box($mb['id'], $mb['title'], 'rosemary_testimonial_show_meta_box', $mb['page'], $mb['context'], $mb['priority']);
	}
}

// Callback function to show fields in meta box
if (!function_exists('rosemary_testimonial_show_meta_box')) {
	function rosemary_testimonial_show_meta_box() {
		global $post, $ROSEMARY_GLOBALS;

		// Use nonce for verification
		echo '<input type="hidden" name="meta_box_testimonial_nonce" value="', esc_attr($ROSEMARY_GLOBALS['admin_nonce']), '" />';
		
		$data = get_post_meta($post->ID, 'testimonial_data', true);
	
		$fields = $ROSEMARY_GLOBALS['testimonial_meta_box']['fields'];
		?>
		<table class="testimonial_area">
		<?php
		if (is_array($fields) && count($fields) > 0) {
			foreach ($fields as $id=>$field) { 
				$meta = isset($data[$id]) ? $data[$id] : '';
				?>
				<tr class="testimonial_field <?php echo esc_attr($field['class']); ?>" valign="top">
					<td><label for="<?php echo esc_attr($id); ?>"><?php echo esc_attr($field['title']); ?></label></td>
					<td><input type="text" name="<?php echo esc_attr($id); ?>" id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($meta); ?>" size="30" />
						<br><small><?php echo esc_attr($field['desc']); ?></small></td>
				</tr>
				<?php
			}
		}
		?>
		</table>
		<?php
	}
}


// Save data from meta box
if (!function_exists('rosemary_testimonial_save_data')) {
	//add_action('save_post', 'rosemary_testimonial_save_data');
	function rosemary_testimonial_save_data($post_id) {
		global $ROSEMARY_GLOBALS;
		// verify nonce
		if (!isset($_POST['meta_box_testimonial_nonce']) || !wp_verify_nonce($_POST['meta_box_testimonial_nonce'], $ROSEMARY_GLOBALS['admin_url'])) {
			return $post_id;
		}

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		// check permissions
		if ($_POST['post_type']!='testimonial' || !current_user_can('edit_post', $post_id)) {
			return $post_id;
		}

		$data = array();

		$fields = $ROSEMARY_GLOBALS['testimonial_meta_box']['fields'];

		// Post type specific data handling
		if (is_array($fields) && count($fields) > 0) {
			foreach ($fields as $id=>$field) { 
				if (isset($_POST[$id])) 
					$data[$id] = stripslashes($_POST[$id]);
			}
		}

		update_post_meta($post_id, 'testimonial_data', $data);
	}
}






// ---------------------------------- [trx_testimonials] ---------------------------------------

/*
[trx_testimonials id="unique_id" style="1|2|3"]
	[trx_testimonials_item user="user_login"]Testimonials text[/trx_testimonials_item]
	[trx_testimonials_item email="" name="" position="" photo="photo_url"]Testimonials text[/trx_testimonials]
[/trx_testimonials]
*/

if (!function_exists('rosemary_sc_testimonials')) {
	function rosemary_sc_testimonials($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "testimonials-1",
			"columns" => 1,
			"slider" => "yes",
			"slides_space" => 0,
			"controls" => "no",
			"interval" => "",
			"autoheight" => "no",
			"align" => "",
			"custom" => "no",
			"ids" => "",
			"cat" => "",
			"count" => "3",
			"offset" => "",
			"orderby" => "date",
			"order" => "desc",
			"scheme" => "",
			"bg_color" => "",
			"bg_image" => "",
			"bg_overlay" => "",
			"bg_texture" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
	
		if (empty($id)) $id = "sc_testimonials_".str_replace('.', '', mt_rand());
		if (empty($width)) $width = "100%";
		if (!empty($height) && rosemary_param_is_on($autoheight)) $autoheight = "no";
		if (empty($interval)) $interval = mt_rand(5000, 10000);
	
		if ($bg_image > 0) {
			$attach = wp_get_attachment_image_src( $bg_image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$bg_image = $attach[0];
		}
	
		if ($bg_overlay > 0) {
			if ($bg_color=='') $bg_color = rosemary_get_scheme_color('bg');
			$rgb = rosemary_hex2rgb($bg_color);
		}
		
		$class .= ($class ? ' ' : '') . rosemary_get_css_position_as_classes($top, $right, $bottom, $left);

		$ws = rosemary_get_css_dimensions_from_values($width);
		$hs = rosemary_get_css_dimensions_from_values('', $height);
		$css .= ($hs) . ($ws);

		$count = max(1, (int) $count);
		$columns = max(1, min(12, (int) $columns));
		if (rosemary_param_is_off($custom) && $count < $columns) $columns = $count;
		
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['sc_testimonials_id'] = $id;
		$ROSEMARY_GLOBALS['sc_testimonials_style'] = $style;
		$ROSEMARY_GLOBALS['sc_testimonials_columns'] = $columns;
		$ROSEMARY_GLOBALS['sc_testimonials_counter'] = 0;
		$ROSEMARY_GLOBALS['sc_testimonials_slider'] = $slider;
		$ROSEMARY_GLOBALS['sc_testimonials_css_wh'] = $ws . $hs;

		if (rosemary_param_is_on($slider)) rosemary_enqueue_slider('swiper');
	
		$output = ($bg_color!='' || $bg_image!='' || $bg_overlay>0 || $bg_texture>0 || rosemary_strlen($bg_texture)>2 || ($scheme && !rosemary_param_is_off($scheme) && !rosemary_param_is_inherit($scheme))
					? '<div class="sc_testimonials_wrap sc_section'
							. ($scheme && !rosemary_param_is_off($scheme) && !rosemary_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '')
							. '"'
						.' style="'
							. ($bg_color !== '' && $bg_overlay==0 ? 'background-color:' . esc_attr($bg_color) . ';' : '')
							. ($bg_image !== '' ? 'background-image:url(' . esc_url($bg_image) . ');' : '')
							. '"'
						. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
						. '>'
						. '<div class="sc_section_overlay'.($bg_texture>0 ? ' texture_bg_'.esc_attr($bg_texture) : '') . '"'
								. ' style="' . ($bg_overlay>0 ? 'background-color:rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.min(1, max(0, $bg_overlay)).');' : '')
									. (rosemary_strlen($bg_texture)>2 ? 'background-image:url('.esc_url($bg_texture).');' : '')
									. '"'
									. ($bg_overlay > 0 ? ' data-overlay="'.esc_attr($bg_overlay).'" data-bg_color="'.esc_attr($bg_color).'"' : '')
									. '>' 
					: '')
				. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_testimonials sc_testimonials_style_'.esc_attr($style)
 					. ' ' . esc_attr(rosemary_get_template_property($style, 'container_classes'))
 					. (rosemary_param_is_on($slider)
						? ' sc_slider_swiper swiper-slider-container'
							. ' ' . esc_attr(rosemary_get_slider_controls_classes($controls))
							. (rosemary_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
							. ($hs ? ' sc_slider_height_fixed' : '')
						: '')
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. ($align!='' && $align!='none' ? ' align'.esc_attr($align) : '')
					. '"'
				. ($bg_color=='' && $bg_image=='' && $bg_overlay==0 && ($bg_texture=='' || $bg_texture=='0') && !rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
				. (!empty($width) && rosemary_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
				. (!empty($height) && rosemary_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
				. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
				. ($columns > 1 ? ' data-slides-per-view="' . esc_attr($columns) . '"' : '')
				. ($slides_space > 0 ? ' data-slides-space="' . esc_attr($slides_space) . '"' : '')
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. '>'
			. (!empty($subtitle) ? '<h6 class="sc_testimonials_subtitle sc_item_subtitle">' . trim(rosemary_strmacros($subtitle)) . '</h6>' : '')
			. (!empty($title) ? '<h2 class="sc_testimonials_title sc_item_title">' . trim(rosemary_strmacros($title)) . '</h2>' : '')
			. (!empty($description) ? '<div class="sc_testimonials_descr sc_item_descr">' . trim(rosemary_strmacros($description)) . '</div>' : '')
			. (rosemary_param_is_on($slider)
				? '<div class="slides swiper-wrapper">' 
				: ($columns > 1 
					? '<div class="sc_columns columns_wrap">' 
					: '')
				);
	
		$content = do_shortcode($content);
			
		if (rosemary_param_is_on($custom) && $content) {
			$output .= $content;
		} else {
			global $post;
		
			if (!empty($ids)) {
				$posts = explode(',', $ids);
				$count = count($posts);
			}
			
			$args = array(
				'post_type' => 'testimonial',
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => true,
				'order' => $order=='asc' ? 'asc' : 'desc',
			);
		
			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}
		
			$args = rosemary_query_add_sort_order($args, $orderby, $order);
			$args = rosemary_query_add_posts_and_cats($args, $ids, 'testimonial', $cat, 'testimonial_group');
	
			$query = new WP_Query( $args );
	
			$post_number = 0;
				
			while ( $query->have_posts() ) { 
				$query->the_post();
				$post_number++;
				$args = array(
					'layout' => $style,
					'show' => false,
					'number' => $post_number,
					'posts_on_page' => ($count > 0 ? $count : $query->found_posts),
					"descr" => rosemary_get_custom_option('post_excerpt_maxlength'.($columns > 1 ? '_masonry' : '')),
					"orderby" => $orderby,
					'content' => false,
					'terms_list' => false,
					'columns_count' => $columns,
					'slider' => $slider,
					'tag_id' => $id ? $id . '_' . $post_number : '',
					'tag_class' => '',
					'tag_animation' => '',
					'tag_css' => '',
					'tag_css_wh' => $ws . $hs
				);
				$post_data = rosemary_get_post_data($args);
				$post_data['post_content'] = wpautop($post_data['post_content']);	// Add <p> around text and paragraphs. Need separate call because 'content'=>false (see above)
				$post_meta = get_post_meta($post_data['post_id'], 'testimonial_data', true);
				$thumb_sizes = rosemary_get_thumb_sizes(array('layout' => $style));
				$args['author'] = $post_meta['testimonial_author'];
				$args['position'] = $post_meta['testimonial_position'];
				$args['link'] = !empty($post_meta['testimonial_link']) ? $post_meta['testimonial_link'] : '';	//$post_data['post_link'];
				$args['email'] = $post_meta['testimonial_email'];
				$args['photo'] = $post_data['post_thumb'];
				if (empty($args['photo']) && !empty($args['email'])) $args['photo'] = get_avatar($args['email'], $thumb_sizes['w']*min(2, max(1, rosemary_get_theme_option("retina_ready"))));
				$output .= rosemary_show_post_layout($args, $post_data);
			}
			wp_reset_postdata();
		}
	
		if (rosemary_param_is_on($slider)) {
			$output .= '</div>'
				. '<div class="sc_slider_controls_wrap"><a class="sc_slider_prev" href="#"></a><a class="sc_slider_next" href="#"></a></div>'
				. '<div class="sc_slider_pagination_wrap"></div>';
		} else if ($columns > 1) {
			$output .= '</div>';
		}

		$output .= '</div>'
					. ($bg_color!='' || $bg_image!='' || $bg_overlay>0 || $bg_texture>0 || rosemary_strlen($bg_texture)>2
						?  '</div></div>'
						: '');
	
		// Add template specific scripts and styles
		do_action('rosemary_action_blog_scripts', $style);

		return apply_filters('rosemary_shortcode_output', $output, 'trx_testimonials', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_testimonials', 'rosemary_sc_testimonials');
}
	
	
if (!function_exists('rosemary_sc_testimonials_item')) {
	function rosemary_sc_testimonials_item($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"author" => "",
			"position" => "",
			"link" => "",
			"photo" => "",
			"email" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
		), $atts)));

		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['sc_testimonials_counter']++;
	
		$id = $id ? $id : ($ROSEMARY_GLOBALS['sc_testimonials_id'] ? $ROSEMARY_GLOBALS['sc_testimonials_id'] . '_' . $ROSEMARY_GLOBALS['sc_testimonials_counter'] : '');
	
		$thumb_sizes = rosemary_get_thumb_sizes(array('layout' => $ROSEMARY_GLOBALS['sc_testimonials_style']));

		if (empty($photo)) {
			if (!empty($email))
				$photo = get_avatar($email, $thumb_sizes['w']*min(2, max(1, rosemary_get_theme_option("retina_ready"))));
		} else {
			if ($photo > 0) {
				$attach = wp_get_attachment_image_src( $photo, 'full' );
				if (isset($attach[0]) && $attach[0]!='')
					$photo = $attach[0];
			}
			$photo = rosemary_get_resized_image_tag($photo, $thumb_sizes['w'], $thumb_sizes['h']);
		}

		$post_data = array(
			'post_content' => do_shortcode($content)
		);
		$args = array(
			'layout' => $ROSEMARY_GLOBALS['sc_testimonials_style'],
			'number' => $ROSEMARY_GLOBALS['sc_testimonials_counter'],
			'columns_count' => $ROSEMARY_GLOBALS['sc_testimonials_columns'],
			'slider' => $ROSEMARY_GLOBALS['sc_testimonials_slider'],
			'show' => false,
			'descr'  => 0,
			'tag_id' => $id,
			'tag_class' => $class,
			'tag_animation' => '',
			'tag_css' => $css,
			'tag_css_wh' => $ROSEMARY_GLOBALS['sc_testimonials_css_wh'],
			'author' => $author,
			'position' => $position,
			'link' => $link,
			'email' => $email,
			'photo' => $photo
		);
		$output = rosemary_show_post_layout($args, $post_data);

		return apply_filters('rosemary_shortcode_output', $output, 'trx_testimonials_item', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_testimonials_item', 'rosemary_sc_testimonials_item');
}
// ---------------------------------- [/trx_testimonials] ---------------------------------------



// Add [trx_testimonials] and [trx_testimonials_item] in the shortcodes list
if (!function_exists('rosemary_testimonials_reg_shortcodes')) {
	//add_filter('rosemary_action_shortcodes_list',	'rosemary_testimonials_reg_shortcodes');
	function rosemary_testimonials_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['shortcodes'])) {

			$testimonials_groups = rosemary_get_list_terms(false, 'testimonial_group');
			$testimonials_styles = rosemary_get_list_templates('testimonials');
			$controls = rosemary_get_list_slider_controls();

			rosemary_array_insert_before($ROSEMARY_GLOBALS['shortcodes'], 'trx_title', array(
			
				// Testimonials
				"trx_testimonials" => array(
					"title" => esc_html__("Testimonials", "rosemary"),
					"desc" => wp_kses( __("Insert testimonials into post (page)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", "rosemary"),
							"desc" => wp_kses( __("Title for the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => esc_html__("Subtitle", "rosemary"),
							"desc" => wp_kses( __("Subtitle for the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Description", "rosemary"),
							"desc" => wp_kses( __("Short description for the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => "",
							"type" => "textarea"
						),
						"style" => array(
							"title" => esc_html__("Testimonials style", "rosemary"),
							"desc" => wp_kses( __("Select style to display testimonials", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => "testimonials-1",
							"type" => "select",
							"options" => $testimonials_styles
						),
						"columns" => array(
							"title" => esc_html__("Columns", "rosemary"),
							"desc" => wp_kses( __("How many columns use to show testimonials", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => 1,
							"min" => 1,
							"max" => 6,
							"step" => 1,
							"type" => "spinner"
						),
						"slider" => array(
							"title" => esc_html__("Slider", "rosemary"),
							"desc" => wp_kses( __("Use slider to show testimonials", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => "yes",
							"type" => "switch",
							"options" => $ROSEMARY_GLOBALS['sc_params']['yes_no']
						),
						"controls" => array(
							"title" => esc_html__("Controls", "rosemary"),
							"desc" => wp_kses( __("Slider controls style and position", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $controls
						),
						"slides_space" => array(
							"title" => esc_html__("Space between slides", "rosemary"),
							"desc" => wp_kses( __("Size of space (in px) between slides", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => 0,
							"min" => 0,
							"max" => 100,
							"step" => 10,
							"type" => "spinner"
						),
						"interval" => array(
							"title" => esc_html__("Slides change interval", "rosemary"),
							"desc" => wp_kses( __("Slides change interval (in milliseconds: 1000ms = 1s)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => 7000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"autoheight" => array(
							"title" => esc_html__("Autoheight", "rosemary"),
							"desc" => wp_kses( __("Change whole slider's height (make it equal current slide's height)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => $ROSEMARY_GLOBALS['sc_params']['yes_no']
						),
						"align" => array(
							"title" => esc_html__("Alignment", "rosemary"),
							"desc" => wp_kses( __("Alignment of the testimonials block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $ROSEMARY_GLOBALS['sc_params']['align']
						),
						"custom" => array(
							"title" => esc_html__("Custom", "rosemary"),
							"desc" => wp_kses( __("Allow get testimonials from inner shortcodes (custom) or get it from specified group (cat)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $ROSEMARY_GLOBALS['sc_params']['yes_no']
						),
						"cat" => array(
							"title" => esc_html__("Categories", "rosemary"),
							"desc" => wp_kses( __("Select categories (groups) to show testimonials. If empty - select testimonials from any category (group) or from IDs list", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'custom' => array('no')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => rosemary_array_merge(array(0 => esc_html__('- Select category -', 'rosemary')), $testimonials_groups)
						),
						"count" => array(
							"title" => esc_html__("Number of posts", "rosemary"),
							"desc" => wp_kses( __("How many posts will be displayed? If used IDs - this parameter ignored.", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => esc_html__("Offset before select posts", "rosemary"),
							"desc" => wp_kses( __("Skip posts before select next part.", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Post order by", "rosemary"),
							"desc" => wp_kses( __("Select desired posts sorting method", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "date",
							"type" => "select",
							"options" => $ROSEMARY_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => esc_html__("Post order", "rosemary"),
							"desc" => wp_kses( __("Select desired posts order", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $ROSEMARY_GLOBALS['sc_params']['ordering']
						),
						"ids" => array(
							"title" => esc_html__("Post IDs list", "rosemary"),
							"desc" => wp_kses( __("Comma separated list of posts ID. If set - parameters above are ignored!", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "",
							"type" => "text"
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", "rosemary"),
							"desc" => wp_kses( __("Select color scheme for this block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => "",
							"type" => "checklist",
							"options" => $ROSEMARY_GLOBALS['sc_params']['schemes']
						),
						"bg_color" => array(
							"title" => esc_html__("Background color", "rosemary"),
							"desc" => wp_kses( __("Any background color for this section", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => esc_html__("Background image URL", "rosemary"),
							"desc" => wp_kses( __("Select or upload image or write URL from other site for the background", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => esc_html__("Overlay", "rosemary"),
							"desc" => wp_kses( __("Overlay color opacity (from 0.0 to 1.0)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => esc_html__("Texture", "rosemary"),
							"desc" => wp_kses( __("Predefined texture style from 1 to 11. 0 - without texture.", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"width" => rosemary_shortcodes_width(),
						"height" => rosemary_shortcodes_height(),
						"top" => $ROSEMARY_GLOBALS['sc_params']['top'],
						"bottom" => $ROSEMARY_GLOBALS['sc_params']['bottom'],
						"left" => $ROSEMARY_GLOBALS['sc_params']['left'],
						"right" => $ROSEMARY_GLOBALS['sc_params']['right'],
						"id" => $ROSEMARY_GLOBALS['sc_params']['id'],
						"class" => $ROSEMARY_GLOBALS['sc_params']['class'],
						"animation" => $ROSEMARY_GLOBALS['sc_params']['animation'],
						"css" => $ROSEMARY_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_testimonials_item",
						"title" => esc_html__("Item", "rosemary"),
						"desc" => wp_kses( __("Testimonials item (custom parameters)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"container" => true,
						"params" => array(
							"author" => array(
								"title" => esc_html__("Author", "rosemary"),
								"desc" => wp_kses( __("Name of the testimonmials author", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
								"value" => "",
								"type" => "text"
							),
							"link" => array(
								"title" => esc_html__("Link", "rosemary"),
								"desc" => wp_kses( __("Link URL to the testimonmials author page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
								"value" => "",
								"type" => "text"
							),
							"email" => array(
								"title" => esc_html__("E-mail", "rosemary"),
								"desc" => wp_kses( __("E-mail of the testimonmials author (to get gravatar)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
								"value" => "",
								"type" => "text"
							),
							"photo" => array(
								"title" => esc_html__("Photo", "rosemary"),
								"desc" => wp_kses( __("Select or upload photo of testimonmials author or write URL of photo from other site", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
								"value" => "",
								"type" => "media"
							),
							"_content_" => array(
								"title" => esc_html__("Testimonials text", "rosemary"),
								"desc" => wp_kses( __("Current testimonials text", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $ROSEMARY_GLOBALS['sc_params']['id'],
							"class" => $ROSEMARY_GLOBALS['sc_params']['class'],
							"css" => $ROSEMARY_GLOBALS['sc_params']['css']
						)
					)
				)

			));
		}
	}
}


// Add [trx_testimonials] and [trx_testimonials_item] in the VC shortcodes list
if (!function_exists('rosemary_testimonials_reg_shortcodes_vc')) {
	//add_filter('rosemary_action_shortcodes_list_vc',	'rosemary_testimonials_reg_shortcodes_vc');
	function rosemary_testimonials_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;

		$testimonials_groups = rosemary_get_list_terms(false, 'testimonial_group');
		$testimonials_styles = rosemary_get_list_templates('testimonials');
		$controls			 = rosemary_get_list_slider_controls();
			
		// Testimonials			
		vc_map( array(
				"base" => "trx_testimonials",
				"name" => esc_html__("Testimonials", "rosemary"),
				"description" => wp_kses( __("Insert testimonials slider", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_testimonials',
				"class" => "trx_sc_collection trx_sc_testimonials",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_testimonials_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Testimonials style", "rosemary"),
						"description" => wp_kses( __("Select style to display testimonials", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip($testimonials_styles),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slider",
						"heading" => esc_html__("Slider", "rosemary"),
						"description" => wp_kses( __("Use slider to show testimonials", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'rosemary'),
						"class" => "",
						"std" => "yes",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['yes_no']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Controls", "rosemary"),
						"description" => wp_kses( __("Slider controls style and position", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'rosemary'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"std" => "no",
						"value" => array_flip($controls),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slides_space",
						"heading" => esc_html__("Space between slides", "rosemary"),
						"description" => wp_kses( __("Size of space (in px) between slides", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'rosemary'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "interval",
						"heading" => esc_html__("Slides change interval", "rosemary"),
						"description" => wp_kses( __("Slides change interval (in milliseconds: 1000ms = 1s)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Slider', 'rosemary'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => "7000",
						"type" => "textfield"
					),
					array(
						"param_name" => "autoheight",
						"heading" => esc_html__("Autoheight", "rosemary"),
						"description" => wp_kses( __("Change whole slider's height (make it equal current slide's height)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Slider', 'rosemary'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => array("Autoheight" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "rosemary"),
						"description" => wp_kses( __("Alignment of the testimonials block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "custom",
						"heading" => esc_html__("Custom", "rosemary"),
						"description" => wp_kses( __("Allow get testimonials from inner shortcodes (custom) or get it from specified group (cat)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => array("Custom slides" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "rosemary"),
						"description" => wp_kses( __("Title for the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"group" => esc_html__('Captions', 'rosemary'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", "rosemary"),
						"description" => wp_kses( __("Subtitle for the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Captions', 'rosemary'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", "rosemary"),
						"description" => wp_kses( __("Description for the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Captions', 'rosemary'),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					array(
						"param_name" => "cat",
						"heading" => esc_html__("Categories", "rosemary"),
						"description" => wp_kses( __("Select categories (groups) to show testimonials. If empty - select testimonials from any category (group) or from IDs list", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Query', 'rosemary'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip(rosemary_array_merge(array(0 => esc_html__('- Select category -', 'rosemary')), $testimonials_groups)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "rosemary"),
						"description" => wp_kses( __("How many columns use to show testimonials", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Query', 'rosemary'),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Number of posts", "rosemary"),
						"description" => wp_kses( __("How many posts will be displayed? If used IDs - this parameter ignored.", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Query', 'rosemary'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => esc_html__("Offset before select posts", "rosemary"),
						"description" => wp_kses( __("Skip posts before select next part.", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Query', 'rosemary'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Post sorting", "rosemary"),
						"description" => wp_kses( __("Select desired posts sorting method", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Query', 'rosemary'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['sorting']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Post order", "rosemary"),
						"description" => wp_kses( __("Select desired posts order", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Query', 'rosemary'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("Post IDs list", "rosemary"),
						"description" => wp_kses( __("Comma separated list of posts ID. If set - parameters above are ignored!", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Query', 'rosemary'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", "rosemary"),
						"description" => wp_kses( __("Select color scheme for this block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Colors and Images', 'rosemary'),
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['schemes']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Background color", "rosemary"),
						"description" => wp_kses( __("Any background color for this section", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Colors and Images', 'rosemary'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => esc_html__("Background image URL", "rosemary"),
						"description" => wp_kses( __("Select background image from library for this section", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Colors and Images', 'rosemary'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_overlay",
						"heading" => esc_html__("Overlay", "rosemary"),
						"description" => wp_kses( __("Overlay color opacity (from 0.0 to 1.0)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Colors and Images', 'rosemary'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_texture",
						"heading" => esc_html__("Texture", "rosemary"),
						"description" => wp_kses( __("Texture style from 1 to 11. Empty or 0 - without texture.", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Colors and Images', 'rosemary'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					rosemary_vc_width(),
					rosemary_vc_height(),
					$ROSEMARY_GLOBALS['vc_params']['margin_top'],
					$ROSEMARY_GLOBALS['vc_params']['margin_bottom'],
					$ROSEMARY_GLOBALS['vc_params']['margin_left'],
					$ROSEMARY_GLOBALS['vc_params']['margin_right'],
					$ROSEMARY_GLOBALS['vc_params']['id'],
					$ROSEMARY_GLOBALS['vc_params']['class'],
					$ROSEMARY_GLOBALS['vc_params']['animation'],
					$ROSEMARY_GLOBALS['vc_params']['css']
				)
		) );
			
			
		vc_map( array(
				"base" => "trx_testimonials_item",
				"name" => esc_html__("Testimonial", "rosemary"),
				"description" => wp_kses( __("Single testimonials item", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"show_settings_on_create" => true,
				"class" => "trx_sc_collection trx_sc_column_item trx_sc_testimonials_item",
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_testimonials_item',
				"as_child" => array('only' => 'trx_testimonials'),
				"as_parent" => array('except' => 'trx_testimonials'),
				"params" => array(
					array(
						"param_name" => "author",
						"heading" => esc_html__("Author", "rosemary"),
						"description" => wp_kses( __("Name of the testimonmials author", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link", "rosemary"),
						"description" => wp_kses( __("Link URL to the testimonmials author page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "email",
						"heading" => esc_html__("E-mail", "rosemary"),
						"description" => wp_kses( __("E-mail of the testimonmials author", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "photo",
						"heading" => esc_html__("Photo", "rosemary"),
						"description" => wp_kses( __("Select or upload photo of testimonmials author or write URL of photo from other site", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => esc_html__("Testimonials text", "rosemary"),
						"description" => wp_kses( __("Current testimonials text", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$ROSEMARY_GLOBALS['vc_params']['id'],
					$ROSEMARY_GLOBALS['vc_params']['class'],
					$ROSEMARY_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxColumnItemView'
		) );
			
		class WPBakeryShortCode_Trx_Testimonials extends ROSEMARY_VC_ShortCodeColumns {}
		class WPBakeryShortCode_Trx_Testimonials_Item extends ROSEMARY_VC_ShortCodeCollection {}
		
	}
}
?>