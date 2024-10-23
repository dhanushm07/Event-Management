-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 22, 2024 at 12:48 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `eventhistory`
--

DROP TABLE IF EXISTS `eventhistory`;
CREATE TABLE IF NOT EXISTS `eventhistory` (
  `Event` varchar(250) NOT NULL,
  `price` int(150) NOT NULL,
  `Date` date NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UID` int(11) NOT NULL,
  `register_deleted_status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `UID` (`UID`)
) ENGINE=InnoDB AUTO_INCREMENT=230 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eventhistory`
--

INSERT INTO `eventhistory` (`Event`, `price`, `Date`, `ID`, `UID`, `register_deleted_status`) VALUES
('game', 75, '2024-09-08', 1, 88, 0),
('meetup', 100, '2024-09-08', 2, 89, 0),
('listen', 50, '2024-08-25', 3, 89, 0),
('meetup', 100, '2024-08-25', 4, 89, 0),
('game', 75, '2024-08-25', 10, 52, 0),
('meetup', 100, '2024-08-31', 13, 4, 0),
('game', 75, '2024-09-29', 17, 4, 0),
('meetup', 100, '2024-09-29', 18, 5, 0),
('game', 75, '2024-09-08', 19, 6, 0),
('game', 75, '2024-08-25', 20, 7, 0),
('food', 25, '2024-08-18', 22, 9, 0),
('meetup', 100, '2024-09-08', 24, 11, 1),
('game', 75, '2024-08-11', 25, 12, 0),
('food', 25, '2024-08-11', 26, 13, 0),
('game', 75, '2024-08-25', 27, 14, 0),
('food', 25, '2024-09-01', 29, 17, 0),
('listen', 50, '2024-08-25', 30, 18, 0),
('meetup', 100, '2024-08-25', 31, 19, 0),
('listen', 50, '2024-08-31', 32, 20, 0),
('game', 75, '2024-08-24', 33, 21, 0),
('game', 75, '2024-08-24', 34, 22, 0),
('meetup', 100, '2024-08-24', 35, 23, 0),
('meetup', 100, '2024-08-25', 36, 24, 0),
('meetup', 100, '2024-08-25', 38, 26, 0),
('meetup', 100, '2024-09-01', 42, 30, 0),
('food', 25, '2024-09-15', 43, 31, 0),
('listen', 50, '2024-08-18', 44, 32, 1),
('food', 75, '2024-09-08', 45, 33, 0),
('listen', 50, '2024-08-17', 46, 34, 0),
('listen', 50, '2024-07-20', 47, 35, 1),
('food', 25, '2024-08-24', 48, 36, 0),
('game', 75, '2024-08-25', 49, 37, 0),
('food', 25, '2024-08-18', 50, 39, 0),
('meetup', 100, '2024-08-31', 51, 40, 0),
('listen', 50, '2024-08-31', 52, 41, 0),
('game', 75, '2024-08-18', 53, 42, 0),
('game', 75, '2024-09-08', 54, 43, 0),
('food', 25, '2024-09-28', 55, 44, 0),
('meetup', 100, '2024-09-21', 56, 45, 0),
('listen', 50, '2024-08-25', 57, 46, 0),
('game', 75, '2024-10-26', 58, 47, 0),
('food', 25, '2024-09-21', 59, 48, 0),
('meetup', 100, '2024-09-21', 60, 49, 0),
('food', 25, '2024-09-01', 61, 50, 1),
('listen', 50, '2024-08-25', 62, 51, 0),
('food', 25, '2024-09-29', 63, 52, 0),
('food', 25, '2024-10-06', 65, 54, 0),
('food', 25, '2024-09-08', 67, 56, 0),
('food', 25, '2024-08-11', 68, 57, 0),
('meetup', 100, '2024-09-08', 69, 58, 0),
('food', 25, '2024-09-08', 70, 59, 0),
('food', 25, '2024-09-01', 72, 61, 0),
('game', 75, '2024-08-25', 73, 62, 0),
('game', 75, '2024-09-01', 74, 63, 0),
('meetup', 100, '2024-09-08', 75, 64, 0),
('meetup', 100, '2024-09-08', 76, 65, 0),
('listen', 50, '2024-08-31', 77, 66, 0),
('meetup', 100, '2024-09-08', 78, 67, 0),
('meetup', 100, '2024-09-08', 79, 68, 0),
('game', 75, '2024-09-08', 81, 70, 0),
('meetup', 100, '2024-09-08', 82, 71, 0),
('game', 75, '2024-08-31', 83, 72, 0),
('meetup', 100, '2024-09-08', 84, 73, 0),
('food', 25, '2024-09-01', 85, 74, 0),
('game', 75, '2024-09-08', 87, 76, 0),
('game', 75, '2024-09-15', 89, 78, 0),
('game', 75, '2024-09-15', 90, 79, 0),
('game', 75, '2024-09-15', 91, 80, 0),
('game', 75, '2024-08-25', 92, 81, 0),
('game', 75, '2024-09-08', 93, 82, 0),
('food', 50, '2024-09-01', 147, 5, 0),
('game', 45, '2024-08-25', 148, 3, 0),
('listen', 50, '2024-08-25', 150, 91, 0),
('meetup', 100, '2024-08-25', 152, 17, 0),
('game', 75, '2024-08-31', 153, 17, 0),
('food', 25, '2024-09-29', 155, 8, 1),
('game', 70, '2024-09-07', 156, 8, 1),
('food', 25, '2024-09-01', 158, 53, 1),
('game', 75, '2024-09-01', 159, 53, 1),
('food', 25, '2024-09-22', 160, 53, 1),
('game', 75, '2024-09-01', 162, 15, 0),
('listen', 50, '2024-08-11', 163, 55, 0),
('game', 75, '2024-08-11', 167, 25, 0),
('food', 25, '2024-09-08', 168, 77, 0),
('game', 75, '2024-09-29', 169, 32, 1),
('meetup', 100, '2024-09-29', 170, 75, 0),
('listen', 50, '2024-08-31', 180, 29, 0),
('food', 25, '2024-09-22', 181, 92, 0),
('food', 25, '2024-09-08', 182, 92, 0),
('meetup', 100, '2024-09-29', 183, 10, 0),
('game', 75, '2024-09-01', 195, 93, 0),
('listen', 50, '2024-09-29', 196, 69, 0),
('game', 75, '2024-08-31', 197, 69, 0),
('game', 75, '2024-08-31', 198, 94, 0),
('meetup', 100, '2024-08-31', 199, 10, 0),
('listen', 50, '2024-08-31', 200, 10, 0),
('game', 75, '2024-08-24', 201, 10, 0),
('game', 75, '2024-10-06', 202, 10, 0),
('game', 75, '2024-09-08', 203, 10, 0),
('game', 75, '2024-09-29', 204, 10, 0),
('game', 75, '2024-09-07', 205, 60, 0),
('game', 75, '2024-08-18', 206, 60, 0),
('listen', 50, '2024-09-01', 207, 60, 0),
('meetup', 100, '2024-09-29', 208, 27, 0),
('food', 75, '2024-09-07', 209, 27, 0),
('game', 75, '2024-09-01', 210, 1, 0),
('food', 25, '2024-09-14', 211, 1, 0),
('food', 25, '2024-08-11', 212, 1, 0),
('listen', 50, '2024-09-14', 213, 1, 0),
('game', 75, '2024-09-14', 214, 1, 0),
('meetup', 100, '2024-09-14', 215, 1, 0),
('game', 75, '2024-08-31', 216, 1, 0),
('meetup', 100, '2024-09-07', 217, 1, 0),
('listen', 50, '2024-09-15', 218, 1, 0),
('meetup', 100, '2024-09-08', 219, 25, 0),
('meetup', 100, '2024-08-24', 220, 19, 0),
('food', 25, '2024-08-24', 221, 19, 0),
('game', 75, '2024-09-22', 222, 19, 0),
('game', 75, '2024-09-01', 223, 19, 0),
('food', 25, '2024-09-29', 224, 40, 0),
('meetup', 100, '2024-10-27', 228, 28, 1),
('game', 75, '2024-08-11', 229, 16, 0);

--
-- Triggers `eventhistory`
--
DROP TRIGGER IF EXISTS `update_event_count_after_insert`;
DELIMITER $$
CREATE TRIGGER `update_event_count_after_insert` AFTER INSERT ON `eventhistory` FOR EACH ROW BEGIN
  INSERT INTO event_count (Date, listen, meetup, game, food)
  VALUES (
    NEW.Date,
    (SELECT COUNT(*) FROM eventhistory WHERE Event = 'listen' AND Date = NEW.Date),
    (SELECT COUNT(*) FROM eventhistory WHERE Event = 'meetup' AND Date = NEW.Date),
    (SELECT COUNT(*) FROM eventhistory WHERE Event = 'game' AND Date = NEW.Date),
    (SELECT COUNT(*) FROM eventhistory WHERE Event = 'food' AND Date = NEW.Date)
  )
  ON DUPLICATE KEY UPDATE
    listen = VALUES(listen),
    meetup = VALUES(meetup),
    game = VALUES(game),
    food = VALUES(food);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `event_count`
--

DROP TABLE IF EXISTS `event_count`;
CREATE TABLE IF NOT EXISTS `event_count` (
  `Date` date NOT NULL,
  `listen` int(11) DEFAULT '0',
  `meetup` int(11) DEFAULT '0',
  `game` int(11) DEFAULT '0',
  `food` int(11) DEFAULT '0',
  PRIMARY KEY (`Date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_count`
--

INSERT INTO `event_count` (`Date`, `listen`, `meetup`, `game`, `food`) VALUES
('2024-07-20', 1, 0, 0, 0),
('2024-08-11', 1, 0, 3, 3),
('2024-08-17', 1, 0, 0, 0),
('2024-08-18', 1, 0, 2, 2),
('2024-08-24', 0, 2, 3, 3),
('2024-08-25', 5, 5, 7, 0),
('2024-08-31', 5, 3, 5, 0),
('2024-09-01', 1, 1, 7, 6),
('2024-09-07', 0, 1, 2, 1),
('2024-09-08', 0, 11, 7, 5),
('2024-09-14', 1, 1, 1, 1),
('2024-09-15', 1, 0, 3, 1),
('2024-09-21', 0, 2, 0, 1),
('2024-09-22', 0, 0, 2, 2),
('2024-09-28', 0, 0, 0, 1),
('2024-09-29', 1, 4, 3, 4),
('2024-10-06', 0, 0, 1, 1),
('2024-10-26', 0, 0, 1, 0),
('2024-10-27', 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `Username` varchar(250) NOT NULL,
  `Password` varchar(250) NOT NULL,
  `Eid` int(150) NOT NULL,
  KEY `Eid` (`Eid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`Username`, `Password`, `Eid`) VALUES
