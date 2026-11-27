<?php
/**
 * Site footer.
 *
 * @package Horizon
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
		<a class="logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Horizon Global Summits">
			<img class="logo-for-dark" src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo-horizon.png'); ?>" alt="" />
			<img class="logo-for-light" src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo-horizon-dark.png'); ?>" alt="" />
		</a>
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
		<?php hohorizon_footer_quick_fallback(); ?>
	</div>
	<div>
		<h2>Contact</h2>
		<ul>
			<li><a href="mailto:<?php echo esc_attr(hohorizon_mod('public_email')); ?>"><?php echo hohorizon_menu_icon('email'); ?><?php echo esc_html(hohorizon_mod('public_email')); ?></a></li>
			<li><span class="contact-line"><?php echo hohorizon_menu_icon('address'); ?><?php echo esc_html(hohorizon_mod('office')); ?></span></li>
			<li><span class="contact-line"><?php echo hohorizon_menu_icon('business hours'); ?><?php echo esc_html(hohorizon_mod('hours')); ?></span></li>
		</ul>
	</div>
	<div class="fineprint">
		<span>© <?php echo esc_html(gmdate('Y')); ?> Horizon Global Summits. All Rights Reserved.</span>
		<nav class="legal" aria-label="Legal">
			<a href="<?php echo esc_url(hohorizon_page_url('terms')); ?>">Terms and conditions</a>
			<a href="<?php echo esc_url(hohorizon_page_url('privacy')); ?>">Privacy</a>
			<a href="<?php echo esc_url(hohorizon_page_url('cookies')); ?>">Cookie policy</a>
			<a href="<?php echo esc_url(hohorizon_page_url('manage-cookies')); ?>">Manage Cookies</a>
		</nav>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
