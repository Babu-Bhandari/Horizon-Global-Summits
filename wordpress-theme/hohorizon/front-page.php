<?php
/**
 * Homepage.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();

$video_id  = absint(get_theme_mod('hohorizon_hero_video', 0));
$video_url = $video_id ? wp_get_attachment_url($video_id) : get_template_directory_uri() . '/assets/hero.mp4';
?>
<section class="hero" data-hero>
	<div class="hero-slide is-on">
		<?php if ($video_url) : ?>
			<video class="hero-video" autoplay muted loop playsinline>
				<source src="<?php echo esc_url($video_url); ?>" type="video/mp4" />
			</video>
		<?php endif; ?>
		<div class="hero-shade"></div>
		<div class="hero-copy">
			<div class="hero-lead">
				<p class="eyebrow">Horizon Global Summits</p>
				<h1><?php echo esc_html(hohorizon_mod('hero_title')); ?></h1>
				<div class="rule"></div>
				<div class="hero-actions">
					<span class="btn">Request an invitation</span>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_template_part('about'); ?>

<section class="section next-meet" id="next-meet">
	<div class="wrap next-meet-grid">
		<div class="next-meet-copy">
			<p class="eyebrow">Explore our upcoming conferences</p>
			<h2>Your next global connection starts here.</h2>
			<a class="next-meet-link" href="<?php echo esc_url(hohorizon_page_url('events')); ?>">View all</a>
		</div>
		<div class="next-meet-cards">
			<?php
			$meets = hohorizon_query('hoh_event', 2);
			$fallbacks = array(
				array(
					'title' => 'Horizon flagship forum',
					'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80',
					'alt'   => 'Delegates seated at a conference',
					'url'   => hohorizon_page_url('events'),
				),
				array(
					'title' => 'Horizon private briefing',
					'image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80',
					'alt'   => 'A conference hall prepared for a meeting',
					'url'   => hohorizon_page_url('events'),
				),
			);
			$shown = 0;
			if ($meets->have_posts()) :
				while ($meets->have_posts()) :
					$meets->the_post();
					$image = hohorizon_image_url(get_the_ID(), '_hohorizon_image', $fallbacks[$shown]['image']);
					?>
					<article class="meet-card">
						<img src="<?php echo esc_url($image); ?>" alt="" />
						<div>
							<h3><?php the_title(); ?></h3>
							<p class="where"><span>Location :</span> <?php echo esc_html(hohorizon_mod('venue')); ?></p>
							<span class="meet-visit">View details</span>
						</div>
					</article>
					<?php
					$shown++;
				endwhile;
				wp_reset_postdata();
			endif;
			while ($shown < 2) :
				$card = $fallbacks[$shown];
				?>
				<article class="meet-card">
					<img src="<?php echo esc_url($card['image']); ?>" alt="<?php echo esc_attr($card['alt']); ?>" />
					<div>
						<h3><?php echo esc_html($card['title']); ?></h3>
						<p class="where"><span>Location :</span> <?php echo esc_html(hohorizon_mod('venue')); ?></p>
						<span class="meet-visit">View details</span>
					</div>
				</article>
				<?php
				$shown++;
			endwhile;
			?>
		</div>
	</div>
</section>

<?php hohorizon_speaker_stage('h2', true); ?>

<section class="section home-panel" id="partners">
	<div class="wrap">
		<h2 class="about-display">Partners</h2>
		<p class="section-lead">Logo places for organisations that help shape the gathering. A name appears here only after the partnership is agreed.</p>
		<?php hohorizon_partner_row(4); ?>
		<div class="actions" style="justify-content:center"><a class="btn btn-ink" href="<?php echo esc_url(hohorizon_page_url('partners')); ?>">Partner page</a></div>
	</div>
</section>

<section class="section home-panel" id="media">
	<div class="wrap">
		<h2 class="about-display">Media</h2>
		<p class="section-lead">Gatherings on the calendar. Dates, venues and coverage are published when they are fixed.</p>
		<?php hohorizon_event_list(2); ?>
		<div class="actions" style="justify-content:center"><a class="btn btn-ink" href="<?php echo esc_url(hohorizon_page_url('events')); ?>">All events</a></div>
	</div>
</section>

<section class="section home-panel" id="contact">
	<div class="wrap">
		<h2 class="about-display">Contact us</h2>
		<div class="contact-split is-solo">
			<div>
				<?php
				hohorizon_form(
					'contact',
					array(
						array('name' => 'name', 'label' => 'Name', 'autocomplete' => 'name'),
						array('name' => 'organisation', 'label' => 'Company / Organisation', 'autocomplete' => 'organization'),
						array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'autocomplete' => 'email'),
						array('name' => 'phone', 'label' => 'Contact number', 'type' => 'tel', 'autocomplete' => 'tel'),
						array(
							'name'    => 'enquiry',
							'label'   => 'I want to',
							'type'    => 'select',
							'wide'    => true,
							'options' => array('Become a Partner', 'Explore Speaking Opportunity'),
						),
					),
					'Send message'
				);
				?>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
