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
$hero      = hohorizon_mod('hero_image');
$streams   = array_map('trim', explode(',', hohorizon_mod('streams')));
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
			<h1><span><?php echo esc_html(hohorizon_mod('line1')); ?></span><span><?php echo esc_html(hohorizon_mod('line2')); ?></span><span><?php echo esc_html(hohorizon_mod('line3')); ?></span></h1>
			<div class="rule"></div>
			<p class="striped"><?php echo esc_html(hohorizon_mod('mark')); ?></p>
			<div class="hero-actions">
				<a class="btn" href="<?php echo esc_url(hohorizon_page_url('become-a-partner')); ?>"><?php echo esc_html(hohorizon_mod('button_partner')); ?></a>
				<a class="btn" href="<?php echo esc_url(hohorizon_page_url('invitation')); ?>"><?php echo esc_html(hohorizon_mod('button_invite')); ?></a>
			</div>
			<p class="hero-when"><?php echo esc_html(hohorizon_mod('hero_name')); ?><br /><?php echo esc_html(hohorizon_mod('hero_date')); ?><br /><?php echo esc_html(hohorizon_mod('hero_venue')); ?></p>
		</div>
		<div class="hero-side">
			<p class="hero-side-title"><?php echo wp_kses(nl2br(esc_html(hohorizon_mod('hero_side'))), array('br' => array())); ?></p>
			<ul class="streams">
				<?php foreach ($streams as $stream) : ?>
					<?php if ($stream !== '') : ?>
						<li><?php echo esc_html($stream); ?></li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
			<div class="clock" data-countdown="<?php echo esc_attr(hohorizon_mod('countdown')); ?>" aria-label="Countdown. The date is still to be confirmed until a date is saved.">
				<div><b data-unit="days">--</b><span>Days</span></div>
				<div><b data-unit="hours">--</b><span>Hours</span></div>
				<div><b data-unit="minutes">--</b><span>Minutes</span></div>
				<div><b data-unit="seconds">--</b><span>Seconds</span></div>
			</div>
		</div>
	</div>
</section>

<section class="marquee" aria-hidden="true">
	<div class="marquee-track">
		<?php for ($copy = 0; $copy < 2; $copy++) : ?>
			<?php foreach ($streams as $stream) : ?>
				<?php if ($stream !== '') : ?>
					<span><?php echo esc_html($stream); ?></span>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endfor; ?>
	</div>
</section>

<section class="section">
	<div class="wrap split">
		<div class="frame">
			<img src="<?php echo esc_url(hohorizon_mod('welcome_image')); ?>" alt="" />
		</div>
		<div>
			<p class="eyebrow"><?php echo esc_html(hohorizon_mod('welcome_eyebrow')); ?></p>
			<h2><?php echo esc_html(hohorizon_mod('welcome_title')); ?></h2>
			<?php foreach (preg_split("/\n\s*\n/", hohorizon_mod('welcome_text')) as $paragraph) : ?>
				<?php if (trim($paragraph) !== '') : ?>
					<p class="lede" style="margin-top:22px"><?php echo esc_html(trim($paragraph)); ?></p>
				<?php endif; ?>
			<?php endforeach; ?>
			<div class="actions">
				<a class="btn btn-ink" href="<?php echo esc_url(hohorizon_page_url('about')); ?>">Read more</a>
			</div>
		</div>
	</div>
</section>

<section class="section band">
	<div class="wrap">
		<div class="section-head">
			<div>
				<p class="eyebrow"><?php echo esc_html(hohorizon_mod('stats_eyebrow')); ?></p>
				<h2><?php echo esc_html(hohorizon_mod('stats_title')); ?></h2>
			</div>
		</div>
		<div class="stats">
			<?php foreach (hohorizon_stats() as $stat) : ?>
				<article class="stat">
					<p class="stat-value"><?php echo esc_html($stat[1]); ?></p>
					<p class="stat-label"><?php echo esc_html($stat[0]); ?></p>
					<?php if ($stat[2] !== '') : ?><p class="note"><?php echo esc_html($stat[2]); ?></p><?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php $highlights = hohorizon_query('hoh_highlight'); ?>
<?php if ($highlights->have_posts()) : ?>
	<section class="section">
		<div class="wrap">
			<div class="section-head">
				<div>
					<p class="eyebrow"><?php echo esc_html(hohorizon_mod('expect_eyebrow')); ?></p>
					<h2><?php echo esc_html(hohorizon_mod('expect_title')); ?></h2>
				</div>
			</div>
			<div class="cards">
				<?php $number = 1; ?>
				<?php while ($highlights->have_posts()) : $highlights->the_post(); ?>
					<article class="card">
						<?php $image = hohorizon_image_url(get_the_ID()); ?>
						<?php if ($image) : ?><img src="<?php echo esc_url($image); ?>" alt="" /><?php endif; ?>
						<div>
							<p class="eyebrow"><?php echo esc_html(str_pad((string) $number, 2, '0', STR_PAD_LEFT)); ?></p>
							<h3><?php the_title(); ?></h3>
							<p><?php echo esc_html(has_excerpt() ? get_the_excerpt() : wp_strip_all_tags(get_the_content())); ?></p>
						</div>
					</article>
					<?php $number++; ?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="section paper">
	<div class="wrap">
		<div class="section-head">
			<div>
				<p class="eyebrow"><?php echo esc_html(hohorizon_mod('events_eyebrow')); ?></p>
				<h2><?php echo esc_html(hohorizon_mod('events_title')); ?></h2>
			</div>
			<a class="btn btn-ink" href="<?php echo esc_url(hohorizon_page_url('events')); ?>">All events</a>
		</div>
		<?php hohorizon_event_list(2); ?>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="section-head">
			<div>
				<p class="eyebrow"><?php echo esc_html(hohorizon_mod('programme_eyebrow')); ?></p>
				<h2><?php echo esc_html(hohorizon_mod('programme_title')); ?></h2>
			</div>
			<a class="btn btn-ink" href="<?php echo esc_url(hohorizon_page_url('programme')); ?>">Full programme</a>
		</div>
		<p class="lede" style="margin-bottom:22px"><?php echo esc_html(hohorizon_mod('programme_note')); ?></p>
		<?php hohorizon_filters(); ?>
		<?php
		$sessions = hohorizon_query('hoh_session', 4);
		while ($sessions->have_posts()) {
			$sessions->the_post();
			hohorizon_session_row();
		}
		wp_reset_postdata();
		?>
	</div>
