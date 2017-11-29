<?php

/**
 * Returns an array of country names.
 * @return string[]
 */
function owp_get_countries()
{
	return array (
			'AF' => 'Afghanistan', 
			'AX' => 'Aland Islands', 
			'AL' => 'Albania', 
			'DZ' => 'Algeria', 
			'AS' => 'American Samoa', 
			'AD' => 'Andorra', 
			'AO' => 'Angola', 
			'AI' => 'Anguilla', 
			'AQ' => 'Antarctica', 
			'AG' => 'Antigua And Barbuda', 
			'AR' => 'Argentina', 
			'AM' => 'Armenia', 
			'AW' => 'Aruba', 
			'AU' => 'Australia', 
			'AT' => 'Austria', 
			'AZ' => 'Azerbaijan', 
			'BS' => 'Bahamas', 
			'BH' => 'Bahrain', 
			'BD' => 'Bangladesh', 
			'BB' => 'Barbados', 
			'BY' => 'Belarus', 
			'BE' => 'Belgium', 
			'BZ' => 'Belize', 
			'BJ' => 'Benin', 
			'BM' => 'Bermuda', 
			'BT' => 'Bhutan', 
			'BO' => 'Bolivia', 
			'BA' => 'Bosnia And Herzegovina', 
			'BW' => 'Botswana', 
			'BV' => 'Bouvet Island', 
			'BR' => 'Brazil', 
			'IO' => 'British Indian Ocean Territory', 
			'BN' => 'Brunei Darussalam', 
			'BG' => 'Bulgaria', 
			'BF' => 'Burkina Faso', 
			'BI' => 'Burundi', 
			'KH' => 'Cambodia', 
			'CM' => 'Cameroon', 
			'CA' => 'Canada', 
			'CV' => 'Cape Verde', 
			'KY' => 'Cayman Islands', 
			'CF' => 'Central African Republic', 
			'TD' => 'Chad', 
			'CL' => 'Chile', 
			'CN' => 'China', 
			'CX' => 'Christmas Island', 
			'CC' => 'Cocos (Keeling) Islands', 
			'CO' => 'Colombia', 
			'KM' => 'Comoros', 
			'CG' => 'Congo', 
			'CD' => 'Congo, Democratic Republic', 
			'CK' => 'Cook Islands', 
			'CR' => 'Costa Rica', 
			'CI' => 'Cote D\'Ivoire', 
			'HR' => 'Croatia', 
			'CU' => 'Cuba', 
			'CY' => 'Cyprus', 
			'CZ' => 'Czech Republic', 
			'DK' => 'Denmark', 
			'DJ' => 'Djibouti', 
			'DM' => 'Dominica', 
			'DO' => 'Dominican Republic', 
			'EC' => 'Ecuador', 
			'EG' => 'Egypt', 
			'SV' => 'El Salvador', 
			'GQ' => 'Equatorial Guinea', 
			'ER' => 'Eritrea', 
			'EE' => 'Estonia', 
			'ET' => 'Ethiopia', 
			'FK' => 'Falkland Islands (Malvinas)', 
			'FO' => 'Faroe Islands', 
			'FJ' => 'Fiji', 
			'FI' => 'Finland', 
			'FR' => 'France', 
			'GF' => 'French Guiana', 
			'PF' => 'French Polynesia', 
			'TF' => 'French Southern Territories', 
			'GA' => 'Gabon', 
			'GM' => 'Gambia', 
			'GE' => 'Georgia', 
			'DE' => 'Germany', 
			'GH' => 'Ghana', 
			'GI' => 'Gibraltar', 
			'GR' => 'Greece', 
			'GL' => 'Greenland', 
			'GD' => 'Grenada', 
			'GP' => 'Guadeloupe', 
			'GU' => 'Guam', 
			'GT' => 'Guatemala', 
			'GG' => 'Guernsey', 
			'GN' => 'Guinea', 
			'GW' => 'Guinea-Bissau', 
			'GY' => 'Guyana', 
			'HT' => 'Haiti', 
			'HM' => 'Heard Island & Mcdonald Islands', 
			'VA' => 'Holy See (Vatican City State)', 
			'HN' => 'Honduras', 
			'HK' => 'Hong Kong', 
			'HU' => 'Hungary', 
			'IS' => 'Iceland', 
			'IN' => 'India', 
			'ID' => 'Indonesia', 
			'IR' => 'Iran, Islamic Republic Of', 
			'IQ' => 'Iraq', 
			'IE' => 'Ireland', 
			'IM' => 'Isle Of Man', 
			'IL' => 'Israel', 
			'IT' => 'Italy', 
			'JM' => 'Jamaica', 
			'JP' => 'Japan', 
			'JE' => 'Jersey', 
			'JO' => 'Jordan', 
			'KZ' => 'Kazakhstan', 
			'KE' => 'Kenya', 
			'KI' => 'Kiribati', 
			'KR' => 'Korea', 
			'KW' => 'Kuwait', 
			'KG' => 'Kyrgyzstan', 
			'LA' => 'Lao People\'s Democratic Republic', 
			'LV' => 'Latvia', 
			'LB' => 'Lebanon', 
			'LS' => 'Lesotho', 
			'LR' => 'Liberia', 
			'LY' => 'Libyan Arab Jamahiriya', 
			'LI' => 'Liechtenstein', 
			'LT' => 'Lithuania', 
			'LU' => 'Luxembourg', 
			'MO' => 'Macao', 
			'MK' => 'Macedonia', 
			'MG' => 'Madagascar', 
			'MW' => 'Malawi', 
			'MY' => 'Malaysia', 
			'MV' => 'Maldives', 
			'ML' => 'Mali', 
			'MT' => 'Malta', 
			'MH' => 'Marshall Islands', 
			'MQ' => 'Martinique', 
			'MR' => 'Mauritania', 
			'MU' => 'Mauritius', 
			'YT' => 'Mayotte', 
			'MX' => 'Mexico', 
			'FM' => 'Micronesia, Federated States Of', 
			'MD' => 'Moldova', 
			'MC' => 'Monaco', 
			'MN' => 'Mongolia', 
			'ME' => 'Montenegro', 
			'MS' => 'Montserrat', 
			'MA' => 'Morocco', 
			'MZ' => 'Mozambique', 
			'MM' => 'Myanmar', 
			'NA' => 'Namibia', 
			'NR' => 'Nauru', 
			'NP' => 'Nepal', 
			'NL' => 'Netherlands', 
			'AN' => 'Netherlands Antilles', 
			'NC' => 'New Caledonia', 
			'NZ' => 'New Zealand', 
			'NI' => 'Nicaragua', 
			'NE' => 'Niger', 
			'NG' => 'Nigeria', 
			'NU' => 'Niue', 
			'NF' => 'Norfolk Island', 
			'MP' => 'Northern Mariana Islands', 
			'NO' => 'Norway', 
			'OM' => 'Oman', 
			'PK' => 'Pakistan', 
			'PW' => 'Palau', 
			'PS' => 'Palestinian Territory, Occupied', 
			'PA' => 'Panama', 
			'PG' => 'Papua New Guinea', 
			'PY' => 'Paraguay', 
			'PE' => 'Peru', 
			'PH' => 'Philippines', 
			'PN' => 'Pitcairn', 
			'PL' => 'Poland', 
			'PT' => 'Portugal', 
			'PR' => 'Puerto Rico', 
			'QA' => 'Qatar', 
			'RE' => 'Reunion', 
			'RO' => 'Romania', 
			'RU' => 'Russian Federation', 
			'RW' => 'Rwanda', 
			'BL' => 'Saint Barthelemy', 
			'SH' => 'Saint Helena', 
			'KN' => 'Saint Kitts And Nevis', 
			'LC' => 'Saint Lucia', 
			'MF' => 'Saint Martin', 
			'PM' => 'Saint Pierre And Miquelon', 
			'VC' => 'Saint Vincent And Grenadines', 
			'WS' => 'Samoa', 
			'SM' => 'San Marino', 
			'ST' => 'Sao Tome And Principe', 
			'SA' => 'Saudi Arabia', 
			'SN' => 'Senegal', 
			'RS' => 'Serbia', 
			'SC' => 'Seychelles', 
			'SL' => 'Sierra Leone', 
			'SG' => 'Singapore', 
			'SK' => 'Slovakia', 
			'SI' => 'Slovenia', 
			'SB' => 'Solomon Islands', 
			'SO' => 'Somalia', 
			'ZA' => 'South Africa', 
			'GS' => 'South Georgia And Sandwich Isl.', 
			'ES' => 'Spain', 
			'LK' => 'Sri Lanka', 
			'SD' => 'Sudan', 
			'SR' => 'Suriname', 
			'SJ' => 'Svalbard And Jan Mayen', 
			'SZ' => 'Swaziland', 
			'SE' => 'Sweden', 
			'CH' => 'Switzerland', 
			'SY' => 'Syrian Arab Republic', 
			'TW' => 'Taiwan', 
			'TJ' => 'Tajikistan', 
			'TZ' => 'Tanzania', 
			'TH' => 'Thailand', 
			'TL' => 'Timor-Leste', 
			'TG' => 'Togo', 
			'TK' => 'Tokelau', 
			'TO' => 'Tonga', 
			'TT' => 'Trinidad And Tobago', 
			'TN' => 'Tunisia', 
			'TR' => 'Turkey', 
			'TM' => 'Turkmenistan', 
			'TC' => 'Turks And Caicos Islands', 
			'TV' => 'Tuvalu', 
			'UG' => 'Uganda', 
			'UA' => 'Ukraine', 
			'AE' => 'United Arab Emirates', 
			'GB' => 'United Kingdom', 
			'US' => 'United States', 
			'UM' => 'United States Outlying Islands', 
			'UY' => 'Uruguay', 
			'UZ' => 'Uzbekistan', 
			'VU' => 'Vanuatu', 
			'VE' => 'Venezuela', 
			'VN' => 'Viet Nam', 
			'VG' => 'Virgin Islands, British', 
			'VI' => 'Virgin Islands, U.S.', 
			'WF' => 'Wallis And Futuna', 
			'EH' => 'Western Sahara', 
			'YE' => 'Yemen', 
			'ZM' => 'Zambia', 
			'ZW' => 'Zimbabwe' 
	);
}

