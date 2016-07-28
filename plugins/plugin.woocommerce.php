<?php
/* Woocommerce support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('rosemary_woocommerce_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_woocommerce_theme_setup', 1 );
	function rosemary_woocommerce_theme_setup() {

		if (rosemary_exists_woocommerce()) {
			add_action('rosemary_action_add_styles', 				'rosemary_woocommerce_frontend_scripts' );

			// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
			add_filter('rosemary_filter_get_blog_type',				'rosemary_woocommerce_get_blog_type', 9, 2);
			add_filter('rosemary_filter_get_blog_title',			'rosemary_woocommerce_get_blog_title', 9, 2);
			add_filter('rosemary_filter_get_current_taxonomy',		'rosemary_woocommerce_get_current_taxonomy', 9, 2);
			add_filter('rosemary_filter_is_taxonomy',				'rosemary_woocommerce_is_taxonomy', 9, 2);
			add_filter('rosemary_filter_get_stream_page_title',		'rosemary_woocommerce_get_stream_page_title', 9, 2);
			add_filter('rosemary_filter_get_stream_page_link',		'rosemary_woocommerce_get_stream_page_link', 9, 2);
			add_filter('rosemary_filter_get_stream_page_id',		'rosemary_woocommerce_get_stream_page_id', 9, 2);
			add_filter('rosemary_filter_detect_inheritance_key',	'rosemary_woocommerce_detect_inheritance_key', 9, 1);
			add_filter('rosemary_filter_detect_template_page_id',	'rosemary_woocommerce_detect_template_page_id', 9, 2);

			add_filter('rosemary_filter_list_post_types', 			'rosemary_woocommerce_list_post_types', 10, 1);

			if (is_admin()) {
				add_filter( 'rosemary_filter_importer_options',				'rosemary_woocommerce_importer_set_options' );
				add_action( 'rosemary_action_importer_after_import_posts',	'rosemary_woocommerce_importer_after_import_posts', 10, 1 );
			}
		}

		if (is_admin()) {
			add_filter( 'rosemary_filter_importer_required_plugins',		'rosemary_woocommerce_importer_required_plugins', 10, 2 );
			add_filter( 'rosemary_filter_required_plugins',					'rosemary_woocommerce_required_plugins' );
		}
	}
}

if ( !function_exists( 'rosemary_woocommerce_settings_theme_setup2' ) ) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_woocommerce_settings_theme_setup2', 3 );
	function rosemary_woocommerce_settings_theme_setup2() {
		if (rosemary_exists_woocommerce()) {
			// Add WooCommerce pages in the Theme inheritance system
			rosemary_add_theme_inheritance( array( 'woocommerce' => array(
				'stream_template' => '',
				'single_template' => '',
				'taxonomy' => array('product_cat'),
				'taxonomy_tags' => array('product_tag'),
				'post_type' => array('product'),
				'override' => 'page'
				) )
			);

			// Add WooCommerce specific options in the Theme Options
			global $ROSEMARY_GLOBALS;

			rosemary_array_insert_before($ROSEMARY_GLOBALS['options'], 'partition_service', array(
				
				"partition_woocommerce" => array(
					"title" => esc_html__('WooCommerce', 'rosemary'),
					"icon" => "iconadmin-basket",
					"type" => "partition"),

				"info_wooc_1" => array(
					"title" => esc_html__('WooCommerce products list parameters', 'rosemary'),
					"desc" => esc_html__("Select WooCommerce products list's style and crop parameters", 'rosemary'),
					"type" => "info"),
		
				"shop_mode" => array(
					"title" => esc_html__('Shop list style',  'rosemary'),
					"desc" => esc_html__("WooCommerce products list's style: thumbs or list with description", 'rosemary'),
					"std" => "thumbs",
					"divider" => false,
					"options" => array(
						'thumbs' => esc_html__('Thumbs', 'rosemary'),
						'list' => esc_html__('List', 'rosemary')
					),
					"type" => "checklist"),
		
				"show_mode_buttons" => array(
					"title" => esc_html__('Show style buttons',  'rosemary'),
					"desc" => esc_html__("Show buttons to allow visitors change list style", 'rosemary'),
					"std" => "yes",
					"options" => $ROSEMARY_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

				"shop_loop_columns" => array(
					"title" => esc_html__('Shop columns',  'rosemary'),
					"desc" => esc_html__("How many columns used to show products on shop page", 'rosemary'),
					"override" => "category,post,page",
					"std" => "3",
					"step" => 1,
					"min" => 1,
					"max" => 6,
					"type" => "spinner"),

				"show_currency" => array(
					"title" => esc_html__('Show currency selector', 'rosemary'),
					"desc" => esc_html__('Show currency selector in the user menu', 'rosemary'),
					"std" => "yes",
					"options" => $ROSEMARY_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
				"show_cart" => array(
					"title" => esc_html__('Show cart button', 'rosemary'),
					"desc" => esc_html__('Show cart button in the user menu', 'rosemary'),
					"std" => "shop",
					"options" => array(
						'hide'   => esc_html__('Hide', 'rosemary'),
						'always' => esc_html__('Always', 'rosemary'),
						'shop'   => esc_html__('Only on shop pages', 'rosemary')
					),
					"type" => "checklist"),

				"crop_product_thumb" => array(
					"title" => esc_html__("Crop product's thumbnail",  'rosemary'),
					"desc" => esc_html__("Crop product's thumbnails on search results page or scale it", 'rosemary'),
					"std" => "no",
					"options" => $ROSEMARY_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch")
				
				)
			);

		}
	}
}

// WooCommerce hooks
if (!function_exists('rosemary_woocommerce_theme_setup3')) {
	add_action( 'rosemary_action_after_init_theme', 'rosemary_woocommerce_theme_setup3' );
	function rosemary_woocommerce_theme_setup3() {

		if (rosemary_exists_woocommerce()) {

			add_action(    'woocommerce_before_subcategory_title',		'rosemary_woocommerce_open_thumb_wrapper', 9 );
			add_action(    'woocommerce_before_shop_loop_item_title',	'rosemary_woocommerce_open_thumb_wrapper', 9 );

			add_action(    'woocommerce_before_subcategory_title',		'rosemary_woocommerce_open_item_wrapper', 20 );
			add_action(    'woocommerce_before_shop_loop_item_title',	'rosemary_woocommerce_open_item_wrapper', 20 );

			add_action(    'woocommerce_after_subcategory',				'rosemary_woocommerce_close_item_wrapper', 20 );
			add_action(    'woocommerce_after_shop_loop_item',			'rosemary_woocommerce_close_item_wrapper', 20 );

			add_action(    'woocommerce_after_shop_loop_item_title',	'rosemary_woocommerce_after_shop_loop_item_title', 7);

			add_action(    'woocommerce_after_subcategory_title',		'rosemary_woocommerce_after_subcategory_title', 10 );
		}

		if (rosemary_is_woocommerce_page()) {
			
			remove_action( 'woocommerce_sidebar', 						'woocommerce_get_sidebar', 10 );					// Remove WOOC sidebar
			
			remove_action( 'woocommerce_before_main_content',			'woocommerce_output_content_wrapper', 10);
			add_action(    'woocommerce_before_main_content',			'rosemary_woocommerce_wrapper_start', 10);
			
			remove_action( 'woocommerce_after_main_content',			'woocommerce_output_content_wrapper_end', 10);		
			add_action(    'woocommerce_after_main_content',			'rosemary_woocommerce_wrapper_end', 10);

			add_action(    'woocommerce_show_page_title',				'rosemary_woocommerce_show_page_title', 10);

			remove_action( 'woocommerce_single_product_summary',		'woocommerce_template_single_title', 5);		
			add_action(    'woocommerce_single_product_summary',		'rosemary_woocommerce_show_product_title', 5 );

			add_action(    'woocommerce_before_shop_loop', 				'rosemary_woocommerce_before_shop_loop', 10 );

			remove_action( 'woocommerce_after_shop_loop',				'woocommerce_pagination', 10 );
			add_action(    'woocommerce_after_shop_loop',				'rosemary_woocommerce_pagination', 10 );

			add_action(    'woocommerce_product_meta_end',				'rosemary_woocommerce_show_product_id', 10);

			add_filter(    'woocommerce_output_related_products_args',	'rosemary_woocommerce_output_related_products_args' );
			
			add_filter(    'woocommerce_product_thumbnails_columns',	'rosemary_woocommerce_product_thumbnails_columns' );

			add_filter(    'loop_shop_columns',							'rosemary_woocommerce_loop_shop_columns' );

			add_filter(    'get_product_search_form',					'rosemary_woocommerce_get_product_search_form' );

			add_filter(    'post_class',								'rosemary_woocommerce_loop_shop_columns_class' );
			add_action(    'the_title',									'rosemary_woocommerce_the_title');
			
			rosemary_enqueue_popup();
		}
	}
}



// Check if WooCommerce installed and activated
if ( !function_exists( 'rosemary_exists_woocommerce' ) ) {
	function rosemary_exists_woocommerce() {
		return class_exists('Woocommerce');
		//return function_exists('is_woocommerce');
	}
}

// Return true, if current page is any woocommerce page
if ( !function_exists( 'rosemary_is_woocommerce_page' ) ) {
	function rosemary_is_woocommerce_page() {
		$rez = false;
		if (rosemary_exists_woocommerce()) {
			global $ROSEMARY_GLOBALS;
			if (!empty($ROSEMARY_GLOBALS['pre_query'])) {
				$id = isset($ROSEMARY_GLOBALS['pre_query']->queried_object_id) ? $ROSEMARY_GLOBALS['pre_query']->queried_object_id : 0;
				$rez = $ROSEMARY_GLOBALS['pre_query']->get('post_type')=='product' 
						|| $id==wc_get_page_id('shop')
						|| $id==wc_get_page_id('cart')
						|| $id==wc_get_page_id('checkout')
						|| $id==wc_get_page_id('myaccount')
						|| $ROSEMARY_GLOBALS['pre_query']->is_tax( 'product_cat' )
						|| $ROSEMARY_GLOBALS['pre_query']->is_tax( 'product_tag' )
						|| $ROSEMARY_GLOBALS['pre_query']->is_tax( get_object_taxonomies( 'product' ) );
						
			} else
				$rez = is_shop() || is_product() || is_product_category() || is_product_tag() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page();
		}
		return $rez;
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'rosemary_woocommerce_required_plugins' ) ) {
	//add_filter('rosemary_filter_required_plugins',	'rosemary_woocommerce_required_plugins');
	function rosemary_woocommerce_required_plugins($list=array()) {
		$list[] = array(
					'name' 		=> 'WooCommerce',
					'slug' 		=> 'woocommerce',
					'required' 	=> false
				);

		return $list;
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'rosemary_woocommerce_detect_inheritance_key' ) ) {
	//add_filter('rosemary_filter_detect_inheritance_key',	'rosemary_woocommerce_detect_inheritance_key', 9, 1);
	function rosemary_woocommerce_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return rosemary_is_woocommerce_page() ? 'woocommerce' : '';
	}
}

// Filter to detect current template page id
if ( !function_exists( 'rosemary_woocommerce_detect_template_page_id' ) ) {
	//add_filter('rosemary_filter_detect_template_page_id',	'rosemary_woocommerce_detect_template_page_id', 9, 2);
	function rosemary_woocommerce_detect_template_page_id($id, $key) {
		if (!empty($id)) return $id;
		if ($key == 'woocommerce_cart')				$id = get_option('woocommerce_cart_page_id');
		else if ($key == 'woocommerce_checkout')	$id = get_option('woocommerce_checkout_page_id');
		else if ($key == 'woocommerce_account')		$id = get_option('woocommerce_account_page_id');
		else if ($key == 'woocommerce')				$id = get_option('woocommerce_shop_page_id');
		return $id;
	}
}

// Filter to detect current page type (slug)
if ( !function_exists( 'rosemary_woocommerce_get_blog_type' ) ) {
	//add_filter('rosemary_filter_get_blog_type',	'rosemary_woocommerce_get_blog_type', 9, 2);
	function rosemary_woocommerce_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		
		if (is_shop()) 					$page = 'woocommerce_shop';
		else if ($query && $query->get('post_type')=='product' || is_product())		$page = 'woocommerce_product';
		else if ($query && $query->get('product_tag')!='' || is_product_tag())		$page = 'woocommerce_tag';
		else if ($query && $query->get('product_cat')!='' || is_product_category())	$page = 'woocommerce_category';
		else if (is_cart())				$page = 'woocommerce_cart';
		else if (is_checkout())			$page = 'woocommerce_checkout';
		else if (is_account_page())		$page = 'woocommerce_account';
		else if (is_woocommerce())		$page = 'woocommerce';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'rosemary_woocommerce_get_blog_title' ) ) {
	//add_filter('rosemary_filter_get_blog_title',	'rosemary_woocommerce_get_blog_title', 9, 2);
	function rosemary_woocommerce_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		
		if ( rosemary_strpos($page, 'woocommerce')!==false ) {
			if ( $page == 'woocommerce_category' ) {
				$term = get_term_by( 'slug', get_query_var( 'product_cat' ), 'product_cat', OBJECT);
				$title = $term->name;
			} else if ( $page == 'woocommerce_tag' ) {
				$term = get_term_by( 'slug', get_query_var( 'product_tag' ), 'product_tag', OBJECT);
				$title = esc_html__('Tag:', 'rosemary') . ' ' . esc_html($term->name);
			} else if ( $page == 'woocommerce_cart' ) {
				$title = esc_html__( 'Your cart', 'rosemary' );
			} else if ( $page == 'woocommerce_checkout' ) {
				$title = esc_html__( 'Checkout', 'rosemary' );
			} else if ( $page == 'woocommerce_account' ) {
				$title = esc_html__( 'Account', 'rosemary' );
			} else if ( $page == 'woocommerce_product' ) {
				$title = rosemary_get_post_title();
			} else if (($page_id=get_option('woocommerce_shop_page_id')) > 0) {
				$title = rosemary_get_post_title($page_id);
			} else {
				$title = esc_html__( 'Shop', 'rosemary' );
			}
		}
		
		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'rosemary_woocommerce_get_stream_page_title' ) ) {
	//add_filter('rosemary_filter_get_stream_page_title',	'rosemary_woocommerce_get_stream_page_title', 9, 2);
	function rosemary_woocommerce_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (rosemary_strpos($page, 'woocommerce')!==false) {
			if (($page_id = rosemary_woocommerce_get_stream_page_id(0, $page)) > 0)
				$title = rosemary_get_post_title($page_id);
			else
				$title = esc_html__('Shop', 'rosemary');				
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'rosemary_woocommerce_get_stream_page_id' ) ) {
	//add_filter('rosemary_filter_get_stream_page_id',	'rosemary_woocommerce_get_stream_page_id', 9, 2);
	function rosemary_woocommerce_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (rosemary_strpos($page, 'woocommerce')!==false) {
			$id = get_option('woocommerce_shop_page_id');
		}
		return $id;
	}
}

// Filter to detect stream page link
if ( !function_exists( 'rosemary_woocommerce_get_stream_page_link' ) ) {
	//add_filter('rosemary_filter_get_stream_page_link',	'rosemary_woocommerce_get_stream_page_link', 9, 2);
	function rosemary_woocommerce_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (rosemary_strpos($page, 'woocommerce')!==false) {
			$id = rosemary_woocommerce_get_stream_page_id(0, $page);
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'rosemary_woocommerce_get_current_taxonomy' ) ) {
	//add_filter('rosemary_filter_get_current_taxonomy',	'rosemary_woocommerce_get_current_taxonomy', 9, 2);
	function rosemary_woocommerce_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( rosemary_strpos($page, 'woocommerce')!==false ) {
			$tax = 'product_cat';
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'rosemary_woocommerce_is_taxonomy' ) ) {
	//add_filter('rosemary_filter_is_taxonomy',	'rosemary_woocommerce_is_taxonomy', 9, 2);
	function rosemary_woocommerce_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else 
			return $query && $query->get('product_cat')!='' || is_product_category() ? 'product_cat' : '';
	}
}

// Add custom post type into list
if ( !function_exists( 'rosemary_woocommerce_list_post_types' ) ) {
	//add_filter('rosemary_filter_list_post_types', 	'rosemary_woocommerce_list_post_types', 10, 1);
	function rosemary_woocommerce_list_post_types($list) {
		$list['product'] = esc_html__('Products', 'rosemary');
		return $list;
	}
}


	
// Enqueue WooCommerce custom styles
if ( !function_exists( 'rosemary_woocommerce_frontend_scripts' ) ) {
	//add_action( 'rosemary_action_add_styles', 'rosemary_woocommerce_frontend_scripts' );
	function rosemary_woocommerce_frontend_scripts() {
		if (rosemary_is_woocommerce_page() || rosemary_get_custom_option('show_cart')=='always')
			rosemary_enqueue_style( 'rosemary-woo-style',  rosemary_get_file_url('css/woo-style.css'), array(), null );
	}
}

// Replace standard WooCommerce function
/*
if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {
	function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
		global $post;
		if ( has_post_thumbnail() ) {
			$s = wc_get_image_size( $size );
			return rosemary_get_resized_image_tag($post->ID, $s['width'], rosemary_get_theme_option('crop_product_thumb')=='no' ? null :  $s['height']);
			//return get_the_post_thumbnail( $post->ID, array($s['width'], $s['height']) );
		} else if ( wc_placeholder_img_src() )
			return wc_placeholder_img( $size );
	}
}
*/

