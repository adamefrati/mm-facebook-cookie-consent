jQuery(document).ready(function($){
    $('.colorpicker').wpColorPicker();
});
jQuery( document ).ready( function () {
	if( document.cookie.indexOf( "mm_cce_cookies_cookie" ) === -1 ) {
		jQuery( "#mm_cce" ).show();
		jQuery( "#mm_cce button" ).click( function() {
			jQuery( "#mm_cce" ).fadeOut( "slow" );
			var datum = new Date();
			datum.setTime(datum.getTime()+(365*24*60*60*1000));
			var ablauf = datum.toGMTString();
			document.cookie = 'mm_cce_cookies_cookie = 1; expires=' + ablauf + ';' + "domain=." + document.domain + "; path=/;";
		});
	} else { jQuery( "#mm_cce" ).hide(); };

	/*	Display not all options for hyperlink	*/
	if( 1 == jQuery( '[name="mm_cce_sd"] option:selected' ).val() ) {
		jQuery( '#ppbtnbg' ).hide();
		jQuery( '.fhbtn' ).hide();
	}
	jQuery( '[name="mm_cce_sd"]' ).change( function() {
		if( 2 == jQuery( '[name="mm_cce_sd"] option:selected' ).val() ) {
			jQuery( '#ppbtnbg' ).show( 'slow' );
			jQuery( '.fhbtn' ).show();
			jQuery( '.fhhyperlink' ).hide();
		}
		else {
			jQuery( '#ppbtnbg' ).hide( 'slow' );
			jQuery( '.fhbtn' ).hide();
			jQuery( '.fhhyperlink' ).show();
		}
	});

});