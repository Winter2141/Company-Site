<?php
/*
File: inc/functions.php
Description: Plugin functions
Plugin: FlatFolio
Author: Alessio Marzo
*/


// INCLUDE MEGA-FUNCTIONS FRAMEWORK
require_once(FF_DIR.'inc/mega-functions.php');


// Admin thumb size
add_image_size( 'ff-admin-thumb', 50, 50, true );

// Grid thumb size
add_image_size( 'ff-grid-thumb', 250, 250, true );

// Preview thumb size
add_image_size( 'ff-preview-thumb', 500, 500, true );

// Project thumb size
add_image_size( 'ff-project-thumb', 800, 600, true );

function ff_adjust_post_formats() {
	
    if (isset($_GET['post'])){
		$post_type = get_post_type($_GET['post']);
	}
	
	if (isset($_GET['post_type'])) {
		$post_type = $_GET['post_type'];
	}
	
	
    if ( isset($post_type) && $post_type == 'flatfolio' ) {		
        add_theme_support( 'post-formats', array( 'image', 'video', 'audio' ) );
	}
   
}
add_action( 'load-post.php','ff_adjust_post_formats' );
add_action( 'load-post-new.php','ff_adjust_post_formats' );


// Icons Array
function ff_icons_array() {
	
	return array('ff-icon-phone16', 'ff-icon-mobile9', 'ff-icon-mouse6', 'ff-icon-directions2', 'ff-icon-mail9', 'ff-icon-paperplane2', 'ff-icon-pencil11', 'ff-icon-feather3', 'ff-icon-paperclip6', 'ff-icon-drawer4', 'ff-icon-reply5', 'ff-icon-reply-all2', 'ff-icon-forward9', 'ff-icon-user19', 'ff-icon-users8', 'ff-icon-user-add2', 'ff-icon-vcard2', 'ff-icon-export2', 'ff-icon-location10', 'ff-icon-map6', 'ff-icon-compass10', 'ff-icon-location11', 'ff-icon-target8', 'ff-icon-share9', 'ff-icon-sharable', 'ff-icon-heart15', 'ff-icon-heart16', 'ff-icon-star13', 'ff-icon-star14', 'ff-icon-thumbs-up8', 'ff-icon-thumbs-down6', 'ff-icon-chat11', 'ff-icon-comment10', 'ff-icon-quote5', 'ff-icon-house', 'ff-icon-popup2', 'ff-icon-search11', 'ff-icon-flashlight2', 'ff-icon-printer5', 'ff-icon-bell5', 'ff-icon-link9', 'ff-icon-flag9', 'ff-icon-cog11', 'ff-icon-tools2', 'ff-icon-trophy5', 'ff-icon-tag12', 'ff-icon-camera20', 'ff-icon-megaphone5', 'ff-icon-moon7', 'ff-icon-palette2', 'ff-icon-leaf5', 'ff-icon-music9', 'ff-icon-music10', 'ff-icon-new', 'ff-icon-graduation', 'ff-icon-book12', 'ff-icon-newspaper6', 'ff-icon-bag5', 'ff-icon-airplane3', 'ff-icon-lifebuoy', 'ff-icon-eye10', 'ff-icon-clock12', 'ff-icon-microphone11', 'ff-icon-calendar14', 'ff-icon-bolt5', 'ff-icon-thunder', 'ff-icon-droplet4', 'ff-icon-cd4', 'ff-icon-briefcase8', 'ff-icon-air', 'ff-icon-hourglass3', 'ff-icon-gauge', 'ff-icon-language', 'ff-icon-network2', 'ff-icon-key10', 'ff-icon-battery9', 'ff-icon-bucket3', 'ff-icon-magnet5', 'ff-icon-drive', 'ff-icon-cup5', 'ff-icon-rocket5', 'ff-icon-brush5', 'ff-icon-suitcase6', 'ff-icon-cone4', 'ff-icon-earth6', 'ff-icon-keyboard9', 'ff-icon-browser4', 'ff-icon-publish', 'ff-icon-progress-3', 'ff-icon-progress-2', 'ff-icon-brogress-1', 'ff-icon-progress-0', 'ff-icon-sun8', 'ff-icon-sun9', 'ff-icon-adjust2', 'ff-icon-code5', 'ff-icon-screen5', 'ff-icon-infinity3', 'ff-icon-light-bulb2', 'ff-icon-credit-card3', 'ff-icon-database4', 'ff-icon-voicemail', 'ff-icon-clipboard9', 'ff-icon-cart7', 'ff-icon-box5', 'ff-icon-ticket8', 'ff-icon-rss5', 'ff-icon-signal3', 'ff-icon-thermometer4', 'ff-icon-droplets', 'ff-icon-uniF7C32', 'ff-icon-statistics', 'ff-icon-pie2', 'ff-icon-bars5', 'ff-icon-graph2', 'ff-icon-lock8', 'ff-icon-lock-open2', 'ff-icon-logout', 'ff-icon-login', 'ff-icon-checkmark10', 'ff-icon-cross3', 'ff-icon-minus11', 'ff-icon-plus10', 'ff-icon-cross4', 'ff-icon-minus12', 'ff-icon-plus11', 'ff-icon-cross5', 'ff-icon-minus13', 'ff-icon-plus12', 'ff-icon-erase', 'ff-icon-blocked4', 'ff-icon-info12', 'ff-icon-info13', 'ff-icon-question5', 'ff-icon-help2', 'ff-icon-warning5', 'ff-icon-cycle', 'ff-icon-cw', 'ff-icon-ccw', 'ff-icon-shuffle4', 'ff-icon-arrow', 'ff-icon-arrow2', 'ff-icon-retweet3', 'ff-icon-loop6', 'ff-icon-history2', 'ff-icon-back2', 'ff-icon-switch7', 'ff-icon-list13', 'ff-icon-add-to-list', 'ff-icon-layout15', 'ff-icon-list14', 'ff-icon-text', 'ff-icon-text2', 'ff-icon-document3', 'ff-icon-docs', 'ff-icon-landscape', 'ff-icon-pictures6', 'ff-icon-video6', 'ff-icon-music11', 'ff-icon-folder7', 'ff-icon-archive10', 'ff-icon-trash7', 'ff-icon-upload10', 'ff-icon-download13', 'ff-icon-disk3', 'ff-icon-install2', 'ff-icon-cloud17', 'ff-icon-upload11', 'ff-icon-bookmark13', 'ff-icon-bookmarks2', 'ff-icon-book13', 'ff-icon-play10', 'ff-icon-pause8', 'ff-icon-record2', 'ff-icon-stop9', 'ff-icon-next4', 'ff-icon-previous4', 'ff-icon-first3', 'ff-icon-last3', 'ff-icon-resize-enlarge', 'ff-icon-resize-shrink', 'ff-icon-volume10', 'ff-icon-sound3', 'ff-icon-mute3', 'ff-icon-flow-cascade', 'ff-icon-flow-branch', 'ff-icon-flow-tree', 'ff-icon-flow-line', 'ff-icon-flow-parallel2', 'ff-icon-arrow-left9', 'ff-icon-arrow-down9', 'ff-icon-arrow-up--upload', 'ff-icon-arrow-right9', 'ff-icon-arrow-left10', 'ff-icon-arrow-down10', 'ff-icon-arrow-up9', 'ff-icon-arrow-right10', 'ff-icon-arrow-left11', 'ff-icon-arrow-down11', 'ff-icon-arrow-up10', 'ff-icon-arrow-right11', 'ff-icon-arrow-left12', 'ff-icon-arrow-down12', 'ff-icon-arrow-up11', 'ff-icon-arrow-right12', 'ff-icon-arrow-left13', 'ff-icon-arrow-down13', 'ff-icon-arrow-up12', 'ff-icon-arrow-right13', 'ff-icon-arrow-left14', 'ff-icon-arrow-down14', 'ff-icon-arrow-up13', 'ff-icon-arrow-right14', 'ff-icon-arrow-left15', 'ff-icon-arrow-down15', 'ff-icon-arrow-up14', 'ff-icon-uniF82D', 'ff-icon-arrow-left16', 'ff-icon-arrow-down16', 'ff-icon-arrow-up15', 'ff-icon-arrow-right15', 'ff-icon-menu5', 'ff-icon-ellipsis', 'ff-icon-dots', 'ff-icon-dot', 'ff-icon-cc', 'ff-icon-cc-by', 'ff-icon-cc-nc', 'ff-icon-cc-nc-eu', 'ff-icon-cc-nc-jp', 'ff-icon-cc-sa', 'ff-icon-cc-nd', 'ff-icon-cc-pd', 'ff-icon-cc-zero', 'ff-icon-cc-share', 'ff-icon-cc-share2', 'ff-icon-daniel-bruce', 'ff-icon-daniel-bruce2', 'ff-icon-github8', 'ff-icon-github9', 'ff-icon-flickr7', 'ff-icon-flickr8', 'ff-icon-vimeo4', 'ff-icon-vimeo5', 'ff-icon-twitter7', 'ff-icon-twitter8', 'ff-icon-facebook9', 'ff-icon-facebook10', 'ff-icon-facebook11', 'ff-icon-googleplus3', 'ff-icon-googleplus4', 'ff-icon-pinterest4', 'ff-icon-pinterest5', 'ff-icon-tumblr5', 'ff-icon-tumblr6', 'ff-icon-linkedin4', 'ff-icon-linkedin5', 'ff-icon-dribbble8', 'ff-icon-dribbble9', 'ff-icon-stumbleupon4', 'ff-icon-stumbleupon5', 'ff-icon-lastfm4', 'ff-icon-lastfm5', 'ff-icon-rdio', 'ff-icon-rdio2', 'ff-icon-spotify', 'ff-icon-spotify2', 'ff-icon-qq', 'ff-icon-instagram6', 'ff-icon-dropbox2', 'ff-icon-evernote2', 'ff-icon-flattr2', 'ff-icon-skype5', 'ff-icon-skype6', 'ff-icon-renren2', 'ff-icon-sina-weibo', 'ff-icon-paypal5', 'ff-icon-picasa', 'ff-icon-soundcloud3', 'ff-icon-mixi', 'ff-icon-behance', 'ff-icon-circles', 'ff-icon-vk2', 'ff-icon-smashing');

}


// Generate Icons options for select tags
function ff_icon_select_options( $selected ) {
	
	$icons = ff_icons_array();
	foreach($icons as $icon){
		if($icon == $selected) {
			echo '<option value="'.$icon.'" class="'.$icon.'" selected="selected"> '.$icon.'</option>';
		}else{
			echo '<option value="'.$icon.'" class="'.$icon.'"> '.$icon.'</option>';
		}
	}
	
}
