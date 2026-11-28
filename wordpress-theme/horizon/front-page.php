<?php
/**
 * Homepage.
 *
 * @package Horizon
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();

?>
<section class="hero hero-net" data-hero>
	<video class="hero-bg-video" autoplay muted loop playsinline webkit-playsinline disablepictureinpicture disableremoteplayback preload="auto" aria-hidden="true" tabindex="-1"><source src="<?php echo esc_url(get_template_directory_uri() . '/assets/hero-bg.mp4'); ?>" type="video/mp4" /></video>
	<canvas class="hero-net-canvas" aria-hidden="true"></canvas>
	<div class="hero-inner">
		<div class="hero-lead">
			<p class="eyebrow">Horizon Global Summits</p>
			<h1><?php echo esc_html(hohorizon_mod('hero_title')); ?></h1>
			<div class="rule"></div>
			<div class="hero-actions">
				<a class="btn" href="#contact">Request an invitation</a>
				<a class="hero-cpd" href="https://thecpdregister.com/providers/cpd-group-providers--791599" target="_blank" rel="noopener" aria-label="CPD Approved Provider #791599, verify on thecpdregister.com"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/cpd-approved-provider.jpeg'); ?>" alt="The CPD Group Approved Provider #791599" width="1552" height="531" /></a>
			</div>
		</div>
		<?php
		$hohorizon_columns = array(
			'col-up'   => array('1540575467063-178a50c2df87', '1515187029135-18ee286d815b', '1559223607-a43c990c692c', '1475721027785-f74eccf877e2'),
			'col-down' => array('1505373877841-8d25f7d46678', '1512453979798-5ea266f8880c', '1511578314322-379afb476865', '1587825140708-dfaf72ae4b04'),
		);
		?>
		<div class="hero-visual hero-columns" aria-hidden="true">
			<?php foreach ($hohorizon_columns as $hohorizon_class => $hohorizon_ids) : ?>
				<div class="photo-col <?php echo esc_attr($hohorizon_class); ?>"><div class="photo-track">
					<?php for ($hohorizon_pass = 0; $hohorizon_pass < 2; $hohorizon_pass++) : ?>
						<?php foreach ($hohorizon_ids as $hohorizon_id) : ?>
							<figure class="photo-tile"><img src="<?php echo esc_url('https://images.unsplash.com/photo-' . $hohorizon_id . '?auto=format&fit=crop&w=600&q=80'); ?>" alt="" loading="lazy" /></figure>
						<?php endforeach; ?>
					<?php endfor; ?>
				</div></div>
			<?php endforeach; ?>
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
			<div class="next-meet-heading">
				<h2 class="about-display">Upcoming Conferences</h2>
				<p class="section-lead">Your next global connection starts here.</p>
			</div>
		</div>
		<div class="conf-scroller">
			<div class="conf-track" tabindex="0" aria-label="Upcoming conferences">
				<?php hohorizon_conference_cards(); ?>
			</div>
			<div class="conf-nav" hidden>
				<button type="button" class="conf-arrow" data-conf-prev aria-label="Previous conferences"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M11 6l-6 6 6 6"/></svg></button>
				<div class="conf-dots" data-conf-dots></div>
				<button type="button" class="conf-arrow" data-conf-next aria-label="Next conferences"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></button>
			</div>
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
						array('name' => 'organisation', 'label' => 'Company', 'autocomplete' => 'organization'),
						array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'autocomplete' => 'email'),
						array('name' => 'phone', 'label' => 'Contact number', 'type' => 'tel', 'autocomplete' => 'tel'),
						array(
							'name'    => 'enquiry',
							'label'   => 'I want to',
							'type'    => 'select',
							'wide'    => true,
							'options' => array('Request an Invitation', 'Become a Partner', 'Explore Speaking Opportunity'),
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
