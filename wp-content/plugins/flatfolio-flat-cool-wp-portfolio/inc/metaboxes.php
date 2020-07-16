<?php
/*
File: inc/metaboxes.php
Description: Plugin metaboxes
Plugin: FlatFolio
Author: Alessio Marzo
*/


// CREATE METABOXES & METAFIELDS

add_action('admin_menu', 'ff_metaboxes');

function ff_metaboxes() {
	
	// BASIC METAS
	
	$screens_basic = array( 'flatfolio' );
	
	foreach ( $screens_basic as $screen ) {
	
	// Format
	add_meta_box('ff-format-metabox', __('Format Options', FF_PLG_NAME), 'ff_format_metafields', $screen, 'normal', 'high');
	
	// Link
	add_meta_box('ff-link-metabox', __('Link Options', FF_PLG_NAME), 'ff_link_metafields', $screen, 'normal', 'high');
	
	// Extra Fields
	add_meta_box('ff-extra-metabox', __('Extra Fields', FF_PLG_NAME), 'ff_extra_metafields', $screen, 'normal', 'high');
	
	// Social
	add_meta_box('ff-social-metabox', __('Social Share', FF_PLG_NAME), 'ff_social_metafields', $screen, 'normal', 'high');
	
	}
	
	
	// PAGE TEMPLATES
	
	add_meta_box('flatfolio-templates-metabox', __('FlatFolio Template', FF_PLG_NAME), 'ff_templates_metafields', 'page', 'side', 'low');
	
}


// FORMAT FIELDS
function ff_format_metafields() { 

	global $post;
	
		
	// Get all post meta saved
	$ff_meta_video_type = get_post_meta($post->ID, 'ff_meta_video_type', true);
	$ff_meta_video_id = get_post_meta($post->ID, 'ff_meta_video_id', true);
	$ff_meta_audio_code = get_post_meta($post->ID, 'ff_meta_audio_code', true);
	
	// Set a default value if empty
	if (empty($ff_meta_video_type)) { $ff_meta_video_type = 'youtube'; }
	if (empty($ff_meta_video_id)) { $ff_meta_video_id = ''; }
	if (empty($ff_meta_audio_code)) { $ff_meta_audio_code = ''; }
	

	// Image Format
	echo '<div class="ff-image-format" style="display:none;">'.__('You selected <b>IMAGE</b> Format, so you only need to attach a preview image to the post using the WP\'s Featured Image tool to the right.', FF_PLG_NAME).'</div>';
	
	// Video Format
	echo '<div class="ff-video-format" style="display:none;">
	
		 <div class="field-row">
		 <label for="ff_meta_video_type">'.__('Video Type:', FF_PLG_NAME).'</label> 
         <select name="ff_meta_video_type" id="ff_meta_video_type">';
		 if($ff_meta_video_type == 'youtube'){ echo '<option value="youtube" selected="selected">Youtube</option>'; }else{ echo '<option value="youtube">Youtube</option>'; }
		 if($ff_meta_video_type == 'vimeo'){ echo '<option value="vimeo" selected="selected">Vimeo</option>'; }else{ echo '<option value="vimeo">Vimeo</option>'; }
	echo '</select>
		 </div>
		 <div class="field-row">
		 <label for="ff_meta_video_id">'.__('Video ID:', FF_PLG_NAME).'</label> 
		 <input name="ff_meta_video_id" id="ff_meta_video_id" type="text" value="'.$ff_meta_video_id.'"> 
		 </select>
		 </div>
		 
		 </div>';


	// Audio Format
	echo '<div class="ff-audio-format" style="display:none;">
		 <label for="ff_meta_audio_code">'.__('Audio Code:', FF_PLG_NAME).'</label>
         <textarea name="ff_meta_audio_code" id="ff_meta_audio_code" class="large-text code">'.$ff_meta_audio_code.'</textarea> 
		 </div>';
	 	
}