/**
 * Returns an array of currency descriptions
 *
 * @return string[]
 */
function owp_get_currencies()
{
	return array (
			'AED' => __( 'United Arab Emirates Dirham', 'onlineworldpay' ), 
			'ARS' => __( 'Argentine Peso', 'onlineworldpay' ), 
			'AUD' => __( 'Australian Dollars', 'onlineworldpay' ), 
			'BDT' => __( 'Bangladeshi Taka', 'onlineworldpay' ), 
			'BGN' => __( 'Bulgarian Lev', 'onlineworldpay' ), 
			'BRL' => __( 'Brazilian Real', 'onlineworldpay' ), 
			'CAD' => __( 'Canadian Dollars', 'onlineworldpay' ), 
			'CHF' => __( 'Swiss Franc', 'onlineworldpay' ), 
			'CLP' => __( 'Chilean Peso', 'onlineworldpay' ), 
			'CNY' => __( 'Chinese Yuan', 'onlineworldpay' ), 
			'COP' => __( 'Colombian Peso', 'onlineworldpay' ), 
			'CZK' => __( 'Czech Koruna', 'onlineworldpay' ), 
			'DKK' => __( 'Danish Krone', 'onlineworldpay' ), 
			'DOP' => __( 'Dominican Peso', 'onlineworldpay' ), 
			'EGP' => __( 'Egyptian Pound', 'onlineworldpay' ), 
			'EUR' => __( 'Euros', 'onlineworldpay' ), 
			'GBP' => __( 'Pounds Sterling', 'onlineworldpay' ), 
			'HKD' => __( 'Hong Kong Dollar', 'onlineworldpay' ), 
			'HRK' => __( 'Croatia kuna', 'onlineworldpay' ), 
			'HUF' => __( 'Hungarian Forint', 'onlineworldpay' ), 
			'IDR' => __( 'Indonesia Rupiah', 'onlineworldpay' ), 
			'ILS' => __( 'Israeli Shekel', 'onlineworldpay' ), 
			'INR' => __( 'Indian Rupee', 'onlineworldpay' ), 
			'ISK' => __( 'Icelandic krona', 'onlineworldpay' ), 
			'JPY' => __( 'Japanese Yen', 'onlineworldpay' ), 
			'KES' => __( 'Kenyan shilling', 'onlineworldpay' ), 
			'LAK' => __( 'Lao Kip', 'onlineworldpay' ), 
			'KRW' => __( 'South Korean Won', 'onlineworldpay' ), 
			'MXN' => __( 'Mexican Peso', 'onlineworldpay' ), 
			'MYR' => __( 'Malaysian Ringgits', 'onlineworldpay' ), 
			'NGN' => __( 'Nigerian Naira', 'onlineworldpay' ), 
			'NOK' => __( 'Norwegian Krone', 'onlineworldpay' ), 
			'NPR' => __( 'Nepali Rupee', 'onlineworldpay' ), 
			'NZD' => __( 'New Zealand Dollar', 'onlineworldpay' ), 
			'PHP' => __( 'Philippine Pesos', 'onlineworldpay' ), 
			'PKR' => __( 'Pakistani Rupee', 'onlineworldpay' ), 
			'PLN' => __( 'Polish Zloty', 'onlineworldpay' ), 
			'PYG' => __( 'Paraguayan Guaraní', 'onlineworldpay' ), 
			'RON' => __( 'Romanian Leu', 'onlineworldpay' ), 
			'RUB' => __( 'Russian Ruble', 'onlineworldpay' ), 
			'SEK' => __( 'Swedish Krona', 'onlineworldpay' ), 
			'SGD' => __( 'Singapore Dollar', 'onlineworldpay' ), 
			'THB' => __( 'Thai Baht', 'onlineworldpay' ), 
			'TRY' => __( 'Turkish Lira', 'onlineworldpay' ), 
			'TWD' => __( 'Taiwan New Dollars', 'onlineworldpay' ), 
			'UAH' => __( 'Ukrainian Hryvnia', 'onlineworldpay' ), 
			'USD' => __( 'US Dollars', 'onlineworldpay' ), 
			'VND' => __( 'Vietnamese Dong', 'onlineworldpay' ), 
			'ZAR' => __( 'South African rand', 'onlineworldpay' ) 
	);
}

