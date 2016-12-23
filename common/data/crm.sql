-- phpMyAdmin SQL Dump
-- version 4.6.4deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 16, 2016 at 08:11 AM
-- Server version: 5.7.16-0ubuntu0.16.10.1
-- PHP Version: 7.0.13-0ubuntu0.16.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `action`
--

CREATE TABLE `action` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hold` tinyint(1) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `action`
--

INSERT INTO `action` (`id`, `name`, `hold`, `date_create`) VALUES
(1, 'Взять в работу', 0, '2016-08-31 14:35:20'),
(2, 'Отклонить', 0, '2016-08-31 14:35:26'),
(3, 'Перезвонить', 1, '2016-08-31 14:35:31'),
(4, 'Одобрить', 0, '2016-08-31 14:35:37'),
(5, 'Выкуп', 0, '2016-08-31 14:35:42'),
(6, 'Не выкуп', 0, '2016-08-31 14:35:47'),
(7, 'Отправить', 0, '2016-09-04 06:41:49'),
(8, 'Обработать', 0, '2016-09-04 06:41:57'),
(9, 'Допечатнику', 0, '2016-09-06 09:53:27'),
(10, 'Заказы сформированы', 0, '2016-09-06 09:53:44'),
(11, 'Вернуть', 0, '2016-11-21 08:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('ADMIN', 1, 1472032365),
('ADMIN', 4, 1472710776),
('ADMIN', 8, 1473306185),
('ADMIN', 11, 1476460746),
('ADMIN', 12, 1477886745),
('ADMIN', 13, 1479109682),
('OPERATOR', 2, 1478445448),
('OPERATOR', 5, 1473152369),
('OPERATOR', 6, 1473152986),
('OPERATOR', 9, 1473322252),
('OPERATOR', 10, 1476345384),
('OPERATOR', 14, 1481016821),
('WAREHOUSE_MANAGER', 3, 1472364309),
('WAREHOUSE_MANAGER', 7, 1473155307);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('ADMIN', 1, NULL, NULL, NULL, 1472032345, 1472032345),
('OPERATOR', 1, NULL, NULL, NULL, 1472032345, 1472032345),
('WAREHOUSE_MANAGER', 1, NULL, NULL, NULL, 1472364281, 1472364281);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` text COLLATE utf8_unicode_ci,
  `comment_hash` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `brand`, `date_create`, `user_id`) VALUES
