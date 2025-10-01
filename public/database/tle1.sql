-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2025 at 09:46 AM
-- Server version: 8.4.2
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tle1`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `comment` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` bigint UNSIGNED NOT NULL,
  `video_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video_description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `thumbnail` blob NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `views` bigint UNSIGNED DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ai_generated` tinyint(1) DEFAULT NULL,
  `channel_name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `video_title`, `video_description`, `thumbnail`, `user_id`, `date`, `views`, `created_at`, `updated_at`, `file_path`, `ai_generated`, `channel_name`) VALUES
(2, 'Amazing Nature', 'A short documentary about forests', 0x31322e706e67, 101, '2025-09-23', 1523, '2025-09-23 14:03:59', '2025-09-23 14:36:59', 'https://example.com/videos/nature.mp4', 0, 'test'),
(3, 'Top 10 Coding Tips', 'Improve your programming skills', 0x31322e706e67, 102, '2025-09-22', 987, '2025-09-23 14:03:59', '2025-09-23 14:36:59', 'https://example.com/videos/coding_tips.mp4', 0, 'test'),
(138, 'Epic Space Journey', 'Explore the wonders of the universe in this short documentary.', 0x31332e706e67, 0, '2025-09-30', 0, '2025-09-30 14:10:08', '2025-09-30 14:10:08', 'uploads/user-videos/video138.mp4', NULL, 'AstroWorld'),
(182, 'Epic Space Journey', 'Explore the wonders of the universe in this short documentary.', 0x31332e706e67, 0, '2025-09-30', 0, '2025-09-30 14:14:01', '2025-09-30 14:14:01', 'uploads/user-videos/video138.mp4', NULL, 'AstroWorld'),
(183, 'Amazing Nature', 'A short documentary about forests', 0x31322e706e67, 0, '2025-09-30', 1523, '2025-09-30 14:18:10', '2025-09-30 14:18:10', 'https://example.com/videos/nature.mp4', NULL, 'test'),
(184, 'Epic Space Journey', 'Explore the wonders of the universe in this short documentary.', 0x31332e706e67, 0, '2025-09-30', 0, '2025-09-30 14:19:31', '2025-09-30 14:19:31', 'uploads/user-videos/video138.mp4', NULL, 'AstroWorld'),
(185, 'Epic Space Journey', 'Explore the wonders of the universe in this short documentary.', 0x31332e706e67, 0, '2025-09-30', 0, '2025-09-30 14:25:47', '2025-09-30 14:25:47', 'uploads/user-videos/video138.mp4', NULL, 'AstroWorld'),
(186, 'Amazing Nature', 'A short documentary about forests', 0x31322e706e67, 0, '2025-09-30', 1523, '2025-09-30 14:25:52', '2025-09-30 14:25:52', 'https://example.com/videos/nature.mp4', NULL, 'test'),
(187, 'Epic Space Journey', 'Explore the wonders of the universe in this short documentary.', 0x31332e706e67, 0, '2025-09-30', 0, '2025-09-30 14:36:46', '2025-09-30 14:36:46', 'uploads/user-videos/video138.mp4', NULL, 'AstroWorld'),
(188, 'Epic Space Journey', 'Explore the wonders of the universe in this short documentary.', 0x31332e706e67, 0, '2025-09-30', 0, '2025-09-30 14:37:09', '2025-09-30 14:37:09', 'uploads/user-videos/video138.mp4', NULL, 'AstroWorld'),
(189, 'Epic Space Journey', 'Explore the wonders of the universe in this short documentary.', 0x31332e706e67, 0, '2025-09-30', 0, '2025-09-30 14:37:16', '2025-09-30 14:37:16', 'uploads/user-videos/video138.mp4', NULL, 'AstroWorld'),
(190, 'Epic Space Journey', 'Explore the wonders of the universe in this short documentary.', 0x31332e706e67, 0, '2025-10-01', 0, '2025-10-01 11:20:03', '2025-10-01 11:20:03', 'uploads/user-videos/video138.mp4', NULL, 'AstroWorld'),
(191, 'Epic Space Journey', 'Explore the wonders of the universe in this short documentary.', 0x31332e706e67, 0, '2025-10-01', 0, '2025-10-01 11:44:00', '2025-10-01 11:44:00', 'uploads/user-videos/video138.mp4', NULL, 'AstroWorld');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `video_id` bigint UNSIGNED DEFAULT NULL,
  `comment_id` bigint UNSIGNED DEFAULT NULL,
  `is_like` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`, `profile_picture`, `bio`, `created_at`, `updated_at`) VALUES
(1, 'testuser', 'testuser@example.com', 'password123', 0, 'uploads/profile1.png', 'This is a test bio.', '2025-09-23 14:00:00', '2025-09-23 14:00:00'),
(2, 'emre', 'emre@emre.nl', '$2y$12$0x9uypjEp0XO.oQ7SJ6M1uyjLZTbXvKlo42z2tbVrP36WxEzGqnXW', NULL, NULL, NULL, '2025-09-29 10:10:32', '2025-09-29 10:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` bigint UNSIGNED NOT NULL,
  `video_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video_description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `thumbnail` blob NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `views` bigint UNSIGNED DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ai_generated` tinyint(1) DEFAULT NULL,
  `channel_name` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `video_title`, `video_description`, `thumbnail`, `user_id`, `date`, `views`, `created_at`, `updated_at`, `file_path`, `ai_generated`, `channel_name`) VALUES
