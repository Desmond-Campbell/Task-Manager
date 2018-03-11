# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.53-0ubuntu0.14.04.1)
# Database: task
# Generation Time: 2018-03-11 21:21:55 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table activities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `activities`;

CREATE TABLE `activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(10) unsigned NOT NULL,
  `object_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_data` text COLLATE utf8mb4_unicode_ci,
  `new_data` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_user_id_foreign` (`user_id`),
  CONSTRAINT `activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_project_id_foreign` (`project_id`),
  KEY `categories_user_id_foreign` (`user_id`),
  CONSTRAINT `categories_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table customers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_project_id_foreign` (`project_id`),
  KEY `customers_user_id_foreign` (`user_id`),
  CONSTRAINT `customers_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table features
# ------------------------------------------------------------

DROP TABLE IF EXISTS `features`;

CREATE TABLE `features` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `features_project_id_foreign` (`project_id`),
  KEY `features_user_id_foreign` (`user_id`),
  CONSTRAINT `features_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `features_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table members
# ------------------------------------------------------------

DROP TABLE IF EXISTS `members`;

CREATE TABLE `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_user_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `members_project_id_foreign` (`project_id`),
  KEY `members_member_user_id_foreign` (`member_user_id`),
  KEY `members_user_id_foreign` (`user_id`),
  CONSTRAINT `members_member_user_id_foreign` FOREIGN KEY (`member_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `members_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2018_03_10_132107_create_tables',1),
	(4,'2018_03_11_173849_search_index_table',2);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_user_id_foreign` (`user_id`),
  CONSTRAINT `projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;

INSERT INTO `projects` (`id`, `name`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,'LoanCirrus',1,'2018-03-10 12:52:02','2018-03-10 12:52:02');

/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table search_index
# ------------------------------------------------------------

DROP TABLE IF EXISTS `search_index`;

CREATE TABLE `search_index` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `indexed` tinyint(1) DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `search` (`keywords`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `search_index` WRITE;
/*!40000 ALTER TABLE `search_index` DISABLE KEYS */;

INSERT INTO `search_index` (`id`, `project_id`, `task_id`, `data`, `keywords`, `indexed`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,1,7,'a:9:{s:5:\"title\";s:16:\"Bayshore reports\";s:11:\"description\";N;s:10:\"categories\";s:7:\"support\";s:9:\"customers\";s:8:\"Bayshore\";s:8:\"features\";N;s:9:\"assignees\";N;s:5:\"notes\";N;s:10:\"task_items\";s:0:\"\";s:9:\"followups\";s:0:\"\";}','Bayshore reports support Bayshore',0,1,'2018-03-11 17:57:31','2018-03-11 20:11:17'),
	(2,1,1,'a:9:{s:5:\"title\";s:19:\"Billing for Abiodun\";s:11:\"description\";N;s:10:\"categories\";s:8:\"business\";s:9:\"customers\";s:9:\"X3Leasing\";s:8:\"features\";N;s:9:\"assignees\";N;s:5:\"notes\";N;s:10:\"task_items\";s:54:\" Retry billing for new card  Check payment allocation \";s:9:\"followups\";s:0:\"\";}','Billing for Abiodun business X3Leasing Retry billing for new card Check payment allocation',0,1,'2018-03-11 18:01:57','2018-03-11 20:16:53'),
	(3,1,2,'a:9:{s:5:\"title\";s:28:\"Billing for Mainline Finance\";s:11:\"description\";N;s:10:\"categories\";s:8:\"business\";s:9:\"customers\";s:8:\"Mainline\";s:8:\"features\";N;s:9:\"assignees\";N;s:5:\"notes\";N;s:10:\"task_items\";s:22:\" Retry billing charge \";s:9:\"followups\";s:0:\"\";}','Billing for Mainline Finance business Mainline Retry billing charge',1,1,'2018-03-11 18:01:57','2018-03-11 18:03:01'),
	(4,1,3,'a:9:{s:5:\"title\";s:24:\"Loanshopper domain setup\";s:11:\"description\";N;s:10:\"categories\";s:8:\"business\";s:9:\"customers\";s:11:\"Loanshopper\";s:8:\"features\";N;s:9:\"assignees\";N;s:5:\"notes\";N;s:10:\"task_items\";s:47:\" Log in to godaddy and connect domain by cname \";s:9:\"followups\";s:32:\" Contact Tigana and get password\";}','Loanshopper domain setup business Loanshopper Log in to godaddy and connect domain by cname Contact Tigana and get password',0,1,'2018-03-11 18:01:57','2018-03-11 19:17:17'),
	(5,1,4,'a:9:{s:5:\"title\";s:34:\"Opportunity finance domain mapping\";s:11:\"description\";N;s:10:\"categories\";s:8:\"business\";s:9:\"customers\";s:18:\"OpportunityFinance\";s:8:\"features\";N;s:9:\"assignees\";N;s:5:\"notes\";N;s:10:\"task_items\";s:23:\" Log in and map domain \";s:9:\"followups\";s:0:\"\";}','Opportunity finance domain mapping business OpportunityFinance Log in and map domain',1,1,'2018-03-11 18:01:57','2018-03-11 18:03:01'),
	(6,1,5,'a:9:{s:5:\"title\";s:27:\"Maclen penalty rule feature\";s:11:\"description\";N;s:10:\"categories\";s:8:\"features\";s:9:\"customers\";s:6:\"Maclen\";s:8:\"features\";s:12:\"penalty rule\";s:9:\"assignees\";N;s:5:\"notes\";N;s:10:\"task_items\";s:56:\" Patch into production  Push to sandbox  Test with cron \";s:9:\"followups\";s:0:\"\";}','Maclen penalty rule feature features Maclen penalty rule Patch into production Push to sandbox Test with cron',1,1,'2018-03-11 18:01:57','2018-03-11 18:03:01'),
	(7,1,6,'a:9:{s:5:\"title\";s:31:\"Maclen penalty reversal request\";s:11:\"description\";N;s:10:\"categories\";s:7:\"support\";s:9:\"customers\";s:6:\"Maclen\";s:8:\"features\";N;s:9:\"assignees\";N;s:5:\"notes\";N;s:10:\"task_items\";s:46:\" Remove penalty amount and adjust instalments \";s:9:\"followups\";s:34:\" Request information from Donnamar\";}','Maclen penalty reversal request support Maclen Remove penalty amount and adjust instalments Request information from Donnamar',1,1,'2018-03-11 18:01:57','2018-03-11 18:03:01'),
	(8,1,8,'a:9:{s:5:\"title\";s:17:\"REACH translation\";s:11:\"description\";N;s:10:\"categories\";s:7:\"feature\";s:9:\"customers\";s:3:\"All\";s:8:\"features\";N;s:9:\"assignees\";N;s:5:\"notes\";N;s:10:\"task_items\";s:83:\" Translate and patch files into Production  Get objects from app  Reconnect GT API \";s:9:\"followups\";s:30:\" Contact Michael when complete\";}','REACH translation feature All Translate and patch files into Production Get objects from app Reconnect GT API Contact Michael when complete',1,1,'2018-03-11 18:01:57','2018-03-11 18:03:01'),
	(9,1,9,'a:9:{s:5:\"title\";s:20:\"Billodex coupons bug\";s:11:\"description\";N;s:10:\"categories\";s:3:\"bug\";s:9:\"customers\";s:8:\"Billodex\";s:8:\"features\";N;s:9:\"assignees\";N;s:5:\"notes\";N;s:10:\"task_items\";s:50:\" fix tab-index issue  fix coupon tracking in cart \";s:9:\"followups\";s:53:\" Contact billodex once done Asked KP to update server\";}','Billodex coupons bug bug Billodex fix tab-index issue fix coupon tracking in cart Contact billodex once done Asked KP to update server',0,1,'2018-03-11 18:01:57','2018-03-11 19:18:51'),
	(10,1,10,'a:9:{s:5:\"title\";s:32:\"Billing for allright investments\";s:11:\"description\";N;s:10:\"categories\";s:7:\"support\";s:9:\"customers\";s:7:\"Alright\";s:8:\"features\";N;s:9:\"assignees\";N;s:5:\"notes\";N;s:10:\"task_items\";s:54:\" Kill trial if necessary  Retry credit card - 2369.77 \";s:9:\"followups\";s:0:\"\";}','Billing for allright investments support Alright Kill trial if necessary Retry credit card - 2369.77',0,1,'2018-03-11 18:01:57','2018-03-11 19:29:56'),
	(11,1,11,'a:9:{s:5:\"title\";s:19:\"REACH billing setup\";s:11:\"description\";N;s:10:\"categories\";N;s:9:\"customers\";N;s:8:\"features\";N;s:9:\"assignees\";N;s:5:\"notes\";s:10:\"sdsdsdssds\";s:10:\"task_items\";s:0:\"\";s:9:\"followups\";s:0:\"\";}','REACH billing setup sdsdsdssds',1,1,'2018-03-11 18:01:57','2018-03-11 18:03:01'),
	(12,1,12,'a:9:{s:5:\"title\";s:23:\"REACH interface updates\";s:11:\"description\";N;s:10:\"categories\";N;s:9:\"customers\";N;s:8:\"features\";N;s:9:\"assignees\";N;s:5:\"notes\";s:2775:\"- need EDIT ACCOUNT feature for user; and tie up email change\n- copy logo from LC and make visible by default\n- automatically log in user\n- activation for existing subscribers\n- when creating income and expenses during application, bring the ADD button down with the DELETE button, User has to go back to the top each time to add\n- add control for layouts\n\n- no demo user linked * \n- demo data is causing problems / disbursed loans tab current with loan in arrears\n- alright investments ltd = kill trial \n\n- homepage image not uploading\n- users to admin users\n- reach logo on front-end\n- intercom script\n- admin template header/page builder template header\n\n- new design with slider\n- saving partial applications\n- integ. designs\n- update fields to show original label\n- add a connection checker on interval\n- if it\'s not a new client record, allow skipping steps and saving upfront\n\n- reference occupation missing\n- office phone and mobile phone for references\n- possible error on feedback when loan amount is out of range, lower bound\n- verify required documents exist before sending list over\n- relocate save functions from controller to model\n\n- add a link from the billing services page to the REACH CMS set up page\n- default credit officer cannot be REACH, give option in settings to assign a credit officer, first by selecting a default one, then by product\n- move FormDataCtrl to somewhere central\n- reference contact number missing\n- add postal code to addresses\n- add regions to addresses\n- add directions to addresses\n- DSR and summary financials page non-functional\n- sort ALL lists\n- user experience\n- add site status control to admin in REACH\n- indicate preview mode\n- lock down preview mode from public\n- feedback and communication between customers and clients\n- would be nice too: assignment of branch by parish or some other address attribute\n- need to screen some fields from the activity feed\n- more support for documents (output doc generation and signed docs)\n\n+ data movement between LC and RC\n+ user management\n+ design for loan pages\n\n+ pages in seed seem incorrect / page linking issues in forms as well\n+ gotoadmin\n+ remove default identification\n+ loan purpose missing\n+ handle missing unique ref number\n+ status colours NOT showing up in new instance\n+ double check all sections re data being transferred\n+ allow selection of a list on a drop-down element\n+ expense type not copied over into LC\n+ industries for employment still missing\n+ BUG income/expense categories and freqs missing on loan app side\n+ expenses categories missing on client but they show on loan\n\n+ billing setup\n+ billing charge\n+ BUG deleting element\n+ BUG missing user on activity feed \n+ loan application not created when missing fields are not filled\n+ loan state colours\";s:10:\"task_items\";s:0:\"\";s:9:\"followups\";s:0:\"\";}','REACH interface updates - need EDIT ACCOUNT feature for user; and tie up email change\n- copy logo from LC and make visible by default\n- automatically log in user\n- activation for existing subscribers\n- when creating income and expenses during application, bring the ADD button down with the DELETE button, User has to go back to the top each time to add\n- add control for layouts\n\n- no demo user linked * \n- demo data is causing problems / disbursed loans tab current with loan in arrears\n- alright investments ltd = kill trial \n\n- homepage image not uploading\n- users to admin users\n- reach logo on front-end\n- intercom script\n- admin template header/page builder template header\n\n- new design with slider\n- saving partial applications\n- integ. designs\n- update fields to show original label\n- add a connection checker on interval\n- if it\'s not a new client record, allow skipping steps and saving upfront\n\n- reference occupation missing\n- office phone and mobile phone for references\n- possible error on feedback when loan amount is out of range, lower bound\n- verify required documents exist before sending list over\n- relocate save functions from controller to model\n\n- add a link from the billing services page to the REACH CMS set up page\n- default credit officer cannot be REACH, give option in settings to assign a credit officer, first by selecting a default one, then by product\n- move FormDataCtrl to somewhere central\n- reference contact number missing\n- add postal code to addresses\n- add regions to addresses\n- add directions to addresses\n- DSR and summary financials page non-functional\n- sort ALL lists\n- user experience\n- add site status control to admin in REACH\n- indicate preview mode\n- lock down preview mode from public\n- feedback and communication between customers and clients\n- would be nice too: assignment of branch by parish or some other address attribute\n- need to screen some fields from the activity feed\n- more support for documents (output doc generation and signed docs)\n\n+ data movement between LC and RC\n+ user management\n+ design for loan pages\n\n+ pages in seed seem incorrect / page linking issues in forms as well\n+ gotoadmin\n+ remove default identification\n+ loan purpose missing\n+ handle missing unique ref number\n+ status colours NOT showing up in new instance\n+ double check all sections re data being transferred\n+ allow selection of a list on a drop-down element\n+ expense type not copied over into LC\n+ industries for employment still missing\n+ BUG income/expense categories and freqs missing on loan app side\n+ expenses categories missing on client but they show on loan\n\n+ billing setup\n+ billing charge\n+ BUG deleting element\n+ BUG missing user on activity feed \n+ loan application not created when missing fields are not filled\n+ loan state colours',1,1,'2018-03-11 18:01:57','2018-03-11 18:03:01'),
	(13,1,13,'[]','',0,1,'2018-03-11 20:17:50','2018-03-11 20:17:50');

/*!40000 ALTER TABLE `search_index` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table task_followups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `task_followups`;

CREATE TABLE `task_followups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `completed` tinyint(1) DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_followups_task_id_foreign` (`task_id`),
  KEY `task_followups_user_id_foreign` (`user_id`),
  CONSTRAINT `task_followups_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  CONSTRAINT `task_followups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `task_followups` WRITE;
/*!40000 ALTER TABLE `task_followups` DISABLE KEYS */;

INSERT INTO `task_followups` (`id`, `task_id`, `action`, `due_date`, `due_time`, `completed`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,3,'Contact Tigana and get password','2018-03-10','19:00:00',1,1,'2018-03-10 22:57:38','2018-03-11 17:32:55'),
	(2,6,'Request information from Donnamar','2018-03-11','14:00:00',0,1,'2018-03-10 23:02:21','2018-03-11 17:33:06'),
	(3,8,'Contact Michael when complete','2018-03-11','16:30:00',0,1,'2018-03-10 23:04:47','2018-03-10 23:04:47'),
	(4,9,'Contact billodex once done','2018-03-11','14:30:00',0,1,'2018-03-10 23:07:54','2018-03-11 19:18:51'),
	(5,9,'Asked KP to update server','2018-03-11','14:20:00',1,1,'2018-03-11 17:33:46','2018-03-11 19:47:32'),
	(6,3,'Check out domain linking','2018-03-11','19:00:00',0,1,'2018-03-11 19:18:29','2018-03-11 19:18:29');

/*!40000 ALTER TABLE `task_followups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table task_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `task_items`;

CREATE TABLE `task_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `priority` decimal(10,1) DEFAULT '50.0',
  `completed` tinyint(1) DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_items_task_id_foreign` (`task_id`),
  KEY `task_items_user_id_foreign` (`user_id`),
  CONSTRAINT `task_items_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  CONSTRAINT `task_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `task_items` WRITE;
/*!40000 ALTER TABLE `task_items` DISABLE KEYS */;

INSERT INTO `task_items` (`id`, `task_id`, `title`, `description`, `priority`, `completed`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,1,'Retry billing for new card',NULL,10.0,1,1,'2018-03-10 22:55:10','2018-03-11 20:16:58'),
	(2,2,'Retry billing charge',NULL,10.0,0,1,'2018-03-10 22:55:57','2018-03-10 22:55:57'),
	(3,3,'Log in to godaddy and connect domain by cname',NULL,10.0,1,1,'2018-03-10 22:57:38','2018-03-11 19:17:17'),
	(4,4,'Log in and map domain',NULL,10.0,0,1,'2018-03-10 22:58:53','2018-03-10 22:58:53'),
	(5,5,'Patch into production',NULL,5.0,0,1,'2018-03-10 23:00:21','2018-03-10 23:00:21'),
	(6,5,'Push to sandbox',NULL,8.0,0,1,'2018-03-10 23:00:21','2018-03-10 23:00:21'),
	(7,5,'Test with cron',NULL,10.0,0,1,'2018-03-10 23:00:21','2018-03-10 23:00:21'),
	(8,6,'Remove penalty amount and adjust instalments',NULL,10.0,0,1,'2018-03-10 23:02:21','2018-03-10 23:02:21'),
	(9,8,'Translate and patch files into Production',NULL,5.0,0,1,'2018-03-10 23:04:47','2018-03-10 23:04:47'),
	(10,8,'Get objects from app',NULL,8.0,0,1,'2018-03-10 23:04:47','2018-03-10 23:04:47'),
	(11,8,'Reconnect GT API',NULL,10.0,0,1,'2018-03-10 23:04:47','2018-03-10 23:04:47'),
	(12,9,'fix tab-index issue',NULL,5.0,1,1,'2018-03-10 23:07:54','2018-03-11 17:14:58'),
	(13,9,'fix coupon tracking in cart',NULL,1.0,1,1,'2018-03-10 23:07:54','2018-03-11 17:15:01'),
	(14,10,'Kill trial if necessary',NULL,5.0,1,1,'2018-03-10 23:08:53','2018-03-11 15:36:59'),
	(15,10,'Retry credit card - 2369.77',NULL,10.0,0,1,'2018-03-10 23:08:53','2018-03-10 23:09:20'),
	(16,1,'Check payment allocation',NULL,5.0,1,1,'2018-03-11 13:15:28','2018-03-11 13:23:44'),
	(17,7,'build a report for principal corroboration and net-zero balance assessment',NULL,10.0,0,1,'2018-03-11 20:11:17','2018-03-11 20:11:17'),
	(18,7,'build a report for interest corroboration',NULL,15.0,0,1,'2018-03-11 20:11:17','2018-03-11 20:11:17'),
	(19,13,'add to cart/coupon section, use up space better',NULL,20.0,0,1,'2018-03-11 20:46:45','2018-03-11 21:03:03'),
	(20,13,'log in and register page don\'t work',NULL,15.0,0,1,'2018-03-11 20:46:45','2018-03-11 21:03:03'),
	(21,13,'search doesn\'t work on mobile',NULL,10.0,0,1,'2018-03-11 20:46:45','2018-03-11 20:49:05'),
	(22,13,'resolution of content on page',NULL,25.0,0,1,'2018-03-11 20:46:45','2018-03-11 21:03:03'),
	(23,13,'iconography on edit events page',NULL,28.0,0,1,'2018-03-11 20:46:45','2018-03-11 21:03:03'),
	(24,13,'the \"banner\" taking over the page',NULL,8.0,0,1,'2018-03-11 20:46:45','2018-03-11 21:15:03'),
	(25,13,'remove filter from the mobile view',NULL,5.0,0,1,'2018-03-11 21:17:39','2018-03-11 21:17:39');

/*!40000 ALTER TABLE `task_items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `priority` decimal(10,1) DEFAULT '50.0',
  `completion` int(11) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `assignees` text COLLATE utf8mb4_unicode_ci,
  `customers` text COLLATE utf8mb4_unicode_ci,
  `categories` text COLLATE utf8mb4_unicode_ci,
  `features` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'queued',
  `completed` tinyint(1) DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_user_id_foreign` (`user_id`),
  KEY `tasks_project_id_foreign` (`project_id`),
  CONSTRAINT `tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;

INSERT INTO `tasks` (`id`, `project_id`, `title`, `description`, `priority`, `completion`, `start_date`, `start_time`, `due_date`, `due_time`, `assignees`, `customers`, `categories`, `features`, `notes`, `status`, `completed`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,1,'Billing for Abiodun',NULL,10.0,0,'2018-03-10','17:00:00','2018-03-10','22:00:00',NULL,'X3Leasing','business',NULL,NULL,'queued',1,1,'2018-03-10 22:55:10','2018-03-11 17:35:05'),
	(2,1,'Billing for Mainline Finance',NULL,10.0,0,'2018-03-10','17:00:00','2018-03-12','06:00:00',NULL,'Mainline','business',NULL,NULL,'queued',0,1,'2018-03-10 22:55:57','2018-03-11 17:35:34'),
	(3,1,'Loanshopper domain setup',NULL,5.0,0,'2018-03-10','17:00:00','2018-03-11','16:00:00',NULL,'Loanshopper','business',NULL,NULL,'queued',0,1,'2018-03-10 22:57:38','2018-03-11 19:18:29'),
	(4,1,'Opportunity finance domain mapping',NULL,9.0,0,'2018-03-10','19:00:00','2018-03-11','15:00:00',NULL,'OpportunityFinance','business',NULL,NULL,'queued',0,1,'2018-03-10 22:58:53','2018-03-11 17:34:57'),
	(5,1,'Maclen penalty rule feature',NULL,15.0,0,'2018-03-09','10:00:00','2018-03-11','22:30:00',NULL,'Maclen','features','penalty rule',NULL,'queued',0,1,'2018-03-10 23:00:21','2018-03-11 17:35:48'),
	(6,1,'Maclen penalty reversal request',NULL,11.0,0,'2018-03-10','17:00:00','2018-03-11','15:30:00',NULL,'Maclen','support',NULL,NULL,'queued',0,1,'2018-03-10 23:02:21','2018-03-11 17:35:42'),
	(7,1,'Bayshore reports',NULL,1.0,0,'2018-03-10','17:00:00','2018-03-11','16:00:00',NULL,'Bayshore','support',NULL,NULL,'queued',0,1,'2018-03-10 23:03:00','2018-03-11 20:11:17'),
	(8,1,'REACH translation',NULL,7.0,0,'2018-03-10','17:00:00','2018-03-11','17:00:00',NULL,'All','feature',NULL,NULL,'queued',0,1,'2018-03-10 23:04:47','2018-03-10 23:04:47'),
	(9,1,'Billodex coupons bug',NULL,4.0,0,'2018-03-10','20:00:00','2018-03-10','21:00:00',NULL,'Billodex','bug',NULL,NULL,'queued',1,1,'2018-03-10 23:07:54','2018-03-11 17:33:57'),
	(10,1,'Billing for alright investments',NULL,15.0,0,'2018-03-10','19:30:00','2018-03-12','12:30:00',NULL,'Alright','support',NULL,NULL,'queued',0,1,'2018-03-10 23:08:53','2018-03-11 19:29:56'),
	(11,1,'REACH billing setup',NULL,5.0,0,'2018-03-10','23:09:36','2018-03-11','18:00:00',NULL,NULL,NULL,NULL,'sdsdsdssds','queued',0,1,'2018-03-10 23:09:36','2018-03-11 17:34:46'),
	(12,1,'REACH interface updates',NULL,7.0,0,'2018-03-10','23:09:48','2018-03-11','22:00:00',NULL,NULL,NULL,NULL,'- need EDIT ACCOUNT feature for user; and tie up email change\n- copy logo from LC and make visible by default\n- automatically log in user\n- activation for existing subscribers\n- when creating income and expenses during application, bring the ADD button down with the DELETE button, User has to go back to the top each time to add\n- add control for layouts\n\n- no demo user linked * \n- demo data is causing problems / disbursed loans tab current with loan in arrears\n- alright investments ltd = kill trial \n\n- homepage image not uploading\n- users to admin users\n- reach logo on front-end\n- intercom script\n- admin template header/page builder template header\n\n- new design with slider\n- saving partial applications\n- integ. designs\n- update fields to show original label\n- add a connection checker on interval\n- if it\'s not a new client record, allow skipping steps and saving upfront\n\n- reference occupation missing\n- office phone and mobile phone for references\n- possible error on feedback when loan amount is out of range, lower bound\n- verify required documents exist before sending list over\n- relocate save functions from controller to model\n\n- add a link from the billing services page to the REACH CMS set up page\n- default credit officer cannot be REACH, give option in settings to assign a credit officer, first by selecting a default one, then by product\n- move FormDataCtrl to somewhere central\n- reference contact number missing\n- add postal code to addresses\n- add regions to addresses\n- add directions to addresses\n- DSR and summary financials page non-functional\n- sort ALL lists\n- user experience\n- add site status control to admin in REACH\n- indicate preview mode\n- lock down preview mode from public\n- feedback and communication between customers and clients\n- would be nice too: assignment of branch by parish or some other address attribute\n- need to screen some fields from the activity feed\n- more support for documents (output doc generation and signed docs)\n\n+ data movement between LC and RC\n+ user management\n+ design for loan pages\n\n+ pages in seed seem incorrect / page linking issues in forms as well\n+ gotoadmin\n+ remove default identification\n+ loan purpose missing\n+ handle missing unique ref number\n+ status colours NOT showing up in new instance\n+ double check all sections re data being transferred\n+ allow selection of a list on a drop-down element\n+ expense type not copied over into LC\n+ industries for employment still missing\n+ BUG income/expense categories and freqs missing on loan app side\n+ expenses categories missing on client but they show on loan\n\n+ billing setup\n+ billing charge\n+ BUG deleting element\n+ BUG missing user on activity feed \n+ loan application not created when missing fields are not filled\n+ loan state colours','queued',0,1,'2018-03-10 23:09:48','2018-03-11 17:34:51'),
	(13,1,'Billodex mobile design updates',NULL,0.5,0,'2018-03-11','15:00:00','2018-03-11','18:00:00',NULL,'Billodex','bugs',NULL,NULL,'queued',0,1,'2018-03-11 20:17:50','2018-03-11 20:17:50');

/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Desmond Campbell','docampbell@gmail.com','$2y$10$TCDhc0Xw1fOlAinr.52qou1Hi/iUnfZJbbHKHjilR3B3/rxH7TsU.','dM9eGLYORxT0ZJuxqt3qtj8vbg1ZMxNOgoDfISS6PbBskn5UTCLTUsWuhqfi','2018-03-10 14:23:26','2018-03-10 14:23:26');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
