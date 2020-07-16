<?php
/*
File: inc/tpl/page-flatfolio-main.php
Description: Page TPL for the Books loop
Plugin: FlatFolio
Author: Alessio Marzo
*/

//get_header(); ?>

<?php 

function ff_get_flatfolio_main() {
	
$og_args = array(
	'type'                     => 'flatfolio',
	'child_of'                 => 0,
	'parent'                   => '',
	'orderby'                  => 'name',
	'order'                    => 'ASC',
	'hide_empty'               => 1,
	'hierarchical'             => 1,
	'exclude'                  => '',
	'include'                  => '',
	'number'                   => '',
	'taxonomy'                 => 'flatfolio-categories',
	'pad_counts'               => false 

); 

$og_categories = get_categories( $og_args ); 
?> 


	<div class="og-filter">
    	<button id="viewall" class="filter-selected">All</button>
        
        <?php foreach($og_categories as $og_category) { ?>
        <button id="<?php echo $og_category->slug; ?>"><?php echo $og_category->name; ?></button>
        <?php } ?>
        
    </div>
	<ul class="og-grid">

	<?php
    
    $ff_args = array( 'post_type' => 'flatfolio', 'posts_per_page' => -1 );
    
    $ff_loop = new WP_Query( $ff_args );
    
    while ( $ff_loop->have_posts() ) { 
    
    $ff_loop->the_post();
	
	// Get Description
	$excerpt = strip_tags(get_the_excerpt());
	$content = strip_tags(get_the_content());
	
	if ( !empty($excerpt) ) {
		
		if ( strlen($excerpt) > 400 ) {
			$ff_desc = substr($excerpt, 0, 400).'...';
		}else{
			$ff_desc = $excerpt;
		}
		
	}else{
		
		if ( strlen($content) > 400 ) {
			$ff_desc = substr($content, 0, 400).'...';
		}else{
			$ff_desc = $content;
		}
	
	}
	
	// Get Button Data
	switch (get_post_meta(get_the_ID(), 'ff_meta_link_type', true)) {
		case "none":
		$buttonurl = '';
		break;
		
		case "post":
		$buttonurl = get_permalink();
		break;
		
		case "url":
		$buttonurl = get_post_meta(get_the_ID(), 'ff_meta_link', true);
		break;
	}
	
	

	// Get Preview image url
	if(has_post_thumbnail()){
		$ff_preview_url = ff_get_thumbnail_url(get_the_ID(), 'ff-preview-thumb');
	}else{
		$ff_preview_url = FF_URL.'assets/img/no_image_large.png';
	}
	
	// Get Full Code
	$ff_full_url = '';
	$ff_video_code = '';
	$ff_audio_code = '';
	switch( get_post_format(get_the_ID()) ){
		
		case '':
		if(has_post_thumbnail()){
			$ff_full_url = ff_get_thumbnail_url(get_the_ID(), 'ff-project-thumb');
		}else{
			$ff_full_url = FF_URL.'assets/img/no_image_full.png';
		}
		break;
		
		case 'image':
		if(has_post_thumbnail()){
			$ff_full_url = ff_get_thumbnail_url(get_the_ID(), 'ff-project-thumb');
		}else{
			$ff_full_url = FF_URL.'assets/img/no_image_full.png';
		}
		break;
		
		case 'video':
		$ff_video_type = get_post_meta(get_the_ID(), 'ff_meta_video_type', true);
		$ff_video_id = get_post_meta(get_the_ID(), 'ff_meta_video_id', true);
		
		if ($ff_video_type == 'youtube') {
			$ff_video_code = '<iframe width="100%" height="450" src="//www.youtube.com/embed/'.$ff_video_id.'?rel=0" frameborder="0"></iframe>';
		}else{
			$ff_video_code = '<iframe width="100%" height="450" src="//player.vimeo.com/video/'.$ff_video_id.'?byline=0&amp;portrait=0&amp;color=FA6E6E" frameborder="0"></iframe>';
		}
		
		break;
		
		case 'audio':
		$ff_audio_code = get_post_meta(get_the_ID(), 'ff_meta_audio_code', true);
		break;
	}
	
	// Extra fields Init
	$ff_extra_icon_1 = '';
	$ff_extra_label_1 = '';
	$ff_extra_value_1 = '';
	$ff_extra_icon_2 = '';
	$ff_extra_label_2 = '';
	$ff_extra_value_2 = '';
	$ff_extra_icon_3 = '';
	$ff_extra_label_3 = '';
	$ff_extra_value_3 = '';
	$ff_extra_icon_4 = '';
	$ff_extra_label_4 = '';
	$ff_extra_value_4 = '';
	$ff_extra_icon_5 = '';
	$ff_extra_label_5 = '';
	$ff_extra_value_5 = '';
	
	// Extra 1
	$ff_extra_icon_1 = get_post_meta(get_the_ID(), 'ff_meta_icon1', true);
	$ff_extra_label_1 = get_post_meta(get_the_ID(), 'ff_meta_label1', true);
	$ff_extra_value_1 = get_post_meta(get_the_ID(), 'ff_meta_value1', true);
	
	// Extra 2
	$ff_extra_icon_2 = get_post_meta(get_the_ID(), 'ff_meta_icon2', true);
	$ff_extra_label_2 = get_post_meta(get_the_ID(), 'ff_meta_label2', true);
	$ff_extra_value_2 = get_post_meta(get_the_ID(), 'ff_meta_value2', true);
	
	// Extra 3
	$ff_extra_icon_3 = get_post_meta(get_the_ID(), 'ff_meta_icon3', true);
	$ff_extra_label_3 = get_post_meta(get_the_ID(), 'ff_meta_label3', true);
	$ff_extra_value_3 = get_post_meta(get_the_ID(), 'ff_meta_value3', true);
	
	// Extra 4
	$ff_extra_icon_4 = get_post_meta(get_the_ID(), 'ff_meta_icon4', true);
	$ff_extra_label_4 = get_post_meta(get_the_ID(), 'ff_meta_label4', true);
	$ff_extra_value_4 = get_post_meta(get_the_ID(), 'ff_meta_value4', true);
	
	// Extra 5
	$ff_extra_icon_5 = get_post_meta(get_the_ID(), 'ff_meta_icon5', true);
	$ff_extra_label_5 = get_post_meta(get_the_ID(), 'ff_meta_label5', true);
	$ff_extra_value_5 = get_post_meta(get_the_ID(), 'ff_meta_value5', true);
	
	// Social
	$ff_fb = get_post_meta(get_the_ID(), 'ff_meta_facebook', true);
	$ff_tw = get_post_meta(get_the_ID(), 'ff_meta_twitter', true);
	$ff_li = get_post_meta(get_the_ID(), 'ff_meta_linkedin', true);
	$ff_pi = get_post_meta(get_the_ID(), 'ff_meta_pinterest', true);
	
	
	// Prepare data attributes for extras
	
	if(!empty($ff_extra_value_1)){
		$ff_extra_data_1 = 'data-extra-icon-1 ="'.$ff_extra_icon_1.'" data-extra-label-1 ="'.$ff_extra_label_1.'" data-extra-value-1 ="'.$ff_extra_value_1.'" ';
	}else{
		$ff_extra_data_1 ='';
	}
	
	if(!empty($ff_extra_value_2)){
		$ff_extra_data_2 = 'data-extra-icon-2 ="'.$ff_extra_icon_2.'" data-extra-label-2 ="'.$ff_extra_label_2.'" data-extra-value-2 ="'.$ff_extra_value_2.'" ';
	}else{
		$ff_extra_data_2 ='';
	}
	
	if(!empty($ff_extra_value_3)){
		$ff_extra_data_3 = 'data-extra-icon-3 ="'.$ff_extra_icon_3.'" data-extra-label-3 ="'.$ff_extra_label_3.'" data-extra-value-3 ="'.$ff_extra_value_3.'" ';
	}else{
		$ff_extra_data_3 ='';
	}
	
	if(!empty($ff_extra_value_4)){
		$ff_extra_data_4 = 'data-extra-icon-4 ="'.$ff_extra_icon_4.'" data-extra-label-4 ="'.$ff_extra_label_4.'" data-extra-value-4 ="'.$ff_extra_value_4.'" ';
	}else{
		$ff_extra_data_4 ='';
	}
	
	if(!empty($ff_extra_value_5)){
		$ff_extra_data_5 = 'data-extra-icon-5 ="'.$ff_extra_icon_5.'" data-extra-label-5 ="'.$ff_extra_label_5.'" data-extra-value-5 ="'.$ff_extra_value_5.'" ';
	}else{
		$ff_extra_data_5 ='';
	}
	
	$ff_format = get_post_format(get_the_ID());
	switch ($ff_format) {
		case 'image':
		$ff_format_class = 'ff-icon-pictures6';
		break;
		case 'audio':
		$ff_format_class = 'ff-icon-music9';
		break;
		case 'video':
		$ff_format_class = 'ff-icon-play10';
		break;
	}
	
	// Manage Categories
	$itemcats = get_the_terms( get_the_ID(), 'flatfolio-categories' );
	$itemclasses = '';
	if (is_array($itemcats)) {
	foreach($itemcats as $itemcat){$itemclasses .= $itemcat->slug.' '; }
	}
	
	// Create ITEM	
		echo '<li class="item '.$itemclasses.'">';
		echo '<a href="'.$buttonurl.'" data-format="'.$ff_format.'" data-linktarget="'.get_post_meta(get_the_ID(), 'ff_meta_link_target', true).'" data-buttonlabel="'.get_post_meta(get_the_ID(), 'ff_meta_link_label', true).'" data-largesrc="'.$ff_preview_url.'" data-fullsrc="'.$ff_full_url.'" data-title="'.get_the_title().'" data-description="'.$ff_desc.'" '.$ff_extra_data_1.$ff_extra_data_2.$ff_extra_data_3.$ff_extra_data_4.$ff_extra_data_5.' data-facebook="'.$ff_fb.'" data-twitter="'.$ff_tw.'" data-linkedin="'.$ff_li.'" data-pinterest="'.$ff_pi.'">';
		if(has_post_thumbnail()){
			echo get_the_post_thumbnail(get_the_ID(), 'ff-grid-thumb');
		}else{
			echo '<img class="attachment-ff-grid-thumb" src="'.FF_URL.'assets/img/no_image_thumb.png">';
		}
		echo '<div class="og-caption"><span class="'.$ff_format_class.'"></span> '.get_the_title().'</div>';
		echo '</a>';
		if(!empty($ff_video_code)){ echo '<div class="ff-video-container" style="display:none;">'.$ff_video_code.'</div>';}
		if(!empty($ff_audio_code)){ echo '<div class="ff-audio-container" style="display:none;">'.$ff_audio_code.'</div>';}
		echo '</li>';
		
    }
    
    ?>           
            
    </ul>
    
    <div class="og-lightbox-overlay">
    <span class="og-close-overlay"></span>
    </div>


<?php

}

//get_footer();