<?php
/**
 * The Sidebar containing the main widget areas.
 */

$sidebar_show   = rosemary_get_custom_option('show_sidebar_main');
$sidebar_scheme = rosemary_get_custom_option('sidebar_main_scheme');
$sidebar_name   = rosemary_get_custom_option('sidebar_main');

if (!rosemary_param_is_off($sidebar_show) && is_active_sidebar($sidebar_name)) {
	?>
	<div class="sidebar widget_area scheme_<?php echo esc_attr($sidebar_scheme); ?>" role="complementary">
		<div class="sidebar_inner widget_area_inner">
			<?php
			ob_start();
			do_action( 'before_sidebar' );
			global $ROSEMARY_GLOBALS;
			if (!empty($ROSEMARY_GLOBALS['reviews_markup']))
				echo '<aside class="column-1_1 widget widget_reviews">' . ($ROSEMARY_GLOBALS['reviews_markup']) . '</aside>';
			$ROSEMARY_GLOBALS['current_sidebar'] = 'main';
			if ( !dynamic_sidebar($sidebar_name) ) {
				// Put here html if user no set widgets in sidebar
			}
			do_action( 'after_sidebar' );
			$out = ob_get_contents();
			ob_end_clean();
			echo trim(chop(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out)));
			?>
		</div>
	</div> <!-- /.sidebar -->
	<?php
}
?>