<?php
/**
 * First-run pages, menus, and sample entries.
 *
 * @package Horizon
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
			'Horizon GLOBAL AFFAIRS exists to host international business conversations that are specific, civil and useful.',
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
			'Write to connect@horizonglobalsummits.com. There is no public telephone number on this site yet.',
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
			'Tax and finance leadership summits and awards across the GCC, Europe and Asia-Pacific.',
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
			'Privacy',
			'How Horizon Global Summits handles enquiries, a cookie preference, and analytics on this website.',
			hohorizon_legal_document('privacy'),
			array('_hohorizon_eyebrow' => 'Privacy'),
		),
		'terms' => array(
			'Terms and conditions',
			'Terms for using the Horizon Global Summits website.',
			hohorizon_legal_document('terms'),
			array('_hohorizon_eyebrow' => 'Terms'),
		),
		'cookies' => array(
			'Cookie policy',
			'How this website stores a cookie preference.',
			hohorizon_legal_document('cookies'),
			array('_hohorizon_eyebrow' => 'Cookies'),
		),
		'manage-cookies' => array(
			'Manage Cookies',
			'Choose what this browser may store for Horizon Global Summits.',
			hohorizon_legal_document('manage-cookies'),
			array('_hohorizon_eyebrow' => 'Cookies'),
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
		array('flagship-forum', 'Horizon flagship forum', 'Date to be confirmed. Venue to be confirmed. A full-day programme of discussions, private meetings and a hosted close.', 'Flagship forum · Placeholder', 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80', 1),
		array('private-briefing', 'Horizon private briefing', 'Date to be confirmed. Venue to be confirmed. A smaller sitting for a single theme and a longer discussion.', 'Private briefing · Placeholder', 'https://images.unsplash.com/photo-1431540015161-0bf868a2d407?auto=format&fit=crop&w=1200&q=80', 2),
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
				array('About', 0, array(), home_url('/') . '#about'),
				array('Conference', 0, array(), home_url('/') . '#next-meet'),
				array('Speakers', 0, array(), home_url('/') . '#speakers'),
				array('Contact', 0, array(), home_url('/') . '#contact'),
			)
		);
	}
	if (empty($locations['footer_quick'])) {
		$locations['footer_quick'] = hohorizon_menu(
			'Footer quick links',
			array(
				array('Conference', 0, array(), home_url('/') . '#next-meet'),
			)
		);
	}
	if (empty($locations['footer_explore'])) {
		$locations['footer_explore'] = hohorizon_menu(
			'Footer explore',
			array(
				array('Conference', 0, array(), home_url('/') . '#next-meet'),
				array('Programme', $pages['programme'], array()),
				array('Speakers', $pages['speakers'], array()),
				array('Partners', 0, array(), home_url('/') . '#partners'),
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

/**
 * Full copy for the four legal pages.
 *
 * @param string $key Page key.
 * @return string
 */