// Before main content
if ( !function_exists( 'rosemary_woocommerce_wrapper_start' ) ) {
	//remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	//add_action('woocommerce_before_main_content', 'rosemary_woocommerce_wrapper_start', 10);
	function rosemary_woocommerce_wrapper_start() {
		global $ROSEMARY_GLOBALS;
		if (is_product() || is_cart() || is_checkout() || is_account_page()) {
			?>
			<article class="post_item post_item_single post_item_product">
			<?php
		} else {
			?>
			<div class="list_products shop_mode_<?php echo !empty($ROSEMARY_GLOBALS['shop_mode']) ? $ROSEMARY_GLOBALS['shop_mode'] : 'thumbs'; ?>">
			<?php
		}
	}
}

// After main content
if ( !function_exists( 'rosemary_woocommerce_wrapper_end' ) ) {
	//remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);		
	//add_action('woocommerce_after_main_content', 'rosemary_woocommerce_wrapper_end', 10);
	function rosemary_woocommerce_wrapper_end() {
		if (is_product() || is_cart() || is_checkout() || is_account_page()) {
			?>
			</article>	<!-- .post_item -->
			<?php
		} else {
			?>
			</div>	<!-- .list_products -->
			<?php
		}
	}
}

// Check to show page title
if ( !function_exists( 'rosemary_woocommerce_show_page_title' ) ) {
	//add_action('woocommerce_show_page_title', 'rosemary_woocommerce_show_page_title', 10);
	function rosemary_woocommerce_show_page_title($defa=true) {
		return rosemary_get_custom_option('show_page_title')=='no';
	}
}

