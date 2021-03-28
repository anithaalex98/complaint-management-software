-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 24, 2020 at 12:12 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(5) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(15) NOT NULL,
  `description` varchar(40) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `description`) VALUES
(1, 'Category 1', 'it is testing cat 1'),
(2, 'Category 2', 'it is testing cat 2'),
(3, 'Category 3', 'This a category for testing');

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

DROP TABLE IF EXISTS `complaint`;
CREATE TABLE IF NOT EXISTS `complaint` (
  `comp_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cat_id` int(5) NOT NULL,
  `sub_cat_id` int(5) DEFAULT NULL,
  `comp_type_id` int(5) NOT NULL,
  `complaint_title` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `screenshot` varchar(50) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(15) NOT NULL DEFAULT 'Waiting',
  `emp_id` int(11) DEFAULT NULL,
  `response` text,
  PRIMARY KEY (`comp_id`),
  KEY `user_id` (`user_id`),
  KEY `sub_cat_id` (`sub_cat_id`),
  KEY `comp_type_id` (`comp_type_id`),
  KEY `comp_cat_id` (`cat_id`) USING BTREE,
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`comp_id`, `user_id`, `cat_id`, `sub_cat_id`, `comp_type_id`, `complaint_title`, `description`, `screenshot`, `date`, `status`, `emp_id`, `response`) VALUES
(7, 5, 1, 2, 1, 'Test Complaint 1', 'This is a sample complaint description for the purpose of testing. Sample 1.', '', '2020-09-21 22:07:58', 'Assigned', 2, NULL),
(8, 5, 3, NULL, 2, 'Test Complaint 2', 'This is a sample complaint description for the purpose of testing. Sample 2.', '', '2020-09-21 22:08:14', 'Responded', NULL, 'This is a sample response for the purpose of testing.'),
(9, 5, 3, NULL, 3, 'Test Complaint 3', 'This is a sample complaint description for the purpose of testing. Sample 3.', '', '2020-09-21 22:22:29', 'Responded', NULL, 'This is a sample response (2) for the purpose of testing.'),
(10, 5, 2, 3, 1, 'Test Complaint 4', 'This is a sample complaint description for the purpose of testing. Sample 4.', 'index2.png', '2020-09-22 03:26:17', 'Submitted', NULL, NULL),
(11, 2, 3, NULL, 1, 'Test Complaint 5', 'Test complaint for testing. Sample 1 by customerA_123.', '', '2020-09-23 21:57:38', 'Submitted', NULL, NULL),
(12, 2, 2, 3, 4, 'Test Complaint 6', 'This is sample feedback for the purpose of testing. Test Complaint 6.', 'index3.jpg', '2020-09-24 17:38:22', 'Assigned', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `complaint_type`
--

DROP TABLE IF EXISTS `complaint_type`;
CREATE TABLE IF NOT EXISTS `complaint_type` (
  `comp_type_id` int(5) NOT NULL AUTO_INCREMENT,
  `comp_type_title` varchar(15) NOT NULL,
  `comp_type_description` varchar(50) NOT NULL,
  PRIMARY KEY (`comp_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaint_type`
--

INSERT INTO `complaint_type` (`comp_type_id`, `comp_type_title`, `comp_type_description`) VALUES
(1, 'General Query', 'A simple query by customer'),
(2, 'Bug', 'A bug report by customer.'),
(3, 'Comment', 'A comment on a product or service'),
(4, 'Feedback', 'Feedback for product or service'),
(5, 'Complaint', 'A complaint on a product/service');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(20) NOT NULL,
  `dept_head` varchar(30) NOT NULL,
  PRIMARY KEY (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `dept_name`, `dept_head`) VALUES
(1, 'Dept A', 'Emp A'),
(2, 'Dept B', 'Emp B'),
(3, 'Dept C', 'Emp C');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_id` int(11) NOT NULL,
  `emp_name` varchar(30) NOT NULL,
  `emp_email` varchar(30) NOT NULL,
  `emp_gender` varchar(20) NOT NULL,
  PRIMARY KEY (`emp_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `dept_id`, `emp_name`, `emp_email`, `emp_gender`) VALUES
(1, 1, 'Emp Aa', 'empa@example.com', 'male'),
(2, 1, 'Emp Ab', 'empb@example.com', 'female'),
(3, 2, 'Emp Ba', 'empBa@example.com', 'female'),
(4, 2, 'Emp Bb', 'empBb@example.com', 'female'),
(5, 3, 'Emp Ca', 'empCa@example.com', 'male'),
(6, 1, 'Emp A', 'empaaa@example.com', 'male'),
(7, 2, 'Emp B', 'empbbb@example.com', 'male'),
(8, 3, 'Emp C', 'empccc@example.com', 'feamle');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

DROP TABLE IF EXISTS `sub_category`;
CREATE TABLE IF NOT EXISTS `sub_category` (
  `sub_cat_id` int(5) NOT NULL AUTO_INCREMENT,
  `cat_id` int(5) NOT NULL,
  `sub_cat_name` varchar(15) NOT NULL,
  `sub_cat_description` varchar(40) NOT NULL,
  PRIMARY KEY (`sub_cat_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`sub_cat_id`, `cat_id`, `sub_cat_name`, `sub_cat_description`) VALUES
(1, 1, 'sub cat 1', 'test for sub cat 1'),
(2, 1, 'sub cat 2', 'test for sub cat 2'),
(3, 2, 'sub cat 3', 'test for sub cat 3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(15) NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'customer',
  `first_name` varchar(15) NOT NULL,
  `middle_name` varchar(15) DEFAULT NULL,
  `last_name` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `profile` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_type`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `gender`, `profile`) VALUES
(1, 'admin_123', 'admin', 'Anitha', 'Susan', 'Alex', 'anithaalex98@gmail.com', 'admin123', 'female', 'admin profile.png'),
(2, 'customerA_123', 'customer', 'Customer', NULL, 'A', 'angelica1121998@gmail.com', 'customerA123', 'male', NULL),
(5, 'customerB_123', 'customer', 'Customer', 'test', 'B', 'gauravmakasare115@gmail.com', 'customerB123', 'male', 'index4.png');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaint`
--
ALTER TABLE `complaint`
  ADD CONSTRAINT `comp_cat_id` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`),
  ADD CONSTRAINT `comp_type_id` FOREIGN KEY (`comp_type_id`) REFERENCES `complaint_type` (`comp_type_id`),
  ADD CONSTRAINT `emp_id` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`emp_id`),
  ADD CONSTRAINT `sub_cat_id` FOREIGN KEY (`sub_cat_id`) REFERENCES `sub_category` (`sub_cat_id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `dept_id` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`);

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `cat_id` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
