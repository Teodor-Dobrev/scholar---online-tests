<?php 
$sql = <<<Multi
-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 24, 2017 at 07:59 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wservsco_scholar`
--

-- --------------------------------------------------------

--
-- Table structure for table `{$prefix}answers`
--

CREATE TABLE IF NOT EXISTS `{$prefix}answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer` varchar(2048) NOT NULL,
  `correct` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB {$collate} AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{$prefix}difficulties`
--

CREATE TABLE IF NOT EXISTS `{$prefix}difficulties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB {$collate} AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{$prefix}questions`
--

CREATE TABLE IF NOT EXISTS `{$prefix}questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(2048) NOT NULL,
  `user_id` int(11) NOT NULL,
  `difficulty_id` INT NOT NULL,
  `area_id` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB {$collate} AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `{$prefix}tests`
--

CREATE TABLE IF NOT EXISTS `{$prefix}tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `user_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `last_edit` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_to_solve` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB {$collate};

-- --------------------------------------------------------

--
-- Table structure for table `{$prefix}tests_answered`
--

CREATE TABLE IF NOT EXISTS `{$prefix}tests_answered` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `opened` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `solved` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB {$collate};

-- --------------------------------------------------------

--
-- Table structure for table `{$prefix}tests_answers`
--

CREATE TABLE IF NOT EXISTS `{$prefix}tests_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `correct` INT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB {$collate};


-- --------------------------------------------------------

--
-- Table structure for table `{$prefix}areas`
--

CREATE TABLE IF NOT EXISTS `sc1_sc1_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB {$collate};


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
Multi;
