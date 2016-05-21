
CREATE TABLE IF NOT EXISTS `pilot_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(12) NOT NULL,
  `pfname` varchar(50) NOT NULL DEFAULT '',
  `plname` varchar(50) NOT NULL,
  `blank` int(12) NOT NULL DEFAULT '0',
  `warning` int(12) NOT NULL,
  `welcome` int(12) NOT NULL,
  `message` text NOT NULL,
  `datesent` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

