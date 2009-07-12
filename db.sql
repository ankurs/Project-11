--
-- Database: `project11`
--
CREATE DATABASE `project11` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `project11`;

-- --------------------------------------------------------

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;


--
-- Table structure for table `cat_head`
--

CREATE TABLE IF NOT EXISTS `cat_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `headid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;


--
-- Table structure for table `catagory`
--

CREATE TABLE IF NOT EXISTS `catagory` (
  `catid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`catid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;


--
-- Table structure for table `event_head`
--

CREATE TABLE IF NOT EXISTS `event_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;


--
-- Table structure for table `event_org`
--

CREATE TABLE IF NOT EXISTS `event_org` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


--
-- Table structure for table `event_team`
--

CREATE TABLE IF NOT EXISTS `event_team` (
  `eventid` int(11) NOT NULL,
  `teamno` int(11) NOT NULL,
  PRIMARY KEY (`eventid`,`teamno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `event_vol`
--

CREATE TABLE IF NOT EXISTS `event_vol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;


--
-- Table structure for table `main`
--

CREATE TABLE IF NOT EXISTS `main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `reg_info`
--

CREATE TABLE IF NOT EXISTS `reg_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delno` int(11) NOT NULL,
  `eventid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `delno` (`delno`,`eventid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;


--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `reg` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dept` varchar(15) NOT NULL,
  `sem` tinyint(4) NOT NULL,
  `sec` varchar(2) NOT NULL,
  PRIMARY KEY (`reg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `team_info`
--

CREATE TABLE IF NOT EXISTS `team_info` (
  `hash` varchar(64) NOT NULL,
  `delno` int(11) NOT NULL,
  PRIMARY KEY (`hash`,`delno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
