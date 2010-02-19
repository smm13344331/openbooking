-- phpMyAdmin SQL Dump
-- version 2.11.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 19, 2010 at 02:56 PM
-- Server version: 5.0.77
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `openbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `ob_bookings`
--

CREATE TABLE IF NOT EXISTS `ob_bookings` (
  `booking_id` int(11) NOT NULL auto_increment,
  `slot_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  PRIMARY KEY  (`booking_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ob_bookings`
--

INSERT INTO `ob_bookings` (`booking_id`, `slot_id`, `user_id`, `resource_id`) VALUES
(1, 1, 2, 3),
(2, 1, 2, 3),
(3, 4, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `ob_locations`
--

CREATE TABLE IF NOT EXISTS `ob_locations` (
  `location_id` int(11) NOT NULL auto_increment,
  `loc1_name` varchar(255) NOT NULL,
  `loc1_value` varchar(255) NOT NULL,
  `loc2_name` varchar(255) NOT NULL,
  `loc2_value` varchar(255) NOT NULL,
  PRIMARY KEY  (`location_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ob_locations`
--


-- --------------------------------------------------------

--
-- Table structure for table `ob_resources`
--

CREATE TABLE IF NOT EXISTS `ob_resources` (
  `resource_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `bookable` tinyint(1) NOT NULL,
  `location_id` int(11) NOT NULL,
  `cool_period` time NOT NULL,
  `restrict_slots` tinyint(1) NOT NULL,
  `advance` int(11) NOT NULL default '1',
  `advance_unit` enum('h','d','m') NOT NULL default 'm',
  PRIMARY KEY  (`resource_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ob_resources`
--


-- --------------------------------------------------------

--
-- Table structure for table `ob_resource_categories`
--

CREATE TABLE IF NOT EXISTS `ob_resource_categories` (
  `category_id` int(1) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` varchar(255) NOT NULL,
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ob_resource_categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `ob_slots`
--

CREATE TABLE IF NOT EXISTS `ob_slots` (
  `slot_id` int(11) NOT NULL auto_increment,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `monday` tinyint(1) NOT NULL,
  `tuesday` tinyint(1) NOT NULL,
  `wednesday` tinyint(1) NOT NULL,
  `thursday` tinyint(1) NOT NULL,
  `friday` tinyint(1) NOT NULL,
  `saturday` tinyint(1) NOT NULL,
  `sunday` tinyint(1) NOT NULL,
  PRIMARY KEY  (`slot_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ob_slots`
--


