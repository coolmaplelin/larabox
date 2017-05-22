/*
SQLyog Enterprise v10.3 
MySQL - 5.7.14 : Database - larabox
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`larabox` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `larabox`;

/*Table structure for table `custom_form_entry` */

DROP TABLE IF EXISTS `custom_form_entry`;

CREATE TABLE `custom_form_entry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `form_fields` text COLLATE utf8mb4_unicode_ci,
  `is_actioned` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `custom_form_entry_form_id_foreign` (`form_id`),
  CONSTRAINT `custom_form_entry_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `custom_forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `custom_form_entry` */

insert  into `custom_form_entry`(`id`,`form_id`,`form_fields`,`is_actioned`,`created_at`,`updated_at`) values (8,2,'[{\"title\":\"One Question\",\"type\":\"text\",\"options\":\"\",\"help\":\"\",\"manda\":\"0\",\"active\":\"1\",\"value\":\"fd\"}]',0,'2017-03-23 21:55:16','2017-03-23 21:55:16'),(9,2,'[{\"title\":\"One Question\",\"type\":\"text\",\"options\":\"\",\"help\":\"\",\"manda\":\"0\",\"active\":\"1\",\"value\":\"dd\"}]',0,'2017-03-23 22:03:40','2017-03-23 22:03:40'),(10,2,'[{\"title\":\"One Question\",\"type\":\"text\",\"options\":\"\",\"help\":\"\",\"manda\":\"0\",\"active\":\"1\",\"value\":\"dfd\"}]',0,'2017-03-23 22:06:21','2017-03-23 22:06:21'),(11,2,'[{\"title\":\"One Question\",\"type\":\"text\",\"options\":\"\",\"help\":\"\",\"manda\":\"0\",\"active\":\"1\",\"value\":\"dd\"}]',0,'2017-03-23 22:08:48','2017-03-23 22:08:48'),(12,2,'[{\"title\":\"One Question\",\"type\":\"text\",\"options\":\"\",\"help\":\"\",\"manda\":\"0\",\"active\":\"1\",\"value\":\"dfd\"}]',0,'2017-03-23 22:10:55','2017-03-23 22:10:55'),(13,2,'[{\"title\":\"One Question\",\"type\":\"text\",\"options\":\"\",\"help\":\"\",\"manda\":\"0\",\"active\":\"1\",\"value\":\"d\"}]',0,'2017-03-23 22:15:31','2017-03-23 22:15:31'),(14,2,'[{\"title\":\"One Question\",\"type\":\"text\",\"options\":\"\",\"help\":\"\",\"manda\":\"0\",\"active\":\"1\",\"value\":\"dd\"}]',0,'2017-03-23 22:18:10','2017-03-23 22:18:10'),(16,2,'[{\"title\":\"One Question\",\"type\":\"text\",\"options\":\"\",\"help\":\"\",\"manda\":\"0\",\"active\":\"1\",\"value\":\"dd\"}]',0,'2017-03-30 20:53:49','2017-03-30 20:53:49'),(20,1,'[{\"title\":\"Name\",\"type\":\"text\",\"options\":\"\",\"help\":\"\",\"manda\":\"1\",\"active\":\"1\",\"value\":\"Maple\"},{\"title\":\"Email\",\"type\":\"email\",\"options\":\"\",\"help\":\"\",\"manda\":\"1\",\"active\":\"1\",\"value\":\"maple@redpropaganda.com.au\"},{\"title\":\"Radio\",\"type\":\"radio\",\"options\":\"1\\n2\\n3\",\"help\":\"\",\"manda\":\"1\",\"active\":\"1\",\"value\":\"2\"},{\"title\":\"Checkbox\",\"type\":\"checkbox\",\"options\":\"apple\\norgange\\npear\",\"help\":\"\",\"manda\":\"1\",\"active\":\"1\",\"value\":\"organge,pear\"},{\"title\":\"Select box\",\"type\":\"select\",\"options\":\" \\n1\\n2\\n3\",\"help\":\"\",\"manda\":\"1\",\"active\":\"1\",\"value\":\"2\"},{\"title\":\"Upload Image\",\"type\":\"image\",\"options\":\"\",\"help\":\"\",\"manda\":\"0\",\"active\":\"1\",\"value\":\"\\/assets\\/userupload\\/food-q-c-640-480-9.jpg\"}]',0,'2017-05-08 09:29:36','2017-05-08 09:29:36');

/*Table structure for table `custom_forms` */

DROP TABLE IF EXISTS `custom_forms`;

CREATE TABLE `custom_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `emails` text COLLATE utf8mb4_unicode_ci,
  `instructions` text COLLATE utf8mb4_unicode_ci,
  `form_fields` text COLLATE utf8mb4_unicode_ci,
  `thankyou_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thankyou_content` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `custom_forms` */

