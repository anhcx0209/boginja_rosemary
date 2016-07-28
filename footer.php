<?php
/**
 * The template for displaying the footer.
 */

global $ROSEMARY_GLOBALS;

				rosemary_close_wrapper();	// <!-- </.content> -->

				// Show main sidebar
				get_sidebar();

				if (rosemary_get_custom_option('body_style')!='fullscreen') rosemary_close_wrapper();	// <!-- </.content_wrap> -->
				?>

			</div>		<!-- </.page_content_wrap> -->
			
			<?php
			// Footer Testimonials stream
			if (rosemary_get_custom_option('show_testimonials_in_footer')=='yes') {
				$count = max(1, rosemary_get_custom_option('testimonials_count'));
				$data = rosemary_sc_testimonials(array('count'=>$count));
				if ($data) {
					?>
					<footer class="testimonials_wrap sc_section scheme_<?php echo esc_attr(rosemary_get_custom_option('testimonials_scheme')); ?>">
						<div class="testimonials_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php echo ($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}
			
			
			// Footer Twitter stream
			if (rosemary_get_custom_option('show_twitter_in_footer')=='yes') {
				$count = max(1, rosemary_get_custom_option('twitter_count'));
				$data = rosemary_sc_twitter(array('count'=>$count));
				if ($data) {
					?>
					<footer class="twitter_wrap sc_section scheme_<?php echo esc_attr(rosemary_get_custom_option('twitter_scheme')); ?>">
						<div class="twitter_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php echo ($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}


			// Footer contacts
			if (rosemary_get_custom_option('show_contacts_in_footer')=='yes') {
				$contact_info = rosemary_get_custom_option('contact_info');
				$phone = rosemary_get_custom_option('contact_phone');
				$mail = rosemary_get_custom_option('contact_email');
				if (!empty($contact_info) || !empty($phone) || !empty($fax)) {
					?>
					<footer class="contacts_wrap scheme_<?php echo esc_attr(rosemary_get_custom_option('contacts_scheme')); ?>">
						<div class="contacts_wrap_inner">
							<div class="content_wrap">
								<div class="contacts_address">
									<div class="sc_columns columns_wrap">
									<address class="contact_item column-1_3">
										<span class="info_icon icon-phone-1"></span>
										<span class="info_text"><span class="label"><?php if (!empty($phone)) echo esc_html_e('Phone', 'rosemary') . '</span><br>' . esc_html($phone); ?></span>
									</address><address class="contact_item column-1_3">
										<span class="info_icon icon-location"></span>
										<span class="info_text"><span class="label"><?php if (!empty($contact_info)) echo esc_html_e('Address', 'rosemary')  . '</span><br>' . esc_html($contact_info); ?></span>
									</address><address class="contact_item column-1_3">
										<span class="info_icon icon-mail"></span>
										<span class="info_text"><span class="label"><?php if (!empty($mail)) echo esc_html_e('Email', 'rosemary')  . '</span><br>' .'<a href="mailto:'.esc_html($mail).'">'.esc_html($mail).'</a>'; ?></span>									
									</address>
									</div>
								</div>
							</div>	<!-- /.content_wrap -->
						</div>	<!-- /.contacts_wrap_inner -->
					</footer>	<!-- /.contacts_wrap -->
					<?php
				}
			}


			// Google map
			if ( rosemary_get_custom_option('show_googlemap')=='yes' ) {
				$map_address = rosemary_get_custom_option('googlemap_address');
				$map_latlng  = rosemary_get_custom_option('googlemap_latlng');
				$map_zoom    = rosemary_get_custom_option('googlemap_zoom');
				$map_style   = rosemary_get_custom_option('googlemap_style');
				$map_height  = rosemary_get_custom_option('googlemap_height');
				if (!empty($map_address) || !empty($map_latlng)) {
					$args = array();
					if (!empty($map_style))		$args['style'] = esc_attr($map_style);
					if (!empty($map_zoom))		$args['zoom'] = esc_attr($map_zoom);
					if (!empty($map_height))	$args['height'] = esc_attr($map_height);
					echo trim(rosemary_sc_googlemap($args));
				}
			}
// Footer sidebar
			$footer_show  = rosemary_get_custom_option('show_sidebar_footer');
			$sidebar_name = rosemary_get_custom_option('sidebar_footer');
			if (!rosemary_param_is_off($footer_show) && is_active_sidebar($sidebar_name)) {
				$ROSEMARY_GLOBALS['current_sidebar'] = 'footer';
				?>
				<footer class="footer_wrap widget_area scheme_<?php echo esc_attr(rosemary_get_custom_option('sidebar_footer_scheme')); ?>">
					<div class="footer_wrap_inner widget_area_inner">
						<div class="content_wrap">
							<div class="columns_wrap"><?php
								ob_start();
								do_action( 'before_sidebar' );
								if ( !dynamic_sidebar($sidebar_name) ) {
								// Put here html if user no set widgets in sidebar
								}
								do_action( 'after_sidebar' );
								$out = ob_get_contents();
								ob_end_clean();
								echo trim(chop(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out)));
								?></div>	<!-- /.columns_wrap -->
							</div>	<!-- /.content_wrap -->
						</div>	<!-- /.footer_wrap_inner -->
					</footer>	<!-- /.footer_wrap -->
					<?php
				}

		// Copyright area
			$copyright_style = rosemary_get_custom_option('show_copyright_in_footer');
			if (!rosemary_param_is_off($copyright_style)) {
			?> 
				<div class="copyright_wrap copyright_style_<?php echo esc_attr($copyright_style); ?>  scheme_<?php echo esc_attr(rosemary_get_custom_option('copyright_scheme')); ?>">
					<div class="copyright_wrap_inner">
						<div class="content_wrap">
							<?php
							if ($copyright_style == 'menu') {
								if (empty($ROSEMARY_GLOBALS['menu_footer']))	$ROSEMARY_GLOBALS['menu_footer'] = rosemary_get_nav_menu('menu_footer');
								if (!empty($ROSEMARY_GLOBALS['menu_footer']))	echo trim($ROSEMARY_GLOBALS['menu_footer']);
							} else if ($copyright_style == 'socials') {
								echo trim(rosemary_sc_socials(array('size'=>"tiny")));
							}
							?>
							<div class="copyright_text"><?php echo force_balance_tags(rosemary_get_custom_option('footer_copyright')); ?></div>
						</div>
					</div>
				</div>
			<?php } ?>



							</div>	<!-- /.page_wrap -->

						</div>		<!-- /.body_wrap -->

						<?php if ( !rosemary_param_is_off(rosemary_get_custom_option('show_sidebar_outer')) ) { ?>
					</div>	<!-- /.outer_wrap -->
					<?php } ?>

					<?php
					if (rosemary_get_custom_option('show_theme_customizer')=='yes') {
						require_once rosemary_get_file_dir('core/core.customizer/front.customizer.php');
					}
					?>

					<a href="#" class="scroll_to_top icon-up" title="<?php esc_attr_e('Scroll to top', 'rosemary'); ?>"></a>

					<div class="custom_html_section">
						<?php echo force_balance_tags(rosemary_get_custom_option('custom_code')); ?>
					</div>

					<?php echo force_balance_tags(rosemary_get_custom_option('gtm_code2')); ?>

					<?php wp_footer(); ?>

				</body>
				</html>