(1, 'Моя компания', 'dsasdf', '2016-12-16 01:13:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `company_contact`
--

CREATE TABLE `company_contact` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `person` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL,
  `value` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `company_contact`
--

INSERT INTO `company_contact` (`id`, `company_id`, `person`, `type`, `value`, `user_id`) VALUES
(6, 1, 'xxdfdf', 1, '12121212', 1),
(7, 1, '76575', 1, '7655', 1),
(8, 1, '5345345', 1, '534534534', 1);

-- --------------------------------------------------------

--
-- Table structure for table `geo_address`
--

CREATE TABLE `geo_address` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_index` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area_id` int(10) UNSIGNED NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `house` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apartment` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_hash` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geo_area`
--

CREATE TABLE `geo_area` (
  `id` int(10) UNSIGNED NOT NULL,
  `region_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `geo_area`
--

INSERT INTO `geo_area` (`id`, `region_id`, `name`, `type`, `date_create`) VALUES
(1, 2, 'Абхазия', 1, '2016-08-24 10:52:45'),
(2, 2, 'Адыгея', 1, '2016-08-24 10:52:45'),
(3, 2, 'Азербайджан', 1, '2016-08-24 10:52:45'),
(4, 5, 'Алтай', 1, '2016-08-24 10:52:45'),
(5, 5, 'Алтайский', 3, '2016-08-24 10:52:45'),
(6, 4, 'Амурская', 2, '2016-08-24 10:52:45'),
(7, 3, 'Архангельская', 2, '2016-08-24 10:52:45'),
(8, 2, 'Астраханская', 2, '2016-08-24 10:52:45'),
(9, 6, 'Байконур', 4, '2016-08-24 10:52:45'),
(10, 7, 'Башкортостан', 1, '2016-08-24 10:52:45'),
(11, 1, 'Белгородская', 2, '2016-08-24 10:52:45'),
(12, 1, 'Брянская', 2, '2016-08-24 10:52:45'),
(13, 5, 'Бурятия', 1, '2016-08-24 10:52:45'),
(14, 1, 'Владимирская', 2, '2016-08-24 10:52:45'),
(15, 2, 'Волгоградская', 2, '2016-08-24 10:52:45'),
(16, 3, 'Вологодская', 2, '2016-08-24 10:52:45'),
(17, 1, 'Воронежская', 2, '2016-08-24 10:52:45'),
(18, 8, 'Дагестан', 1, '2016-08-24 10:52:45'),
(19, 4, 'Еврейская', 7, '2016-08-24 10:52:45'),
(20, 5, 'Забайкальский', 3, '2016-08-24 10:52:45'),
(21, 1, 'Ивановская', 2, '2016-08-24 10:52:45'),
(22, 8, 'Ингушетия', 1, '2016-08-24 10:52:45'),
(23, 5, 'Иркутская', 2, '2016-08-24 10:52:45'),
(24, 8, 'Кабардино-Балкарская', 1, '2016-08-24 10:52:45'),
(25, 3, 'Калининградская', 2, '2016-08-24 10:52:45'),
(26, 2, 'Калмыкия', 1, '2016-08-24 10:52:45'),
(27, 1, 'Калужская', 2, '2016-08-24 10:52:45'),
(28, 4, 'Камчатский', 3, '2016-08-24 10:52:45'),
(29, 8, 'Карачаево-Черкесская', 1, '2016-08-24 10:52:45'),
(30, 3, 'Карелия', 1, '2016-08-24 10:52:45'),
(31, 5, 'Кемеровская', 2, '2016-08-24 10:52:45'),
(32, 7, 'Кировская', 2, '2016-08-24 10:52:45'),
(33, 3, 'Коми', 1, '2016-08-24 10:52:45'),
(34, 1, 'Костромская', 2, '2016-08-24 10:52:45'),
(35, 2, 'Краснодарский', 3, '2016-08-24 10:52:45'),
(36, 5, 'Красноярский', 3, '2016-08-24 10:52:45'),
(37, 10, 'Крым', 1, '2016-08-24 10:52:45'),
(38, 6, 'Курганская', 2, '2016-08-24 10:52:45'),
(39, 1, 'Курская', 2, '2016-08-24 10:52:45'),
(40, 3, 'Ленинградская', 2, '2016-08-24 10:52:45'),
(41, 1, 'Липецкая', 2, '2016-08-24 10:52:45'),
(42, 4, 'Магаданская', 2, '2016-08-24 10:52:45'),
(43, 7, 'Марий Эл', 1, '2016-08-24 10:52:45'),
(44, 7, 'Мордовия', 1, '2016-08-24 10:52:45'),
(45, 1, 'Москва', 4, '2016-08-24 10:52:45'),
(46, 1, 'Московская', 2, '2016-08-24 10:52:45'),
(47, 3, 'Мурманская', 2, '2016-08-24 10:52:45'),
(48, 3, 'Ненецкий', 5, '2016-08-24 10:52:45'),
(49, 7, 'Нижегородская', 2, '2016-08-24 10:52:45'),
(50, 3, 'Новгородская', 2, '2016-08-24 10:52:45'),
(51, 5, 'Новосибирская', 2, '2016-08-24 10:52:45'),
(52, 5, 'Омская', 2, '2016-08-24 10:52:45'),
(53, 7, 'Оренбургская', 2, '2016-08-24 10:52:45'),
(54, 1, 'Орловская', 2, '2016-08-24 10:52:45'),
(55, 7, 'Пензенская', 2, '2016-08-24 10:52:45'),
(56, 7, 'Пермский', 3, '2016-08-24 10:52:45'),
(57, 4, 'Приморский', 3, '2016-08-24 10:52:45'),
(58, 3, 'Псковская', 2, '2016-08-24 10:52:45'),
(59, 2, 'Ростовская', 2, '2016-08-24 10:52:45'),
(60, 1, 'Рязанская', 2, '2016-08-24 10:52:45'),
(61, 7, 'Самарская', 2, '2016-08-24 10:52:45'),
(62, 3, 'Санкт-Петербург', 4, '2016-08-24 10:52:45'),
(63, 7, 'Саратовская', 2, '2016-08-24 10:52:45'),
(64, 4, 'Саха (Якутия)', 1, '2016-08-24 10:52:45'),
(65, 4, 'Сахалинская', 2, '2016-08-24 10:52:45'),
(66, 6, 'Свердловская', 2, '2016-08-24 10:52:45'),
(67, 10, 'Севастополь', 4, '2016-08-24 10:52:45'),
(68, 8, 'Северная Осетия - Алания', 1, '2016-08-24 10:52:45'),
(69, 1, 'Смоленская', 2, '2016-08-24 10:52:45'),
(70, 8, 'Ставропольский', 3, '2016-08-24 10:52:45'),
(71, 1, 'Тамбовская', 2, '2016-08-24 10:52:45'),
(72, 7, 'Татарстан', 1, '2016-08-24 10:52:45'),
(73, 1, 'Тверская', 2, '2016-08-24 10:52:45'),
(74, 5, 'Томская', 2, '2016-08-24 10:52:45'),
(75, 1, 'Тульская', 2, '2016-08-24 10:52:45'),
(76, 5, 'Тыва', 1, '2016-08-24 10:52:45'),
(77, 6, 'Тюменская', 2, '2016-08-24 10:52:45'),
(78, 7, 'Удмуртская', 1, '2016-08-24 10:52:45'),
(79, 7, 'Ульяновская', 2, '2016-08-24 10:52:45'),
(80, 4, 'Хабаровский', 3, '2016-08-24 10:52:45'),
(81, 5, 'Хакасия', 1, '2016-08-24 10:52:45'),
(82, 6, 'Ханты-Мансийский', 5, '2016-08-24 10:52:45'),
(83, 6, 'Челябинская', 2, '2016-08-24 10:52:45'),
(84, 8, 'Чеченская', 1, '2016-08-24 10:52:45'),
(85, 7, 'Чувашская', 1, '2016-08-24 10:52:45'),
(86, 4, 'Чукотский', 5, '2016-08-24 10:52:45'),
(87, 6, 'Ямало-Ненецкий', 5, '2016-08-24 10:52:45'),
(88, 1, 'Ярославская', 2, '2016-08-24 10:52:45');

-- --------------------------------------------------------

--
-- Table structure for table `geo_region`
--

CREATE TABLE `geo_region` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `geo_region`
--

INSERT INTO `geo_region` (`id`, `name`, `date_create`) VALUES
(1, 'Центр', '2016-08-24 10:52:45'),
(2, 'Юг', '2016-08-24 10:52:45'),
(3, 'Северо-Запад', '2016-08-24 10:52:45'),
(4, 'Дальний Восток', '2016-08-24 10:52:45'),
(5, 'Сибирь', '2016-08-24 10:52:45'),
(6, 'Урал', '2016-08-24 10:52:45'),
(7, 'Приволжье', '2016-08-24 10:52:45'),
(8, 'Северный Кавказ', '2016-08-24 10:52:45'),
(10, 'Крым', '2016-08-24 10:52:45');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1472032341),
('m140506_102106_rbac_init', 1472032345),
('m160427_151334_createTables', 1472032365),
('m160510_150631_createFirstUser', 1472032365),
('m160510_155850_migrateGeoData', 1472032365),
('m160603_005650_createSourceAndProcessTimings', 1472032370),
('m160606_012441_changeStructure', 1472032372),
('m160608_012218_addSourceUrl', 1472032372),
('m160608_021955_createOrderProgress', 1472032373),
('m160616_023328_createClientPhone', 1472032379),
('m160623_012758_changeFieldCity', 1472032380),
('m160719_030254_changeProcessStageStructure', 1472032388),
('m160725_011020_addStageAlias', 1472032388),
('m160725_055251_addTimeSpent', 1472032388),
('m160725_065310_createStages', 1472032392),
('m160725_091200_changeOrderStage', 1472032392),
('m160725_094225_dropOrderHistory', 1472032392),
('m160727_011205_createFirstStage', 1472032393),
('m160727_024948_addOrderCommentManually', 1472032393),
('m160727_073937_addProcessStageTimeUnit', 1472032394),
('m160728_094818_createProcessStageUser', 1472032396),
('m160802_002735_createTags', 1472032398),
('m160802_053233_createUploadBase', 1472032399),
('m160804_035843_changeProductField', 1472032399),
('m160808_014234_change_table_structure', 1472032402),
('m160808_040850_add_order_stage_reason', 1472032404),
('m160808_092827_create_foreign_system', 1472032407),
('m160810_014350_create_source_system', 1472032408),
('m160816_101927_create_warehouse', 1472032413),
('m160817_023840_add_column_current_status', 1472032418),
('m160822_040105_create_access_on_stage', 1472032418),
('m160828_045633_add_order_sending_tracker', 1472357409),
('m160828_070303_create_roles', 1472364281),
('m161213_003429_create_order_company', 1481767007);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `source_id` int(10) UNSIGNED NOT NULL,
  `process_id` int(10) UNSIGNED DEFAULT NULL,
  `current_stage_id` int(10) UNSIGNED DEFAULT NULL,
  `time_postponed` timestamp NULL DEFAULT NULL,
  `price` decimal(14,2) DEFAULT '0.00',
  `currency` tinyint(3) UNSIGNED DEFAULT '1',
  `current_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_user_id` int(10) UNSIGNED DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL,
  `date_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_call_history`