insert  into `custom_forms`(`id`,`name`,`slug`,`active`,`emails`,`instructions`,`form_fields`,`thankyou_title`,`thankyou_content`,`created_at`,`updated_at`) values (1,'Contact us','contact-us',1,'maple_lin2004@hotmail.com','<p>Please fill in the form:</p>','[{\"title\":\"Name\",\"type\":\"text\",\"options\":\"\",\"help\":\"\",\"manda\":\"1\",\"active\":\"1\"},{\"title\":\"Email\",\"type\":\"email\",\"options\":\"\",\"help\":\"\",\"manda\":\"1\",\"active\":\"1\"},{\"title\":\"Radio\",\"type\":\"radio\",\"options\":\"1\\n2\\n3\",\"help\":\"\",\"manda\":\"1\",\"active\":\"1\"},{\"title\":\"Checkbox\",\"type\":\"checkbox\",\"options\":\"apple\\norgange\\npear\",\"help\":\"\",\"manda\":\"1\",\"active\":\"1\"},{\"title\":\"Select box\",\"type\":\"select\",\"options\":\" \\n1\\n2\\n3\",\"help\":\"\",\"manda\":\"1\",\"active\":\"1\"},{\"title\":\"Upload Image\",\"type\":\"image\",\"options\":\"\",\"help\":\"\",\"manda\":\"0\",\"active\":\"1\"}]','Thank You','<p>Thank you content</p>','2017-03-17 22:20:26','2017-03-21 20:05:36'),(2,'simple','simple',1,'maple_lin2004@hotmail.com',NULL,'[{\"title\":\"One Question\",\"type\":\"text\",\"options\":\"\",\"help\":\"\",\"manda\":\"0\",\"active\":\"1\"}]','Thank You','<p>Thank you</p>','2017-03-23 21:53:30','2017-03-23 21:53:30');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2017_03_04_195240_create_newsletters_table',2),(7,'2017_03_04_214550_create_user_newsletters_table',3),(8,'2017_03_05_154133_create_pages_table',4),(9,'2015_08_04_131614_create_settings_table',5),(10,'2017_03_13_200209_create_navigation_table',6),(11,'2017_03_17_143755_create_custom_form_table',7),(12,'2017_03_20_195424_create_custom_form_entry_table',8),(13,'2017_03_27_200151_create_redirects_table',9);

/*Table structure for table `navigations` */

DROP TABLE IF EXISTS `navigations`;

CREATE TABLE `navigations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nav_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `parent_id` int(10) unsigned DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_id` int(10) unsigned DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `navigations` */

insert  into `navigations`(`id`,`name`,`nav_type`,`active`,`parent_id`,`link`,`page_id`,`sort`,`created_at`,`updated_at`) values (1,'home','TOP',1,NULL,'',NULL,2,NULL,'2017-03-28 21:11:22'),(2,'About Us','TOP',1,NULL,'',NULL,4,NULL,'2017-03-16 20:59:07'),(3,'About Maple','TOP',1,2,'',6,2,NULL,'2017-03-16 20:59:43'),(5,'Contact Us','TOP',1,NULL,'/contact-us',NULL,3,'2017-03-15 22:16:44','2017-03-28 21:11:22'),(8,'Test','TOP',0,5,'',4,1,'2017-03-15 22:17:56','2017-03-16 20:58:53'),(9,'Test','TOP',1,NULL,'/test',NULL,1,'2017-03-15 22:17:56','2017-03-16 20:56:38'),(10,'test','TOP',0,2,'',NULL,1,'2017-03-16 20:36:23','2017-03-16 20:58:53'),(11,'Footer1','FOOTER',1,NULL,'',NULL,1,'2017-03-16 21:17:14','2017-03-16 21:17:14'),(12,'TestSearchApp','TOP',1,NULL,'',NULL,5,'2017-03-19 20:42:40','2017-03-19 20:42:40');

