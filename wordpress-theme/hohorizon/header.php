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
	<?php if (is_front_page()) : ?>
		<link rel="preload" as="image" href="<?php echo esc_url(hohorizon_hero_still()); ?>" />
	<?php endif; ?>
	<?php wp_head(); ?>
	<script>try{if(localStorage.getItem("hohorizon-theme")==="light")document.documentElement.dataset.theme="light";}catch(e){}</script>
</head>
<body <?php body_class(); ?> data-ga="<?php echo esc_attr(hohorizon_mod('ga')); ?>">
<?php wp_body_open(); ?>
<a class="skip" href="#content">Skip to content</a>
<header class="site-header">
	<a class="logo" href="<?php echo esc_url(home_url('/')); ?>">
		<strong>HORIZON<br />GLOBAL<br />AFFAIRS</strong>
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
		<button class="theme-toggle" type="button" aria-pressed="false" aria-label="Switch to light mode"><svg class="theme-icon theme-icon-sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 3v2M12 19v2M3 12h2M19 12h2M5.2 5.2l1.4 1.4M17.4 17.4l1.4 1.4M18.8 5.2l-1.4 1.4M6.6 17.4l-1.4 1.4"/></svg><svg class="theme-icon theme-icon-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 14.5A8 8 0 1 1 9.5 4 6.5 6.5 0 0 0 20 14.5z"/></svg></button>
		<a class="btn" href="<?php echo esc_url(hohorizon_page_url('become-a-partner')); ?>"><?php echo esc_html(hohorizon_mod('button_partner')); ?></a>
		<a class="btn" href="<?php echo esc_url(hohorizon_page_url('invitation')); ?>"><?php echo esc_html(hohorizon_mod('button_invite')); ?></a>
	</div>
</header>
<main id="content">