// Check to show product title
if ( !function_exists( 'rosemary_woocommerce_show_product_title' ) ) {
	//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);		
	//add_action( 'woocommerce_single_product_summary', 'rosemary_woocommerce_show_product_title', 5 );
	function rosemary_woocommerce_show_product_title() {
		if (rosemary_get_custom_option('show_post_title')=='yes' || rosemary_get_custom_option('show_page_title')=='no') {
			wc_get_template( 'single-product/title.php' );
		}
	}
}

// Add list mode buttons
if ( !function_exists( 'rosemary_woocommerce_before_shop_loop' ) ) {
	//add_action( 'woocommerce_before_shop_loop', 'rosemary_woocommerce_before_shop_loop', 10 );
	function rosemary_woocommerce_before_shop_loop() {
		global $ROSEMARY_GLOBALS;
		if (rosemary_get_custom_option('show_mode_buttons')=='yes') {
			echo '<div class="mode_buttons"><form action="' . esc_url(rosemary_get_protocol().'://' . ($_SERVER["HTTP_HOST"]) . ($_SERVER["REQUEST_URI"])).'" method="post">'
				. '<input type="hidden" name="rosemary_shop_mode" value="'.esc_attr($ROSEMARY_GLOBALS['shop_mode']).'" />'
				. '<a href="#" class="woocommerce_thumbs icon-th" title="'.esc_attr__('Show products as thumbs', 'rosemary').'"></a>'
				. '<a href="#" class="woocommerce_list icon-th-list" title="'.esc_attr__('Show products as list', 'rosemary').'"></a>'
				. '</form></div>';
		}
	}
}


