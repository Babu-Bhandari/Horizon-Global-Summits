<?php
/**
 * First-run pages, menus, and sample entries.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Create anything that is not already there.
 */
function hohorizon_seed() {
	$pages = hohorizon_seed_pages();
	hohorizon_seed_events();
	hohorizon_seed_speakers();
	hohorizon_seed_sessions();
	hohorizon_seed_highlights();
	hohorizon_seed_topics();
	hohorizon_seed_menus($pages);
	if (get_option('show_on_front') === 'posts' && !empty($pages['home'])) {
		update_option('show_on_front', 'page');
		update_option('page_on_front', $pages['home']);
	}
}

/**
 * Insert a post once, matched by slug.
 *
 * @param array $args Post fields.
 * @param array $meta Meta values.
 * @return int
 */
function hohorizon_ensure_post($args, $meta = array()) {
	$found = get_posts(
		array(
			'name'        => $args['post_name'],
			'post_type'   => $args['post_type'],
			'post_status' => 'any',
			'numberposts' => 1,
		)
	);
	if ($found) {
		return (int) $found[0]->ID;
	}
	$id = wp_insert_post(wp_slash($args));
	if (is_wp_error($id) || !$id) {
		return 0;
	}
	foreach ($meta as $key => $value) {
		update_post_meta($id, $key, $value);
	}
	return (int) $id;
}

/**
 * Block markup for paragraphs.
 *
 * @param string[] $paragraphs Paragraphs.
 * @return string
 */
function hohorizon_paragraphs($paragraphs) {
	$html = '';
	foreach ($paragraphs as $paragraph) {
		$html .= "<!-- wp:paragraph -->\n<p>" . esc_html($paragraph) . "</p>\n<!-- /wp:paragraph -->\n";
	}
	return $html;
}

/**
 * Block markup for heading and paragraph pairs.
 *
 * @param array<int, array{0: string, 1: string}> $pairs Pairs.
 * @return string
 */
function hohorizon_pair_blocks($pairs) {
	$html = '';
	foreach ($pairs as $pair) {
		$html .= "<!-- wp:heading {\"level\":2} -->\n<h2>" . esc_html($pair[0]) . "</h2>\n<!-- /wp:heading -->\n";
		$html .= "<!-- wp:paragraph -->\n<p>" . esc_html($pair[1]) . "</p>\n<!-- /wp:paragraph -->\n";
	}
	return $html;
}

/**
 * Create the editable pages.
 *
 * @return array<string, int>
 */
