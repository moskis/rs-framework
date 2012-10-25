<?php

/**
 * Register and load scripts
 */

function rsf_enqueue_scripts() {
	if ( ! is_admin() ) {

		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' );
		//wp_register_script( 'theme', get_template_directory_uri() . '/js/theme.js', 'jquery', '1.0', TRUE );

		wp_enqueue_script( 'jquery' );
		//wp_enqueue_script( 'theme' );

	}
}
add_action('wp_enqueue_scripts', 'rsf_enqueue_scripts');



/**
 * Add favicon to site and admin area
 */
/*
function rsf_favicon() {
	?>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.png" type="image/png" />
	<?php
}
add_action( 'wp_print_styles', 'rsf_favicon' );
add_action( 'admin_print_styles', 'rsf_favicon' );
*/



/**
 * Configure WP2.9+ Thumbnails
 */
/*
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	//set_post_thumbnail_size( 280, 210, true ); // Normal post thumbnails
	//add_image_size( 'cover-grid', 286, 186, true ); // Cover in 3 cloumn grid view, like portfolio
	//add_image_size( 'cover-small-grid', 164, 123, true ); // Cover in 5 cloumn grid view, like clients, partners
	//add_image_size( 'porfolio-big', 606, '', false ); // Slideshows in portfolio items
}
*/



/**
 * Optional Fixes
 */

// Remove WordPress Galleries inline styles
// add_filter('use_default_gallery_style', '__return_false');


// Shortcodes in the_excerpt()
//add_filter( 'the_excerpt', 'shortcode_unautop');
//add_filter( 'the_excerpt', 'do_shortcode');


// Overwrite the_generator with empty value (hide in html and rss)
function rsf_remove_generator() {
	return '';
}
add_filter( 'the_generator', 'rsf_remove_generator' );


// show admin bar only for admins
/*
if ( ! current_user_can('manage_options') ) {
	add_filter( 'show_admin_bar', '__return_false' );
}
*/


// show admin bar only for admins and editors
/*
if ( ! current_user_can('edit_posts') ) {
	add_filter( 'show_admin_bar', '__return_false' );
}
*/


// Change Excerpt Length
/*
function rsf_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'rsf_excerpt_length' );
*/


// Remove Read More from excerpts
/*
function rsf_new_excerpt_more( $text ) {
	return ' ';
}
add_filter( 'excerpt_more', 'rsf_new_excerpt_more' );
*/


// Save user info to variable for later use in the site
/*
function rsf_current_user() {
	global $current_user;
	$current_user = wp_get_current_user();
}
add_action( 'init', 'rsf_current_user' );
*/