-- ValueMap MySQL export - corrected for InfinityFree/phpMyAdmin
-- Rebuilt from the supplied SQLite-to-MySQL export.
-- This script drops and recreates the ValueMap tables, then restores the supplied data.

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET NAMES utf8mb4;

DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `content_items`;
DROP TABLE IF EXISTS `contact_messages`;
DROP TABLE IF EXISTS `newsletter_subscribers`;
DROP TABLE IF EXISTS `partners`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `migrations`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` DATETIME NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
  `role` VARCHAR(255) NOT NULL DEFAULT 'reader',
  `requested_role` VARCHAR(255) NULL,
  `is_approved` TINYINT(1) NOT NULL DEFAULT 0,
  `approved_at` DATETIME NULL,
  `approved_by` BIGINT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  KEY `users_approved_by_index` (`approved_by`),
  CONSTRAINT `users_approved_by_foreign`
    FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` LONGTEXT NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `contact_messages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `organisation` VARCHAR(255) NULL,
  `subject` VARCHAR(255) NOT NULL,
  `message` LONGTEXT NOT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `consent_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `content_items` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `reference_code` VARCHAR(255) NULL,
  `excerpt` LONGTEXT NULL,
  `body` LONGTEXT NULL,
  `partner` VARCHAR(255) NULL,
  `published_at` DATE NULL,
  `event_date` DATETIME NULL,
  `status` VARCHAR(255) NOT NULL DEFAULT 'published',
  `category` VARCHAR(255) NULL,
  `file_path` VARCHAR(255) NULL,
  `external_url` VARCHAR(2048) NULL,
  `image_path` VARCHAR(255) NULL,
  `is_public` TINYINT(1) NOT NULL DEFAULT 0,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `location` VARCHAR(255) NULL,
  `target_audience` VARCHAR(255) NULL,
  `registration_url` VARCHAR(2048) NULL,
  `agenda_url` VARCHAR(2048) NULL,
  `related_resources` LONGTEXT NULL,
  `approval_status` VARCHAR(255) NOT NULL DEFAULT 'draft',
  `approved_by` BIGINT UNSIGNED NULL,
  `approved_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  KEY `content_items_approved_by_index` (`approved_by`),
  CONSTRAINT `content_items_approved_by_foreign`
    FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` LONGTEXT NOT NULL,
  `queue` LONGTEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` INT NOT NULL,
  `pending_jobs` INT NOT NULL,
  `failed_jobs` INT NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` LONGTEXT NULL,
  `cancelled_at` INT NULL,
  `created_at` INT NOT NULL,
  `finished_at` INT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` INT NOT NULL,
  `reserved_at` INT NULL,
  `available_at` INT NOT NULL,
  `created_at` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `newsletter_subscribers` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `consent_at` DATETIME NOT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `confirmed_at` DATETIME NULL,
  `unsubscribed_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `partners` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `initials` VARCHAR(255) NOT NULL,
  `country` VARCHAR(255) NOT NULL,
  `country_code` VARCHAR(255) NOT NULL,
  `location` VARCHAR(255) NULL,
  `latitude` DECIMAL(10,7) NOT NULL,
  `longitude` DECIMAL(10,7) NOT NULL,
  `map_offset_x` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `map_offset_y` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `role` VARCHAR(255) NULL,
  `description` LONGTEXT NULL,
  `website_url` VARCHAR(2048) NULL,
  `logo_path` VARCHAR(255) NULL,
  `contacts` LONGTEXT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` LONGTEXT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`,`is_admin`,`role`,`requested_role`,`is_approved`,`approved_at`,`approved_by`) VALUES (1,'ValueMap main administrator','jesenko9@hotmail.com',NULL,'$2y$12$QQG/EcK39NxmfTnRHi4t.e6vVrErljBPLVHs0LIFHwX0gCmrhAm0S',NULL,'2026-09-19 06:43:03','2026-09-19 06:43:03',1,'main_admin','main_admin',1,'2026-09-19 06:43:03',NULL),(2,'ValueMap main administrator','jesenko@hotmail.com',NULL,'$2y$12$CFH6yhakYi/ggd4oDdDtn.Rj9PJ0rl1nvjzAmlwNWAkem/pefpnSu',NULL,'2026-09-19 06:44:05','2026-09-20 12:33:25',1,'main_admin','main_admin',1,'2026-09-20 12:33:25',NULL);