function hohorizon_seed_pages() {
	$pages = array(
		'home' => array(
			'Home',
			'The public homepage keeps its design. Edit the hero and section headings in Appearance, Customize. Edit gatherings, speakers, sessions, partners, highlights, and topics in their own admin menus.',
			'',
			array(),
		),
		'about' => array(
			'About Us',
			'HOHORIZON GLOBAL AFFAIRS exists to host international business conversations that are specific, civil and useful.',
			hohorizon_paragraphs(
				array(
					'Executives, investors, policymakers and operators. People who can speak for a decision, or who are close enough to one that the conversation changes the next meeting.',
					'It is not a public exhibition. Attendance is by invitation after a request is reviewed. No attendance figure on this site should be read as a record. None has been published yet.',
					'The host’s job is the room: the programme, the introductions, and the time between sessions. The content of a private meeting stays with the people in it.',
				)
			),
			array(
				'_hohorizon_eyebrow' => 'About us',
				'_hohorizon_hero'    => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=2000&q=80',
				'_hohorizon_image'   => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=1400&q=80',
			),
		),
		'mission' => array(
			'Our Mission',
			'Markets, policy and operating reality rarely sit in the same meeting. The forum is a place where they can.',
			hohorizon_pair_blocks(
				array(
					array('Clarity', 'Sessions have a question. If a subject cannot be asked in one sentence, it does not go on the programme.'),
					array('Proportion', 'The guest list stays small enough that a discussion can finish. Scale is not the measure.'),
					array('Discretion', 'A private meeting is private. The public programme is the part that can be written down.'),
					array('Range', 'Finance, trade, technology, risk and leadership share one day, because the decisions touch all five.'),
					array('Hospitality', 'The setting should feel calm. It should never outrank the reason people travelled.'),
					array('Follow-through', 'An introduction is only useful if both people know why it was made. The host says so.'),
				)
			),
			array(
				'_hohorizon_eyebrow' => 'Our mission',
				'_hohorizon_hero'    => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=2000&q=80',
			),
		),
		'membership' => array(
			'Membership',
			'Membership is not open for payment on this site. If a fee is set later, it will be written here before anyone is asked to pay.',
			hohorizon_pair_blocks(
				array(
					array('International networking', 'Introductions made by the host, with a reason attached.'),
					array('Business opportunities', 'Time in the programme for a meeting that is not an accident.'),
					array('Executive connections', 'A room of people who can continue the conversation after the day.'),
					array('Strategic partnerships', 'A path to speak with partners of the forum, when both sides agree.'),
					array('Global exposure', 'A profile only if you ask for one. Silence is the default.'),
					array('Industry collaboration', 'Working sessions across finance, trade, technology, risk and leadership.'),
				)
			),
			array('_hohorizon_eyebrow' => 'Membership'),
		),
		'contact' => array(
			'Contact',
			'Email address to be confirmed. There is no public telephone number on this site yet.',
			'',
			array('_hohorizon_eyebrow' => 'Contact'),
		),
		'invitation' => array(
			'Request an invitation',
			'Sending this form does not reserve a seat. An invitation is issued only when a gathering has a date and a place for you.',
			'',
			array('_hohorizon_eyebrow' => 'Invitation'),
		),
		'become-a-partner' => array(
			'Become a Partner',
			'Strategic, platinum, gold, silver, institutional and media partnerships are categories, not a price list. Terms are agreed one by one.',
			hohorizon_paragraphs(
				array(
					'A named place in the programme only if it serves the guest. A logo on this site only with permission. An introduction to delegates only when both sides want it.',
					'Send a note with the kind of partnership you have in mind. The form emails the site inbox.',
				)
			),
			array('_hohorizon_eyebrow' => 'Partnership'),
		),
		'events' => array(
			'Events',
			'These cards are placeholders. A date or venue on this page will be replaced when it is confirmed.',
			'',
			array(
				'_hohorizon_eyebrow' => 'Events',
				'_hohorizon_hero'    => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=2000&q=80',
			),
		),
		'programme' => array(
			'Programme',
			'Replace each row when a session, time and speaker are agreed. Filters work on the topic marked on each row.',
			'',
			array('_hohorizon_eyebrow' => 'Programme'),
		),
		'speakers' => array(
			'Speakers',
			'These seats are samples. They are not people. Replace each one when a speaker agrees to appear.',
			'',
			array('_hohorizon_eyebrow' => 'Speakers'),
		),
		'partners' => array(
			'Partners',
			'Each tile is an empty place. Add a partner, choose a tier, and set the logo as the featured image.',
			'',
			array('_hohorizon_eyebrow' => 'Partners & sponsors'),
		),
		'privacy' => array(
			'Privacy Policy',
			'',
			hohorizon_pair_blocks(
				array(
					array('What this website stores', 'This policy describes this website as it works on WordPress. It is not a substitute for advice from counsel.'),
					array('Cookie preference', 'If you accept or decline the notice, the choice is saved in local storage on your device under the key hohorizon-cookie. Declining stores that choice and does not load analytics.'),
					array('Analytics', 'Google Analytics is not loaded unless you accepted the notice and a measurement ID has been saved in Appearance, Customize. Until that ID is saved, nothing is sent to Google.'),
					array('Forms', 'Invitation, partnership, contact, and newsletter forms are emailed to the site inbox. They are not published. A hidden field is used to ignore automated submissions. Do not fill it.'),
					array('Images and type', 'Until you upload your own photographs, some images are loaded from Unsplash. Fonts are loaded from Google Fonts. Those services receive the ordinary technical request your browser makes.'),
				)
			),
			array('_hohorizon_eyebrow' => 'Privacy'),
		),
		'terms' => array(
			'Terms & Conditions',
			'',
			hohorizon_paragraphs(
				array(
					'The site describes HOHORIZON GLOBAL AFFAIRS. Anything marked as a placeholder, sample, or “to be confirmed” is not a fact, a date, a price, or an offer.',
					'Requesting an invitation does not create a place at a gathering. A partnership enquiry does not create a partnership. No fee can be paid through these pages.',
					'You may not present sample profiles, empty logo tiles, or unpublished figures as confirmed information about the forum or about any person or company.',
					'The site is provided as published. Have counsel review these terms before they are used as a binding notice.',
				)
			),
			array('_hohorizon_eyebrow' => 'Terms'),
		),
	);

	$ids = array();
	foreach ($pages as $slug => $page) {
		$ids[$slug] = hohorizon_ensure_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_name'    => $slug,
				'post_title'   => $page[0],
				'post_excerpt' => $page[1],
				'post_content' => $page[2],
			),
			$page[3]
		);
	}
	return $ids;
}

/**
 * Sample gatherings.
 */
