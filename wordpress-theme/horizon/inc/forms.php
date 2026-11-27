<?php
/**
 * Forms that email the site inbox.
 *
 * @package Horizon
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

/**
 * Country dialling codes for the contact number field.
 *
 * @return array<string,string>
 */
function hohorizon_dial_codes() {
	return array(
		'Afghanistan' => '+93',
		'Albania' => '+355',
		'Algeria' => '+213',
		'Andorra' => '+376',
		'Angola' => '+244',
		'Antigua and Barbuda' => '+1 268',
		'Argentina' => '+54',
		'Armenia' => '+374',
		'Australia' => '+61',
		'Austria' => '+43',
		'Azerbaijan' => '+994',
		'Bahamas' => '+1 242',
		'Bahrain' => '+973',
		'Bangladesh' => '+880',
		'Barbados' => '+1 246',
		'Belarus' => '+375',
		'Belgium' => '+32',
		'Belize' => '+501',
		'Benin' => '+229',
		'Bhutan' => '+975',
		'Bolivia' => '+591',
		'Bosnia and Herzegovina' => '+387',
		'Botswana' => '+267',
		'Brazil' => '+55',
		'Brunei' => '+673',
		'Bulgaria' => '+359',
		'Burkina Faso' => '+226',
		'Burundi' => '+257',
		'Cabo Verde' => '+238',
		'Cambodia' => '+855',
		'Cameroon' => '+237',
		'Canada' => '+1',
		'Central African Republic' => '+236',
		'Chad' => '+235',
		'Chile' => '+56',
		'China' => '+86',
		'Colombia' => '+57',
		'Comoros' => '+269',
		'Congo' => '+242',
		'Costa Rica' => '+506',
		'Croatia' => '+385',
		'Cuba' => '+53',
		'Cyprus' => '+357',
		'Czechia' => '+420',
		'Denmark' => '+45',
		'Djibouti' => '+253',
		'Dominica' => '+1 767',
		'Dominican Republic' => '+1 809',
		'Ecuador' => '+593',
		'Egypt' => '+20',
		'El Salvador' => '+503',
		'Equatorial Guinea' => '+240',
		'Eritrea' => '+291',
		'Estonia' => '+372',
		'Eswatini' => '+268',
		'Ethiopia' => '+251',
		'Fiji' => '+679',
		'Finland' => '+358',
		'France' => '+33',
		'Gabon' => '+241',
		'Gambia' => '+220',
		'Georgia' => '+995',
		'Germany' => '+49',
		'Ghana' => '+233',
		'Greece' => '+30',
		'Grenada' => '+1 473',
		'Guatemala' => '+502',
		'Guinea' => '+224',
		'Guinea-Bissau' => '+245',
		'Guyana' => '+592',
		'Haiti' => '+509',
		'Honduras' => '+504',
		'Hungary' => '+36',
		'Iceland' => '+354',
		'India' => '+91',
		'Indonesia' => '+62',
		'Iran' => '+98',
		'Iraq' => '+964',
		'Ireland' => '+353',
		'Israel' => '+972',
		'Italy' => '+39',
		'Jamaica' => '+1 876',
		'Japan' => '+81',
		'Jordan' => '+962',
		'Kazakhstan' => '+7',
		'Kenya' => '+254',
		'Kiribati' => '+686',
		'Kuwait' => '+965',
		'Kyrgyzstan' => '+996',
		'Laos' => '+856',
		'Latvia' => '+371',
		'Lebanon' => '+961',
		'Lesotho' => '+266',
		'Liberia' => '+231',
		'Libya' => '+218',
		'Liechtenstein' => '+423',
		'Lithuania' => '+370',
		'Luxembourg' => '+352',
		'Madagascar' => '+261',
		'Malawi' => '+265',
		'Malaysia' => '+60',
		'Maldives' => '+960',
		'Mali' => '+223',
		'Malta' => '+356',
		'Marshall Islands' => '+692',
		'Mauritania' => '+222',
		'Mauritius' => '+230',
		'Mexico' => '+52',
		'Micronesia' => '+691',
		'Moldova' => '+373',
		'Monaco' => '+377',
		'Mongolia' => '+976',
		'Montenegro' => '+382',
		'Morocco' => '+212',
		'Mozambique' => '+258',
		'Myanmar' => '+95',
		'Namibia' => '+264',
		'Nauru' => '+674',
		'Nepal' => '+977',
		'Netherlands' => '+31',
		'New Zealand' => '+64',
		'Nicaragua' => '+505',
		'Niger' => '+227',
		'Nigeria' => '+234',
		'North Korea' => '+850',
		'North Macedonia' => '+389',
		'Norway' => '+47',
		'Oman' => '+968',
		'Pakistan' => '+92',
		'Palau' => '+680',
		'Palestine' => '+970',
		'Panama' => '+507',
		'Papua New Guinea' => '+675',
		'Paraguay' => '+595',
		'Peru' => '+51',
		'Philippines' => '+63',
		'Poland' => '+48',
		'Portugal' => '+351',
		'Qatar' => '+974',
		'Romania' => '+40',
		'Russia' => '+7',
		'Rwanda' => '+250',
		'Saint Kitts and Nevis' => '+1 869',
		'Saint Lucia' => '+1 758',
		'Saint Vincent and the Grenadines' => '+1 784',
		'Samoa' => '+685',
		'San Marino' => '+378',
		'Sao Tome and Principe' => '+239',
		'Saudi Arabia' => '+966',
		'Senegal' => '+221',
		'Serbia' => '+381',
		'Seychelles' => '+248',
		'Sierra Leone' => '+232',
		'Singapore' => '+65',
		'Slovakia' => '+421',
		'Slovenia' => '+386',
		'Solomon Islands' => '+677',
		'Somalia' => '+252',
		'South Africa' => '+27',
		'South Korea' => '+82',
		'South Sudan' => '+211',
		'Spain' => '+34',
		'Sri Lanka' => '+94',
		'Sudan' => '+249',
		'Suriname' => '+597',
		'Sweden' => '+46',
		'Switzerland' => '+41',
		'Syria' => '+963',
		'Tajikistan' => '+992',
		'Tanzania' => '+255',
		'Thailand' => '+66',
		'Timor-Leste' => '+670',
		'Togo' => '+228',
		'Tonga' => '+676',
		'Trinidad and Tobago' => '+1 868',
		'Tunisia' => '+216',
		'Turkey' => '+90',
		'Turkmenistan' => '+993',
		'Tuvalu' => '+688',
		'Uganda' => '+256',
		'Ukraine' => '+380',
		'United Arab Emirates' => '+971',
		'United Kingdom' => '+44',
		'United States' => '+1',
		'Uruguay' => '+598',
		'Uzbekistan' => '+998',
		'Vanuatu' => '+678',
		'Vatican City' => '+39',
		'Venezuela' => '+58',
		'Vietnam' => '+84',
		'Yemen' => '+967',
		'Zambia' => '+260',
		'Zimbabwe' => '+263',
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
	$card       = in_array($kind, array('contact', 'invitation'), true);
	$form_class = 'site-form' . ($card ? ' contact-form' : '');
	echo '<form class="' . esc_attr($form_class) . '" method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
	if ($card) {
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
			$extra        = $name === 'phone' ? ' inputmode="numeric" maxlength="10" pattern="[0-9]{10}" title="Enter exactly 10 digits"' : '';
			echo '<input name="' . esc_attr($name) . '" type="' . esc_attr($type) . '"' . $req . $placeholder . $autocomplete . $extra . ' />';
		}
		echo '</label>';
	}
	if ($card) {
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
		'contact'     => array('name', 'organisation', 'email', 'phone', 'enquiry'),
		'invitation'  => array('name', 'email', 'organisation', 'role', 'phone', 'country', 'gathering', 'industry', 'message'),
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
		if ($key === 'phone') {
			if (!preg_match('/^[0-9]{10}$/', $value)) {
				$fail();
			}
			$codes   = hohorizon_dial_codes();
			$country = isset($_POST['phone_code']) ? sanitize_text_field(wp_unslash($_POST['phone_code'])) : '';
			if ($country !== '') {
				if (!isset($codes[$country])) {
					$fail();
				}
				$value = $codes[$country] . ' ' . $value;
			}
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
