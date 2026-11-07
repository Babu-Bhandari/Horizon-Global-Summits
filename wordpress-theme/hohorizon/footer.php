<?php
/**
 * Site footer.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

$socials = array(
	'linkedin'  => 'LinkedIn',
	'instagram' => 'Instagram',
	'youtube'   => 'YouTube',
	'facebook'  => 'Facebook',
);
?>
</main>
<footer class="site-footer">
	<div>
		<a class="logo" href="<?php echo esc_url(home_url('/')); ?>">
			<strong>HORIZON<br />GLOBAL<br />SUMMITS</strong>
		</a>
		<p class="footer-blurb"><?php echo esc_html(hohorizon_mod('footer_text')); ?></p>
		<div class="socials" aria-label="Social media">
			<?php foreach ($socials as $key => $label) : ?>
				<?php $url = hohorizon_mod($key); ?>
				<?php if ($url) : ?>
					<a href="<?php echo esc_url($url); ?>" aria-label="<?php echo esc_attr($label); ?>"><?php echo hohorizon_social_icon($key); ?></a>
				<?php else : ?>
					<span aria-label="<?php echo esc_attr($label); ?>, to be added"><?php echo hohorizon_social_icon($key); ?></span>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div>
		<h2>Quick links</h2>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'footer_quick',
				'container'      => false,
				'items_wrap'     => '<ul>%3$s</ul>',
				'fallback_cb'    => 'hohorizon_footer_quick_fallback',
			)
		);
		?>
	</div>
	<div>
		<h2>Explore</h2>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'footer_explore',
				'container'      => false,
				'items_wrap'     => '<ul>%3$s</ul>',
				'fallback_cb'    => 'hohorizon_footer_explore_fallback',
			)
		);
		?>
	</div>
	<div>
		<h2>Contact</h2>
		<ul>
			<li><?php echo esc_html(hohorizon_mod('public_email')); ?></li>
			<li><?php echo esc_html(hohorizon_mod('venue')); ?></li>
		</ul>
	</div>
	<div class="fineprint">
		<span>© <?php echo esc_html(gmdate('Y')); ?> Hohorizon Global Affairs. All Rights Reserved.</span>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
