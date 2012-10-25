<?php

/**
 * Generate additional Body and Post classes for advanced styling
 */

// Generate Body Classes
function k2_body_class_filter($classes) {
	global $wp_query, $blog_id;

	$classes[] = 'wordpress';

	// Only on single posts and static pages
	if ( is_single() or is_page() ) {
		// Add 'author-XXXX' class
		$author = get_userdata($wp_query->post->post_author);
		$classes[] = 'author-' . sanitize_html_class($author->user_nicename , $author->ID);

		// Add 'slug-XXXX' for the post or page slug -- CONSIDER REMOVING; WHAT WORTH DOES IT HAVE OVER 'postid-X'?
		$classes[] = 'slug-' . $wp_query->post->post_name;

		// Only for posts...
		if ( is_single() ) {
			// Adds classes for the month, day, and hour when the post was published
			if ( isset($wp_query->post->post_date) )
				k2_date_classes( mysql2date( 'U', $wp_query->post->post_date ), $classes, 's-' );

			// Add 'category-XXXX' for each relevant category
			foreach ( (array) get_the_category($wp_query->post->ID) as $cat ) {
				if ( empty($cat->slug ) )
					continue;
				$classes[] = 'category-' . sanitize_html_class($cat->slug, $cat->cat_ID);
			}

			// Add 'tag-XXXX' for each relevant tag
			foreach ( (array) get_the_tags($wp_query->post->ID) as $tag ) {
				if ( empty($tag->slug ) )
					continue;
				$classes[] = 'tag-' . sanitize_html_class($tag->slug, $tag->term_id);
			}
		}
	}

	// Language settings
	$locale = get_locale();
	if ( empty($locale) ) {
		$locale = 'en';
	} else {
		$lang_array = explode( '_', $locale );
		$locale = $lang_array[0];
	}
	$classes[] = 'lang-' . $locale;

    // For WPMU. Set a class for the blog ID
    if ( isset($blog_id) )
        $classes[] = 'wpmu-' . $blog_id;

	$classes = array_merge( $classes, k2_browser_classes() );

	return $classes;
}
add_filter('body_class', 'k2_body_class_filter');


// Adapted for K2 (http://getk2.com) from PHP CSS Browser Selector v0.0.1
// Bastian Allgeier (http://bastian-allgeier.de)
// http://bastian-allgeier.de/css_browser_selector
// License: http://creativecommons.org/licenses/by/2.5/
// Credits: This is a php port from Rafael Lima's original Javascript CSS Browser Selector: http://rafael.adm.br/css_browser_selector
function k2_browser_classes($ua = null) {
		$ua = ($ua) ? strtolower($ua) : strtolower($_SERVER['HTTP_USER_AGENT']);

		$g = 'gecko';
		$w = 'webkit';
		$s = 'safari';
		$b = array();

		// browser
		if ( !preg_match( '/opera|webtv/i', $ua ) && preg_match( '/msie\s(\d)/', $ua, $array ) ):
			$b[] = 'ie ie' . $array[1];
		elseif ( strstr( $ua, 'firefox/2' ) ):
			$b[] = $g . ' ff2';
		elseif ( strstr( $ua, 'firefox/3.5' ) ):
			$b[] = $g . ' ff3 ff3_5';
		elseif ( strstr( $ua, 'firefox/3' ) ):
			$b[] = $g . ' ff3';
		elseif ( strstr( $ua, 'firefox' ) ):
			$b[] = $g . ' ff' . $array[1];
		elseif ( strstr( $ua, 'gecko/' ) ):
			$b[] = $g;
		elseif (preg_match('/opera(\s|\/)(\d+)/', $ua, $array ) ):
			$b[] = 'opera opera' . $array[2];
		elseif ( strstr( $ua, 'konqueror' ) ):
			$b[] = 'konqueror';
		elseif ( strstr( $ua, 'chrome' ) ):
			$b[] = $w . ' ' . $s . ' chrome';
		elseif ( strstr( $ua, 'iron' ) ):
			$b[] = $w . ' ' . $s . ' iron';
		elseif ( strstr( $ua, 'applewebkit/' ) ):
			$b[] = (preg_match('/version\/(\d+)/i', $ua, $array)) ? $w . ' ' . $s . ' ' . $s . $array[1] : $w . ' ' . $s;
		elseif ( strstr( $ua, 'mozilla/' ) ):
			$b[] = $g;
		endif;

		// platform
		if ( strstr( $ua, 'j2me' ) ):
			$b[] = 'mobile';
		elseif ( strstr( $ua, 'iphone' ) ):
			$b[] = 'iphone';
		elseif ( strstr( $ua, 'ipod' ) ):
			$b[] = 'ipod';
		elseif ( strstr( $ua, 'ipad' ) ):
			$b[] = 'ipad';
		elseif ( strstr( $ua, 'mac' ) ):
			$b[] = 'mac';
		elseif ( strstr( $ua, 'darwin' ) ):
			$b[] = 'mac';
		elseif ( strstr( $ua, 'webtv' ) ):
			$b[] = 'webtv';
		elseif ( strstr( $ua, 'win' ) ):
			$b[] = 'win';
		elseif ( strstr( $ua, 'freebsd' ) ):
			$b[] = 'freebsd';
		elseif ( strstr( $ua, 'x11' ) || strstr( $ua, 'linux' ) ):
			$b[] = 'linux';
		endif;

		return $b;
}


// Generate Post classes
function k2_post_class_filter( $classes ) {
	global $k2_post_alt, $post;

	if ( !$k2_post_alt )
		$k2_post_alt = 1;

	$classes[] = "p$k2_post_alt";

	// If it's the other to the every, then add 'alt' class
	if ( ++$k2_post_alt % 2 )
		$classes[] = 'alt';

	// Applies the time- and date-based classes (below) to post DIV
	k2_date_classes( mysql2date( 'U', $post->post_date ), $classes );

	return $classes;
}
add_filter( 'post_class', 'k2_post_class_filter' );


// Generates time- and date-based classes for BODY, post DIVs, and comment LIs; relative to GMT (UTC)
function k2_date_classes( $t, &$c, $p = '' ) {
	$t = $t + ( get_option('gmt_offset') * 3600 );
	$c[] = $p . 'y' . gmdate('Y', $t); // Year
	$c[] = $p . 'm' . gmdate('m', $t); // Month
	$c[] = $p . 'd' . gmdate('d', $t); // Day
	$c[] = $p . 'h' . gmdate('H', $t); // Hour
}