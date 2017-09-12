-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `checklist`;
CREATE TABLE `checklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `property_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `contact_fields`;
CREATE TABLE `contact_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopify_field` varchar(255) NOT NULL,
  `default_address` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `contact_fields` (`id`, `shopify_field`, `default_address`) VALUES
(1,	'id',	0),
(2,	'email',	0),
(3,	'accepts_marketing',	0),
(4,	'first_name',	0),
(5,	'last_name',	0),
(6,	'orders_count',	0),
(7,	'state',	0),
(8,	'total_spent',	0),
(9,	'last_order_id',	0),
(10,	'note',	0),
(11,	'verified_email',	0),
(12,	'tax_exempt',	0),
(13,	'phone',	0),
(14,	'tags',	0),
(15,	'last_order_name',	0),
(16,	'first_name',	1),
(17,	'last_name',	1),
(18,	'company',	1),
(19,	'address1',	1),
(20,	'address2',	1),
(21,	'city',	1),
(22,	'province',	1),
(23,	'country',	1),
(24,	'zip',	1),
(25,	'phone',	1),
(26,	'name',	1),
(27,	'province_code',	1),
(28,	'country_code',	1),
(29,	'country_name',	1);

DROP TABLE IF EXISTS `contact_mapping`;
CREATE TABLE `contact_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `shopify_field` varchar(255) NOT NULL,
  `shopify_field_id` varchar(255) NOT NULL,
  `emarsys_field_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(255) NOT NULL,
  `emarsys_code` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `country` (`id`, `country`, `emarsys_code`) VALUES
