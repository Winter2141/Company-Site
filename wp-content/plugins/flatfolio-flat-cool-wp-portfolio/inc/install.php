<?php
/*
File: inc/install.php
Description: Install functions
Plugin: FlatFolio
Author: Alessio Marzo
*/


//***************************************************************************
// Options Install/Unistall
//***************************************************************************

register_activation_hook(__FILE__,'ff_install_options');
register_deactivation_hook(__FILE__, 'ff_uninstall_options');


// Install Options Function
function ff_install_options() {
	
	// Force to uninstall past options
    ff_uninstall_options();
	
	// Add the options
	add_option('ff_custom_css','');
	
	// Update the revrite rules on activation
	flush_rewrite_rules();
	
}

// Uninstall Options Function
function ff_uninstall_options() { 

	// Remove Options
	delete_option('ff_custom_css');
	
	// Update the revrite rules on deactivation
	flush_rewrite_rules();
	
}



//***************************************************************************
// Plugin INIT
//***************************************************************************


// LANGUAGE
add_action('init', 'ff_language');

function ff_language() {
	
	load_plugin_textdomain('bl', false, FF_DIR . '/languages/'); 
	
}

// FUNCTIONS
require_once(FF_DIR.'inc/functions.php'); 

// ASSETS
require_once(FF_DIR.'inc/assets.php');

// POST TYPES
require_once(FF_DIR.'inc/posttypes/flatfolio.php');

// MENUS & PAGES
require_once(FF_DIR.'inc/menus.php');

// CUSTOM SIDEBARS
require_once(FF_DIR.'inc/sidebars.php');

// META BOXES
require_once(FF_DIR.'inc/metaboxes.php');

// PAGE TEMPLATES
require_once(FF_DIR.'inc/templates.php');
