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

?>
<section class="hero hero-net" data-hero>
	<canvas class="hero-net-canvas" aria-hidden="true"></canvas>
	<div class="hero-inner">
		<div class="hero-lead">
			<p class="eyebrow">Horizon Global Summits</p>
			<h1><?php echo esc_html(hohorizon_mod('hero_title')); ?></h1>
			<div class="rule"></div>
			<div class="hero-actions">
				<a class="btn" href="#contact">Request an invitation</a>
			</div>
		</div>
		<div class="hero-visual" aria-hidden="true">
			<div class="hero-orbit">
				<div class="hero-blob">
					<img class="is-on" src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&amp;fit=crop&amp;w=1000&amp;q=80" alt="" />
					<img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?auto=format&amp;fit=crop&amp;w=1000&amp;q=80" alt="" loading="lazy" />
					<img src="https://images.unsplash.com/photo-1559223607-a43c990c692c?auto=format&amp;fit=crop&amp;w=1000&amp;q=80" alt="" loading="lazy" />
					<img src="https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&amp;fit=crop&amp;w=1000&amp;q=80" alt="" loading="lazy" />
				</div>
			</div>
		</div>
	</div>
	<svg class="hero-fan" viewBox="0 0 1440 90" preserveAspectRatio="none" aria-hidden="true">
		<path opacity="0.25" d="M0 90V30C240 70 480 10 720 40s480 40 720-10v60z" />
		<path opacity="0.45" d="M0 90V50C260 80 500 30 760 55s440 25 680-5v40z" />
		<path d="M0 90V70C300 92 560 58 820 72s420 12 620-4v22z" />
	</svg>
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
