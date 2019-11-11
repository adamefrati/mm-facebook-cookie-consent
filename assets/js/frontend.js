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
});