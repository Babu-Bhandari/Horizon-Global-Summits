<?php
/**
 * Extra fields on pages and theme content.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('add_meta_boxes', 'hohorizon_meta_boxes');
add_action('save_post', 'hohorizon_save_meta');

/**
 * Register the boxes.
 */
function hohorizon_meta_boxes() {
	add_meta_box('hohorizon_page', 'Page details', 'hohorizon_page_box', 'page', 'normal', 'high');
	add_meta_box('hohorizon_event', 'Event details', 'hohorizon_event_box', 'hoh_event', 'normal', 'high');
	add_meta_box('hohorizon_speaker', 'Speaker details', 'hohorizon_speaker_box', 'hoh_speaker', 'normal', 'high');
	add_meta_box('hohorizon_session', 'Session details', 'hohorizon_session_box', 'hoh_session', 'normal', 'high');
	add_meta_box('hohorizon_partner', 'Partner details', 'hohorizon_partner_box', 'hoh_partner', 'side', 'high');
	add_meta_box('hohorizon_topic', 'Topic details', 'hohorizon_topic_box', 'hoh_topic', 'normal', 'high');
	add_meta_box('hohorizon_photo', 'Photo URL', 'hohorizon_photo_box', array('hoh_event', 'hoh_highlight', 'hoh_topic'), 'side', 'default');
}

/**
 * Shared nonce and photo URL field.
 *
 * @param WP_Post $post Post.
 */
function hohorizon_nonce_field($post) {
	wp_nonce_field('hohorizon_save_meta', 'hohorizon_meta_nonce');
}

/**
 * Page label and banner.
 *
 * @param WP_Post $post Post.
 */
function hohorizon_page_box($post) {
	hohorizon_nonce_field($post);
	hohorizon_field('Label above the title', '_hohorizon_eyebrow', get_post_meta($post->ID, '_hohorizon_eyebrow', true));
	hohorizon_field('Banner photo URL', '_hohorizon_hero', get_post_meta($post->ID, '_hohorizon_hero', true), 'A featured image replaces this.');
	hohorizon_field('Second photo URL', '_hohorizon_image', get_post_meta($post->ID, '_hohorizon_image', true), 'Used beside the text on the About page.');
	echo '<p>The line under the title is the excerpt. Add it in the Excerpt panel.</p>';
}

/**
 * Event fields.
 *
 * @param WP_Post $post Post.
 */
function hohorizon_event_box($post) {
	hohorizon_nonce_field($post);
	hohorizon_field('Label', '_hohorizon_kicker', get_post_meta($post->ID, '_hohorizon_kicker', true), 'Example: Placeholder');
	echo '<p>The title is the event name. The excerpt is the short card. The main text is the detail page. Set the order with Page attributes.</p>';
}

/**
 * Speaker fields.
 *
 * @param WP_Post $post Post.
 */
function hohorizon_speaker_box($post) {
	hohorizon_nonce_field($post);
	hohorizon_field('Job title', '_hohorizon_role', get_post_meta($post->ID, '_hohorizon_role', true));
	hohorizon_field('Organisation', '_hohorizon_organisation', get_post_meta($post->ID, '_hohorizon_organisation', true));
	hohorizon_field('Note', '_hohorizon_note', get_post_meta($post->ID, '_hohorizon_note', true), 'Leave empty once this is a confirmed person.');
	echo '<p>The title is the person’s name. The main text is the biography. A featured image replaces the number.</p>';
}

/**
 * Session fields.
 *
 * @param WP_Post $post Post.
 */
function hohorizon_session_box($post) {
	hohorizon_nonce_field($post);
	hohorizon_field('Time', '_hohorizon_time', get_post_meta($post->ID, '_hohorizon_time', true));
	hohorizon_field('Duration', '_hohorizon_duration', get_post_meta($post->ID, '_hohorizon_duration', true));
	$current = get_post_meta($post->ID, '_hohorizon_topic', true);
	echo '<p><label for="hohorizon-topic">Topic<br /><select id="hohorizon-topic" name="_hohorizon_topic">';
	foreach (hohorizon_topics() as $key => $label) {
		echo '<option value="' . esc_attr($key) . '"' . selected($current, $key, false) . '>' . esc_html($label) . '</option>';
	}
	echo '</select></label></p>';
	hohorizon_field('Speaker', '_hohorizon_speaker', get_post_meta($post->ID, '_hohorizon_speaker', true));
	hohorizon_field('Speaker role', '_hohorizon_role', get_post_meta($post->ID, '_hohorizon_role', true));
	echo '<p>The title is the session name. The main text is the one-line description.</p>';
}