// Open thumbs wrapper for categories and products
if ( !function_exists( 'rosemary_woocommerce_open_thumb_wrapper' ) ) {
	//add_action( 'woocommerce_before_subcategory_title', 'rosemary_woocommerce_open_thumb_wrapper', 9 );
	//add_action( 'woocommerce_before_shop_loop_item_title', 'rosemary_woocommerce_open_thumb_wrapper', 9 );
	function rosemary_woocommerce_open_thumb_wrapper($cat='') {
		rosemary_set_global('in_product_item', true);
		?>
		<div class="post_item_wrap">
			<div class="post_featured">
				<div class="post_thumb">
					<a class="hover_icon hover_icon_link" href="<?php echo get_permalink(); ?>">
		<?php
	}
}

// Open item wrapper for categories and products
if ( !function_exists( 'rosemary_woocommerce_open_item_wrapper' ) ) {
	//add_action( 'woocommerce_before_subcategory_title', 'rosemary_woocommerce_open_item_wrapper', 20 );
	//add_action( 'woocommerce_before_shop_loop_item_title', 'rosemary_woocommerce_open_item_wrapper', 20 );
	function rosemary_woocommerce_open_item_wrapper($cat='') {
		?>
				</a>
			</div>
		</div>
		<div class="post_content">
		<?php
	}
}

