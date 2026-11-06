<?php
/**
 * Template helpers.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Default text used until a Customizer value is saved.
 *
 * @return array<string, string>
 */
function hohorizon_defaults() {
	return array(
		'line1'            => 'Horizon',
		'line2'            => 'Global',
		'line3'            => 'Summits',
		'mark'             => 'Forum',
		'button_partner'   => 'Become a partner',
		'button_invite'    => 'Request an invite',
		'hero_name'        => 'HOHORIZON Global Affairs',
		'hero_date'        => 'Date to be confirmed.',
		'hero_venue'       => 'Venue to be confirmed.',
		'hero_side'        => "One focused day.\nFive live streams.",
		'streams'          => 'Finance, Risk, Trade, Technology, Leadership',
		'countdown'        => '',
		'hero_image'       => '',
		'intro_image'      => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=2000&q=80',
		'welcome_eyebrow'  => 'Welcome to HOHORIZON',
		'welcome_title'    => 'Where global leaders connect and opportunities begin.',
		'welcome_text'     => "HOHORIZON GLOBAL AFFAIRS is a forum, not a trade-show floor. It is built for people who already carry responsibility: the executive opening a new market, the investor testing a thesis, the policymaker who needs the view from the operating table.\n\nThe purpose is simple. Put the right people in one place, give them a clear programme, and leave enough time for the conversation that does not fit on a panel.",
		'welcome_image'    => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1400&q=80',
		'stats_eyebrow'    => 'The room, in numbers',
		'stats_title'      => 'Figures will be published when they are real.',
		'stats'            => "International delegates | To be confirmed | Placeholder\nParticipating companies | To be confirmed | Placeholder\nCountries represented | To be confirmed | Placeholder\nIndustry leaders | To be confirmed | Placeholder\nStrategic partners | To be confirmed | Placeholder\nGlobal reach | To be confirmed | Placeholder",
		'expect_eyebrow'   => 'What to expect',
		'expect_title'     => 'A day built around the conversation.',
		'events_eyebrow'   => 'Upcoming',
		'events_title'     => 'Gatherings on the calendar will appear here.',
		'programme_eyebrow'=> 'Sample agenda',
		'programme_title'  => 'The programme is not confirmed yet.',
		'programme_note'   => 'The rows below show the layout. Times, speakers and titles are placeholders.',
		'topics_eyebrow'   => 'Discussion areas',
		'topics_title'     => 'Five subjects. No filler track.',
		'speakers_eyebrow' => 'Speakers',
		'speakers_title'   => 'Names will be published when they are confirmed.',
		'partners_eyebrow' => 'Partners',
		'partners_title'   => 'Logo places, ready to be replaced.',
		'member_eyebrow'   => 'Membership & partnership',
		'member_title'     => 'A seat, or a role in the room.',
		'member_text'      => 'Members come for the conversations and the introductions. Partners help shape the gathering and meet the people in it. Fees, if any, will be published when each opens. Nothing on this page is an offer.',
		'member_points'    => "International networking with a host, not a directory.\nA path to executive conversations around the programme.\nVisibility only where it is agreed in advance.",
		'member_image'     => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=1400&q=80',
		'cta_eyebrow'      => 'Invitation',
		'cta_title'        => 'Your next global connection starts here.',
		'cta_text'         => 'Join an international community of business leaders and decision-makers. Applications are read. An invitation is sent only when a place is confirmed.',
		'cta_image'        => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=2000&q=80',
		'footer_text'      => 'An invitation-led forum for executives, investors, policymakers and operators who need a quieter room for serious conversations.',
		'public_email'     => 'Email to be confirmed',
		'venue'            => 'Venue to be confirmed',
		'inbox'            => '',
		'ga'               => '',
		'linkedin'         => '',
		'instagram'        => '',
		'youtube'          => '',
		'facebook'         => '',
	);
}

/**
 * A Customizer value, or its default.
 *
 * @param string $key Key without the hohorizon_ prefix.
 * @return string
 */