/**
 * Returns an array of html formatted currency symbols.
 *
 * @return string[]
 */
function owp_get_currency_symbols()
{
	return array (
			'AED' => '&#1583;.&#1573;',  // ?
			'AFN' => '&#65;&#102;', 
			'ALL' => '&#76;&#101;&#107;', 
			'AMD' => '', 
			'ANG' => '&#402;', 
			'AOA' => '&#75;&#122;',  // ?
			'ARS' => '&#36;', 
			'AUD' => '&#36;', 
			'AWG' => '&#402;', 
			'AZN' => '&#1084;&#1072;&#1085;', 
			'BAM' => '&#75;&#77;', 
			'BBD' => '&#36;', 
			'BDT' => '&#2547;',  // ?
			'BGN' => '&#1083;&#1074;', 
			'BHD' => '.&#1583;.&#1576;',  // ?
			'BIF' => '&#70;&#66;&#117;',  // ?
			'BMD' => '&#36;', 
			'BND' => '&#36;', 
			'BOB' => '&#36;&#98;', 
			'BRL' => '&#82;&#36;', 
			'BSD' => '&#36;', 
			'BTN' => '&#78;&#117;&#46;',  // ?
			'BWP' => '&#80;', 
			'BYR' => '&#112;&#46;', 
			'BZD' => '&#66;&#90;&#36;', 
			'CAD' => '&#36;', 
			'CDF' => '&#70;&#67;', 
			'CHF' => '&#67;&#72;&#70;', 
			'CLF' => '',  // ?
			'CLP' => '&#36;', 
			'CNY' => '&#165;', 
			'COP' => '&#36;', 
			'CRC' => '&#8353;', 
			'CUP' => '&#8396;', 
			'CVE' => '&#36;',  // ?
			'CZK' => '&#75;&#269;', 
			'DJF' => '&#70;&#100;&#106;',  // ?
			'DKK' => '&#107;&#114;', 
			'DOP' => '&#82;&#68;&#36;', 
			'DZD' => '&#1583;&#1580;',  // ?
			'EGP' => '&#163;', 
			'ETB' => '&#66;&#114;', 
			'EUR' => '&#8364;', 
			'FJD' => '&#36;', 
			'FKP' => '&#163;', 
			'GBP' => '&#163;', 
			'GEL' => '&#4314;',  // ?
			'GHS' => '&#162;', 
			'GIP' => '&#163;', 
			'GMD' => '&#68;',  // ?
			'GNF' => '&#70;&#71;',  // ?
			'GTQ' => '&#81;', 
			'GYD' => '&#36;', 
			'HKD' => '&#36;', 
			'HNL' => '&#76;', 
			'HRK' => '&#107;&#110;', 
			'HTG' => '&#71;',  // ?
			'HUF' => '&#70;&#116;', 
			'IDR' => '&#82;&#112;', 
			'ILS' => '&#8362;', 
			'INR' => '&#8377;', 
			'IQD' => '&#1593;.&#1583;',  // ?
			'IRR' => '&#65020;', 
			'ISK' => '&#107;&#114;', 
			'JEP' => '&#163;', 
			'JMD' => '&#74;&#36;', 
			'JOD' => '&#74;&#68;',  // ?
			'JPY' => '&#165;', 
			'KES' => '&#75;&#83;&#104;',  // ?
			'KGS' => '&#1083;&#1074;', 
			'KHR' => '&#6107;', 
			'KMF' => '&#67;&#70;',  // ?
			'KPW' => '&#8361;', 
			'KRW' => '&#8361;', 
			'KWD' => '&#1583;.&#1603;',  // ?
			'KYD' => '&#36;', 
			'KZT' => '&#1083;&#1074;', 
			'LAK' => '&#8365;', 
			'LBP' => '&#163;', 
			'LKR' => '&#8360;', 
			'LRD' => '&#36;', 
			'LSL' => '&#76;',  // ?
			'LTL' => '&#76;&#116;', 
			'LVL' => '&#76;&#115;', 
			'LYD' => '&#1604;.&#1583;',  // ?
			'MAD' => '&#1583;.&#1605;.',  // ?
			'MDL' => '&#76;', 
			'MGA' => '&#65;&#114;',  // ?
			'MKD' => '&#1076;&#1077;&#1085;', 
			'MMK' => '&#75;', 
			'MNT' => '&#8366;', 
			'MOP' => '&#77;&#79;&#80;&#36;',  // ?
			'MRO' => '&#85;&#77;',  // ?
			'MUR' => '&#8360;',  // ?
			'MVR' => '.&#1923;',  // ?
			'MWK' => '&#77;&#75;', 
			'MXN' => '&#36;', 
			'MYR' => '&#82;&#77;', 
			'MZN' => '&#77;&#84;', 
			'NAD' => '&#36;', 
			'NGN' => '&#8358;', 
			'NIO' => '&#67;&#36;', 
			'NOK' => '&#107;&#114;', 
			'NPR' => '&#8360;', 
			'NZD' => '&#36;', 
			'OMR' => '&#65020;', 
			'PAB' => '&#66;&#47;&#46;', 
			'PEN' => '&#83;&#47;&#46;', 
			'PGK' => '&#75;',  // ?
			'PHP' => '&#8369;', 
			'PKR' => '&#8360;', 
			'PLN' => '&#122;&#322;', 
			'PYG' => '&#71;&#115;', 
			'QAR' => '&#65020;', 
			'RON' => '&#108;&#101;&#105;', 
			'RSD' => '&#1044;&#1080;&#1085;&#46;', 
			'RUB' => '&#1088;&#1091;&#1073;', 
			'RWF' => '&#1585;.&#1587;', 
			'SAR' => '&#65020;', 
			'SBD' => '&#36;', 
			'SCR' => '&#8360;', 
			'SDG' => '&#163;',  // ?
			'SEK' => '&#107;&#114;', 
			'SGD' => '&#36;', 
			'SHP' => '&#163;', 
			'SLL' => '&#76;&#101;',  // ?
			'SOS' => '&#83;', 
			'SRD' => '&#36;', 
			'STD' => '&#68;&#98;',  // ?
			'SVC' => '&#36;', 
			'SYP' => '&#163;', 
			'SZL' => '&#76;',  // ?
			'THB' => '&#3647;', 
			'TJS' => '&#84;&#74;&#83;',  // ? TJS (guess)
			'TMT' => '&#109;', 
			'TND' => '&#1583;.&#1578;', 
			'TOP' => '&#84;&#36;', 
			'TRY' => '&#8356;',  // New Turkey Lira (old symbol used)
			'TTD' => '&#36;', 
			'TWD' => '&#78;&#84;&#36;', 
			'TZS' => '', 
			'UAH' => '&#8372;', 
			'UGX' => '&#85;&#83;&#104;', 
			'USD' => '&#36;', 
			'UYU' => '&#36;&#85;', 
			'UZS' => '&#1083;&#1074;', 
			'VEF' => '&#66;&#115;', 
			'VND' => '&#8363;', 
			'VUV' => '&#86;&#84;', 
			'WST' => '&#87;&#83;&#36;', 
			'XAF' => '&#70;&#67;&#70;&#65;', 
			'XCD' => '&#36;', 
			'XDR' => '', 
			'XOF' => '', 
			'XPF' => '&#70;', 
			'YER' => '&#65020;', 
			'ZAR' => '&#82;', 
			'ZMK' => '&#90;&#75;',  // ?
			'ZWL' => '&#90;&#36;' 
	);
}

