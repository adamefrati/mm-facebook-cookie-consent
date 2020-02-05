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
 * @since             2.0.1
 * @package           Facebook Cookie Consent
 *
 * @wordpress-plugin
 * Plugin Name:       FACEBOOK COOKIE CONSENT - Myyntimaatio
 * Plugin URI:        https://myyntimaatio.fi
 * Description:       Adds a cookie notice and a privacy notice with facebook pixel authorization.
 * Version:           2.0.1
 * Author:            Shayan Abbas
 * Author URI:        https://linkedin.com/in/shayanabbas
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       mm-facebook-cookie-consent
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
	'https://github.com/shayanabbas/mm-facebook-cookie-consent/',
	__FILE__,
	'mm-facebook-cookie-consent'
);

$myUpdateChecker->getVcsApi()->enableReleaseAssets();

add_action( 'init', function () {
	load_plugin_textdomain( 'mm-facebook-cookie-consent' );
	if( function_exists( 'pll_register_string' ) ) {
        pll_register_string( __( 'Text in cookie notice' ), __( 'Verkkosivumme käyttää evästeitä saadaksesi parhaan käyttökokemuksen. Jatkaessasi sivuston käyttöä hyväksyt evästeet.' ), 'mm tools', true);
        pll_register_string( __( 'Text of privacy policy hyperlink' ), __( 'Lue lisää' ), 'mm tools' );
        pll_register_string( __( 'Text in cookie button' ), __( 'Selvä' ), 'mm tools' );
	}
} );

add_action( 'plugin_action_links_' . plugin_basename(__FILE__), 'mm_bcc_add_plugin_page_settings_link' );

function mm_bcc_add_plugin_page_settings_link( $links ) {
	$in = '<a href="' .
		admin_url( 'admin.php?page=mm_bcc_cookies_options' ) .
		'">' . __('Settings') . '</a>';
	array_unshift($links, $in);
	return $links;
}

add_action( 'admin_menu', 'mm_bcc_register_script_backend' );

function mm_bcc_register_script_backend() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker-alpha', plugins_url( 'assets/js/wp-color-picker-alpha.min.js', __FILE__ ), array( 'wp-color-picker' ) );
	
	wp_register_script( 'mm_bcc_backend_js', plugins_url( 'assets/js/backend.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ),  MM_CC_VERSION );
	wp_enqueue_script( 'mm_bcc_backend_js' );
}

add_action( 'wp_enqueue_scripts', 'mm_bcc_register_script_frontend' );

function mm_bcc_register_script_frontend() {
	

	wp_register_script( 'mm_bcc_frontend_js', plugins_url( 'assets/js/frontend.js', __FILE__ ), array( 'jquery' ),  MM_CC_VERSION );
	wp_enqueue_script( 'mm_bcc_frontend_js' );


	wp_localize_script('mm_bcc_frontend_js', 'WPURLS', array( 'siteurl' => get_option('siteurl'), 'ajax_url' => admin_url('admin-ajax.php'), 'mm_cookie_page' => get_option( 'mm_bcc_learnmore_link', 1 ), 'mm_current_page' => get_the_ID() ));


	wp_register_script( 'mm_bcc_modal_js', plugins_url( 'assets/js/jquery.modal.min.js', __FILE__ ), array( 'jquery' ),  MM_CC_VERSION );
	wp_enqueue_script( 'mm_bcc_modal_js' );

	wp_register_style( 'mm_bcc_modal_css', plugins_url( 'assets/css/jquery.modal.min.css', __FILE__ ), array( ),  MM_CC_VERSION );
	wp_enqueue_style( 'mm_bcc_modal_css' );


}

add_action( 'wp_ajax_my_ajax_request', 'mm_bcc_handle_ajax_request' );
add_action( 'wp_ajax_nopriv_my_ajax_request', 'mm_bcc_handle_ajax_request' );
function mm_bcc_handle_ajax_request() {
    $facebook	= isset($_POST['facebook'])?trim($_POST['facebook']):"";
    if( $facebook ==  "true" ) {
    	$ip_array = json_decode( ( get_option("mm_bcc_ipaddress") == "" ) ? '[]' : get_option("mm_bcc_ipaddress") );
    	$ip_array[] = getenv('HTTP_CLIENT_IP')?:
							getenv('HTTP_X_FORWARDED_FOR')?:
							getenv('HTTP_X_FORWARDED')?:
							getenv('HTTP_FORWARDED_FOR')?:
							getenv('HTTP_FORWARDED')?:
							getenv('REMOTE_ADDR');
    	update_option( "mm_bcc_ipaddress", json_encode($ip_array) );
    }
    exit;
}

function mm_bcc_hook_javascript() {
    ?>
    <!-- Facebook Pixel Code -->
	<script>
	  !function(f,b,e,v,n,t,s)
	  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	  n.queue=[];t=b.createElement(e);t.async=!0;
	  t.src=v;s=b.getElementsByTagName(e)[0];
	  s.parentNode.insertBefore(t,s)}(window, document,'script',
	  'https://connect.facebook.net/en_US/fbevents.js');
	  <?php
	  if($_COOKIE['mm_bcc_cookies_facebook'] != 1 ) {
	  ?>

      fbq('consent', 'revoke');
      <?php
  	  }
  	  ?>

	  fbq('init', '<?php echo esc_attr( get_option( 'mm_bcc_fbpixelid', '' ) ); ?>');
	  fbq('track', 'PageView');

	</script>
	<noscript>
	  <img height="1" width="1" style="display:none" 
	       src="https://www.facebook.com/tr?id=<?php echo esc_attr( get_option( 'mm_bcc_fbpixelid', '' ) ); ?>&ev=PageView&noscript=1"/>
	</noscript>
	<!-- End Facebook Pixel Code -->
    <?php
}
if( esc_attr( get_option( 'mm_bcc_fbpixelid', '' ) ) != "" )
	add_action('wp_head', 'mm_bcc_hook_javascript');


/** Check if cookie doesnt exist then show popup */
if( !isset($_COOKIE['mm_bcc_cookies_cookie']) ) {

	add_action('wp_footer', 'mm_bcc_insert');

	function mm_bcc_insert() {
		echo mm_bcc_content();
	}

}

?>