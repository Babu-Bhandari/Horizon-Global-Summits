<?php
/**
 * About page.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();

while (have_posts()) :
	the_post();
	hohorizon_page_hero();
	$image = hohorizon_image_url(get_the_ID(), '_hohorizon_image');
	echo '<section class="section" id="about-page"><div class="wrap split"><div class="prose">';
	echo '<h2>Who it is for</h2>';
	the_content();
	echo '<div class="actions">';
	echo '<a class="btn btn-ink" href="' . esc_url(hohorizon_page_url('mission')) . '">Our mission</a>';
	echo '<a class="btn btn-ink" href="' . esc_url(home_url('/#contact')) . '">Request an invitation</a>';
	echo '</div></div>';
	if ($image) {
		echo '<div class="frame"><img src="' . esc_url($image) . '" alt="" /></div>';
	}
	echo '</div></section>';
endwhile;

get_footer();
