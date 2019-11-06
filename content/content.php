<?php
function mm_cce_content() {
?>
<style>
	@keyframes fadein1 {
		0% {
			opacity: 0.5;
		}
		100% {
			opacity: 1;
		}
	}
	
	#mm_cce { 
		width: 100%; 
		animation: fadein1 1s;
		position: fixed; 
		left: 0px;
		z-index: 9999;
		display: table;
		bottom:0px;
		background: <?php echo esc_attr( get_option( 'mm_cce_bgcolor', '#333' ) ); ?>;
	}


	#mm_cce .privacybutton {
		background: <?php echo esc_attr( get_option( 'mm_cce_ppbuttonbg', '#000' ) ); ?>;
		color: inherit;
		border: none;
	}
	
	#mm_cce p {
		display: table-cell;
		text-align: center;
		width: 100%;
		padding: 10px;
		color: <?php echo esc_attr( get_option( 'mm_cce_textcolor', '#fff' ) ); ?>;
	}
	
	#mm_cce .mainbutton {
		background: <?php echo esc_attr( get_option( 'mm_cce_buttonbgcolor', '#000' ) ) ?>;
		color: <?php echo esc_attr( get_option( 'mm_cce_buttontextcolor', "#fff" ) ); ?>;
		border: none;
	}
	
	#mm_cce .mainbutton:hover {
		background: <?php echo esc_attr( get_option( 'mm_cce_buttonbgcolor_hover', '#131313' ) ) ?>;
		color: <?php echo esc_attr( get_option( 'mm_cce_buttontextcolor_hover', "#fff" ) ); ?>;
		border: none;
	}

	#mm_cce a {
		color: <?php echo esc_attr( get_option( 'mm_cce_learnmore_text_color', "#fff" ) ); ?>;
		text-decoration: underline;
	}
	#mm_cce a:hover {
		color: <?php echo esc_attr( get_option( 'mm_cce_learnmore_text_color_hover', "#dadada" ) ); ?>;
		text-decoration: underline;
	}
</style>
<div id="mm_cce">
	<p>
		<?php if( function_exists( 'pll_e' ) ) {
					pll_e( __( 'Verkkosivumme käyttää evästeitä saadaksesi parhaan käyttökokemuksen. Jatkaessasi sivuston käyttöä hyväksyt evästeet. ' ) );
				}
				else echo esc_attr( get_option( 'mm_cce_text', __( 'Verkkosivumme käyttää evästeitä saadaksesi parhaan käyttökokemuksen. Jatkaessasi sivuston käyttöä hyväksyt evästeet. ', 'mm-cookie-consent-europe' ) ) );
		?>

		<?php if( 1 == esc_attr( get_option( 'mm_cce_show_hyperlink_learnmore', 1 ) ) ) { ?>
			<a href="<?php 
				if( !function_exists( 'pll_register_string' ) ) {
					echo get_page_link( esc_attr( get_option( 'mm_cce_learnmore_link', 1 ) ) ); 
				} else {
					$translations = pll_languages_list( array( 'fields' => 'name' ) );
					for( $i = 0; $i < count( $translations ); $i++) {
						if( $translations[ $i ] == pll_current_language( 'name' ) )
							echo get_page_link( esc_attr( get_option( 'mm_cce_pp_' . $translations[ $i ], 1 ) ) );
					}
				}
				?>"><?php 
				if( 2 == esc_attr( get_option( 'mm_cce_sd', 1 ) ) )
					echo "<button class='privacybutton' type='button'>";
                if( function_exists( 'pll_e' ) ) {
                    pll_e( __( 'Lue lisää' ) );
                } else {
                    echo esc_attr( get_option( 'mm_cce_learnmore_text', __( 'Lue lisää', 'mm-cookie-consent-europe' ) ) ); 
				} 
				if( 2 == esc_attr( get_option( 'mm_cce_sd', 1 ) ) )
					echo "</button>";	
				?></a>
		<?php } ?>


        <button type="button" class="mainbutton" style="margin-left: 30px; margin-right: 30px;"><?php 
            if( function_exists( 'pll_e' ) ) {
                pll_e( __( 'Selvä' ) );
            } else {
                echo esc_attr( get_option( 'mm_cce_buttontext', __( 'Selvä', 'mm-cookie-consent-europe' ) ) ); 
            } ?>
        </button>
		
	</p>
</div>
<?php
}
?>