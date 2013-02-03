-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2009 年 06 月 06 日 07:24
-- 服务器版本: 5.1.33
-- PHP 版本: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `db_heishanjazz`
--

-- --------------------------------------------------------

--
-- 表的结构 `videos_description`
--

CREATE TABLE IF NOT EXISTS `videos_description` (
  `videoid` int(32) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`videoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `videos_description`
--

INSERT INTO `videos_description` (`videoid`, `title`, `description`, `time`) VALUES
(1, '黑山教授的爵士音乐教学播客开播', '黑山老师将在网上向大家教学大家欢迎', '2009-06-05 12:00:00'),
(2, '什么是爵士乐', '视频阐述了爵士乐的发展和特点', '2009-06-05 13:00:00'),
(3, '运用五度圈学音乐-黑山音乐讲座系列', '五度圈是中国古代发明', '2009-06-05 14:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `videos_keyword`
--

CREATE TABLE IF NOT EXISTS `videos_keyword` (
  `videoid` int(32) NOT NULL,
  `count` int(11) NOT NULL,
  `keyword` varchar(64) NOT NULL,
  PRIMARY KEY (`videoid`,`count`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `videos_keyword`
--

INSERT INTO `videos_keyword` (`videoid`, `count`, `keyword`) VALUES
(3, 1, '乐理'),
(1, 1, '视频'),
(1, 2, '黑山'),
(3, 2, '五度圈'),
(2, 1, '爵士'),
(3, 3, '和声'),
(3, 4, '音程'),
(2, 2, '黑山');

-- --------------------------------------------------------

--
-- 表的结构 `videos_related`
--

CREATE TABLE IF NOT EXISTS `videos_related` (
  `videoid` int(32) NOT NULL,
  `count` int(11) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `url` varchar(256) DEFAULT NULL,
  `isheishanvideo` tinyint(1) NOT NULL,
  PRIMARY KEY (`videoid`,`count`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `videos_related`
--

INSERT INTO `videos_related` (`videoid`, `count`, `description`, `url`, `isheishanvideo`) VALUES
(1, 1, '什么是爵士乐', '2', 1),
(2, 1, '黑山教授的爵士音乐教学播客开播', '1', 1),
(3, 1, '黑山教学视频', 'http://you.video.sina.com.cn/hsjazz', 0);

-- --------------------------------------------------------

--
-- 表的结构 `videos_url`
--

CREATE TABLE IF NOT EXISTS `videos_url` (
  `videoid` int(32) NOT NULL,
  `site` varchar(16) NOT NULL,
  `url` varchar(256) NOT NULL,
  PRIMARY KEY (`videoid`,`site`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `videos_url`
--

INSERT INTO `videos_url` (`videoid`, `site`, `url`) VALUES
(1, 'sina', 'http://vhead.blog.sina.com.cn/player/outer_player.swf?auto=1&vid=11533941&uid=1357523881'),
(2, 'sina', 'http://vhead.blog.sina.com.cn/player/outer_player.swf?auto=1&vid=11561077&uid=1357523881'),
(3, 'sina', 'http://vhead.blog.sina.com.cn/player/outer_player.swf?auto=0&vid=11820328&uid=1357523881');
