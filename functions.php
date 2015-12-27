<?php
/**
 * Pyfal functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Pyfal
 * @since Pyfal 1.0
 */

if ( ! function_exists( 'pyfal_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Pyfal 1.0
 */
function pyfal_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on pyfal, use a find and replace
	 * to change 'pyfal' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'pyfal', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'pyfal' ),
		'drawer'  => __( 'Drawer Links Menu', 'pyfal' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

}
endif; // pyfal_setup
add_action( 'after_setup_theme', 'pyfal_setup' );

/**
 * Register widget area.
 *
 * @since Pyfal 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function pyfal_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'pyfal' ),
		'id'            => 'sidebar',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'pyfal' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s mdl-cell mdl-cell--4-col-tablet mdl-cell--12-col-desktop">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title mdl-typography--title mdl-typography--text-uppercase">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'pyfal_widgets_init' );

/**
 * Enqueue scripts and styles.
 *
 * @since Pyfal 1.0
 */
function pyfal_scripts() {
	// Load the Mdl Bootsrap.
	wp_enqueue_style( 'mdl-style', get_template_directory_uri() . '/mdl/material.min.css');

	// Load our main stylesheet.
	wp_enqueue_style( 'pyfal-style', get_stylesheet_uri() );

	// Mdl.js
	wp_enqueue_script( 'mdl-js', get_template_directory_uri() . '/mdl/material.min.js', array(),11, true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


}
add_action( 'wp_enqueue_scripts', 'pyfal_scripts' );


/**
 * Custom template tags for this theme.
 *
 * @since Pyfal 1.0
 */
require get_template_directory() . '/inc/template-tags.php';
