-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 18, 2018 at 09:04 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ghostbox_586491`
--
CREATE DATABASE IF NOT EXISTS `ghostbox_586491` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ghostbox_586491`;

-- --------------------------------------------------------

--
-- Table structure for table `global_fileformats`
--

DROP TABLE IF EXISTS `global_fileformats`;
CREATE TABLE IF NOT EXISTS `global_fileformats` (
  `FORMATID` int(11) NOT NULL AUTO_INCREMENT,
  `FILEFORMAT` varchar(5) NOT NULL,
  `FORMAT_CATEGORIE` varchar(50) NOT NULL,
  PRIMARY KEY (`FILEFORMAT`),
  UNIQUE KEY `FORMATID` (`FORMATID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `global_fileformats`
--

INSERT INTO `global_fileformats` (`FORMATID`, `FILEFORMAT`, `FORMAT_CATEGORIE`) VALUES
(16, 'BMP', 'Grafikformat'),
(4, 'GIF', 'Grafikformat'),
(1, 'JPG', 'Grafikformat'),
(6, 'PDF', 'Dokumentformat'),
(3, 'PNG', 'Grafikformat'),
(8, 'TAR', 'Archivierungsformat'),
(5, 'TXT', 'Dokumentformat'),
(7, 'ZIP', 'Archivierungsformat');

-- --------------------------------------------------------

--
-- Table structure for table `global_settings`
--

DROP TABLE IF EXISTS `global_settings`;
CREATE TABLE IF NOT EXISTS `global_settings` (
  `SETTINGSID` int(11) NOT NULL AUTO_INCREMENT,
  `SETTINGS_NAME` varchar(100) NOT NULL,
  `SETTINGS_VALUE` varchar(100) NOT NULL,
  `SETTINGS_DISPLAY_NAME` varchar(100) NOT NULL,
  PRIMARY KEY (`SETTINGSID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `global_settings`
--

INSERT INTO `global_settings` (`SETTINGSID`, `SETTINGS_NAME`, `SETTINGS_VALUE`, `SETTINGS_DISPLAY_NAME`) VALUES
(1, 'MAX_STORAGE', '20000', 'maximaler Gesamtspeicher'),
(2, 'MAX_FILE_UPLOAD', '5000', 'maximalaer Datei-Upload'),
(3, 'ALLOWED_FILEFORMATS', 'JPG;BMP;PNG;GIF;TXT;PDF;ZIP;TAR', 'erlaubte Dateiformate');

-- --------------------------------------------------------

--
-- Table structure for table `raw_files`
--

DROP TABLE IF EXISTS `raw_files`;
CREATE TABLE IF NOT EXISTS `raw_files` (
  `FILEID` int(11) NOT NULL AUTO_INCREMENT,
  `FILENAME` varchar(100) NOT NULL,
  `FILEDISPLAYNAME` varchar(100) NOT NULL,
  `FILEFORMAT` varchar(5) NOT NULL,
  `FILESIZE` int(11) NOT NULL COMMENT 'Byte',
  `SAVE_LOCAL` tinyint(1) NOT NULL,
  `SAVE_CLOUD` tinyint(1) NOT NULL,
  `USERID` int(11) NOT NULL,
  `_CREATEDATE` datetime NOT NULL,
  `_DELETEDATE` datetime DEFAULT NULL,
  `PUBLIC` tinyint(1) NOT NULL,
  PRIMARY KEY (`FILEID`),
  KEY `userid_files` (`USERID`),
  KEY `fileformat` (`FILEFORMAT`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `raw_files`
--

INSERT INTO `raw_files` (`FILEID`, `FILENAME`, `FILEDISPLAYNAME`, `FILEFORMAT`, `FILESIZE`, `SAVE_LOCAL`, `SAVE_CLOUD`, `USERID`, `_CREATEDATE`, `_DELETEDATE`, `PUBLIC`) VALUES
(1, 'MjAxN19JQV9Qcm9qZWt0YXJiZWl0X0F1ZmdhYmVuc3RlbGx1bmcucGRm', 'Projekt Aufgabenstellung', 'PDF', 642011, 1, 0, 1, '2018-01-16 18:50:12', NULL, 1),
(2, 'MjAxN19JQV9Qcm9qZWt0YXJiZWl0X0Jld2VydHVuZ3Nib2dlbi5wZGY=', 'Projekt Bewertungsbogen', 'PDF', 328073, 1, 0, 1, '2018-01-16 18:50:33', NULL, 0),
(3, 'UEVOTlkgTWFya3QuanBn', 'Penny', 'JPG', 4327143, 1, 0, 1, '2018-01-16 19:02:35', NULL, 1),
(4, 'U3BlemlhbHRoZW1lbi1NSS1MYXJhdmVsLnBkZg==', 'Laravel PHP Vortrag', 'PDF', 312398, 1, 0, 1, '2018-01-17 09:08:25', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `raw_file_tags`
--

DROP TABLE IF EXISTS `raw_file_tags`;
CREATE TABLE IF NOT EXISTS `raw_file_tags` (
  `FILEID` int(11) NOT NULL,
  `TAG` varchar(100) NOT NULL,
  PRIMARY KEY (`FILEID`,`TAG`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `raw_file_tags`
--

INSERT INTO `raw_file_tags` (`FILEID`, `TAG`) VALUES
(1, 'Aufgabenstellung'),
(1, 'Dietrich'),
(1, 'Internetanwendungen'),
(1, 'Medieninformatik'),
(2, 'Dietrich'),
(2, 'Internetanwendungen'),
(2, 'PHP'),
(2, 'Projekt'),
(2, 'Zend'),
(3, 'Gemüse'),
(3, 'Mann'),
(3, 'Obst'),
(3, 'Penny'),
(4, 'Laravel'),
(4, 'Studium');

-- --------------------------------------------------------

--
-- Table structure for table `raw_user`
--

DROP TABLE IF EXISTS `raw_user`;
CREATE TABLE IF NOT EXISTS `raw_user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FIRSTNAME` varchar(50) DEFAULT NULL,
  `LASTNAME` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `_CREATEDATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_UPDATEDATE` datetime DEFAULT NULL,
  `_DELETEDATE` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `EMAIL` (`EMAIL`),
  UNIQUE KEY `USERID` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `raw_user`
--

INSERT INTO `raw_user` (`ID`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PASSWORD`, `_CREATEDATE`, `_UPDATEDATE`, `_DELETEDATE`) VALUES
(1, 'Christoph', 'Stockinger', 'cs@christophstockinger.de', 'Test1234', '2018-01-16 18:48:30', '2018-01-16 19:15:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `raw_user_settings`
--

DROP TABLE IF EXISTS `raw_user_settings`;
CREATE TABLE IF NOT EXISTS `raw_user_settings` (
  `USERID` int(11) NOT NULL,
  `SAVELOCATION_LOCAL` varchar(150) NOT NULL,
  `SAVE_CLOUD` tinyint(1) NOT NULL,
  `SAVELOCATION_CLOUD` varchar(150) NOT NULL,
  `USERNAME_CLOUD` varchar(50) NOT NULL,
  `PASSWORD_CLOUD` varchar(50) NOT NULL,
  `MAX_FILE_UPLOAD` int(6) NOT NULL COMMENT 'Megabyte',
  `MAX_STORAGE` int(6) NOT NULL COMMENT 'Megabyte',
  `ALLOWED_FILEFORMATS` varchar(60) NOT NULL,
  PRIMARY KEY (`USERID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `raw_user_settings`
--

INSERT INTO `raw_user_settings` (`USERID`, `SAVELOCATION_LOCAL`, `SAVE_CLOUD`, `SAVELOCATION_CLOUD`, `USERNAME_CLOUD`, `PASSWORD_CLOUD`, `MAX_FILE_UPLOAD`, `MAX_STORAGE`, `ALLOWED_FILEFORMATS`) VALUES
(1, '039c5b7f9ee2cb0666815bf0ee3ea50b', 0, '', '', '', 5000, 20000, 'JPG;BMP;PNG;GIF;TXT;PDF;ZIP;TAR');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `raw_files`
--
ALTER TABLE `raw_files`
  ADD CONSTRAINT `fileformat` FOREIGN KEY (`FILEFORMAT`) REFERENCES `global_fileformats` (`FILEFORMAT`),
  ADD CONSTRAINT `userid_files` FOREIGN KEY (`USERID`) REFERENCES `raw_user` (`ID`);

--
-- Constraints for table `raw_file_tags`
--
ALTER TABLE `raw_file_tags`
  ADD CONSTRAINT `files` FOREIGN KEY (`FILEID`) REFERENCES `raw_files` (`FILEID`);

--
-- Constraints for table `raw_user_settings`
--
ALTER TABLE `raw_user_settings`
  ADD CONSTRAINT `userid` FOREIGN KEY (`USERID`) REFERENCES `raw_user` (`ID`);