// Close item wrapper for categories and products
if ( !function_exists( 'rosemary_woocommerce_close_item_wrapper' ) ) {
	//add_action( 'woocommerce_after_subcategory', 'rosemary_woocommerce_close_item_wrapper', 20 );
	//add_action( 'woocommerce_after_shop_loop_item', 'rosemary_woocommerce_close_item_wrapper', 20 );
	function rosemary_woocommerce_close_item_wrapper($cat='') {
		?>
			</div>
		</div>
		<?php
		rosemary_set_global('in_product_item', false);
	}
}

// Add excerpt in output for the product in the list mode
if ( !function_exists( 'rosemary_woocommerce_after_shop_loop_item_title' ) ) {
	//add_action( 'woocommerce_after_shop_loop_item_title', 'rosemary_woocommerce_after_shop_loop_item_title', 7);
	function rosemary_woocommerce_after_shop_loop_item_title() {
		global $ROSEMARY_GLOBALS;
		if ($ROSEMARY_GLOBALS['shop_mode'] == 'list') {
		    $excerpt = apply_filters('the_excerpt', get_the_excerpt());
			echo '<div class="description">'.trim($excerpt).'</div>';
		}
	}
}

// Add excerpt in output for the product in the list mode
if ( !function_exists( 'rosemary_woocommerce_after_subcategory_title' ) ) {
	//add_action( 'woocommerce_after_subcategory_title', 'rosemary_woocommerce_after_subcategory_title', 10 );
	function rosemary_woocommerce_after_subcategory_title($category) {
		global $ROSEMARY_GLOBALS;
		if ($ROSEMARY_GLOBALS['shop_mode'] == 'list')
			echo '<div class="description">' . trim($category->description) . '</div>';
	}
}

