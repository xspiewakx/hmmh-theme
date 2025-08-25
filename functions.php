<?php
/**
 * hmmh-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hmmh-theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hmmh_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on hmmh-theme, use a find and replace
		* to change 'hmmh-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'hmmh-theme', get_template_directory() . '/languages' );

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
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'hmmh-theme' ),
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
			'hmmh_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

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
add_action( 'after_setup_theme', 'hmmh_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hmmh_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hmmh_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'hmmh_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hmmh_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'hmmh-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'hmmh-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'hmmh_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hmmh_theme_scripts() {
	wp_enqueue_style( 'hmmh-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'hmmh-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'hmmh-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hmmh_theme_scripts' );

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
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}










//
// CASE STUDIES - FRONTEND
//

function my_acf_json_save_point( $path ) {
    return get_stylesheet_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_load_point( $paths ) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

function register_my_acf_block() {
    acf_register_block_type(array(
        'name'              => 'my-custom-block',
        'title'             => __('Mój Niestandardowy Blok'),
        'description'       => __('Blok demonstracyjny stworzony z ACF.'),
        'render_template'   => 'template-parts/blocks/my-custom-block.php',
        'category'          => 'common',
        'icon'              => 'admin-home',
        'keywords'          => array('custom', 'my-block', 'demo'),
		'enqueue_style'     => get_stylesheet_directory_uri() . '/css/my-custom-block.css',
    	'enqueue_script'    => get_stylesheet_directory_uri() . '/js/my-custom-block.js',
    ));
}
add_action('acf/init', 'register_my_acf_block');

//
// MECHANICY - BACKEND
//
function remove_mechanic_role() {
    remove_role( 'mechanic' );
}
//add_action( 'init', 'remove_mechanic_role' );
add_action( 'init', 'add_mechanic_functions' );

function add_mechanic_functions() {
	if( mechanic_is_required_plugin_active() ) {
		register_mechanic_role();
		cptui_register_my_cpts();
		cptui_register_my_taxes();
		add_action( 'acf/include_fields', 'cars_add_fields' );
	}
	else { add_action( 'admin_notices', 'required_plugins_notice' ); }
}


function register_mechanic_role() {
	//define vars
	$cpt_singular = 'car';
    $cpt_plural   = 'cars';
	$role_slug = 'mechanic';
	$role_name = 'Mechanik';
	$taxonomy_slug = 'car_brand';
	if ( get_role( $role_slug ) === null ) {
        // uprawnienia
        $caps = array(
            'read'                       => true, // Podstawowe uprawnienie do odczytu
            'upload_files'               => true, // Dodawanie plików

            // Uprawnienia CPT
            'edit_'.$cpt_singular         => true,
            'read_'.$cpt_singular         => true,
            'delete_'.$cpt_singular       => true,
            'edit_'.$cpt_plural           => true,
            'edit_others_'.$cpt_plural    => true,
            'publish_'.$cpt_plural        => true,
            'read_private_'.$cpt_plural   => true,
            'delete_'.$cpt_plural         => true,
            'delete_private_'.$cpt_plural => true,
            'delete_published_'.$cpt_plural => true,
            'delete_others_'.$cpt_plural  => true,
            'edit_private_'.$cpt_plural   => true,
            'edit_published_'.$cpt_plural => true,
			'manage_'.$taxonomy_slug => true,
            'edit_'.$taxonomy_slug => true,
            'delete_'.$taxonomy_slug => true,
            'assign_'.$taxonomy_slug => true,
        );

        // nowa rola
        add_role(
            $role_slug,      // Identyfikator roli
            $role_name,      // Nazwa wyświetlana
            $caps             // Tablica uprawnień
        );
    }
}
function cptui_register_my_cpts() {

	/**
	 * Post Type: Cars.
	 */

	$labels = [
		"name" => esc_html__( "Cars", "twenty-twenty-five-child" ),
		"singular_name" => esc_html__( "Car", "twenty-twenty-five-child" ),
	];

	$args = [
		"label" => esc_html__( "Cars", "twenty-twenty-five-child" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => [ "car", "cars" ],
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "car", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-car",
		"supports" => [ "title", "editor", "thumbnail" ],
		"taxonomies" => [ "car_brand" ],
		"show_in_graphql" => false,
	];

	register_post_type( "car", $args );
}

