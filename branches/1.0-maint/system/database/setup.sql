-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: mysql.dansworkshop.net
-- Generation Time: Sep 05, 2007 at 01:23 PM
-- Server version: 5.0.24
-- PHP Version: 4.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `testbudget`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `Categories`
-- 

CREATE TABLE IF NOT EXISTS `Categories` (
  `category_id` bigint(20) NOT NULL auto_increment,
  `pretty_name` varchar(256) NOT NULL,
  PRIMARY KEY  (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Categories`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `Months`
-- 

CREATE TABLE IF NOT EXISTS `Months` (
  `month_id` bigint(20) NOT NULL,
  `pretty_name` varchar(30) NOT NULL,
  `short_name` varchar(3) NOT NULL,
  PRIMARY KEY  (`month_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `Months`
-- 

INSERT INTO `Months` (`month_id`, `pretty_name`, `short_name`) VALUES 
(92007, 'September', 'Sep');

-- --------------------------------------------------------

-- 
-- Table structure for table `Transactions`
-- 

CREATE TABLE IF NOT EXISTS `Transactions` (
  `transaction_id` bigint(20) NOT NULL auto_increment,
  `month_id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `amount` double NOT NULL,
  `description` varchar(256) default NULL,
  PRIMARY KEY  (`transaction_id`),
  FOREIGN KEY (month_id) REFERENCES Months(month_id),
  FOREIGN KEY (category_id) REFERENCES Categories(category_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `Transactions`
-- 

