
--
-- Table structure for table `catagory`
--

CREATE TABLE IF NOT EXISTS `catagory` (
  `catid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `info` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`catid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `cat_head`
--

CREATE TABLE IF NOT EXISTS `cat_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `headid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `cbt`
--

CREATE TABLE IF NOT EXISTS `cbt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `qnum` int(11) NOT NULL,
  `eventkey` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cbt_login`
--

CREATE TABLE IF NOT EXISTS `cbt_login` (
  `delno` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `passkey` varchar(64) COLLATE utf8_bin NOT NULL,
  `reset` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`delno`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eventid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `team` tinyint(4) NOT NULL DEFAULT '0',
  `info` text NOT NULL,
  `min_team_mem` int(11) NOT NULL,
  `max_team_mem` int(11) NOT NULL,
  PRIMARY KEY (`eventid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_head`
--

CREATE TABLE IF NOT EXISTS `event_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_org`
--

CREATE TABLE IF NOT EXISTS `event_org` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_team`
--

CREATE TABLE IF NOT EXISTS `event_team` (
  `eventid` int(11) NOT NULL,
  `teamno` int(11) NOT NULL,
  PRIMARY KEY (`eventid`,`teamno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_vol`
--

CREATE TABLE IF NOT EXISTS `event_vol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `main`
--

CREATE TABLE IF NOT EXISTS `main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `question` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `opt1` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `opt2` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `opt3` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `opt4` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `copt` int(11) NOT NULL,
  PRIMARY KEY (`qid`),
  UNIQUE KEY `qid` (`qid`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reg_info`
--

CREATE TABLE IF NOT EXISTS `reg_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delno` int(11) NOT NULL,
  `eventid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `delno` (`delno`,`eventid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

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
  `password` int(11) NOT NULL,
  PRIMARY KEY (`delno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `team_info`
--

CREATE TABLE IF NOT EXISTS `team_info` (
  `hash` varchar(64) NOT NULL,
  `delno` int(11) NOT NULL,
  PRIMARY KEY (`hash`,`delno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


