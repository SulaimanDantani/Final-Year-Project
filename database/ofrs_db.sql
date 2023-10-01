-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2022 at 08:53 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `ofrs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `history_list`
--

CREATE TABLE `history_list` (
  `id` int(30) NOT NULL,
  `request_id` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history_list`
--

INSERT INTO `history_list` (`id`, `request_id`, `status`, `remarks`, `date_created`) VALUES
(1, 1, 1, 'Request has been assign to a fire control team.', '2022-05-21 12:08:58'),
(2, 1, 2, 'The assigned fire control team is on its way.', '2022-05-21 13:51:02'),
(3, 1, 3, 'The Fire Control team is in on-progress of putting the fire down.', '2022-05-21 13:54:15'),
(4, 1, 4, 'Fire has been successfully controlled.', '2022-05-21 13:54:52'),
(5, 2, 1, 'Request has been assign to a fire control team.', '2022-05-21 14:48:55');

-- --------------------------------------------------------

--
-- Table structure for table `inquiry_list`
--

CREATE TABLE `inquiry_list` (
  `id` int(30) NOT NULL,
  `fullname` text NOT NULL,
  `email` text NOT NULL,
  `contact` text NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `request_list`
--

CREATE TABLE `request_list` (
  `id` int(30) NOT NULL,
  `team_id` int(30) DEFAULT NULL,
  `code` varchar(100) NOT NULL,
  `fullname` text NOT NULL,
  `contact` text NOT NULL,
  `message` text NOT NULL,
  `location` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Pending,\r\n1 = Assigned to Team,\r\n2 = Team on their Way\r\n3 = Relief on progress\r\n4 = Completed',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request_list`
--

INSERT INTO `request_list` (`id`, `team_id`, `code`, `fullname`, `contact`, `message`, `location`, `status`, `date_created`, `date_updated`) VALUES
(1, 2, '2022052100001', 'Ella Zane', '09456987455', 'A Residential Area is on Fire.', '2688 Goosetown Drive, Charlotte, North Carolina, 28202', 4, '2022-05-21 10:25:02', '2022-05-21 13:54:52'),
(2, 1, '2022052100002', 'Dina Santos', '0978945631', 'Sample report only', '4250 Star Trek Drive, Tallahassee, Florida, 32303', 1, '2022-05-21 14:35:12', '2022-05-21 14:48:55'),
(4, NULL, '2022052100003', 'Martha V Whitten', '562-397-5583', 'Commercial Buiding is on fire.', '3621 Thompson Drive, San Leandro, California(CA), 94578', 0, '2022-05-21 14:51:56', '2022-05-21 14:51:56');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Online Fire Reporting System'),
(6, 'short_name', 'OFRS - PHP'),
(11, 'logo', 'uploads/logo.png?v=1653095716'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png?v=1653095717'),
(17, 'phone', '456-987-1231'),
(18, 'mobile', '09123456987 / 094563212222 '),
(19, 'email', 'info@firedepartment.com'),
(20, 'address', '7087 Henry St. Clifton Park, NY 12065');

-- --------------------------------------------------------

--
-- Table structure for table `team_list`
--

CREATE TABLE `team_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `leader_name` text NOT NULL,
  `leader_contact` text NOT NULL,
  `members` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_list`
--

INSERT INTO `team_list` (`id`, `code`, `leader_name`, `leader_contact`, `members`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'F-623', 'Mark D Cooper', '09456789123', 'John Smith, Mike Ross, Steven Miller, Anthony Wheeler', 0, '2022-05-21 09:31:00', '2022-05-21 09:33:50'),
(2, 'F-1014', 'Johnny Deep', '09654789123', 'Member 101, Member 102, Member 103, Member 104', 0, '2022-05-21 09:44:15', '2022-05-21 09:44:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='2';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', '', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/1.png?v=1649834664', NULL, 1, '2021-01-20 14:02:37', '2022-05-16 14:17:49'),
(6, 'Mark', 'D', 'Cooper', 'mcooper', 'c7162ff89c647f444fcaa5c635dac8c3', 'uploads/avatars/6.png?v=1653035960', NULL, 2, '2022-05-20 16:39:20', '2022-05-20 16:39:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history_list`
--
ALTER TABLE `history_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `inquiry_list`
--
ALTER TABLE `inquiry_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_list`
--
ALTER TABLE `request_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id_fk_rl` (`team_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_list`
--
ALTER TABLE `team_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history_list`
--
ALTER TABLE `history_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inquiry_list`
--
ALTER TABLE `inquiry_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_list`
--
ALTER TABLE `request_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `team_list`
--
ALTER TABLE `team_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history_list`
--
ALTER TABLE `history_list`
  ADD CONSTRAINT `request_id_fh_hl` FOREIGN KEY (`request_id`) REFERENCES `request_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `request_list`
--
ALTER TABLE `request_list`
  ADD CONSTRAINT `team_id_fk_rl` FOREIGN KEY (`team_id`) REFERENCES `team_list` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;
COMMIT;
