<?php
/*
File: inc/mega-functions.php
Description: WEBSELF's personal functions framework
Plugin: FlatFolio
Author: Alessio Marzo
*/


// SANITIZE A STRING TO A SAFE STRING WITHOUT SPECIAL CHARS AND SPACES (useful for files name)
// Return: Cleaned String

function ff_sanitize_string($string) {
	
	// Remove special accented characters - ie. sí.
	$clean_name = strtr($string, 'ŠŽšžŸÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïñòóôõöøùúûüýÿ', 'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy');
	
	$clean_name = strtr($clean_name, array('Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss', 'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u'));
	
	$clean_name = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $clean_name);
	
	$clean_name = strtolower($clean_name);
	
	return $clean_name;
	
}


// CHECK IF GENERIC URL EXISTS
// Return: TRUE/FALSE

function ff_url_exists($url) {
	
$a_url = parse_url($url);

if (!isset($a_url['port'])) {
	
	$a_url['port'] = 80;
}

$errno = 0;

$errstr = '';

$timeout = 30;

if(isset($a_url['host']) && $a_url['host']!=gethostbyname($a_url['host'])){
	
	$fid = fsockopen($a_url['host'], $a_url['port'], $errno, $errstr, $timeout);

	if (!$fid) return false;
	
	$page = isset($a_url['path']) ?$a_url['path']:'';
	
	$page .= isset($a_url['query'])?'?'.$a_url['query']:'';
	
	fputs($fid, 'HEAD '.$page.' HTTP/1.0'."\r\n".'Host: '.$a_url['host']."\r\n\r\n");
	
	$head = fread($fid, 4096);
	
	fclose($fid);
	
	return preg_match('#^HTTP/.*\s+[200|302]+\s#i', $head);
	
} else {
	
return false;

}

}


// GET TAXONOMY PARENTS FROM A TAXONOMY ID
// Return: List of Categories with a custom separator (ex. maincat/subcat/selected-cat )

function ff_get_taxonomy_parents( $id, $taxonomy = 'category', $link = false, $separator = '/', $nicename = false, $visited = array() ) {

            $chain = '';
            $parent = get_term( $id, $taxonomy );

            if ( is_wp_error( $parent ) )
                    return $parent;

            if ( $nicename )
                    $name = $parent->slug;
            else
                    $name = $parent->name;

            if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {
                    $visited[] = $parent->parent;
                    $chain .= ff_get_taxonomy_parents( $parent->parent, $taxonomy, $link, $separator, $nicename, $visited );
            }

            if ( $link ) {
				if ($parent->parent != 0){
                    $chain .= $separator.'<a href="' . esc_url( get_term_link( $parent,$taxonomy ) ) . '" title="' . esc_attr( sprintf( __( "View all file in %s", FF_PLG_NAME ), $parent->name ) ) . '">'.$name.'</a>';
				}else{
					$chain .= '<a href="' . esc_url( get_term_link( $parent,$taxonomy ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", FF_PLG_NAME ), $parent->name ) ) . '">'.$name.'</a>';
				}
		
					
			}else{
            
            if ($parent->parent != 0){
				$chain .= $separator.$name;
			}else{
				$chain .= $name;
			}
			
			}

            return $chain;
}


// GET TAXONOMY LINK FROM A TAXONOMY ID
// Return: The link of category/term selected

function ff_get_taxonomy_link( $termid, $termslug, $termname, $taxonomy = 'category', $post_type = 'post', $link = true, $backend = false ) {

            $chain = '';
			
			if ($backend == true) {
				
				if($link == true) {
					$chain = "<a href='edit-tags.php?action=edit&taxonomy=$taxonomy&post_type=$post_type&tag_ID={$termid}'> " . esc_html(sanitize_term_field('name', $termname, $termid, 'category', 'display')) . "</a>";
				}else{
					$chain = 'edit-tags.php?action=edit&taxonomy=$taxonomy&post_type=$post_type&tag_ID={$termid}';
				}
				
			}else{
				
				if($link == true) {
					$chain = "<a href='".get_term_link( $termslug, $taxonomy )."'> " . esc_html(sanitize_term_field('name', $termname, $termid, 'category', 'display')) . "</a>";
				}else{
					$chain = get_term_link( $termname, $taxonomy );
				}
				
			}

            return $chain;
}


// GET TAXONOMY CHILDS FROM A TAXONOMY ID
// Return: Array of Categories

function ff_get_taxonomy_childs($id, $taxonomy = 'category', $post_type = 'post') {
	
	$args_sub = array(
		'type'                     => $post_type,
		'orderby'                  => 'name',
		'child_of'                 => $id,
		'order'                    => 'ASC',
		'hide_empty'               => 1,
		'hierarchical'             => true,
		'exclude'                  => '',
		'include'                  => '',
		'number'                   => '',
		'taxonomy'                 => $taxonomy,
		'pad_counts'               => false );
		
		$subcategories = get_categories( $args_sub );
		
		return $subcategories;
		
}


// GET CURRENT URL
// Return: Url of the page where function is called

function ff_get_current_url() {
	
	$pageURL = 'http://';
 
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

	return $pageURL;
  
}

// *************************** //
// START THENE BASIC FUNCTIONS //
// *************************** //

/**
 * Displays navigation to next/previous set of posts when applicable.
 * Echo: Html code
 */
 
function ff_get_pagination() {
	
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="pagination" role="pagination">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', FF_PLG_NAME ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', FF_PLG_NAME ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', FF_PLG_NAME ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}


/*
* Displays navigation to next/previous post when applicable.
* ECHO: Html Code
*/

function ff_get_navigation() {
	
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', FF_PLG_NAME ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', FF_PLG_NAME ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', FF_PLG_NAME ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}


/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 * ECHO: Html code
 */
 
function ff_get_post_meta() {
	
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', FF_PLG_NAME ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		adt_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( ',' );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', ',' );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', FF_PLG_NAME ), get_the_author() ) ),
			get_the_author()
		);
	}
}


/**
 * Prints HTML with date information for current post.
 * ECHO/RETURN: Date information
 */
 
function ff_get_post_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', FF_PLG_NAME );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', FF_PLG_NAME ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}


/*
* Get the thumb url by ID
* RETURN: Url of the thumb
*/

function ff_get_thumbnail_url($postid, $size = null) {
	
	$thumb_id = get_post_thumbnail_id($postid);
	$image_attributes = wp_get_attachment_image_src( $thumb_id, $size ); 
	return $image_attributes[0];
	
}