function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Car Brands.
	 */

	$labels = [
		"name" => esc_html__( "Car Brands", "twenty-twenty-five-child" ),
		"singular_name" => esc_html__( "Car Brand", "twenty-twenty-five-child" ),
	];

	
	$args = [
		"label" => esc_html__( "Car Brands", "twenty-twenty-five-child" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'car_brand', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "car_brand",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
		'capabilities'       => array(
            'manage_terms' => 'manage_car_brand', 
            'edit_terms'   => 'edit_car_brand',   
            'delete_terms' => 'delete_car_brand', 
            'assign_terms' => 'assign_car_brand', 
        ),
	];
	register_taxonomy( "car_brand", [ "car" ], $args );
}

function cars_add_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_68ab6b2f1553f',
	'title' => 'Cars Fields',
	'fields' => array(
		array(
			'key' => 'field_68ab6b3066141',
			'label' => 'Assigned mechanics',
			'name' => 'assigned_mechanics',
			'aria-label' => '',
			'type' => 'user',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'role' => array(
				0 => 'mechanic',
			),
			'return_format' => 'array',
			'multiple' => 1,
			'allow_null' => 0,
			'allow_in_bindings' => 0,
			'bidirectional' => 0,
			'bidirectional_target' => array(
			),
		),
		array(
			'key' => 'field_68ab7f8be774f',
			'label' => 'Car Brand',
			'name' => 'car_brand',
			'aria-label' => '',
			'type' => 'taxonomy',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'taxonomy' => 'car_brand',
			'add_term' => 1,
			'save_terms' => 0,
			'load_terms' => 0,
			'return_format' => 'id',
			'field_type' => 'checkbox',
			'allow_in_bindings' => 0,
			'bidirectional' => 0,
			'multiple' => 0,
			'allow_null' => 0,
			'bidirectional_target' => array(
			),
		),
		array(
			'key' => 'field_68ab7fece7751',
			'label' => 'Car Model',
			'name' => 'car_model',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'allow_in_bindings' => 0,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_68ab7f27e774e',
			'label' => 'Year of the car',
			'name' => 'car_year',
			'aria-label' => '',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'min' => 1900,
			'max' => 2100,
			'allow_in_bindings' => 0,
			'placeholder' => '',
			'step' => '',
			'prepend' => '',
			'append' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'car',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );
}




function mechanic_is_required_plugin_active() {
    // Lista wymaganych wtyczek do sprawdzenia
    $required_plugins = array(
        'advanced-custom-fields/acf.php',
        'advanced-custom-fields-pro/acf.php',
        'secure-custom-fields/secure-custom-fields.php', // Przykładowa nazwa innej wtyczki
    );

    // Sprawdzamy, czy funkcja is_plugin_active istnieje
    if ( ! function_exists( 'is_plugin_active' ) ) {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

    // Pętla przez listę wymaganych wtyczek
    foreach ( $required_plugins as $plugin_path ) {
        if ( is_plugin_active( $plugin_path ) ) {
            // Jeśli znajdziemy jedną aktywną, zwracamy true i przerywamy pętlę
            return true;
        }
    }

    // Jeśli pętla się zakończyła i nie znaleziono żadnej aktywnej wtyczki, zwracamy false
    return false;
}

function required_plugins_notice() {
    echo '<div class="notice notice-error is-dismissible">';
    echo '<p>Aktywuj wtyczkę ACF / ACF Pro / SCF</p>';
    echo '</div>';
}

?>