function hohorizon_legal_document($key) {
	$pages = array(
		'terms' => array(
			array('These terms explain how you may use the Horizon Global Summits website. By using the site, you agree to them. If you do not agree, please leave the site.'),
			array('Who we are', array('Horizon Global Summits is a UAE-based organisation that hosts international B2B conferences, executive forums and industry summits. The website is operated from Dubai, United Arab Emirates. Questions about these terms can be sent to connect@horizonglobalsummits.com.')),
			array('Using the website', array(
				'You may browse the site, read about upcoming gatherings, and send an enquiry. You must be able to form a contract in your place of residence. Use the site only for lawful purposes and do not attempt to disrupt it, probe it, or send automated submissions.',
				'The site is provided as it is published. We may change, suspend, or withdraw pages without notice, including when a programme, date, or venue is still being confirmed.',
			)),
			array('Invitations, speaking and partnerships', array(
				'Requesting an invitation does not reserve a place. A speaking enquiry does not confirm a role on the programme. A partnership enquiry does not create a partnership. We review each request and reply if we can take it forward.',
				'No fee can be paid through these pages. Any commercial terms, including sponsorship or attendance, are agreed separately in writing. Nothing on the site is an offer capable of acceptance.',
			)),
			array('What the website says', array(
				'We aim to keep the site accurate. Dates, venues, speakers, partners and programme details that are marked to be confirmed, shown as samples, or left unpublished are not confirmed facts. Do not present them as confirmed information about Horizon Global Summits, a gathering, a person, or a company.',
				'Company names and logos appear only when a relationship is agreed. Empty or sample marks are not partners.',
			)),
			array('Acceptable use', array('Do not copy the site in a way that suggests you are Horizon Global Summits. Do not post unlawful, misleading, or infringing material through a form. Do not attempt to access another person’s enquiry or any non-public part of the site.')),
			array('Intellectual property', array('The site design, text, logos and other materials we publish are owned by Horizon Global Summits or used with permission. You may share a link to a page. You may not reproduce the site, our name, or our logo for your own event, product, or promotion without written consent.')),
			array('Other websites', array('Links and embedded services, including fonts and photographs loaded from other providers, are outside our control. Their terms and privacy notices apply once you leave this site or your browser contacts them.')),
			array('Liability', array('To the extent the law allows, we are not liable for loss that arises from using the site, relying on a page that is still being updated, or a failure of email delivery. Nothing in these terms limits liability that cannot legally be limited.')),
			array('Changes and law', array('We may update these terms by publishing a new version on this page. The date at the top shows when they were last updated. These terms are governed by the laws of the United Arab Emirates.')),
		),
		'privacy' => array(
			array('This policy explains what Horizon Global Summits collects through this website and how that information is used. It covers the public site only.'),
			array('Who we are', array('Horizon Global Summits is based in Dubai, United Arab Emirates. For privacy questions, email connect@horizonglobalsummits.com. Business hours are 09:30 AM to 5:30 PM GST (UTC+4).')),
			array('Information you give us', array(
				'If you use a form, we receive the details you type. Depending on the form, that can include your name, company or organisation, email address, contact number, the kind of enquiry, and your message. Invitation requests may also include your job title, country, and the gathering or industry you are asking about.',
				'The form sends those details to connect@horizonglobalsummits.com. We use them to read your request, reply, and keep a record of the conversation. We do not sell personal information and we do not use enquiry forms for an unrelated mailing list.',
				'A hidden field on each form is there to ignore automated submissions. Please leave it empty.',
			)),
			array('Preferences on your device', array(
				'If you accept or decline the cookie notice, that choice is saved in local storage on your device under the name hohorizon-cookie. It stays in this browser until you change it or clear the site data. Declining keeps analytics off.',
				'If you switch between light and dark mode, that choice is saved in local storage under the name hohorizon-theme so the site can open in the same appearance next time.',
			)),
			array('Analytics', array('Google Analytics is not loaded unless you have accepted the cookie notice and a measurement ID has been configured for the site. Until that ID is added, nothing is sent to Google Analytics. If both are in place, Google may receive technical information such as pages viewed and a general location derived from your connection. You can refuse this on the Manage Cookies page.')),
			array('Fonts and images', array('Typefaces are loaded from Google Fonts. Some photographs are loaded from Unsplash until they are replaced with our own images. Those services receive the ordinary technical request your browser makes, which can include your IP address.')),
			array('How long we keep enquiries', array('We keep enquiry correspondence for as long as we need it to respond, plan a gathering, or meet a legal or accounting duty. You can ask us what we still hold from an email you sent, and you can ask us to delete it where we are not required to keep it.')),
			array('Your choices', array('You can change the cookie choice at any time on the Manage Cookies page. You can also clear this site’s data in your browser settings. To ask about an enquiry you sent, email connect@horizonglobalsummits.com.')),
		),
		'cookies' => array(
			array('This notice describes what Horizon Global Summits stores on your device when you use this website, and how you can change it.'),
			array('Cookie preference', array(
				'When you choose Accept or Decline, the choice is saved in local storage in this browser under the name hohorizon-cookie. The value is either accept or decline. It is not sent to us as a form. It tells this site whether analytics may load on later visits.',
				'Decline still saves the choice, so the notice does not keep returning, and analytics stays off.',
			)),
			array('Appearance', array('The light or dark theme is saved separately in local storage under the name hohorizon-theme. That preference is only used to display the site. It is not used for advertising.')),
			array('Analytics', array('Google Analytics loads only after you accept and only when a measurement ID has been added to the site. Until that ID exists, accepting does not send anything to Google. If analytics is running, Google may set its own cookies to recognise a browser across pages. You can stop that by choosing Decline.')),
			array('Fonts and images', array('Pages request fonts from Google Fonts and some photographs from Unsplash. Those requests can include your IP address. They are needed to display the page and are not used by us to build a profile.')),
			array('How to change your choice', array(
				'Open Manage Cookies and choose Accept or Decline. You can also remove the saved preference by clearing this site’s data in your browser. The notice appears again when no choice is stored.',
				'More about enquiries and contact details is in the Privacy page.',
			)),
		),
		'manage-cookies' => array(
			array('This page saves one preference on this device. It does not create an account, and the choice is not emailed to us. You can change it whenever you return.'),
			array('What Accept does', array('Accept stores the choice in local storage under the name hohorizon-cookie. If a Google Analytics measurement ID has been configured, analytics may then load. Until that ID is added, accepting does not send data to Google.')),
			array('What Decline does', array('Decline stores the choice in the same place and keeps analytics off. The cookie notice stays dismissed on this browser until you choose again.')),
			array('A separate preference', array('The light or dark theme is a separate display preference. Changing it does not change this cookie choice. Read the Cookie policy for the full notice and the Privacy page for how enquiries are handled.')),
		),
	);
	if (!isset($pages[$key])) {
		return '';
	}
	$html = "<!-- wp:paragraph -->\n<p>Last updated 25 November 2026.</p>\n<!-- /wp:paragraph -->\n";
	foreach ($pages[$key] as $block) {
		if (count($block) === 1) {
			$html .= hohorizon_paragraphs($block);
			continue;
		}
		$html .= "<!-- wp:heading {\"level\":2} -->\n<h2>" . esc_html($block[0]) . "</h2>\n<!-- /wp:heading -->\n";
		$html .= hohorizon_paragraphs($block[1]);
	}
	return $html;
}