(1,	'Afghanistan',	1),
(2,	'Albania',	2),
(3,	'Algeria',	3),
(4,	'Andorra',	4),
(5,	'Angola',	5),
(6,	'Antigua and Barbuda',	6),
(7,	'Argentina',	7),
(8,	'Armenia',	8),
(9,	'Australia',	9),
(10,	'Austria',	10),
(11,	'Azerbaijan',	11),
(12,	'Bahamas',	12),
(13,	'Bahrain',	13),
(14,	'Bangladesh',	14),
(15,	'Barbados',	15),
(16,	'Belarus',	16),
(17,	'Belgium',	17),
(18,	'Belize',	18),
(19,	'Benin',	19),
(20,	'Bhutan',	20),
(21,	'Bolivia',	21),
(22,	'Bosnia and Herzegovina',	22),
(23,	'Botswana',	23),
(24,	'Brazil',	24),
(25,	'Brunei Darussalam',	25),
(26,	'Bulgaria',	26),
(27,	'Burkina Faso',	27),
(28,	'Burma',	28),
(29,	'Burundi',	29),
(30,	'Cambodia',	30),
(31,	'Cameroon',	31),
(32,	'Canada',	32),
(33,	'Cape Verde',	33),
(34,	'Central African Republic',	34),
(35,	'Chad',	35),
(36,	'Chile',	36),
(37,	'China',	37),
(38,	'Colombia',	38),
(39,	'Comoros',	39),
(40,	'Congo',	40),
(41,	'Congo, Democratic Republic of the',	41),
(42,	'Costa Rica',	42),
(43,	'Cote d’Ivoire',	43),
(44,	'Croatia',	44),
(45,	'Cuba',	45),
(46,	'Cyprus',	46),
(47,	'Czech Republic',	47),
(48,	'Denmark',	48),
(49,	'Djibouti',	49),
(50,	'Dominica',	50),
(51,	'Dominican Republic',	51),
(52,	'Ecuador',	52),
(53,	'Egypt',	53),
(54,	'El Salvador',	54),
(55,	'Equatorial Guinea',	55),
(56,	'Eritrea',	56),
(57,	'Estonia',	57),
(58,	'Ethiopia',	58),
(59,	'Fiji',	59),
(60,	'Finland',	60),
(61,	'France',	61),
(62,	'Gabon',	62),
(63,	'Gambia, The',	63),
(64,	'Georgia',	64),
(65,	'Germany',	65),
(66,	'Ghana',	66),
(67,	'Greece',	67),
(68,	'Grenada',	68),
(69,	'Guatemala',	69),
(70,	'Guinea',	70),
(71,	'Guinea-Bissau',	71),
(72,	'Guyana',	72),
(73,	'Haiti',	73),
(74,	'Honduras',	74),
(75,	'Hungary',	75),
(76,	'Iceland',	76),
(77,	'India',	77),
(78,	'Indonesia',	78),
(79,	'Iran',	79),
(80,	'Iraq',	80),
(81,	'Ireland',	81),
(82,	'Israel',	82),
(83,	'Italy',	83),
(84,	'Jamaica',	84),
(85,	'Japan',	85),
(86,	'Jordan',	86),
(87,	'Kazakhstan',	87),
(88,	'Kenya',	88),
(89,	'Kiribati',	89),
(90,	'Korea, North',	90),
(91,	'Korea, South',	91),
(92,	'Kuwait',	92),
(93,	'Kyrgyzstan',	93),
(94,	'Laos',	94),
(95,	'Latvia',	95),
(96,	'Lebanon',	96),
(97,	'Lesotho',	97),
(98,	'Liberia',	98),
(99,	'Libya',	99),
(100,	'Liechtenstein',	100),
(101,	'Lithuania',	101),
(102,	'Luxembourg',	102),
(103,	'Macedonia',	103),
(104,	'Madagascar',	104),
(105,	'Malawi',	105),
(106,	'Malaysia',	106),
(107,	'Maldives',	107),
(108,	'Mali',	108),
(109,	'Malta',	109),
(110,	'Marshall Islands',	110),
(111,	'Mauritania',	111),
(112,	'Mauritius',	112),
(113,	'Mexico',	113),
(114,	'Micronesia',	114),
(115,	'Moldova',	115),
(116,	'Monaco',	116),
(117,	'Mongolia',	117),
(118,	'Morocco',	118),
(119,	'Mozambique',	119),
(120,	'Myanmar',	120),
(121,	'Namibia',	121),
(122,	'Nauru',	122),
(123,	'Nepal',	123),
(124,	'The Netherlands',	124),
(125,	'New Zealand',	125),
(126,	'Nicaragua',	126),
(127,	'Niger',	127),
(128,	'Nigeria',	128),
(129,	'Norway',	129),
(130,	'Oman',	130),
(131,	'Pakistan',	131),
(132,	'Palau',	132),
(133,	'Panama',	134),
(134,	'Papua New Guinea',	135),
(135,	'Paraguay',	136),
(136,	'Peru',	137),
(137,	'Philippines',	138),
(138,	'Poland',	139),
(139,	'Portugal',	140),
(140,	'Qatar',	141),
(141,	'Romania',	142),
(142,	'Russia',	143),
(143,	'Rwanda',	144),
(144,	'St. Kitts and Nevis',	145),
(145,	'St. Lucia',	146),
(146,	'St. Vincent and The Grenadines',	147),
(147,	'Samoa',	148),
(148,	'San Marino',	149),
(149,	'São Tomé and Príncipe',	150),
(150,	'Saudi Arabia',	151),
(151,	'Senegal',	152),
(152,	'Serbia',	153),
(153,	'Seychelles',	154),
(154,	'Sierra Leone',	155),
(155,	'Singapore',	156),
(156,	'Slovakia',	157),
(157,	'Slovenia',	158),
(158,	'Solomon Islands',	159),
(159,	'Somalia',	160),
(160,	'South Africa',	161),
(161,	'Spain',	162),
(162,	'Sri Lanka',	163),
(163,	'Sudan',	164),
(164,	'Suriname',	165),
(165,	'Swaziland',	166),
(166,	'Sweden',	167),
(167,	'Switzerland',	168),
(168,	'Syria',	169),
(169,	'Taiwan',	170),
(170,	'Tajikistan',	171),
(171,	'Tanzania',	172),
(172,	'Thailand',	173),
(173,	'Togo',	174),
(174,	'Tonga',	175),
(175,	'Trinidad and Tobago',	176),
(176,	'Tunisia',	177),
(177,	'Turkey',	178),
(178,	'Turkmenistan',	179),
(179,	'Tuvalu',	180),
(180,	'Uganda',	181),
(181,	'Ukraine',	182),
(182,	'United Arab Emirates',	183),
(183,	'United Kingdom',	184),
(184,	'United States of America',	185),
(185,	'Uruguay',	186),
(186,	'Uzbekistan',	187),
(187,	'Vanuatu',	188),
(188,	'Vatican City',	189),
(189,	'Venezuela',	190),
(190,	'Vietnam',	191),
(191,	'Western Sahara',	192),
(192,	'Yemen',	193),
(193,	'Yugoslavia',	194),
(194,	'Zaire',	195),
(195,	'Zambia',	196),
(196,	'Zimbabwe',	197),
(197,	'Greenland',	198),
(198,	'Virgin Islands',	199),
(199,	'Canary Islands',	201),
(200,	'Montenegro',	202),
(201,	'Gibraltar',	203),
(202,	'Netherlands Antilles',	204),
(203,	'Hong Kong',	205),
(204,	'Macau',	206),
(205,	'East Timor',	258),
(206,	'Kosovo',	259);

