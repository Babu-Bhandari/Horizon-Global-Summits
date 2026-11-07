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
add_action('init', 'hohorizon_ensure_home_link');

/**
 * Theme supports.
 */
function hohorizon_setup() {
	load_theme_textdomain('hohorizon', get_template_directory() . '/languages');
	add_theme_support('title-tag');
	add_filter('document_title_parts', 'hohorizon_document_title_parts');
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
 * Browser tab name.
 *
 * @param array $parts Title parts.
 * @return array
 */
function hohorizon_document_title_parts($parts) {
	$parts['site'] = 'Horizon Global Summits';
	return $parts;
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
 * Add a Home item to an existing primary menu that does not have one.
 */
function hohorizon_ensure_home_link() {
	if (get_option('hohorizon_home_link') === '1') {
		return;
	}
	$locations = get_nav_menu_locations();
	if (empty($locations['primary'])) {
		return;
	}
	$items = wp_get_nav_menu_items($locations['primary']);
	if (!$items) {
		return;
	}
	$home = untrailingslashit(home_url('/'));
	foreach ($items as $item) {
		if ($item->title === 'Home' || untrailingslashit($item->url) === $home) {
			update_option('hohorizon_home_link', '1');
			return;
		}
	}
	wp_update_nav_menu_item(
		$locations['primary'],
		0,
		array(
			'menu-item-title'    => 'Home',
			'menu-item-url'      => home_url('/'),
			'menu-item-type'     => 'custom',
			'menu-item-status'   => 'publish',
			'menu-item-position' => 1,
		)
	);
	update_option('hohorizon_home_link', '1');
}

/**
 * Create the starting pages and sample entries the first time the theme is used.
 */
function hohorizon_activate() {
	hohorizon_register_content_types();
	hohorizon_seed();
	flush_rewrite_rules();
}