('USER1', 'pass1', 1),
('USER2', 'pass2', 2),
('USER3', 'pass3', 3),
('USER4', 'pass4', 4),
('USER5', 'pass5', 6),
('USER7', 'user7', 7),
('DHANUSHM', 'dhanush', 8),
('VIJAYJ', 'vijay', 9),
('SURYA', 'surya', 10),
('vikram', 'vikram', 11),
('samitha', 'samitha', 12),
('PRIYANKA', 'priyanka', 13),
('gokila', 'gokila', 14),
('RAMESWH', 'ramesh', 15),
('GOKULAN', 'gokulan', 16),
('KUMAAR', 'kumar', 17),
('VINITHA', 'vinitha', 18),
('ARUN', 'arun', 19),
('RAJINI', 'rajini', 20),
('KARMEGAM', 'karmega', 21),
('GURUM', 'guru', 23),
('NEWUSER', 'passnew', 24),
('admin', 'admin', 25),
('Murugesan', 'muru', 26),
('Kabilan', 'kabi', 27),
('AArthi', 'aarthi', 28),
('Malathi', 'malathi', 29),
('jana', 'jana', 30),
('mohan', 'mohan', 31),
('ganesh', 'ganesh', 32),
('aarthi', 'aarthi', 28),
('aarthi', 'aarthi', 28),
('aaarthiik', 'aaaa', 53),
('newthing', 'newthing', 54),
('sundari', 'sundari', 33),
('vani', 'vani', 34),
('balu', 'balu', 35),
('manor', 'manor', 36),
('robert', 'robert', 37),
('ranjini', 'rajini', 38),
('garan', 'garan', 39),
('kanama', 'kanama', 40),
('kadhar', 'kadhar', 41),
('mathi', 'mathi', 42),
('rajaa', 'rajaa', 43),
('ramyaa', 'ramyaa', 44),
('yamini', 'yamini', 45),
('shanthanu', 'shanthnu', 46),
('vasanth', 'vasanth', 47),
('manas', 'mans', 48),
('karthika', 'karthika', 49),
('ravi', 'chnadran', 50),
('umeraah', 'umeraah', 51),
('navith', 'navith', 52),
('aarthim', 'muruganaar', 53),
('newthin', 'thinsnew', 54),
('hjhjvj v', '1234', 55),
('gfdhd', 'asdf', 56),
('sara', 'new', 57),
('kumaresan', 'kumar', 58),
('vaithishwari', 'vaithishwari', 59),
('ANUPRIYA', 'anupriya', 60),
('RAJINIKAn', 'Rajini@1234', 61),
('CHANDRU', 'Chandru@123', 62),
('Karthick', 'Pass@12345', 63),
('Krishnan', 'Krishnan@1234', 64),
('Varun', 'Varun@123', 65),
('kkkk', 'Pass@123', 66),
('paneer', 'Paneer@1234', 67),
('yuvaraj', 'Yuvaraj@123', 68),
('SANGAMI', 'Sangami@123', 70),
('SASMITHA', 'SASMITHA@123', 71),
('UDHAYASURIYAN', 'Udhaya@123', 73),
('PRIYANKA77', 'Priyanka@77', 74),
('KAVIYA', 'Kaviya@123', 75),
('SRINIHIL', 'Sri@12345', 76),
('DHANUSH', 'Dhanush@123', 77),
('velunatchiyar', 'Natchiyar@123', 78),
('velunatchiyar', 'Natchiyar@123', 79),
('velunatchiyar', 'Natchiyar@123', 80),
('MADHUMITHA', '$2y$10$I/ausFy7C5kT6vhZSsmqwORkQGHlsX4o4Brppk8H6rfyOyVnHyS/G', 88),
('Vishnukanth', 'Vishnu@1234', 89),
('VENGADALAKSHMI', 'ABCD@1234', 90),
('SUNIL', 'Sunil@12345', 91),
('Shalini', 'Shalini@123', 92),
('MARTIN', 'Martin@12345', 93),
('Sneha', 'Sneha@1234', 94);

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

