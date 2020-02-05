<?php

add_action( 'admin_menu', 'mm_bcc_cookies_adminmenu', 11 );

function mm_bcc_cookies_adminmenu() {
	global $_wp_last_object_menu;
	$_wp_last_object_menu++;
	
	// If Myyntimaatio Launcher plugin is not activated
	// Show Cookie menu under Settings tab
	if( !is_plugin_active( 'myyntimaatio-launcher/myyntimaatio-launcher.php' ) ) {
		add_options_page( __( 'FB Cookie Consent', 'mm-facebook-cookie-consent' ), __( 'FB Cookie Consent', 'mm-facebook-cookie-consent' ), 'administrator', 'mm_bcc_cookies_options', 'mm_bcc_cookies_options_seite', null, $_wp_last_object_menu );
	} 

	add_submenu_page( 'myyntimaatio-launcher', 'FB Cookie Consent', 'FB Cookie Consent', 'manage_options', 'mm_bcc_cookies_options', 'mm_bcc_cookies_options_seite', null );

	add_action( 'admin_init', 'mm_bcc_cookies_plugin_options' );
}

function mm_bcc_cookies_plugin_options() {
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_position' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_abstand' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_bgcolor' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_textcolor' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_text' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_buttonbgcolor' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_buttontextcolor' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_buttonbgcolor_hover' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_buttontextcolor_hover' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_buttontext' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_buttontext_nessacary' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_show_hyperlink_learnmore' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_learnmore_link' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_learnmore_text' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_sd' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_learnmore_text_color' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_learnmore_text_color_hover' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_ppbuttonbg' );
	register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_fbpixelid' );
	if( function_exists( 'pll_e' ) ) {
		$translations = pll_languages_list( array('fields' => 'name' ) );
		for( $i = 0; $i < count( $translations ); $i++) {
			register_setting( 'mm_bcc_cookies_settings_group1', 'mm_bcc_pp_' . $translations[ $i ] );
		}
	}
}
	
