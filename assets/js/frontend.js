
jq2 = jQuery.noConflict();
jq2(function( $ ) {
	console.log(WPURLS.ajax_url);
  	// Code using $ as usual goes here; the actual jQuery object is jq2
	
	if( WPURLS.mm_current_page != WPURLS.mm_cookie_page ) {
		$.modal.defaults = {
		  closeExisting: false,    // Close existing modals. Set this to false if you need to stack multiple modal instances.
		  escapeClose: false,      // Allows the user to close the modal by pressing `ESC`
		  clickClose: false,       // Allows the user to close the modal by clicking the overlay
		};
		
		if( document.cookie.indexOf( "mm_bcc_cookies_cookie" ) === -1 ) {
			$("#mm_bcc").modal('show');
			//Authorize facebook cookies
			$( "#mm_bcc button.mainbutton" ).click( function() {
				setCookie('mm_bcc_cookies_cookie', 1, 365);
				setCookie('mm_bcc_cookies_facebook', 1, 365);
				// Send Ajax request IP
				var data = {
				    'action': 'my_ajax_request',
				    'post_type': 'POST',
				    'facebook': 'true'
				};

				jQuery.post(WPURLS.ajax_url, data, function(response) {
				    console.log( response );
				}, 'json');
				//end Ajax request

				$.modal.close();
			});
			//Revoke facebook cookies
			$( "#mm_bcc button.mainbutton_nessacary" ).click( function() {
				setCookie('mm_bcc_cookies_cookie', 1, 365);
				$.modal.close();
			});
		} else { 
			$.modal.close(); 
		};
	}
});

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {   
    document.cookie = name+'=; Max-Age=-99999999;';  
}