// LINK FIELDS
function ff_link_metafields() { 

	global $post;
	
		
	// Get all post meta saved
	$ff_meta_link_type = get_post_meta($post->ID, 'ff_meta_link_type', true);
	$ff_meta_link = get_post_meta($post->ID, 'ff_meta_link', true);
	$ff_meta_link_target = get_post_meta($post->ID, 'ff_meta_link_target', true);
	$ff_meta_link_label = get_post_meta($post->ID, 'ff_meta_link_label', true);
	
	
	
	// Set a default value if empty
	if (empty($ff_meta_link_type)) { $ff_meta_link_type = 'none'; }
	if (empty($ff_meta_link)) { $ff_meta_link = ''; }
	if (empty($ff_meta_link_target)) { $ff_meta_link_target = '_self'; }
	if (empty($ff_meta_link_label)) { $ff_meta_link_label = 'Visit Website'; }
	
	

	echo '<div class="ff-link">
	
		 <div class="field-row">
		 <label for="ff_meta_link_type">'.__('Link Type:', FF_PLG_NAME).'</label> 
         <select name="ff_meta_link_type" id="ff_meta_link_type">';
		 if($ff_meta_link_type == 'none'){ echo '<option value="none" selected="selected">None</option>'; }else{ echo '<option value="none">None</option>'; }
		 //if($ff_meta_link_type == 'post'){ echo '<option value="post" selected="selected">Permalink</option>'; }else{ echo '<option value="post">Permalink</option>'; }
		 if($ff_meta_link_type == 'url'){ echo '<option value="url" selected="selected">Custom Url</option>'; }else{ echo '<option value="url">Custom Url</option>'; }
	echo '</select>
		 </div>
		
		 <div class="field-row" id="ff_meta_link_wrap" style="display:none;">
         <label for="ff_meta_link">'.__('Custom Url:', FF_PLG_NAME).'</label> 
		 <input name="ff_meta_link" id="ff_meta_link" type="text" value="'.$ff_meta_link.'">
		 </div>

		 <div class="field-row">
		 <label for="ff_meta_link_target">'.__('Link Target:', FF_PLG_NAME).'</label> 
         <select name="ff_meta_link_target" id="ff_meta_link_target">';
		 if($ff_meta_link_type == '_self'){ echo '<option value="_self" selected="selected">Same Window</option>'; }else{ echo '<option value="_self">Same Window</option>'; }
		 if($ff_meta_link_type == '_blank'){ echo '<option value="_blank" selected="selected">New Window</option>'; }else{ echo '<option value="_blank">New Window</option>'; }
	echo '</select>
		 </div>	
		 
		 <div class="field-row" id="ff_meta_link_label_wrap">
         <label for="ff_meta_link_label">'.__('Button Label:', FF_PLG_NAME).'</label> 
		 <input name="ff_meta_link_label" id="ff_meta_link_label" type="text" value="'.$ff_meta_link_label.'">
		 </div>
	
		 </div>';
		 	
}


