<?php
/**
 * Fallback list.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();
		hohorizon_page_hero();
		echo '<section class="section"><div class="wrap prose">';
		the_content();
		echo '</div></section>';
	}
} else {
	echo '<section class="page-hero"><div class="wrap"><h1>Nothing published yet.</h1></div></section>';
}

get_footer();
