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
			<strong><?php echo esc_html(hohorizon_mod('line1')); ?><br /><?php echo esc_html(hohorizon_mod('line2')); ?><br /><?php echo esc_html(hohorizon_mod('line3')); ?></strong>
			<span><?php echo esc_html(hohorizon_mod('mark')); ?></span>
		</a>
		<p style="margin-top:16px;max-width:28rem;color:rgba(251,250,247,.78)"><?php echo esc_html(hohorizon_mod('footer_text')); ?></p>
		<div class="socials" aria-label="Social media">
			<?php foreach ($socials as $key => $label) : ?>
				<?php $url = hohorizon_mod($key); ?>
				<?php if ($url) : ?>
					<a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a>
				<?php else : ?>
					<span><?php echo esc_html($label); ?> — to be added</span>
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
		<?php
		hohorizon_form(
			'newsletter',
			array(
				array('name' => 'email', 'label' => 'Newsletter', 'type' => 'email', 'placeholder' => 'Email address'),
			),
			'Subscribe'
		);
		?>
	</div>
	<div class="fineprint">
		<span>© <?php echo esc_html(gmdate('Y')); ?> <?php echo esc_html(hohorizon_mod('line1')); ?> <?php echo esc_html(hohorizon_mod('line2')); ?> <?php echo esc_html(hohorizon_mod('line3')); ?></span>
		<span>Placeholders are not confirmed facts.</span>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
