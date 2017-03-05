/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50711
Source Host           : localhost:3306
Source Database       : larabox

Target Server Type    : MYSQL
Target Server Version : 50711
File Encoding         : 65001

Date: 2017-03-05 22:26:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2017_03_04_195240_create_newsletters_table', '2');
INSERT INTO `migrations` VALUES ('7', '2017_03_04_214550_create_user_newsletters_table', '3');
INSERT INTO `migrations` VALUES ('8', '2017_03_05_154133_create_pages_table', '4');

-- ----------------------------
-- Table structure for newsletters
-- ----------------------------
DROP TABLE IF EXISTS `newsletters`;
CREATE TABLE `newsletters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of newsletters
-- ----------------------------
INSERT INTO `newsletters` VALUES ('1', 'Daily');
INSERT INTO `newsletters` VALUES ('2', 'Weekly');
INSERT INTO `newsletters` VALUES ('3', 'Monthly');

-- ----------------------------
-- Table structure for pages
-- ----------------------------
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

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES ('4', 'home', '1', '2017-03-05 17:49:45', null, 'homepage', 'homepage', null, null, null, null, '2017-03-05 17:49:45', '2017-03-05 17:51:11', null);
INSERT INTO `pages` VALUES ('5', 'About Us', '1', '2017-03-05 20:16:22', '4', 'About Us', 'about-us', null, null, null, null, '2017-03-05 20:16:22', '2017-03-05 20:16:22', null);
INSERT INTO `pages` VALUES ('6', 'About Maple', '1', '2017-03-05 21:28:49', '5', 'About Maple', 'about-maple', null, null, null, null, '2017-03-05 21:28:49', '2017-03-05 22:22:02', null);
INSERT INTO `pages` VALUES ('8', 'About Bin', '0', '2017-03-05 22:05:29', '5', 'About Bin', 'about-bin', null, null, null, null, '2017-03-05 22:05:29', '2017-03-05 22:21:48', null);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
INSERT INTO `password_resets` VALUES ('ericli@example.com', '$2y$10$UGVwMMKURzbs25nPax2vwuMWtchkgTlh5TZA3pva5oQo9eApjzvDG', '2017-03-04 12:09:49');

-- ----------------------------
-- Table structure for users
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Maple', 'Test', 'maple_lin2004@hotmail.com', 'ADMIN', '$2y$10$6TmOjF2FD.CDe.r4tpe/QOcKVBMeIHLLk1Y7Ql6DdUiytUmfypJsa', 'ZgdYokyS7UWQXbLaCi6V89HFtKJGNNVQO1r7CdJwzTFMbwmYm3AT0lBdrORl', null, 'assets/Images/photo/c153c69557d97b91b573c3e90a9d9ecd.jpg', '2016-11-02 10:36:05', '2017-03-05 16:19:39');
INSERT INTO `users` VALUES ('2', 'Bin', 'Li', 'binli@example.com', 'USER', '$2y$10$8yprn8Cr58YWeRuJgmpeLO20GkVsXXxpKIq893WisneCVkYSusEjK', 'UkFKCDunHpsHQkyVkq6wIq94muQfIZ1THeFZSVHeNF4TxEUtDgho4bZrKNMu', null, 'assets/Images/photo/d3b883458853fb8fc0267106bd8d1a2d.jpg', '2017-03-03 20:29:03', '2017-03-03 21:33:46');
INSERT INTO `users` VALUES ('3', 'Eric', 'Li', 'ericli@example.com', 'USER', '$2y$10$eiq40ApwhC3dwKV/lRhJWOCw8lA.cwZP7lj57KFBN8XUNhwZoyh7S', 'ySNRucAXroUMdiYCtopIsbc19njIBkxVTcl4VT2pN6uuCW0QV7iumcGK27E2', null, null, '2017-03-04 11:50:30', '2017-03-04 11:50:30');

-- ----------------------------
-- Table structure for user_newsletters
-- ----------------------------
DROP TABLE IF EXISTS `user_newsletters`;
CREATE TABLE `user_newsletters` (
  `user_id` int(10) unsigned NOT NULL,
  `newsletter_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`newsletter_id`),
  KEY `user_newsletters_newsletter_id_foreign` (`newsletter_id`),
  CONSTRAINT `user_newsletters_newsletter_id_foreign` FOREIGN KEY (`newsletter_id`) REFERENCES `newsletters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_newsletters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_newsletters
-- ----------------------------
INSERT INTO `user_newsletters` VALUES ('1', '1');
INSERT INTO `user_newsletters` VALUES ('1', '2');
SET FOREIGN_KEY_CHECKS=1;
