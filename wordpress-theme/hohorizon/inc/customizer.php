<?php
/**
 * Customizer fields for the designed homepage and footer.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('customize_register', 'hohorizon_customize');

/**
 * Register the fields.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function hohorizon_customize($wp_customize) {
	$sections = array(
		'hohorizon_hero'    => 'Hero',
		'hohorizon_welcome' => 'Welcome',
		'hohorizon_home'    => 'Homepage sections',
		'hohorizon_footer'  => 'Footer and contact',
	);
	foreach ($sections as $id => $title) {
		$wp_customize->add_section(
			$id,
			array(
				'title'    => $title,
				'priority' => 30,
			)
		);
	}

	$fields = array(
		'line1'             => array('Hero line 1', 'hohorizon_hero', 'text'),
		'line2'             => array('Hero line 2', 'hohorizon_hero', 'text'),
		'line3'             => array('Hero line 3', 'hohorizon_hero', 'text'),
		'mark'              => array('Word under the line', 'hohorizon_hero', 'text'),
		'button_partner'    => array('Partner button', 'hohorizon_hero', 'text'),
		'button_invite'     => array('Invitation button', 'hohorizon_hero', 'text'),
		'hero_name'         => array('Name under the buttons', 'hohorizon_hero', 'text'),
		'hero_date'         => array('Date line', 'hohorizon_hero', 'text'),
		'hero_venue'        => array('Venue line', 'hohorizon_hero', 'text'),
		'hero_side'         => array('Right-hand heading', 'hohorizon_hero', 'textarea'),
		'streams'           => array('Streams, separated by commas', 'hohorizon_hero', 'text'),
		'countdown'         => array('Countdown date, such as 2026-11-25 09:00', 'hohorizon_hero', 'text'),
		'welcome_eyebrow'   => array('Eyebrow', 'hohorizon_welcome', 'text'),
		'welcome_title'     => array('Heading', 'hohorizon_welcome', 'text'),
		'welcome_text'      => array('Text, with a blank line between paragraphs', 'hohorizon_welcome', 'textarea'),
		'stats_eyebrow'     => array('Figures eyebrow', 'hohorizon_home', 'text'),
		'stats_title'       => array('Figures heading', 'hohorizon_home', 'text'),
		'stats'             => array('Figures, one per line: Label | Value | Note', 'hohorizon_home', 'textarea'),
		'expect_eyebrow'    => array('Highlights eyebrow', 'hohorizon_home', 'text'),
		'expect_title'      => array('Highlights heading', 'hohorizon_home', 'text'),
		'events_eyebrow'    => array('Events eyebrow', 'hohorizon_home', 'text'),
		'events_title'      => array('Events heading', 'hohorizon_home', 'text'),
		'programme_eyebrow' => array('Programme eyebrow', 'hohorizon_home', 'text'),
		'programme_title'   => array('Programme heading', 'hohorizon_home', 'text'),
		'programme_note'    => array('Programme note', 'hohorizon_home', 'textarea'),
		'topics_eyebrow'    => array('Topics eyebrow', 'hohorizon_home', 'text'),
		'topics_title'      => array('Topics heading', 'hohorizon_home', 'text'),
		'speakers_eyebrow'  => array('Speakers eyebrow', 'hohorizon_home', 'text'),
		'speakers_title'    => array('Speakers heading', 'hohorizon_home', 'text'),
		'partners_eyebrow'  => array('Partners eyebrow', 'hohorizon_home', 'text'),
		'partners_title'    => array('Partners heading', 'hohorizon_home', 'text'),
		'member_eyebrow'    => array('Membership eyebrow', 'hohorizon_home', 'text'),
		'member_title'      => array('Membership heading', 'hohorizon_home', 'text'),
		'member_text'       => array('Membership text', 'hohorizon_home', 'textarea'),
		'member_points'     => array('Membership points, one per line', 'hohorizon_home', 'textarea'),
		'cta_eyebrow'       => array('Closing eyebrow', 'hohorizon_home', 'text'),
		'cta_title'         => array('Closing heading', 'hohorizon_home', 'text'),
		'cta_text'          => array('Closing text', 'hohorizon_home', 'textarea'),
		'footer_text'       => array('Footer introduction', 'hohorizon_footer', 'textarea'),
		'public_email'      => array('Email shown on the site', 'hohorizon_footer', 'text'),
		'venue'             => array('Venue shown on the site', 'hohorizon_footer', 'text'),
		'inbox'             => array('Inbox that receives forms', 'hohorizon_footer', 'email'),
		'ga'                => array('Google Analytics measurement ID', 'hohorizon_footer', 'text'),
		'linkedin'          => array('LinkedIn URL', 'hohorizon_footer', 'url'),
		'instagram'         => array('Instagram URL', 'hohorizon_footer', 'url'),
		'youtube'           => array('YouTube URL', 'hohorizon_footer', 'url'),
		'facebook'          => array('Facebook URL', 'hohorizon_footer', 'url'),
	);

	foreach ($fields as $key => $field) {
		$defaults = hohorizon_defaults();
		$wp_customize->add_setting(
			'hohorizon_' . $key,
			array(
				'default'           => isset($defaults[$key]) ? $defaults[$key] : '',
				'sanitize_callback' => hohorizon_sanitize_kind($field[2]),
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			'hohorizon_' . $key,
			array(
				'label'   => $field[0],
				'section' => $field[1],
				'type'    => $field[2] === 'textarea' ? 'textarea' : ($field[2] === 'email' ? 'email' : ($field[2] === 'url' ? 'url' : 'text')),
			)
		);
	}

	$images = array(
		'hero_image'    => array('Hero photo', 'hohorizon_hero'),
		'intro_image'   => array('Opening photo', 'hohorizon_hero'),
		'welcome_image' => array('Welcome photo', 'hohorizon_welcome'),
		'member_image'  => array('Membership photo', 'hohorizon_home'),
		'cta_image'     => array('Closing photo', 'hohorizon_home'),
	);
	foreach ($images as $key => $field) {
		$defaults = hohorizon_defaults();
		$wp_customize->add_setting(
			'hohorizon_' . $key,
			array(
				'default'           => isset($defaults[$key]) ? $defaults[$key] : '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'hohorizon_' . $key,
				array(
					'label'   => $field[0],
					'section' => $field[1],
				)
			)
		);
	}

	$wp_customize->add_setting(
		'hohorizon_hero_video',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hohorizon_hero_video',
			array(
				'label'     => 'Hero video',
				'section'   => 'hohorizon_hero',
				'mime_type' => 'video',
			)
		)
	);
}

/**
 * Sanitizer for a field kind.
 *
 * @param string $kind text, textarea, email, or url.
 * @return callable
 */
function hohorizon_sanitize_kind($kind) {
	if ($kind === 'textarea') {
		return 'sanitize_textarea_field';
	}
	if ($kind === 'email') {
		return 'sanitize_email';
	}
	if ($kind === 'url') {
		return 'esc_url_raw';
	}
	return 'sanitize_text_field';
}
