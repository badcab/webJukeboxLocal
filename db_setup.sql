/*the sql file to create the db I will be using*/
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `web_jukebox` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `web_jukebox`;

CREATE TABLE IF NOT EXISTS `songs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT 'UNKNOWN',
  `artist` varchar(50) NOT NULL DEFAULT 'UNKNOWN',
  `file_path` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'UNKNOWN',
  `has_played` tinyint(2) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