/**
 * Return the exponent that indicates the smalles measuring point for a currency.
 * <div>Country exponents used from <a href="https://en.wikipedia.org/wiki/ISO_4217">Wiki ISO 4712</a>.
 *
 * @param string $currency        	
 */
function owp_get_currency_code_exponent( $currency = 'GBP' )
{
	$array = array (
			'AED' => 2, 
			'ARS' => 2, 
			'AUD' => 2, 
			'BDT' => 2, 
			'BGN' => 2, 
			'BRL' => 2, 
			'CAD' => 2, 
			'CHF' => 2, 
			'CLP' => 0, 
			'CNY' => 2, 
			'COP' => 2, 
			'CZK' => 2, 
			'DKK' => 2, 
			'DOP' => 2, 
			'EGP' => 2, 
			'EUR' => 2, 
			'GBP' => 2, 
			'HKD' => 2, 
			'HRK' => 2, 
			'HUF' => 2, 
			'IDR' => 2, 
			'ILS' => 2, 
			'INR' => 2, 
			'ISK' => 0, 
			'JPY' => 0, 
			'KES' => 2, 
			'LAK' => 2, 
			'KRW' => 0, 
			'MXN' => 2, 
			'MYR' => 2, 
			'NGN' => 2, 
			'NOK' => 2, 
			'NPR' => 2, 
			'NZD' => 2, 
			'PHP' => 2, 
			'PKR' => 2, 
			'PLN' => 2, 
			'PYG' => 0, 
			'RON' => 2, 
			'RUB' => 2, 
			'SEK' => 2, 
			'SGD' => 2, 
			'THB' => 2, 
			'TRY' => 2, 
			'TWD' => 2, 
			'UAH' => 2, 
			'USD' => 2, 
			'VND' => 0, 
			'ZAR' => 2 
	);
	return $array [ $currency ];
}

