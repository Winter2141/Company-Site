<?php
/*
Plugin Name: FlatFolio - Portfolio & Gallery
Plugin URI: http://wordpress.webself.it/flatfolio/
Description: Flat & Cool Portfolio (Free Version)
Author: unCommons
Version: 1.0
Author URI: http://codecanyon.net/user/unCommons/?ref=unCommons
Compatibility: WP 3.6.x - 4.x 
*/

// Basic plugin definitions 
define ('FF_PLG_NAME', 'flatfolio');
define( 'FF_PLG_VERSION', '1.0' );
define( 'FF_URL', WP_PLUGIN_URL . '/' . str_replace( basename(__FILE__), '', plugin_basename(__FILE__) ));
define( 'FF_DIR', WP_PLUGIN_DIR . '/' . str_replace( basename(__FILE__), '', plugin_basename(__FILE__) ));


// Plugin INIT
require_once(FF_DIR.'inc/install.php');


// Admin Notices

add_action('admin_notices', 'flatfolio_notice');

function flatfolio_notice() {
	global $current_user ;
    $user_id = $current_user->ID;
		
    /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'flatfolio_ignore') ) {
        echo '<div class="updated" style="position:relative;"><p>'; 
        printf(__('<h3>News: It\'s online the new amazing PRO version of FlatFolio! <a href="http://codecanyon.net/item/flatfolio-flat-cool-wp-portfolio/9294349/?ref=unCommons" target="_blank">Take a look &raquo;</a></h3> <div style="position:absolute; top:10px; right:10px;"><a href="%1$s">Hide News</a></div>'), '?flatfolio_notice=0');
        echo "</p></div>";
	}
	
}

add_action('admin_init', 'flatfolio_notice_ignore');

function flatfolio_notice_ignore() {
	global $current_user;
	$user_id = $current_user->ID;
	
	/* If user clicks to ignore the notice, add that to their user meta */
	if ( isset($_GET['flatfolio_notice']) && '0' == $_GET['flatfolio_notice'] ) {
		 add_user_meta($user_id, 'flatfolio_ignore', 'true', true);
		 add_user_meta($user_id, 'flatfolio_ignore_data', time(), true);
	}
	
	$data = get_user_meta($user_id, 'flatfolio_ignore_data');
	
	
	if ($data){
		$days = time() - $data[0];	
	}else{
		$days = time();
	}
	
	// Expire after 1 week
	if ( get_user_meta($user_id, 'flatfolio_ignore_data') AND $days > 604800 ) {
		delete_user_meta($user_id, 'flatfolio_ignore');
		delete_user_meta($user_id, 'flatfolio_ignore_data');
	}
	
}
