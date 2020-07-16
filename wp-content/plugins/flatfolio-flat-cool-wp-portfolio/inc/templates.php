<?php
/*
File: inc/templates.php
Description: Loading Custom Templates
Plugin: FlatFolio
Author: Alessio Marzo
*/


add_filter('the_content','ff_add_tpl_after_page_content');

function ff_add_tpl_after_page_content($content) {
	
	$tpl_meta_field = get_post_meta(get_the_ID(), 'ff_template_field', true );
	
	if ($tpl_meta_field == 'main') {
		
		require_once(FF_DIR.'inc/tpl/flatfolio-main.php');
		echo do_shortcode( $content );
		ff_get_flatfolio_main();
		
	}else{
		
		return $content;
		
	}

}