function hohorizon_mod($key) {
	$defaults = hohorizon_defaults();
	$default  = isset($defaults[$key]) ? $defaults[$key] : '';
	$value    = get_theme_mod('hohorizon_' . $key, $default);
	return is_string($value) ? $value : $default;
}

/**
 * Hero still shown before the film plays.
 *
 * @return string
 */
function hohorizon_hero_still() {
	$image = hohorizon_mod('hero_image');
	if ($image === '' || strpos($image, 'photo-1464037866556') !== false) {
		return get_template_directory_uri() . '/assets/hero-still.jpg';
	}
	return $image;
}

/**
 * The three hero title lines.
 *
 * @return array<int, string>
 */
function hohorizon_hero_lines() {
	$lines = array(hohorizon_mod('line1'), hohorizon_mod('line2'), hohorizon_mod('line3'));
	if ($lines === array('HOHORIZON', 'GLOBAL', 'AFFAIRS')) {
		return array('Horizon', 'Global', 'Summits');
	}
	return $lines;
}

/**
 * Menu icon for a label.
 *
 * @param string $label Menu label.
 * @return string
 */
function hohorizon_nav_icon($label) {
	$key   = strtolower(trim(wp_strip_all_tags($label)));
	$paths = array(
		'home'              => '<path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1z"/>',
		'about'             => '<circle cx="12" cy="8" r="3"/><path d="M5 19c1.2-3 3.4-4.5 7-4.5S17.8 16 19 19"/>',
		'agenda'            => '<rect x="4" y="5" width="16" height="15" rx="2"/><path d="M8 3v4M16 3v4M4 10h16"/>',
		'speakers'          => '<rect x="9" y="3" width="6" height="10" rx="3"/><path d="M6 11a6 6 0 0 0 12 0M12 17v4M8 21h8"/>',
		'partners'          => '<circle cx="8" cy="9" r="2.4"/><circle cx="16" cy="9" r="2.4"/><path d="M3.5 18.5c.7-2.4 2.3-3.5 4.5-3.5s3.8 1.1 4.5 3.5M11.5 18.5c.7-2.4 2.3-3.5 4.5-3.5s3.8 1.1 4.5 3.5"/>',
		'media'             => '<rect x="3" y="6" width="18" height="12" rx="2"/><path d="m10 9 5 3-5 3z"/>',
		'contact'           => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/>',
		'our mission'       => '<circle cx="12" cy="12" r="8"/><path d="M12 8v4l3 2"/>',
		'membership'        => '<rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/>',
		'become a partner'  => '<path d="M12 5v14M5 12h14"/>',
	);
	$path = isset($paths[$key]) ? $paths[$key] : $paths['home'];
	return '<svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>';
}

/**
 * Permalink for a page slug created by the theme.
 *
 * @param string $slug Page slug.
 * @return string
 */
function hohorizon_page_url($slug) {
	$page = get_page_by_path($slug);
	if ($page) {
		return get_permalink($page);
	}
	return home_url('/' . trim($slug, '/') . '/');
}

/**
 * Photo for a post: featured image, then a stored URL.
 *
 * @param int    $post_id Post ID.
 * @param string $meta    Meta key.
 * @param string $fallback Fallback URL.
 * @return string
 */
function hohorizon_image_url($post_id, $meta = '_hohorizon_image', $fallback = '') {
	$thumb = get_the_post_thumbnail_url($post_id, 'large');
	if ($thumb) {
		return $thumb;
	}
	$stored = get_post_meta($post_id, $meta, true);
	if (is_string($stored) && $stored !== '') {
		return $stored;
	}
	return $fallback;
}

/**
 * Split a textarea into trimmed lines.
 *
 * @param string $text Raw text.
 * @return string[]
 */
function hohorizon_lines($text) {
	$lines = preg_split('/\r\n|\r|\n/', (string) $text);
	$clean = array();
	foreach ($lines as $line) {
		$line = trim($line);
		if ($line !== '') {
			$clean[] = $line;
		}
	}
	return $clean;
}

/**
 * Stat rows: Label | Value | Note.
 *
 * @return array<int, array{0: string, 1: string, 2: string}>
 */
