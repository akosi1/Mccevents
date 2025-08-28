-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2025 at 03:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `status` enum('active','postponed','cancelled') NOT NULL DEFAULT 'active',
  `department` varchar(255) DEFAULT NULL,
  `is_exclusive` tinyint(1) NOT NULL DEFAULT 0,
  `allowed_departments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`allowed_departments`)),
  `is_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `recurrence_pattern` varchar(255) DEFAULT NULL,
  `recurrence_interval` int(11) NOT NULL DEFAULT 1,
  `recurrence_end_date` date DEFAULT NULL,
  `recurrence_count` int(11) DEFAULT NULL,
  `repeat_type` enum('none','daily','weekly','monthly','yearly') NOT NULL DEFAULT 'none',
  `repeat_interval` int(11) DEFAULT 1,
  `repeat_until` date DEFAULT NULL,
  `parent_event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cancel_reason` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `date`, `start_time`, `end_time`, `location`, `status`, `department`, `is_exclusive`, `allowed_departments`, `is_recurring`, `recurrence_pattern`, `recurrence_interval`, `recurrence_end_date`, `recurrence_count`, `repeat_type`, `repeat_interval`, `repeat_until`, `parent_event_id`, `cancel_reason`, `image`, `created_at`, `updated_at`) VALUES
(65, 'Volleyball', 'Volleyball', '2025-08-29', NULL, NULL, 'MCC Covered court', 'active', 'BSIT', 0, NULL, 0, NULL, 1, NULL, NULL, 'none', 1, NULL, NULL, NULL, 'events/6OQhVQr62m8A13KGVZHn.jpg', '2025-08-18 18:37:46', '2025-08-18 18:57:00'),
(66, 'Basketball', 'Basketball', '2025-09-01', NULL, NULL, 'MCC Covered court', 'active', 'BSIT', 0, NULL, 0, NULL, 1, NULL, NULL, 'none', 1, NULL, NULL, NULL, 'events/PLZBWAtQMP8DqOUtIzuY.jpg', '2025-08-18 18:42:00', '2025-08-18 18:52:25'),
(67, 'Soccer', 'Soccer', '2025-09-24', NULL, NULL, 'MNHS Oval', 'active', 'BSIT', 1, NULL, 0, NULL, 1, NULL, NULL, 'none', 1, NULL, NULL, NULL, 'events/ng2alQPqfrBKAiI1CD3G.jfif', '2025-08-18 18:46:34', '2025-08-20 18:58:12'),
(69, 'Badminton', 'Badminton', '2025-09-04', '03:49:00', '06:49:00', 'MNHS Oval', 'active', 'BSED', 1, '[\"BSBA\"]', 0, NULL, 1, NULL, NULL, 'none', 1, NULL, NULL, NULL, 'events/yuHRL9fwQTZxZDzosqrY.jfif', '2025-08-19 06:50:25', '2025-08-25 11:50:27'),
(70, 'MOBILE LEGEND', 'MOBILE LEGEND', '2025-08-28', NULL, NULL, 'mcc IT lab 1', 'active', 'BSBA', 0, NULL, 0, NULL, 1, NULL, NULL, 'none', 1, NULL, NULL, NULL, 'events/zAkr8NFNZsW9cSvX9Oer.jpg', '2025-08-19 06:52:52', '2025-08-19 07:13:29'),
(72, 'asdasd', 'asdasdasd', '2025-08-22', '11:26:00', '21:29:00', 'MNHS Oval', 'active', NULL, 0, NULL, 0, NULL, 1, NULL, NULL, 'none', 1, NULL, NULL, NULL, 'events/d1hwtpCQzp8M0piTCqpc.png', '2025-08-20 03:27:32', '2025-08-20 03:27:32'),
(79, 'intrmmurals', '2025', '2025-09-04', '05:42:00', '17:42:00', 'mcc IT lab 1', 'active', NULL, 0, NULL, 0, NULL, 1, NULL, NULL, 'none', 1, NULL, NULL, NULL, NULL, '2025-08-22 01:42:40', '2025-08-22 01:42:40'),
(80, 'Art', 'brain palautog', '2025-08-24', '08:19:00', '16:16:00', 'San Agustin', 'active', NULL, 0, NULL, 0, NULL, 1, NULL, NULL, 'none', 1, NULL, NULL, NULL, 'events/icaRuVlWMGiYKafo2aak.png', '2025-08-22 19:17:12', '2025-08-22 19:19:19'),
(81, 'ASDSADAS', 'ASDSADASWDS', '2025-10-08', '04:26:00', '16:27:00', 'MCC Stage', 'active', NULL, 1, '[\"BSED\"]', 0, NULL, 1, NULL, NULL, 'none', 1, NULL, NULL, NULL, NULL, '2025-08-25 12:25:55', '2025-08-25 12:25:55');