/*Table structure for table `newsletters` */

DROP TABLE IF EXISTS `newsletters`;

CREATE TABLE `newsletters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `newsletters` */

insert  into `newsletters`(`id`,`name`) values (1,'Daily'),(2,'Weekly'),(3,'Monthly');

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_live` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` datetime DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `gallery` json DEFAULT NULL,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pages_parent_id_foreign` (`parent_id`),
  CONSTRAINT `pages_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pages` */

insert  into `pages`(`id`,`name`,`is_live`,`published_at`,`parent_id`,`title`,`slug`,`content`,`gallery`,`meta_title`,`meta_description`,`created_at`,`updated_at`,`deleted_at`) values (4,'home',1,'2017-03-05 17:49:45',NULL,'homepage','homepage',NULL,'[]',NULL,NULL,'2017-03-05 17:49:45','2017-03-09 21:39:25',NULL),(5,'About Us',1,'2017-03-05 20:16:22',NULL,'About Us','about-us',NULL,NULL,NULL,NULL,'2017-03-05 20:16:22','2017-03-19 21:05:36',NULL),(6,'About Maple',1,'2017-03-05 21:28:49',5,'About Maple 1','about-us/about-maple-1',NULL,'[{\"url\": \"http://larabox/assets/files/page/6/Chrysanthemum.jpg\", \"desc\": \"\", \"live\": \"1\", \"name\": \"Chrysanthemum.jpg\", \"size\": 879394, \"type\": \"image/jpeg\", \"title\": \"\", \"deleteUrl\": \"/fileupload/handle/page/6/?file=Chrysanthemum.jpg\", \"deleteType\": \"DELETE\", \"thumbnailUrl\": \"http://larabox/assets/files/page/6/thumbnail/Chrysanthemum.jpg\"}, {\"url\": \"http://larabox/assets/files/page/6/Tulips.jpg\", \"desc\": \"\", \"live\": \"1\", \"name\": \"Tulips.jpg\", \"size\": 620888, \"type\": \"image/jpeg\", \"title\": \"\", \"deleteUrl\": \"/fileupload/handle/page/6/?file=Tulips.jpg\", \"deleteType\": \"DELETE\", \"thumbnailUrl\": \"http://larabox/assets/files/page/6/thumbnail/Tulips.jpg\"}, {\"url\": \"http://larabox/assets/files/page/6/Desert.jpg\", \"desc\": \"\", \"live\": \"1\", \"name\": \"Desert.jpg\", \"size\": 845941, \"type\": \"image/jpeg\", \"title\": \"\", \"deleteUrl\": \"/fileupload/handle/page/6/?file=Desert.jpg\", \"deleteType\": \"DELETE\", \"thumbnailUrl\": \"http://larabox/assets/files/page/6/thumbnail/Desert.jpg\"}, {\"url\": \"http://larabox/assets/files/page/6/Jellyfish.jpg\", \"desc\": \"\", \"live\": \"1\", \"name\": \"Jellyfish.jpg\", \"size\": 775702, \"type\": \"image/jpeg\", \"title\": \"\", \"deleteUrl\": \"/fileupload/handle/page/6/?file=Jellyfish.jpg\", \"deleteType\": \"DELETE\", \"thumbnailUrl\": \"http://larabox/assets/files/page/6/thumbnail/Jellyfish.jpg\"}]',NULL,NULL,'2017-03-05 21:28:49','2017-03-30 20:30:45',NULL),(8,'About Bin',1,'2017-03-05 22:05:29',6,'About Bin 1','about-us/about-maple-1/about-bin-1',NULL,NULL,NULL,NULL,'2017-03-05 22:05:29','2017-03-27 21:18:43',NULL);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

insert  into `password_resets`(`email`,`token`,`created_at`) values ('ericli@example.com','$2y$10$UGVwMMKURzbs25nPax2vwuMWtchkgTlh5TZA3pva5oQo9eApjzvDG','2017-03-04 12:09:49');

/*Table structure for table `redirects` */

DROP TABLE IF EXISTS `redirects`;

