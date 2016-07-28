<?php
/**
 * RoseMary Framework: Clients post type settings
 *
 * @package	rosemary
 * @since	rosemary 1.0
 */

// Theme init
if (!function_exists('rosemary_clients_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_clients_theme_setup' );
	function rosemary_clients_theme_setup() {

		// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
		add_filter('rosemary_filter_get_blog_type',			'rosemary_clients_get_blog_type', 9, 2);
		add_filter('rosemary_filter_get_blog_title',		'rosemary_clients_get_blog_title', 9, 2);
		add_filter('rosemary_filter_get_current_taxonomy',	'rosemary_clients_get_current_taxonomy', 9, 2);
		add_filter('rosemary_filter_is_taxonomy',			'rosemary_clients_is_taxonomy', 9, 2);
		add_filter('rosemary_filter_get_stream_page_title',	'rosemary_clients_get_stream_page_title', 9, 2);
		add_filter('rosemary_filter_get_stream_page_link',	'rosemary_clients_get_stream_page_link', 9, 2);
		add_filter('rosemary_filter_get_stream_page_id',	'rosemary_clients_get_stream_page_id', 9, 2);
		add_filter('rosemary_filter_query_add_filters',		'rosemary_clients_query_add_filters', 9, 2);
		add_filter('rosemary_filter_detect_inheritance_key','rosemary_clients_detect_inheritance_key', 9, 1);

		// Extra column for clients lists
		if (rosemary_get_theme_option('show_overriden_posts')=='yes') {
			add_filter('manage_edit-clients_columns',			'rosemary_post_add_options_column', 9);
			add_filter('manage_clients_posts_custom_column',	'rosemary_post_fill_options_column', 9, 2);
		}

		// Add shortcodes [trx_clients] and [trx_clients_item] in the shortcodes list
		add_action('rosemary_action_shortcodes_list',		'rosemary_clients_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_clients_reg_shortcodes_vc');
		
		if (function_exists('rosemary_require_data')) {
			// Prepare type "Clients"
			rosemary_require_data( 'post_type', 'clients', array(
				'label'               => esc_html__( 'Clients', 'rosemary' ),
				'description'         => esc_html__( 'Clients Description', 'rosemary' ),
				'labels'              => array(
					'name'                => esc_html__( 'Clients', 'rosemary' ),
					'singular_name'       => esc_html__( 'Client', 'rosemary' ),
					'menu_name'           => esc_html__( 'Clients', 'rosemary' ),
					'parent_item_colon'   => esc_html__( 'Parent Item:', 'rosemary' ),
					'all_items'           => esc_html__( 'All Clients', 'rosemary' ),
					'view_item'           => esc_html__( 'View Item', 'rosemary' ),
					'add_new_item'        => esc_html__( 'Add New Client', 'rosemary' ),
					'add_new'             => esc_html__( 'Add New', 'rosemary' ),
					'edit_item'           => esc_html__( 'Edit Item', 'rosemary' ),
					'update_item'         => esc_html__( 'Update Item', 'rosemary' ),
					'search_items'        => esc_html__( 'Search Item', 'rosemary' ),
					'not_found'           => esc_html__( 'Not found', 'rosemary' ),
					'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'rosemary' ),
				),
				'supports'            => array( 'title', 'excerpt', 'editor', 'author', 'thumbnail', 'comments', 'custom-fields'),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'menu_icon'			  => 'dashicons-admin-users',
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => '52.1',
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'query_var'           => true,
				'capability_type'     => 'page',
				'rewrite'             => true
				)
			);
			
			// Prepare taxonomy for clients
			rosemary_require_data( 'taxonomy', 'clients_group', array(
				'post_type'			=> array( 'clients' ),
				'hierarchical'      => true,
				'labels'            => array(
					'name'              => esc_html__( 'Clients Group', 'rosemary' ),
					'singular_name'     => esc_html__( 'Group', 'rosemary' ),
					'search_items'      => esc_html__( 'Search Groups', 'rosemary' ),
					'all_items'         => esc_html__( 'All Groups', 'rosemary' ),
					'parent_item'       => esc_html__( 'Parent Group', 'rosemary' ),
					'parent_item_colon' => esc_html__( 'Parent Group:', 'rosemary' ),
					'edit_item'         => esc_html__( 'Edit Group', 'rosemary' ),
					'update_item'       => esc_html__( 'Update Group', 'rosemary' ),
					'add_new_item'      => esc_html__( 'Add New Group', 'rosemary' ),
					'new_item_name'     => esc_html__( 'New Group Name', 'rosemary' ),
					'menu_name'         => esc_html__( 'Clients Group', 'rosemary' ),
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'clients_group' ),
				)
			);
		}
	}
}