</section>

<?php $topics = hohorizon_query('hoh_topic'); ?>
<?php if ($topics->have_posts()) : ?>
	<section class="section paper">
		<div class="wrap topics">
			<div class="section-head">
				<div>
					<p class="eyebrow"><?php echo esc_html(hohorizon_mod('topics_eyebrow')); ?></p>
					<h2><?php echo esc_html(hohorizon_mod('topics_title')); ?></h2>
				</div>
			</div>
			<?php $number = 1; ?>
			<?php while ($topics->have_posts()) : $topics->the_post(); ?>
				<article class="topic">
					<?php $image = hohorizon_image_url(get_the_ID()); ?>
					<?php if ($image) : ?><img src="<?php echo esc_url($image); ?>" alt="" /><?php endif; ?>
					<div>
						<p class="eyebrow"><?php echo esc_html(str_pad((string) $number, 2, '0', STR_PAD_LEFT)); ?></p>
						<h2><?php the_title(); ?></h2>
						<p class="lede" style="margin-top:14px"><?php echo esc_html(wp_strip_all_tags(get_the_content())); ?></p>
						<?php $related = get_post_meta(get_the_ID(), '_hohorizon_related', true); ?>
						<?php if ($related) : ?><p class="lede"><?php echo esc_html($related); ?></p><?php endif; ?>
					</div>
				</article>
				<?php $number++; ?>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</section>
<?php endif; ?>

<section class="section">
	<div class="wrap">
		<div class="section-head">
			<div>
				<p class="eyebrow"><?php echo esc_html(hohorizon_mod('speakers_eyebrow')); ?></p>
				<h2><?php echo esc_html(hohorizon_mod('speakers_title')); ?></h2>
			</div>
			<a class="btn btn-ink" href="<?php echo esc_url(hohorizon_page_url('speakers')); ?>">All profiles</a>
		</div>
		<?php hohorizon_speaker_list(3, true); ?>
	</div>
</section>

<section class="section paper">
	<div class="wrap">
		<div class="section-head">
			<div>
				<p class="eyebrow"><?php echo esc_html(hohorizon_mod('partners_eyebrow')); ?></p>
				<h2><?php echo esc_html(hohorizon_mod('partners_title')); ?></h2>
			</div>
			<a class="btn btn-ink" href="<?php echo esc_url(hohorizon_page_url('partners')); ?>">Partner page</a>
		</div>
		<?php hohorizon_partner_row(4); ?>
	</div>
</section>

<section class="section">
	<div class="wrap split">
		<div>
			<p class="eyebrow"><?php echo esc_html(hohorizon_mod('member_eyebrow')); ?></p>
			<h2><?php echo esc_html(hohorizon_mod('member_title')); ?></h2>
			<p class="lede" style="margin-top:18px"><?php echo esc_html(hohorizon_mod('member_text')); ?></p>
			<ul class="lede" style="margin-top:16px;padding-left:18px">
				<?php foreach (hohorizon_lines(hohorizon_mod('member_points')) as $point) : ?>
					<li><?php echo esc_html($point); ?></li>
				<?php endforeach; ?>
			</ul>
			<div class="actions">
				<a class="btn btn-ink" href="<?php echo esc_url(hohorizon_page_url('membership')); ?>">Become a member</a>
				<a class="btn btn-ink" href="<?php echo esc_url(hohorizon_page_url('become-a-partner')); ?>"><?php echo esc_html(hohorizon_mod('button_partner')); ?></a>
			</div>
		</div>
		<div class="frame">
			<img src="<?php echo esc_url(hohorizon_mod('member_image')); ?>" alt="" />
		</div>
	</div>
</section>

<section class="cta" style="background-image:url('<?php echo esc_url(hohorizon_mod('cta_image')); ?>')">
	<div class="wrap">
		<p class="eyebrow"><?php echo esc_html(hohorizon_mod('cta_eyebrow')); ?></p>
		<h2><?php echo esc_html(hohorizon_mod('cta_title')); ?></h2>
		<p class="lede" style="margin-top:16px;color:rgba(251,250,247,.86)"><?php echo esc_html(hohorizon_mod('cta_text')); ?></p>
		<div class="actions"><a class="btn" href="<?php echo esc_url(hohorizon_page_url('invitation')); ?>">Request an invitation</a></div>
	</div>
</section>
<?php
get_footer();
