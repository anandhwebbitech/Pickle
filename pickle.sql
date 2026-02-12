-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2026 at 01:22 PM
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
-- Database: `pickle`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `product_id`, `category_id`, `user_id`, `quantity`, `weight`, `price`, `discount`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(2, 6, 1, 2, 2, '100', 100, 0, 200, 1, '2026-02-11 11:57:44', '2026-02-12 05:41:29'),
(3, 5, 1, 2, 2, '100', 100, 0, 200, 1, '2026-02-11 12:02:17', '2026-02-12 05:47:28'),
(4, 3, 1, 2, 2, '100', 100, 0, 200, 1, '2026-02-12 04:48:52', '2026-02-12 05:35:50');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Organic Pulses', 1, '2026-02-10 05:24:01', '2026-02-10 05:24:01'),
(2, 'Organic Pulses', 1, '2026-02-10 05:24:16', '2026-02-10 05:24:16'),
(3, 'Pure Honeys', 0, '2026-02-10 05:30:44', '2026-02-10 06:30:54');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SAVE10', 0, 257, 1, '2026-02-10 12:00:03', '2026-02-10 12:16:43');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `deals` int(11) NOT NULL,
  `weight` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `contains` text DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `description`, `deals`, `weight`, `image`, `contains`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Curry Leaf Powder', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770791978.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Coriander Powder\",\"Garlic\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\"]', 200, 1, '2026-02-11 06:39:38', '2026-02-11 06:39:38'),
(3, 'Mango Pickle', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770792188.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Garlic\",\"Coriander Powder\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\",\"uploads\\/products\",\"Mango Pickle\"]', 250, 1, '2026-02-11 06:43:08', '2026-02-11 06:43:08'),
(4, 'Mango Pickle', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770792188.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Garlic\",\"Coriander Powder\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\",\"uploads\\/products\",\"Mango Pickle\"]', 250, 1, '2026-02-11 06:43:08', '2026-02-11 06:43:08'),
(5, 'Curry Leaf Powder', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770791978.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Coriander Powder\",\"Garlic\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\"]', 200, 1, '2026-02-11 06:39:38', '2026-02-11 06:39:38'),
(6, 'Mango Pickle', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770792188.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Garlic\",\"Coriander Powder\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\",\"uploads\\/products\",\"Mango Pickle\"]', 250, 1, '2026-02-11 06:43:08', '2026-02-11 06:43:08');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `images` varchar(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_price_details`
--

CREATE TABLE `product_price_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('gUFSyOVII0U2oe6al6Q3hi9aTlS7GXyHEYjs3rz4', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNUVTWDhtc25pNVlGZVlYOUVJeGdRajNIWTBMck9waHd3SXFUMko0cSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3QvcGlja2xlL3Byb2R1Y3QiO3M6NToicm91dGUiO3M6NzoicHJvZHVjdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1770898658),
('UAXheIsjcB890j6cUDuKdv7O8gTBkn5RphKTzsfV', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiMW5xdG9FN3l5YWxkRnZTdUtlTDBFUTZUWlZTQW8yTWdlTzlYUWhWZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY1OiJodHRwOi8vbG9jYWxob3N0L3BpY2tsZS9wcm9maWxlP190b2tlbj0xbnF0b0U3eXlhbGRGdlN1S2VMMEVRNlRaVlNBbzJNZ2VPOVhRaFZnJmFkZHJlc3NfbGluZTE9NjclMjBTZWNvbmQlMjBFeHRlbnNpb24mY2l0eT1RdWklMjBhdXRlbSUyMGN1bSUyMHN1c2NpcCZmdWxsX25hbWU9RW1pbHklMjBLaXJrJmlzX2RlZmF1bHQ9MSZtb2JpbGU9QXV0ZW0lMjBpZCUyMHJhdGlvbmUlMjBzYSZwaW5jb2RlPTc4NTY5ODUmc3RhdGU9RG9sb3JlbSUyMGNvbnNlY3RldHVyJTIwIjtzOjU6InJvdXRlIjtzOjc6InByb2ZpbGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTA6Indpc2hsaXN0XzIiO2E6MTp7aTo2O2E6NTp7czoyOiJpZCI7aTo2O3M6MTI6InByb2R1Y3RfbmFtZSI7czoxMjoiTWFuZ28gUGlja2xlIjtzOjU6InByaWNlIjtOO3M6ODoicXVhbnRpdHkiO2k6MTtzOjExOiJwcm9kdWN0X2ltZyI7czoxNToiMTc3MDc5MjE4OC53ZWJwIjt9fXM6ODoiZGlzY291bnQiO2E6Mzp7czo0OiJjb2RlIjtzOjY6IlNBVkUxMCI7czo0OiJ0eXBlIjtpOjA7czo1OiJ2YWx1ZSI7aToyNTc7fXM6NjoiY291cG9uIjthOjI6e3M6NDoiY29kZSI7czo2OiJTQVZFMTAiO3M6ODoiZGlzY291bnQiO2k6MjU3O319', 1770889243);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `otp` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `status`, `otp`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'adminpickle@gmail.com', '9994394717', '1', NULL, NULL, '$2y$12$RdL1FyIq5/za3Wei4quWKu2xhlFyPWHhkAzTUJoWFHfStTmlQhPQm', NULL, '2026-02-11 05:04:08', '2026-02-11 05:04:08'),
(2, 'Anandh', 'anandhwebbitech@gmail.com', '9994394718', '1', NULL, NULL, '$2y$12$htUsrXlpIzQTDbLNMHnRwOvHWPNNPV5fl55G24xvk1kDKp3Sluv.O', NULL, '2026-02-10 23:50:05', '2026-02-12 05:26:17'),
(3, 'Nithyanandhan K', 'anandwebbitech@gmail.com', '9994394719', '1', NULL, NULL, '$2y$12$vgEqWxeBlIYxUUYJXyRanOJcI5O27d1zo49SRuMGMAAVDr8vZumz.', NULL, '2026-02-10 23:56:56', '2026-02-10 23:56:56'),
(4, 'Prabu', 'prabuwebbitech@gmail.com', '9994394720', '1', NULL, NULL, '$2y$12$0r5ZGYEySEF/VHS3zA.iDeAodOe97YgnQUAu/RIECcF3jc2TKnRfy', NULL, '2026-02-11 00:00:29', '2026-02-11 00:00:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_default` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `name`, `mobile`, `city`, `state`, `pincode`, `address`, `status`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 2, 'Dustin Buck', 'Libero ut deserunt c', 'Est maiores corrupti', 'Numquam in sint ape', '785685', '672 New Street', 1, 0, '2026-02-12 07:27:43', '2026-02-12 09:19:54'),
(2, 2, 'Nithyanandhan K', '7586954852', 'Coimbatore', 'Tamil Nadu', '641002', 'ryuytfdgf', 1, 0, '2026-02-12 09:00:56', '2026-02-12 09:19:54'),
(3, 2, 'Farrah Cunningham', 'Quo a nemo quisquam', 'Asperiores sit mole', 'Molestias laborum ob', '752989', '78 Rocky Cowley Street', 1, 1, '2026-02-12 09:10:57', '2026-02-12 09:19:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_price_details`
--
ALTER TABLE `product_price_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `1` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_price_details`
--
ALTER TABLE `product_price_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
