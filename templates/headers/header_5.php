<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'rosemary_template_header_5_theme_setup' ) ) {
	add_action( 'rosemary_action_before_init_theme', 'rosemary_template_header_5_theme_setup', 1 );
	function rosemary_template_header_5_theme_setup() {
		rosemary_add_template(array(
			'layout' => 'header_5',
			'mode'   => 'header',
			'title'  => esc_html__('Header 5', 'rosemary'),
			'icon'   => rosemary_get_file_url('templates/headers/images/5.jpg')
			));
	}
}


/*echo force_balance_tags($open_hours);*/

// Template output
if ( !function_exists( 'rosemary_template_header_5_output' ) ) {
	function rosemary_template_header_5_output($post_options, $post_data) {
		global $ROSEMARY_GLOBALS;
		$contact_phone=trim(rosemary_get_custom_option('contact_phone'));
		$contact_info=trim(rosemary_get_custom_option('contact_info'));
		$open_hours=trim(rosemary_get_custom_option('contact_open_hours'));

		// WP custom header
		$header_css = '';
		if ($post_options['position'] != 'over') {
			$header_image = get_header_image();
			$header_css = $header_image!='' 
			? ' style="background: url('.esc_url($header_image).') repeat center top"' 
			: '';
		}
		?>

		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_5 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_5 top_panel_position_<?php echo esc_attr(rosemary_get_custom_option('top_panel_position')); ?>">
				<?php if (rosemary_get_custom_option('show_top_panel_top')=='yes') { ?>
				<div class="top_panel_top">
					<div class="content_wrap clearfix">
						<?php
						$top_panel_top_components = array('contact_info', 'open_hours', 'login', 'currency', 'bookmarks', 'socials');
						require_once rosemary_get_file_dir('templates/headers/_parts/top-panel-top.php');
						?>
					</div>
				</div>
				<?php } ?>

				<div class="top_panel_middle top" <?php echo ($header_css); ?>>
					<div class="content_wrap">
						<div class="info_part_wrap">
							<div class="contact_info_wrap">
								<span class="info_icon icon-phone-1"></span>
								<span class="contact_phone">
								<?php echo esc_html__('Звоните: ','rosemary'). '<b>'.force_balance_tags($contact_phone).'</b>'; ?></span>
								<span class="open_hours"><?php echo force_balance_tags($open_hours); ?></span>
							</div>
							<div class="contact_logo">
								<?php require_once rosemary_get_file_dir('templates/headers/_parts/logo.php');?>
							</div>
							<div class="contact_address"><span class="info_icon  icon-location"></span>
								<?php echo force_balance_tags($contact_info); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="top_panel_middle bottom">
					<div class="content_wrap">
						<div class="menu_main_wrap clearfix">
							<a href="#" class="menu_main_responsive_button icon-menu"></a>
							<nav class="menu_main_nav_area">
								<?php
								if (empty($ROSEMARY_GLOBALS['menu_main'])) $ROSEMARY_GLOBALS['menu_main'] = rosemary_get_nav_menu('menu_main');
								if (empty($ROSEMARY_GLOBALS['menu_main'])) $ROSEMARY_GLOBALS['menu_main'] = rosemary_get_nav_menu();
								echo ($ROSEMARY_GLOBALS['menu_main']);
								?>
							</nav>
							<?php
							if (rosemary_get_custom_option('show_search')=='yes')
								echo trim(rosemary_sc_search(array('class'=>"top_panel_icon", 'state'=>"closed")));
							if (function_exists('rosemary_exists_woocommerce') && rosemary_exists_woocommerce() && (rosemary_is_woocommerce_page() && rosemary_get_custom_option('show_cart')=='shop' || rosemary_get_custom_option('show_cart')=='always') && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART'))) {
								?>
								<div class="menu_main_cart top_panel_icon">
									<?php require_once rosemary_get_file_dir('templates/headers/_parts/contact-info-cart.php'); ?>
								</div>
								<?php
							}
							?>
						</div>
						
						
					</div></div>
				</div>
			</header>

			<?php
		}
	}
	?>