-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Mer 24 Octobre 2012 à 16:24
-- Version du serveur: 5.5.27-log
-- Version de PHP: 5.4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `appli_facebook_automate`
--

-- --------------------------------------------------------

--
-- Structure de la table `fb_automate_album`
--

CREATE TABLE IF NOT EXISTS `fb_automate_album` (
  `uid_album` varchar(20) NOT NULL,
  `name_album` varchar(50) NOT NULL,
  `date_create_album` datetime NOT NULL,
  `uid` varchar(20) NOT NULL,
  PRIMARY KEY (`uid_album`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fb_automate_album`
--

INSERT INTO `fb_automate_album` (`uid_album`, `name_album`, `date_create_album`, `uid`) VALUES
('176255172399385', 'Timeline Photos', '2010-12-10 01:56:20', '100000447113991'),
('430130257011874', 'BD  ..', '2012-05-19 22:35:32', '100000447113991'),
('435423856482514', 'Escalade..', '2012-05-28 16:12:54', '100000447113991'),
('430165330341700', 'Cover Photos', '2012-05-19 23:47:54', '100000447113991'),
('461897093835190', 'Mobile Uploads', '2012-07-17 15:44:49', '100000447113991'),
('176255175732718', 'Timeline Photos', '2010-12-10 01:56:20', '100000447113991'),
('151919731499596', 'Profile Pictures', '2010-09-05 06:49:21', '100000447113991');

-- --------------------------------------------------------

--
-- Structure de la table `fb_automate_page`
--

CREATE TABLE IF NOT EXISTS `fb_automate_page` (
  `uid_page` varchar(20) NOT NULL,
  `name_page` varchar(50) NOT NULL,
  `token_access_page` varchar(150) NOT NULL,
  `uid` varchar(20) NOT NULL,
  PRIMARY KEY (`uid_page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fb_automate_page`
--

INSERT INTO `fb_automate_page` (`uid_page`, `name_page`, `token_access_page`, `uid`) VALUES
('304717649592540', 'Automator', 'AAAEtbW2aSdkBANatxOujnFOHtgxGSYwa1ZA35Qzor9XfSjZA5ZBm3tCpEAxXL3ACudZCxVDHVp8L1c7GeUP9aKiZBBZCRiZACejdugxPbSmreVruiXeZCce6', '100000447113991');

-- --------------------------------------------------------

--
-- Structure de la table `fb_automate_post`
--

CREATE TABLE IF NOT EXISTS `fb_automate_post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `type_post` varchar(20) NOT NULL,
  `type_page` varchar(20) NOT NULL,
  `message_post` varchar(450) NOT NULL,
  `created_at` datetime NOT NULL,
  `posted_for` datetime NOT NULL,
  `lien_post` varchar(150) DEFAULT NULL,
  `uid` varchar(20) NOT NULL,
  `uid_album` varchar(20) DEFAULT NULL,
  `uname` varchar(50) DEFAULT NULL,
  `posted_post` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_post`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=283 ;

--
-- Contenu de la table `fb_automate_post`
--

INSERT INTO `fb_automate_post` (`id_post`, `type_post`, `type_page`, `message_post`, `created_at`, `posted_for`, `lien_post`, `uid`, `uid_album`, `uname`, `posted_post`) VALUES
(282, 'album', 'profil', 'qfssqf', '2012-10-24 16:18:11', '2012-10-24 16:17:00', '', '100000447113991', '430130257011874', '', 1),
(280, 'album', 'profil', 'coucou', '2012-10-24 15:55:26', '0000-00-00 00:00:00', '', '100000447113991', '430130257011874', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `fb_automate_user`
--

CREATE TABLE IF NOT EXISTS `fb_automate_user` (
  `uid` varchar(20) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `token_access` varchar(150) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fb_automate_user`
--

INSERT INTO `fb_automate_user` (`uid`, `lastname`, `firstname`, `created_at`, `last_login`, `token_access`) VALUES
('100000447113991', 'Ricos', 'Nicoco', '2012-10-24 15:53:22', '2012-10-24 15:53:22', 'AAAEtbW2aSdkBADrzvQWqZBiORVdzDDlfDplAhll4f74wfFLsuEzndOukTQXKk6RzgKR3iX0mghnn6bvmZBKNZCQg3ZC1mL6CQybZAW7GwQQZDZD');

-- --------------------------------------------------------

--
-- Structure de la table `fb_automate_user_google`
--

CREATE TABLE IF NOT EXISTS `fb_automate_user_google` (
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `fb_automate_user_tweeter`
--

CREATE TABLE IF NOT EXISTS `fb_automate_user_tweeter` (
  `uname` varchar(50) NOT NULL,
  `oauth_token` varchar(90) NOT NULL,
  `oauth_token_secret` varchar(90) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`uname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fb_automate_user_tweeter`
--

INSERT INTO `fb_automate_user_tweeter` (`uname`, `oauth_token`, `oauth_token_secret`, `created_at`) VALUES
('clisfranc', '262099465-G1uh5SmdAwhoMyTi5jut3g8LmEzSsRk2tDsk1m8J', 'CxutKjJitWRzK7adzbo0qyXvoZLEWjQW6BENwYi4ig', '2012-02-08 13:22:16'),
('', '', '', '2012-02-08 15:11:30');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
