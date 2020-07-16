<?php
/*
File: inc/sidebars.php
Description: Plugin sidebars
Plugin: FlatFolio
Author: Alessio Marzo
*/


// Blank Plugin Sidebar 1
$sidebar_args1 = array(
	'name'          => __( 'Blank Plugin Sidebar 1', FF_PLG_NAME ),
	'id'            => 'blank-sidebar-1',
	'description'   => __( 'Here you can add widgets for Blank Plugin', FF_PLG_NAME ),
    'class'         => '',
	'before_widget' => '<div class="widget">',
	'after_widget'  => '</div>',
	'before_title'  => '<h3 class="widget-title">',
	'after_title'   => '</h3>' );
	
register_sidebar( $sidebar_args1 );


// Blank Plugin Sidebar 21
$sidebar_args2 = array(
	'name'          => __( 'Blank Plugin Sidebar 2', FF_PLG_NAME ),
	'id'            => 'blank-sidebar-2',
	'description'   => __( 'Here you can add widgets for Blank Plugin', FF_PLG_NAME ),
    'class'         => '',
	'before_widget' => '<div class="widget">',
	'after_widget'  => '</div>',
	'before_title'  => '<h3 class="widget-title">',
	'after_title'   => '</h3>' );
	
register_sidebar( $sidebar_args2 );