-- --------------------------------------------------------

--
-- Table structure for table `event_joins`
--

CREATE TABLE `event_joins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_joins`
--

INSERT INTO `event_joins` (`id`, `user_id`, `event_id`, `joined_at`, `created_at`, `updated_at`) VALUES
(23, 22, 80, '2025-08-22 19:18:15', '2025-08-22 19:18:15', '2025-08-22 19:18:15');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_24_123717_create_events_table', 1),
(5, '2025_06_24_123725_add_role_to_users_table', 1),
(6, '2025_07_01_072809_add_image_to_events_table', 2),
(7, '2025_07_18_135247_update_users_table_add_name_fields', 3),
(8, '2025_07_19_105946_update_events_table', 4),
(9, '2025_08_09_024938_create_event_joins_table', 5),
(10, '2025_08_09_024951_create_notifications_table', 5),
(11, '2025_08_15_024258_update_events_table_add_new_fields', 6),
(12, '2025_08_25_190801_add_department_to_users_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `email`, `password`) VALUES
(1, 'brian@bing.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('355IlM178gMpJQPCSqUUEurcqFcYGbLg80ykhxgK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSFY1T01nRk80UXBlTlZDSFJiOUNrNkxWTVhZVnU4c2V3cHpXOTM2byI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9ub3RpZmljYXRpb25zL2NvdW50Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756150642),
('3DZwbFd7l3QUeFYADvTYScFP3FpJiRE6PEaR2lgE', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidmdCZXR3YTI1MGRUM0E0dXdvb0IzWDJjZ0lSRzhYU3dhU0pTa2tZdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9ub3RpZmljYXRpb25zL2NvdW50Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1756159035);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `department`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `status`) VALUES
(1, '', NULL, '', 'test@example.com', '', '2025-06-24 05:31:22', '$2y$12$PIYLGrElJ6rR/40T95dAruGSRSTLLXoXkaOgZnk9ndDY4Ku11LxHy', 'GtXp2bQgOBSXF1YlyYMXQSyPmxfr6VsOsMDdOY3x66uYjK3roOfrdV5Y1VBY', '2025-06-24 05:31:22', '2025-06-24 05:31:22', 'user', 'active'),
(2, '', NULL, '', 'event@gmail.com', '', NULL, '$2y$12$mo1E2y6aKq8AJmK4N4GBmOxDykDeddVwK9c/EhxUeDdg/x78eZmuu', NULL, '2025-06-24 05:35:35', '2025-06-25 05:47:07', 'admin', 'active'),
(3, '', NULL, '', 'bryasdas@gmail.com', '', NULL, '$2y$12$ReUn3xiSfeutqERSBlxwluKC885tA4n55ft2qGo/piaz05xbyHbMG', NULL, '2025-06-26 02:42:26', '2025-06-26 02:42:26', 'user', 'active'),
(4, '', NULL, '', 'hahahha@gmail.com', '', NULL, '$2y$12$yMiRYEIZE.2FxATACN21DeNMPRgr/BeoGU.wCPkTosTB4JNDroMKW', NULL, '2025-06-29 23:53:58', '2025-06-30 18:50:10', 'user', 'active'),
(5, '', NULL, '', 'sadasdasd@gmail.com', '', NULL, '$2y$12$qW0Pe8SoFMEJVzIQPnkJAOIZQipFMVER6qd.2RjJoS.if0lXr1bU2', NULL, '2025-07-02 06:54:58', '2025-07-02 06:54:58', 'user', 'active'),
(8, '', NULL, '', 'sasdd@gmail.com', '', NULL, '$2y$12$D.cX0ZFHBsYqXu751xSsseT0r.uMv8xdxD2pgS5rYcwF7l3bnnE6K', NULL, '2025-07-02 20:17:44', '2025-07-02 20:17:44', 'user', 'active'),
(9, '', NULL, '', 'juaisduoasd@gmail.com', '', NULL, '$2y$12$CH2dQhlSEA1nvfV5UvTOm.KZX5K.GwxLmGkU6jL/AwZ0mwVyHWjv6', NULL, '2025-07-03 21:39:56', '2025-07-03 21:39:56', 'user', 'active'),
(12, '', NULL, '', 'ninz@gmail.com', '', NULL, '$2y$12$lECdARPAHNpauhyDPbwPzOU.8vxmrC7st3loROIdT7tiVIEl5qGfq', NULL, '2025-07-10 16:42:06', '2025-07-10 16:42:06', 'user', 'active'),
(13, '', NULL, '', 'ninzhh@gmail.com', '', NULL, '$2y$12$vCRgc7aAsYKCf9RHEtmfveKcDUuMKidOeujm1LzHgNRZwAXYFbJwC', NULL, '2025-07-10 23:55:56', '2025-07-10 23:55:56', 'admin', 'active'),
(14, '', NULL, '', 'ninzhjhjgkjh@gmail.com', '', NULL, '$2y$12$5QW.etMRdX0qrRY433sGXOUA/Q.f4KwwUyHWOwpOq.Jy26zWnw.NW', NULL, '2025-07-10 23:56:59', '2025-07-12 01:10:16', 'admin', 'inactive'),
(15, 'hasdhadasd', 'hasdhadasd', 'hasdhadasd', 'ninzasdsad@gmail.com', '', NULL, '$2y$12$jvz4yXn3Cgi7VbkMzzJLf.mMpNbk2AdD62wL8rElqUx7TqWPZysiC', NULL, '2025-07-18 05:54:48', '2025-07-18 05:54:48', 'user', 'active'),
(16, 'asdsadasd', 'adaasdsdsdsad', 'asdsadsad', 'ninzhjasdasdhjgkjh@gmail.com', '', NULL, '$2y$12$P45SwM1kdOItaNX8z4KIFuM9FBSGmI214BlVGTTtf94S45nJu60Pe', NULL, '2025-07-18 06:57:17', '2025-07-18 06:57:17', 'user', 'active'),
(18, 'ayawkol', 'ayawkol', 'ayawkol', 'ayawkol@bing.com', '', NULL, '$2y$12$KOOI0S3vaVRvgaHaela6OeyUbwhVLvkLje85zEhByGx0Wb97L0Qre', NULL, '2025-08-08 06:39:42', '2025-08-08 06:39:42', 'user', 'active'),
(19, 'dad', 'asdjaskudgasid', 'asdkasdkasd', 'adjaskjdaskdmin@gmail.com', '', NULL, '$2y$12$Ag2aOqQ/QVKUuvhwwkCYUuRlWWeU733UOb2Qm6DCpZRIjPigaAYTi', NULL, '2025-08-09 01:11:45', '2025-08-09 01:11:45', 'user', 'active'),
(20, 'bry', 'bry', 'bry', 'brysad@gmail.com', '', NULL, '$2y$12$Z01Abe8fVTOD3rt7E2r3BOoMxeyfg8uM10aovSgmOA6AfZbX6nMXG', NULL, '2025-08-12 07:56:23', '2025-08-12 07:56:23', 'user', 'active'),
(21, 'eventdasdasdas', 'event', 'asdasdasasdsa', 'asdasdadasdsd@gmail.com', '', NULL, '$2y$12$0tbTe39Vl2SP18iM6.2eve1MA18IPpnYGY7dpyJg6yivIfdsUHyge', NULL, '2025-08-15 05:36:14', '2025-08-15 05:36:14', 'user', 'active'),
(22, 'Jan Robert', 'Quezon', 'Francisco', 'jan@gmail.com', '', NULL, '$2y$12$p9FsM9.84WwkBARl8rBsyOHgiKlcIDor7Z8ttCQogc0Q9rz9AJ8a.', NULL, '2025-08-22 19:05:20', '2025-08-22 19:05:20', 'admin', 'active'),
(23, 'ayawkol', 'sadasd', 'sasadasd@example.com', 'ninzhjhjgkjsaasash@gmail.com', 'BEED', NULL, '$2y$12$ZgolD.k/7.Ga9zWTVkBImucFmCOPzFusF3B2nYMrrCeOtnzDbfMSK', NULL, '2025-08-25 11:13:01', '2025-08-25 11:13:01', 'user', 'active'),
(24, 'asdasdsaasdas', 'aasdas', 'asdasdsaasdas', 'admin@gmail.com', 'BSIT', NULL, '$2y$12$lekYskQoQlUOM4rZdWuu0eZ9xJBeegnzJ.stwWizZ17WImQ5YKt6S', NULL, '2025-08-25 11:24:36', '2025-08-25 11:24:36', 'user', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_parent_event_id_foreign` (`parent_event_id`);

--
-- Indexes for table `event_joins`
--
ALTER TABLE `event_joins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_joins_user_id_event_id_unique` (`user_id`,`event_id`),
  ADD KEY `event_joins_event_id_foreign` (`event_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `event_joins`
--
ALTER TABLE `event_joins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_parent_event_id_foreign` FOREIGN KEY (`parent_event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `event_joins`
--
ALTER TABLE `event_joins`
  ADD CONSTRAINT `event_joins_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_joins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
