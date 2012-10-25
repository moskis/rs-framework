<?php

/**
 * Load Includes
 */

// RS functions file
require_once("functions.php");

// Advanced Body & Post classes for styling
require_once("inc/post-classes.php");

// Page Meta data
//require_once("inc/page-meta.php");

// Portfolio Post Type
//require_once("inc/portfolio-type.php");

// Portfolio Meta data
//require_once("inc/portfolio-meta.php");

// Clients Post Type
//require_once("inc/clients-type.php");

// Clients Meta data
//require_once("inc/clients-meta.php");

// Partners Post Type
//require_once("inc/partners-type.php");

// Partners Meta data
//require_once("inc/partners-meta.php");

// Widgets
//require_once("inc/widgets.php");

// Shortcodes
//require_once("inc/shortcodes.php");

// Customization in Login/Register Pages
//require_once("inc/login.php");

// Extra fields in user profiles
//require_once("inc/user-meta.php");


/*
 * Options Framework
 */

require_once( 'options-framework/options.php' );

if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/rs-framework/options-framework/inc/' );
	require_once dirname( __FILE__ ) . '/options-framework/inc/options-framework.php';
}