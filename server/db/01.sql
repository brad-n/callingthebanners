-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 19, 2017 at 09:16 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `callingthebanners`
--
CREATE DATABASE IF NOT EXISTS `callingthebanners` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `callingthebanners`;

-- --------------------------------------------------------

--
-- Table structure for table `decks`
--

CREATE TABLE `decks` (
  `deck_id` int(11) NOT NULL,
  `group_id` int(6) NOT NULL,
  `created_by` int(6) NOT NULL,
  `date_created` datetime NOT NULL,
  `url` varchar(255) NOT NULL,
  `faction` int(3) NOT NULL,
  `agenda` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `active` int(1) NOT NULL,
  `validation_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `password`, `date_created`, `active`, `validation_code`) VALUES
(1, 'test', 'test', 'test', '2017-08-23 00:00:00', 1, NULL),
(6, 'digitalgenesis@gmail.com', 'brad', '1c8bfe8f801d79745c4631d09fff36c82aa37fc4cce4fc946683d7b336b63032', '2017-08-23 21:24:06', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `decks`
--
ALTER TABLE `decks`
  ADD PRIMARY KEY (`deck_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `decks`
--
ALTER TABLE `decks`
  MODIFY `deck_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;