function hohorizon_stats() {
	$rows = array();
	foreach (hohorizon_lines(hohorizon_mod('stats')) as $line) {
		$parts = array_map('trim', explode('|', $line));
		if (count($parts) < 2 || $parts[0] === '') {
			continue;
		}
		$rows[] = array($parts[0], $parts[1], isset($parts[2]) ? $parts[2] : '');
	}
	return $rows;
}

/**
 * Session topic labels.
 *
 * @return array<string, string>
 */
function hohorizon_topics() {
	return array(
		'finance'    => 'Finance',
		'investment' => 'Investment',
		'trade'      => 'Global trade',
		'technology' => 'Technology',
		'leadership' => 'Leadership',
		'risk'       => 'Risk management',
	);
}

/**
 * Partner tiers.
 *
 * @return array<string, string>
 */
function hohorizon_tiers() {
	return array(
		'strategic'     => 'Strategic partners',
		'platinum'      => 'Platinum partners',
		'gold'          => 'Gold partners',
		'silver'        => 'Silver partners',
		'institutional' => 'Institutional partners',
		'media'         => 'Media partners',
	);
}

/**
 * Query theme content in menu order.
 *
 * @param string $type Post type.
 * @param int    $count How many. -1 for all.
 * @param array  $meta Optional meta query.
 * @return WP_Query
 */
function hohorizon_query($type, $count = -1, $meta = array()) {
	$args = array(
		'post_type'      => $type,
		'posts_per_page' => $count,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	);
	if ($meta) {
		$args['meta_query'] = $meta;
	}
	return new WP_Query($args);
}

/**
 * Page banner.
 *
 * @param int $post_id Post ID.
 */
function hohorizon_page_hero($post_id = 0) {
	$post_id = $post_id ? $post_id : get_queried_object_id();
	$image   = hohorizon_image_url($post_id, '_hohorizon_hero');
	$eyebrow = get_post_meta($post_id, '_hohorizon_eyebrow', true);
	echo '<section class="page-hero"';
	if ($image) {
		echo ' style="' . esc_attr('--hero:url(' . esc_url($image) . ')') . '"';
	}
	echo '><div class="wrap">';
	if ($eyebrow) {
		echo '<p class="eyebrow">' . esc_html($eyebrow) . '</p>';
	}
	echo '<h1>' . esc_html(get_the_title($post_id)) . '</h1>';
	if (has_excerpt($post_id)) {
		echo '<p>' . esc_html(get_the_excerpt($post_id)) . '</p>';
	}
	echo '</div></section>';
}

/**
 * Heading and paragraph pairs from a page.
 *
 * @param int $post_id Post ID.
 * @return array<int, array{title: string, text: string}>
 */
function hohorizon_pairs($post_id) {
	$post = get_post($post_id);
	if (!$post) {
		return array();
	}
	$items   = array();
	$current = null;
	foreach (parse_blocks($post->post_content) as $block) {
		if ($block['blockName'] === 'core/heading') {
			if ($current) {
				$items[] = $current;
			}
			$current = array(
				'title' => trim(wp_strip_all_tags($block['innerHTML'])),
				'text'  => '',
			);
		} elseif ($block['blockName'] === 'core/paragraph' && $current) {
			$text = trim(wp_strip_all_tags($block['innerHTML']));
			if ($text !== '') {
				$current['text'] .= ($current['text'] === '' ? '' : ' ') . $text;
			}
		}
	}
	if ($current) {
		$items[] = $current;
	}
	return $items;
}

/**
 * Sample agenda rows used until sessions are published.
 */
