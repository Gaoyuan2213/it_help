-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2025-10-19 19:00:42
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `it_helpdesk`
--

-- --------------------------------------------------------

--
-- 表的结构 `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `priority` enum('Low','Medium','High') DEFAULT 'Medium',
  `status` enum('New','Assigned','In Progress','Resolved','Closed') DEFAULT 'New',
  `assigned_to` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `title`, `description`, `category`, `priority`, `status`, `assigned_to`, `created_at`) VALUES
(2, 7, 'Cannot access company VPN', 'I am working remotely and cannot connect to the company VPN since this morning. Error says authentication failed.', 'Network', 'High', 'In Progress', 9, '2025-10-14 13:55:13');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','it_staff','employee') DEFAULT 'employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`) VALUES
(7, 'gaoyuan', 'gy655123@dal.ca', '$2y$10$GC31NWQPaO0WSWbY0qR8uu66UjaZ9WFMd9VVLBwIIP7zDy2HlffX6', 'employee'),
(8, 'user1', 'usertest@email', '$2y$10$BEl5y2TZgobuyZALTjLmK.8wlO68v8GmSyWLKaMGmFyn2VI0SjM1G', 'it_staff'),
(9, 'user3', 'test2@email', '$2y$10$lzi1oWofKR1b5VTEDK2uhOcSPUAMMfxiTXUyi3dU4gM99kxDedr6e', 'it_staff'),
(10, 'user_admin', 'admin@email', '$2y$10$HEhKiS3kQm.yt2Ho2fMMe.PXdKyKMGzFc9EXF3abEoVIJPoXNzBMi', 'admin'),
(12, 'Gaoyuan ', 'gaoyuan@email', '$2y$10$n.imTIGrC7B2k75NW9qdouM2e6bP9UfVsOMKpR.BMXMZWKjYVRTm2', 'employee');

--
-- 转储表的索引
--

--
-- 表的索引 `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
