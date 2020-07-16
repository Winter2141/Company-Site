<?php
/*
File: inc/posttypes/books.php
Description: Register FlatFolio Post Type
Plugin: FlatFolio
Author: Alessio Marzo
*/


// Post Type Registration
add_action( 'init', 'ff_flatfolio_register_posttype' );

function ff_flatfolio_register_posttype() {

	$labels = array(
		'name'               => __('FlatFolio Projects', FF_PLG_NAME),
		'singular_name'      => __('Project', FF_PLG_NAME),
		'add_new'            => __('Add New', FF_PLG_NAME),
		'add_new_item'       => __('Add New Project', FF_PLG_NAME),
		'edit_item'          => __('Edit Project', FF_PLG_NAME),
		'new_item'           => __('New Project', FF_PLG_NAME),
		'all_items'          => __('All Projects', FF_PLG_NAME),
		'view_item'          => __('View Project', FF_PLG_NAME),
		'search_items'       => __('Search Projects', FF_PLG_NAME),
		'not_found'          => __('No project found', FF_PLG_NAME),
		'not_found_in_trash' => __('No project found in Trash', FF_PLG_NAME),
		'parent_item_colon'  => '',
		'menu_name'          => __('FlatFolio', FF_PLG_NAME)
	  );
	
	  $args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'flatfolio' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => FF_URL.'assets/img/flatfolio_icon.png',
		'supports'           => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'post-formats' )
	  );
	
	  register_post_type( 'flatfolio', $args );

}


// Register thumb column
function ff_thumb_column_register( $columns ) {
	$columns['thumb'] = __( 'Thumb', 'mvafsp' );
	return $columns;
}
add_filter( 'manage_edit-flatfolio_columns', 'ff_thumb_column_register' );


// Display thumb column content
function ff_thumb_column_display( $column_name, $post_id ) {
	if ( 'thumb' != $column_name )
		return;
		
 	echo get_the_post_thumbnail($post_id, 'ff-admin-thumb');
	
}
add_action( 'manage_flatfolio_posts_custom_column', 'ff_thumb_column_display', 10, 2 );



// Taxonomy Registration
add_action( 'init', 'ff_flatfolio_register_taxonomy', 0 );

function ff_flatfolio_register_taxonomy() {
	
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => __( 'Categories', FF_PLG_NAME),
		'singular_name'     => __( 'Category', FF_PLG_NAME),
		'search_items'      => __( 'Search Categories', FF_PLG_NAME),
		'all_items'         => __( 'All Categories', FF_PLG_NAME),
		'parent_item'       => __( 'Parent Category', FF_PLG_NAME),
		'parent_item_colon' => __( 'Parent Category:', FF_PLG_NAME),
		'edit_item'         => __( 'Edit Category', FF_PLG_NAME),
		'update_item'       => __( 'Update Category', FF_PLG_NAME),
		'add_new_item'      => __( 'Add New Category', FF_PLG_NAME),
		'new_item_name'     => __( 'New Genre Category', FF_PLG_NAME),
		'menu_name'         => __( 'Categories', FF_PLG_NAME),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'flatfolio-categories' ),
	);

	register_taxonomy( 'flatfolio-categories', array( 'flatfolio' ), $args );
	
	
}



// Post Type custom messages
add_filter( 'post_updated_messages', 'ff_flatfolio_custom_messages' );

function ff_flatfolio_custom_messages( $messages ) {
	
  global $post, $post_ID;

  $messages['flatfolio'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Project updated. <a href="%s">View project</a>', FF_PLG_NAME), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', FF_PLG_NAME),
    3 => __('Custom field deleted.', FF_PLG_NAME),
    4 => __('Project updated.', FF_PLG_NAME),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Project restored to revision from %s', FF_PLG_NAME), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Project published. <a href="%s">View project</a>', FF_PLG_NAME), esc_url( get_permalink($post_ID) ) ),
    7 => __('Project saved.', FF_PLG_NAME),
    8 => sprintf( __('Project submitted. <a target="_blank" href="%s">Preview project</a>', FF_PLG_NAME), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>', FF_PLG_NAME),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i', FF_PLG_NAME ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Project draft updated. <a target="_blank" href="%s">Preview project</a>', FF_PLG_NAME), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
  
}