/**
 * Return an array of settlement currencies.
 *
 * @return string[]
 */
function owp_get_settlement_currencies()
{
	return array (
			'GBP' => __( 'Pounds Sterling', 'onlineworldpay' ), 
			'EUR' => __( 'Euros', 'onlineworldpay' ), 
			'USD' => __( 'US Dollars', 'onlineworldpay' ), 
			'CAD' => __( 'Canadian Dollars', 'onlineworldpay' ), 
			'DKK' => __( 'Danish Krone', 'onlineworldpay' ), 
			'HKD' => __( 'Hong Kong Dollar', 'onlineworldpay' ), 
			'NOK' => __( 'Norwegian Krone', 'onlineworldpay' ), 
			'SEK' => __( 'Swedish Krona', 'onlineworldpay' ), 
			'SGD' => __( 'Singapore Dollar', 'onlineworldpay' ) 
	);
}

/**
 * Returns the currecny symbol for the provided $currency.
 *
 * @param string $symbol        	
 * @return string
 */
function owp_get_currency_symbol( $currency = 'USD' )
{
	$symbols = owp_get_currency_symbols();
	return $symbols [ $currency ];
}

/**
 * function that returns an array of payment methods.
 *
 * @return string[][]
 */
function owp_get_payment_methods()
{
	return array (
			'amex' => array (
					'type' => 'img', 
					'src' => ONLINEWORLDPAY_ASSETS . 'images/amex.png', 
					'class' => 'payment-method-img', 
					'value' => 'American Express' 
			), 
			'china_union_pay' => array (
					'type' => 'img', 
					'src' => ONLINEWORLDPAY_ASSETS . 'images/china_union_pay.png', 
					'class' => 'payment-method-img', 
					'value' => 'China UnionPay' 
			), 
			'diners_club_international' => array (
					'type' => 'img', 
					'src' => ONLINEWORLDPAY_ASSETS . 'images/diners_club_international.png', 
					'class' => 'payment-method-img', 
					'value' => 'Diner\'s Club' 
			), 
			'discover' => array (
					'type' => 'img', 
					'src' => ONLINEWORLDPAY_ASSETS . 'images/discover.png', 
					'class' => 'payment-method-img', 
					'value' => 'Discover' 
			), 
			'jcb' => array (
					'type' => 'img', 
					'src' => ONLINEWORLDPAY_ASSETS . 'images/jcb.png', 
					'class' => 'payment-method-img', 
					'value' => 'JCB' 
			), 
			'maestro' => array (
					'type' => 'img', 
					'src' => ONLINEWORLDPAY_ASSETS . 'images/maestro.png', 
					'class' => 'payment-method-img', 
					'value' => 'Maestro' 
			), 
			'master_card' => array (
					'type' => 'img', 
					'src' => ONLINEWORLDPAY_ASSETS . 'images/master_card.png', 
					'class' => 'payment-method-img', 
					'value' => 'MasterCard' 
			), 
			'solo' => array (
					'type' => 'img', 
					'src' => ONLINEWORLDPAY_ASSETS . 'images/solo.png', 
					'class' => 'payment-method-img', 
					'value' => 'Solo' 
			), 
			'switch_type' => array (
					'type' => 'img', 
					'src' => ONLINEWORLDPAY_ASSETS . 'images/switch_type.png', 
					'class' => 'payment-method-img', 
					'value' => 'Switch' 
			), 
			'visa' => array (
					'type' => 'img', 
					'src' => ONLINEWORLDPAY_ASSETS . 'images/visa.png', 
					'class' => 'payment-method-img', 
					'value' => 'Visa' 
			), 
			'paypal' => array (
					'type' => 'img', 
					'src' => ONLINEWORLDPAY_ASSETS . 'images/paypal.png', 
					'class' => 'payment-method-img', 
					'value' => 'PayPal' 
			) 
	);
}