// EXTRA FIELDS
function ff_extra_metafields() { 

	global $post;	
		
	// Get all post meta saved	
	
	$ff_meta_icon1 = get_post_meta($post->ID, 'ff_meta_icon1', true);
	$ff_meta_icon2 = get_post_meta($post->ID, 'ff_meta_icon2', true);
	$ff_meta_icon3 = get_post_meta($post->ID, 'ff_meta_icon3', true);
	$ff_meta_icon4 = get_post_meta($post->ID, 'ff_meta_icon4', true);
	$ff_meta_icon5 = get_post_meta($post->ID, 'ff_meta_icon5', true);
	
	$ff_meta_label1 = get_post_meta($post->ID, 'ff_meta_label1', true);
	$ff_meta_label2 = get_post_meta($post->ID, 'ff_meta_label2', true);
	$ff_meta_label3 = get_post_meta($post->ID, 'ff_meta_label3', true);
	$ff_meta_label4 = get_post_meta($post->ID, 'ff_meta_label4', true);
	$ff_meta_label5 = get_post_meta($post->ID, 'ff_meta_label5', true);
	
	$ff_meta_value1 = get_post_meta($post->ID, 'ff_meta_value1', true);
	$ff_meta_value2 = get_post_meta($post->ID, 'ff_meta_value2', true);
	$ff_meta_value3 = get_post_meta($post->ID, 'ff_meta_value3', true);
	$ff_meta_value4 = get_post_meta($post->ID, 'ff_meta_value4', true);
	$ff_meta_value5 = get_post_meta($post->ID, 'ff_meta_value5', true);
	
	// Set a default value if empty	
	if (empty($ff_meta_label1)) { $ff_meta_label1 = ''; }
	if (empty($ff_meta_label2)) { $ff_meta_label2 = ''; }
	if (empty($ff_meta_label3)) { $ff_meta_label3 = ''; }
	if (empty($ff_meta_label4)) { $ff_meta_label4 = ''; }
	if (empty($ff_meta_label5)) { $ff_meta_label5 = ''; }
	
	if (empty($ff_meta_value1)) { $ff_meta_value1 = ''; }
	if (empty($ff_meta_value2)) { $ff_meta_value2 = ''; }
	if (empty($ff_meta_value3)) { $ff_meta_value3 = ''; }
	if (empty($ff_meta_value4)) { $ff_meta_value4 = ''; }
	if (empty($ff_meta_value5)) { $ff_meta_value5 = ''; }
	

	echo '<div class="ff-extra">
		 
		 <div class="field-row">
		 <label for="ff_meta_label1">'.__('Label 1:', FF_PLG_NAME).'</label>  
         
		 <select id="ff_meta_icon1" name="ff_meta_icon1">
		 <option value="0">None</option>';		 
		 ff_icon_select_options($ff_meta_icon1);		 
		 echo '</select>
		 
		 <input name="ff_meta_label1" id="ff_meta_label1" type="text" value="'.$ff_meta_label1.'"> 
		 </div>
		 <div class="field-row">
		 <label for="ff_meta_value1">'.__('Value 1:', FF_PLG_NAME).'</label>
         <textarea name="ff_meta_value1" id="ff_meta_value1" class="medium-text code">'.$ff_meta_value1.'</textarea> 
		 </div>
		 
		 <div class="field-row">
		 <label for="ff_meta_label2">'.__('Label 2:', FF_PLG_NAME).'</label>  
         
		 <select id="ff_meta_icon2" name="ff_meta_icon2">
		 <option value="0">None</option>';		 
		 ff_icon_select_options($ff_meta_icon2);		 
		 echo '</select>
		 
		 <input name="ff_meta_label2" id="ff_meta_label2" type="text" value="'.$ff_meta_label2.'"> 
		 </div>
		 <div class="field-row">
		 <label for="ff_meta_value2">'.__('Value 2:', FF_PLG_NAME).'</label>  
         <textarea name="ff_meta_value2" id="ff_meta_value2" class="medium-text code">'.$ff_meta_value2.'</textarea> 
		 </div>
		 
		 <div class="field-row">
		 <label for="ff_meta_label3">'.__('Label 3:', FF_PLG_NAME).'</label>  
         
		 <select id="ff_meta_icon3" name="ff_meta_icon3">
		 <option value="0">None</option>';		 
		 ff_icon_select_options($ff_meta_icon3);		 
		 echo '</select> 
		 
		 <input name="ff_meta_label3" id="ff_meta_label3" type="text" value="'.$ff_meta_label3.'"> 
		 </div>
		 <div class="field-row">
		 <label for="ff_meta_value3">'.__('Value 3:', FF_PLG_NAME).'</label>  
         <textarea name="ff_meta_value3" id="ff_meta_value3" class="medium-text code">'.$ff_meta_value3.'</textarea> 
		 </div>

		 <div class="field-row">
		 <label for="ff_meta_label4">'.__('Label 4:', FF_PLG_NAME).'</label>  
         
		 <select id="ff_meta_icon4" name="ff_meta_icon4">
		 <option value="0">None</option>';		 
		 ff_icon_select_options($ff_meta_icon4);		 
		 echo '</select>
		 
		 <input name="ff_meta_label4" id="ff_meta_label4" type="text" value="'.$ff_meta_label4.'"> 
		 </div>
		 <div class="field-row">
		 <label for="ff_meta_value4">'.__('Value 4:', FF_PLG_NAME).'</label>  
         <textarea name="ff_meta_value4" id="ff_meta_value4" class="medium-text code">'.$ff_meta_value4.'</textarea> 
		 </div>
		 
		 <div class="field-row">
		 <label for="ff_meta_label5">'.__('Label 5:', FF_PLG_NAME).'</label>  
         
		 <select id="ff_meta_icon5" name="ff_meta_icon5">
		 <option value="0">None</option>';		 
		 ff_icon_select_options($ff_meta_icon5);		 
		 echo '</select>
		 
		 <input name="ff_meta_label5" id="ff_meta_label5" type="text" value="'.$ff_meta_label5.'"> 
		 </div>
		 <div class="field-row">
		 <label for="ff_meta_value5">'.__('Value 5:', FF_PLG_NAME).'</label>  
         <textarea name="ff_meta_value5" id="ff_meta_value5" class="medium-text code">'.$ff_meta_value5.'</textarea> 
		 </div>
		 <br>
		 
		 '.__('<em>(Each field you leave blank will be disabled)</em>', FF_PLG_NAME).'
		 
		 </div>';
	
}


