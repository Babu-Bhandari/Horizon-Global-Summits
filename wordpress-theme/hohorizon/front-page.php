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
$hero      = hohorizon_hero_still();
$title     = hohorizon_hero_lines();
?>
<section class="hero">
	<div class="hero-bg" style="background-image:url('<?php echo esc_url($hero); ?>')"></div>
	<?php if ($video_url) : ?>
		<video class="hero-video" hidden autoplay muted loop playsinline poster="<?php echo esc_url($hero); ?>">
			<source src="<?php echo esc_url($video_url); ?>" type="video/mp4" />
		</video>
	<?php endif; ?>
	<div class="hero-shade"></div>
	<div class="hero-copy">
		<div class="hero-lead">
			<h1><span><?php echo esc_html($title[0]); ?></span><span><?php echo esc_html($title[1]); ?></span><span><?php echo esc_html($title[2]); ?></span></h1>
			<div class="rule"></div>
			<div class="hero-actions">
				<a class="btn" href="<?php echo esc_url(hohorizon_page_url('become-a-partner')); ?>"><?php echo esc_html(hohorizon_mod('button_partner')); ?></a>
				<a class="btn" href="<?php echo esc_url(hohorizon_page_url('invitation')); ?>"><?php echo esc_html(hohorizon_mod('button_invite')); ?></a>
			</div>
		</div>
	</div>
</section>

<section class="section company-section">
	<?php get_template_part('template-parts/companies'); ?>
	<div class="wrap">
		<article class="about-card">
			<div class="frame">
				<img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=1400&q=80" alt="A small group in discussion" />
			</div>
			<div>
				<p class="about-display">About us</p>
				<p class="eyebrow">Who we are</p>
				<h2>A forum for people who can speak for a decision.</h2>
				<p class="lede">HOHORIZON GLOBAL AFFAIRS hosts international business conversations that stay specific, civil and useful. Executives, investors, policymakers and operators sit together with a clear programme and time left for the meeting that does not fit on a panel.</p>
				<div class="about-stats">
					<p><strong data-count="750" data-suffix="+">750+</strong><span>Delegates</span></p>
					<p><strong data-count="300" data-suffix="+">300+</strong><span>Companies represented</span></p>
					<p><strong data-count="60" data-suffix="%">60%</strong><span>C-suite &amp; director-level attendees</span></p>
					<p><strong data-count="25" data-suffix="+">25+</strong><span>Industry speakers</span></p>
					<p><strong data-count="20" data-suffix="+">20+</strong><span>Partners</span></p>
					<p><strong data-count="200" data-suffix="k+">200k+</strong><span>Digital reach</span></p>
				</div>
			</div>
		</article>
	</div>
</section>

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
			if ($meets->have_posts()) :
				while ($meets->have_posts()) :
					$meets->the_post();
					$image = hohorizon_image_url(get_the_ID());
					?>
					<article class="meet-card">
						<?php if ($image) : ?><img src="<?php echo esc_url($image); ?>" alt="" /><?php endif; ?>
						<div>
							<h3><?php the_title(); ?></h3>
							<p class="where"><span>Location :</span> <?php echo esc_html(hohorizon_mod('venue')); ?></p>
							<a class="meet-visit" href="<?php the_permalink(); ?>">View details</a>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</div>
	</div>
</section>

<?php hohorizon_speaker_stage('h2', true); ?>

<section class="section home-panel" id="agenda">
	<div class="wrap">
		<h2 class="about-display">Agenda</h2>
		<p class="section-lead">A sample of the day. Times, speakers and titles stay as placeholders until the programme is confirmed.</p>
		<?php hohorizon_filters(); ?>
		<?php
		$sessions = hohorizon_query('hoh_session', 4);
		while ($sessions->have_posts()) {
			$sessions->the_post();
			hohorizon_session_row();
		}
		wp_reset_postdata();
		?>
		<div class="actions" style="justify-content:center"><a class="btn btn-ink" href="<?php echo esc_url(hohorizon_page_url('programme')); ?>">Full programme</a></div>
	</div>
</section>

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
		<p class="section-lead">Write to the forum. The public email address will be added when it is confirmed.</p>
		<div class="contact-split">
			<div>
				<?php
				hohorizon_form(
					'contact',
					array(
						array('name' => 'name', 'label' => 'Name', 'autocomplete' => 'name'),
						array('name' => 'email', 'label' => 'Email', 'type' => 'email', 'autocomplete' => 'email'),
						array('name' => 'message', 'label' => 'Message', 'type' => 'textarea'),
					),
					'Send'
				);
				?>
			</div>
			<div class="contact-facts">
				<article class="contact-fact">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 13a8 8 0 0 1 16 0"/><path d="M4 13v4a2 2 0 0 0 2 2h1v-6H6a2 2 0 0 0-2 2zM20 13v4a2 2 0 0 1-2 2h-1v-6h1a2 2 0 0 1 2 2z"/><path d="M12 19v2"/></svg>
					<p><small>Info line</small><strong>To be confirmed</strong></p>
				</article>
				<article class="contact-fact">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>
					<p><small>Email address</small><strong><?php echo esc_html(hohorizon_mod('public_email')); ?></strong></p>
				</article>
				<article class="contact-fact">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 20V8l8-4 8 4v12"/><path d="M9 20v-6h6v6"/><path d="M9 10h.01M15 10h.01"/></svg>
					<p><small>Head office</small><strong><?php echo esc_html(hohorizon_mod('venue')); ?></strong></p>
				</article>
				<article class="contact-fact">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path d="M12 8v5l3 2"/></svg>
					<p><small>Business hours</small><strong>To be confirmed</strong></p>
				</article>
			</div>
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
		<p class="lede" style="margin-top:16px;color:rgba(251,250,247,.86)"><?php echo esc_html(hohorizon_mod('cta_text')); ?></p>
		<div class="actions"><a class="btn" href="<?php echo esc_url(hohorizon_page_url('invitation')); ?>">Request an invitation</a></div>
	</div>
</section>
<?php
get_footer();