// Add Product ID for single product
if ( !function_exists( 'rosemary_woocommerce_show_product_id' ) ) {
	//add_action( 'woocommerce_product_meta_end', 'rosemary_woocommerce_show_product_id', 10);
	function rosemary_woocommerce_show_product_id() {
		global $post, $product;
		echo '<span class="product_id">'.esc_html__('Product ID: ', 'rosemary') . '<span>' . ($post->ID) . '</span></span>';
	}
}

// Redefine number of related products
if ( !function_exists( 'rosemary_woocommerce_output_related_products_args' ) ) {
	//add_filter( 'woocommerce_output_related_products_args', 'rosemary_woocommerce_output_related_products_args' );
	function rosemary_woocommerce_output_related_products_args($args) {
		$ppp = $ccc = 0;
		if (rosemary_param_is_on(rosemary_get_custom_option('show_post_related'))) {
			$ccc_add = in_array(rosemary_get_custom_option('body_style'), array('fullwide', 'fullscreen')) ? 1 : 0;
			$ccc =  rosemary_get_custom_option('post_related_columns');
			$ccc = $ccc > 0 ? $ccc : (rosemary_param_is_off(rosemary_get_custom_option('show_sidebar_main')) ? 3+$ccc_add : 2+$ccc_add);
			$ppp = rosemary_get_custom_option('post_related_count');
			$ppp = $ppp > 0 ? $ppp : $ccc;
		}
		$args['posts_per_page'] = $ppp;
		$args['columns'] = $ccc;
		return $args;
	}
}

