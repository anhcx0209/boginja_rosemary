					<div class="logo">
						<a href="<?php echo esc_url(home_url('/')); ?>"><?php
							echo !empty($ROSEMARY_GLOBALS['logo'])
								? '<img src="'.esc_url($ROSEMARY_GLOBALS['logo']).'" class="logo_main" alt="">'
								: ''; 
							echo !empty($ROSEMARY_GLOBALS['logo_fixed'])
								? '<img src="'.esc_url($ROSEMARY_GLOBALS['logo_fixed']).'" class="logo_fixed" alt="">'
								: '';
							echo ($ROSEMARY_GLOBALS['logo_text']
								? '<div class="logo_text">'.($ROSEMARY_GLOBALS['logo_text']).'</div>'
								: '');
							echo ($ROSEMARY_GLOBALS['logo_slogan']
								? '<div class="logo_slogan">' . esc_html($ROSEMARY_GLOBALS['logo_slogan']) . '</div>'
								: '');
						?></a>
					</div>
