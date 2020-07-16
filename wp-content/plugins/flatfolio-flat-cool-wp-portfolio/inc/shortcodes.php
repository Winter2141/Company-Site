<?php
/*
File: inc/shortcodes.php
Description: Plugin shortcodes
Plugin: FlatFolio
Author: Alessio Marzo
*/



function ff_main_short( $content = null ) {
	
	// Return
	require_once(FF_DIR.'inc/tpl/flatfolio-main.php');
    return ff_get_flatfolio_main();
	 
}

add_shortcode( 'flatfolio', 'ff_main_short' );