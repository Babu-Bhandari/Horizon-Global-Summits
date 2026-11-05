<?php
/**
 * Opening screen on the homepage.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}
?>
<div class="intro" id="intro">
	<div class="hero-bg" style="background-image:url('<?php echo esc_url(hohorizon_mod('intro_image')); ?>')"></div>
	<div class="hero-shade"></div>
	<div class="intro-copy">
		<p class="intro-title"><span><?php echo esc_html(hohorizon_mod('line1')); ?></span><span><?php echo esc_html(hohorizon_mod('line2')); ?></span><span><?php echo esc_html(hohorizon_mod('line3')); ?></span></p>
		<div class="rule"></div>
		<div class="intro-year">
			<p class="striped"><?php echo esc_html(hohorizon_mod('mark')); ?></p>
			<p class="intro-pct"><span id="intro-pct">000</span>%</p>
		</div>
	</div>
	<div class="intro-meta">
		<span>[ <?php echo esc_html(hohorizon_mod('hero_date')); ?> ]</span>
		<span>[ <?php echo esc_html(hohorizon_mod('hero_venue')); ?> ]</span>
	</div>
</div>