function owp_get_order_statuses()
{
	return array (
			'wc-pending' => _x( 'Pending Payment', 'Order status', 'woocommerce' ), 
			'wc-processing' => _x( 'Processing', 'Order status', 'woocommerce' ), 
			'wc-on-hold' => _x( 'On Hold', 'Order status', 'woocommerce' ), 
			'wc-completed' => _x( 'Completed', 'Order status', 'woocommerce' ), 
			'wc-cancelled' => _x( 'Cancelled', 'Order status', 'woocommerce' ), 
			'wc-refunded' => _x( 'Refunded', 'Order status', 'woocommerce' ), 
			'wc-failed' => _x( 'Failed', 'Order status', 'woocommerce' ) 
	);
}

function owp_get_subscription_statuses()
{
	return array (
			'wc-pending' => _x( 'Pending', 'Subscription status', 'woocommerce-subscriptions' ), 
			'wc-active' => _x( 'Active', 'Subscription status', 'woocommerce-subscriptions' ), 
			'wc-on-hold' => _x( 'On hold', 'Subscription status', 'woocommerce-subscriptions' ), 
			'wc-cancelled' => _x( 'Cancelled', 'Subscription status', 'woocommerce-subscriptions' ), 
			'wc-switched' => _x( 'Switched', 'Subscription status', 'woocommerce-subscriptions' ), 
			'wc-expired' => _x( 'Expired', 'Subscription status', 'woocommerce-subscriptions' ), 
			'wc-pending-cancel' => _x( 'Pending Cancellation', 'Subscription status', 'woocommerce-subscriptions' ) 
	);
}

