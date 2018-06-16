# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: taurus-dev.com (MySQL 5.5.52-0ubuntu0.14.04.1)
# Database: taurus
# Generation Time: 2017-06-18 10:24:20 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table exercise
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exercise`;

CREATE TABLE `exercise` (
  `exercise_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `difficulty` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `variant_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `exercise_group_id` int(11) unsigned DEFAULT NULL,
  `workout_location_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`exercise_id`),
  KEY `exercise_group_id` (`exercise_group_id`),
  KEY `workout_location_id` (`workout_location_id`),
  CONSTRAINT `exercise_ibfk_1` FOREIGN KEY (`exercise_group_id`) REFERENCES `exercise_group` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `exercise_ibfk_2` FOREIGN KEY (`workout_location_id`) REFERENCES `workout_location` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table exercise_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exercise_group`;

CREATE TABLE `exercise_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `difficulty` varchar(255) DEFAULT NULL,
  `muscle_group_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `muscle_group_id` (`muscle_group_id`),
  CONSTRAINT `exercise_group_ibfk_1` FOREIGN KEY (`muscle_group_id`) REFERENCES `muscle_group` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table muscle_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `muscle_group`;

CREATE TABLE `muscle_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table workout
# ------------------------------------------------------------

DROP TABLE IF EXISTS `workout`;

CREATE TABLE `workout` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `workout_location_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workout_location_id` (`workout_location_id`),
  CONSTRAINT `workout_ibfk_1` FOREIGN KEY (`workout_location_id`) REFERENCES `workout_location` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS `workout_location`;

CREATE TABLE `workout_location` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `geo_location` point ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.58-0ubuntu0.14.04.1)
# Database: taurus_test
# Generation Time: 2017-10-31 17:53:38 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

