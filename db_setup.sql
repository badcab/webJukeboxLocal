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


CREATE TABLE IF NOT EXISTS `queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `song_id` int(11) unsigned NOT NULL,
  `votes` int(11) unsigned NOT NULL DEFAULT 0,
  `btn_label` int(11)  NOT NULL DEFAULT 'UNKNOWN',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`song_id`) REFERENCES `songs`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*
a heat will just be the top three things
will do a nice select on this
*/



