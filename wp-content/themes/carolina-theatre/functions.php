<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Carolina_Theatre
 * @since 1.0
 */

/**
 * Set up theme defaults and register support for various WordPress features.
 */
function carolinatheatre_setup() {
	load_theme_textdomain( 'carolinatheatre' );
	add_theme_support( 'automatic-feed-links' );	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'title-tag' ); // WP manages the document title, so there is no hard-coded <title>
	add_theme_support( 'post-thumbnails' ); // Enable support for Post Thumbnails on posts and pages.
	
	// Custom Images Sizes
	add_image_size( 'gallery-thumb', 700, 400, true ); // 2x actual size
	add_image_size( 'gallery-full', 1440, false ); // large enough for all sizes
	
	// same ratios, different sizes, for easy uploading and use throughout site
	add_image_size( 'hero-default', 1440, 810, true ); // large enough for all sizes
	add_image_size( 'hero-small', 1280, 720, true ); // large enough for all sizes
	add_image_size( 'event-thumb', 500, 280, true ); // 2x actual size
	// add_image_size( 'event-hero', 800, 450, true ); // actual size

	// Registering menu locations for the theme
	register_nav_menus( array(
		'header-topleft'  => __( 'Header - Top Left', 'carolinatheatre' ),
		'header-topright' => __( 'Header - Top Right', 'carolinatheatre' ),
		'header-main'   	=> __( 'Header - Main', 'carolinatheatre' ),
		'header-cta' 			=> __( 'Header - Call to Action Button' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );
}
add_action( 'after_setup_theme', 'carolinatheatre_setup' );

/**
 * Allow SVG file uploads to Media Library
 */
function add_file_types_to_uploads($file_types){

    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );

    return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');


/*
 * Adding an ACF Theme Options page in the Dashboard
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'general-settings',
		'capability'	=> 'edit_posts',
		// 'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'parent_slug'	=> 'general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Scripts & Styles',
		'menu_title'	=> 'Scripts & Styles',
		'parent_slug'	=> 'general-settings',
	));
}

/**
 * Register widget areas.
 */
function carolinatheatre_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'carolinatheatre' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'carolinatheatre' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'carolinatheatre_widgets_init' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function carolinatheatre_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'carolinatheatre_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 */
function carolinatheatre_scripts() {
	// Theme stylesheet.
	wp_enqueue_style( 'main-styles', get_template_directory_uri() . '/dist/styles.css', array(), null);
	
	// All being pulled into and minified to 'scripts-min.js' thru Codekit
	// wp_enqueue_script( 'events-script', get_template_directory_uri() . '/src/js/event-filter.js', array('jquery'
	// ), null, true );
	// wp_enqueue_script( 'slick-slider', get_template_directory_uri() . '/src/js/slick-min.js', array('jquery'
	// ), null, true );
	// wp_enqueue_script( 'slick-script', get_template_directory_uri() . '/src/js/slick-init.js', array('jquery'
	// ), null, true );
	// wp_enqueue_script( 'single-film-read-more', get_template_directory_uri() . '/src/js/singleFilmReadMore.js', array('jquery'
	// ), null, true );
	// wp_enqueue_script( 'film-festival-tabs', get_template_directory_uri() . '/src/js/filmFestivalTabs.js', array('jquery'
	// ), null, true );
	// wp_enqueue_script( 'featherlight', get_template_directory_uri() . '/src/js/featherlight.js', array('jquery'
	// ), null, true );
	// wp_enqueue_script( 'featherlight-gallery', get_template_directory_uri() . '/src/js/featherlight.gallery.js', array('jquery'
	// ), null, true );

	wp_enqueue_script( 'main-scripts', get_template_directory_uri() . '/dist/scripts-min.js', array('jquery'
	), null, true );
	wp_enqueue_script('jquery');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'carolinatheatre_scripts' );

/**
 * Reorder Menu Items in WordPress Dashboard
 */
require get_template_directory() . '/inc/reorder-admin-dashboard.php';

/**
 * Instantiate Custom Post Types
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Custom Walker for Main Mobile Menu
 */
require get_template_directory() . '/inc/custom_walker-icon.php';

/**
 * Extra buttons, styles, and styling of TinyMCE WYSIWYG
 */
require get_template_directory() . '/inc/tinymce.php';
