-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 02, 2012 at 06:12 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iso`
--

-- --------------------------------------------------------

--
-- Table structure for table `discussions`
--

CREATE TABLE IF NOT EXISTS `discussions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupId` int(10) unsigned DEFAULT NULL,
  `userId` int(10) unsigned DEFAULT NULL,
  `message` varchar(2000) DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_discussions` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `discussions`
--

INSERT INTO `discussions` (`id`, `groupId`, `userId`, `message`, `added`) VALUES
(9, 3, 8, 'abc', '2012-05-24 12:44:31'),
(11, 3, 8, 'asdf asdf asf asdfas fasdf asdf asdf asfd asdf asfd asdf asdf as fdas dfasd fasd fasdfas fasdf asfd as fas fasf asf asf \r\nsd fas afsdf asdf asdf asdf as fas fasf', '2012-05-24 12:48:39'),
(13, 3, 8, 'asdfasdf asdfa sd', '2012-05-24 12:54:30'),
(14, 6, 13, 'Do you think period for summer vacation should be long?', '2012-05-24 01:15:53'),
(19, 7, 13, 'they will benefit', '2012-05-24 01:55:14'),
(20, 7, 15, 'ges', '2012-05-24 02:57:42'),
(21, 7, 11, 'not', '2012-05-24 02:59:05'),
(23, 8, 11, 'salam', '2012-05-25 05:18:30'),
(24, 8, 15, 'w/salam sir', '2012-05-25 05:19:03'),
(25, 8, 15, 'are you ready for summer vecations?', '2012-05-25 05:19:59'),
(26, 8, 17, 'sir i think we should arrange some sort of group activity during summers', '2012-05-25 08:26:17'),
(27, 8, 11, 'i think', '2012-05-25 03:59:22'),
(28, 8, 11, 'if we arrange any new type of functionalu\r\n', '2012-05-31 08:11:20'),
(29, 8, 15, 'no sir its \r\n', '2012-06-02 05:39:30');

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE IF NOT EXISTS `friendships` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fromId` int(10) unsigned DEFAULT NULL,
  `toId` int(10) unsigned DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `status` enum('Pending','Approved','Disapproved') DEFAULT 'Pending',
  `message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

--
-- Dumping data for table `friendships`
--