CREATE TABLE `redirects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `redirects` */

insert  into `redirects`(`id`,`type`,`from`,`to`,`created_at`,`updated_at`) values (1,'original','about-us','something','2017-03-27 20:42:00','2017-03-27 20:42:00'),(2,'system','about-us/about-maple/about-bin','about-us/about-bin','2017-03-27 21:17:09','2017-03-27 21:17:09'),(3,'system','about-us/about-bin','about-us/about-bin-1','2017-03-27 21:17:39','2017-03-27 21:17:39'),(4,'system','about-us/about-bin-1','about-us/about-maple/about-bin-1','2017-03-27 21:18:13','2017-03-27 21:18:13'),(5,'system','about-us/about-maple','about-us/about-maple-1','2017-03-27 21:18:43','2017-03-27 21:18:43'),(6,'system','about-us/about-maple/about-bin-1','about-us/about-maple-1/about-bin-1','2017-03-27 21:18:43','2017-03-27 21:18:43');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `settings` */

insert  into `settings`(`id`,`key`,`name`,`description`,`value`,`field`,`active`,`created_at`,`updated_at`) values (1,'contact_email','Contact form email address','The email address that all emails from the contact form will go to.','admin@updivision.com','{\"name\":\"value\",\"label\":\"Value\",\"type\":\"email\"}',1,NULL,NULL),(2,'contact_cc','Contact form CC field','Email adresses separated by comma, to be included as CC in the email sent by the contact form.','','{\"name\":\"value\",\"label\":\"Value\",\"type\":\"email\"}',1,NULL,NULL),(3,'contact_bcc','Contact form BCC field','Email adresses separated by comma, to be included as BCC in the email sent by the contact form.',NULL,'{\"name\":\"value\",\"label\":\"Value\",\"type\":\"email\"}',1,NULL,'2017-03-10 19:04:50'),(4,'motto','Motto','Website motto','this is the value','{\"name\":\"value\",\"label\":\"Value\", \"title\":\"Motto value\" ,\"type\":\"textarea\"}',1,NULL,NULL);

/*Table structure for table `user_newsletters` */

DROP TABLE IF EXISTS `user_newsletters`;

CREATE TABLE `user_newsletters` (
  `user_id` int(10) unsigned NOT NULL,
  `newsletter_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`newsletter_id`),
  KEY `user_newsletters_newsletter_id_foreign` (`newsletter_id`),
  CONSTRAINT `user_newsletters_newsletter_id_foreign` FOREIGN KEY (`newsletter_id`) REFERENCES `newsletters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_newsletters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_newsletters` */

insert  into `user_newsletters`(`user_id`,`newsletter_id`) values (1,1),(1,2),(1,3);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`first_name`,`last_name`,`email`,`account_type`,`password`,`remember_token`,`phone`,`photo`,`created_at`,`updated_at`) values (1,'Maple','Test','maple_lin2004@hotmail.com','ADMIN','$2y$10$6TmOjF2FD.CDe.r4tpe/QOcKVBMeIHLLk1Y7Ql6DdUiytUmfypJsa','E5FnT2vCnAGeDRKjX0Jeg92Bf3PRLnk1800IaGMSGB3dv4TFe7ZywwWWXhQh',NULL,'assets/Images/photo/c153c69557d97b91b573c3e90a9d9ecd.jpg','2016-11-02 10:36:05','2017-03-05 16:19:39'),(2,'Bin','Li','binli@example.com','USER','$2y$10$8yprn8Cr58YWeRuJgmpeLO20GkVsXXxpKIq893WisneCVkYSusEjK','UkFKCDunHpsHQkyVkq6wIq94muQfIZ1THeFZSVHeNF4TxEUtDgho4bZrKNMu',NULL,'assets/Images/photo/d3b883458853fb8fc0267106bd8d1a2d.jpg','2017-03-03 20:29:03','2017-03-03 21:33:46'),(3,'Eric','Li','ericli@example.com','USER','$2y$10$eiq40ApwhC3dwKV/lRhJWOCw8lA.cwZP7lj57KFBN8XUNhwZoyh7S','ySNRucAXroUMdiYCtopIsbc19njIBkxVTcl4VT2pN6uuCW0QV7iumcGK27E2',NULL,NULL,'2017-03-04 11:50:30','2017-03-04 11:50:30');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
