-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.31 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table mcms.appointment
CREATE TABLE IF NOT EXISTS `appointment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `patientID` int(10) NOT NULL,
  `doctorID` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `addedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cancel` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table mcms.appointment: 3 rows
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
INSERT INTO `appointment` (`id`, `patientID`, `doctorID`, `date`, `addedDate`, `cancel`) VALUES
	(3, 1, 3, '2022-09-25 18:00:00', '2022-09-25 14:47:37', 0),
	(15, 2, 3, '2022-09-26 05:20:00', '2022-09-26 00:17:01', 1),
	(14, 1, 3, '2022-09-26 04:20:00', '2022-09-26 00:16:43', 1);
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;

-- Dumping structure for table mcms.disease
CREATE TABLE IF NOT EXISTS `disease` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientID` int(10) NOT NULL,
  `doctorID` int(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `des` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table mcms.disease: 2 rows
/*!40000 ALTER TABLE `disease` DISABLE KEYS */;
INSERT INTO `disease` (`id`, `patientID`, `doctorID`, `date`, `des`) VALUES
	(1, 1, 3, '2022-09-27 13:22:22', 'Sugur'),
	(3, 2, 3, '2022-09-28 00:24:51', 'test');
/*!40000 ALTER TABLE `disease` ENABLE KEYS */;

-- Dumping structure for table mcms.medicine
CREATE TABLE IF NOT EXISTS `medicine` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `patientID` int(10) NOT NULL,
  `doctorID` int(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `medicines` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table mcms.medicine: 1 rows
/*!40000 ALTER TABLE `medicine` DISABLE KEYS */;
INSERT INTO `medicine` (`id`, `patientID`, `doctorID`, `date`, `medicines`) VALUES
	(1, 2, 3, '2022-09-28 01:24:10', 'Test medi 1\nTest medi 2\nTest medi 3');
/*!40000 ALTER TABLE `medicine` ENABLE KEYS */;

-- Dumping structure for table mcms.patient
CREATE TABLE IF NOT EXISTS `patient` (
  `id` int(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `age` int(3) NOT NULL DEFAULT '0',
  `address` varchar(500) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `regDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Dumping data for table mcms.patient: 2 rows
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` (`id`, `name`, `age`, `address`, `phone`, `note`, `regDate`) VALUES
	(1, 'Test Patient edit', 20, 'test, test', '1234567890', 'test.....', '2022-09-22 00:00:00'),
	(2, 'Test Patient 2', 20, 'test, test', '1234567890', 'test.....', '2022-09-22 00:00:00');
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;

-- Dumping structure for table mcms.test
CREATE TABLE IF NOT EXISTS `test` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `patientID` int(10) NOT NULL,
  `doctorID` int(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `testName` varchar(100) NOT NULL,
  `results` varchar(500) NOT NULL DEFAULT 'Results Pending',
  `doneDate` datetime DEFAULT NULL,
  `done` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table mcms.test: 1 rows
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
INSERT INTO `test` (`id`, `patientID`, `doctorID`, `date`, `testName`, `results`, `doneDate`, `done`) VALUES
	(1, 1, 3, '2022-09-28 01:44:04', 'FBC', '1\r\n2\r\n3\r\n4\r\n5', '2022-09-28 00:00:00', 1);
/*!40000 ALTER TABLE `test` ENABLE KEYS */;

-- Dumping structure for table mcms.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(20) NOT NULL,
  `password` varchar(25) NOT NULL,
  `name` varchar(250) NOT NULL,
  `designation` int(1) NOT NULL DEFAULT '0',
  `gender` varchar(1) NOT NULL,
  `address` varchar(500) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `special` varchar(500) DEFAULT NULL,
  `note` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`,`userName`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table mcms.user: 3 rows
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `userName`, `password`, `name`, `designation`, `gender`, `address`, `phone`, `special`, `note`) VALUES
	(1, 'admin', '1234', 'Admin Admin', 0, 'M', 'address', '0123456789', 'admin', 'admin'),
	(3, 'testDoc', '1234', 'Doctor Test', 1, 'M', 'fghj', '4477889955', 'kk', 'll'),
	(4, 'recipt1', '1234', 'Test Recipt', 2, 'F', 'df', '0710347725', 'vfv', 'gg');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