function hohorizon_sample_sessions() {
	$rows = array(
		array('leadership', 'Opening conversation', 'How the day will be used, and what a useful disagreement looks like.'),
		array('finance', 'Capital across borders', 'Where cross-border finance is slowing, and where it is still moving.'),
		array('investment', 'Mandates, not slogans', 'What investors are actually willing to underwrite this year.'),
		array('trade', 'Routes and resilience', 'Trade corridors, delays, and the contracts written around them.'),
	);
	foreach ($rows as $row) {
		echo '<article class="session" data-topic="' . esc_attr($row[0]) . '">';
		echo '<p>Time to be confirmed<br />Duration to be confirmed</p>';
		echo '<div><h3>' . esc_html($row[1]) . '</h3><p>' . esc_html($row[2]) . '</p></div>';
		echo '<p>Speaker to be confirmed<br />Designation to be confirmed</p>';
		echo '</article>';
	}
}
function hohorizon_session_row() {
	$topic = get_post_meta(get_the_ID(), '_hohorizon_topic', true);
	$time  = get_post_meta(get_the_ID(), '_hohorizon_time', true);
	$span  = get_post_meta(get_the_ID(), '_hohorizon_duration', true);
	$who   = get_post_meta(get_the_ID(), '_hohorizon_speaker', true);
	$role  = get_post_meta(get_the_ID(), '_hohorizon_role', true);
	echo '<article class="session" data-topic="' . esc_attr($topic) . '">';
	echo '<p>' . esc_html($time) . '<br />' . esc_html($span) . '</p>';
	echo '<div><h3>' . esc_html(get_the_title()) . '</h3><p>' . esc_html(wp_strip_all_tags(get_the_content())) . '</p></div>';
	echo '<p>' . esc_html($who) . '<br />' . esc_html($role) . '</p>';
	echo '</article>';
}

/**
 * Filter buttons for sessions.
 */
function hohorizon_filters() {
	echo '<div class="filters" aria-label="Filter sessions">';
	echo '<button type="button" data-filter="all" aria-pressed="true">All</button>';
	foreach (hohorizon_topics() as $key => $label) {
		echo '<button type="button" data-filter="' . esc_attr($key) . '">' . esc_html($label) . '</button>';
	}
	echo '</div>';
}

/**
 * Primary menu when none has been saved.
 */
function hohorizon_primary_fallback() {
	$items = array(
		array('Home', '', array()),
		array('About', 'about', array()),
		array('Agenda', 'programme', array()),
		array('Speakers', 'speakers', array()),
		array('Partners', 'partners', array()),
		array('Media', 'events', array()),
		array('Contact', 'contact', array()),
	);
	foreach ($items as $item) {
		$url = $item[1] === '' ? home_url('/') : hohorizon_page_url($item[1]);
		$anchors = array(
			'About'    => '#about',
			'Agenda'   => '#agenda',
			'Speakers' => '#speakers',
			'Media'    => '#media',
		);
		if (isset($anchors[$item[0]])) {
			$url = home_url('/') . $anchors[$item[0]];
		}
		$href = isset($anchors[$item[0]]) ? esc_url(home_url('/')) . $anchors[$item[0]] : esc_url($url);
		echo '<div class="menu-item"><a href="' . $href . '">' . hohorizon_nav_icon($item[0]) . esc_html($item[0]) . '</a>';
		if ($item[2]) {
			echo '<div class="dropdown">';
			foreach ($item[2] as $child) {
				echo '<a href="' . esc_url(hohorizon_page_url($child[1])) . '">' . hohorizon_nav_icon($child[0]) . esc_html($child[0]) . '</a>';
			}
			echo '</div>';
		}
		echo '</div>';
	}
}

/**
 * Footer quick links fallback.
 */
function hohorizon_footer_quick_fallback() {
	hohorizon_link_list(
		array(
			'About Us'             => 'about',
			'Our Mission'          => 'mission',
			'Membership'           => 'membership',
			'Contact'              => 'contact',
			'Privacy Policy'       => 'privacy',
			'Terms & Conditions'   => 'terms',
		)
	);
}

/**
 * Footer explore links fallback.
 */
function hohorizon_footer_explore_fallback() {
	hohorizon_link_list(
		array(
			'Events'                 => 'events',
			'Programme'              => 'programme',
			'Speakers'               => 'speakers',
			'Partners'               => 'partners',
			'Become a Partner'       => 'become-a-partner',
			'Request an invitation'  => 'invitation',
		)
	);
}

/**
 * A simple link list.
 *
 * @param array<string, string> $links Label => slug.
 */
