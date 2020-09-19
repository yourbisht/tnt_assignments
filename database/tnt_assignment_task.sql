/*
SQLyog Community v13.1.2 (64 bit)
MySQL - 10.4.11-MariaDB : Database - tnt_assignment_task
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tnt_assignment_task` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `tnt_assignment_task`;

/*Table structure for table `jobseekers` */

DROP TABLE IF EXISTS `jobseekers`;

CREATE TABLE `jobseekers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` bigint(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobseekers` */

insert  into `jobseekers`(`id`,`name`,`job_title`,`email`,`location`,`description`,`profile_photo`,`phone_number`,`status`,`created_at`,`updated_at`) values 
(1,'Eric Suzor','SSE','eric@swivelt.com','3','eric',NULL,90909090,0,'2020-09-16 13:35:21','2020-09-18 06:55:24'),
(2,'Eric Suzor','SSE','eric1@swivelt.com','9','eric','1600421614.jpg',90909090,1,'2020-09-16 13:36:43','2020-09-18 06:37:19'),
(3,'Mukesh Bisht','Senior PHP Developer','mukesh.bisht@swivelt.com','2','Senior PHP Developer',NULL,9090909090,1,'2020-09-18 05:33:28','2020-09-18 05:33:28'),
(4,'Dhruv','Doctor','admin@swivelt.com','2','test',NULL,9090909090,1,'2020-09-18 05:35:24','2020-09-18 05:35:24'),
(5,'Sourav','Junior','varuntest@gmail.com','2','test',NULL,9090909090,1,'2020-09-18 05:36:20','2020-09-18 05:36:20');

/*Table structure for table `jobseekers_galleries` */

DROP TABLE IF EXISTS `jobseekers_galleries`;

CREATE TABLE `jobseekers_galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `gallery_photos` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobseekers_galleries` */

/*Table structure for table `locations` */

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `locations` */

insert  into `locations`(`id`,`location_name`,`status`,`created_at`,`updated_at`) values 
(1,'Delhi',1,'2020-09-16 05:46:16','2020-09-16 05:46:16'),
(2,'Banglore',1,'2020-09-16 05:46:16','2020-09-16 05:46:16'),
(3,'Noida',1,'2020-09-16 05:46:16','2020-09-16 05:46:16'),
(4,'Gurugram',1,'2020-09-16 05:46:16','2020-09-16 05:46:16'),
(5,'Hyderabad',1,'2020-09-16 05:46:16','2020-09-16 05:46:16'),
(6,'Chennai',1,'2020-09-16 05:46:16','2020-09-16 05:46:16'),
(7,'Pune',1,'2020-09-16 05:46:16','2020-09-16 05:46:16'),
(8,'Mumbai',1,'2020-09-16 05:46:16','2020-09-16 05:46:16'),
(9,'Jaipur',1,'2020-09-16 05:46:16','2020-09-16 05:46:16'),
(10,'Dehradun',1,'2020-09-16 05:46:16','2020-09-16 05:46:16');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Mukesh Bisht','mukesh.bisht@nityo.com',NULL,'$2y$10$oNZH36IhVPDuf/fa0wMoLewvl7mxqh19HYwFmlw9GyqN0p.PB3D9e',NULL,'2020-09-16 10:31:01','2020-09-16 10:31:01');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
