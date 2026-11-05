<?php
/**
 * One gathering.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();

while (have_posts()) :
	the_post();
	$image = hohorizon_image_url(get_the_ID());
	echo '<article class="page-hero"';
	if ($image) {
		echo ' style="' . esc_attr('--hero:url(' . esc_url($image) . ')') . '"';
	}
	echo '><div class="wrap">';
	$kicker = get_post_meta(get_the_ID(), '_hohorizon_kicker', true);
	if ($kicker) {
		echo '<p class="eyebrow">' . esc_html($kicker) . '</p>';
	}
	echo '<h1>' . esc_html(get_the_title()) . '</h1>';
	if (has_excerpt()) {
		echo '<p>' . esc_html(get_the_excerpt()) . '</p>';
	}
	echo '</div></article>';
	echo '<section class="section"><div class="wrap prose">';
	the_content();
	echo '<div class="actions">';
	echo '<a class="btn btn-ink" href="' . esc_url(hohorizon_page_url('programme')) . '">Sample programme</a>';
	echo '<a class="btn btn-ink" href="' . esc_url(hohorizon_page_url('invitation')) . '">Request an invitation</a>';
	echo '</div></div></section>';
endwhile;

get_footer();
