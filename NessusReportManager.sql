-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2013 at 03:43 AM
-- Server version: 5.5.29-0ubuntu0.12.10.1
-- PHP Version: 5.4.6-1ubuntu1.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `NessusReportManager`
--

-- --------------------------------------------------------

--
-- Table structure for table `AccessLogin`
--

CREATE TABLE IF NOT EXISTS `AccessLogin` (
  `Id` int(225) NOT NULL AUTO_INCREMENT,
  `Username` varchar(45) DEFAULT NULL,
  `IpAddress` varchar(45) DEFAULT NULL,
  `RequestTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `AccessLogin`
--

INSERT INTO `AccessLogin` (`Id`, `Username`, `IpAddress`, `RequestTime`) VALUES
(1, 'admin', '127.0.0.1', '2013-01-09 11:41:45'),
(2, 'admin', '127.0.0.1', '2013-01-09 12:41:36'),
(3, 'admin', '127.0.0.1', '2013-01-09 20:26:54'),
(4, 'admin', '127.0.0.1', '2013-01-10 11:45:58'),
(5, 'admin', '127.0.0.1', '2013-01-10 13:12:21'),
(6, 'admin', '127.0.0.1', '2013-01-10 21:08:21'),
(7, 'admin', '127.0.0.1', '2013-01-11 12:57:55'),
(8, 'admin', '127.0.0.1', '2013-01-12 17:47:22'),
(9, 'admin', '127.0.0.1', '2013-01-12 18:30:39'),
(10, 'admin', '127.0.0.1', '2013-01-12 19:04:56'),
(11, 'admin', '127.0.0.1', '2013-01-17 12:12:43'),
(12, 'admin', '127.0.0.1', '2013-01-25 09:19:47'),
(13, 'admin', '127.0.0.1', '2013-01-26 12:16:57'),
(14, 'admin', '127.0.0.1', '2013-01-29 22:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `FailLogin`
--

CREATE TABLE IF NOT EXISTS `FailLogin` (
  `Id` int(255) NOT NULL AUTO_INCREMENT,
  `Username` varchar(45) DEFAULT NULL,
  `Password` varchar(45) DEFAULT NULL,
  `IpAddress` varchar(45) DEFAULT NULL,
  `RequestTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `FailLogin`
--

INSERT INTO `FailLogin` (`Id`, `Username`, `Password`, `IpAddress`, `RequestTime`) VALUES
(1, 'mince', 'qwe123!', '127.0.0.1', '2013-01-10 11:45:54'),
(2, 'admin', 'qwe123!', '127.0.0.1', '2013-01-12 19:04:08');

-- --------------------------------------------------------

--
-- Table structure for table `Hosts`
--

CREATE TABLE IF NOT EXISTS `Hosts` (
  `HostID` int(255) NOT NULL AUTO_INCREMENT,
  `ReportID` int(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  PRIMARY KEY (`HostID`),
  KEY `HostID` (`HostID`),
  KEY `HostID_2` (`HostID`),
  KEY `ReportID` (`ReportID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `HostsVulnerabilities`
--

CREATE TABLE IF NOT EXISTS `HostsVulnerabilities` (
  `HostID` int(255) NOT NULL,
  `VulnID` int(255) DEFAULT NULL,
  `id` int(255) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `HostID` (`HostID`),
  KEY `HostID_2` (`HostID`),
  KEY `HostID_3` (`HostID`),
  KEY `VulnID` (`VulnID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `JobAssignment`
--

CREATE TABLE IF NOT EXISTS `JobAssignment` (
  `JobID` int(255) NOT NULL AUTO_INCREMENT,
  `UserID` int(255) DEFAULT NULL,
  `HostID` int(255) DEFAULT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `Description` text NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`JobID`),
  KEY `JobID` (`JobID`),
  KEY `JobID_2` (`JobID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ReportGroups`
--

CREATE TABLE IF NOT EXISTS `ReportGroups` (
  `GroupID` int(255) NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `GroupDescription` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`GroupID`),
  KEY `GroupID` (`GroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Reports`
--

CREATE TABLE IF NOT EXISTS `Reports` (
  `ReportID` int(255) NOT NULL AUTO_INCREMENT,
  `UserID` int(255) NOT NULL,
  `InsertDate` date NOT NULL,
  `IpAddress` varchar(45) NOT NULL,
  `CheckSum` varchar(45) NOT NULL,
  `ReportName` varchar(255) NOT NULL,
  `ReportDescription` text NOT NULL,
  `ReportPath` varchar(255) NOT NULL,
  `IsProcessed` int(1) NOT NULL DEFAULT '0',
  `GroupID` int(255) NOT NULL,
  PRIMARY KEY (`ReportID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `UserID` int(255) NOT NULL AUTO_INCREMENT,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `Mail` varchar(45) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Surname` varchar(45) NOT NULL,
  `RegistrationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `UserIdentify` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Username_UNIQUE` (`Username`),
  UNIQUE KEY `Mail_UNIQUE` (`Mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `Username`, `Password`, `Mail`, `Name`, `Surname`, `RegistrationDate`, `UserIdentify`) VALUES
(1, 'admin', '40572c205c325dcdafa5be6a29bc08e853741602', 'mehmet.ince@bga.com.tr', 'Mehmet', 'Ince', '2012-09-27 02:57:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Vulnerabilities`
--

CREATE TABLE IF NOT EXISTS `Vulnerabilities` (
  `VulnID` int(11) NOT NULL AUTO_INCREMENT,
  `Port` int(11) DEFAULT NULL,
  `Service` varchar(45) DEFAULT NULL,
  `Protocol` varchar(45) DEFAULT NULL,
  `Name` text,
  `RiskFactor` varchar(45) DEFAULT NULL,
  `Severity` int(1) DEFAULT NULL,
  `Synopsis` text,
  `Description` text,
  `PluginID` int(11) DEFAULT NULL,
  `Family` varchar(45) DEFAULT NULL,
  `VulnPublicationDate` date DEFAULT NULL,
  `ExploitabilityEase` varchar(45) DEFAULT NULL,
  `ExploitAvailable` int(1) DEFAULT NULL,
  `Solution` text,
  `PluginPublicationDate` date DEFAULT NULL,
  `PluginModificationDate` date DEFAULT NULL,
  `PatchPublicationDate` date DEFAULT NULL,
  `SeeAlso` text,
  `CvssBaseScore` float DEFAULT NULL,
  `Cve` varchar(225) DEFAULT NULL,
  `Bid` varchar(255) DEFAULT NULL,
  `Xref` varchar(225) DEFAULT NULL,
  `ExploitFrameworkCanvas` int(1) DEFAULT NULL,
  `ExploitFrameworkCore` int(1) DEFAULT NULL,
  `ExploitFrameworkMetasploit` int(1) DEFAULT NULL,
  `MetasploitName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`VulnID`),
  UNIQUE KEY `PluginID` (`PluginID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