DROP TABLE IF EXISTS `register`;
CREATE TABLE IF NOT EXISTS `register` (
  `Name` varchar(250) NOT NULL,
  `Age` bigint(150) NOT NULL,
  `Gender` varchar(250) NOT NULL,
  `Phonenum` varchar(250) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`Name`, `Age`, `Gender`, `Phonenum`, `Email`, `Id`, `deleted`) VALUES
('Rajini', 16, 'female', '4578965435', 'dhanushpanruti2003@gmail.com', 1, 0),
('peron', 22, 'female', '7540046765', 'people2@gmail.com', 2, 0),
('pradheepranganathan', 24, 'male', '8428949209', 'people3@gmail.com', 3, 0),
('people', 26, 'other', '8012765434', 'people4@gmail.com', 4, 0),
('karpagavalli', 26, 'female', '8012765434', 'people4@gmail.com', 5, 0),
('ramachandran s k r', 26, 'male', '7645389097', 'people5@gmail.com', 6, 0),
('people', 25, 'female', '8076875434', 'people6@gmail.com', 7, 0),
('dhanushmuruga', 24, 'male', '8012764478', 'dhanush@gmail.com', 8, 1),
('Vijay', 31, 'male', '9877537889', 'joseph@gmail.com', 9, 0),
('Surya', 26, 'male', '6570756453', 'surya@gmail.com', 10, 0),
('vikram', 45, 'female', '7890978764', 'vikram@655', 11, 1),
('samitha', 31, 'female', '9898677654', 'samitha@gmail.com', 12, 0),
('priyanka', 45, 'female', '988754653', 'priyanka@12321', 13, 0),
('gokila', 26, 'female', '9788745765', 'gokila@gmail.com', 14, 0),
('ramesh', 35, 'male', '8768754238', 'ramesh@gmail.com', 15, 0),
('gokulan', 35, 'male', '986564323', 'gokulan@gmail.com', 16, 0),
('Kumar', 45, 'male', '8768790806', 'kumar@7657', 17, 0),
('vinitha', 28, 'female', '90876476436', 'vinitha@gmail.com', 18, 0),
('arun', 26, 'male', '899876565', 'arun@1243', 19, 0),
('Rajini', 58, 'male', '988776443', 'super@134', 20, 0),
('karmegam', 19, 'female', '980563453', 'karmega@27647', 21, 0),
('karmegam', 19, 'female', '980563453', 'karmega@27647', 22, 0),
('Gurumoorthy', 28, 'male', '98985663', 'gurumoorthy@12445', 23, 0),
('newuser', 25, 'male', '796874654', 'newuser@gmail', 24, 0),
('admin', 35, 'male', '00000000000000000', 'dhanushmpanruti@gmail.com', 25, 0),
('Murugasen', 25, 'male', '87587744', 'murugesan2gmail', 26, 0),
('kabilan', 45, 'male', '986755434', 'kabilan@53', 27, 0),
('aarthi', 45, 'female', '5547547687', 'aarthi@123gmail.com', 28, 1),
('malathi', 24, 'female', '4654876883', 'malathit020@gmail.com', 29, 0),
('janagapriyan', 35, 'male', '65477875234', 'janga276446@hg.com', 30, 0),
('mohanapriya', 17, 'female', '4768789863', 'priya@mohana.com', 31, 0),
('ganeshkumar', 31, 'male', '354687354', 'ganesh@gmail.com', 32, 1),
('rajasundhari', 45, 'female', '7643451747', 'sundahri@hjf.com', 33, 0),
('kalaivani', 55, 'female', '6476451324', 'kali2gmail.com', 34, 0),
('balu', 32, 'male', '87535e765', 'balusir2h,mail.com', 35, 0),
('manoranjitham', 36, 'female', '657874353', 'monoranjitham@gmail.com', 36, 0),
('robert', 29, 'male', '3479875325', 'robert@gmail.copm', 37, 0),
('ranjinikanth', 45, 'female', '6547873144', 'ranjini@kjghg.com', 38, 0),
('manogaran', 45, 'male', '87543476', 'mano@gmail.com', 39, 0),
('kanamma', 39, 'female', '76465232376', 'kannama@gmail.com', 40, 0),
('kadharbasha', 28, 'male', '876534588', 'kaadar@gamil.com', 41, 0),
('ilamathi', 22, 'female', '8757454525', 'ilamathi@gmail.com', 42, 0),
('rajaa', 26, 'male', '6575563', 'rajaaa@gmail.com', 43, 0),
('ramya', 26, 'female', '875764989', 'ramya@gmail.com', 44, 0),
('yamini', 26, 'female', '6547878931', 'yamini@gmail.com', 45, 0),
('shanthanu', 36, 'male', '354768787', 'shanytahnu@gmail.com', 46, 0),
('vasanth', 20, 'male', '87576436367', 'vasanth@gmail.com', 47, 0),
('manas', 18, 'male', '654787834341', 'manasbiswal@gmail.com', 48, 0),
('karthikaa', 22, 'female', '687684343413', 'karthika@gmail.com', 49, 0),
('ravichandran', 45, 'male', '7685413543', 'ravi@gmail.com', 50, 1),
('umeraah', 27, 'female', '68768354654', 'umeraa@gmail.com', 51, 0),
('jaavith', 17, 'male', '57687754334', 'navith@gmail.com', 52, 0),
('aarthimurugan', 26, 'female', '547867641', 'aarthi@hkk', 53, 1),
('newthing', 31, 'male', '354654.1', 'new@gmail', 54, 0),
('Kasinathan', 24, 'male', '6570756453', 'kjhbkb@gmail.com', 55, 0),
('monishkumar', 45, 'male', '5646357856', 'monish@gmail', 56, 0),
('saravanan7', 45, 'male', '78987476548', 'saravanan89', 57, 0),
('kumaresanmoorthy', 45, 'male', '7869543215', 'kumarresan@gmail.com', 58, 0),
('Vaithishwari', 45, 'female', '789456127', 'vaithishwari@gmail.com', 59, 0),
('Anupriya', 35, 'female', '7548945678', 'anu@gmail.com', 60, 0),
('Rajini', 45, 'male', '6570756453', 'AFGDTE@gamial.com', 61, 0),
('Chandrukanth', 45, 'male', '7894561237', 'chandru@gmail.com', 62, 0),
('Karthickrahman', 25, 'male', '6570756453', 'kartick@gmail.com', 63, 0),
('Navaneethakrishnan', 45, 'male', '6570756453', 'abacd@123.com', 64, 0),
('Varun', 45, 'male', '7889456214', 'varun@gmail.com', 65, 0),
('Kamal', 17, 'male', '8888888888', 'abacd@123.com', 66, 0),
('Paneer', 53, 'male', '2589746135', 'Paneer@1234.com', 67, 0),
('Yuvaraj', 20, 'male', '9458796412', 'yuvaraj@gmail.com', 68, 0),
('sangami', 22, 'female', '6570756453', 'ssangami469@gmail.com', 69, 0),
('Sangami', 45, 'female', '7894561234', 'AFGDTE@gamial.com', 70, 0),
('sasmitha', 36, 'female', '7845129635', 'sas@gmail', 71, 0),
('Rajini', 25, 'male', '7894561234', 'abacddw@gmail.com', 72, 0),
('udhayasuriyan', 45, 'male', '6570756453', 'AFGDTE@gamial', 73, 0),
('Priyanka', 21, 'female', '4487985331', 'priyanka@123.com', 74, 0),
('Kaviya', 25, 'male', '7854982355', 'Kaviya@gmail.com', 75, 0),
('Srinihil', 31, 'male', '7894565287', 'sri@gmail.com', 76, 0),
('Dhanush', 21, 'male', '4875957445', 'dhanushmpanruti@gmail.com', 77, 0),
('VELUNATCHIYAR', 45, 'female', '8012765434', 'velunatchi@gmail.com', 78, 0),
('VELUNATCHIYAR', 45, 'female', '8012765434', 'velunatchi@gmail.com', 79, 0),
('VELUNATCHIYAR', 45, 'female', '8012765434', 'velunatchi@gmail.com', 80, 0),
('sundarapandiyan', 45, 'male', '4578965435', 'sundhara@gmail.com', 81, 0),
('Mohammad', 45, 'male', '4578965435', 'mohamad@gmail.com', 82, 0),
('subramani', 45, 'male', '8794545975', 'subramani@gmail.com', 83, 0),
('Subramani', 45, 'male', '5689754214', 'Sunran@gmail.com', 84, 0),
('Subramani', 45, 'male', '5689754214', 'Sunran@gmail.com', 85, 0),
('Subramani', 45, 'male', '5689754214', 'Sunran@gmail.com', 86, 0),
('Madhu', 21, 'female', '8789321454', 'madhiu@gmail.com', 87, 0),
('Madhumitha', 24, 'female', '7893326656', 'madhumitha@gmail.com', 88, 0),
('Vishnukanth', 26, 'male', '7833215545', 'vishnukanth@gmail.com', 89, 0),
('Vengadalakshmi', 31, 'female', '2226569871', 'vengadalakshmi@gmail.com', 90, 0),
('Sunil', 25, 'male', '4579613654', 'sunil@gmail.com', 91, 0),
('Shalini', 21, 'female', '5489765143', 'shalini@gmail.com', 92, 0),
('Martin', 30, 'male', '8214758548', 'martin123@gmail.com', 93, 0),
('Sneha Ravi', 20, 'female', '7895223213', 'sneha579845@gmail.com', 94, 0);

--
-- Triggers `register`
--
DROP TRIGGER IF EXISTS `update_eventhistory_deleted_status`;
DELIMITER $$
CREATE TRIGGER `update_eventhistory_deleted_status` AFTER UPDATE ON `register` FOR EACH ROW BEGIN
    -- Update `eventhistory` table based on changes in `register.deleted`
    IF OLD.deleted != NEW.deleted THEN
        UPDATE `eventhistory`
        SET `register_deleted_status` = NEW.deleted
        WHERE `UID` = OLD.Id;
    END IF;
END
$$
DELIMITER ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eventhistory`
--
ALTER TABLE `eventhistory`
  ADD CONSTRAINT `eventhistory_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `register` (`Id`);

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`Eid`) REFERENCES `register` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
