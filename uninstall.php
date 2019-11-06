<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit();
}

delete_option( 'mm_cce_position' );
delete_option( 'mm_cce_bgcolor' );
delete_option( 'mm_cce_textcolor' );
delete_option( 'mm_cce_text' );
delete_option( 'mm_cce_buttonbgcolor' );
delete_option( 'mm_cce_buttontextcolor' );
delete_option( 'mm_cce_buttonbgcolor_hover' );
delete_option( 'mm_cce_buttontextcolor_hover' );
delete_option( 'mm_cce_buttontext' );
delete_option( 'mm_cce_show_hyperlink_learnmore' );
delete_option( 'mm_cce_learnmore_link' );
delete_option( 'mm_cce_learnmore_text' );
delete_option( 'mm_cce_learnmore_text_color' );
delete_option( 'mm_cce_learnmore_text_color_hover' );
delete_option( 'mm_cce_sd' );
delete_option( 'mm_cce_ppbuttonbg' );
if( function_exists( 'pll_register_string' ) ) {
	$translations = pll_languages_list( array('fields' => 'name' ) );
	for( $i = 0; $i < count( $translations ); $i++) {
		delete_option( 'mm_cce_pp_' . $translations[ $i ] );
	}
}
?>