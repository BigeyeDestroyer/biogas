CREATE DATABASE IF NOT EXISTS `biogas`;
USE `biogas`;

-- the administrator table
DROP TABLE IF EXISTS `biogas_admin`;
CREATE TABLE `biogas_admin` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- the user table
DROP TABLE IF EXISTS `biogas_user`;
CREATE TABLE `biogas_user`(
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `capacity` decimal(10, 2) NOT NULL,
  `pId` smallint(5) unsigned NOT NULL,
  `cId` smallint(5) unsigned NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `uDesc` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- the province table
DROP TABLE IF EXISTS `biogas_prov`;
CREATE TABLE `biogas_prov` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `province` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `province` (`province`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `biogas_city`;
CREATE TABLE `biogas_city` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

