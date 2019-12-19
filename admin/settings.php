<?php

add_action( 'admin_menu', 'mm_cce_cookies_adminmenu', 11 );

function mm_cce_cookies_adminmenu() {
	global $_wp_last_object_menu;
	$_wp_last_object_menu++;
	
	// If Myyntimaatio Launcher plugin is not activated
	// Show Cookie menu under Settings tab
	if( !is_plugin_active( 'myyntimaatio-launcher/myyntimaatio-launcher.php' ) ) {
		add_options_page( __( 'Cookie Consent', 'mm-cookie-consent-europe' ), __( 'Cookie Consent', 'mm-cookie-consent-europe' ), 'administrator', 'mm_cce_cookies_options', 'mm_cce_cookies_options_seite', null, $_wp_last_object_menu );
	} 

	add_submenu_page( 'myyntimaatio-launcher', 'Cookie Consent', 'Cookie Consent', 'manage_options', 'mm_cce_cookies_options', 'mm_cce_cookies_options_seite', null );

	add_action( 'admin_init', 'mm_cce_cookies_plugin_options' );
}

function mm_cce_cookies_plugin_options() {
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_position' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_abstand' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_bgcolor' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_textcolor' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_text' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_buttonbgcolor' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_buttontextcolor' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_buttonbgcolor_hover' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_buttontextcolor_hover' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_buttontext' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_show_hyperlink_learnmore' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_learnmore_link' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_learnmore_text' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_sd' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_learnmore_text_color' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_learnmore_text_color_hover' );
	register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_ppbuttonbg' );
	if( function_exists( 'pll_e' ) ) {
		$translations = pll_languages_list( array('fields' => 'name' ) );
		for( $i = 0; $i < count( $translations ); $i++) {
			register_setting( 'mm_cce_cookies_settings_group1', 'mm_cce_pp_' . $translations[ $i ] );
		}
	}
}
	