--

CREATE TABLE `order_call_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_comment`
--

CREATE TABLE `order_comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `comment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `manually` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL,
  `price` decimal(12,2) DEFAULT '0.00',
  `currency` tinyint(3) UNSIGNED DEFAULT '1',
  `quantity` tinyint(3) UNSIGNED DEFAULT '1',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_stage`
--

CREATE TABLE `order_stage` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `stage_id` int(10) UNSIGNED NOT NULL,
  `action_id` int(10) UNSIGNED DEFAULT NULL,
  `reason_id` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `overdue` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `time_limit` int(10) UNSIGNED DEFAULT '0',
  `time_spent` int(10) UNSIGNED DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `process`
--

CREATE TABLE `process` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `process`
--

INSERT INTO `process` (`id`, `name`, `status`, `user_id`, `date_create`) VALUES
(1, 'Новый процесс', 1, 1, '2016-12-16 01:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `process_action`
--

CREATE TABLE `process_action` (
  `id` int(10) UNSIGNED NOT NULL,
  `process_id` int(10) UNSIGNED NOT NULL,
  `action` tinyint(3) UNSIGNED NOT NULL,
  `working_time` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `process_source`
--

CREATE TABLE `process_source` (
  `id` int(10) UNSIGNED NOT NULL,
  `process_id` int(10) UNSIGNED NOT NULL,
  `source_id` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `process_source`
--

INSERT INTO `process_source` (`id`, `process_id`, `source_id`, `date_create`) VALUES
(1, 1, 1, '2016-12-16 01:05:39'),
(2, 1, 2, '2016-12-16 01:05:39'),
(3, 1, 5, '2016-12-16 01:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `process_stage`
--

CREATE TABLE `process_stage` (
  `id` int(10) UNSIGNED NOT NULL,
  `process_id` int(10) UNSIGNED NOT NULL,
  `stage_id` int(10) UNSIGNED NOT NULL,
  `time_limit` int(10) UNSIGNED NOT NULL,
  `time_unit` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `type_search_operator` tinyint(1) UNSIGNED DEFAULT '1',
  `user_id` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL,
  `first_stage` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `process_stage`
--

INSERT INTO `process_stage` (`id`, `process_id`, `stage_id`, `time_limit`, `time_unit`, `type_search_operator`, `user_id`, `date_create`, `first_stage`) VALUES
(1, 1, 1, 2, 1, 1, 1, '2016-12-16 01:05:39', 1),
(2, 1, 2, 2, 1, 1, 1, '2016-12-16 01:05:39', 0),
(3, 1, 5, 3, 1, 1, 1, '2016-12-16 01:05:39', 0),
(4, 1, 4, 1, 1, 1, 1, '2016-12-16 01:05:39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `process_stage_action`
--

CREATE TABLE `process_stage_action` (
  `id` int(10) UNSIGNED NOT NULL,
  `process_stage_id` int(10) UNSIGNED NOT NULL,
  `action_id` int(10) UNSIGNED NOT NULL,
  `follow_to_stage_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `process_stage_action`
--