DROP TABLE IF EXISTS `cron`;
CREATE TABLE `cron` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `shopify_data` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `frequency` varchar(255) NOT NULL,
  `execute_min` int(11) NOT NULL,
  `execute_hour` int(11) NOT NULL,
  `execute_day` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `emarsys_cart_placeholders`;
CREATE TABLE `emarsys_cart_placeholders` (
  `pkCartPlaceholderID` int(11) NOT NULL AUTO_INCREMENT,
  `fkShopifyEventID` int(11) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `cart_id` varchar(255) DEFAULT NULL,
  `cart_token` varchar(255) DEFAULT NULL,
  `cart_line_items` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `item_qty` varchar(255) DEFAULT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_price` varchar(255) DEFAULT NULL,
  `item_discounted_price` varchar(255) DEFAULT NULL,
  `item_line_price` varchar(255) DEFAULT NULL,
  `item_total_discount` varchar(255) DEFAULT NULL,
  `item_sku` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pkCartPlaceholderID`),
  KEY `fkShopifyEventID` (`fkShopifyEventID`),
  CONSTRAINT `emarsys_cart_placeholders_ibfk_1` FOREIGN KEY (`fkShopifyEventID`) REFERENCES `shopify_events` (`pkShopifyEventID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_checkout_placeholders`;
CREATE TABLE `emarsys_checkout_placeholders` (
  `pkCheckoutPlaceholderID` int(11) NOT NULL AUTO_INCREMENT,
  `fkShopifyEventID` int(11) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `checkout_id` varchar(255) DEFAULT NULL,
  `checkout_token` varchar(255) DEFAULT NULL,
  `checkout_cart_token` varchar(255) DEFAULT NULL,
  `checkout_email` varchar(255) DEFAULT NULL,
  `checkout_created_at` varchar(255) DEFAULT NULL,
  `checkout_updated_at` varchar(255) DEFAULT NULL,
  `checkout_subtotal_price` varchar(255) DEFAULT NULL,
  `checkout_total_discounts` varchar(255) DEFAULT NULL,
  `checkout_total_line_items_price` varchar(255) DEFAULT NULL,
  `checkout_total_price` varchar(255) DEFAULT NULL,
  `checkout_total_tax` varchar(255) DEFAULT NULL,
  `checkout_currency` varchar(255) DEFAULT NULL,
  `checkout_user_id` varchar(255) DEFAULT NULL,
  `checkout_location_id` varchar(255) DEFAULT NULL,
  `checkout_abandoned_checkout_url` varchar(255) DEFAULT NULL,
  `checkout_line_items` varchar(255) DEFAULT NULL,
  `item_destination_location_id` varchar(255) DEFAULT NULL,
  `item_fulfillment_service` varchar(255) DEFAULT NULL,
  `item_line_price` varchar(255) DEFAULT NULL,
  `item_origin_location_id` varchar(255) DEFAULT NULL,
  `item_price` varchar(255) DEFAULT NULL,
  `item_product_id` varchar(255) DEFAULT NULL,
  `item_quantity` varchar(255) DEFAULT NULL,
  `item_requires_shipping` varchar(255) DEFAULT NULL,
  `item_sku` varchar(255) DEFAULT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_variant_id` varchar(255) DEFAULT NULL,
  `item_variant_title` varchar(255) DEFAULT NULL,
  `checkout_billing_address` varchar(255) DEFAULT NULL,
  `billing_address_first_name` varchar(255) DEFAULT NULL,
  `billing_address_last_name` varchar(255) DEFAULT NULL,
  `billing_address_address1` varchar(255) DEFAULT NULL,
  `billing_address_phone` varchar(255) DEFAULT NULL,
  `billing_address_city` varchar(255) DEFAULT NULL,
  `billing_address_zip` varchar(255) DEFAULT NULL,
  `billing_address_province` varchar(255) DEFAULT NULL,
  `billing_address_country` varchar(255) DEFAULT NULL,
  `billing_address_address2` varchar(255) DEFAULT NULL,
  `billing_address_name` varchar(255) DEFAULT NULL,
  `checkout_shipping_address` varchar(255) DEFAULT NULL,
  `shipping_address_first_name` varchar(255) DEFAULT NULL,
  `shipping_address_address1` varchar(255) DEFAULT NULL,
  `shipping_address_phone` varchar(255) DEFAULT NULL,
  `shipping_address_city` varchar(255) DEFAULT NULL,
  `shipping_address_zip` varchar(255) DEFAULT NULL,
  `shipping_address_province` varchar(255) DEFAULT NULL,
  `shipping_address_country` varchar(255) DEFAULT NULL,
  `shipping_address_last_name` varchar(255) DEFAULT NULL,
  `shipping_address_address2` varchar(255) DEFAULT NULL,
  `shipping_address_name` varchar(255) DEFAULT NULL,
  `checkout_customer` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_first_name` varchar(255) DEFAULT NULL,
  `customer_last_name` varchar(255) DEFAULT NULL,
  `customer_orders_count` varchar(255) DEFAULT NULL,
  `customer_state` varchar(255) DEFAULT NULL,
  `customer_total_spent` varchar(255) DEFAULT NULL,
  `customer_verified_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pkCheckoutPlaceholderID`),
  KEY `fkShopifyEventID` (`fkShopifyEventID`),
  CONSTRAINT `emarsys_checkout_placeholders_ibfk_1` FOREIGN KEY (`fkShopifyEventID`) REFERENCES `shopify_events` (`pkShopifyEventID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_contacts`;
CREATE TABLE `emarsys_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `emarsys_shopify_contact_id` int(11) NOT NULL,
  `emarsys_shopify_contact_status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `emarsys_contact_export`;
CREATE TABLE `emarsys_contact_export` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `emarsys_export_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `emarsys_credentials`;
CREATE TABLE `emarsys_credentials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `emarsys_username` varchar(255) NOT NULL,
  `emarsys_password` varchar(255) NOT NULL,
  `emarsys_merchant_id` varchar(255) NOT NULL,
  `emarsys_mershant_script_status` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_customer_placeholder`;
CREATE TABLE `emarsys_customer_placeholder` (
  `pkCustomerPlaceholderID` int(11) NOT NULL AUTO_INCREMENT,
  `fkShopifyEventID` int(11) NOT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_first_name` varchar(255) DEFAULT NULL,
  `customer_last_name` varchar(255) DEFAULT NULL,
  `customer_orders_count` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `address_first_name` varchar(255) DEFAULT NULL,
  `address_last_name` varchar(255) DEFAULT NULL,
  `address_address1` varchar(255) DEFAULT NULL,
  `address_phone` varchar(255) DEFAULT NULL,
  `address_city` varchar(255) DEFAULT NULL,
  `address_province` varchar(255) DEFAULT NULL,
  `address_country` varchar(255) DEFAULT NULL,
  `address_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pkCustomerPlaceholderID`),
  KEY `fkShopifyEventID` (`fkShopifyEventID`),
  CONSTRAINT `emarsys_customer_placeholder_ibfk_1` FOREIGN KEY (`fkShopifyEventID`) REFERENCES `shopify_events` (`pkShopifyEventID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_email_templates`;
CREATE TABLE `emarsys_email_templates` (
  `pkTemplateID` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) DEFAULT NULL,
  `templateTitle` varchar(255) DEFAULT NULL,
  `templateBody` longtext,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pkTemplateID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_event_mapper`;
CREATE TABLE `emarsys_event_mapper` (
  `pkEventMapperID` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `fkShopifyEventID` int(11) DEFAULT NULL,
  `fkEventID` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pkEventMapperID`),
  KEY `fkShopifyEventID` (`fkShopifyEventID`),
  KEY `fkEventID` (`fkEventID`),
  CONSTRAINT `emarsys_event_mapper_ibfk_1` FOREIGN KEY (`fkShopifyEventID`) REFERENCES `shopify_events` (`pkShopifyEventID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_external_events`;
CREATE TABLE `emarsys_external_events` (
  `pkEventID` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) DEFAULT NULL,
  `eventEmarsysID` varchar(255) DEFAULT NULL,
  `eventName` varchar(255) DEFAULT NULL,
  `eventStatus` enum('0','1') DEFAULT '1' COMMENT '0 = Incative | 1 = Active',
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pkEventID`),
  KEY `fkStoreID` (`store_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_fields`;
CREATE TABLE `emarsys_fields` (
  `pkFieldID` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) DEFAULT NULL,
  `fieldName` varchar(255) DEFAULT NULL,
  `fieldEmarsysID` int(11) DEFAULT NULL,
  `fieldEmarsysName` varchar(255) DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pkFieldID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_fulfillments_placeholders`;
CREATE TABLE `emarsys_fulfillments_placeholders` (
  `pkFulfillmentPlaceholderID` int(11) NOT NULL AUTO_INCREMENT,
  `fkShopifyEventID` int(11) NOT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `fulfillment_id` varchar(255) DEFAULT NULL,
  `fulfillment_order_id` varchar(255) DEFAULT NULL,
  `fulfillment_status` varchar(255) DEFAULT NULL,
  `fulfillment_tracking_company` varchar(255) DEFAULT NULL,
  `fulfillment_shipment_status` varchar(255) DEFAULT NULL,
  `fulfillment_email` varchar(255) DEFAULT NULL,
  `fulfillment_destination` varchar(255) DEFAULT NULL,
  `address_first_name` varchar(255) DEFAULT NULL,
  `address_last_name` varchar(255) DEFAULT NULL,
  `address_address1` varchar(255) DEFAULT NULL,
  `address_phone` varchar(255) DEFAULT NULL,
  `address_city` varchar(255) DEFAULT NULL,
  `address_zip` varchar(255) DEFAULT NULL,
  `address_province` varchar(255) DEFAULT NULL,
  `address_country` varchar(255) DEFAULT NULL,
  `address_name` varchar(255) DEFAULT NULL,
  `fulfillment_tracking_number` varchar(255) DEFAULT NULL,
  `fulfillment_tracking_url` varchar(255) DEFAULT NULL,
  `fulfillment_line_items` varchar(255) DEFAULT NULL,
  `item_id` varchar(255) DEFAULT NULL,
  `item_qty` varchar(255) DEFAULT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_price` varchar(255) DEFAULT NULL,
  `item_fulfillment_service` varchar(255) DEFAULT NULL,
  `item_requires_shipping` varchar(255) DEFAULT NULL,
  `item_product_exists` varchar(255) DEFAULT NULL,
  `item_sku` varchar(255) DEFAULT NULL,
  `item_fulfillable_quantity` varchar(255) DEFAULT NULL,
  `item_total_discount` varchar(255) DEFAULT NULL,
  `item_fulfillment_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pkFulfillmentPlaceholderID`),
  KEY `fkShopifyEventID` (`fkShopifyEventID`),
  CONSTRAINT `emarsys_fulfillments_placeholders_ibfk_1` FOREIGN KEY (`fkShopifyEventID`) REFERENCES `shopify_events` (`pkShopifyEventID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_optin`;
CREATE TABLE `emarsys_optin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `optin` int(11) NOT NULL,
  `mail_sent` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_order_placeholders`;
CREATE TABLE `emarsys_order_placeholders` (
  `pkOrderPlaceholderID` int(11) NOT NULL AUTO_INCREMENT,
  `fkShopifyEventID` int(11) NOT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `order_email` varchar(255) DEFAULT NULL,
  `order_total_price` varchar(255) DEFAULT NULL,
  `order_subtotal_price` varchar(255) DEFAULT NULL,
  `order_total_tax` varchar(255) DEFAULT NULL,
  `order_currency` varchar(255) DEFAULT NULL,
  `order_total_discounts` varchar(255) DEFAULT NULL,
  `order_total_line_items_price` varchar(255) DEFAULT NULL,
  `order_line_items` varchar(255) DEFAULT NULL,
  `item_product_id` varchar(255) DEFAULT NULL,
  `item_qty` varchar(255) DEFAULT NULL,
  `item_title` varchar(255) DEFAULT NULL,
  `item_price` varchar(255) DEFAULT NULL,
  `item_fulfillment_service` varchar(255) DEFAULT NULL,
  `item_requires_shipping` varchar(255) DEFAULT NULL,
  `item_product_exists` varchar(255) DEFAULT NULL,
  `item_fulfillable_quantity` varchar(255) DEFAULT NULL,
  `item_total_discount` varchar(255) DEFAULT NULL,
  `item_sku` varchar(255) DEFAULT NULL,
  `item_fulfillment_status` varchar(255) DEFAULT NULL,
  `order_shipping_address` varchar(255) DEFAULT NULL,
  `shipping_address_first_name` varchar(255) DEFAULT NULL,
  `shipping_address_last_name` varchar(255) DEFAULT NULL,
  `shipping_address_address1` varchar(255) DEFAULT NULL,
  `shipping_address_phone` varchar(255) DEFAULT NULL,
  `shipping_address_city` varchar(255) DEFAULT NULL,
  `shipping_address_zip` varchar(255) DEFAULT NULL,
  `shipping_address_province` varchar(255) DEFAULT NULL,
  `shipping_address_country` varchar(255) DEFAULT NULL,
  `shipping_address_name` varchar(255) DEFAULT NULL,
  `order_billing_address` varchar(255) DEFAULT NULL,
  `billing_address_first_name` varchar(255) DEFAULT NULL,
  `billing_address_last_name` varchar(255) DEFAULT NULL,
  `billing_address_address1` varchar(255) DEFAULT NULL,
  `billing_address_phone` varchar(255) DEFAULT NULL,
  `billing_address_city` varchar(255) DEFAULT NULL,
  `billing_address_zip` varchar(255) DEFAULT NULL,
  `billing_address_province` varchar(255) DEFAULT NULL,
  `billing_address_country` varchar(255) DEFAULT NULL,
  `billing_address_name` varchar(255) DEFAULT NULL,
  `order_customer` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_first_name` varchar(255) DEFAULT NULL,
  `customer_last_name` varchar(255) DEFAULT NULL,
  `customer_orders_count` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pkOrderPlaceholderID`),
  KEY `fkShopifyEventID` (`fkShopifyEventID`),
  CONSTRAINT `emarsys_order_placeholders_ibfk_1` FOREIGN KEY (`fkShopifyEventID`) REFERENCES `shopify_events` (`pkShopifyEventID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_personalization_fields`;
CREATE TABLE `emarsys_personalization_fields` (
  `pkPersonalizedID` int(11) NOT NULL AUTO_INCREMENT,
  `fkStoreID` int(11) NOT NULL,
  `personilazedKey` varchar(255) DEFAULT NULL,
  `personalizedValue` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pkPersonalizedID`),
  KEY `fkStoreID` (`fkStoreID`),
  CONSTRAINT `emarsys_personalization_fields_ibfk_1` FOREIGN KEY (`fkStoreID`) REFERENCES `store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_product_placeholders`;
CREATE TABLE `emarsys_product_placeholders` (
  `pkProductPlaceholderID` int(11) NOT NULL AUTO_INCREMENT,
  `fkShopifyEventID` int(11) NOT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `product_title` varchar(255) DEFAULT NULL,
  `product_product_type` varchar(255) DEFAULT NULL,
  `product_variants` varchar(255) DEFAULT NULL,
  `variants_id` varchar(255) DEFAULT NULL,
  `variants_product_id` varchar(255) DEFAULT NULL,
  `variants_title` varchar(255) DEFAULT NULL,
  `variants_price` varchar(255) DEFAULT NULL,
  `variants_sku` varchar(255) DEFAULT NULL,
  `product_images` varchar(255) DEFAULT NULL,
  `image_id` varchar(255) DEFAULT NULL,
  `image_product_id` varchar(255) DEFAULT NULL,
  `image_src` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pkProductPlaceholderID`),
  KEY `fkShopifyEventID` (`fkShopifyEventID`),
  CONSTRAINT `emarsys_product_placeholders_ibfk_1` FOREIGN KEY (`fkShopifyEventID`) REFERENCES `shopify_events` (`pkShopifyEventID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `emarsys_shopify_placeholder`;
CREATE TABLE `emarsys_shopify_placeholder` (
  `pkEmarsysShopifyPlaceholderID` int(11) NOT NULL AUTO_INCREMENT,
  `fkShopifyEventID` int(11) DEFAULT NULL,
  `shopifyVar` varchar(255) DEFAULT NULL,
  `shopifyLabel` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pkEmarsysShopifyPlaceholderID`),
  KEY `fkShopifyEventID` (`fkShopifyEventID`),
  CONSTRAINT `emarsys_shopify_placeholder_ibfk_1` FOREIGN KEY (`fkShopifyEventID`) REFERENCES `shopify_events` (`pkShopifyEventID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `optin_campaign_id`;
CREATE TABLE `optin_campaign_id` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `optin_campaign_id` varchar(255) NOT NULL,
  `welcome_campaign_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `optin_verify`;
CREATE TABLE `optin_verify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `shopify_user_id` varchar(255) NOT NULL,
  `auth` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `sftp_credentials`;
CREATE TABLE `sftp_credentials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `sftp_hostname` varchar(255) NOT NULL,
  `sftp_port` int(11) NOT NULL,
  `sftp_username` varchar(255) NOT NULL,
  `sftp_password` varchar(255) NOT NULL,
  `sftp_export` varchar(255) NOT NULL,
  `feed_export` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sftp_si_credentials`;
CREATE TABLE `sftp_si_credentials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `sftp_hostname` varchar(255) NOT NULL,
  `sftp_port` int(11) NOT NULL,
  `sftp_username` varchar(255) NOT NULL,
  `sftp_password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `shopify_events`;
CREATE TABLE `shopify_events` (
  `pkShopifyEventID` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `shopifyEnevtName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pkShopifyEventID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `shopify_webhook`;
CREATE TABLE `shopify_webhook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `shopify_webhook_id` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `smart_insight`;
CREATE TABLE `smart_insight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `order_name` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `webhook_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0= refund, 1= paid ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `smart_insight_webhook`;
CREATE TABLE `smart_insight_webhook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `webhook_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `store`;
CREATE TABLE `store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `webdav_credentials`;
CREATE TABLE `webdav_credentials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 2017-09-12 11:30:29