function mm_bcc_cookies_options_seite() {
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
		<h1><?php _e( 'Facebook Cookie Consent', 'mm-facebook-cookie-consent' ); ?></h1>
		<form method="post" action="options.php">
		<?php settings_fields( 'mm_bcc_cookies_settings_group1' ); ?>
		<?php do_settings_sections( 'mm_bcc_cookies_settings_group1' ); ?>
			<fieldset>
				<legend><?php _e( 'Cookie notice settings', 'mm-facebook-cookie-consent' ); ?></legend>
				<p>
					<b><?php _e( 'Background color', 'mm-facebook-cookie-consent' ); ?>:</b><br />
					<input type="text" class="colorpicker" data-alpha="true" name="mm_bcc_bgcolor" value="<?php echo esc_attr( get_option( 'mm_bcc_bgcolor', "#e5e5e5" ) ); ?>" />
				</p>
				<p>
					<b><?php _e( 'Text color', 'mm-facebook-cookie-consent' ); ?>:</b><br />
					<input type="text" class="colorpicker" data-alpha="true" name="mm_bcc_textcolor" value="<?php echo esc_attr( get_option( 'mm_bcc_textcolor', "#353535" ) ); ?>" />
				</p>
                <?php
                    if( function_exists( 'pll_register_string' ) ) { ?>
                        <div class="notice notice-success"> 
                            <p><?php
                            $var = "<a href='/wp-admin/admin.php?page=mlang_strings'>Polylang Strings</a>";
                            echo sprintf( wp_kses( __( 'You are using Polylang, to configure the strings go to %s', 'mm-facebook-cookie-consent' ), array(  'a' => array( 'href' => array() ) ) ), $var );
                            ?></p>
                        </div>
                        <?php
                    }
                    else {
                ?>
                    <p>
                        <b><?php _e( 'Text (no HTML)', 'mm-facebook-cookie-consent' ) ?>:</b><br />
                        <textarea style="width: 500px; height: 100px;" name="mm_bcc_text"><?php echo esc_attr( get_option( 'mm_bcc_text', __( 'Verkkosivumme käyttää evästeitä saadaksesi parhaan käyttökokemuksen. Jatkaessasi sivuston käyttöä hyväksyt evästeet.', 'mm-facebook-cookie-consent' ) ) ); ?></textarea>
                    </p>
                <?php } ?>
                <table>
                	<tr>
                		<td>
							<p>
								<b><?php _e( 'Button color', 'mm-facebook-cookie-consent' ) ?>:</b><br />
								<input type="text" class="colorpicker" data-alpha="true" name="mm_bcc_buttonbgcolor" value="<?php echo esc_attr( get_option( 'mm_bcc_buttonbgcolor', "#27b7f4" ) ); ?>" />
							</p>
							<p>
								<b><?php _e( 'Text color in button', 'mm-facebook-cookie-consent' ) ?>:</b><br />
								<input type="text" class="colorpicker" data-alpha="true" name="mm_bcc_buttontextcolor" value="<?php echo esc_attr( get_option( 'mm_bcc_buttontextcolor', "#ffffff" ) ); ?>" />
			                </p>
			            </td>

                		<td style="padding-left:25px;">
							<p>
								<b><?php _e( 'Button hover color', 'mm-facebook-cookie-consent' ) ?>:</b><br />
								<input type="text" class="colorpicker" data-alpha="true" name="mm_bcc_buttonbgcolor_hover" value="<?php echo esc_attr( get_option( 'mm_bcc_buttonbgcolor_hover', "#24abe5" ) ); ?>" />
							</p>
							<p>
								<b><?php _e( 'Text hover color in button', 'mm-facebook-cookie-consent' ) ?>:</b><br />
								<input type="text" class="colorpicker" data-alpha="true" name="mm_bcc_buttontextcolor_hover" value="<?php echo esc_attr( get_option( 'mm_bcc_buttontextcolor_hover', "#ffffff" ) ); ?>" />
			                </p>
			            </td>
			        </tr>
			    </table>
                <?php
                if( !function_exists( 'pll_register_string' ) ) { ?>
                    <p>
                        <b><?php _e('Text in button', 'mm-facebook-cookie-consent' ) ?>:</b><br />
                        <input type="text" name="mm_bcc_buttontext" value="<?php echo esc_attr( get_option( 'mm_bcc_buttontext', __( 'Selvä', 'mm-facebook-cookie-consent' ) ) ); ?>" />
                    </p>
                    <p>
                        <b><?php _e('Text in button (nessacary cookies)', 'mm-facebook-cookie-consent' ) ?>:</b><br />
                        <input type="text" name="mm_bcc_buttontext_nessacary" value="<?php echo esc_attr( get_option( 'mm_bcc_buttontext_nessacary', __( 'Vain tarvittavat evästeet', 'mm-facebook-cookie-consent' ) ) ); ?>" />
                    </p>
                <?php } ?>
                <hr />
				<p>
					<b><?php _e( 'Show hyperlink on <strong>Learn More</strong> link', 'mm-facebook-cookie-consent' ) ?>:</b><br />
					<?php
						$mm_bcc_position = esc_attr( get_option( 'mm_bcc_show_hyperlink_learnmore' ) );
						if( 1 == $mm_bcc_position ) $mm_bcc_sd_selection1 = "selected";
						if( 2 == $mm_bcc_position ) $mm_bcc_sd_selection2 = "selected";
					?>
					<select name="mm_bcc_show_hyperlink_learnmore">
						<option value="1" <?php echo $mm_bcc_sd_selection1; ?>><?php _e( 'Yes', 'mm-facebook-cookie-consent' ) ?></option>
						<option value="2" <?php echo $mm_bcc_sd_selection2; ?>><?php _e( 'No', 'mm-facebook-cookie-consent' ) ?></option>
					</select>
				</p>
				<p>
					<b><?php _e( 'Privacy policy page', 'mm-facebook-cookie-consent' ) ?>:</b><br />
					<?php 
					if( !function_exists( 'pll_register_string' ) ) {
						$fhw_dropdown_args = array(
							'selected'	=> esc_attr( get_option( 'mm_bcc_learnmore_link', 0 ) ),
							'name'		=> 'mm_bcc_learnmore_link'
						);
						wp_dropdown_pages( $fhw_dropdown_args );
					} else {
						$translations = pll_languages_list( array('fields' => 'name' ) );
						for( $i = 0; $i < count( $translations ); $i++) {
							echo "<b>" . $translations[ $i ] . ":</b>";
							$fhw_dropdown_args = array(
								'selected'	=> esc_attr( get_option( 'mm_bcc_pp_' . $translations[ $i ], 0 ) ),
								'name'		=> 'mm_bcc_pp_' . $translations[ $i ]
							);
							wp_dropdown_pages( $fhw_dropdown_args );
							echo esc_attr( get_option( 'mm_bcc_pp_' . $translations[ $i ] ) );
							echo "<br />";
						}
					}
					?>
				</p>
                <?php
                if( !function_exists( 'pll_register_string' ) ) { ?>
                    <p>
                    <b><?php _e( 'Text of <strong>Learn More</strong> hyperlink', 'mm-facebook-cookie-consent' ) ?>:</b><br />
					<input type="text" name="mm_bcc_learnmore_text" value="<?php echo esc_attr( get_option( 'mm_bcc_learnmore_text', __('Lue lisää','mm-facebook-cookie-consent')) ); ?>" />
                    </p>
                <?php } ?>
				<p>
					<b class="fhhyperlink"><?php _e( 'Color of <strong>Learn More</strong> hyperlink', 'mm-facebook-cookie-consent' ) ?>:</b>
					<b class="fhbtn"><?php _e( 'Color of <strong>Learn More</strong> text in button', 'mm-facebook-cookie-consent' ) ?>:</b><br />
					<input type="text" class="colorpicker" data-alpha="true" name="mm_bcc_learnmore_text_color" value="<?php echo esc_attr( get_option( 'mm_bcc_learnmore_text_color', '#353535' ) ); ?>" />
				</p>
				<p>
					<b class="fhhyperlink"><?php _e( 'Color of <strong>Learn More</strong> hyperlink', 'mm-facebook-cookie-consent' ) ?>:</b>
					<b class="fhbtn"><?php _e( 'Color of <strong>Learn More</strong> text in button', 'mm-facebook-cookie-consent' ) ?>:</b><br />
					<input type="text" class="colorpicker" data-alpha="true" name="mm_bcc_learnmore_text_color_hover" value="<?php echo esc_attr( get_option( 'mm_bcc_learnmore_text_color_hover', '#595959' ) ); ?>" />
				</p>
				<p>
					<b class="fhbtn"><?php _e( 'FB Pixel ID', 'mm-facebook-cookie-consent' ) ?>:</b><br />
					<input type="text" name="mm_bcc_fbpixelid" required="required" value="<?php echo esc_attr( get_option( 'mm_bcc_fbpixelid', '' ) ); ?>" />

				</p>
			</fieldset>
			<?php submit_button(); ?>
		</form>
		<div id="mm_ip_addresses" class="expandContent">
		    <a href="#mm_ip_addresses"><strong>Show Approved IP addresses</strong></a>
		 </div>
		<div class="showMe" style="display:none">
		     <?php
		     	$ips = json_decode( get_option('mm_bcc_ipaddress') );
		     	foreach (@$ips as $ip) {
		     		echo '<a target="_blank" href="https://whatismyipaddress.com/ip/' . $ip . '">' . $ip . '</a> | ';
		     	}
		     ?>
		</div>
	</div>
<?php
}
    