INSERT INTO `process_stage_action` (`id`, `process_stage_id`, `action_id`, `follow_to_stage_id`, `user_id`, `date_create`) VALUES
(1, 1, 2, 5, 1, '2016-12-16 01:05:39'),
(2, 1, 4, 2, 1, '2016-12-16 01:05:39'),
(3, 2, 2, 5, 1, '2016-12-16 01:05:39'),
(4, 2, 4, 4, 1, '2016-12-16 01:05:39'),
(5, 3, 1, 1, 1, '2016-12-16 01:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `process_stage_action_reason`
--

CREATE TABLE `process_stage_action_reason` (
  `id` int(10) UNSIGNED NOT NULL,
  `process_stage_action_id` int(10) UNSIGNED NOT NULL,
  `reason_id` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `process_stage_operator`
--

CREATE TABLE `process_stage_operator` (
  `id` int(10) UNSIGNED NOT NULL,
  `process_id` int(10) UNSIGNED NOT NULL,
  `stage_id` int(10) UNSIGNED NOT NULL,
  `operator_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `article` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `category` tinyint(3) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `article`, `description`, `category`, `status`, `user_id`, `date_create`) VALUES
(1, 'Товар 1', '', '', 1, 1, 1, '2016-12-16 00:19:57');

-- --------------------------------------------------------

--
-- Table structure for table `product_price`
--

CREATE TABLE `product_price` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `currency` tinyint(3) UNSIGNED DEFAULT '1',
  `type` tinyint(1) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_price`
--

INSERT INTO `product_price` (`id`, `product_id`, `price`, `currency`, `type`, `status`, `user_id`, `date_create`) VALUES
(2, 1, '1000.00', 1, 1, 1, 1, '2016-12-16 00:19:57'),
(3, 1, '500.00', 1, 2, 1, 1, '2016-12-16 00:19:57');

-- --------------------------------------------------------

--
-- Table structure for table `product_tag`
--

CREATE TABLE `product_tag` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_tag`
--

INSERT INTO `product_tag` (`id`, `product_id`, `tag_id`, `date_create`) VALUES
(2, 1, 1, '2016-12-16 00:19:57');

-- --------------------------------------------------------

--
-- Table structure for table `reason`
--

CREATE TABLE `reason` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reason`
--

INSERT INTO `reason` (`id`, `name`, `date_create`) VALUES
(1, 'Некорректный номер', '2016-08-31 14:35:58'),
(2, 'Не согласился', '2016-08-31 14:36:05'),
(3, 'Попросил перезвонить', '2016-08-31 14:36:12'),
(4, 'Недоступен', '2016-08-31 14:36:28'),
(5, 'Не взял трубку', '2016-08-31 14:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

CREATE TABLE `source` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `source`
--

INSERT INTO `source` (`id`, `name`, `date_create`) VALUES
(1, 'Основной источник', '2016-09-03 05:27:13'),
(2, 'Базы данных', '2016-09-01 07:38:41'),
(5, 'Квикдекор', '2016-09-09 10:45:45');

-- --------------------------------------------------------

--
-- Table structure for table `source_system`
--

CREATE TABLE `source_system` (
  `id` int(10) UNSIGNED NOT NULL,
  `source_id` int(10) UNSIGNED NOT NULL,
  `system_id` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stage`
--

CREATE TABLE `stage` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL,
  `department` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stage`
--

INSERT INTO `stage` (`id`, `name`, `alias`, `user_id`, `date_create`, `department`) VALUES
(1, 'Новый', 'new', 1, '2016-08-31 14:36:57', 1),
(2, 'Первичный обзвон', 'first_calling', 1, '2016-12-16 01:11:45', 1),
(3, 'Повторный обзвон', 'next_calling', 1, '2016-09-04 06:26:05', 1),
(4, 'Одобрен', 'accepted', 1, '2016-08-31 15:07:18', 2),
(5, 'Отклонен', 'rejected', 1, '2016-08-31 14:37:58', 1),
(6, 'Выкуплен', 'purchased', 1, '2016-08-31 14:38:10', 1),
(7, 'Не выкуплен', 'not_purchased', 1, '2016-08-31 14:38:26', 1),
(8, 'Товар поставлен', 'product_supplied', 1, '2016-09-04 06:47:32', 2),
(10, 'Заказ обработан', 'order_completed', 1, '2016-09-04 06:43:37', 2),
(11, 'Отклонен со склада', 'order_rejected_from_warehouse', 1, '2016-08-31 14:42:09', 2),
(12, 'Заказ отправлен', 'order_sent', 1, '2016-08-31 15:13:29', 1),
(13, 'Допечатная подг.', 'preprint', 1, '2016-09-06 09:50:58', 1),
(14, 'Производство', 'manufact', 1, '2016-09-09 11:10:57', 2),
(15, 'Упаковка', 'packing', 1, '2016-09-09 11:12:32', 2);

-- --------------------------------------------------------

--
-- Table structure for table `stage_method`
--

CREATE TABLE `stage_method` (
  `id` int(10) UNSIGNED NOT NULL,
  `stage_id` int(10) UNSIGNED NOT NULL,
  `method` tinyint(3) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stage_method`
--

INSERT INTO `stage_method` (`id`, `stage_id`, `method`, `date_create`) VALUES
(1, 2, 1, '2016-12-16 01:11:45');

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE `system` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_product`
--

CREATE TABLE `system_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `system_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `foreign_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_stage`
--

CREATE TABLE `system_stage` (
  `id` int(10) UNSIGNED NOT NULL,
  `system_id` int(10) UNSIGNED NOT NULL,
  `stage_id` int(10) UNSIGNED NOT NULL,
  `foreign_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_url`
--

CREATE TABLE `system_url` (
  `id` int(10) UNSIGNED NOT NULL,
  `system_id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(3) UNSIGNED NOT NULL,
  `url` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `label_class` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `name`, `label_class`, `user_id`, `date_create`) VALUES
(1, '1212112', 'label-primary', 1, '2016-12-14 01:32:06');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `fio` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` char(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_token` char(44) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `fio`, `role`, `password_hash`, `password_reset_token`, `auth_key`, `status`, `date_create`) VALUES
(1, 'admin@admin.ru', 'Администратор', 'ADMIN', '$2y$13$iPxyaR2TmZ7keTFqgX5o9.YmYvcDi2WohjCrCT96V0v9ShUNGnc3i', NULL, 'StJnQ9XlyOqSTxelvLD-6kWaSBX9JRDs', 1, '2016-08-24 10:52:45'),
(2, 'ksenia@thor-cpa.com', 'Ксения', 'OPERATOR', '$2y$13$7GzapwSAtB1y9Nl.3lmlVObRJ1LchaysYQ18DQ08hZK6uox2VjGGa', NULL, 'hVWw3m7_AfJbbHLB4lwuV0JyaGqNKktp', 0, '2016-11-06 17:17:28'),
(3, 'warehouse@warehouse.ru', 'Виктор Анатольевич Писаренко', 'WAREHOUSE_MANAGER', '$2y$13$LXa4fcWpurj/heObJWch5.iaff1m2s8ynsdB48p5bvjwfU4YGkMNG', NULL, 'eyAf5-ss0KNvUAGTkOG8Llkwz9p09Wum', 0, '2016-09-01 07:12:22'),
(4, 'oksana@thor-cpa.com', 'Оксана Дружинина', 'ADMIN', '$2y$13$/8as0NN34e4PCG0.U5bGUedhdKm6sdbFMc9I2b5kwPKU/rSIE3ZiS', NULL, 'Jc44hk6RSevadevzPnH0G17dfzxxqf6N', 0, '2016-09-01 09:13:21'),
(5, 'print@print.ru', 'Печатник', 'OPERATOR', '$2y$13$KKBwSfPEp1kEdatywo8otuSX23ApmHVSfUJHjD78fu6Z.KLBFHYZS', NULL, '5TOVK-muAklpZNBMFLtq--jlAycdLFHr', 0, '2016-09-09 10:59:31'),
(6, 'operator@pano.ru', 'Пано Оператор', 'OPERATOR', '$2y$13$L.3PzsqyE3bNjj.s0foK/.HFoBjRx6/KVZOTllY0VEW1ZqjFdnWVC', NULL, 'QDAQtr-RwFJJZxnn0gLk2dTxlo3vO82M', 0, '2016-09-09 10:59:49'),
(7, 'operator@man.ru', 'Оператор производства', 'WAREHOUSE_MANAGER', '$2y$13$43g58ZxG2S6alSnDNowkhu5Mtsz4ab9ws4DjInE7MjW8dNtYo9C0e', NULL, '1fhuS3WWv-EUpAeo5zY5_uOvU2WDVFqH', 0, '2016-09-09 11:00:23'),
(8, 'detzel@rvokzal.ru', 'Детцель Юрий', 'ADMIN', '$2y$13$jcqnGLxuaPgzLFM5iWqq5.ym8AO9IMFkc0Q9K9cgASOqoRs6DCoqu', NULL, 'MI7ceChX1kdxU0J_LsyeOI-8m6I8jL66', 0, '2016-09-08 05:31:58'),
(9, '102@operator.ru', 'Оператор кол-центра', 'OPERATOR', '$2y$13$i1QRbA7cpQa0v1tv.z/hY.AcS.i4A1Hx0O18rxLpzz4uis6AqUdSm', NULL, 'S-nOtPCUshKyg80LxEWqte_soS0puo9a', 0, '2016-09-27 09:09:23'),
(10, 'marina_t@rvokzal.ru', 'Табарыкина Марина', 'OPERATOR', '$2y$13$7Z02cxiqHHy9.JszalVfluXbC83oWe83PuTBTcsji8LmxI/11IfLW', NULL, '7WinMZ-rKTY_FKx6Ag6Bn1EJhKcf-VD9', 0, '2016-10-13 09:59:43'),
(11, 'ivanitsk@mail.ru', 'Валерий Людвигович Иваницкий', 'ADMIN', '$2y$13$GPk5JDA5apSfKmBKBdj1Du31DKSTnrh.1gZMRcL6VNGGNyI3XfnrO', NULL, 'bVIYHLpNhBd1n0FU-jL9vIQswZZrHtU9', 0, '2016-10-14 16:59:06'),
(12, 'sangar@rvokzal.ru', 'Дижевский Олег Сергеевич', 'ADMIN', '$2y$13$epr1107LBmB//0Nq/iXSkeVk0FJgmrRjEB2mr6f8NP2MWl3CX./ri', NULL, 'rAteQX1wi8e0gX-nryoe1drMI1gCuQeD', 0, '2016-10-31 06:05:45'),
(13, 'nikita@thor-cpa.com', 'Завадский Никита Владимирович', 'ADMIN', '$2y$13$kUimzFPGfmMg/Bg5JMYBVOFKVpDeskctu/vbMxZ2h4cv/VEkwmSy2', NULL, 'nWe-YnpmJpa-5LTn2B42fJ-OdzwJfoqA', 0, '2016-11-14 09:48:02'),
(14, 'zavadskiy.n@sttk.tv', 'Завадский Никита Владимирович', 'OPERATOR', '$2y$13$3uLBUTYx6PMuAW3dGdpNxOtP3LYHknygZUIfJ4CjSd6K/PiXGo83O', NULL, 'giJr_Q1IW0tmWVwAq-AedXTovVvQ2CE3', 0, '2016-12-15 00:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_history`
--

CREATE TABLE `user_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `action` int(10) UNSIGNED NOT NULL,
  `comment` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tag`
--

CREATE TABLE `user_tag` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_tag`
--

INSERT INTO `user_tag` (`id`, `user_id`, `tag_id`, `date_create`) VALUES
(1, 14, 1, '2016-12-15 00:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `wh_order_transaction`
--

CREATE TABLE `wh_order_transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wh_product_component`
--

CREATE TABLE `wh_product_component` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wh_product_component_stock`
--

CREATE TABLE `wh_product_component_stock` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_component_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED DEFAULT '0',
  `date_create` timestamp NULL DEFAULT NULL,
  `date_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wh_product_tech_list`
--

CREATE TABLE `wh_product_tech_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `tech_list_id` int(10) UNSIGNED NOT NULL,
  `priority` tinyint(3) UNSIGNED DEFAULT '1',
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wh_tech_list`
--

CREATE TABLE `wh_tech_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wh_tech_list_product_component`
--

CREATE TABLE `wh_tech_list_product_component` (
  `id` int(10) UNSIGNED NOT NULL,
  `tech_list_id` int(10) UNSIGNED NOT NULL,
  `product_component_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wh_transaction`
--

CREATE TABLE `wh_transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL,
  `name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wh_transaction_product_component`
--

CREATE TABLE `wh_transaction_product_component` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `product_component_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `fk_auth_assignment_user_id` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_user_id` (`user_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_user_id` (`user_id`);

--
-- Indexes for table `company_contact`
--
ALTER TABLE `company_contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_contact_company_id` (`company_id`),
  ADD KEY `fk_company_contact_user_id` (`user_id`);

--
-- Indexes for table `geo_address`
--
ALTER TABLE `geo_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_geo_address_area_id` (`area_id`),
  ADD KEY `fk_geo_address_city_id` (`city`);

--
-- Indexes for table `geo_area`
--
ALTER TABLE `geo_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_geo_area_region_id` (`region_id`);

--
-- Indexes for table `geo_region`
--
ALTER TABLE `geo_region`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_process_id` (`process_id`),
  ADD KEY `fk_order_current_user_id` (`current_user_id`),
  ADD KEY `fk_order_created_user_id` (`created_user_id`),
  ADD KEY `fk_order_source_id` (`source_id`),
  ADD KEY `fk_order_current_stage_id` (`current_stage_id`);

--
-- Indexes for table `order_call_history`
--
ALTER TABLE `order_call_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_call_history_order_id` (`order_id`),
  ADD KEY `fk_order_call_history_user_id` (`user_id`);

--
-- Indexes for table `order_comment`
--
ALTER TABLE `order_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_comment_order_id` (`order_id`),
  ADD KEY `fk_order_comment_comment_id` (`comment_id`),
  ADD KEY `fk_order_comment_user_id` (`user_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_product_order_id` (`order_id`),
  ADD KEY `fk_order_product_product_id` (`product_id`),
  ADD KEY `fk_order_product_user_id` (`user_id`);

--
-- Indexes for table `order_stage`
--
ALTER TABLE `order_stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_stage_action_id` (`action_id`),
  ADD KEY `fk_order_stage_reason_id` (`reason_id`),
  ADD KEY `fk_order_stage_stage_id` (`stage_id`),
  ADD KEY `index_order_status` (`order_id`,`status`);

--
-- Indexes for table `process`
--
ALTER TABLE `process`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_process_user_id` (`user_id`);

--
-- Indexes for table `process_action`
--
ALTER TABLE `process_action`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_process_action_user_id` (`user_id`),
  ADD KEY `fk_process_action_process_id` (`process_id`);

--
-- Indexes for table `process_source`
--
ALTER TABLE `process_source`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_process_source_process_id` (`process_id`),
  ADD KEY `fk_process_source_source_id` (`source_id`);

--
-- Indexes for table `process_stage`
--
ALTER TABLE `process_stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_process_stage_process_id` (`process_id`),
  ADD KEY `fk_process_stage_stage_id` (`stage_id`);

--
-- Indexes for table `process_stage_action`
--
ALTER TABLE `process_stage_action`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_process_stage_action_process_stage_id` (`process_stage_id`),
  ADD KEY `fk_process_stage_action_follow_to_stage_id` (`follow_to_stage_id`),
  ADD KEY `fk_process_stage_action_action_id` (`action_id`);

--
-- Indexes for table `process_stage_action_reason`
--
ALTER TABLE `process_stage_action_reason`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_process_stage_action_reason_process_stage_action_id` (`process_stage_action_id`),
  ADD KEY `fk_process_stage_action_reason_reason_id` (`reason_id`);

--
-- Indexes for table `process_stage_operator`
--
ALTER TABLE `process_stage_operator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_process_stage_operator_process_id` (`process_id`),
  ADD KEY `fk_process_stage_operator_stage_id` (`stage_id`),
  ADD KEY `fk_process_stage_operator_operator_id` (`operator_id`),
  ADD KEY `fk_process_stage_operator_user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_user_id` (`user_id`);

--
-- Indexes for table `product_price`
--
ALTER TABLE `product_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_price_product_id` (`product_id`),
  ADD KEY `fk_product_price_user_id` (`user_id`);

--
-- Indexes for table `product_tag`
--
ALTER TABLE `product_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_tag_product_id` (`product_id`),
  ADD KEY `fk_product_tag_tag_id` (`tag_id`);

--
-- Indexes for table `reason`
--
ALTER TABLE `reason`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `source`
--
ALTER TABLE `source`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `source_system`
--
ALTER TABLE `source_system`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_source_system_source_id` (`source_id`),
  ADD KEY `fk_source_system_system_id` (`system_id`);

--
-- Indexes for table `stage`
--
ALTER TABLE `stage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stage_method`
--
ALTER TABLE `stage_method`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stage_method_stage_id` (`stage_id`);

--
-- Indexes for table `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_product`
--
ALTER TABLE `system_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_system_product_system_id` (`system_id`),
  ADD KEY `fk_system_product_product_id` (`product_id`);

--
-- Indexes for table `system_stage`
--
ALTER TABLE `system_stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_system_stage_system_id` (`system_id`),
  ADD KEY `fk_system_stage_stage_id` (`stage_id`);

--
-- Indexes for table `system_url`
--
ALTER TABLE `system_url`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_system_url_system_id` (`system_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_history`
--
ALTER TABLE `user_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_history_user_id` (`user_id`);

--
-- Indexes for table `user_tag`
--
ALTER TABLE `user_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_tag_user_id` (`user_id`),
  ADD KEY `fk_user_tag_tag_id` (`tag_id`);

--
-- Indexes for table `wh_order_transaction`
--
ALTER TABLE `wh_order_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_transaction_order_id` (`order_id`),
  ADD KEY `fk_order_transaction_transaction_id` (`transaction_id`);

--
-- Indexes for table `wh_product_component`
--
ALTER TABLE `wh_product_component`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wh_product_component_stock`
--
ALTER TABLE `wh_product_component_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_component_stock_product_component_id` (`product_component_id`);

--
-- Indexes for table `wh_product_tech_list`
--
ALTER TABLE `wh_product_tech_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_tech_list_product_id` (`product_id`),
  ADD KEY `fk_product_tech_list_tech_list_id` (`tech_list_id`);

--
-- Indexes for table `wh_tech_list`
--
ALTER TABLE `wh_tech_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wh_tech_list_product_component`
--
ALTER TABLE `wh_tech_list_product_component`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tech_list_product_component_tech_list_id` (`tech_list_id`),
  ADD KEY `fk_tech_list_product_component_product_component_id` (`product_component_id`);

--
-- Indexes for table `wh_transaction`
--
ALTER TABLE `wh_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wh_transaction_product_component`
--
ALTER TABLE `wh_transaction_product_component`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transaction_product_component_transaction_id` (`transaction_id`),
  ADD KEY `fk_transaction_product_component_product_component_id` (`product_component_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action`
--
ALTER TABLE `action`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `company_contact`
--
ALTER TABLE `company_contact`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `geo_address`
--
ALTER TABLE `geo_address`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `geo_area`
--
ALTER TABLE `geo_area`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `geo_region`
--
ALTER TABLE `geo_region`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_call_history`
--
ALTER TABLE `order_call_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_comment`
--
ALTER TABLE `order_comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order_stage`
--
ALTER TABLE `order_stage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `process`
--
ALTER TABLE `process`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `process_action`
--
ALTER TABLE `process_action`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `process_source`
--
ALTER TABLE `process_source`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `process_stage`
--
ALTER TABLE `process_stage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `process_stage_action`
--
ALTER TABLE `process_stage_action`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `process_stage_action_reason`
--
ALTER TABLE `process_stage_action_reason`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `process_stage_operator`
--
ALTER TABLE `process_stage_operator`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `product_tag`
--
ALTER TABLE `product_tag`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `reason`
--
ALTER TABLE `reason`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `source`
--
ALTER TABLE `source`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `source_system`
--
ALTER TABLE `source_system`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stage`
--
ALTER TABLE `stage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `stage_method`
--
ALTER TABLE `stage_method`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `system`
--
ALTER TABLE `system`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `system_product`
--
ALTER TABLE `system_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `system_stage`
--
ALTER TABLE `system_stage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `system_url`
--
ALTER TABLE `system_url`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `user_history`
--
ALTER TABLE `user_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_tag`
--
ALTER TABLE `user_tag`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `wh_order_transaction`
--
ALTER TABLE `wh_order_transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wh_product_component`
--
ALTER TABLE `wh_product_component`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wh_product_component_stock`
--
ALTER TABLE `wh_product_component_stock`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wh_product_tech_list`
--
ALTER TABLE `wh_product_tech_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wh_tech_list`
--
ALTER TABLE `wh_tech_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wh_tech_list_product_component`
--
ALTER TABLE `wh_tech_list_product_component`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wh_transaction`
--
ALTER TABLE `wh_transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wh_transaction_product_component`
--
ALTER TABLE `wh_transaction_product_component`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_auth_assignment_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `fk_company_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `company_contact`
--
ALTER TABLE `company_contact`
  ADD CONSTRAINT `fk_company_contact_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_company_contact_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `geo_address`
--
ALTER TABLE `geo_address`
  ADD CONSTRAINT `fk_geo_address_area_id` FOREIGN KEY (`area_id`) REFERENCES `geo_area` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `geo_area`
--
ALTER TABLE `geo_area`
  ADD CONSTRAINT `fk_geo_area_region_id` FOREIGN KEY (`region_id`) REFERENCES `geo_region` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_created_user_id` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_current_stage_id` FOREIGN KEY (`current_stage_id`) REFERENCES `stage` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_current_user_id` FOREIGN KEY (`current_user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_process_id` FOREIGN KEY (`process_id`) REFERENCES `process` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_source_id` FOREIGN KEY (`source_id`) REFERENCES `source` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_call_history`
--
ALTER TABLE `order_call_history`
  ADD CONSTRAINT `fk_order_call_history_order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_call_history_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_comment`
--
ALTER TABLE `order_comment`
  ADD CONSTRAINT `fk_order_comment_comment_id` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_comment_order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `fk_order_product_order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_product_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_product_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_stage`
--
ALTER TABLE `order_stage`
  ADD CONSTRAINT `fk_order_stage_action_id` FOREIGN KEY (`action_id`) REFERENCES `action` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_stage_order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_stage_reason_id` FOREIGN KEY (`reason_id`) REFERENCES `reason` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_stage_stage_id` FOREIGN KEY (`stage_id`) REFERENCES `stage` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `process`
--
ALTER TABLE `process`
  ADD CONSTRAINT `fk_process_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `process_action`
--
ALTER TABLE `process_action`
  ADD CONSTRAINT `fk_process_action_process_id` FOREIGN KEY (`process_id`) REFERENCES `process` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_process_action_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `process_source`
--
ALTER TABLE `process_source`
  ADD CONSTRAINT `fk_process_source_process_id` FOREIGN KEY (`process_id`) REFERENCES `process` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_process_source_source_id` FOREIGN KEY (`source_id`) REFERENCES `source` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `process_stage`
--
ALTER TABLE `process_stage`
  ADD CONSTRAINT `fk_process_stage_process_id` FOREIGN KEY (`process_id`) REFERENCES `process` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_process_stage_stage_id` FOREIGN KEY (`stage_id`) REFERENCES `stage` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `process_stage_action`
--
ALTER TABLE `process_stage_action`
  ADD CONSTRAINT `fk_process_stage_action_action_id` FOREIGN KEY (`action_id`) REFERENCES `action` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_process_stage_action_follow_to_stage_id` FOREIGN KEY (`follow_to_stage_id`) REFERENCES `stage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_process_stage_action_process_stage_id` FOREIGN KEY (`process_stage_id`) REFERENCES `process_stage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `process_stage_action_reason`
--
ALTER TABLE `process_stage_action_reason`
  ADD CONSTRAINT `fk_process_stage_action_reason_process_stage_action_id` FOREIGN KEY (`process_stage_action_id`) REFERENCES `process_stage_action` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_process_stage_action_reason_reason_id` FOREIGN KEY (`reason_id`) REFERENCES `reason` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `process_stage_operator`
--
ALTER TABLE `process_stage_operator`
  ADD CONSTRAINT `fk_process_stage_operator_operator_id` FOREIGN KEY (`operator_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_process_stage_operator_process_id` FOREIGN KEY (`process_id`) REFERENCES `process` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_process_stage_operator_stage_id` FOREIGN KEY (`stage_id`) REFERENCES `stage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_process_stage_operator_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product_price`
--
ALTER TABLE `product_price`
  ADD CONSTRAINT `fk_product_price_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_price_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product_tag`
--
ALTER TABLE `product_tag`
  ADD CONSTRAINT `fk_product_tag_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_tag_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `source_system`
--
ALTER TABLE `source_system`
  ADD CONSTRAINT `fk_source_system_source_id` FOREIGN KEY (`source_id`) REFERENCES `source` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_source_system_system_id` FOREIGN KEY (`system_id`) REFERENCES `system` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stage_method`
--
ALTER TABLE `stage_method`
  ADD CONSTRAINT `fk_stage_method_stage_id` FOREIGN KEY (`stage_id`) REFERENCES `stage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `system_product`
--
ALTER TABLE `system_product`
  ADD CONSTRAINT `fk_system_product_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_system_product_system_id` FOREIGN KEY (`system_id`) REFERENCES `system` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `system_stage`
--
ALTER TABLE `system_stage`
  ADD CONSTRAINT `fk_system_stage_stage_id` FOREIGN KEY (`stage_id`) REFERENCES `stage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_system_stage_system_id` FOREIGN KEY (`system_id`) REFERENCES `system` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `system_url`
--
ALTER TABLE `system_url`
  ADD CONSTRAINT `fk_system_url_system_id` FOREIGN KEY (`system_id`) REFERENCES `system` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_history`
--
ALTER TABLE `user_history`
  ADD CONSTRAINT `fk_user_history_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_tag`
--
ALTER TABLE `user_tag`
  ADD CONSTRAINT `fk_user_tag_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_tag_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wh_order_transaction`
--
ALTER TABLE `wh_order_transaction`
  ADD CONSTRAINT `fk_order_transaction_order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_transaction_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `wh_transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wh_product_component_stock`
--
ALTER TABLE `wh_product_component_stock`
  ADD CONSTRAINT `fk_product_component_stock_product_component_id` FOREIGN KEY (`product_component_id`) REFERENCES `wh_product_component` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wh_product_tech_list`
--
ALTER TABLE `wh_product_tech_list`
  ADD CONSTRAINT `fk_product_tech_list_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_tech_list_tech_list_id` FOREIGN KEY (`tech_list_id`) REFERENCES `wh_tech_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wh_tech_list_product_component`
--
ALTER TABLE `wh_tech_list_product_component`
  ADD CONSTRAINT `fk_tech_list_product_component_product_component_id` FOREIGN KEY (`product_component_id`) REFERENCES `wh_product_component` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tech_list_product_component_tech_list_id` FOREIGN KEY (`tech_list_id`) REFERENCES `wh_tech_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wh_transaction_product_component`
--
ALTER TABLE `wh_transaction_product_component`
  ADD CONSTRAINT `fk_transaction_product_component_product_component_id` FOREIGN KEY (`product_component_id`) REFERENCES `wh_product_component` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaction_product_component_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `wh_transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
