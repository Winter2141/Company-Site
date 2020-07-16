<?php
/*
File: inc/menus.php
Description: Plugin Menus
Plugin: FlatFolio
Author: Alessio Marzo
*/


add_action('admin_menu', 'ff_menus');

function ff_menus() {
	
	// Sub Page button for a specific Post Type
    add_submenu_page( 'edit.php?post_type=flatfolio', __('FlatFolio Options', FF_PLG_NAME), __('Settings', FF_PLG_NAME), 'manage_options', 'flatfolio_options', 'ff_flatfolio_options');
	
	/* Codex 
	add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	
	// Parent Slug Examples 
	For Dashboard: add_submenu_page( 'index.php', ... );
    For Posts: add_submenu_page( 'edit.php', ... );
    For Media: add_submenu_page( 'upload.php', ... );
    For Links: add_submenu_page( 'link-manager.php', ... );
    For Pages: add_submenu_page( 'edit.php?post_type=page', ... );
    For Comments: add_submenu_page( 'edit-comments.php', ... );
    For Custom Post Types: add_submenu_page( 'edit.php?post_type=your_post_type', ... );
    For Appearance: add_submenu_page( 'themes.php', ... );
    For Plugins: add_submenu_page( 'plugins.php', ... );
    For Users: add_submenu_page( 'users.php', ... );
    For Tools: add_submenu_page( 'tools.php', ... );
    For Settings: add_submenu_page( 'options-general.php', ... );
	*/
	
	/* Codex 
	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	*/
	
}