if ( !function_exists( 'rosemary_clients_settings_theme_setup2' ) ) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_clients_settings_theme_setup2', 3 );
	function rosemary_clients_settings_theme_setup2() {
		// Add post type 'clients' and taxonomy 'clients_group' into theme inheritance list
		rosemary_add_theme_inheritance( array('clients' => array(
			'stream_template' => 'blog-clients',
			'single_template' => 'single-client',
			'taxonomy' => array('clients_group'),
			'taxonomy_tags' => array(),
			'post_type' => array('clients'),
			'override' => 'page'
			) )
		);
	}
}


if (!function_exists('rosemary_clients_after_theme_setup')) {
	add_action( 'rosemary_action_after_init_theme', 'rosemary_clients_after_theme_setup' );
	function rosemary_clients_after_theme_setup() {
		// Update fields in the meta box
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['post_meta_box']) && $ROSEMARY_GLOBALS['post_meta_box']['page']=='clients') {
			// Meta box fields
			$ROSEMARY_GLOBALS['post_meta_box']['title'] = esc_html__('Client Options', 'rosemary');
			$ROSEMARY_GLOBALS['post_meta_box']['fields'] = array(
				"mb_partition_clients" => array(
					"title" => esc_html__('Clients', 'rosemary'),
					"override" => "page,post",
					"divider" => false,
					"icon" => "iconadmin-users",
					"type" => "partition"),
				"mb_info_clients_1" => array(
					"title" => esc_html__('Client details', 'rosemary'),
					"override" => "page,post",
					"divider" => false,
					"desc" => wp_kses( __('In this section you can put details for this client', 'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"class" => "client_meta",
					"type" => "info"),
				"client_name" => array(
					"title" => esc_html__('Contact name',  'rosemary'),
					"desc" => wp_kses( __("Name of the contacts manager", 'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"override" => "page,post",
					"class" => "client_name",
					"std" => '',
					"type" => "text"),
				"client_position" => array(
					"title" => esc_html__('Position',  'rosemary'),
					"desc" => wp_kses( __("Position of the contacts manager", 'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"override" => "page,post",
					"class" => "client_position",
					"std" => '',
					"type" => "text"),
				"client_show_link" => array(
					"title" => esc_html__('Show link',  'rosemary'),
					"desc" => wp_kses( __("Show link to client page", 'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"override" => "page,post",
					"class" => "client_show_link",
					"std" => "no",
					"options" => rosemary_get_list_yesno(),
					"type" => "switch"),
				"client_link" => array(
					"title" => esc_html__('Link',  'rosemary'),
					"desc" => wp_kses( __("URL of the client's site. If empty - use link to this page", 'rosemary'), $ROSEMARY_GLOBALS['allowed_tags'] ),
					"override" => "page,post",
					"class" => "client_link",
					"std" => '',
					"type" => "text")
			);
		}
	}
}


// Return true, if current page is clients page
if ( !function_exists( 'rosemary_is_clients_page' ) ) {
	function rosemary_is_clients_page() {
		global $ROSEMARY_GLOBALS;
		$is = in_array($ROSEMARY_GLOBALS['page_template'], array('blog-clients', 'single-client'));
		if (!$is) {
			if (!empty($ROSEMARY_GLOBALS['pre_query']))
				$is = $ROSEMARY_GLOBALS['pre_query']->get('post_type')=='clients'
						|| $ROSEMARY_GLOBALS['pre_query']->is_tax('clients_group')
						|| ($ROSEMARY_GLOBALS['pre_query']->is_page()
							&& ($id=rosemary_get_template_page_id('blog-clients')) > 0
							&& $id==(isset($ROSEMARY_GLOBALS['pre_query']->queried_object_id)
										? $ROSEMARY_GLOBALS['pre_query']->queried_object_id
										: 0
									)
						);
			else
				$is = get_query_var('post_type')=='clients' 
						|| is_tax('clients_group') 
						|| (is_page() && ($id=rosemary_get_template_page_id('blog-clients')) > 0 && $id==get_the_ID());
		}
		return $is;
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'rosemary_clients_detect_inheritance_key' ) ) {
	//add_filter('rosemary_filter_detect_inheritance_key',	'rosemary_clients_detect_inheritance_key', 9, 1);
	function rosemary_clients_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return rosemary_is_clients_page() ? 'clients' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'rosemary_clients_get_blog_type' ) ) {
	//add_filter('rosemary_filter_get_blog_type',	'rosemary_clients_get_blog_type', 9, 2);
	function rosemary_clients_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if ($query && $query->is_tax('clients_group') || is_tax('clients_group'))
			$page = 'clients_category';
		else if ($query && $query->get('post_type')=='clients' || get_query_var('post_type')=='clients')
			$page = $query && $query->is_single() || is_single() ? 'clients_item' : 'clients';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'rosemary_clients_get_blog_title' ) ) {
	//add_filter('rosemary_filter_get_blog_title',	'rosemary_clients_get_blog_title', 9, 2);
	function rosemary_clients_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( rosemary_strpos($page, 'clients')!==false ) {
			if ( $page == 'clients_category' ) {
				$term = get_term_by( 'slug', get_query_var( 'clients_group' ), 'clients_group', OBJECT);
				$title = $term->name;
			} else if ( $page == 'clients_item' ) {
				$title = rosemary_get_post_title();
			} else {
				$title = esc_html__('All clients', 'rosemary');
			}
		}

		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'rosemary_clients_get_stream_page_title' ) ) {
	//add_filter('rosemary_filter_get_stream_page_title',	'rosemary_clients_get_stream_page_title', 9, 2);
	function rosemary_clients_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (rosemary_strpos($page, 'clients')!==false) {
			if (($page_id = rosemary_clients_get_stream_page_id(0, $page=='clients' ? 'blog-clients' : $page)) > 0)
				$title = rosemary_get_post_title($page_id);
			else
				$title = esc_html__('All clients', 'rosemary');
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'rosemary_clients_get_stream_page_id' ) ) {
	//add_filter('rosemary_filter_get_stream_page_id',	'rosemary_clients_get_stream_page_id', 9, 2);
	function rosemary_clients_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (rosemary_strpos($page, 'clients')!==false) $id = rosemary_get_template_page_id('blog-clients');
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'rosemary_clients_get_stream_page_link' ) ) {
	//add_filter('rosemary_filter_get_stream_page_link',	'rosemary_clients_get_stream_page_link', 9, 2);
	function rosemary_clients_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (rosemary_strpos($page, 'clients')!==false) {
			$id = rosemary_get_template_page_id('blog-clients');
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'rosemary_clients_get_current_taxonomy' ) ) {
	//add_filter('rosemary_filter_get_current_taxonomy',	'rosemary_clients_get_current_taxonomy', 9, 2);
	function rosemary_clients_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( rosemary_strpos($page, 'clients')!==false ) {
			$tax = 'clients_group';
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'rosemary_clients_is_taxonomy' ) ) {
	//add_filter('rosemary_filter_is_taxonomy',	'rosemary_clients_is_taxonomy', 9, 2);
	function rosemary_clients_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else 
			return $query && $query->get('clients_group')!='' || is_tax('clients_group') ? 'clients_group' : '';
	}
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'rosemary_clients_query_add_filters' ) ) {
	//add_filter('rosemary_filter_query_add_filters',	'rosemary_clients_query_add_filters', 9, 2);
	function rosemary_clients_query_add_filters($args, $filter) {
		if ($filter == 'clients') {
			$args['post_type'] = 'clients';
		}
		return $args;
	}
}





