<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit();
}

delete_option( 'mm_bcc_position' );
delete_option( 'mm_bcc_bgcolor' );
delete_option( 'mm_bcc_textcolor' );
delete_option( 'mm_bcc_text' );
delete_option( 'mm_bcc_buttonbgcolor' );
delete_option( 'mm_bcc_buttontextcolor' );
delete_option( 'mm_bcc_buttonbgcolor_hover' );
delete_option( 'mm_bcc_buttontextcolor_hover' );
delete_option( 'mm_bcc_buttontext' );
delete_option( 'mm_bcc_buttontext_nessacary' );
delete_option( 'mm_bcc_show_hyperlink_learnmore' );
delete_option( 'mm_bcc_learnmore_link' );
delete_option( 'mm_bcc_learnmore_text' );
delete_option( 'mm_bcc_learnmore_text_color' );
delete_option( 'mm_bcc_learnmore_text_color_hover' );
delete_option( 'mm_bcc_sd' );
delete_option( 'mm_bcc_ppbuttonbg' );
delete_option( 'mm_bcc_fbpixelid' );
delete_option( 'mm_bcc_ipaddress' );
if( function_exists( 'pll_register_string' ) ) {
	$translations = pll_languages_list( array('fields' => 'name' ) );
	for( $i = 0; $i < count( $translations ); $i++) {
		delete_option( 'mm_bcc_pp_' . $translations[ $i ] );
	}
}
?>