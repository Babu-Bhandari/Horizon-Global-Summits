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
		echo '<a class="btn btn-ink" href="' . esc_url(home_url('/#contact')) . '">Request an invitation</a>';
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
			echo '<a class="btn btn-ink" href="' . esc_url(home_url('/#contact')) . '">Request an invitation</a>';
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
				array('name' => 'organisation', 'label' => 'Company', 'autocomplete' => 'organization'),
				array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'autocomplete' => 'email'),
				array('name' => 'phone', 'label' => 'Contact number', 'type' => 'tel', 'autocomplete' => 'tel'),
				array(
					'name'    => 'enquiry',
					'label'   => 'I want to',
					'type'    => 'select',
					'wide'    => true,
					'options' => array('Request an Invitation', 'Become a Partner', 'Explore Speaking Opportunity'),
				),
			),
			'Send message'
		);
		echo '</div></section>';
	} elseif ($slug === 'invitation') {
		echo '<section class="section"><div class="wrap"><div class="contact-split"><div>';
		hohorizon_form(
			'invitation',
			array(
				array('name' => 'name', 'label' => 'Name', 'autocomplete' => 'name'),
				array('name' => 'email', 'label' => 'Work email', 'type' => 'email', 'autocomplete' => 'email'),
				array('name' => 'organisation', 'label' => 'Organisation', 'autocomplete' => 'organization'),
				array('name' => 'role', 'label' => 'Job title', 'autocomplete' => 'organization-title'),
				array('name' => 'phone', 'label' => 'Phone (optional)', 'type' => 'tel', 'autocomplete' => 'tel', 'optional' => true),
				array('name' => 'country', 'label' => 'Country', 'type' => 'select', 'autocomplete' => 'country-name', 'options' => hohorizon_countries()),
				array(
					'name'    => 'gathering',
					'label'   => 'Gathering',
					'type'    => 'select',
					'options' => array('Horizon flagship forum', 'Horizon private briefing', 'Either gathering'),
				),
				array(
					'name'    => 'industry',
					'label'   => 'Industry',
					'type'    => 'select',
					'options' => array('Trade', 'Finance', 'Artificial intelligence', 'Logistics', 'Risk', 'Technology', 'Other'),
				),
				array('name' => 'message', 'label' => 'Why this forum', 'type' => 'textarea', 'wide' => true),
			),
			'Request an invitation'
		);
		echo '</div><aside class="contact-facts">';
		echo '<p class="eyebrow">Reach us</p><h3>The forum desk</h3>';
		echo '<article class="contact-fact"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 13a8 8 0 0 1 16 0"/><path d="M4 13v4a2 2 0 0 0 2 2h1v-6H6a2 2 0 0 0-2 2zM20 13v4a2 2 0 0 1-2 2h-1v-6h1a2 2 0 0 1 2 2z"/><path d="M12 19v2"/></svg><p><small>Info line</small><strong>To be confirmed</strong></p></article>';
		echo '<article class="contact-fact"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg><p><small>Email address</small><strong><a href="mailto:' . esc_attr(hohorizon_mod('public_email')) . '">' . esc_html(hohorizon_mod('public_email')) . '</a></strong></p></article>';
		echo '<article class="contact-fact"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 20V8l8-4 8 4v12"/><path d="M9 20v-6h6v6"/><path d="M9 10h.01M15 10h.01"/></svg><p><small>Head office</small><strong>' . esc_html(hohorizon_mod('office')) . '</strong></p></article>';
		echo '<article class="contact-fact"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path d="M12 8v5l3 2"/></svg><p><small>Business hours</small><strong>' . esc_html(hohorizon_mod('hours')) . '</strong></p></article>';
		echo '</aside></div></div></section>';
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
	} elseif ($slug === 'manage-cookies' || get_the_title() === 'Manage Cookies') {
		echo '<section class="section"><div class="wrap prose">';
		the_content();
		echo '<h2>Your choice on this device</h2>';
		echo '<p data-cookie-status>No choice is saved on this device yet.</p>';
		echo '<div class="actions cookie-manage">';
		echo '<button class="btn" type="button" data-cookie="accept">Accept</button>';
		echo '<button class="btn btn-ink" type="button" data-cookie="decline">Decline</button>';
		echo '</div></div></section>';
	} else {
		echo '<section class="section"><div class="wrap prose">';
		the_content();
		echo '</div></section>';
	}
endwhile;

get_footer();
