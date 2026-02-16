-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2026 at 01:43 PM
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
(3, 'Pure Honeys', 1, '2026-02-10 05:30:44', '2026-02-16 05:09:03');

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
  `updated_at` datetime NOT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `use_limit` int(11) NOT NULL,
  `use_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `status`, `created_at`, `updated_at`, `expiry_date`, `use_limit`, `use_count`) VALUES
(1, 'SAVE10', 0, 257, 1, '2026-02-10 12:00:03', '2026-02-10 12:16:43', '2026-02-28 17:20:16', 12, 1),
(3, 'SAVE20', 0, 250, 1, '2026-02-16 07:37:51', '2026-02-16 07:38:11', '2026-03-07 00:00:00', 15, NULL),
(4, 'SAVE30', 0, 250, 1, '2026-02-16 07:45:23', '2026-02-16 07:45:23', '2026-03-14 00:00:00', 10, NULL),
(5, 'SAVE40', 0, 500, 1, '2026-02-16 07:47:13', '2026-02-16 07:47:29', '2026-03-06 00:00:00', 20, NULL);

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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `address_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `cart_id`, `user_id`, `weight`, `price`, `discount`, `coupon_code`, `total`, `payment_type`, `status`, `address_id`, `order_date`, `delivery_date`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 2, NULL, 100, 0, '0', 200, 1, 0, 3, '2026-02-16 07:18:09', '2026-02-16 07:18:09', '2026-02-14 07:18:09', '2026-02-14 07:18:09'),
(2, 4, 2, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-17 07:26:13', '2026-02-21 07:26:13', '2026-02-14 07:26:13', '2026-02-14 07:26:13'),
(3, 4, 3, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 07:27:10', '2026-02-21 07:27:10', '2026-02-14 07:27:10', '2026-02-14 07:27:10'),
(4, 4, 4, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 07:30:15', '2026-02-21 07:30:15', '2026-02-14 07:30:15', '2026-02-14 07:30:15'),
(5, 4, 5, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 07:34:41', '2026-02-21 07:34:41', '2026-02-14 07:34:41', '2026-02-14 07:34:41'),
(6, 4, 6, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 07:36:38', '2026-02-21 07:36:38', '2026-02-14 07:36:38', '2026-02-14 07:36:38'),
(7, 5, 7, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 07:39:41', '2026-02-21 07:39:41', '2026-02-14 07:39:41', '2026-02-14 07:39:41'),
(8, 7, 8, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 07:42:21', '2026-02-21 07:42:21', '2026-02-14 07:42:21', '2026-02-14 07:42:21'),
(9, 5, 9, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 07:46:11', '2026-02-21 07:46:11', '2026-02-14 07:46:11', '2026-02-14 07:46:11'),
(10, 4, 10, 2, NULL, 100, 0, '0', 100, 1, 1, 3, '2026-02-14 07:48:29', '2026-02-21 07:48:29', '2026-02-14 07:48:29', '2026-02-14 07:48:51'),
(11, 2, 11, 2, NULL, 100, 0, '0', 100, 1, 1, 3, '2026-02-14 08:53:27', '2026-02-21 08:53:27', '2026-02-14 08:53:27', '2026-02-14 08:53:49'),
(12, 3, 12, 2, NULL, 100, 0, '0', 100, 1, 1, 3, '2026-02-14 08:53:27', '2026-02-21 08:53:27', '2026-02-14 08:53:27', '2026-02-14 08:53:49'),
(13, 4, 13, 2, NULL, 100, 0, '0', 300, 1, 1, 3, '2026-02-14 08:53:27', '2026-02-21 08:53:27', '2026-02-14 08:53:27', '2026-02-14 08:53:49'),
(14, 4, 14, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 08:55:49', '2026-02-21 08:55:49', '2026-02-14 08:55:49', '2026-02-14 08:55:49'),
(15, 3, 15, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 09:05:26', '2026-02-21 09:05:26', '2026-02-14 09:05:26', '2026-02-14 09:05:26'),
(16, 5, 16, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 09:05:26', '2026-02-21 09:05:26', '2026-02-14 09:05:26', '2026-02-14 09:05:26'),
(17, 4, 17, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 09:06:22', '2026-02-17 09:06:22', '2026-02-14 09:06:22', '2026-02-14 09:06:22'),
(18, 2, 18, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 09:06:22', '2026-02-21 09:06:22', '2026-02-14 09:06:22', '2026-02-14 09:06:22'),
(19, 6, 19, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 09:06:22', '2026-02-21 09:06:22', '2026-02-14 09:06:22', '2026-02-14 09:06:22'),
(20, 4, 20, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 09:09:39', '2026-02-21 09:09:39', '2026-02-14 09:09:39', '2026-02-14 09:09:39'),
(21, 7, 21, 2, NULL, 100, 0, '0', 200, 1, 0, 3, '2026-02-14 09:09:39', '2026-02-21 09:09:39', '2026-02-14 09:09:39', '2026-02-14 09:09:39'),
(22, 4, 22, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 09:13:30', '2026-02-21 09:13:30', '2026-02-14 09:13:30', '2026-02-14 09:13:30'),
(23, 5, 23, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 09:13:30', '2026-02-21 09:13:30', '2026-02-14 09:13:30', '2026-02-14 09:13:30'),
(24, 7, 24, 2, NULL, 100, 0, '0', 100, 1, 0, 3, '2026-02-14 09:13:30', '2026-02-21 09:13:30', '2026-02-14 09:13:30', '2026-02-14 09:13:30'),
(25, 4, 25, 2, NULL, 100, 0, '0', 100, 1, 3, 3, '2026-02-14 09:14:43', '2026-02-17 09:14:43', '2026-02-14 09:14:43', '2026-02-14 10:39:48'),
(26, 5, 26, 2, NULL, 100, 0, '0', 200, 1, 2, 3, '2026-02-14 09:14:43', '2026-02-21 09:14:43', '2026-02-14 09:14:43', '2026-02-16 09:39:55'),
(27, 6, 27, 2, NULL, 100, 0, '0', 100, 1, 1, 3, '2026-02-14 09:14:43', '2026-02-21 09:14:43', '2026-02-14 09:14:43', '2026-02-14 09:15:04'),
(28, 5, 28, 2, NULL, 100, 0, '0', 100, 1, 2, 3, '2026-02-14 09:15:43', '2026-02-21 09:15:43', '2026-02-14 09:15:43', '2026-02-16 09:37:17'),
(29, 8, 36, 2, '100', 100, 0, '0', 100, 2, 1, 3, '2026-02-16 10:48:21', '2026-02-23 10:48:21', '2026-02-16 10:48:21', '2026-02-16 10:48:21'),
(30, 9, 37, 2, '100', 100, 0, '0', 100, 2, 1, 3, '2026-02-16 10:48:21', '2026-02-23 10:48:21', '2026-02-16 10:48:21', '2026-02-16 10:48:21'),
(31, 10, 39, 2, '100', 100, 0, '0', 100, 1, 1, 3, '2026-02-16 10:49:43', '2026-02-23 10:49:43', '2026-02-16 10:49:43', '2026-02-16 10:50:07'),
(32, 12, 40, 2, '100', 100, 250, 'SAVE20', 500, 1, 1, 3, '2026-02-16 12:13:39', '2026-02-23 12:13:39', '2026-02-16 12:13:39', '2026-02-16 12:14:03'),
(33, 9, 41, 2, '100', 100, 0, 'SAVE30', 1000, 2, 1, 3, '2026-02-16 12:43:01', '2026-02-23 12:43:01', '2026-02-16 12:43:01', '2026-02-16 12:43:01');

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
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `order_id`, `payment_id`, `razorpay_order_id`, `signature`, `payment_method`, `amount`, `payment_status`, `status`, `created_at`, `updated_at`) VALUES
(1, '10', 'pay_SFwtE1vOkkzVdo', 'order_SFwt8P5bygBuCq', '6c30d7a0a8fd73c4d94c32e5cdbc42ad01f1c79af4f1884db73989d30f40e423', 'Razorpay', 0, '1', 1, '2026-02-14 07:48:51', '2026-02-14 07:48:51'),
(2, '11', 'pay_SFxzqirLVX16XM', 'order_SFxzji5LMC0Hhv', 'ffca007a179aa7f5f79c26ebd27d2c20017043443abf3de87c242eb4407c022f', 'Razorpay', 0, '1', 1, '2026-02-14 08:53:49', '2026-02-14 08:53:49'),
(3, '12', 'pay_SFxzqirLVX16XM', 'order_SFxzji5LMC0Hhv', 'ffca007a179aa7f5f79c26ebd27d2c20017043443abf3de87c242eb4407c022f', 'Razorpay', 0, '1', 1, '2026-02-14 08:53:49', '2026-02-14 08:53:49'),
(4, '13', 'pay_SFxzqirLVX16XM', 'order_SFxzji5LMC0Hhv', 'ffca007a179aa7f5f79c26ebd27d2c20017043443abf3de87c242eb4407c022f', 'Razorpay', 0, '1', 1, '2026-02-14 08:53:49', '2026-02-14 08:53:49'),
(5, '[25,26,27]', 'pay_SFyMITGjEyTDDw', 'order_SFyMDKGf7h1wXv', '92c0c2548c4dbc66b4bd5d44c2c5d6c5b75d4e32aeb1cf5882f82082950691fb', 'Razorpay', 400, '1', 1, '2026-02-14 09:15:04', '2026-02-14 09:15:04'),
(6, '[28]', 'pay_SFyNKyBDPNweaz', 'order_SFyNGMYvlrddSq', 'f6f58eb52739b95c03198a2dedeb494b4731ae03c614b02c83854eb32dfef278', 'Razorpay', 100, '1', 1, '2026-02-14 09:16:04', '2026-02-14 09:16:04'),
(7, '26', 'PAY_COD_1771234795', NULL, NULL, 'COD', 100, '1', 2, '2026-02-16 09:39:55', '2026-02-16 09:39:55'),
(8, '[31]', 'pay_SGn2yr75kymMwc', 'order_SGn2qhf5z8HalN', 'a977644010612b1daeab35150cd8b8056fe2eb1e2c253577c927ae0219b5e272', 'Razorpay', 100, '1', 1, '2026-02-16 10:50:07', '2026-02-16 10:50:07'),
(9, '[32]', 'pay_SGoTcrsyMReMpd', 'order_SGoTUxajFxKIFh', 'cef64eb9bb7dba57cc08584d7d58bd295e651f389d1c7f7dee48471731409fc6', 'Razorpay', 340, '1', 1, '2026-02-16 12:14:03', '2026-02-16 12:14:03');

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
  `gst` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `description`, `deals`, `weight`, `image`, `contains`, `quantity`, `gst`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Curry Leaf Powder', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770791978.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Coriander Powder\",\"Garlic\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\"]', 200, 18, 1, '2026-02-11 06:39:38', '2026-02-11 06:39:38'),
(3, 'Mango Pickle', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770792188.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Garlic\",\"Coriander Powder\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\",\"uploads\\/products\",\"Mango Pickle\"]', 250, 18, 1, '2026-02-11 06:43:08', '2026-02-11 06:43:08'),
(4, 'Mango Pickle', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770792188.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Garlic\",\"Coriander Powder\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\",\"uploads\\/products\",\"Mango Pickle\"]', 250, 18, 1, '2026-02-11 06:43:08', '2026-02-11 06:43:08'),
(5, 'Curry Leaf Powder', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770791978.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Coriander Powder\",\"Garlic\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\"]', 200, 18, 1, '2026-02-11 06:39:38', '2026-02-11 06:39:38'),
(6, 'Mango Pickle', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770792188.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Garlic\",\"Coriander Powder\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\",\"uploads\\/products\",\"Mango Pickle\"]', 250, 18, 1, '2026-02-11 06:43:08', '2026-02-11 06:43:08'),
(7, 'Curry Leaf Powder', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770791978.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Coriander Powder\",\"Garlic\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\"]', 200, 18, 1, '2026-02-11 06:39:38', '2026-02-11 06:39:38'),
(8, 'Mango Pickle', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770792188.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Garlic\",\"Coriander Powder\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\",\"uploads\\/products\",\"Mango Pickle\"]', 250, 18, 1, '2026-02-11 06:43:08', '2026-02-11 06:43:08'),
(9, 'Curry Leaf Powder', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770791978.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Coriander Powder\",\"Garlic\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\"]', 200, 18, 1, '2026-02-11 06:39:38', '2026-02-11 06:39:38'),
(10, 'Curry Leaf Powder', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770791978.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Coriander Powder\",\"Garlic\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\"]', 200, 18, 1, '2026-02-11 06:39:38', '2026-02-11 06:39:38'),
(11, 'Mango Pickle', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770792188.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Garlic\",\"Coriander Powder\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\",\"uploads\\/products\",\"Mango Pickle\"]', 250, 18, 1, '2026-02-11 06:43:08', '2026-02-11 06:43:08'),
(12, 'Curry Leaf Powder', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770791978.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Coriander Powder\",\"Garlic\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\"]', 200, 18, 1, '2026-02-11 06:39:38', '2026-02-11 06:39:38'),
(13, 'Mango Pickle', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770792188.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Garlic\",\"Coriander Powder\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\",\"uploads\\/products\",\"Mango Pickle\"]', 250, 18, 1, '2026-02-11 06:43:08', '2026-02-11 06:43:08'),
(14, 'Curry Leaf Powder', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770791978.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Coriander Powder\",\"Garlic\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\"]', 200, 18, 1, '2026-02-11 06:39:38', '2026-02-11 06:39:38'),
(15, 'Mango Pickle', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770792188.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Garlic\",\"Coriander Powder\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\",\"uploads\\/products\",\"Mango Pickle\"]', 250, 18, 1, '2026-02-11 06:43:08', '2026-02-11 06:43:08'),
(16, 'Curry Leaf Powder', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770791978.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Coriander Powder\",\"Garlic\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\"]', 200, 18, 1, '2026-02-11 06:39:38', '2026-02-11 06:39:38'),
(17, 'Curry Leaf Powder', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770791978.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Coriander Powder\",\"Garlic\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\"]', 200, 18, 1, '2026-02-11 06:39:38', '2026-02-11 06:39:38'),
(18, 'Curry Leaf Powder', 1, 'Fresh curry leaves are pounded with perfection and processed along with the choicest of spices to bring forth a healthy and tasty gastronomic treat. Just add ghee to hot rice and sprinkle Priya Curry Leaf Powder generously over it, or get it on board with idlis, dosas or upma. Pure bliss!', 1, '[{\"weight\":\"100\",\"price\":\"100\"},{\"weight\":\"500\",\"price\":\"450\"},{\"weight\":\"1000\",\"price\":\"850\"}]', '1770791978.webp', '[\"Curry Leaves Powder (11%)\",\"Refined Rice Bran Oil\",\"Coriander Powder\",\"Garlic\",\"Iodized Salt\",\"Chilli Powder\",\"Black Gram Lentils\",\"Cumin & Sesame Powder (1%)\"]', 200, 18, 1, '2026-02-11 06:39:38', '2026-02-11 06:39:38');

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
('09hGb9UgDNIjylpOc788Jb6uuEhQzjF2fDP52NWq', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibXYzaHgzWVRaeUlGVU1kbUJjb0N1QXBHbUpRcDlrWTlyWUtmYnZXYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3QvcGlja2xlL2NhcnQvbmF2YmFyIjtzOjU6InJvdXRlIjtzOjExOiJjYXJ0Lm5hdmJhciI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czo2OiJjb3Vwb24iO2E6Mzp7czo0OiJjb2RlIjtzOjY6IlNBVkUzMCI7czo4OiJkaXNjb3VudCI7aToyNTA7czo3OiJ1c2VyX2lkIjtpOjI7fX0=', 1771245783);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 2,
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

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `status`, `otp`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'adminpickle@gmail.com', '9994394717', 1, '1', NULL, NULL, '$2y$12$htUsrXlpIzQTDbLNMHnRwOvHWPNNPV5fl55G24xvk1k...', NULL, '2026-02-11 05:04:08', '2026-02-11 05:04:08'),
(2, 'Anandh', 'anandhwebbitech@gmail.com', '9994394718', 2, '1', NULL, NULL, '$2y$12$htUsrXlpIzQTDbLNMHnRwOvHWPNNPV5fl55G24xvk1kDKp3Sluv.O', NULL, '2026-02-10 23:50:05', '2026-02-12 05:26:17'),
(3, 'Nithyanandhan K', 'anandwebbitech@gmail.com', '9994394719', 2, '1', NULL, NULL, '$2y$12$vgEqWxeBlIYxUUYJXyRanOJcI5O27d1zo49SRuMGMAAVDr8vZumz.', NULL, '2026-02-10 23:56:56', '2026-02-10 23:56:56'),
(4, 'Prabu', 'prabuwebbitech@gmail.com', '9994394720', 2, '1', NULL, NULL, '$2y$12$0r5ZGYEySEF/VHS3zA.iDeAodOe97YgnQUAu/RIECcF3jc2TKnRfy', NULL, '2026-02-11 00:00:29', '2026-02-11 00:00:29'),
(7, 'Admin', 'admin@gmail.com', '9994394799', 1, '1', NULL, NULL, '$2y$12$htUsrXlpIzQTDbLNMHnRwOvHWPNNPV5fl55G24xvk1kDKp3Sluv.O', NULL, '2026-02-10 23:50:05', '2026-02-12 05:26:17');

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
(1, 2, 'Dustin Buck', '12345678945', 'Est maiores corrupti', 'Numquam in sint ape', '785685', '672 New Street', 1, 0, '2026-02-12 07:27:43', '2026-02-12 09:19:54'),
(2, 2, 'Nithyanandhan K', '7586954852', 'Coimbatore', 'Tamil Nadu', '641002', 'ryuytfdgf', 1, 0, '2026-02-12 09:00:56', '2026-02-12 09:19:54'),
(3, 2, 'Farrah Cunningham', '4589658745', 'Asperiores sit mole', 'Molestias laborum ob', '752989', '78 Rocky Cowley Street', 1, 1, '2026-02-12 09:10:57', '2026-02-12 09:19:54');

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