INSERT INTO `cache` (`key`,`value`,`expiration`) VALUES ('valuemap-cache-admin-login:jesenko9@hotmail.com|127.0.0.1:timer','i:1789907606;

INSERT INTO `content_items` (`id`,`type`,`title`,`slug`,`reference_code`,`excerpt`,`body`,`partner`,`published_at`,`event_date`,`status`,`category`,`file_path`,`external_url`,`image_path`,`is_public`,`sort_order`,`created_at`,`updated_at`,`location`,`target_audience`,`registration_url`,`agenda_url`,`related_resources`,`approval_status`,`approved_by`,`approved_at`) VALUES (1,'news','ValueMap begins its work across Europe','valuemap-begins-its-work-across-europe',NULL,'Nine partners from six countries are starting a shared effort to map how European health data ecosystems create value.','The ValueMap consortium has officially begun its work. The project brings together nine partners from six European countries to examine the actors, resources, relationships and conditions that shape health data ecosystems.\r
\r
This initial update is draft website content and will be replaced with the consortium-approved announcement and partner quotations.',NULL,'2026-09-08 00:00:00',NULL,'published','Project update',NULL,NULL,NULL,1,0,'2026-09-09 00:40:25','2026-09-20 12:34:03',NULL,NULL,NULL,NULL,NULL,'approved',NULL,NULL),(2,'event','ValueMap consortium meeting in Budapest','valuemap-consortium-meeting-budapest',NULL,'The consortium will meet in Budapest in early October to align the research programme and review the advanced website version.','The ValueMap partners will convene in Budapest in early October. The meeting will align the next implementation steps and provide a shared space to review the project\'s public communication platform.

The exact date, venue and public participation details are pending confirmation.',NULL,'2026-09-08 00:00:00','2026-10-01 09:00:00','forthcoming','Consortium meeting',NULL,NULL,NULL,1,0,'2026-09-09 00:40:25','2026-09-09 00:40:25',NULL,NULL,NULL,NULL,NULL,'approved',NULL,NULL),(3,'deliverable','ValueMap public results library','valuemap-public-results-library','Coming soon','Public deliverables and supporting project outputs will be released here as the project progresses.','This record demonstrates how a public deliverable will appear. Each item can include a reference number, responsible partner, publication date, status, full description and downloadable document.

The first consortium-approved public materials are expected from late October.',NULL,'2026-09-08 00:00:00',NULL,'forthcoming',NULL,NULL,NULL,NULL,1,0,'2026-09-09 00:40:25','2026-09-09 00:40:25',NULL,NULL,NULL,NULL,NULL,'approved',NULL,NULL),(4,'newsletter','The ValueMap newsletter archive is ready','valuemap-newsletter-archive',NULL,'Every edition of the ValueMap newsletter will be available to read and download from this communication hub.','Newsletter editions will be published here with a short summary, publication date and downloadable PDF. This draft item marks the future archive location.',NULL,'2026-09-08 00:00:00',NULL,'forthcoming','Newsletter',NULL,NULL,NULL,1,0,'2026-09-09 00:40:25','2026-09-09 00:40:25',NULL,NULL,NULL,NULL,NULL,'approved',NULL,NULL),(5,'news','Test Admin','test-admin',NULL,'Test Admin','lorem ipsum','Partner','2025-02-01 00:00:00','2028-06-25 12:00:00','completed','Project update',NULL,NULL,NULL,1,0,'2026-09-20 12:35:29','2026-09-20 12:38:19',NULL,NULL,NULL,NULL,NULL,'approved',NULL,NULL);

INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_09_09_000001_create_content_items_table',2),(5,'2026_09_09_000002_create_contact_messages_table',2),(6,'2026_09_09_000003_add_is_admin_to_users_table',2),(7,'2026_09_19_000001_add_roles_and_approval_to_users_table',3),(8,'2026_09_27_000001_add_consent_to_contact_messages_table',4),(9,'2026_09_27_000002_add_event_details_to_content_items_table',4),(10,'2026_09_27_000003_create_newsletter_subscribers_table',5),(11,'2026_09_28_000001_create_partners_table',6),(12,'2026_09_28_000002_add_content_approval',7),(13,'2026_09_28_000003_add_newsletter_confirmation',8);

INSERT INTO `partners` (`id`,`name`,`initials`,`country`,`country_code`,`location`,`latitude`,`longitude`,`map_offset_x`,`map_offset_y`,`role`,`description`,`website_url`,`logo_path`,`contacts`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (1,'InnoStars','IS','Hungary','HUN','Hungary','47.4979','19.0402',0,0,'Project Coordinator and WP1 Lead','Coordinates the project and supports collaboration between European health innovation ecosystems, stakeholders and institutions.','https://innostars.org/',NULL,'[]',1,1,'2026-09-27 22:15:41','2026-09-27 22:15:41'),(2,'Institut Català de la Salut','ICS','Spain','ESP','Barcelona','41.3874','2.1686',0,0,'Beneficiary and WP4 Lead','Contributes healthcare-system expertise and leads the development of joint actions, recommendations and implementation tools.','https://ics.gencat.cat/ca/lics/',NULL,'[]',2,1,'2026-09-27 22:15:41','2026-09-27 22:15:41'),(3,'CoLAB TRIALS','CT','Portugal','PRT','Portugal','39.5',-8,0,0,'Beneficiary and WP2 Lead','Leads the European landscape analysis and contributes expertise in research, innovation and health data-related approaches.','https://colabtrials.pt/',NULL,'[]',3,1,'2026-09-27 22:15:41','2026-09-27 22:15:41'),(4,'Karolinska Institutet','KI','Sweden','SWE','Stockholm','59.3293','18.0686',0,0,'Beneficiary','Contributes expertise in research, digital health and health data-related regulatory and innovation contexts.','https://ki.se/en',NULL,'[]',4,1,'2026-09-27 22:15:41','2026-09-27 22:15:41'),(5,'Fundación Pública Andaluza Progreso y Salud','FPS','Spain','ESP','Seville','37.3891','-5.9845',0,0,'Beneficiary','Contributes expertise in public health research and innovation and supports advisory and joint planning activities.','https://juntadeandalucia.es/organismos/fps.html',NULL,'[]',5,1,'2026-09-27 22:15:41','2026-09-27 22:15:41'),(6,'Verlab Institute','VI','Bosnia and Herzegovina','BIH','Sarajevo','43.8563','18.4131',0,0,'Beneficiary and WP5 Lead','Leads communication, dissemination and exploitation and contributes digital health and biomedical engineering expertise.','https://verlabinstitute.com/',NULL,'[]',6,1,'2026-09-27 22:15:41','2026-09-27 22:15:41'),(7,'Consejería de Sanidad de la Comunidad de Madrid','CM','Spain','ESP','Madrid','40.4168','-3.7038',0,0,'Beneficiary and WP3 Lead','Leads regional assessment activities and contributes public-sector and healthcare-system perspectives.','https://www.comunidad.madrid/centros/consejeria-sanidad',NULL,'[]',7,1,'2026-09-27 22:15:41','2026-09-27 22:15:41'),(8,'Fundación para la Investigación e Innovación Biosanitaria de Atención Primaria','FI','Spain','ESP','Madrid','40.4168','-3.7038',38,-14,'Affiliated Partner','Contributes expertise in primary healthcare, research and innovation and supports stakeholder engagement.','https://fiibap.es/',NULL,'[]',8,1,'2026-09-27 22:15:41','2026-09-27 22:15:41'),(9,'Takeda Products Ireland Ltd.','TK','Ireland','IRL','Citywest, Dublin','53.286','-6.426',0,0,'Associated Partner','Contributes an industry and pharmaceutical perspective on health data, innovation and sustainable business models.','https://www.takeda.com/',NULL,'[]',9,1,'2026-09-27 22:15:41','2026-09-27 22:15:41');

INSERT INTO `sessions` (`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) VALUES ('syf4FCeA3uGQaTv7cUWgDND0ZdbFfD9OpWLN6PpM',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0;

SET FOREIGN_KEY_CHECKS=1;
