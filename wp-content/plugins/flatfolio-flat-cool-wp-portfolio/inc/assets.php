<?php
/*
File: inc/assets.php
Description: Assets inclusion
Plugin: FlatFolio
Author: Alessio Marzo
*/



//********************************************************************************//
// CSS
//********************************************************************************//


// Frontend
add_action( 'wp_enqueue_scripts', 'ff_frontend_styles' );

function ff_frontend_styles() {
	
	// Main
	wp_register_style( 'ff-main-style',  FF_URL . 'assets/css/frontend.css' );
    wp_enqueue_style( 'ff-main-style' );
	
	// Fonts
	wp_register_style( 'ff-fonts-style',  FF_URL . 'assets/css/fonts.css' );
    wp_enqueue_style( 'ff-fonts-style' );
	
	// Inline
	wp_add_inline_style( 'ff-main-style', get_option('ff_opt_custom_css') ); 
	
}


// Backend
add_action( 'admin_enqueue_scripts', 'ff_backend_styles' );

function ff_backend_styles() {
	
	// Main
	wp_register_style( 'ff-backend-style',  FF_URL . 'assets/css/backend.css' );
    wp_enqueue_style( 'ff-backend-style' );
	
	// Fonts
	wp_register_style( 'ff-fonts-style',  FF_URL . 'assets/css/fonts.css' );
    wp_enqueue_style( 'ff-fonts-style' );
	
}



//********************************************************************************//
// JS
//********************************************************************************//


// Frontend
add_action('wp_enqueue_scripts', 'ff_frontend_scripts');

function ff_frontend_scripts() {
	
	// Load WP jQuery if not included
	wp_enqueue_script('jquery');
	
	// Load modernizer.custom js script
	wp_enqueue_script('ff-modernizer-script', FF_URL . 'assets/js/modernizr.custom.js', '', '', true);
	
	// Load grid js script
	wp_enqueue_script('ff-grid-script', FF_URL . 'assets/js/grid.js', array('jquery'), '', true);
	
	// Load main js script
	wp_enqueue_script('ff-frontend-script', FF_URL . 'assets/js/frontend.js', array('jquery'), '', true);
	
	/* Codex
	wp_register_script( $handle, $src, $deps, $ver, $in_footer );
	*/
	
}


// Backend
add_action('admin_enqueue_scripts', 'ff_backend_scripts');

function ff_backend_scripts() {
	
	// Load WP jQuery if not included
	wp_enqueue_script('jquery');
	
	// Load main js script
	wp_enqueue_script('ff-backend-script', FF_URL . 'assets/js/backend.js', array('jquery'), '', true);
	
	/* Codex
	wp_register_script( $handle, $src, $deps, $ver, $in_footer );
	*/
	
}