// ---------------------------------- [trx_clients] ---------------------------------------

/*
[trx_clients id="unique_id" columns="3" style="clients-1|clients-2|..."]
	[trx_clients_item name="client name" position="director" image="url"]Description text[/trx_clients_item]
	...
[/trx_clients]
*/
if ( !function_exists( 'rosemary_sc_clients' ) ) {
	function rosemary_sc_clients($atts, $content=null){
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "clients-1",
			"columns" => 4,
			"slider" => "no",
			"slides_space" => 0,
			"controls" => "no",
			"interval" => "",
			"autoheight" => "no",
			"custom" => "no",
			"ids" => "",
			"cat" => "",
			"count" => 4,
			"offset" => "",
			"orderby" => "date",
			"order" => "desc",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link_caption" => esc_html__('Learn more', 'rosemary'),
			"link" => '',
			"scheme" => '',
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

		if (empty($id)) $id = "sc_clients_".str_replace('.', '', mt_rand());
		if (empty($width)) $width = "100%";
		if (!empty($height) && rosemary_param_is_on($autoheight)) $autoheight = "no";
		if (empty($interval)) $interval = mt_rand(5000, 10000);

		$class .= ($class ? ' ' : '') . rosemary_get_css_position_as_classes($top, $right, $bottom, $left);

		$ws = rosemary_get_css_dimensions_from_values($width);
		$hs = rosemary_get_css_dimensions_from_values('', $height);
		$css .= ($hs) . ($ws);

		if (rosemary_param_is_on($slider)) rosemary_enqueue_slider('swiper');
	
		$columns = max(1, min(12, $columns));
		$count = max(1, (int) $count);
		if (rosemary_param_is_off($custom) && $count < $columns) $columns = $count;
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['sc_clients_id'] = $id;
		$ROSEMARY_GLOBALS['sc_clients_style'] = $style;
		$ROSEMARY_GLOBALS['sc_clients_counter'] = 0;
		$ROSEMARY_GLOBALS['sc_clients_columns'] = $columns;
		$ROSEMARY_GLOBALS['sc_clients_slider'] = $slider;
		$ROSEMARY_GLOBALS['sc_clients_css_wh'] = $ws . $hs;

		$output = '<div' . ($id ? ' id="'.esc_attr($id).'_wrap"' : '') 
						. ' class="sc_clients_wrap'
						. ($scheme && !rosemary_param_is_off($scheme) && !rosemary_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '')
						.'">'
					. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_clients sc_clients_style_'.esc_attr($style)
							. ' ' . esc_attr(rosemary_get_template_property($style, 'container_classes'))
							. ' ' . esc_attr(rosemary_get_slider_controls_classes($controls))
							. (!empty($class) ? ' '.esc_attr($class) : '')
							. (rosemary_param_is_on($slider)
								? ' sc_slider_swiper swiper-slider-container'
									. (rosemary_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
									. ($hs ? ' sc_slider_height_fixed' : '')
								: '')
						.'"'
						. (!empty($width) && rosemary_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
						. (!empty($height) && rosemary_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
						. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
						. ($columns > 1 ? ' data-slides-per-view="' . esc_attr($columns) . '"' : '')
						. ($slides_space > 0 ? ' data-slides-space="' . esc_attr($slides_space) . '"' : '')
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
						. (!rosemary_param_is_off($animation) ? ' data-animation="'.esc_attr(rosemary_get_animation_classes($animation)).'"' : '')
					. '>'
					. (!empty($subtitle) ? '<h6 class="sc_clients_subtitle sc_item_subtitle">' . trim(rosemary_strmacros($subtitle)) . '</h6>' : '')
					. (!empty($title) ? '<h2 class="sc_clients_title sc_item_title">' . trim(rosemary_strmacros($title)) . '</h2>' : '')
					. (!empty($description) ? '<div class="sc_clients_descr sc_item_descr">' . trim(rosemary_strmacros($description)) . '</div>' : '')
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
				'post_type' => 'clients',
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => true,
				'order' => $order=='asc' ? 'asc' : 'desc',
			);
		
			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}
		
			$args = rosemary_query_add_sort_order($args, $orderby, $order);
			$args = rosemary_query_add_posts_and_cats($args, $ids, 'clients', $cat, 'clients_group');

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
				$post_meta = get_post_meta($post_data['post_id'], 'post_custom_options', true);
				$thumb_sizes = rosemary_get_thumb_sizes(array('layout' => $style));
				$args['client_name'] = $post_meta['client_name'];
				$args['client_position'] = $post_meta['client_position'];
				$args['client_image'] = $post_data['post_thumb'];
				$args['client_link'] = rosemary_param_is_on('client_show_link')
					? (!empty($post_meta['client_link']) ? $post_meta['client_link'] : $post_data['post_link'])
					: '';
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

		$output .= (!empty($link) ? '<div class="sc_clients_button sc_item_button">'.rosemary_do_shortcode('[trx_button link="'.esc_url($link).'" icon="icon-right"]'.esc_html($link_caption).'[/trx_button]').'</div>' : '')
				. '</div><!-- /.sc_clients -->'
			. '</div><!-- /.sc_clients_wrap -->';
	
		// Add template specific scripts and styles
		do_action('rosemary_action_blog_scripts', $style);
	
		return apply_filters('rosemary_shortcode_output', $output, 'trx_clients', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_clients', 'rosemary_sc_clients');
}


if ( !function_exists( 'rosemary_sc_clients_item' ) ) {
	function rosemary_sc_clients_item($atts, $content=null) {
		if (rosemary_in_shortcode_blogger()) return '';
		extract(rosemary_html_decode(shortcode_atts( array(
			// Individual params
			"name" => "",
			"position" => "",
			"image" => "",
			"link" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => ""
		), $atts)));
	
		global $ROSEMARY_GLOBALS;
		$ROSEMARY_GLOBALS['sc_clients_counter']++;
	
		$id = $id ? $id : ($ROSEMARY_GLOBALS['sc_clients_id'] ? $ROSEMARY_GLOBALS['sc_clients_id'] . '_' . $ROSEMARY_GLOBALS['sc_clients_counter'] : '');
	
		$descr = trim(chop(do_shortcode($content)));
	
		$thumb_sizes = rosemary_get_thumb_sizes(array('layout' => $ROSEMARY_GLOBALS['sc_clients_style']));

		if ($image > 0) {
			$attach = wp_get_attachment_image_src( $image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$image = $attach[0];
		}
		$image = rosemary_get_resized_image_tag($image, $thumb_sizes['w'], $thumb_sizes['h']);

		$post_data = array(
			'post_title' => $name,
			'post_excerpt' => $descr
		);
		$args = array(
			'layout' => $ROSEMARY_GLOBALS['sc_clients_style'],
			'number' => $ROSEMARY_GLOBALS['sc_clients_counter'],
			'columns_count' => $ROSEMARY_GLOBALS['sc_clients_columns'],
			'slider' => $ROSEMARY_GLOBALS['sc_clients_slider'],
			'show' => false,
			'descr'  => 0,
			'tag_id' => $id,
			'tag_class' => $class,
			'tag_animation' => $animation,
			'tag_css' => $css,
			'tag_css_wh' => $ROSEMARY_GLOBALS['sc_clients_css_wh'],
			'client_position' => $position,
			'client_link' => $link,
			'client_image' => $image
		);
		$output = rosemary_show_post_layout($args, $post_data);
		return apply_filters('rosemary_shortcode_output', $output, 'trx_clients_item', $atts, $content);
	}
	if (function_exists('rosemary_require_shortcode')) rosemary_require_shortcode('trx_clients_item', 'rosemary_sc_clients_item');
}
// ---------------------------------- [/trx_clients] ---------------------------------------



// Add [trx_clients] and [trx_clients_item] in the shortcodes list
if (!function_exists('rosemary_clients_reg_shortcodes')) {
	//add_filter('rosemary_action_shortcodes_list',	'rosemary_clients_reg_shortcodes');
	function rosemary_clients_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
		if (isset($ROSEMARY_GLOBALS['shortcodes'])) {

			$users = rosemary_get_list_users();
			$members = rosemary_get_list_posts(false, array(
				'post_type'=>'clients',
				'orderby'=>'title',
				'order'=>'asc',
				'return'=>'title'
				)
			);
			$clients_groups = rosemary_get_list_terms(false, 'clients_group');
			$clients_styles = rosemary_get_list_templates('clients');
			$controls 		= rosemary_get_list_slider_controls();

			rosemary_array_insert_after($ROSEMARY_GLOBALS['shortcodes'], 'trx_chat', array(

				// Clients
				"trx_clients" => array(
					"title" => esc_html__("Clients", "rosemary"),
					"desc" => wp_kses( __("Insert clients list in your page (post)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
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
							"title" => esc_html__("Clients style", "rosemary"),
							"desc" => wp_kses( __("Select style to display clients list", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => "clients-1",
							"type" => "select",
							"options" => $clients_styles
						),
						"columns" => array(
							"title" => esc_html__("Columns", "rosemary"),
							"desc" => wp_kses( __("How many columns use to show clients", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => 4,
							"min" => 2,
							"max" => 6,
							"step" => 1,
							"type" => "spinner"
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", "rosemary"),
							"desc" => wp_kses( __("Select color scheme for this block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => "",
							"type" => "checklist",
							"options" => $ROSEMARY_GLOBALS['sc_params']['schemes']
						),
						"slider" => array(
							"title" => esc_html__("Slider", "rosemary"),
							"desc" => wp_kses( __("Use slider to show clients", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => "no",
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
							"value" => "no",
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
							"value" => "no",
							"type" => "switch",
							"options" => $ROSEMARY_GLOBALS['sc_params']['yes_no']
						),
						"custom" => array(
							"title" => esc_html__("Custom", "rosemary"),
							"desc" => wp_kses( __("Allow get team members from inner shortcodes (custom) or get it from specified group (cat)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $ROSEMARY_GLOBALS['sc_params']['yes_no']
						),
						"cat" => array(
							"title" => esc_html__("Categories", "rosemary"),
							"desc" => wp_kses( __("Select categories (groups) to show team members. If empty - select team members from any category (group) or from IDs list", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'custom' => array('no')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => rosemary_array_merge(array(0 => esc_html__('- Select category -', 'rosemary')), $clients_groups)
						),
						"count" => array(
							"title" => esc_html__("Number of posts", "rosemary"),
							"desc" => wp_kses( __("How many posts will be displayed? If used IDs - this parameter ignored.", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 4,
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
							"value" => "title",
							"type" => "select",
							"options" => $ROSEMARY_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => esc_html__("Post order", "rosemary"),
							"desc" => wp_kses( __("Select desired posts order", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "asc",
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
						"link" => array(
							"title" => esc_html__("Button URL", "rosemary"),
							"desc" => wp_kses( __("Link URL for the button at the bottom of the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => "",
							"type" => "text"
						),
						"link_caption" => array(
							"title" => esc_html__("Button caption", "rosemary"),
							"desc" => wp_kses( __("Caption for the button at the bottom of the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
							"value" => "",
							"type" => "text"
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
						"name" => "trx_clients_item",
						"title" => esc_html__("Client", "rosemary"),
						"desc" => wp_kses( __("Single client (custom parameters)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"container" => true,
						"params" => array(
							"name" => array(
								"title" => esc_html__("Name", "rosemary"),
								"desc" => wp_kses( __("Client's name", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"position" => array(
								"title" => esc_html__("Position", "rosemary"),
								"desc" => wp_kses( __("Client's position", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
								"value" => "",
								"type" => "text"
							),
							"link" => array(
								"title" => esc_html__("Link", "rosemary"),
								"desc" => wp_kses( __("Link on client's personal page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"image" => array(
								"title" => esc_html__("Image", "rosemary"),
								"desc" => wp_kses( __("Client's image", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
								"value" => "",
								"readonly" => false,
								"type" => "media"
							),
							"_content_" => array(
								"title" => esc_html__("Description", "rosemary"),
								"desc" => wp_kses( __("Client's short description", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $ROSEMARY_GLOBALS['sc_params']['id'],
							"class" => $ROSEMARY_GLOBALS['sc_params']['class'],
							"animation" => $ROSEMARY_GLOBALS['sc_params']['animation'],
							"css" => $ROSEMARY_GLOBALS['sc_params']['css']
						)
					)
				)

			));
		}
	}
}


// Add [trx_clients] and [trx_clients_item] in the VC shortcodes list
if (!function_exists('rosemary_clients_reg_shortcodes_vc')) {
	//add_filter('rosemary_action_shortcodes_list_vc',	'rosemary_clients_reg_shortcodes_vc');
	function rosemary_clients_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;

		$clients_groups = rosemary_get_list_terms(false, 'clients_group');
		$clients_styles = rosemary_get_list_templates('clients');
		$controls		= rosemary_get_list_slider_controls();

		// Clients
		vc_map( array(
				"base" => "trx_clients",
				"name" => esc_html__("Clients", "rosemary"),
				"description" => wp_kses( __("Insert clients list", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_clients',
				"class" => "trx_sc_columns trx_sc_clients",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_clients_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Clients style", "rosemary"),
						"description" => wp_kses( __("Select style to display clients list", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip($clients_styles),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", "rosemary"),
						"description" => wp_kses( __("Select color scheme for this block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['schemes']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slider",
						"heading" => esc_html__("Slider", "rosemary"),
						"description" => wp_kses( __("Use slider to show testimonials", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'rosemary'),
						"class" => "",
						"std" => "no",
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
						"param_name" => "custom",
						"heading" => esc_html__("Custom", "rosemary"),
						"description" => wp_kses( __("Allow get clients from inner shortcodes (custom) or get it from specified group (cat)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => array("Custom clients" => "yes" ),
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
						"description" => wp_kses( __("Select category to show clients. If empty - select clients from any category (group) or from IDs list", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Query', 'rosemary'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip(rosemary_array_merge(array(0 => esc_html__('- Select category -', 'rosemary')), $clients_groups)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "rosemary"),
						"description" => wp_kses( __("How many columns use to show clients", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Query', 'rosemary'),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
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
						"value" => "4",
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
						"heading" => esc_html__("client's IDs list", "rosemary"),
						"description" => wp_kses( __("Comma separated list of client's ID. If set - parameters above (category, count, order, etc.)  are ignored!", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
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
						"param_name" => "link",
						"heading" => esc_html__("Button URL", "rosemary"),
						"description" => wp_kses( __("Link URL for the button at the bottom of the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Captions', 'rosemary'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link_caption",
						"heading" => esc_html__("Button caption", "rosemary"),
						"description" => wp_kses( __("Caption for the button at the bottom of the block", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"group" => esc_html__('Captions', 'rosemary'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$ROSEMARY_GLOBALS['vc_params']['margin_top'],
					$ROSEMARY_GLOBALS['vc_params']['margin_bottom'],
					$ROSEMARY_GLOBALS['vc_params']['margin_left'],
					$ROSEMARY_GLOBALS['vc_params']['margin_right'],
					$ROSEMARY_GLOBALS['vc_params']['id'],
					$ROSEMARY_GLOBALS['vc_params']['class'],
					$ROSEMARY_GLOBALS['vc_params']['animation'],
					$ROSEMARY_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxColumnsView'
			) );
			
			
		vc_map( array(
				"base" => "trx_clients_item",
				"name" => esc_html__("Client", "rosemary"),
				"description" => wp_kses( __("Client - all data pull out from it account on your site", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"show_settings_on_create" => true,
				"class" => "trx_sc_collection trx_sc_column_item trx_sc_clients_item",
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_clients_item',
				"as_child" => array('only' => 'trx_clients'),
				"as_parent" => array('except' => 'trx_clients'),
				"params" => array(
					array(
						"param_name" => "name",
						"heading" => esc_html__("Name", "rosemary"),
						"description" => wp_kses( __("Client's name", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "position",
						"heading" => esc_html__("Position", "rosemary"),
						"description" => wp_kses( __("Client's position", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link", "rosemary"),
						"description" => wp_kses( __("Link on client's personal page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("Client's image", "rosemary"),
						"description" => wp_kses( __("Clients's image", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					$ROSEMARY_GLOBALS['vc_params']['id'],
					$ROSEMARY_GLOBALS['vc_params']['class'],
					$ROSEMARY_GLOBALS['vc_params']['animation'],
					$ROSEMARY_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxColumnItemView'
			) );
			
		class WPBakeryShortCode_Trx_Clients extends ROSEMARY_VC_ShortCodeColumns {}
		class WPBakeryShortCode_Trx_Clients_Item extends ROSEMARY_VC_ShortCodeCollection {}

	}
}
?>