// Post Type Contextual Help
add_action( 'contextual_help', 'ff_flatfolio_contextual_help', 10, 3 );

function ff_flatfolio_contextual_help( $contextual_help, $screen_id, $screen ) {
	
  if ( 'flatfolio' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a book:', FF_PLG_NAME) . '</p>' .
      '<ul>' .
      '<li>' . __('Specify the correct genre such as Mystery, or Historic.', FF_PLG_NAME) . '</li>' .
      '<li>' . __('Specify the correct writer of the book.  Remember that the Author module refers to you, the author of this book review.', FF_PLG_NAME) . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the book review to be published in the future:', FF_PLG_NAME) . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.', FF_PLG_NAME) . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.', FF_PLG_NAME) . '</li>' .
      '</ul>' .
      '<p><strong>' . __('For more information:', FF_PLG_NAME) . '</strong></p>' .
      '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>', FF_PLG_NAME) . '</p>' .
      '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', FF_PLG_NAME) . '</p>' ;
  } elseif ( 'edit-book' == $screen->id ) {
    $contextual_help =
      '<p>' . __('This is the help screen displaying the table of books blah blah blah.', FF_PLG_NAME) . '</p>' ;
  }
  return $contextual_help;
  
}

// Books's Options page function
function ff_flatfolio_options() {
	
	$ff_opt_custom_css = get_option('ff_opt_custom_css');
	
	if (isset($_REQUEST['ff_opt_custom_css'])) {
		
		$ff_opt_custom_css = $_REQUEST['ff_opt_custom_css'];
		
		update_option('ff_opt_custom_css', $ff_opt_custom_css);
		
	}
	
	if (empty($ff_opt_custom_css)) {
		
		$ff_opt_custom_css = ' 
/* Grid Classes */	
	
.og-grid { }

.og-grid li { }

.og-grid li img.attachment-ff-grid-thumb { }

.og-grid li .og-caption { }


.og-grid li:hover img.attachment-ff-grid-thumb{ }

.og-grid li > a,
.og-grid li > a img { }

.og-grid li.og-expanded > a::after { }

.og-expander { }

.og-expander-inner { }

.og-close { }

.og-close::before,
.og-close::after { }

.og-close::after { }

.og-close:hover::before,
.og-close:hover::after { }

.og-fullimg,
.og-video,
.og-audio,
.og-details,
.og-extra { }

.og-fullimg,
.og-video,
.og-audio { }

.og-details { }

.og-extra { }

.og-details { }

.og-fullimg { }

.og-fullimg img { }

.og-details h3 { }

.og-details p { }

.og-details a.ff-link {  }

.og-details a.ff-link:before { }

.og-details a:hover { }

.extra1, .extra2, .extra3, .extra4, .extra5 { }

.og-extra .extralabel { }

.og-extra .extravalue { }

.og-loading { }

.og-lightbox-overlay { }

.og-close-overlay { }

.og-close-overlay::before,
.og-close-overlay::after { }

.og-close-overlay::after { }

.og-close-overlay:hover::before,
.og-close-overlay:hover::after { }


.admin-bar .og-lightbox-overlay .og-close-overlay { }

.og-show { }

.og-fullimage { }

.ff-icon-facebook10, 
.ff-icon-twitter8, 
.ff-icon-linkedin5, 
.ff-icon-pinterest5 { }

.og-filter { }

.og-filter button { }

.og-filter button:hover { }

.og-filter button.filter-selected { }

';
	
	}
	
	echo '<div class="wrap"><h2>FlatFolio Options</h2>';
	
	echo '<h3>Compatibility</h3>';
	
	echo '<form method="post">';
	
	echo '<textarea id="ff_opt_custom_css" name="ff_opt_custom_css" class="xlarge">'.$ff_opt_custom_css.'</textarea>';
	
	echo '<br><br><input type="submit" class="button button-primary" name ="submit" id="submit" value="'.__('Save', FF_PLG_NAME).'">';
	
	echo '</form>';
	
	echo '</div>';
	
}