/**
 * Output and html input form.
 *
 * @param unknown $field        	
 */
function owp_get_input_html( $field )
{
	
	$field [ 'type' ] = isset( $field [ 'type' ] ) ? $field [ 'type' ] : 'text';
	$field [ 'value' ] = isset( $field [ 'value' ] ) ? $field [ 'value' ] : '';
	$field [ 'class' ] = isset( $field [ 'class' ] ) ? $field [ 'class' ] : 'onlineworldpay-input';
	$field [ 'wrapper_class' ] = isset( $field [ 'wrapper_class' ] ) ? $field [ 'wrapper_class' ] : 'onlineworldpay-wrapper';
	$field [ 'name' ] = isset( $field [ 'name' ] ) ? $field [ 'name' ] : $field [ 'id' ];
	
	echo '<p class="' . $field [ 'wrapper_class' ] . '">';
	
	$input = '<input type="' . $field [ 'type' ] . '" id="' . $field [ 'id' ] . '" name="' . $field [ 'name' ] . '" class="' . $field [ 'class' ] . '" value="' . $field [ 'value' ] . '"';
	
	foreach ( $field [ 'attributes' ] as $attribute => $value ) {
		$input .= $attribute . '="' . $value . '" ';
	}
	
	$input .= '/>';
	
	echo $input;
	
	echo '</p>';
}

