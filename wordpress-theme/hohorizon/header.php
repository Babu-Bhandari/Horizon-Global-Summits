<?php
/**
 * Site header.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php if (!has_site_icon()) : ?>
		<link rel="icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon.svg'); ?>" type="image/svg+xml" />
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-ga="<?php echo esc_attr(hohorizon_mod('ga')); ?>">
<?php wp_body_open(); ?>
<a class="skip" href="#content">Skip to content</a>
<?php if (is_front_page()) : ?>
	<?php get_template_part('template-parts/intro'); ?>
<?php endif; ?>
<header class="site-header">
	<a class="logo" href="<?php echo esc_url(home_url('/')); ?>">
		<strong><?php echo esc_html(hohorizon_mod('line1')); ?><br /><?php echo esc_html(hohorizon_mod('line2')); ?><br /><?php echo esc_html(hohorizon_mod('line3')); ?></strong>
		<span><?php echo esc_html(hohorizon_mod('mark')); ?></span>
	</a>
	<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav">Menu</button>
	<nav class="nav" id="site-nav" aria-label="Primary">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'walker'         => new Hohorizon_Walker(),
				'fallback_cb'    => 'hohorizon_primary_fallback',
			)
		);
		?>
		<a class="btn nav-cta" href="<?php echo esc_url(hohorizon_page_url('become-a-partner')); ?>"><?php echo esc_html(hohorizon_mod('button_partner')); ?></a>
		<a class="btn nav-cta" href="<?php echo esc_url(hohorizon_page_url('invitation')); ?>"><?php echo esc_html(hohorizon_mod('button_invite')); ?></a>
	</nav>
	<div class="header-actions">
		<a class="btn" href="<?php echo esc_url(hohorizon_page_url('become-a-partner')); ?>"><?php echo esc_html(hohorizon_mod('button_partner')); ?></a>
		<a class="btn" href="<?php echo esc_url(hohorizon_page_url('invitation')); ?>"><?php echo esc_html(hohorizon_mod('button_invite')); ?></a>
	</div>
</header>
<main id="content">
