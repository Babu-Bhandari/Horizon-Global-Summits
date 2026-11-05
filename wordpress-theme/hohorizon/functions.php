<?php
/**
 * HOHORIZON theme.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

define('HOHORIZON_VERSION', '1.0.0');

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/meta.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/forms.php';
require get_template_directory() . '/inc/seed.php';
