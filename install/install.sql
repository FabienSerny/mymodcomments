CREATE TABLE IF NOT EXISTS `PREFIX_mymod_comment` (
  `id_mymod_comment` int(11) NOT NULL AUTO_INCREMENT,
  `id_shop` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `firstname` VARCHAR( 255 ) NOT NULL,
  `lastname` VARCHAR( 255 ) NOT NULL,
  `email` VARCHAR( 255 ) NOT NULL,
  `grade` tinyint(1) NOT NULL,
  `comment` text NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_mymod_comment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
