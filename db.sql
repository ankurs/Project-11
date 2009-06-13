--
-- Table structure for table `catagory`
--

CREATE TABLE IF NOT EXISTS `catagory` (
  `catid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`catid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `cat_event`
--

CREATE TABLE IF NOT EXISTS `cat_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `eventid` (`eventid`),
  UNIQUE KEY `eventid_2` (`eventid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `cat_head`
--

CREATE TABLE IF NOT EXISTS `cat_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `headid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eventid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `team` tinyint(4) NOT NULL DEFAULT '0',
  `info` text NOT NULL,
  PRIMARY KEY (`eventid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `event_head`
--

CREATE TABLE IF NOT EXISTS `event_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `event_org`
--

CREATE TABLE IF NOT EXISTS `event_org` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `event_vol`
--

CREATE TABLE IF NOT EXISTS `event_vol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Table structure for table `heads`
--

CREATE TABLE IF NOT EXISTS `heads` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `level` varchar(10) NOT NULL,
  `passkey` varchar(64) NOT NULL,
  `reset` varchar(10) NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `reg_info`
--

CREATE TABLE IF NOT EXISTS `reg_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delno` int(11) NOT NULL,
  `eventid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `reg_user`
--

CREATE TABLE IF NOT EXISTS `reg_user` (
  `delno` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `regno` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cllg` varchar(100) NOT NULL,
  `sem` int(11) NOT NULL,
  `phone` varchar(12) NOT NULL,
  PRIMARY KEY (`delno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `student`
-- -- student records stored here --
--

CREATE TABLE IF NOT EXISTS `student` (
  `reg` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dept` varchar(15) NOT NULL,
  `sem` tinyint(4) NOT NULL,
  `sec` varchar(2) NOT NULL,
  PRIMARY KEY (`reg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

