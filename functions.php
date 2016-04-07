<?php
/**
 * Single Malt functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Single_Malt
 */

/**DEV MODE
 *If is set to true then CSS and JS will load from minimized versions
 */
if (! defined('DEV_MODE')) {
	define( 'DEV_MODE', true );
}

if ( ! function_exists( 'single_malt_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function single_malt_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Single Malt, use a find and replace
	 * to change 'single_malt' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'single_malt', get_template_directory() . '/languages' );

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
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'single_malt' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'single_malt_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'single_malt_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function single_malt_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'single_malt_content_width', 640 );
}
add_action( 'after_setup_theme', 'single_malt_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function single_malt_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'single_malt' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'single_malt' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'single_malt_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function single_malt_scripts() {
	//LOAD STYLES
	if (defined('DEV_MODE') && true === DEV_MODE) : 
	//IF IN DEV MODE LOAD STYLES INDIVIDUALY
	wp_enqueue_style( 'single_malt-style', get_stylesheet_uri() );

	else : 
	//IF NOT IN DEV MODE LOAD CONCAT & MINIFIED VERSIONS (excluding any you want to load seperatly - add these individually below).
	wp_enqueue_style( 'single_malt-style.min', get_template_directory_uri() . '/app/dist/css/style.min.css' );
	wp_enqueue_style( 'vendor.min.css', get_template_directory_uri() . '/app/dist/css/vendor.min.css' );

	endif;

	//LOAD SCRIPTS
	if (defined('DEV_MODE') && true === DEV_MODE) : 
	//IF IN DEV MODE LOAD SCRIPTS INDIVIDUALY
	wp_enqueue_script( 'modernizr.js', get_template_directory_uri() . '/app/dev/js/modernizr.js', array(), '5.5.2.5', false );
	wp_enqueue_script( 'single_malt-navigation', get_template_directory_uri() . '/app/dev/js/navigation.js', array(), '1.01', true );
	wp_enqueue_script( 'single_malt-skip-link-focus-fix', get_template_directory_uri() . '/app/dev/js/skip-link-focus-fix.js', array(), '10.1', true );
	wp_enqueue_script( 'theme.js', get_template_directory_uri() . '/app/dev/js/theme.js', array('jquery'), '1.01', true );

	else : 
	//IF NOT IN DEV MODE LOAD CONCAT & MINIFIED VERSIONS (excluding Modernizr and any others you want to load seperatly - add these individually below).
	wp_enqueue_script( 'modernizr.js', get_template_directory_uri() . '/app/dist/js/modernizr.min.js', array(), '5.5.2.5', false );
	wp_enqueue_script( 'vendor.js', get_template_directory_uri() . '/app/dist/js/vendor.min.js', array('jquery'), '1.01', true );
	wp_enqueue_script( 'app.js', get_template_directory_uri() . '/app/dist/js/app.min.js', array('jquery'), '1.01', true );

	endif;

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'single_malt_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
