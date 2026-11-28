<?php
/**
 * Homepage About section.
 * This file is in the main theme folder so it shows in Appearance → Theme File Editor.
 *
 * @package Horizon
 */

if (!defined('ABSPATH')) {
	exit;
}
?>
<section class="section about-section" id="about">
	<div class="wrap">
		<article class="about-card">
			<div class="frame">
				<img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=1000&q=80" alt="Executives in a boardroom meeting during a presentation" />
			</div>
			<div>
				<p class="about-display">About us</p>
				<p class="lede">Horizon Global Summits is a UAE-based international B2B conference and executive summit organisation dedicated to bringing together business leaders, senior executives, industry experts and key decision-makers from across the globe.</p>
				<p class="lede">Through thoughtfully curated international conferences, executive leadership forums and industry-focused summits, we create distinguished platforms for meaningful dialogue, knowledge exchange, strategic networking and impactful business partnerships.</p>
				<p class="lede">Driven by a global vision and an unwavering commitment to excellence, we strive to bridge industries, foster cross-border collaboration and unlock new opportunities for business growth. By connecting influential minds and organisations, Horizon Global Summits aims to transform meaningful conversations into strategic alliances, sustainable opportunities and lasting global impact.</p>
			</div>
		</article>
		<?php $hg_cert = get_template_directory_uri() . '/assets/cpd-certificate.jpeg'; ?>
		<article class="cpd-panel">
			<div class="cpd-copy">
				<p class="cpd-kicker">Accredited &amp; verified</p>
				<h3 class="cpd-title">We are an approved CPD provider</h3>
				<p class="lede">At Horizon Global Summits, we know your time is valuable, and we want you to get the most out of every event you attend. From learning new industry insights to hearing from experienced professionals, our conferences are designed to give you something valuable to take back.</p>
				<p class="lede">And there&#39;s more! As we are a CDP-accredited event organiser, you can also earn Career Development Points (CDPs) by attending our events, making your time with us even more rewarding.</p>
				<div class="cpd-meta">
					<a class="cpd-badge" href="https://thecpdregister.com/providers/cpd-group-providers--791599" target="_blank" rel="noopener" aria-label="Verify CPD Approved Provider #791599 on thecpdregister.com"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/cpd-approved-provider.jpeg'); ?>" alt="The CPD Group Approved Provider #791599" width="1552" height="531" loading="lazy" /></a>
					<dl class="cpd-facts">
						<div><dt>Provider no.</dt><dd>#791599</dd></div>
						<div><dt>Issued</dt><dd>26 Nov 2026</dd></div>
					</dl>
				</div>
			</div>
			<figure class="cpd-cert">
				<button type="button" class="cpd-cert-frame" data-cert-open="<?php echo esc_url($hg_cert); ?>" aria-label="View the CPD Approved Provider certificate full size">
					<img src="<?php echo esc_url($hg_cert); ?>" alt="Certificate from The CPD Group confirming Horizon Global Summits is an Approved CPD Provider, number 791599, issued 26/11/2026" width="1599" height="1131" loading="lazy" />
					<span class="cpd-cert-zoom" aria-hidden="true"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5M11 8v6M8 11h6"/></svg>View certificate</span>
				</button>
				<figcaption>Official certificate of approval &middot; The CPD Group</figcaption>
			</figure>
		</article>
	</div>
</section>