function hohorizon_link_list($links) {
	echo '<ul>';
	foreach ($links as $label => $slug) {
		echo '<li><a href="' . esc_url(hohorizon_page_url($slug)) . '">' . hohorizon_menu_icon($label) . esc_html($label) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Menu URL. About, Agenda, Speakers and Media stay on the homepage.
 *
 * @param string $title Menu label.
 * @param string $url Stored URL.
 * @param int    $depth Depth.
 * @return string
 */
function hohorizon_nav_href($title, $url, $depth = 0) {
	$anchors = array(
		'about'    => '#about',
		'about us' => '#about',
		'agenda'   => '#agenda',
		'speakers' => '#speakers',
		'media'    => '#media',
	);
	$key = strtolower(trim(wp_strip_all_tags($title)));
	if ((int) $depth === 0 && isset($anchors[$key])) {
		return esc_url(home_url('/')) . $anchors[$key];
	}
	return esc_url($url);
}

/**
 * Menu markup that matches the existing stylesheet.
 */
class Hohorizon_Walker extends Walker_Nav_Menu {
	/**
	 * Open a submenu.
	 *
	 * @param string   $output Output.
	 * @param int      $depth Depth.
	 * @param stdClass $args Args.
	 */
	public function start_lvl(&$output, $depth = 0, $args = null) {
	}

	/**
	 * Close a submenu.
	 *
	 * @param string   $output Output.
	 * @param int      $depth Depth.
	 * @param stdClass $args Args.
	 */
	public function end_lvl(&$output, $depth = 0, $args = null) {
	}

	/**
	 * Open a menu item.
	 *
	 * @param string   $output Output.
	 * @param WP_Post  $item Item.
	 * @param int      $depth Depth.
	 * @param stdClass $args Args.
	 * @param int      $id ID.
	 */
	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
		if ($depth > 0) {
			return;
		}
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$active  = in_array('current-menu-item', $classes, true) || in_array('current-menu-ancestor', $classes, true);
		if ($depth === 0) {
			$output .= '<div class="menu-item">';
		}
		$output .= '<a href="' . hohorizon_nav_href($item->title, $item->url, $depth) . '"' . ($active ? ' aria-current="page"' : '') . '>' . hohorizon_nav_icon($item->title) . esc_html($item->title) . '</a>';
	}

	/**
	 * Close a menu item.
	 *
	 * @param string   $output Output.
	 * @param WP_Post  $item Item.
	 * @param int      $depth Depth.
	 * @param stdClass $args Args.
	 */
	public function end_el(&$output, $item, $depth = 0, $args = null) {
		if ($depth > 0) {
			return;
		}
		if ($depth === 0) {
			$output .= '</div>';
		}
	}
}

/**
 * Event cards.
 *
 * @param int $count How many. -1 for all.
 */
function hohorizon_event_list($count = -1) {
	$events = hohorizon_query('hoh_event', $count);
	$samples = array(
		array(
			'Flagship forum · Placeholder',
			'HOHORIZON flagship forum',
			'Date to be confirmed. Venue to be confirmed. A full-day programme of discussions, private meetings and a hosted close.',
			'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80',
			'A bright executive meeting room',
		),
		array(
			'Private briefing · Placeholder',
			'HOHORIZON private briefing',
			'Date to be confirmed. Venue to be confirmed. A smaller sitting for a single theme and a longer discussion.',
			'https://images.unsplash.com/photo-1431540015161-0bf868a2d407?auto=format&fit=crop&w=1200&q=80',
			'A boardroom prepared for a private meeting',
		),
	);
	echo '<div class="events">';
	$shown = 0;
	if ($events->have_posts()) {
		while ($events->have_posts()) {
			$events->the_post();
			$image = hohorizon_image_url(get_the_ID(), '_hohorizon_image', isset($samples[$shown]) ? $samples[$shown][3] : '');
			echo '<article class="event-card">';
			if ($image) {
				echo '<img src="' . esc_url($image) . '" alt="" />';
			}
			echo '<div><p class="eyebrow">' . esc_html((string) get_post_meta(get_the_ID(), '_hohorizon_kicker', true)) . '</p>';
			echo '<h3>' . esc_html(get_the_title()) . '</h3>';
			echo '<p class="lede" style="margin-top:12px">' . esc_html(has_excerpt() ? get_the_excerpt() : '') . '</p>';
			echo '<div class="actions">';
			echo '<a class="btn btn-ink" href="' . esc_url(get_permalink()) . '">View details</a>';
			echo '<a class="btn btn-ink" href="' . esc_url(hohorizon_page_url('invitation')) . '">Request invitation</a>';
			echo '</div></div></article>';
			$shown++;
		}
		wp_reset_postdata();
	}
	$limit = $count > 0 ? $count : count($samples);
	while ($shown < $limit && $shown < count($samples)) {
		$card = $samples[$shown];
		echo '<article class="event-card">';
		echo '<img src="' . esc_url($card[3]) . '" alt="' . esc_attr($card[4]) . '" />';
		echo '<div><p class="eyebrow">' . esc_html($card[0]) . '</p>';
		echo '<h3>' . esc_html($card[1]) . '</h3>';
		echo '<p class="lede" style="margin-top:12px">' . esc_html($card[2]) . '</p>';
		echo '<div class="actions">';
		echo '<a class="btn btn-ink" href="' . esc_url(hohorizon_page_url('events')) . '">View details</a>';
		echo '<a class="btn btn-ink" href="' . esc_url(hohorizon_page_url('invitation')) . '">Request invitation</a>';
		echo '</div></div></article>';
		$shown++;
	}
	echo '</div>';
}

/**
 * Speakers page: two scrolling portrait rows.
 */
function hohorizon_speaker_stage($tag = 'h1', $home = false) {
	$speakers = hohorizon_query('hoh_speaker', -1);
	$cards    = array();
	$fallbacks = array(
		'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80',
		'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80',
		'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=600&q=80',
		'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80',
		'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=600&q=80',
		'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=600&q=80',
		'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80',
		'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=600&q=80',
		'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=600&q=80',
		'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=600&q=80',
		'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=600&q=80',
		'https://images.unsplash.com/photo-1556157382-97eda2d62296?auto=format&fit=crop&w=600&q=80',
	);
	$index = 0;
	if ($speakers->have_posts()) {
		while ($speakers->have_posts()) {
			$speakers->the_post();
			$image = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
			if (!$image) {
				$image = $fallbacks[$index % count($fallbacks)];
			}
			$role = (string) get_post_meta(get_the_ID(), '_hohorizon_role', true);
			$bio  = wp_strip_all_tags(get_the_content());
			$cards[] = array(get_the_ID(), get_the_title(), $role !== '' ? $role : 'Role to be confirmed', $image, $bio);
			$index++;
		}
		wp_reset_postdata();
	}
	$sample = 0;
	while (count($cards) < 14) {
		$cards[] = array(
			'sample-' . $sample,
			'Name to be confirmed',
			'Title to be confirmed',
			$fallbacks[$sample % count($fallbacks)],
			'A short biography will be published here after the speaker agrees to appear.',
		);
		$sample++;
	}
	$tag = $tag === 'h2' ? 'h2' : 'h1';
	echo '<section class="speaker-stage' . ($home ? ' is-home' : '') . '"' . ($home ? ' id="speakers"' : '') . '>';
	echo '<div class="wrap speaker-intro"><' . $tag . ' class="meet">Meet the Speakers</' . $tag . '>';
	echo '<p>Senior executives and industry experts sharing firsthand perspectives on global trade, finance, AI, logistics, risk and technology.</p></div>';
	if (!$cards) {
		echo '<p class="lede wrap">No speaker profiles have been published yet.</p></section>';
		return;
	}
	$rows = array_chunk($cards, (int) ceil(count($cards) / 2));
	if (count($rows) === 1) {
		$rows[] = $rows[0];
	}
	foreach ($rows as $row) {
		echo '<div class="portrait-row"><button class="portrait-arrow" type="button" data-dir="-1" aria-label="Previous speakers">‹</button><div class="portrait-window"><div class="portrait-track">';
		foreach ($row as $card) {
			echo '<article class="portrait" id="speaker-' . esc_attr((string) $card[0]) . '">';
			echo '<img src="' . esc_url($card[3]) . '" alt="" />';
			echo '<button class="portrait-more" type="button" aria-expanded="false" aria-label="Sample profile">+</button>';
			echo '<div class="portrait-copy"><h3>' . esc_html($card[1]) . '</h3><p>' . esc_html($card[2]) . '</p></div>';
			echo '<p class="portrait-bio">' . esc_html($card[4]) . '</p></article>';
		}
		echo '</div></div><button class="portrait-arrow" type="button" data-dir="1" aria-label="Next speakers">›</button></div>';
	}
	echo '</section>';
}

/**
 * Speaker cards.
 *
 * @param int  $count How many. -1 for all.
 * @param bool $link Whether to link to the speakers page.
 */
function hohorizon_speaker_list($count = -1, $link = false) {
	$speakers = hohorizon_query('hoh_speaker', $count);
	if (!$speakers->have_posts()) {
		echo '<p class="lede">No speaker profiles have been published yet.</p>';
		return;
	}
	echo '<div class="speakers">';
	$number = 1;
	while ($speakers->have_posts()) {
		$speakers->the_post();
		$image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
		$note  = get_post_meta(get_the_ID(), '_hohorizon_note', true);
		echo '<article class="speaker" id="speaker-' . esc_attr((string) get_the_ID()) . '">';
		echo '<div class="monogram" aria-hidden="true">';
		if ($image) {
			echo '<img src="' . esc_url($image) . '" alt="" />';
		} else {
			echo esc_html(str_pad((string) $number, 2, '0', STR_PAD_LEFT));
		}
		echo '</div>';
		echo '<h3>' . esc_html(get_the_title()) . '</h3>';
		echo '<p>' . esc_html((string) get_post_meta(get_the_ID(), '_hohorizon_role', true)) . '</p>';
		echo '<p>' . esc_html((string) get_post_meta(get_the_ID(), '_hohorizon_organisation', true)) . '</p>';
		if (!$link) {
			echo '<p>' . esc_html(wp_strip_all_tags(get_the_content())) . '</p>';
		}
		if ($note) {
			echo '<p class="note">' . esc_html($note) . '</p>';
		}
		if ($link) {
			echo '<a class="btn btn-ink" href="' . esc_url(hohorizon_page_url('speakers') . '#speaker-' . get_the_ID()) . '">View profile</a>';
		}
		echo '</article>';
		$number++;
	}
	echo '</div>';
	wp_reset_postdata();
}

/**
 * Logo tiles. Empty places stay labelled until a logo is added.
 *
 * @param int    $count How many. 0 lists the whole tier.
 * @param string $tier Optional tier key.
 */
function hohorizon_partner_row($count = 0, $tier = '') {
	$meta = array();
	if ($tier !== '') {
		$meta[] = array(
			'key'   => '_hohorizon_tier',
			'value' => $tier,
		);
	}
	$partners = hohorizon_query('hoh_partner', $count > 0 ? $count : -1, $meta);
	echo '<div class="logo-row">';
	if ($partners->have_posts()) {
		while ($partners->have_posts()) {
			$partners->the_post();
			$logo = get_the_post_thumbnail_url(get_the_ID(), 'medium');
			echo '<div class="logo-tile">';
			if ($logo) {
				echo '<img src="' . esc_url($logo) . '" alt="' . esc_attr(get_the_title()) . '" />';
			} else {
				echo esc_html(get_the_title());
			}
			echo '</div>';
		}
		wp_reset_postdata();
	} else {
		$slots = $count > 0 ? $count : 4;
		for ($i = 0; $i < $slots; $i++) {
			echo '<div class="logo-tile">Logo to add</div>';
		}
	}
	echo '</div>';
}

/**
 * Stroke icon markup for a menu label.
 *
 * @param string $label Link label.
 * @return string
 */
function hohorizon_menu_icon($label) {
	$key = strtolower(trim(wp_strip_all_tags($label)));
	$map = array(
		'home'                  => 'home',
		'about'                 => 'about',
		'about us'              => 'about',
		'our mission'           => 'mission',
		'agenda'                => 'programme',
		'programme'             => 'programme',
		'speakers'              => 'speakers',
		'partners'              => 'partners',
		'media'                 => 'events',
		'events'                => 'events',
		'contact'               => 'contact',
		'contact us'            => 'contact',
		'membership'            => 'membership',
		'privacy policy'        => 'privacy',
		'terms & conditions'    => 'terms',
		'terms and conditions'  => 'terms',
		'become a partner'      => 'partner',
		'request an invitation' => 'contact',
		'request an invite'     => 'contact',
	);
	$paths = array(
		'home'       => '<path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1z"/>',
		'about'      => '<circle cx="12" cy="8" r="3"/><path d="M5 19c1.2-3 3.4-4.5 7-4.5S17.8 16 19 19"/>',
		'programme'  => '<rect x="4" y="5" width="16" height="15" rx="2"/><path d="M8 3v4M16 3v4M4 10h16"/>',
		'speakers'   => '<rect x="9" y="3" width="6" height="10" rx="3"/><path d="M6 11a6 6 0 0 0 12 0M12 17v4M8 21h8"/>',
		'partners'   => '<circle cx="8" cy="9" r="2.4"/><circle cx="16" cy="9" r="2.4"/><path d="M3.5 18.5c.7-2.4 2.3-3.5 4.5-3.5s3.8 1.1 4.5 3.5M11.5 18.5c.7-2.4 2.3-3.5 4.5-3.5s3.8 1.1 4.5 3.5"/>',
		'events'     => '<rect x="3" y="6" width="18" height="12" rx="2"/><path d="m10 9 5 3-5 3z"/>',
		'contact'    => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/>',
		'mission'    => '<circle cx="12" cy="12" r="8"/><path d="M12 8v4l3 2"/>',
		'membership' => '<rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/>',
		'partner'    => '<path d="M12 5v14M5 12h14"/>',
		'privacy'    => '<path d="M12 3 5 6v6c0 4.2 2.8 7.2 7 8.5 4.2-1.3 7-4.3 7-8.5V6z"/>',
		'terms'      => '<path d="M7 3h7l5 5v13H7z"/><path d="M14 3v5h5M9 13h6M9 17h6"/>',
	);
	$id = isset($map[$key]) ? $map[$key] : 'home';
	return '<svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">' . $paths[$id] . '</svg>';
}

/**
 * Social icon markup.
 *
 * @param string $id Icon id.
 * @return string
 */
function hohorizon_social_icon($id) {
	$paths = array(
		'linkedin'  => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 10v7M8 7h.01M12 17v-4.2a2 2 0 0 1 4 0V17"/>',
		'instagram' => '<rect x="4" y="4" width="16" height="16" rx="4"/><circle cx="12" cy="12" r="3.5"/><path d="M17.5 6.5h.01"/>',
		'youtube'   => '<rect x="3" y="6" width="18" height="12" rx="3"/><path d="m10 9 5 3-5 3z"/>',
		'facebook'  => '<path d="M14 8h2V5h-2a3 3 0 0 0-3 3v2H9v3h2v6h3v-6h2.2l.8-3H14V8a1 1 0 0 1 1-1z"/>',
	);
	$path = isset($paths[$id]) ? $paths[$id] : $paths['linkedin'];
	return '<svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>';
}

/**
 * Add icons to the footer menus.
 *
 * @param string   $title Title.
 * @param WP_Post  $item Item.
 * @param stdClass $args Args.
 * @param int      $depth Depth.
 * @return string
 */
function hohorizon_footer_menu_icon($title, $item, $args, $depth) {
	unset($item, $depth);
	$location = isset($args->theme_location) ? $args->theme_location : '';
	if (!in_array($location, array('footer_quick', 'footer_explore'), true)) {
		return $title;
	}
	return hohorizon_menu_icon($title) . esc_html(wp_strip_all_tags($title));
}
add_filter('nav_menu_item_title', 'hohorizon_footer_menu_icon', 10, 4);
