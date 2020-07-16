/* 
File: assets/js/backend.js
Description: JS Script for Backend
Plugin: FlatFolio
Author: Alessio Marzo
*/

jQuery(document).ready(function($) {
	
	// Default Format Selection
	if ( $( '.post-type-flatfolio #post-format-video' ).attr( "checked" ) != "checked" && $( '.post-type-flatfolio #post-format-audio' ).attr( "checked" ) != "checked" ) {
		
		$( '.post-type-flatfolio #post-format-image' ).attr( "checked", "checked" );
		$('.post-type-flatfolio .ff-image-format').show();
	
	}
	
	// Display Right Format
	if ( $('.post-type-flatfolio #post-format-video' ).attr( "checked" ) == "checked" ) {
		$('.post-type-flatfolio .ff-video-format').show();
		$('.post-type-flatfolio .ff-image-format').hide();
		$('.post-type-flatfolio .ff-audio-format').hide();
	}
	if ( $('.post-type-flatfolio #post-format-audio' ).attr( "checked" ) == "checked" ) {
		$('.post-type-flatfolio .ff-audio-format').show();
		$('.post-type-flatfolio .ff-video-format').hide();
		$('.post-type-flatfolio .ff-image-format').hide();
	}
	
	
	// Change on Selecting Format
	$('.post-type-flatfolio #post-formats-select input[type=radio][name=post_format]').change(function() {
		
		if(this.value == 'image') {
			$('.post-type-flatfolio .ff-image-format').show();
			$('.post-type-flatfolio .ff-video-format').hide();
			$('.post-type-flatfolio .ff-audio-format').hide();
		}
		
		if(this.value == 'video') {
			$('.post-type-flatfolio .ff-video-format').show();
			$('.post-type-flatfolio .ff-image-format').hide();
			$('.post-type-flatfolio .ff-audio-format').hide();
		}
		
		if(this.value == 'audio') {
			$('.post-type-flatfolio .ff-audio-format').show();
			$('.post-type-flatfolio .ff-image-format').hide();
			$('.post-type-flatfolio .ff-video-format').hide();
		}
		
	});
	
	
	// Custom URL field
	if( $('.post-type-flatfolio #ff_meta_link_type').val() == 'url' ){ $('.post-type-flatfolio #ff_meta_link_wrap').show(); }
	$('.post-type-flatfolio #ff_meta_link_type').change(function() {
		
		if(this.value == 'url') {
			$('.post-type-flatfolio #ff_meta_link_wrap').show();
		}else{
			$('.post-type-flatfolio #ff_meta_link_wrap').hide();
		}
		
	});
	
}); 