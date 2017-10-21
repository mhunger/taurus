# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: taurus-dev.com (MySQL 5.5.52-0ubuntu0.14.04.1)
# Database: taurus
# Generation Time: 2017-02-05 18:17:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;


# Dump of table exercise
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exercise`;

CREATE TABLE `exercise` (
  `exercise_id`  INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`         VARCHAR(255)              DEFAULT NULL,
  `difficulty`   VARCHAR(255)
                 CHARACTER SET latin1      DEFAULT NULL,
  `variant_name` VARCHAR(255)
                 CHARACTER SET latin1      DEFAULT NULL,
  PRIMARY KEY (`exercise_id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Dump of table ExerciseGroup
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ExerciseGroup`;

CREATE TABLE `ExerciseGroup` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Dump of table workout
# ------------------------------------------------------------

DROP TABLE IF EXISTS `workout`;

CREATE TABLE `workout` (
  `id`   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` DATETIME                  DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