/**
 * Output an html select field.
 *
 * @param unknown $field        	
 */
function owp_get_select_html( $field )
{
	
	echo '<p class="' . $field [ 'wrapper_class' ] . '">';
	
	echo '<select id="' . $field [ 'id' ] . '" name="' . $field [ 'name' ] . '" class="' . $field [ 'class' ] . '">';
	
	foreach ( $field [ 'options' ] as $option => $value ) {
		echo '<option value="' . $option . '"' . selected( $field [ 'value' ], $option ) . '>' . $value . '</option>';
	}
	
	echo '</select>';
	
	echo '</p>';
}

function owp_get_paypal_buttons()
{
	return array (
			0 => array (
					'type' => 'image', 
					'src' => ONLINEWORLDPAY_ASSETS . 'images/paypal-marquee.svg', 
					'style' => 'color: white; background: linear-gradient(-180deg, #009cde 0%,#0083de 100%);
						padding: 8px 8px; width: 105px; height: 35px; border-radius: 4px;' 
			), 
			1 => array (
					'type' => 'image', 
					'src' => 'https://www.paypalobjects.com/en_US/i/bnr/bnr_MSPFbanner_ec2_143x32.gif', 
					'style' => '' 
			), 
			2 => array (
					'type' => 'image', 
					'src' => 'https://www.paypalobjects.com/en_US/i/btn/btn_xpressCheckout.gif', 
					'style' => '' 
			), 
			3 => array (
					'type' => 'image', 
					'src' => 'https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif', 
					'style' => '' 
			), 
			4 => array (
					'type' => 'image', 
					'src' => 'https://www.paypalobjects.com/en_US/i/btn/x-click-but03.gif', 
					'style' => '' 
			), 
			5 => array (
					'type' => 'image', 
					'src' => 'https://www.paypalobjects.com/en_US/i/btn/x-click-but5.gif', 
					'style' => '' 
			) 
	);
}

function owp_get_paypal_button( $index = 0 )
{
	$buttons = owp_get_paypal_buttons();
	return $buttons [ $index ];
}

function owp_get_order_property( $prop, $order )
{
	$value = '';
	
	if ( owp_is_wc_3_0_0_or_more() ) {
		if ( array_key_exists( $prop, owp_get_3_0_0_updated_props() ) ) {
			$props = owp_get_3_0_0_updated_props();
			$prop = $props [ $prop ];
		}
		if ( is_callable( array (
				$order, 
				"get_$prop" 
		) ) ) {
			$value = $order->{"get_$prop"}();
		} else {
			if ( ! $value = owp_get_3_0_0_deprecated_order_prop( $prop, $order ) ) {
				/**
				 * If the getter method does not exist (for custom properties for example) then
				 * fetch the data directly from the post_meta of the order.
				 */
				$value = get_post_meta( owp_get_order_property( 'id', $order ), "_{$prop}", true );
			}
		}
	} else {
		$value = $order->{$prop};
	}
	return $value;
}

/**
 * Return true if the WC version is 3.0.0 or greater.
 *
 * @return boolean
 */
function owp_is_wc_3_0_0_or_more()
{
	return function_exists( 'WC' ) ? version_compare( WC()->version, '3.0.0', '>=' ) : false;
}

function owp_get_3_0_0_updated_props()
{
	return array (
			'customer_user' => 'customer_id', 
			'order_currency' => 'currency' 
	);
}

function owp_get_3_0_0_deprecated_order_prop( $prop, $order )
{
	$value = null;
	switch( $prop ) {
		case 'post_status' :
			$value = get_post_status( $order->get_id() );
			break;
		case 'id' :
			$value = $order->get_id();
			break;
		case 'order_currency' :
			$value = $order->get_currency();
			break;
		case 'post' :
			$value = get_post( $order->get_id() );
			break;
	}
	return $value;
}