<?php
/**
 * Theme setup, content types, and assets.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('after_setup_theme', 'hohorizon_setup');
add_action('init', 'hohorizon_register_content_types');
add_action('wp_enqueue_scripts', 'hohorizon_assets');
add_action('after_switch_theme', 'hohorizon_activate');

/**
 * Theme supports.
 */
function hohorizon_setup() {
	load_theme_textdomain('hohorizon', get_template_directory() . '/languages');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
	add_post_type_support('page', 'excerpt');
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 80,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	register_nav_menus(
		array(
			'primary'        => 'Primary menu',
			'footer_quick'   => 'Footer quick links',
			'footer_explore' => 'Footer explore links',
		)
	);
}

/**
 * Styles and behaviour.
 */
function hohorizon_assets() {
	$css = get_template_directory() . '/assets/theme.css';
	$js  = get_template_directory() . '/assets/theme.js';
	wp_enqueue_style('hohorizon', get_template_directory_uri() . '/assets/theme.css', array(), file_exists($css) ? (string) filemtime($css) : HOHORIZON_VERSION);
	wp_enqueue_script('hohorizon', get_template_directory_uri() . '/assets/theme.js', array(), file_exists($js) ? (string) filemtime($js) : HOHORIZON_VERSION, true);
}

/**
 * Content types edited from the admin menu.
 */
function hohorizon_register_content_types() {
	$common = array(
		'public'       => false,
		'show_ui'      => true,
		'show_in_rest' => true,
		'has_archive'  => false,
		'rewrite'      => false,
		'supports'     => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
		'capability_type' => 'post',
	);

	register_post_type(
		'hoh_event',
		array_merge(
			$common,
			array(
				'public'              => true,
				'publicly_queryable'  => true,
				'rewrite'             => array('slug' => 'event'),
				'menu_icon'           => 'dashicons-calendar-alt',
				'menu_position'       => 21,
				'labels'              => hohorizon_labels('Event', 'Events'),
			)
		)
	);
	register_post_type(
		'hoh_speaker',
		array_merge(
			$common,
			array(
				'menu_icon'     => 'dashicons-microphone',
				'menu_position' => 22,
				'labels'        => hohorizon_labels('Speaker', 'Speakers'),
			)
		)
	);
	register_post_type(
		'hoh_session',
		array_merge(
			$common,
			array(
				'menu_icon'     => 'dashicons-list-view',
				'menu_position' => 23,
				'labels'        => hohorizon_labels('Session', 'Sessions'),
			)
		)
	);
	register_post_type(
		'hoh_partner',
		array_merge(
			$common,
			array(
				'menu_icon'     => 'dashicons-awards',
				'menu_position' => 24,
				'supports'      => array('title', 'thumbnail', 'page-attributes'),
				'labels'        => hohorizon_labels('Partner', 'Partners'),
			)
		)
	);
	register_post_type(
		'hoh_highlight',
		array_merge(
			$common,
			array(
				'menu_icon'     => 'dashicons-screenoptions',
				'menu_position' => 25,
				'labels'        => hohorizon_labels('Highlight', 'Highlights'),
			)
		)
	);
	register_post_type(
		'hoh_topic',
		array_merge(
			$common,
			array(
				'menu_icon'     => 'dashicons-category',
				'menu_position' => 26,
				'labels'        => hohorizon_labels('Topic', 'Topics'),
			)
		)
	);
}

/**
 * Labels for a content type.
 *
 * @param string $single Singular.
 * @param string $plural Plural.
 * @return array<string, string>
 */
function hohorizon_labels($single, $plural) {
	return array(
		'name'          => $plural,
		'singular_name' => $single,
		'add_new_item'  => 'Add new ' . strtolower($single),
		'edit_item'     => 'Edit ' . strtolower($single),
		'new_item'      => 'New ' . strtolower($single),
		'view_item'     => 'View ' . strtolower($single),
		'search_items'  => 'Search ' . strtolower($plural),
		'not_found'     => 'No ' . strtolower($plural) . ' yet',
		'all_items'     => 'All ' . strtolower($plural),
	);
}

/**
 * Create the starting pages and sample entries the first time the theme is used.
 */
function hohorizon_activate() {
	hohorizon_register_content_types();
	hohorizon_seed();
	flush_rewrite_rules();
}
