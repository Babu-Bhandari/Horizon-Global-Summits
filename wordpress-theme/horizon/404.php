<?php
/**
 * Missing page.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>
<section class="page-hero">
	<div class="wrap">
		<p class="eyebrow">404</p>
		<h1>This page is not on the site.</h1>
		<p>The address may have changed. The homepage is the surest way back.</p>
		<div class="actions"><a class="btn" href="<?php echo esc_url(home_url('/')); ?>">Back to the homepage</a></div>
	</div>
</section>
<?php
get_footer();
