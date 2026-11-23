<?php
/**
 * Forms that email the site inbox.
 *
 * @package Hohorizon
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Country names for the contact form.
 *
 * @return string[]
 */
function hohorizon_countries() {
	return array(
		'Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Australia', 'Austria', 'Azerbaijan',
		'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi',
		'Cabo Verde', 'Cambodia', 'Cameroon', 'Canada', 'Central African Republic', 'Chad', 'Chile', 'China', 'Colombia', 'Comoros', 'Congo', 'Costa Rica', 'Croatia', 'Cuba', 'Cyprus', 'Czechia',
		'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic',
		'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Eswatini', 'Ethiopia',
		'Fiji', 'Finland', 'France',
		'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana',
		'Haiti', 'Honduras', 'Hungary',
		'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy',
		'Jamaica', 'Japan', 'Jordan',
		'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan',
		'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg',
		'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Mauritania', 'Mauritius', 'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Morocco', 'Mozambique', 'Myanmar',
		'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'North Korea', 'North Macedonia', 'Norway',
		'Oman',
		'Pakistan', 'Palau', 'Palestine', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal',
		'Qatar',
		'Romania', 'Russia', 'Rwanda',
		'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Korea', 'South Sudan', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Sweden', 'Switzerland', 'Syria',
		'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste', 'Togo', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu',
		'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan',
		'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam',
		'Yemen',
		'Zambia', 'Zimbabwe',
	);
}

add_action('admin_post_nopriv_hohorizon_form', 'hohorizon_handle_form');
add_action('admin_post_hohorizon_form', 'hohorizon_handle_form');

/**
 * Print a form.
 *
 * @param string $kind Form kind.
 * @param array  $fields Fields.
 * @param string $submit Button label.
 */
function hohorizon_form($kind, $fields, $submit) {
	$sent = isset($_GET['sent'], $_GET['form']) && sanitize_key(wp_unslash($_GET['form'])) === $kind
		? sanitize_text_field(wp_unslash($_GET['sent']))
		: '';
	if ($sent === '1') {
		echo '<div class="thanks"><p>Thank you. The note was sent to the site inbox.</p></div>';
		return;
	}
	if ($sent === '0') {
		echo '<p class="form-error">The note could not be sent. Check the required fields and try again.</p>';
	}
	$form_class = 'site-form' . ($kind === 'contact' ? ' contact-form' : '');
	echo '<form class="' . esc_attr($form_class) . '" method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
	if ($kind === 'contact') {
		echo '<div class="form-grid">';
	}
	foreach ($fields as $field) {
		$name     = $field['name'];
		$label    = $field['label'];
		$type     = isset($field['type']) ? $field['type'] : 'text';
		$required = empty($field['optional']);
		$req      = $required ? ' required' : '';
		$wide     = !empty($field['wide']) ? ' class="is-wide"' : '';
		echo '<label' . $wide . '>' . esc_html($label);
		if ($type === 'textarea') {
			echo '<textarea name="' . esc_attr($name) . '" rows="5"' . $req . '></textarea>';
		} elseif ($type === 'select') {
			$autocomplete = isset($field['autocomplete']) ? ' autocomplete="' . esc_attr($field['autocomplete']) . '"' : '';
			echo '<select name="' . esc_attr($name) . '"' . $req . $autocomplete . '><option value="">Select</option>';
			foreach ($field['options'] as $option) {
				echo '<option>' . esc_html($option) . '</option>';
			}
			echo '</select>';
		} else {
			$placeholder  = isset($field['placeholder']) ? ' placeholder="' . esc_attr($field['placeholder']) . '"' : '';
			$autocomplete = isset($field['autocomplete']) ? ' autocomplete="' . esc_attr($field['autocomplete']) . '"' : '';
			echo '<input name="' . esc_attr($name) . '" type="' . esc_attr($type) . '"' . $req . $placeholder . $autocomplete . ' />';
		}
		echo '</label>';
	}
	if ($kind === 'contact') {
		echo '</div>';
	}
	echo '<label class="hp" aria-hidden="true">Website<input name="website" tabindex="-1" autocomplete="off" /></label>';
	echo '<input type="hidden" name="action" value="hohorizon_form" />';
	echo '<input type="hidden" name="kind" value="' . esc_attr($kind) . '" />';
	wp_nonce_field('hohorizon_form', 'hohorizon_nonce');
	echo '<button class="btn" type="submit">' . esc_html($submit) . '</button>';
	echo '</form>';
}

/**
 * Send a form to the inbox saved in the Customizer, or the WordPress admin email.
 */
function hohorizon_handle_form() {
	$kind = isset($_POST['kind']) ? sanitize_key(wp_unslash($_POST['kind'])) : '';
	$back = wp_get_referer();
	if (!$back) {
		$back = home_url('/');
	}
	$back = remove_query_arg(array('sent', 'form'), $back);

	$fail = function () use ($back, $kind) {
		wp_safe_redirect(add_query_arg(array('sent' => '0', 'form' => $kind), $back));
		exit;
	};

	if (!isset($_POST['hohorizon_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['hohorizon_nonce'])), 'hohorizon_form')) {
		$fail();
	}
	if (!empty($_POST['website'])) {
		$fail();
	}

	$allowed = array(
		'contact'     => array('name', 'email', 'organisation', 'role', 'phone', 'country', 'enquiry', 'message'),
		'invitation'  => array('name', 'organisation', 'role', 'country', 'email', 'message'),
		'partnership' => array('name', 'organisation', 'email', 'interest', 'message'),
		'newsletter'  => array('email'),
	);
	if (!isset($allowed[$kind])) {
		$fail();
	}

	$lines = array();
	foreach ($allowed[$kind] as $key) {
		$raw = isset($_POST[$key]) ? wp_unslash($_POST[$key]) : '';
		if ($key === 'email') {
			$value = sanitize_email($raw);
		} elseif ($key === 'message') {
			$value = sanitize_textarea_field($raw);
		} else {
			$value = sanitize_text_field($raw);
		}
		if ($value === '') {
			if ($key === 'phone') {
				continue;
			}
			$fail();
		}
		$lines[] = ucfirst($key) . ': ' . $value;
	}

	$to = hohorizon_mod('inbox');
	if (!is_email($to)) {
		$to = get_option('admin_email');
	}
	$reply = '';
	foreach ($lines as $line) {
		if (strpos($line, 'Email: ') === 0) {
			$reply = trim(substr($line, 7));
		}
	}
	$headers = array('Content-Type: text/plain; charset=UTF-8');
	if (is_email($reply)) {
		$headers[] = 'Reply-To: ' . $reply;
	}
	$sent = wp_mail($to, 'Horizon ' . $kind, implode("\n", $lines), $headers);
	wp_safe_redirect(add_query_arg(array('sent' => $sent ? '1' : '0', 'form' => $kind), $back));
	exit;
}