INSERT INTO `friendships` (`id`, `fromId`, `toId`, `added`, `status`, `message`) VALUES
(11, 8, 13, '2012-05-15 00:00:00', 'Approved', 'a'),
(20, 15, 8, '2012-05-20 00:00:00', 'Approved', 'slam'),
(21, 11, 15, '2012-05-25 05:15:57', 'Approved', ''),
(22, 17, 11, '2012-05-25 08:21:56', 'Approved', 'slam sir, i m ur student of year 3'),
(23, 8, 17, '2012-05-25 08:40:12', 'Approved', 'hi here is badar'),
(24, 8, 11, '2012-05-29 06:32:00', 'Approved', 'asalamo alikum\r\n'),
(25, 18, 11, '2012-05-29 07:27:12', 'Approved', 'slam sir, i am your student'),
(26, 18, 8, '2012-05-29 07:27:49', 'Approved', 'hi, its me, iftikhar Rasool'),
(27, 18, 15, '2012-05-29 07:28:17', 'Pending', 'hi, i am your class fellow'),
(28, 18, 16, '2012-05-29 07:29:12', 'Pending', 'hi can you add me to your friends'),
(29, 18, 17, '2012-05-29 07:29:56', 'Approved', 'hi im ifti'),
(30, 18, 13, '2012-05-29 07:30:24', 'Approved', 'slam sir, i am your student'),
(31, 19, 15, '2012-05-29 07:37:09', 'Pending', 'slam bhai jan'),
(32, 19, 8, '2012-05-29 07:37:27', 'Approved', 'slam bhai jan'),
(33, 19, 16, '2012-05-29 07:37:40', 'Pending', 'slam bhai jan'),
(34, 19, 11, '2012-05-29 07:37:55', 'Pending', 'slam sir\r\n'),
(35, 19, 18, '2012-05-29 07:39:03', 'Approved', 'slam bhai jan'),
(36, 19, 17, '2012-05-29 07:39:24', 'Approved', 'slam bhai jan'),
(37, 19, 13, '2012-05-29 07:39:47', 'Approved', 'slam sir'),
(38, 20, 19, '2012-05-29 07:42:03', 'Approved', 'slam bhai jan'),
(39, 20, 15, '2012-05-29 07:42:13', 'Approved', 'slam bhai jan'),
(40, 20, 16, '2012-05-29 07:42:25', 'Pending', 'slam bhai jan'),
(41, 20, 11, '2012-05-29 07:42:43', 'Pending', 'slam sir'),
(42, 20, 18, '2012-05-29 07:42:59', 'Pending', 'slam bhai jan'),
(43, 20, 17, '2012-05-29 07:43:14', 'Approved', 'slam bhai jan'),
(44, 20, 13, '2012-05-29 07:43:38', 'Approved', 'slam sir\r\n'),
(45, 21, 19, '2012-05-29 07:49:30', 'Approved', 'slam bhai jan'),
(46, 21, 15, '2012-05-29 07:49:45', 'Approved', 'slam bhai jan\r\n'),
(47, 21, 8, '2012-05-29 07:49:57', 'Approved', 'slam bhai jan'),
(48, 21, 16, '2012-05-29 07:50:08', 'Pending', 'slam bhai jan'),
(49, 21, 11, '2012-05-29 07:50:21', 'Pending', 'slam sir\r\n'),
(50, 21, 18, '2012-05-29 07:50:37', 'Pending', 'slam bhai jan'),
(51, 21, 17, '2012-05-29 07:50:57', 'Approved', 'slam bhai jan'),
(52, 21, 13, '2012-05-29 07:51:23', 'Approved', 'slam sir\r\n'),
(53, 22, 19, '2012-05-29 07:53:34', 'Approved', 'slam bhai jan'),
(54, 22, 15, '2012-05-29 07:53:48', 'Approved', 'slam bhai jan\r\n'),
(55, 22, 8, '2012-05-29 07:54:00', 'Approved', 'slam bhai jan'),
(56, 22, 16, '2012-05-29 07:54:13', 'Pending', 'slam bhai jan'),
(57, 22, 11, '2012-05-29 07:54:27', 'Pending', 'slam '),
(58, 22, 18, '2012-05-29 07:54:48', 'Pending', 'slam bhai jan'),
(59, 22, 17, '2012-05-29 07:55:03', 'Approved', 'slam bhai jan'),
(60, 22, 20, '2012-05-29 07:55:11', 'Pending', 'slam bhai jan'),
(61, 22, 21, '2012-05-29 07:55:22', 'Pending', 'slam bhai jan'),
(62, 22, 13, '2012-05-29 07:55:54', 'Approved', 'slam\r\n'),
(63, 23, 19, '2012-05-29 07:57:13', 'Approved', 'slam bhai jan\r\n'),
(64, 23, 15, '2012-05-29 07:57:24', 'Approved', 'slam bhai jan'),
(65, 23, 8, '2012-05-29 07:57:37', 'Approved', 'slam bhai jan'),
(66, 23, 16, '2012-05-29 07:57:51', 'Pending', 'slam bhai jan'),
(67, 23, 11, '2012-05-29 07:58:06', 'Pending', 'slam'),
(68, 23, 22, '2012-05-29 07:58:23', 'Approved', 'slam bhai jan'),
(69, 23, 18, '2012-05-29 07:59:01', 'Pending', 'slam bhai jan'),
(70, 23, 17, '2012-05-29 07:59:17', 'Approved', 'slam bhai jan'),
(71, 23, 20, '2012-05-29 07:59:36', 'Pending', 'slam bhai jan'),
(72, 23, 13, '2012-05-29 07:59:47', 'Approved', 'slam bhai jan'),
(73, 23, 21, '2012-05-29 07:59:52', 'Pending', 'slam bhai jan'),
(74, 25, 19, '2012-05-30 10:16:54', 'Approved', ''),
(75, 25, 15, '2012-05-30 10:17:03', 'Approved', ''),
(76, 25, 8, '2012-05-30 10:17:13', 'Approved', ''),
(77, 25, 16, '2012-05-30 10:17:25', 'Pending', ''),
(78, 25, 11, '2012-05-30 10:17:33', 'Pending', ''),
(79, 25, 22, '2012-05-30 10:17:43', 'Pending', ''),
(80, 25, 18, '2012-05-30 10:18:01', 'Pending', ''),
(81, 25, 17, '2012-05-30 10:18:21', 'Approved', ''),
(82, 25, 20, '2012-05-30 10:18:25', 'Pending', ''),
(83, 25, 13, '2012-05-30 10:18:33', 'Pending', ''),
(84, 25, 21, '2012-05-30 10:18:36', 'Pending', ''),
(85, 25, 23, '2012-05-30 10:18:52', 'Approved', ''),
(86, 25, 24, '2012-05-30 10:19:07', 'Pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `groupmembers`
--

CREATE TABLE IF NOT EXISTS `groupmembers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupId` int(10) unsigned DEFAULT NULL,
  `memberId` int(10) unsigned DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `status` enum('Pending','Active') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_groupmembers` (`groupId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `groupmembers`
--

INSERT INTO `groupmembers` (`id`, `groupId`, `memberId`, `message`, `added`, `status`) VALUES
(1, 7, 11, NULL, '2012-05-20 00:00:00', 'Active'),
(2, 7, 15, NULL, '2012-05-20 00:00:00', 'Active'),
(9, 6, 15, '56', '2012-05-24 22:02:00', 'Active'),
(10, 8, 15, '', '2012-05-24 22:14:39', 'Active'),
(11, 8, 17, 'sir i think we should arrange some sort of activity or workshop of php', '2012-05-25 01:23:22', 'Active'),
(12, 6, 20, '', '2012-05-29 00:43:53', 'Active'),
(13, 7, 20, '', '2012-05-29 00:44:06', 'Active'),
(14, 8, 20, '', '2012-05-29 00:44:16', 'Pending'),
(15, 6, 18, '', '2012-05-29 00:46:30', 'Active'),
(16, 7, 18, 'definitely they will benefit the students', '2012-05-29 00:47:27', 'Pending'),
(17, 8, 18, '', '2012-05-29 00:47:46', 'Pending'),
(18, 6, 24, '', '2012-05-29 01:02:41', 'Active'),
(19, 7, 24, '', '2012-05-29 01:02:48', 'Pending'),
(20, 8, 24, '', '2012-05-29 01:02:54', 'Pending'),
(21, 6, 8, '', '2012-05-29 01:04:12', 'Active'),
(22, 8, 8, '', '2012-05-29 01:04:26', 'Pending'),
(23, 7, 8, '', '2012-05-29 01:04:33', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `detail` varchar(2000) DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `status` enum('Active','Close') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_groups` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `userId`, `name`, `detail`, `added`, `status`) VALUES
(6, 13, 'Summer Vacation Activities', 'We will discuss here summer vacation acitivites for out school / cholleges in namal valley.', '2012-05-24 00:00:00', 'Active'),
(7, 13, 'Free books for poor students', 'Will students benefit from free books?', '2012-05-24 00:00:00', 'Active'),
(8, 11, 'summer group', 'view about the summer vacation for the student of namal college mianwali ', '2012-05-25 00:00:00', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `klasses`
--

CREATE TABLE IF NOT EXISTS `klasses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `klasses`
--

INSERT INTO `klasses` (`id`, `name`) VALUES
(1, 'One'),
(2, 'Two'),
(3, 'Three'),
(4, 'Four'),
(5, 'Five'),
(6, 'Six'),
(7, 'Seven'),
(8, 'Eight'),
(9, 'Nine'),
(10, 'Ten'),
(11, '1st Year'),
(12, '2nd Year');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resource` varchar(100) DEFAULT NULL,
  `rolId` int(10) unsigned DEFAULT NULL,
  `ownerAccess` enum('Yes','No') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_permissions` (`rolId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=503 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `resource`, `rolId`, `ownerAccess`) VALUES
(1, 'Add Member', 1, ''),
(2, 'Edit Profile', 1, 'Yes'),
(3, 'Delete Profile', 1, 'Yes'),
(4, 'View Members', 1, ''),
(5, 'Search Members', 2, ''),
(101, 'View Permissions', 1, ''),
(102, 'Edit Permission', 1, ''),
(201, 'Add Friends', 2, ''),
(301, 'Can Post', 2, ''),
(401, 'Apply Scholarship', 3, NULL),
(402, 'Manage Scholarships', 1, NULL),
(501, 'Start Group', 4, NULL),
(502, 'Join Group', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usrId` int(10) unsigned DEFAULT NULL,
  `category` enum('text','image','video') DEFAULT NULL,
  `content` varchar(2000) DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_posts` (`usrId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `usrId`, `category`, `content`, `added`) VALUES
(65, 13, 'text', 'i am a teacher', '2012-05-24 01:11:42'),
(66, 8, 'text', 'good morning every body', '2012-05-30 11:04:08'),
(67, 23, 'text', 'good morning too badar bhai', '2012-05-30 11:08:22'),
(68, 8, 'text', 'today is my presentation dears, pray for me\r\n', '2012-05-31 06:08:26'),
(69, 19, 'text', 'praying for your presentation', '2012-05-31 08:23:59'),
(70, 11, 'text', 'hjhkj\r\n', '2012-06-02 05:41:26'),
(71, 15, 'text', 'hhhhhh', '2012-06-02 05:47:52');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Member'),
(3, 'Student'),
(4, 'Teacher');

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE IF NOT EXISTS `scholarships` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usrId` int(11) unsigned DEFAULT NULL,
  `fatherName` varchar(50) DEFAULT NULL,
  `guardianName` varchar(50) DEFAULT NULL,
  `guardianOccupation` varchar(50) DEFAULT NULL,
  `guardianSalary` int(11) DEFAULT NULL,
  `guardianPhone` int(11) DEFAULT NULL,
  `dependentFamilyMembers` int(11) DEFAULT NULL,
  `KlsId` int(10) unsigned DEFAULT NULL,
  `schoolName` varchar(100) DEFAULT NULL,
  `lastExam` varchar(20) DEFAULT NULL,
  `resultPercentage` float DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_scholarships` (`usrId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `scholarships`
--

INSERT INTO `scholarships` (`id`, `usrId`, `fatherName`, `guardianName`, `guardianOccupation`, `guardianSalary`, `guardianPhone`, `dependentFamilyMembers`, `KlsId`, `schoolName`, `lastExam`, `resultPercentage`, `added`, `status`) VALUES
(2, 15, 'Fateh Muhammad', 'Fateh Muhammad', 'Teacher', 9000, 2147483647, 5, 11, 'Global Science College', 'Annual', 83, '2012-05-29 00:00:00', 'Approved'),
(4, 18, 'Taj Rasool', 'Taj Rasool', 'Driver', 3000, 2147483647, 6, 11, 'Al fatima school', 'Sendup-Test', 89, '2012-05-31 00:00:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT 'Male',
  `dob` date DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(10) DEFAULT NULL,
  `password` varchar(15) DEFAULT NULL,
  `rolId` int(10) unsigned DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `seen` datetime DEFAULT NULL,
  `status` enum('Active','Pending','Disable') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_users` (`rolId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `dob`, `image`, `email`, `username`, `password`, `rolId`, `added`, `seen`, `status`) VALUES
(8, 'Badar', 'Male', '1991-01-18', 'badar_3.jpg', 'badar@gmail.com', 'badar', '123*', 1, '2012-05-10 00:00:00', '2012-06-02 00:00:00', 'Active'),
(11, 'Dr Noman Javed', 'Male', '1988-04-04', 'noman.jpg', 'noman@gmail.com', 'noman', '123*', 4, '2012-05-12 00:00:00', '2012-06-02 00:00:00', 'Active'),
(13, 'zameer nawaz', 'Male', '1988-04-04', 'zameer nawaz.jpg', 'zameer@gmail.com', 'zameer', '123*', 4, '2012-05-15 00:00:00', '2012-05-30 00:00:00', 'Active'),
(15, 'asadullah', 'Male', '1988-04-04', 'asadullah.jpg', 'badar_ma@yahoo.com', 'asadullah', '123*', 3, '2012-05-20 00:00:00', '2012-06-02 00:00:00', 'Active'),
(16, 'dost', 'Male', '1980-05-01', 'dost.jpg', 'dost@hotmail.com', 'dost', '123*', 2, '2012-05-25 00:00:00', '2012-05-31 00:00:00', 'Active'),
(17, 'mudassir', 'Male', '1989-08-14', 'mudassir.jpg', 'mudassir.569@hotmail.com', 'mudassir', '123*', 3, '2012-05-25 00:00:00', '2012-05-30 00:00:00', 'Active'),
(18, 'iftikhar', 'Male', '1989-08-14', 'iftikhar.jpg', 'iftikhar@gmail.com', 'iftikhar', '123*', 3, '2012-05-29 00:00:00', '2012-05-31 00:00:00', 'Active'),
(19, 'abid', 'Male', '1989-08-14', 'abid.jpg', 'abid@gmail.com', 'abid', '123*', 3, '2012-05-29 00:00:00', '2012-05-31 00:00:00', 'Active'),
(20, 'Tariq Majeed', 'Male', '1989-08-14', 'tariq majeed copy.jpg', 'tariq@yahoo.com', 'tariq', '123*', 3, '2012-05-29 00:00:00', '2012-05-30 00:00:00', 'Active'),
(21, 'Noor', 'Male', '1989-08-14', 'download (1).jpg', 'noor@gmail.com', 'noor', '123*', 2, '2012-05-29 00:00:00', '2012-05-29 00:00:00', 'Active'),
(22, 'Gulzar', 'Male', '1989-08-14', 'charity1.jpg', 'gulzar@gmail.com', 'gulzar', '123*', 2, '2012-05-29 00:00:00', '2012-05-30 00:00:00', 'Active'),
(23, 'saad', 'Male', '1989-10-10', 'saad.jpg', 'saad2010@namal.edu.pk', 'saad', '123*', 2, '2012-05-29 00:00:00', '2012-05-30 00:00:00', 'Active'),
(24, 'ummar', 'Male', '1989-08-14', 'dfssd.jpg', 'ummar@gmail.com', 'ummar', '123*', 3, '2012-05-29 00:00:00', '2012-05-29 00:00:00', 'Active'),
(25, 'malaeka', 'Female', '2005-08-14', 'malaeka.jpg', 'malaeka@gmail.com', 'malaeka', '123*', 3, '2012-05-30 00:00:00', '2012-05-30 00:00:00', 'Active'),
(26, 'Shafqat Shehzad', 'Male', '1980-05-01', 'shehzad.jpg', 'shehzad@gmail.com', 'shehzad', '123*', 4, '2012-05-30 00:00:00', '2012-05-30 00:00:00', 'Active'),
(27, 'awais', 'Male', '2013-05-01', 'adsfsa.jpg', 'awais.math@live.com', 'awais', '123*', 2, '2012-05-31 00:00:00', '2012-05-31 00:00:00', 'Active');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `discussions`
--
ALTER TABLE `discussions`
  ADD CONSTRAINT `FK_discussions` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `groupmembers`
--
ALTER TABLE `groupmembers`
  ADD CONSTRAINT `FK_groupmembers` FOREIGN KEY (`groupId`) REFERENCES `groups` (`id`);

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `FK_groups` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `FK_permissions` FOREIGN KEY (`rolId`) REFERENCES `roles` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_posts` FOREIGN KEY (`usrId`) REFERENCES `users` (`id`);

--
-- Constraints for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD CONSTRAINT `FK_scholarships` FOREIGN KEY (`usrId`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users` FOREIGN KEY (`rolId`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