// SOCIAL FIELDS
function ff_social_metafields() { 

	global $post;	
		
	// Get all post meta saved	
	$ff_meta_facebook = get_post_meta($post->ID, 'ff_meta_facebook', true);
	$ff_meta_twitter = get_post_meta($post->ID, 'ff_meta_twitter', true);
	$ff_meta_linkedin = get_post_meta($post->ID, 'ff_meta_linkedin', true);
	$ff_meta_pinterest = get_post_meta($post->ID, 'ff_meta_pinterest', true);

	
	

	echo '<div class="ff-social">
	
		 <div class="field-row">
		 <label for="ff_meta_facebook">'.__('Facebook:', FF_PLG_NAME).'</label>  
         <input name="ff_meta_facebook" id="ff_meta_facebook" type="checkbox" value="1"';
		 if ($ff_meta_facebook == 1) {echo 'checked="checked"';}
	echo '>
		 </div>
		 
		 <div class="field-row">
		 <label for="ff_meta_twitter">'.__('Twitter:', FF_PLG_NAME).'</label>  
         <input name="ff_meta_twitter" id="ff_meta_twitter" type="checkbox" value="1"';
		 if ($ff_meta_twitter == 1) {echo 'checked="checked"';}
	echo '>
		 </div>
		 
		 <div class="field-row">
		 <label for="ff_meta_linkedin">'.__('Linkedin:', FF_PLG_NAME).'</label>  
         <input name="ff_meta_linkedin" id="ff_meta_linkedin" type="checkbox" value="1"';
		 if ($ff_meta_linkedin == 1) {echo 'checked="checked"';}
	echo '>
		 </div>
		 
		 <div class="field-row">
		 <label for="ff_meta_pinterest">'.__('Pinterest:', FF_PLG_NAME).'</label>  
         <input name="ff_meta_pinterest" id="ff_meta_pinterest" type="checkbox" value="1"';
		 if ($ff_meta_pinterest == 1) {echo 'checked="checked"';}
	echo '>
		 </div>
		 
		 </div>';
	
	
}



// TEMPLATES FIELD 
function ff_templates_metafields() { 

	global $post;
	
	
	// Get template value
	$ff_template_field = get_post_meta($post->ID, 'ff_template_field', true);
	

	echo '<select id="ff_template_field" name="ff_template_field">
			<option value="disabled" '; if( $ff_template_field == 'disabled' || empty($ff_template_field) ) { echo 'selected'; } echo '>Disabled</option>
			<option value="main" '; if( $ff_template_field == 'main' ) { echo 'selected'; } echo '>Main</option>
		  </select>';
		 	
}


// SAVE METABOXES & METAFIELDS

add_action('save_post', 'ff_save_meta');