/**
 * Partner tier.
 *
 * @param WP_Post $post Post.
 */
function hohorizon_partner_box($post) {
	hohorizon_nonce_field($post);
	$current = get_post_meta($post->ID, '_hohorizon_tier', true);
	echo '<p><label for="hohorizon-tier">Tier<br /><select id="hohorizon-tier" name="_hohorizon_tier">';
	foreach (hohorizon_tiers() as $key => $label) {
		echo '<option value="' . esc_attr($key) . '"' . selected($current, $key, false) . '>' . esc_html($label) . '</option>';
	}
	echo '</select></label></p>';
	echo '<p>The title shows until you set a featured image, which is the logo.</p>';
}

/**
 * Topic related line.
 *
 * @param WP_Post $post Post.
 */
function hohorizon_topic_box($post) {
	hohorizon_nonce_field($post);
	hohorizon_field('Related themes', '_hohorizon_related', get_post_meta($post->ID, '_hohorizon_related', true));
	echo '<p>The title is the subject. The main text is the description.</p>';
}

/**
 * External photo until a featured image is set.
 *
 * @param WP_Post $post Post.
 */
function hohorizon_photo_box($post) {
	if (!isset($_POST['hohorizon_meta_nonce'])) {
		wp_nonce_field('hohorizon_save_meta', 'hohorizon_meta_nonce');
	}
	hohorizon_field('Photo URL', '_hohorizon_image', get_post_meta($post->ID, '_hohorizon_image', true), 'A featured image replaces this.');
}

/**
 * One labelled input.
 *
 * @param string $label Label.
 * @param string $name Field name.
 * @param string $value Value.
 * @param string $help Optional help.
 */
function hohorizon_field($label, $name, $value, $help = '') {
	echo '<p><label>' . esc_html($label) . '<br />';
	echo '<input type="text" class="widefat" name="' . esc_attr($name) . '" value="' . esc_attr((string) $value) . '" />';
	echo '</label>';
	if ($help) {
		echo '<span class="description">' . esc_html($help) . '</span>';
	}
	echo '</p>';
}

/**
 * Save the fields that belong to this post type.
 *
 * @param int $post_id Post ID.
 */
function hohorizon_save_meta($post_id) {
	if (!isset($_POST['hohorizon_meta_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hohorizon_meta_nonce'])), 'hohorizon_save_meta')) {
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	$map = array(
		'page'          => array('_hohorizon_eyebrow', '_hohorizon_hero', '_hohorizon_image'),
		'hoh_event'     => array('_hohorizon_kicker', '_hohorizon_image'),
		'hoh_speaker'   => array('_hohorizon_role', '_hohorizon_organisation', '_hohorizon_note'),
		'hoh_session'   => array('_hohorizon_time', '_hohorizon_duration', '_hohorizon_topic', '_hohorizon_speaker', '_hohorizon_role'),
		'hoh_partner'   => array('_hohorizon_tier'),
		'hoh_topic'     => array('_hohorizon_related', '_hohorizon_image'),
		'hoh_highlight' => array('_hohorizon_image'),
	);
	$type = get_post_type($post_id);
	if (!isset($map[$type])) {
		return;
	}
	foreach ($map[$type] as $key) {
		if (!isset($_POST[$key])) {
			continue;
		}
		$value = sanitize_text_field(wp_unslash($_POST[$key]));
		if (strpos($key, 'image') !== false || strpos($key, 'hero') !== false) {
			$value = esc_url_raw($value);
		}
		update_post_meta($post_id, $key, $value);
	}
}