function hohorizon_seed_events() {
	$events = array(
		array('flagship-forum', 'HOHORIZON flagship forum', 'Date to be confirmed. Venue to be confirmed. A full-day programme of discussions, private meetings and a hosted close.', 'Flagship forum · Placeholder', 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80', 1),
		array('private-briefing', 'HOHORIZON private briefing', 'Date to be confirmed. Venue to be confirmed. A smaller sitting for a single theme and a longer discussion.', 'Private briefing · Placeholder', 'https://images.unsplash.com/photo-1431540015161-0bf868a2d407?auto=format&fit=crop&w=1200&q=80', 2),
	);
	$body = hohorizon_paragraphs(
		array(
			'A hosted arrival, a published programme, time for private meetings, and a close that does not depend on a speech running long. Speakers are listed only after they have agreed to appear.',
			'Registration opens when a date is fixed. Until then, the invitation form is a request to be considered, not a ticket.',
		)
	);
	foreach ($events as $event) {
		hohorizon_ensure_post(
			array(
				'post_type'    => 'hoh_event',
				'post_status'  => 'publish',
				'post_name'    => $event[0],
				'post_title'   => $event[1],
				'post_excerpt' => $event[2],
				'post_content' => $body,
				'menu_order'   => $event[5],
			),
			array(
				'_hohorizon_kicker' => $event[3],
				'_hohorizon_image'  => $event[4],
			)
		);
	}
}

/**
 * Sample speaker seats. These are not real people.
 */
function hohorizon_seed_speakers() {
	for ($i = 1; $i <= 6; $i++) {
		hohorizon_ensure_post(
			array(
				'post_type'    => 'hoh_speaker',
				'post_status'  => 'publish',
				'post_name'    => 'sample-speaker-' . $i,
				'post_title'   => 'Name to be confirmed',
				'post_content' => 'A short biography will be published here after the speaker agrees to appear.',
				'menu_order'   => $i,
			),
			array(
				'_hohorizon_role'         => 'Title to be confirmed',
				'_hohorizon_organisation' => 'Organisation to be confirmed',
				'_hohorizon_note'         => 'Sample profile',
			)
		);
	}
}

/**
 * Sample sessions.
 */
function hohorizon_seed_sessions() {
	$rows = array(
		array('opening-conversation', 'Opening conversation', 'How the day will be used, and what a useful disagreement looks like.', 'leadership', 1),
		array('capital-across-borders', 'Capital across borders', 'Where cross-border finance is slowing, and where it is still moving.', 'finance', 2),
		array('mandates-not-slogans', 'Mandates, not slogans', 'What investors are actually willing to underwrite this year.', 'investment', 3),
		array('routes-and-resilience', 'Routes and resilience', 'Trade corridors, delays, and the contracts written around them.', 'trade', 4),
		array('applied-intelligence', 'Applied intelligence', 'Tools that change a cost line.', 'technology', 5),
		array('continuity', 'Continuity', 'What still works when a forecast does not.', 'risk', 6),
		array('close', 'Close', 'What should leave the room, and what should not.', 'leadership', 7),
	);
	foreach ($rows as $row) {
		hohorizon_ensure_post(
			array(
				'post_type'    => 'hoh_session',
				'post_status'  => 'publish',
				'post_name'    => $row[0],
				'post_title'   => $row[1],
				'post_content' => $row[2],
				'menu_order'   => $row[4],
			),
			array(
				'_hohorizon_time'     => 'Time to be confirmed',
				'_hohorizon_duration' => 'Duration to be confirmed',
				'_hohorizon_topic'    => $row[3],
				'_hohorizon_speaker'  => 'Speaker to be confirmed',
				'_hohorizon_role'     => 'Designation to be confirmed',
			)
		);
	}
}

/**
 * The seven homepage cards.
 */
function hohorizon_seed_highlights() {
	$cards = array(
		array('international-networking', 'International networking', 'Introductions with a reason, not a stack of badges at the door.', 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1400&q=80'),
		array('executive-conferences', 'Executive conferences', 'Short sessions for people who have already read the briefing.', 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&w=1400&q=80'),
		array('industry-discussions', 'Industry discussions', 'Finance, trade, technology, risk and leadership, kept specific.', 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1200&q=80'),
		array('strategic-partnerships', 'Strategic partnerships', 'Time set aside for the meeting that should not happen in a corridor.', 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=1200&q=80'),
		array('vip-hospitality', 'VIP hospitality', 'A calm setting around the programme, with the schedule still in charge.', 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1200&q=80'),
		array('business-showcases', 'Business showcases', 'A short window for work that deserves a proper introduction.', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80'),
		array('leadership-conversations', 'Leadership conversations', 'Chairs who have done the job, not a script read from the stage.', 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=1200&q=80'),
	);
	$order = 1;
	foreach ($cards as $card) {
		hohorizon_ensure_post(
			array(
				'post_type'    => 'hoh_highlight',
				'post_status'  => 'publish',
				'post_name'    => $card[0],
				'post_title'   => $card[1],
				'post_excerpt' => $card[2],
				'menu_order'   => $order,
			),
			array('_hohorizon_image' => $card[3])
		);
		$order++;
	}
}

/**
 * Discussion areas.
 */
function hohorizon_seed_topics() {
	$topics = array(
		array('global-finance', 'Global finance & investment', 'Capital allocation, cross-border mandates and the difference between a theme and a deal.', 'Related themes: private capital, sovereign balance sheets, credit, partnerships.', 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80'),
		array('international-trade', 'International trade & commerce', 'How goods, contracts and corridors are being redrawn, and who is paying for the delay.', 'Related themes: logistics, supply contracts, market access, trade finance.', 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=1200&q=80'),
		array('technology', 'Technology & artificial intelligence', 'Tools that change a cost line, not a slide. The question is adoption with accountability.', 'Related themes: applied intelligence, infrastructure, data, operating models.', 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80'),
		array('risk-management', 'Risk management & economic resilience', 'What still works when a forecast does not: insurance, continuity, and the board conversation.', 'Related themes: credit risk, geopolitical exposure, continuity, governance.', 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80'),
		array('leadership', 'Leadership & innovation', 'How operators keep a business moving while they change the way it works.', 'Related themes: succession, culture, new ventures, decision rights.', 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=1200&q=80'),
	);
	$order = 1;
	foreach ($topics as $topic) {
		hohorizon_ensure_post(
			array(
				'post_type'    => 'hoh_topic',
				'post_status'  => 'publish',
				'post_name'    => $topic[0],
				'post_title'   => $topic[1],
				'post_content' => $topic[2],
				'menu_order'   => $order,
			),
			array(
				'_hohorizon_related' => $topic[3],
				'_hohorizon_image'   => $topic[4],
			)
		);
		$order++;
	}
}

/**
 * Menus pointing at the pages.
 *
 * @param array<string, int> $pages Page IDs.
 */
function hohorizon_seed_menus($pages) {
	$locations = get_theme_mod('nav_menu_locations', array());
	if (empty($locations['primary'])) {
		$locations['primary'] = hohorizon_menu(
			'Primary',
			array(
				array('Home', 0, array(), home_url('/')),
				array('About', $pages['about'], array(array('Our Mission', $pages['mission']))),
				array('Agenda', $pages['programme'], array()),
				array('Speakers', $pages['speakers'], array()),
				array('Partners', $pages['partners'], array(array('Membership', $pages['membership']), array('Become a Partner', $pages['become-a-partner']))),
				array('Media', $pages['events'], array()),
				array('Contact', $pages['contact'], array()),
			)
		);
	}
	if (empty($locations['footer_quick'])) {
		$locations['footer_quick'] = hohorizon_menu(
			'Footer quick links',
			array(
				array('About Us', $pages['about'], array()),
				array('Our Mission', $pages['mission'], array()),
				array('Membership', $pages['membership'], array()),
				array('Contact', $pages['contact'], array()),
				array('Privacy Policy', $pages['privacy'], array()),
				array('Terms & Conditions', $pages['terms'], array()),
			)
		);
	}
	if (empty($locations['footer_explore'])) {
		$locations['footer_explore'] = hohorizon_menu(
			'Footer explore',
			array(
				array('Events', $pages['events'], array()),
				array('Programme', $pages['programme'], array()),
				array('Speakers', $pages['speakers'], array()),
				array('Partners', $pages['partners'], array()),
				array('Become a Partner', $pages['become-a-partner'], array()),
				array('Request an invitation', $pages['invitation'], array()),
			)
		);
	}
	set_theme_mod('nav_menu_locations', $locations);
}

/**
 * Create a menu.
 *
 * @param string $name Menu name.
 * @param array  $items Items as title, page ID, children.
 * @return int
 */
function hohorizon_menu($name, $items) {
	$menu = wp_get_nav_menu_object($name);
	$id   = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu($name);
	if (!$id) {
		return 0;
	}
	$existing = wp_get_nav_menu_items($id);
	if ($existing) {
		return $id;
	}
	foreach ($items as $item) {
		$custom = isset($item[3]) ? $item[3] : '';
		$parent = wp_update_nav_menu_item(
			$id,
			0,
			$custom !== ''
				? array(
					'menu-item-title'  => $item[0],
					'menu-item-url'    => $custom,
					'menu-item-type'   => 'custom',
					'menu-item-status' => 'publish',
				)
				: array(
					'menu-item-title'     => $item[0],
					'menu-item-object-id' => $item[1],
					'menu-item-object'    => 'page',
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				)
		);
		foreach ($item[2] as $child) {
			wp_update_nav_menu_item(
				$id,
				0,
				array(
					'menu-item-title'     => $child[0],
					'menu-item-object-id' => $child[1],
					'menu-item-object'    => 'page',
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
					'menu-item-parent-id' => $parent,
				)
			);
		}
	}
	return $id;
}