// Number columns for product thumbnails
if ( !function_exists( 'rosemary_woocommerce_product_thumbnails_columns' ) ) {
	//add_filter( 'woocommerce_product_thumbnails_columns', 'rosemary_woocommerce_product_thumbnails_columns' );
	function rosemary_woocommerce_product_thumbnails_columns($cols) {
		return 5;
	}
}

// Add column class into product item in shop streampage
if ( !function_exists( 'rosemary_woocommerce_loop_shop_columns_class' ) ) {
	//add_filter( 'post_class', 'rosemary_woocommerce_loop_shop_columns_class' );
	function rosemary_woocommerce_loop_shop_columns_class($class) {
		global $woocommerce_loop;
		if (is_product()) {
			if (!empty($woocommerce_loop['columns']))
			$class[] = ' column-1_'.esc_attr($woocommerce_loop['columns']);
		} else if (!is_product() && !is_cart() && !is_checkout() && !is_account_page()) {
			$ccc_add = in_array(rosemary_get_custom_option('body_style'), array('fullwide', 'fullscreen')) ? 1 : 0;
			$ccc =  rosemary_get_custom_option('shop_loop_columns');
			$ccc = $ccc > 0 ? $ccc : (rosemary_param_is_off(rosemary_get_custom_option('show_sidebar_main')) ? 3+$ccc_add : 2+$ccc_add);
			$class[] = ' column-1_'.esc_attr($ccc);
		}
		return $class;
	}
}

// Number columns for shop streampage
if ( !function_exists( 'rosemary_woocommerce_loop_shop_columns' ) ) {
	//add_filter( 'loop_shop_columns', 'rosemary_woocommerce_loop_shop_columns' );
	function rosemary_woocommerce_loop_shop_columns($cols) {
		$ccc_add = in_array(rosemary_get_custom_option('body_style'), array('fullwide', 'fullscreen')) ? 1 : 0;
		$ccc =  rosemary_get_custom_option('shop_loop_columns');
		$ccc = $ccc > 0 ? $ccc : (rosemary_param_is_off(rosemary_get_custom_option('show_sidebar_main')) ? 3+$ccc_add : 2+$ccc_add);
		return $ccc;
	}
}

// Search form
if ( !function_exists( 'rosemary_woocommerce_get_product_search_form' ) ) {
	//add_filter( 'get_product_search_form', 'rosemary_woocommerce_get_product_search_form' );
	function rosemary_woocommerce_get_product_search_form($form) {
		return '
		<form role="search" method="get" class="search_form" action="' . esc_url( home_url( '/'  ) ) . '">
			<input type="text" class="search_field" placeholder="' . esc_attr__('Search for products &hellip;', 'rosemary') . '" value="' . get_search_query() . '" name="s" title="' . esc_attr__('Search for products:', 'rosemary') . '" /><button class="search_button icon-search" type="submit"></button>
			<input type="hidden" name="post_type" value="product" />
		</form>
		';
	}
}

