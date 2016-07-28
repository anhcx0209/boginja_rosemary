<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('rosemary_sc_woocommerce_theme_setup')) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_sc_woocommerce_theme_setup' );
	function rosemary_sc_woocommerce_theme_setup() {
		add_action('rosemary_action_shortcodes_list', 		'rosemary_sc_woocommerce_reg_shortcodes');
		add_action('rosemary_action_shortcodes_list_vc',	'rosemary_sc_woocommerce_reg_shortcodes_vc');
	}
}



/* Add shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_woocommerce_reg_shortcodes' ) ) {
	//add_action('rosemary_action_shortcodes_list', 'rosemary_sc_woocommerce_reg_shortcodes');
	function rosemary_sc_woocommerce_reg_shortcodes() {
		global $ROSEMARY_GLOBALS;
	
		// Woocommerce Shortcodes list
		//------------------------------------------------------------------
		if (rosemary_exists_woocommerce()) {
			
			// WooCommerce - Cart
			$ROSEMARY_GLOBALS['shortcodes']["woocommerce_cart"] = array(
				"title" => esc_html__("Woocommerce: Cart", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: show Cart page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array()
			);
			
			// WooCommerce - Checkout
			$ROSEMARY_GLOBALS['shortcodes']["woocommerce_checkout"] = array(
				"title" => esc_html__("Woocommerce: Checkout", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: show Checkout page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array()
			);
			
			// WooCommerce - My Account
			$ROSEMARY_GLOBALS['shortcodes']["woocommerce_my_account"] = array(
				"title" => esc_html__("Woocommerce: My Account", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: show My Account page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array()
			);
			
			// WooCommerce - Order Tracking
			$ROSEMARY_GLOBALS['shortcodes']["woocommerce_order_tracking"] = array(
				"title" => esc_html__("Woocommerce: Order Tracking", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: show Order Tracking page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array()
			);
			
			// WooCommerce - Shop Messages
			$ROSEMARY_GLOBALS['shortcodes']["shop_messages"] = array(
				"title" => esc_html__("Woocommerce: Shop Messages", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: show shop messages", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array()
			);
			
			// WooCommerce - Product Page
			$ROSEMARY_GLOBALS['shortcodes']["product_page"] = array(
				"title" => esc_html__("Woocommerce: Product Page", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: display single product page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"sku" => array(
						"title" => esc_html__("SKU", "rosemary"),
						"desc" => wp_kses( __("SKU code of displayed product", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"id" => array(
						"title" => esc_html__("ID", "rosemary"),
						"desc" => wp_kses( __("ID of displayed product", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"posts_per_page" => array(
						"title" => esc_html__("Number", "rosemary"),
						"desc" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "1",
						"min" => 1,
						"type" => "spinner"
					),
					"post_type" => array(
						"title" => esc_html__("Post type", "rosemary"),
						"desc" => wp_kses( __("Post type for the WP query (leave 'product')", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "product",
						"type" => "text"
					),
					"post_status" => array(
						"title" => esc_html__("Post status", "rosemary"),
						"desc" => wp_kses( __("Display posts only with this status", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "publish",
						"type" => "select",
						"options" => array(
							"publish" => esc_html__('Publish', 'rosemary'),
							"protected" => esc_html__('Protected', 'rosemary'),
							"private" => esc_html__('Private', 'rosemary'),
							"pending" => esc_html__('Pending', 'rosemary'),
							"draft" => esc_html__('Draft', 'rosemary')
						)
					)
				)
			);
			
			// WooCommerce - Product
			$ROSEMARY_GLOBALS['shortcodes']["product"] = array(
				"title" => esc_html__("Woocommerce: Product", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: display one product", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"sku" => array(
						"title" => esc_html__("SKU", "rosemary"),
						"desc" => wp_kses( __("SKU code of displayed product", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"id" => array(
						"title" => esc_html__("ID", "rosemary"),
						"desc" => wp_kses( __("ID of displayed product", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					)
				)
			);
			
			// WooCommerce - Best Selling Products
			$ROSEMARY_GLOBALS['shortcodes']["best_selling_products"] = array(
				"title" => esc_html__("Woocommerce: Best Selling Products", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: show best selling products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"per_page" => array(
						"title" => esc_html__("Number", "rosemary"),
						"desc" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 1,
						"type" => "spinner"
					),
					"columns" => array(
						"title" => esc_html__("Columns", "rosemary"),
						"desc" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 2,
						"max" => 4,
						"type" => "spinner"
					)
				)
			);
			
			// WooCommerce - Recent Products
			$ROSEMARY_GLOBALS['shortcodes']["recent_products"] = array(
				"title" => esc_html__("Woocommerce: Recent Products", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: show recent products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"per_page" => array(
						"title" => esc_html__("Number", "rosemary"),
						"desc" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 1,
						"type" => "spinner"
					),
					"columns" => array(
						"title" => esc_html__("Columns", "rosemary"),
						"desc" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 2,
						"max" => 4,
						"type" => "spinner"
					),
					"orderby" => array(
						"title" => esc_html__("Order by", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "date",
						"type" => "select",
						"options" => array(
							"date" => esc_html__('Date', 'rosemary'),
							"title" => esc_html__('Title', 'rosemary')
						)
					),
					"order" => array(
						"title" => esc_html__("Order", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "desc",
						"type" => "switch",
						"size" => "big",
						"options" => $ROSEMARY_GLOBALS['sc_params']['ordering']
					)
				)
			);
			
			// WooCommerce - Related Products
			$ROSEMARY_GLOBALS['shortcodes']["related_products"] = array(
				"title" => esc_html__("Woocommerce: Related Products", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: show related products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"posts_per_page" => array(
						"title" => esc_html__("Number", "rosemary"),
						"desc" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 1,
						"type" => "spinner"
					),
					"columns" => array(
						"title" => esc_html__("Columns", "rosemary"),
						"desc" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 2,
						"max" => 4,
						"type" => "spinner"
					),
					"orderby" => array(
						"title" => esc_html__("Order by", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "date",
						"type" => "select",
						"options" => array(
							"date" => esc_html__('Date', 'rosemary'),
							"title" => esc_html__('Title', 'rosemary')
						)
					)
				)
			);
			
			// WooCommerce - Featured Products
			$ROSEMARY_GLOBALS['shortcodes']["featured_products"] = array(
				"title" => esc_html__("Woocommerce: Featured Products", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: show featured products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"per_page" => array(
						"title" => esc_html__("Number", "rosemary"),
						"desc" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 1,
						"type" => "spinner"
					),
					"columns" => array(
						"title" => esc_html__("Columns", "rosemary"),
						"desc" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 2,
						"max" => 4,
						"type" => "spinner"
					),
					"orderby" => array(
						"title" => esc_html__("Order by", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "date",
						"type" => "select",
						"options" => array(
							"date" => esc_html__('Date', 'rosemary'),
							"title" => esc_html__('Title', 'rosemary')
						)
					),
					"order" => array(
						"title" => esc_html__("Order", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "desc",
						"type" => "switch",
						"size" => "big",
						"options" => $ROSEMARY_GLOBALS['sc_params']['ordering']
					)
				)
			);
			
			// WooCommerce - Top Rated Products
			$ROSEMARY_GLOBALS['shortcodes']["featured_products"] = array(
				"title" => esc_html__("Woocommerce: Top Rated Products", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: show top rated products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"per_page" => array(
						"title" => esc_html__("Number", "rosemary"),
						"desc" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 1,
						"type" => "spinner"
					),
					"columns" => array(
						"title" => esc_html__("Columns", "rosemary"),
						"desc" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 2,
						"max" => 4,
						"type" => "spinner"
					),
					"orderby" => array(
						"title" => esc_html__("Order by", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "date",
						"type" => "select",
						"options" => array(
							"date" => esc_html__('Date', 'rosemary'),
							"title" => esc_html__('Title', 'rosemary')
						)
					),
					"order" => array(
						"title" => esc_html__("Order", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "desc",
						"type" => "switch",
						"size" => "big",
						"options" => $ROSEMARY_GLOBALS['sc_params']['ordering']
					)
				)
			);
			
			// WooCommerce - Sale Products
			$ROSEMARY_GLOBALS['shortcodes']["featured_products"] = array(
				"title" => esc_html__("Woocommerce: Sale Products", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: list products on sale", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"per_page" => array(
						"title" => esc_html__("Number", "rosemary"),
						"desc" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 1,
						"type" => "spinner"
					),
					"columns" => array(
						"title" => esc_html__("Columns", "rosemary"),
						"desc" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 2,
						"max" => 4,
						"type" => "spinner"
					),
					"orderby" => array(
						"title" => esc_html__("Order by", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "date",
						"type" => "select",
						"options" => array(
							"date" => esc_html__('Date', 'rosemary'),
							"title" => esc_html__('Title', 'rosemary')
						)
					),
					"order" => array(
						"title" => esc_html__("Order", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "desc",
						"type" => "switch",
						"size" => "big",
						"options" => $ROSEMARY_GLOBALS['sc_params']['ordering']
					)
				)
			);
			
			// WooCommerce - Product Category
			$ROSEMARY_GLOBALS['shortcodes']["product_category"] = array(
				"title" => esc_html__("Woocommerce: Products from category", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: list products in specified category(-ies)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"per_page" => array(
						"title" => esc_html__("Number", "rosemary"),
						"desc" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 1,
						"type" => "spinner"
					),
					"columns" => array(
						"title" => esc_html__("Columns", "rosemary"),
						"desc" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 2,
						"max" => 4,
						"type" => "spinner"
					),
					"orderby" => array(
						"title" => esc_html__("Order by", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "date",
						"type" => "select",
						"options" => array(
							"date" => esc_html__('Date', 'rosemary'),
							"title" => esc_html__('Title', 'rosemary')
						)
					),
					"order" => array(
						"title" => esc_html__("Order", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "desc",
						"type" => "switch",
						"size" => "big",
						"options" => $ROSEMARY_GLOBALS['sc_params']['ordering']
					),
					"category" => array(
						"title" => esc_html__("Categories", "rosemary"),
						"desc" => wp_kses( __("Comma separated category slugs", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => '',
						"type" => "text"
					),
					"operator" => array(
						"title" => esc_html__("Operator", "rosemary"),
						"desc" => wp_kses( __("Categories operator", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "IN",
						"type" => "checklist",
						"size" => "medium",
						"options" => array(
							"IN" => esc_html__('IN', 'rosemary'),
							"NOT IN" => esc_html__('NOT IN', 'rosemary'),
							"AND" => esc_html__('AND', 'rosemary')
						)
					)
				)
			);
			
			// WooCommerce - Products
			$ROSEMARY_GLOBALS['shortcodes']["products"] = array(
				"title" => esc_html__("Woocommerce: Products", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: list all products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"skus" => array(
						"title" => esc_html__("SKUs", "rosemary"),
						"desc" => wp_kses( __("Comma separated SKU codes of products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"ids" => array(
						"title" => esc_html__("IDs", "rosemary"),
						"desc" => wp_kses( __("Comma separated ID of products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"columns" => array(
						"title" => esc_html__("Columns", "rosemary"),
						"desc" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 2,
						"max" => 4,
						"type" => "spinner"
					),
					"orderby" => array(
						"title" => esc_html__("Order by", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "date",
						"type" => "select",
						"options" => array(
							"date" => esc_html__('Date', 'rosemary'),
							"title" => esc_html__('Title', 'rosemary')
						)
					),
					"order" => array(
						"title" => esc_html__("Order", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "desc",
						"type" => "switch",
						"size" => "big",
						"options" => $ROSEMARY_GLOBALS['sc_params']['ordering']
					)
				)
			);
			
			// WooCommerce - Product attribute
			$ROSEMARY_GLOBALS['shortcodes']["product_attribute"] = array(
				"title" => esc_html__("Woocommerce: Products by Attribute", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: show products with specified attribute", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"per_page" => array(
						"title" => esc_html__("Number", "rosemary"),
						"desc" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 1,
						"type" => "spinner"
					),
					"columns" => array(
						"title" => esc_html__("Columns", "rosemary"),
						"desc" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 2,
						"max" => 4,
						"type" => "spinner"
					),
					"orderby" => array(
						"title" => esc_html__("Order by", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "date",
						"type" => "select",
						"options" => array(
							"date" => esc_html__('Date', 'rosemary'),
							"title" => esc_html__('Title', 'rosemary')
						)
					),
					"order" => array(
						"title" => esc_html__("Order", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "desc",
						"type" => "switch",
						"size" => "big",
						"options" => $ROSEMARY_GLOBALS['sc_params']['ordering']
					),
					"attribute" => array(
						"title" => esc_html__("Attribute", "rosemary"),
						"desc" => wp_kses( __("Attribute name", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"filter" => array(
						"title" => esc_html__("Filter", "rosemary"),
						"desc" => wp_kses( __("Attribute value", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					)
				)
			);
			
			// WooCommerce - Products Categories
			$ROSEMARY_GLOBALS['shortcodes']["product_categories"] = array(
				"title" => esc_html__("Woocommerce: Product Categories", "rosemary"),
				"desc" => wp_kses( __("WooCommerce shortcode: show categories with products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"number" => array(
						"title" => esc_html__("Number", "rosemary"),
						"desc" => wp_kses( __("How many categories showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 1,
						"type" => "spinner"
					),
					"columns" => array(
						"title" => esc_html__("Columns", "rosemary"),
						"desc" => wp_kses( __("How many columns per row use for categories output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => 4,
						"min" => 2,
						"max" => 4,
						"type" => "spinner"
					),
					"orderby" => array(
						"title" => esc_html__("Order by", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "date",
						"type" => "select",
						"options" => array(
							"date" => esc_html__('Date', 'rosemary'),
							"title" => esc_html__('Title', 'rosemary')
						)
					),
					"order" => array(
						"title" => esc_html__("Order", "rosemary"),
						"desc" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "desc",
						"type" => "switch",
						"size" => "big",
						"options" => $ROSEMARY_GLOBALS['sc_params']['ordering']
					),
					"parent" => array(
						"title" => esc_html__("Parent", "rosemary"),
						"desc" => wp_kses( __("Parent category slug", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"ids" => array(
						"title" => esc_html__("IDs", "rosemary"),
						"desc" => wp_kses( __("Comma separated ID of products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "",
						"type" => "text"
					),
					"hide_empty" => array(
						"title" => esc_html__("Hide empty", "rosemary"),
						"desc" => wp_kses( __("Hide empty categories", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"value" => "yes",
						"type" => "switch",
						"options" => $ROSEMARY_GLOBALS['sc_params']['yes_no']
					)
				)
			);
		}
	}
}


/* Add shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'rosemary_sc_woocommerce_reg_shortcodes_vc' ) ) {
	//add_action('rosemary_action_shortcodes_list_vc', 'rosemary_sc_woocommerce_reg_shortcodes_vc');
	function rosemary_sc_woocommerce_reg_shortcodes_vc() {
		global $ROSEMARY_GLOBALS;
	
		if (false && rosemary_exists_woocommerce()) {
		
			// WooCommerce - Cart
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "woocommerce_cart",
				"name" => esc_html__("Cart", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: show cart page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_wooc_cart',
				"class" => "trx_sc_alone trx_sc_woocommerce_cart",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", "rosemary"),
						"description" => wp_kses( __("Dummy data - not used in shortcodes", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Woocommerce_Cart extends ROSEMARY_VC_ShortCodeAlone {}
		
		
			// WooCommerce - Checkout
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "woocommerce_checkout",
				"name" => esc_html__("Checkout", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: show checkout page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_wooc_checkout',
				"class" => "trx_sc_alone trx_sc_woocommerce_checkout",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", "rosemary"),
						"description" => wp_kses( __("Dummy data - not used in shortcodes", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Woocommerce_Checkout extends ROSEMARY_VC_ShortCodeAlone {}
		
		
			// WooCommerce - My Account
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "woocommerce_my_account",
				"name" => esc_html__("My Account", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: show my account page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_wooc_my_account',
				"class" => "trx_sc_alone trx_sc_woocommerce_my_account",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", "rosemary"),
						"description" => wp_kses( __("Dummy data - not used in shortcodes", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Woocommerce_My_Account extends ROSEMARY_VC_ShortCodeAlone {}
		
		
			// WooCommerce - Order Tracking
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "woocommerce_order_tracking",
				"name" => esc_html__("Order Tracking", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: show order tracking page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_wooc_order_tracking',
				"class" => "trx_sc_alone trx_sc_woocommerce_order_tracking",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", "rosemary"),
						"description" => wp_kses( __("Dummy data - not used in shortcodes", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Woocommerce_Order_Tracking extends ROSEMARY_VC_ShortCodeAlone {}
		
		
			// WooCommerce - Shop Messages
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "shop_messages",
				"name" => esc_html__("Shop Messages", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: show shop messages", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_wooc_shop_messages',
				"class" => "trx_sc_alone trx_sc_shop_messages",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", "rosemary"),
						"description" => wp_kses( __("Dummy data - not used in shortcodes", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Shop_Messages extends ROSEMARY_VC_ShortCodeAlone {}
		
		
			// WooCommerce - Product Page
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "product_page",
				"name" => esc_html__("Product Page", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: display single product page", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_product_page',
				"class" => "trx_sc_single trx_sc_product_page",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "sku",
						"heading" => esc_html__("SKU", "rosemary"),
						"description" => wp_kses( __("SKU code of displayed product", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "id",
						"heading" => esc_html__("ID", "rosemary"),
						"description" => wp_kses( __("ID of displayed product", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "posts_per_page",
						"heading" => esc_html__("Number", "rosemary"),
						"description" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "post_type",
						"heading" => esc_html__("Post type", "rosemary"),
						"description" => wp_kses( __("Post type for the WP query (leave 'product')", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "product",
						"type" => "textfield"
					),
					array(
						"param_name" => "post_status",
						"heading" => esc_html__("Post status", "rosemary"),
						"description" => wp_kses( __("Display posts only with this status", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => array(
							esc_html__('Publish', 'rosemary') => 'publish',
							esc_html__('Protected', 'rosemary') => 'protected',
							esc_html__('Private', 'rosemary') => 'private',
							esc_html__('Pending', 'rosemary') => 'pending',
							esc_html__('Draft', 'rosemary') => 'draft'
						),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Product_Page extends ROSEMARY_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Product
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "product",
				"name" => esc_html__("Product", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: display one product", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_product',
				"class" => "trx_sc_single trx_sc_product",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "sku",
						"heading" => esc_html__("SKU", "rosemary"),
						"description" => wp_kses( __("Product's SKU code", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "id",
						"heading" => esc_html__("ID", "rosemary"),
						"description" => wp_kses( __("Product's ID", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Product extends ROSEMARY_VC_ShortCodeSingle {}
		
		
			// WooCommerce - Best Selling Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "best_selling_products",
				"name" => esc_html__("Best Selling Products", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: show best selling products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_best_selling_products',
				"class" => "trx_sc_single trx_sc_best_selling_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", "rosemary"),
						"description" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "rosemary"),
						"description" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Best_Selling_Products extends ROSEMARY_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Recent Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "recent_products",
				"name" => esc_html__("Recent Products", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: show recent products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_recent_products',
				"class" => "trx_sc_single trx_sc_recent_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", "rosemary"),
						"description" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "rosemary"),
						"description" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'rosemary') => 'date',
							esc_html__('Title', 'rosemary') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Recent_Products extends ROSEMARY_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Related Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "related_products",
				"name" => esc_html__("Related Products", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: show related products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_related_products',
				"class" => "trx_sc_single trx_sc_related_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "posts_per_page",
						"heading" => esc_html__("Number", "rosemary"),
						"description" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "rosemary"),
						"description" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'rosemary') => 'date',
							esc_html__('Title', 'rosemary') => 'title'
						),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Related_Products extends ROSEMARY_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Featured Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "featured_products",
				"name" => esc_html__("Featured Products", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: show featured products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_featured_products',
				"class" => "trx_sc_single trx_sc_featured_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", "rosemary"),
						"description" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "rosemary"),
						"description" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'rosemary') => 'date',
							esc_html__('Title', 'rosemary') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Featured_Products extends ROSEMARY_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Top Rated Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "top_rated_products",
				"name" => esc_html__("Top Rated Products", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: show top rated products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_top_rated_products',
				"class" => "trx_sc_single trx_sc_top_rated_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", "rosemary"),
						"description" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "rosemary"),
						"description" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'rosemary') => 'date',
							esc_html__('Title', 'rosemary') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Top_Rated_Products extends ROSEMARY_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Sale Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "sale_products",
				"name" => esc_html__("Sale Products", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: list products on sale", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_sale_products',
				"class" => "trx_sc_single trx_sc_sale_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", "rosemary"),
						"description" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "rosemary"),
						"description" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'rosemary') => 'date',
							esc_html__('Title', 'rosemary') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Sale_Products extends ROSEMARY_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Product Category
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "product_category",
				"name" => esc_html__("Products from category", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: list products in specified category(-ies)", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_product_category',
				"class" => "trx_sc_single trx_sc_product_category",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", "rosemary"),
						"description" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "rosemary"),
						"description" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'rosemary') => 'date',
							esc_html__('Title', 'rosemary') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "category",
						"heading" => esc_html__("Categories", "rosemary"),
						"description" => wp_kses( __("Comma separated category slugs", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "operator",
						"heading" => esc_html__("Operator", "rosemary"),
						"description" => wp_kses( __("Categories operator", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('IN', 'rosemary') => 'IN',
							esc_html__('NOT IN', 'rosemary') => 'NOT IN',
							esc_html__('AND', 'rosemary') => 'AND'
						),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Product_Category extends ROSEMARY_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Products
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "products",
				"name" => esc_html__("Products", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: list all products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_products',
				"class" => "trx_sc_single trx_sc_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "skus",
						"heading" => esc_html__("SKUs", "rosemary"),
						"description" => wp_kses( __("Comma separated SKU codes of products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("IDs", "rosemary"),
						"description" => wp_kses( __("Comma separated ID of products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "rosemary"),
						"description" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'rosemary') => 'date',
							esc_html__('Title', 'rosemary') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Products extends ROSEMARY_VC_ShortCodeSingle {}
		
		
		
		
			// WooCommerce - Product Attribute
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "product_attribute",
				"name" => esc_html__("Products by Attribute", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: show products with specified attribute", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_product_attribute',
				"class" => "trx_sc_single trx_sc_product_attribute",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", "rosemary"),
						"description" => wp_kses( __("How many products showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "rosemary"),
						"description" => wp_kses( __("How many columns per row use for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'rosemary') => 'date',
							esc_html__('Title', 'rosemary') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "attribute",
						"heading" => esc_html__("Attribute", "rosemary"),
						"description" => wp_kses( __("Attribute name", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "filter",
						"heading" => esc_html__("Filter", "rosemary"),
						"description" => wp_kses( __("Attribute value", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Product_Attribute extends ROSEMARY_VC_ShortCodeSingle {}
		
		
		
			// WooCommerce - Products Categories
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "product_categories",
				"name" => esc_html__("Product Categories", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: show categories with products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_product_categories',
				"class" => "trx_sc_single trx_sc_product_categories",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "number",
						"heading" => esc_html__("Number", "rosemary"),
						"description" => wp_kses( __("How many categories showed", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "rosemary"),
						"description" => wp_kses( __("How many columns per row use for categories output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'rosemary') => 'date',
							esc_html__('Title', 'rosemary') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", "rosemary"),
						"description" => wp_kses( __("Sorting order for products output", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($ROSEMARY_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "parent",
						"heading" => esc_html__("Parent", "rosemary"),
						"description" => wp_kses( __("Parent category slug", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "date",
						"type" => "textfield"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("IDs", "rosemary"),
						"description" => wp_kses( __("Comma separated ID of products", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "hide_empty",
						"heading" => esc_html__("Hide empty", "rosemary"),
						"description" => wp_kses( __("Hide empty categories", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => array("Hide empty" => "1" ),
						"type" => "checkbox"
					)
				)
			) );
			
			class WPBakeryShortCode_Products_Categories extends ROSEMARY_VC_ShortCodeSingle {}
		
			/*
		
			// WooCommerce - Add to cart
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "add_to_cart",
				"name" => esc_html__("Add to cart", "rosemary"),
				"description" => wp_kses( __("WooCommerce shortcode: Display a single product price + cart button", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
				"category" => esc_html__('WooCommerce', 'js_composer'),
				'icon' => 'icon_trx_add_to_cart',
				"class" => "trx_sc_single trx_sc_add_to_cart",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "id",
						"heading" => esc_html__("ID", "rosemary"),
						"description" => wp_kses( __("Product's ID", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "sku",
						"heading" => esc_html__("SKU", "rosemary"),
						"description" => wp_kses( __("Product's SKU code", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "quantity",
						"heading" => esc_html__("Quantity", "rosemary"),
						"description" => wp_kses( __("How many item add", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "show_price",
						"heading" => esc_html__("Show price", "rosemary"),
						"description" => wp_kses( __("Show price near button", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => array("Show price" => "true" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "class",
						"heading" => esc_html__("Class", "rosemary"),
						"description" => wp_kses( __("CSS class", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "style",
						"heading" => esc_html__("CSS style", "rosemary"),
						"description" => wp_kses( __("CSS style for additional decoration", "rosemary"), $ROSEMARY_GLOBALS['allowed_tags'] ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );
			
			class WPBakeryShortCode_Add_To_Cart extends ROSEMARY_VC_ShortCodeSingle {}
			*/
		}
	}
}
?>