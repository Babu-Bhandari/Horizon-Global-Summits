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
				<h1><?php echo preg_replace('/here\./', '<span class="hero-here">here.</span>', esc_html(hohorizon_mod('cta_title')), 1); ?></h1>
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
			<p class="eyebrow">Explore our upcoming events</p>
			<h2>The next business meet.</h2>
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
		<p class="section-lead">Write to the forum at connect@horizonglobalsummits.com.</p>
		<div class="contact-split has-map">
			<div>
				<?php
				hohorizon_form(
					'contact',
					array(
						array('name' => 'name', 'label' => 'Name', 'autocomplete' => 'name'),
						array('name' => 'email', 'label' => 'Work email', 'type' => 'email', 'autocomplete' => 'email'),
						array('name' => 'organisation', 'label' => 'Organisation', 'autocomplete' => 'organization'),
						array('name' => 'role', 'label' => 'Job title', 'autocomplete' => 'organization-title'),
						array('name' => 'phone', 'label' => 'Phone (optional)', 'type' => 'tel', 'autocomplete' => 'tel', 'optional' => true),
						array('name' => 'country', 'label' => 'Country', 'type' => 'select', 'autocomplete' => 'country-name', 'options' => hohorizon_countries()),
						array(
							'name'    => 'enquiry',
							'label'   => 'How can we help',
							'type'    => 'select',
							'wide'    => true,
							'options' => array('Request an invitation', 'Become a partner', 'Speaking opportunity', 'Sponsorship', 'Media enquiry', 'General question'),
						),
						array('name' => 'message', 'label' => 'Message', 'type' => 'textarea', 'wide' => true),
					),
					'Send message'
				);
				?>
			</div>
			<aside class="contact-facts">
				<p class="eyebrow">Reach us</p>
				<h3>The forum desk</h3>
				<article class="contact-fact">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 13a8 8 0 0 1 16 0"/><path d="M4 13v4a2 2 0 0 0 2 2h1v-6H6a2 2 0 0 0-2 2zM20 13v4a2 2 0 0 1-2 2h-1v-6h1a2 2 0 0 1 2 2z"/><path d="M12 19v2"/></svg>
					<p><small>Info line</small><strong>To be confirmed</strong></p>
				</article>
				<article class="contact-fact">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>
					<p><small>Email address</small><strong><a href="mailto:<?php echo esc_attr(hohorizon_mod('public_email')); ?>"><?php echo esc_html(hohorizon_mod('public_email')); ?></a></strong></p>
				</article>
				<article class="contact-fact">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 20V8l8-4 8 4v12"/><path d="M9 20v-6h6v6"/><path d="M9 10h.01M15 10h.01"/></svg>
					<p><small>Head office</small><strong><?php echo esc_html(hohorizon_mod('office')); ?></strong></p>
				</article>
				<article class="contact-fact">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path d="M12 8v5l3 2"/></svg>
					<p><small>Business hours</small><strong><?php echo esc_html(hohorizon_mod('hours')); ?></strong></p>
				</article>
			</aside>
			<aside class="contact-map">
				<p class="eyebrow">Location</p>
				<h3>Dubai, United Arab Emirates</h3>
				<iframe title="Map of Dubai, United Arab Emirates" src="https://maps.google.com/maps?q=Dubai%2C%20United%20Arab%20Emirates&amp;hl=en&amp;z=11&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				<a href="https://www.google.com/maps/search/?api=1&amp;query=Dubai%2C%20United%20Arab%20Emirates" target="_blank" rel="noopener noreferrer">Open in Google Maps</a>
			</aside>
		</div>
	</div>
</section>

<?php
$cta_image = hohorizon_mod('cta_image');
if (strpos($cta_image, 'photo-1497366754035') !== false) {
	$cta_image = hohorizon_defaults()['cta_image'];
}
?>
<section class="cta" style="background-image:url('<?php echo esc_url($cta_image); ?>')">
	<div class="wrap">
		<p class="eyebrow"><?php echo esc_html(hohorizon_mod('cta_eyebrow')); ?></p>
		<h2><?php echo esc_html(hohorizon_mod('cta_title')); ?></h2>
		<div class="actions"><a class="btn" href="<?php echo esc_url(hohorizon_page_url('invitation')); ?>">Request an invitation</a></div>
	</div>
</section>
<?php
get_footer();
