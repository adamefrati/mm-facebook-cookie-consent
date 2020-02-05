<?php
function mm_bcc_content() {
?>
<style>
	.modal {
		max-width: 50vw;
	}
	#mm_bcc_container {
		width:70%;
		margin:0 auto;
	}
	#mm_bcc { 
		padding:5%;
		background: <?php echo esc_attr( get_option( 'mm_bcc_bgcolor', '#e5e5e5' ) ); ?>;
	}


	#mm_bcc .privacybutton {
		background: <?php echo esc_attr( get_option( 'mm_bcc_ppbuttonbg', '#000' ) ); ?>;
		color: inherit;
		border: none;
	}

	#mm_bcc h1 {
		color: <?php echo esc_attr( get_option( 'mm_bcc_textcolor', '#353535' ) ); ?>;
		text-align: center;
	}
	
	#mm_bcc p {
		color: <?php echo esc_attr( get_option( 'mm_bcc_textcolor', '#353535' ) ); ?>;
	}

	#mm_bcc .mainbutton_nessacary {
		width:100%;
		border:none;
		color: <?php echo esc_attr( get_option( 'mm_bcc_learnmore_text_color', "#353535" ) ); ?>;
	}
	#mm_bcc .mainbutton_nessacary:focus {
		background: none;
		outline:none;
	}
	#mm_bcc .mainbutton_nessacary:hover {
		width:100%;
		border:none;
		background: none;
		color: <?php echo esc_attr( get_option( 'mm_bcc_learnmore_text_color_hover', "#595959" ) ); ?>;
	}
	
	#mm_bcc .mainbutton {
		background: <?php echo esc_attr( get_option( 'mm_bcc_buttonbgcolor', '#27b7f4' ) ) ?>;
		color: <?php echo esc_attr( get_option( 'mm_bcc_buttontextcolor', "#fff" ) ); ?>;
		border: none;
		width: 100%;
	}
	
	#mm_bcc .mainbutton:hover {
		background: <?php echo esc_attr( get_option( 'mm_bcc_buttonbgcolor_hover', '#24abe5' ) ) ?>;
		color: <?php echo esc_attr( get_option( 'mm_bcc_buttontextcolor_hover', "#fff" ) ); ?>;
	}

	#mm_bcc a {
		color: <?php echo esc_attr( get_option( 'mm_bcc_learnmore_text_color', "#353535" ) ); ?>;
		text-decoration: underline;
	}
	#mm_bcc a:hover {
		color: <?php echo esc_attr( get_option( 'mm_bcc_learnmore_text_color_hover', "#595959" ) ); ?>;
		text-decoration: underline;
	}
</style>

	<!-- Modal HTML embedded directly into document -->
	<div id="mm_bcc" class="modal">
		<div id="mm_bcc_container">
			<h1>Evästeet</h1>
		  	<p>
			<?php if( function_exists( 'pll_e' ) ) {
						pll_e( __( 'Verkkosivumme käyttää evästeitä saadaksesi parhaan käyttökokemuksen. Jatkaessasi sivuston käyttöä hyväksyt evästeet. ' ) );
					}
					else echo esc_attr( get_option( 'mm_bcc_text', __( 'Verkkosivumme käyttää evästeitä saadaksesi parhaan käyttökokemuksen. Jatkaessasi sivuston käyttöä hyväksyt evästeet. ', 'mm-facebook-cookie-consent' ) ) );
			?>
			<?php if( 1 == esc_attr( get_option( 'mm_bcc_show_hyperlink_learnmore', 1 ) ) ) { ?>
				<a href="<?php 
					if( !function_exists( 'pll_register_string' ) ) {
						echo get_page_link( esc_attr( get_option( 'mm_bcc_learnmore_link', 1 ) ) ); 
					} else {
						$translations = pll_languages_list( array( 'fields' => 'name' ) );
						for( $i = 0; $i < count( $translations ); $i++) {
							if( $translations[ $i ] == pll_current_language( 'name' ) )
								echo get_page_link( esc_attr( get_option( 'mm_bcc_pp_' . $translations[ $i ], 1 ) ) );
						}
					}
					?>"><?php 
					if( 2 == esc_attr( get_option( 'mm_bcc_sd', 1 ) ) )
						echo "<button class='privacybutton' type='button'>";
	                if( function_exists( 'pll_e' ) ) {
	                    pll_e( __( 'Lue lisää' ) );
	                } else {
	                    echo esc_attr( get_option( 'mm_bcc_learnmore_text', __( 'Lue lisää', 'mm-facebook-cookie-consent' ) ) ); 
					} 
					if( 2 == esc_attr( get_option( 'mm_bcc_sd', 1 ) ) )
						echo "</button>";	
					?></a>
			<?php } ?>
		  	</p>
		  	<p style="text-align: center; margin:0;">
		  	<button type="button" class="mainbutton"><?php 
	            if( function_exists( 'pll_e' ) ) {
	                pll_e( __( 'Selvä' ) );
	            } else {
	                echo esc_attr( get_option( 'mm_bcc_buttontext', __( 'Selvä', 'mm-facebook-cookie-consent' ) ) ); 
	            } ?>
	        </button>
	    	</p>

		  	<button type="button" class="mainbutton_nessacary"><?php 
	            if( function_exists( 'pll_e' ) ) {
	                pll_e( __( 'Vain tarvittavat evästeet' ) );
	            } else {
	                echo esc_attr( get_option( 'mm_bcc_buttontext_nessacary', __( 'Vain tarvittavat evästeet', 'mm-facebook-cookie-consent' ) ) ); 
	            } ?>
	        </button>
	    </div>
	</div>


<?php
}
?>