function mm_cce_cookies_options_seite() {
	global $wpdb;
	if( !is_admin() ) {
		wp_die( __( 'No permissions' ) );
	}	
?>
	<style>
		fieldset {
			border: 1px solid #333;
			padding: 15px;
		}
		legend { font-weight: bold; }
		.wp-picker-container .iris-picker {
		    position: absolute;
		    z-index: 2;
		}

		.color-alpha {
			height:100% !important;
		}
	</style>
	<div class="wrap">
		<h1><?php _e( 'Cookie Consent', 'mm-cookie-consent-europe' ); ?></h1>
		<form method="post" action="options.php">
		<?php settings_fields( 'mm_cce_cookies_settings_group1' ); ?>
		<?php do_settings_sections( 'mm_cce_cookies_settings_group1' ); ?>
			<fieldset>
				<legend><?php _e( 'Cookie notice settings', 'mm-cookie-consent-europe' ); ?></legend>
				<p>
					<b><?php _e( 'Background color', 'mm-cookie-consent-europe' ); ?>:</b><br />
					<input type="text" class="colorpicker" data-alpha="true" name="mm_cce_bgcolor" value="<?php echo esc_attr( get_option( 'mm_cce_bgcolor', "#333333" ) ); ?>" />
				</p>
				<p>
					<b><?php _e( 'Text color', 'mm-cookie-consent-europe' ); ?>:</b><br />
					<input type="text" class="colorpicker" data-alpha="true" name="mm_cce_textcolor" value="<?php echo esc_attr( get_option( 'mm_cce_textcolor', "#ffffff" ) ); ?>" />
				</p>
                <?php
                    if( function_exists( 'pll_register_string' ) ) { ?>
                        <div class="notice notice-success"> 
                            <p><?php
                            $var = "<a href='/wp-admin/admin.php?page=mlang_strings'>Polylang Strings</a>";
                            echo sprintf( wp_kses( __( 'You are using Polylang, to configure the strings go to %s', 'mm-cookie-consent-europe' ), array(  'a' => array( 'href' => array() ) ) ), $var );
                            ?></p>
                        </div>
                        <?php
                    }
                    else {
                ?>
                    <p>
                        <b><?php _e( 'Text (no HTML)', 'mm-cookie-consent-europe' ) ?>:</b><br />
                        <textarea style="width: 500px; height: 100px;" name="mm_cce_text"><?php echo esc_attr( get_option( 'mm_cce_text', __( 'Verkkosivumme käyttää evästeitä saadaksesi parhaan käyttökokemuksen. Jatkaessasi sivuston käyttöä hyväksyt evästeet.', 'mm-cookie-consent-europe' ) ) ); ?></textarea>
                    </p>
                <?php } ?>
                <table>
                	<tr>
                		<td>
							<p>
								<b><?php _e( 'Button color', 'mm-cookie-consent-europe' ) ?>:</b><br />
								<input type="text" class="colorpicker" data-alpha="true" name="mm_cce_buttonbgcolor" value="<?php echo esc_attr( get_option( 'mm_cce_buttonbgcolor', "#000000" ) ); ?>" />
							</p>
							<p>
								<b><?php _e( 'Text color in button', 'mm-cookie-consent-europe' ) ?>:</b><br />
								<input type="text" class="colorpicker" data-alpha="true" name="mm_cce_buttontextcolor" value="<?php echo esc_attr( get_option( 'mm_cce_buttontextcolor', "#ffffff" ) ); ?>" />
			                </p>
			            </td>

                		<td style="padding-left:25px;">
							<p>
								<b><?php _e( 'Button hover color', 'mm-cookie-consent-europe' ) ?>:</b><br />
								<input type="text" class="colorpicker" data-alpha="true" name="mm_cce_buttonbgcolor_hover" value="<?php echo esc_attr( get_option( 'mm_cce_buttonbgcolor_hover', "#131313" ) ); ?>" />
							</p>
							<p>
								<b><?php _e( 'Text hover color in button', 'mm-cookie-consent-europe' ) ?>:</b><br />
								<input type="text" class="colorpicker" data-alpha="true" name="mm_cce_buttontextcolor_hover" value="<?php echo esc_attr( get_option( 'mm_cce_buttontextcolor_hover', "#ffffff" ) ); ?>" />
			                </p>
			            </td>
			        </tr>
			    </table>
                <?php
                if( !function_exists( 'pll_register_string' ) ) { ?>
                    <p>
                        <b><?php _e('Text in button', 'mm-cookie-consent-europe' ) ?>:</b><br />
                        <input type="text" name="mm_cce_buttontext" value="<?php echo esc_attr( get_option( 'mm_cce_buttontext', __( 'Selvä', 'mm-cookie-consent-europe' ) ) ); ?>" />
                    </p>
                <?php } ?>
                <hr />
				<p>
					<b><?php _e( 'Show hyperlink on <strong>Learn More</strong> link', 'mm-cookie-consent-europe' ) ?>:</b><br />
					<?php
						$mm_cce_position = esc_attr( get_option( 'mm_cce_show_hyperlink_learnmore' ) );
						if( 1 == $mm_cce_position ) $mm_cce_sd_selection1 = "selected";
						if( 2 == $mm_cce_position ) $mm_cce_sd_selection2 = "selected";
					?>
					<select name="mm_cce_show_hyperlink_learnmore">
						<option value="1" <?php echo $mm_cce_sd_selection1; ?>><?php _e( 'Yes', 'mm-cookie-consent-europe' ) ?></option>
						<option value="2" <?php echo $mm_cce_sd_selection2; ?>><?php _e( 'No', 'mm-cookie-consent-europe' ) ?></option>
					</select>
				</p>
				<p>
					<b><?php _e( 'Privacy policy page', 'mm-cookie-consent-europe' ) ?>:</b><br />
					<?php 
					if( !function_exists( 'pll_register_string' ) ) {
						$fhw_dropdown_args = array(
							'selected'	=> esc_attr( get_option( 'mm_cce_learnmore_link', 0 ) ),
							'name'		=> 'mm_cce_learnmore_link'
						);
						wp_dropdown_pages( $fhw_dropdown_args );
					} else {
						$translations = pll_languages_list( array('fields' => 'name' ) );
						for( $i = 0; $i < count( $translations ); $i++) {
							echo "<b>" . $translations[ $i ] . ":</b>";
							$fhw_dropdown_args = array(
								'selected'	=> esc_attr( get_option( 'mm_cce_pp_' . $translations[ $i ], 0 ) ),
								'name'		=> 'mm_cce_pp_' . $translations[ $i ]
							);
							wp_dropdown_pages( $fhw_dropdown_args );
							echo esc_attr( get_option( 'mm_cce_pp_' . $translations[ $i ] ) );
							echo "<br />";
						}
					}
					?>
				</p>
                <?php
                if( !function_exists( 'pll_register_string' ) ) { ?>
                    <p>
                    <b><?php _e( 'Text of <strong>Learn More</strong> hyperlink', 'mm-cookie-consent-europe' ) ?>:</b><br />
					<input type="text" name="mm_cce_learnmore_text" value="<?php echo esc_attr( get_option( 'mm_cce_learnmore_text', __('Lue lisää','mm-cookie-consent-europe')) ); ?>" />
                    </p>
                <?php } ?>
				<p>
					<b class="fhhyperlink"><?php _e( 'Color of <strong>Learn More</strong> hyperlink', 'mm-cookie-consent-europe' ) ?>:</b>
					<b class="fhbtn"><?php _e( 'Color of <strong>Learn More</strong> text in button', 'mm-cookie-consent-europe' ) ?>:</b><br />
					<input type="text" class="colorpicker" data-alpha="true" name="mm_cce_learnmore_text_color" value="<?php echo esc_attr( get_option( 'mm_cce_learnmore_text_color', '#ffffff' ) ); ?>" />
				</p>
				<p>
					<b class="fhhyperlink"><?php _e( 'Color of <strong>Learn More</strong> hyperlink', 'mm-cookie-consent-europe' ) ?>:</b>
					<b class="fhbtn"><?php _e( 'Color of <strong>Learn More</strong> text in button', 'mm-cookie-consent-europe' ) ?>:</b><br />
					<input type="text" class="colorpicker" data-alpha="true" name="mm_cce_learnmore_text_color_hover" value="<?php echo esc_attr( get_option( 'mm_cce_learnmore_text_color_hover', '#dadada' ) ); ?>" />
				</p>
			</fieldset>
			<?php submit_button(); ?>
		</form>
	</div>
<?php
}
    