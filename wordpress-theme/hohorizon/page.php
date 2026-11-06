<?php
/**
 * Inner pages.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();

while (have_posts()) :
	the_post();
	$slug = get_post_field('post_name', get_the_ID());
	if ($slug !== 'speakers') {
		hohorizon_page_hero();
	}

	if ($slug === 'about') {
		$image = hohorizon_image_url(get_the_ID(), '_hohorizon_image');
		echo '<section class="section"><div class="wrap split"><div class="prose">';
		the_content();
		echo '<div class="actions">';
		echo '<a class="btn btn-ink" href="' . esc_url(hohorizon_page_url('mission')) . '">Our mission</a>';
		echo '<a class="btn btn-ink" href="' . esc_url(hohorizon_page_url('invitation')) . '">Request an invitation</a>';
		echo '</div></div>';
		if ($image) {
			echo '<div class="frame"><img src="' . esc_url($image) . '" alt="" /></div>';
		}
		echo '</div></section>';
	} elseif ($slug === 'mission' || $slug === 'membership') {
		$pairs = hohorizon_pairs(get_the_ID());
		echo '<section class="section"><div class="wrap">';
		if ($pairs) {
			echo '<div class="benefits">';
			foreach ($pairs as $pair) {
				echo '<article class="benefit"><h2 class="eyebrow">' . esc_html($pair['title']) . '</h2><p>' . esc_html($pair['text']) . '</p></article>';
			}
			echo '</div>';
		} else {
			echo '<div class="prose">';
			the_content();
			echo '</div>';
		}
		if ($slug === 'membership') {
			echo '<div class="actions">';
			echo '<a class="btn btn-ink" href="' . esc_url(hohorizon_page_url('invitation')) . '">Request an invitation</a>';
			echo '<a class="btn btn-ink" href="' . esc_url(hohorizon_page_url('become-a-partner')) . '">Become a partner</a>';
			echo '</div>';
		}
		echo '</div></section>';
	} elseif ($slug === 'events') {
		echo '<section class="section"><div class="wrap">';
		hohorizon_event_list();
		echo '</div></section>';
	} elseif ($slug === 'programme') {
		echo '<section class="section"><div class="wrap">';
		hohorizon_filters();
		$sessions = hohorizon_query('hoh_session');
		while ($sessions->have_posts()) {
			$sessions->the_post();
			hohorizon_session_row();
		}
		wp_reset_postdata();
		echo '</div></section>';
	} elseif ($slug === 'speakers') {
		hohorizon_speaker_stage();
	} elseif ($slug === 'partners') {
		echo '<section class="section"><div class="wrap logo-grid">';
		foreach (hohorizon_tiers() as $key => $label) {
			echo '<div><h2 class="eyebrow">' . esc_html($label) . '</h2>';
			hohorizon_partner_row(0, $key);
			echo '</div>';
		}
		echo '<a class="btn btn-ink" href="' . esc_url(hohorizon_page_url('become-a-partner')) . '">Become a partner</a>';
		echo '</div></section>';
	} elseif ($slug === 'contact') {
		echo '<section class="section"><div class="wrap">';
		hohorizon_form(
			'contact',
			array(
				array('name' => 'name', 'label' => 'Name', 'autocomplete' => 'name'),
				array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'autocomplete' => 'email'),
				array('name' => 'message', 'label' => 'Message', 'type' => 'textarea'),
			),
			'Send'
		);
		echo '</div></section>';
	} elseif ($slug === 'invitation') {
		echo '<section class="section"><div class="wrap">';
		hohorizon_form(
			'invitation',
			array(
				array('name' => 'name', 'label' => 'Name', 'autocomplete' => 'name'),
				array('name' => 'organisation', 'label' => 'Organisation'),
				array('name' => 'role', 'label' => 'Role'),
				array('name' => 'country', 'label' => 'Country', 'autocomplete' => 'country-name'),
				array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'autocomplete' => 'email'),
				array('name' => 'message', 'label' => 'Why this forum', 'type' => 'textarea'),
			),
			'Request an invitation'
		);
		echo '</div></section>';
	} elseif ($slug === 'become-a-partner') {
		echo '<section class="section"><div class="wrap split"><div class="prose">';
		the_content();
		echo '</div>';
		hohorizon_form(
			'partnership',
			array(
				array('name' => 'name', 'label' => 'Name', 'autocomplete' => 'name'),
				array('name' => 'organisation', 'label' => 'Organisation'),
				array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'autocomplete' => 'email'),
				array(
					'name'    => 'interest',
					'label'   => 'Interest',
					'type'    => 'select',
					'options' => array('Strategic', 'Platinum', 'Gold', 'Silver', 'Institutional', 'Media'),
				),
				array('name' => 'message', 'label' => 'Note', 'type' => 'textarea'),
			),
			'Become a partner'
		);
		echo '</div></section>';
	} else {
		echo '<section class="section"><div class="wrap prose">';
		the_content();
		echo '</div></section>';
	}
endwhile;

get_footer();
