-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 13. Jan 2017 um 23:39
-- Server-Version: 5.6.25
-- PHP-Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `superdb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `raw_user`
--

CREATE TABLE IF NOT EXISTS `raw_user` (
  `ID` int(11) NOT NULL,
  `FIRSTNAME` varchar(50) DEFAULT NULL,
  `LASTNAME` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `_CREATEDATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_UPDATEDATE` datetime DEFAULT NULL,
  `_DELETEDATE` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `raw_user`
--

INSERT INTO `raw_user` (`ID`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PASSWORD`, `_CREATEDATE`, `_UPDATEDATE`, `_DELETEDATE`) VALUES
(1, 'Hans Peter', 'Müller', 'hp@mueller.de', '1234', '2017-01-12 22:30:04', NULL, NULL),
(2, 'Heike', 'Müller', 'heike@web.de', '5678GeheiM', '2017-01-12 22:38:47', NULL, NULL),
(3, 'Udo', 'Lindenbarg', 'udo@berlinrocker.de', 'zugnachpankow', '2017-01-13 23:12:38', NULL, NULL),
(4, 'Rosalind', 'Picard', 'rp@mit.edu', 'affectivec0mput1ng', '2017-01-13 23:13:42', NULL, NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `raw_user`
--
ALTER TABLE `raw_user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `raw_user`
--
ALTER TABLE `raw_user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