(1, 'test titel', 'test description', 0x31322e706e67, 1, '2023-02-12', 13, '2023-02-12 00:00:00', '2025-09-23 14:36:59', 'test file path', 0, 'test'),
(2, 'Amazing Nature', 'A short documentary about forests', 0x31322e706e67, 101, '2025-09-23', 1523, '2025-09-23 14:03:59', '2025-09-23 14:36:59', 'https://example.com/videos/nature.mp4', 0, 'test'),
(3, 'Top 10 Coding Tips', 'Improve your programming skills', 0x31322e706e67, 102, '2025-09-22', 987, '2025-09-23 14:03:59', '2025-09-23 14:36:59', 'https://example.com/videos/coding_tips.mp4', 0, 'test'),
(4, 'Funny Cats Compilation', 'Cats doing hilarious things', 0x31322e706e67, 103, '2025-09-21', 3050, '2025-09-23 14:03:59', '2025-09-23 14:36:59', 'https://example.com/videos/funny_cats.mp4', 0, 'test'),
(5, 'Space Exploration', 'The latest news in space science', 0x31322e706e67, 104, '2025-09-20', 2011, '2025-09-23 14:03:59', '2025-09-23 14:36:59', 'https://example.com/videos/space.mp4', 1, 'test'),
(6, 'Guitar Lessons for Beginners', 'Learn basic guitar chords', 0x31322e706e67, 105, '2025-09-19', 674, '2025-09-23 14:03:59', '2025-09-23 14:36:59', 'https://example.com/videos/guitar_lessons.mp4', 0, 'test'),
(10, 'Test Video 10', 'Description for video 10', 0x31322e706e67, 1, '2025-09-23', 0, '2025-09-23 14:00:00', '2025-09-23 14:36:59', 'uploads/video10.mp4', 0, 'test'),
(11, 'Test Video 11', 'Description for video 11', 0x31322e706e67, 1, '2025-09-23', 0, '2025-09-23 14:00:00', '2025-09-23 14:36:59', 'uploads/video11.mp4', 0, 'test'),
(12, 'Test Video 12', 'Description for video 12', 0x31322e706e67, 1, '2025-09-23', 0, '2025-09-23 14:00:00', '2025-09-23 14:36:59', 'uploads/video12.mp4', 0, 'test'),
(13, 'Test Video 13', 'Description for video 13', 0x31322e706e67, 1, '2025-09-23', 0, '2025-09-23 14:00:00', '2025-09-23 14:36:59', 'uploads/video13.mp4', 0, 'test'),
(14, 'Test Video 14', 'Description for video 14', 0x31322e706e67, 1, '2025-09-23', 0, '2025-09-23 14:00:00', '2025-09-23 14:36:59', 'uploads/video14.mp4', 0, 'test'),
(15, 'Test Video 15', 'Description for video 15', 0x31322e706e67, 1, '2025-09-23', 0, '2025-09-23 14:00:00', '2025-09-23 14:36:59', 'uploads/video15.mp4', 0, 'test'),
(16, 'Test Video 16', 'Description for video 16', 0x31322e706e67, 1, '2025-09-23', 0, '2025-09-23 14:00:00', '2025-09-23 14:36:59', 'uploads/video16.mp4', 0, 'test'),
(17, 'Test Video 17', 'Description for video 17', 0x31322e706e67, 1, '2025-09-23', 0, '2025-09-23 14:00:00', '2025-09-23 14:36:59', 'uploads/video17.mp4', 0, 'test'),
(18, 'Test Video 18', 'Description for video 18', 0x31322e706e67, 1, '2025-09-23', 0, '2025-09-23 14:00:00', '2025-09-23 14:36:59', 'uploads/video18.mp4', 0, 'test'),
(19, 'Test Video 19', 'Description for video 19', 0x31322e706e67, 1, '2025-09-23', 0, '2025-09-23 14:00:00', '2025-09-23 14:36:59', 'uploads/video19.mp4', 0, 'test'),
(20, 'Amazing Nature', 'A short documentary about forests', 0x31322e706e67, 2, '2025-09-23', 0, '2025-09-23 14:38:53', '2025-09-23 14:38:53', 'uploads/user-videos/video20.mp4', 0, 'WildLifeChannel'),
(21, 'Top 10 Coding Tips', 'Improve your programming skills', 0x31322e706e67, 3, '2025-09-22', 0, '2025-09-23 14:38:53', '2025-09-23 14:38:53', 'uploads/user-videos/video21.mp4', 0, 'CodeMaster'),
(22, 'Funny Cats Compilation', 'Cats doing hilarious things', 0x31322e706e67, 4, '2025-09-21', 0, '2025-09-23 14:38:53', '2025-09-23 14:38:53', 'uploads/user-videos/video22.mp4', 0, 'MeowTube'),
(138, 'Epic Space Journey', 'Explore the wonders of the universe in this short documentary.', 0x31332e706e67, 5, '2025-09-23', 0, '2025-09-23 14:51:48', '2025-09-23 14:51:48', 'uploads/user-videos/video138.mp4', 0, 'AstroWorld');

-- --------------------------------------------------------

--
-- Table structure for table `video_tags`
--

CREATE TABLE `video_tags` (
  `video_id` bigint UNSIGNED NOT NULL,
  `tag_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `video_tags`
--
ALTER TABLE `video_tags`
  ADD PRIMARY KEY (`video_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
