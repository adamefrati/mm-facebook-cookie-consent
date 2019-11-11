<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://linkedin.com/in/shayanabbas
 * @since             1.0.2
 * @package           Cookie Consent Europe
 *
 * @wordpress-plugin
 * Plugin Name:       COOKIE CONSENT - Myyntimaatio
 * Plugin URI:        https://myyntimaatio.fi
 * Description:       Adds a cookie notice and a privacy notice.
 * Version:           1.0.2
 * Author:            Shayan Abbas
 * Author URI:        https://linkedin.com/in/shayanabbas
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mm-cookie-consent-europe
 * Domain Path:       /languages
 */

$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$plugin_version = $plugin_data['Version'];
define( 'MM_CC_VERSION', $plugin_version );

require_once plugin_basename( '/admin/settings.php' );
require_once plugin_basename( '/content/content.php' );
require_once plugin_basename( '/plugin-update-checker/plugin-update-checker.php' );

// Adding plugin autoupdate feature
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/shayanabbas/mm-cookie-consent-europe/',
	__FILE__,
	'mm-cookie-consent-europe'
);

$myUpdateChecker->getVcsApi()->enableReleaseAssets();

add_action( 'init', function () {
	load_plugin_textdomain( 'mm-cookie-consent-europe' );
	if( function_exists( 'pll_register_string' ) ) {
        pll_register_string( __( 'Text in cookie notice' ), __( 'Verkkosivumme käyttää evästeitä saadaksesi parhaan käyttökokemuksen. Jatkaessasi sivuston käyttöä hyväksyt evästeet.' ), 'mm tools', true);
        pll_register_string( __( 'Text of privacy policy hyperlink' ), __( 'Lue lisää' ), 'mm tools' );
        pll_register_string( __( 'Text in cookie button' ), __( 'Selvä' ), 'mm tools' );
	}
} );

add_action( 'plugin_action_links_' . plugin_basename(__FILE__), 'mm_cce_add_plugin_page_settings_link' );

function mm_cce_add_plugin_page_settings_link( $links ) {
	$in = '<a href="' .
		admin_url( 'options-general.php?page=mm_cce_cookies_options' ) .
		'">' . __('Settings') . '</a>';
	array_unshift($links, $in);
	return $links;
}

add_action( 'admin_menu', 'mm_cce_register_script_backend' );

function mm_cce_register_script_backend() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker-alpha', plugins_url( 'assets/js/wp-color-picker-alpha.min.js', __FILE__ ), array( 'wp-color-picker' ) );
	
	wp_register_script( 'mm_cce_backend_js', plugins_url( 'assets/js/backend.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ),  MM_CC_VERSION );
	wp_enqueue_script( 'mm_cce_backend_js' );
}

add_action( 'wp_enqueue_scripts', 'mm_cce_register_script_frontend' );

function mm_cce_register_script_frontend() {
	
	wp_register_script( 'mm_cce_frontend_js', plugins_url( 'assets/js/frontend.js', __FILE__ ), array( 'jquery' ),  MM_CC_VERSION );
	wp_enqueue_script( 'mm_cce_frontend_js' );
}

/** Check if cookie doesnt exist then show popup */
if( !isset($_COOKIE['mm_cce_cookies_cookie']) ) {

	add_action('wp_footer', 'mm_cce_insert');

	function mm_cce_insert() {
		echo mm_cce_content();
	}

}

?>