// Wrap product title into link
if ( !function_exists( 'rosemary_woocommerce_the_title' ) ) {
	//add_filter( 'the_title', 'rosemary_woocommerce_the_title' );
	function rosemary_woocommerce_the_title($title) {
		if (rosemary_get_global('in_product_item') && get_post_type()=='product') {
			$title = '<a href="'.get_permalink().'">'.($title).'</a>';
		}
		return $title;
	}
}

// Show pagination links
if ( !function_exists( 'rosemary_woocommerce_pagination' ) ) {
	//add_filter( 'woocommerce_after_shop_loop', 'rosemary_woocommerce_pagination', 10 );
	function rosemary_woocommerce_pagination() {
		$style = rosemary_get_custom_option('blog_pagination');
		rosemary_show_pagination(array(
			'class' => 'pagination_wrap pagination_' . esc_attr($style),
			'style' => $style,
			'button_class' => '',
			'first_text'=> '',
			'last_text' => '',
			'prev_text' => '',
			'next_text' => '',
			'pages_in_group' => $style=='pages' ? 10 : 20
			)
		);
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check WooC in the required plugins
if ( !function_exists( 'rosemary_woocommerce_importer_required_plugins' ) ) {
	//add_filter( 'rosemary_filter_importer_required_plugins',	'rosemary_woocommerce_importer_required_plugins', 10, 2 );
	function rosemary_woocommerce_importer_required_plugins($not_installed='', $importer=null) {
		if ($importer && in_array('woocommerce', $importer->options['required_plugins']) && !rosemary_exists_woocommerce() )
			$not_installed .= '<br>WooCommerce';
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'rosemary_woocommerce_importer_set_options' ) ) {
	//add_filter( 'rosemary_filter_importer_options',	'rosemary_woocommerce_importer_set_options' );
	function rosemary_woocommerce_importer_set_options($options=array()) {
		if (is_array($options)) {
			$options['additional_options'][] = 'shop_%';		// Add slugs to export options for this plugin
			$options['additional_options'][] = 'woocommerce_%';
		}
		return $options;
	}
}

// Setup WooC pages after import posts complete
if ( !function_exists( 'rosemary_woocommerce_importer_after_import_posts' ) ) {
	//add_action( 'rosemary_action_importer_after_import_posts',	'rosemary_woocommerce_importer_after_import_posts', 10, 1 );
	function rosemary_woocommerce_importer_after_import_posts($importer) {
		$wooc_pages = array(						// Options slugs and pages titles for WooCommerce pages
			'woocommerce_shop_page_id' 				=> 'Shop',
			'woocommerce_cart_page_id' 				=> 'Cart',
			'woocommerce_checkout_page_id' 			=> 'Checkout',
			'woocommerce_pay_page_id' 				=> 'Checkout &#8594; Pay',
			'woocommerce_thanks_page_id' 			=> 'Order Received',
			'woocommerce_myaccount_page_id' 		=> 'My Account',
			'woocommerce_edit_address_page_id'		=> 'Edit My Address',
			'woocommerce_view_order_page_id'		=> 'View Order',
			'woocommerce_change_password_page_id'	=> 'Change Password',
			'woocommerce_logout_page_id'			=> 'Logout',
			'woocommerce_lost_password_page_id'		=> 'Lost Password'
		);
		foreach ($wooc_pages as $woo_page_name => $woo_page_title) {
			$woopage = get_page_by_title( $woo_page_title );
			if ($woopage->ID) {
				update_option($woo_page_name, $woopage->ID);
			}
		}
		// We no longer need to install pages
		delete_option( '_wc_needs_pages' );
		delete_transient( '_wc_activation_redirect' );
	}
}
?>