/**
 * Pages that should receive the legal copy, including titles already created in WordPress.
 *
 * @return array<string, array<string, mixed>>
 */
function hohorizon_legal_page_targets() {
	return array(
		'terms' => array(
			'slug'    => 'terms',
			'title'   => 'Terms and conditions',
			'excerpt' => 'Terms for using the Horizon Global Summits website.',
			'eyebrow' => 'Terms',
			'slugs'   => array('terms', 'terms-and-conditions', 'terms-conditions'),
			'titles'  => array('Terms and conditions', 'Terms and Conditions', 'Terms & Conditions'),
		),
		'privacy' => array(
			'slug'    => 'privacy',
			'title'   => 'Privacy',
			'excerpt' => 'How Horizon Global Summits handles enquiries, a cookie preference, and analytics on this website.',
			'eyebrow' => 'Privacy',
			'slugs'   => array('privacy', 'privacy-policy'),
			'titles'  => array('Privacy', 'Privacy Policy', 'Privacy policy'),
		),
		'cookies' => array(
			'slug'    => 'cookies',
			'title'   => 'Cookie policy',
			'excerpt' => 'How this website stores a cookie preference.',
			'eyebrow' => 'Cookies',
			'slugs'   => array('cookies', 'cookie-policy'),
			'titles'  => array('Cookie policy', 'Cookie Policy', 'Cookies'),
		),
		'manage-cookies' => array(
			'slug'    => 'manage-cookies',
			'title'   => 'Manage Cookies',
			'excerpt' => 'Choose what this browser may store for Horizon Global Summits.',
			'eyebrow' => 'Cookies',
			'slugs'   => array('manage-cookies'),
			'titles'  => array('Manage Cookies'),
		),
	);
}

/**
 * Find an existing legal page by its slug or title.
 *
 * @param array<string, mixed> $target Page target.
 * @return WP_Post[]
 */
function hohorizon_find_legal_pages($target) {
	$found = array();
	foreach ($target['slugs'] as $slug) {
		$page = get_page_by_path($slug);
		if ($page) {
			$found[$page->ID] = $page;
		}
	}
	global $wpdb;
	foreach ($target['titles'] as $title) {
		$ids = $wpdb->get_col($wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'page' AND post_status NOT IN ('trash','auto-draft') AND post_title = %s",
			$title
		));
		foreach ($ids as $id) {
			$page = get_post((int) $id);
			if ($page) {
				$found[$page->ID] = $page;
			}
		}
	}
	return array_values($found);
}

/**
 * Write the legal copy into existing Pages, and create any page that is missing.
 */
function hohorizon_fill_legal_pages() {
	foreach (hohorizon_legal_page_targets() as $key => $target) {
		$content = hohorizon_legal_document($key);
		$pages = hohorizon_find_legal_pages($target);
		if (!$pages) {
			hohorizon_ensure_post(
				array(
					'post_type'    => 'page',
					'post_status'  => 'publish',
					'post_name'    => $target['slug'],
					'post_title'   => $target['title'],
					'post_excerpt' => $target['excerpt'],
					'post_content' => $content,
				),
				array('_hohorizon_eyebrow' => $target['eyebrow'])
			);
			continue;
		}
		foreach ($pages as $page) {
			if (strpos($page->post_content, 'Last updated 25 November 2026') !== false) {
				continue;
			}
			wp_update_post(wp_slash(array(
				'ID'           => $page->ID,
				'post_content' => $content,
				'post_excerpt' => $target['excerpt'],
				'post_status'  => 'publish',
			)));
			update_post_meta($page->ID, '_hohorizon_eyebrow', $target['eyebrow']);
		}
	}
}
add_action('init', 'hohorizon_fill_legal_pages');