function ff_save_meta($post_id, $post = null) {	
	
	
	// FORMAT FIELDS
	
	if ( isset( $_REQUEST['ff_meta_video_type'] ) ) {
	
	$ff_meta_video_type = $_REQUEST['ff_meta_video_type'];	
	update_post_meta($post_id, 'ff_meta_video_type', $ff_meta_video_type);
	
	}
	
	if ( isset( $_REQUEST['ff_meta_video_id'] ) ) {
	
	$ff_meta_video_id = $_REQUEST['ff_meta_video_id'];	
	update_post_meta($post_id, 'ff_meta_video_id', $ff_meta_video_id);
	
	}
	
	if ( isset( $_REQUEST['ff_meta_audio_code'] ) ) {
	
	$ff_meta_audio_code = $_REQUEST['ff_meta_audio_code'];	
	update_post_meta($post_id, 'ff_meta_audio_code', $ff_meta_audio_code);
	
	}
	
	
	// URL FIELDS
	
	if ( isset( $_REQUEST['ff_meta_link_type'] ) ) {	
	update_post_meta($post_id, 'ff_meta_link_type', $_REQUEST['ff_meta_link_type']);
	}
	if ( isset( $_REQUEST['ff_meta_link'] ) ) {	
	update_post_meta($post_id, 'ff_meta_link', $_REQUEST['ff_meta_link']);
	}
	if ( isset( $_REQUEST['ff_meta_link_target'] ) ) {	
	update_post_meta($post_id, 'ff_meta_link_target', $_REQUEST['ff_meta_link_target']);
	}
	if ( isset( $_REQUEST['ff_meta_link_label'] ) ) {	
	update_post_meta($post_id, 'ff_meta_link_label', $_REQUEST['ff_meta_link_label']);
	}
	
	
	// EXTRA FIELDS
	
	if ( isset( $_REQUEST['ff_meta_icon1'] ) ) {	
	update_post_meta($post_id, 'ff_meta_icon1', $_REQUEST['ff_meta_icon1']);
	}
	if ( isset( $_REQUEST['ff_meta_icon2'] ) ) {	
	update_post_meta($post_id, 'ff_meta_icon2', $_REQUEST['ff_meta_icon2']);
	}
	if ( isset( $_REQUEST['ff_meta_icon3'] ) ) {	
	update_post_meta($post_id, 'ff_meta_icon3', $_REQUEST['ff_meta_icon3']);
	}
	if ( isset( $_REQUEST['ff_meta_icon4'] ) ) {	
	update_post_meta($post_id, 'ff_meta_icon4', $_REQUEST['ff_meta_icon4']);
	}
	if ( isset( $_REQUEST['ff_meta_icon5'] ) ) {	
	update_post_meta($post_id, 'ff_meta_icon5', $_REQUEST['ff_meta_icon5']);
	}
	
	
	if ( isset( $_REQUEST['ff_meta_label1'] ) ) {	
	update_post_meta($post_id, 'ff_meta_label1',  htmlentities($_REQUEST['ff_meta_label1']));
	}
	if ( isset( $_REQUEST['ff_meta_label2'] ) ) {	
	update_post_meta($post_id, 'ff_meta_label2',  htmlentities($_REQUEST['ff_meta_label2']));
	}
	if ( isset( $_REQUEST['ff_meta_label3'] ) ) {	
	update_post_meta($post_id, 'ff_meta_label3',  htmlentities($_REQUEST['ff_meta_label3']));
	}
	if ( isset( $_REQUEST['ff_meta_label4'] ) ) {	
	update_post_meta($post_id, 'ff_meta_label4',  htmlentities($_REQUEST['ff_meta_label4']));
	}
	if ( isset( $_REQUEST['ff_meta_label5'] ) ) {	
	update_post_meta($post_id, 'ff_meta_label5',  htmlentities($_REQUEST['ff_meta_label5']));
	}
	
	
	if ( isset( $_REQUEST['ff_meta_value1'] ) ) {	
	update_post_meta($post_id, 'ff_meta_value1', htmlentities($_REQUEST['ff_meta_value1']));
	}
	if ( isset( $_REQUEST['ff_meta_value2'] ) ) {	
	update_post_meta($post_id, 'ff_meta_value2', htmlentities($_REQUEST['ff_meta_value2']));
	}
	if ( isset( $_REQUEST['ff_meta_value3'] ) ) {	
	update_post_meta($post_id, 'ff_meta_value3', htmlentities($_REQUEST['ff_meta_value3']));
	}
	if ( isset( $_REQUEST['ff_meta_value4'] ) ) {	
	update_post_meta($post_id, 'ff_meta_value4', htmlentities($_REQUEST['ff_meta_value4']));
	}
	if ( isset( $_REQUEST['ff_meta_value5'] ) ) {	
	update_post_meta($post_id, 'ff_meta_value5', htmlentities($_REQUEST['ff_meta_value5']));
	}
	
	
	// SOCIAL FIELDS
	
	if ( isset( $_REQUEST['ff_meta_facebook'] ) ) {	
		update_post_meta($post_id, 'ff_meta_facebook', $_REQUEST['ff_meta_facebook']);
	}else{
		delete_post_meta($post_id, 'ff_meta_facebook');
	}
	
	if ( isset( $_REQUEST['ff_meta_twitter'] ) ) {	
		update_post_meta($post_id, 'ff_meta_twitter', $_REQUEST['ff_meta_twitter']);
	}else{
		delete_post_meta($post_id, 'ff_meta_twitter');
	}
	
	if ( isset( $_REQUEST['ff_meta_linkedin'] ) ) {	
		update_post_meta($post_id, 'ff_meta_linkedin', $_REQUEST['ff_meta_linkedin']);
	}else{
		delete_post_meta($post_id, 'ff_meta_linkedin');
	}
	
	if ( isset( $_REQUEST['ff_meta_pinterest'] ) ) {	
		update_post_meta($post_id, 'ff_meta_pinterest', $_REQUEST['ff_meta_pinterest']);
	}else{
		delete_post_meta($post_id, 'ff_meta_pinterest');
	}
	
	// TEMPLATE FIELD
	
	if ( isset( $_REQUEST['ff_template_field'] ) ) {
		
	$ff_template_field = $_REQUEST['ff_template_field'];	
	update_post_meta($post_id, 'ff_template_field', sanitize_text_field($ff_template_field));
	
	}
	
	
}
