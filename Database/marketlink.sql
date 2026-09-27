-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2026 at 11:03 AM
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
-- Database: `marketlink`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`) VALUES
(1, 'Vegetables', 'active', '2026-09-25 07:35:35'),
(2, 'Fruits', 'active', '2026-09-25 07:35:35'),
(3, 'Dairy', 'active', '2026-09-25 07:35:35'),
(4, 'Grains', 'active', '2026-09-25 07:35:35'),
(5, 'Organic', 'active', '2026-09-25 07:35:35'),
(6, 'Herbs', 'active', '2026-09-25 07:35:35');

-- --------------------------------------------------------

--
-- Table structure for table `favorite_farmers`
--

CREATE TABLE `favorite_farmers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `farmer_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_products`
--

CREATE TABLE `favorite_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `markets`
--

CREATE TABLE `markets` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `address` varchar(255) NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `markets`
--

INSERT INTO `markets` (`id`, `name`, `address`, `latitude`, `longitude`, `status`, `created_at`) VALUES
(1, 'Gulshan Fresh Market', 'Gulshan-e-Iqbal, Karachi', 24.9209000, 67.0882000, 'active', '2026-09-25 07:35:35'),
(2, 'Malir Farmers Market', 'Malir, Karachi', 24.8931000, 67.1980000, 'active', '2026-09-25 07:35:35'),
(3, 'North Nazimabad Market', 'North Nazimabad, Karachi', 24.9494000, 66.9997000, 'active', '2026-09-25 07:35:35'),
(4, 'Lahore Model Market', 'Model Town, Lahore', 31.4807000, 74.3233000, 'active', '2026-09-25 07:35:35');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(40) NOT NULL DEFAULT 'system',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`) VALUES
(16, 3, 'Order Completed', 'Your fruit order has been completed successfully.', 'order', 1, '2026-09-26 08:13:35'),
(17, 8, 'Order Placed', 'Your order has been placed and is waiting for farmer confirmation.', 'order', 0, '2026-09-26 08:13:35'),
(18, 2, 'New Order Received', 'You have received a new pending order from a customer.', 'order', 1, '2026-09-26 08:13:35'),
(19, 7, 'New Order Received', 'You have received a new pending order from a customer.', 'order', 0, '2026-09-26 08:13:35'),
(20, 8, 'Pickup time updated', 'Farmer set order #6 pickup time to 16:00:00.', 'order', 0, '2026-09-26 15:03:58'),
(21, 8, 'Order status updated', 'Order #6 is now accepted.', 'order', 0, '2026-09-26 15:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `market_id` int(10) UNSIGNED DEFAULT NULL,
  `pickup_date` date NOT NULL,
  `pickup_time` time NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','accepted','declined','ready','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `market_id`, `pickup_date`, `pickup_time`, `note`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(5, 3, 1, '2026-09-25', '14:00:00', 'Please keep the fruits fresh and ready for pickup.', 840.00, 'completed', '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(6, 8, 2, '2026-09-27', '16:00:00', 'Please prepare the fruits for pickup tomorrow.', 1020.00, 'accepted', '2026-09-26 08:13:35', '2026-09-26 15:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `product_name` varchar(150) NOT NULL,
  `farmer_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `farmer_id`, `quantity`, `unit_price`, `subtotal`) VALUES
(21, 5, 69, 'Fresh Banana', 2, 2, 180.00, 360.00),
(22, 5, 83, 'Fresh Mango', 7, 1, 480.00, 480.00),
(23, 6, 67, 'Fresh Apple', 2, 1, 420.00, 420.00),
(24, 6, 86, 'Fresh Orange', 7, 2, 260.00, 520.00),
(25, 6, 69, 'Fresh Banana', 2, 1, 180.00, 180.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `farmer_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `is_sold_out` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `farmer_id`, `category_id`, `name`, `description`, `price`, `stock`, `image`, `status`, `is_sold_out`, `created_at`, `updated_at`) VALUES
(67, 2, 2, 'Fresh Apple', 'Fresh and naturally sweet apples sourced from local farms.', 420.00, 40, 'APPLE.png.webp', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(68, 2, 2, 'Fresh Apricot', 'Juicy and naturally sweet fresh apricots.', 380.00, 30, 'APRICOT.png.jpg', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(69, 2, 2, 'Fresh Banana', 'Fresh ripe bananas with a naturally sweet taste.', 180.00, 50, 'BANANApng.webp', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(70, 2, 2, 'Fresh Chikoo', 'Naturally sweet and delicious fresh chikoo.', 280.00, 35, 'CHIKOO.png.jfif', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(71, 2, 2, 'Fresh Coconut', 'Fresh coconuts suitable for cooking and direct consumption.', 220.00, 30, 'COCONUT.png.webp', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(72, 2, 2, 'Fresh Custard Apple', 'Sweet and creamy fresh custard apples.', 450.00, 25, 'CUSTARD APPLE.png.webp', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(73, 2, 2, 'Fresh Dates', 'Naturally sweet and nutritious fresh dates.', 650.00, 25, 'DATES.png.jpg', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(74, 2, 2, 'Fresh Falsa', 'Fresh seasonal falsa berries with a sweet and tangy taste.', 350.00, 20, 'FALSA.png.jpg', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(75, 2, 2, 'Fresh Fig', 'Fresh figs with a naturally sweet flavor.', 550.00, 20, 'FIG.png.webp', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(76, 2, 2, 'Fresh Grapefruit', 'Juicy and refreshing grapefruit.', 300.00, 30, 'GRAPEFRUIT.png.jpg', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(77, 2, 2, 'Fresh Grapes', 'Sweet and juicy fresh grapes.', 320.00, 40, 'GRAPESpng.avif', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(78, 2, 2, 'Fresh Guava', 'Fresh green guavas with a crisp texture.', 220.00, 45, 'GUAVA.png.jpg', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(79, 2, 2, 'Fresh Jackfruit', 'Fresh and flavorful jackfruit sourced from local farms.', 300.00, 20, 'JACKFRUIT.png.avif', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(80, 2, 2, 'Fresh Kinnow', 'Juicy and refreshing kinnow, perfect for fresh juice.', 240.00, 40, 'KINNOW.png.jpg', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(81, 2, 2, 'Fresh Lemon', 'Fresh juicy lemons with a naturally tangy flavor.', 180.00, 60, 'LEMON.png.webp', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(82, 7, 2, 'Fresh Lychee', 'Sweet and juicy fresh lychees.', 520.00, 25, 'LYCHEE.png.jfif', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(83, 7, 2, 'Fresh Mango', 'Premium seasonal mangoes with rich natural flavor.', 480.00, 35, 'MANGO.png.jfif', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(84, 7, 2, 'Fresh Melon', 'Fresh juicy melon perfect for summer.', 250.00, 30, 'MELON.png.jpg', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(85, 7, 2, 'Fresh Mulberry', 'Fresh naturally sweet mulberries.', 450.00, 20, 'MULBERRY.png.webp', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(86, 7, 2, 'Fresh Orange', 'Juicy and refreshing fresh oranges.', 260.00, 45, 'ORANGE.png.webp', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(87, 7, 2, 'Fresh Papaya', 'Fresh ripe papaya with a naturally sweet taste.', 200.00, 35, 'PAPAYA.png.jpg', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(88, 7, 2, 'Fresh Peach', 'Juicy and naturally sweet fresh peaches.', 420.00, 25, 'PEACH.png.jfif', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(89, 7, 2, 'Fresh Pear', 'Crisp and juicy fresh pears.', 350.00, 35, 'PEAR.png.jfif', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(90, 7, 2, 'Fresh Persimmon', 'Sweet and flavorful fresh persimmons.', 500.00, 20, 'PERSIMMOM.png.webp', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(91, 7, 2, 'Fresh Plum', 'Fresh juicy plums with a sweet and tangy flavor.', 380.00, 30, 'PLUM.png.jpg', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(92, 7, 2, 'Fresh Pomegranate', 'Premium pomegranates with juicy flavorful seeds.', 450.00, 30, 'POMEGRANATE.png.jpg', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(93, 7, 2, 'Fresh Star Fruit', 'Fresh star fruit with a refreshing taste.', 320.00, 20, 'STAR FRUIT.png.webp', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(94, 7, 2, 'Fresh Strawberry', 'Fresh juicy strawberries with a naturally sweet taste.', 550.00, 25, 'STRAWBERRY.png.jpg', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(95, 7, 2, 'Fresh Tamarind', 'Fresh tamarind with a sweet and tangy flavor.', 300.00, 30, 'TAMARIND.png.webp', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35'),
(96, 7, 2, 'Fresh Watermelon', 'Fresh juicy watermelon perfect for summer.', 180.00, 40, 'WATERMELON.png.jpg', 'approved', 0, '2026-09-26 08:13:35', '2026-09-26 08:13:35');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `report_type` varchar(100) NOT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `total_sales` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_orders` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `report_type`, `period_start`, `period_end`, `total_sales`, `total_orders`, `created_at`) VALUES
(1, 'Current Snapshot', '2026-09-26', '2026-09-26', 840.00, 2, '2026-09-26 15:01:25'),
(2, 'Current Snapshot', '2026-09-27', '2026-09-27', 840.00, 2, '2026-09-27 07:58:00'),
(3, 'Current Snapshot', '2026-09-27', '2026-09-27', 840.00, 2, '2026-09-27 08:19:27');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` varchar(500) NOT NULL,
  `farmer_response` varchar(500) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `customer_id`, `rating`, `comment`, `farmer_response`, `status`, `created_at`) VALUES
(1, 69, 3, 5, 'Very good quality rocomended', NULL, 'approved', '2026-09-26 15:09:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `role` enum('admin','farmer','customer') NOT NULL DEFAULT 'customer',
  `market_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `approval_status` enum('pending','approved','suspended') NOT NULL DEFAULT 'approved',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `profile_image`, `role`, `market_id`, `status`, `approval_status`, `created_at`) VALUES
(1, 'System Admin', 'admin@example.com', '$2y$12$Lk7wpGFJnYAcZZmmhI95JOrt/VuRk9cuV9U4GRghhNdD5KR.CpfUC', '03000000000', NULL, 'admin', NULL, 'active', 'approved', '2026-09-25 07:35:35'),
(2, 'Green Valley Farms', 'farmer@example.com', '$2y$12$msI2sRiI7LtwG.Er5pOAYOf5wtoxh7XSBcmv8q4Qu72dPAp1NOpPu', '03111111111', NULL, 'farmer', 1, 'active', 'approved', '2026-09-25 07:35:35'),
(3, 'Ayesha Khan', 'customer@example.com', '$2y$12$9lqsgpZ0yukNhT.2TMKbl.9PqNf/Pyn3U4aiVfugg6SNX6esiKK4.', '03222222222', NULL, 'customer', NULL, 'active', 'approved', '2026-09-25 07:35:35'),
(7, 'Sunrise Organic Farms', 'farmer2@example.com', '$2y$12$msI2sRiI7LtwG.Er5pOAYOf5wtoxh7XSBcmv8q4Qu72dPAp1NOpPu', '03333333333', NULL, 'farmer', 2, 'active', 'approved', '2026-09-26 07:45:49'),
(8, 'Ali Ahmed', 'customer2@example.com', '$2y$12$9lqsgpZ0yukNhT.2TMKbl.9PqNf/Pyn3U4aiVfugg6SNX6esiKK4.', '03444444444', NULL, 'customer', NULL, 'active', 'approved', '2026-09-26 07:49:11'),
(9, 'owiii', 'customer1@example.com', '$2y$10$yTV1SPYZKvDiW/zvelGFKutmW0ZXeSB7fEdADwoebXYdWmaMJWyLK', '01111111111111111', NULL, 'customer', NULL, 'active', 'approved', '2026-09-26 08:00:22'),
(10, 'owiii', 'farmer1@example.com', '$2y$10$gvZmBxWQW4yzB1QOQtl0Yu/BwSeI1p3CmrgLAG2ZMtAW14gqE.i7G', '01111111111111111', NULL, 'farmer', 1, 'inactive', 'approved', '2026-09-26 08:04:30');

-- --------------------------------------------------------

--
-- Table structure for table `weekly_stock`
--

CREATE TABLE `weekly_stock` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `day_of_week` tinyint(3) UNSIGNED NOT NULL,
  `available_qty` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `weekly_stock`
--

INSERT INTO `weekly_stock` (`id`, `product_id`, `day_of_week`, `available_qty`) VALUES
(319, 67, 0, 40),
(320, 68, 0, 30),
(321, 69, 0, 50),
(322, 70, 0, 35),
(323, 71, 0, 30),
(324, 72, 0, 25),
(325, 73, 0, 25),
(326, 74, 0, 20),
(327, 75, 0, 20),
(328, 76, 0, 30),
(329, 77, 0, 40),
(330, 78, 0, 45),
(331, 79, 0, 20),
(332, 80, 0, 40),
(333, 81, 0, 60),
(334, 82, 0, 25),
(335, 83, 0, 35),
(336, 84, 0, 30),
(337, 85, 0, 20),
(338, 86, 0, 45),
(339, 87, 0, 35),
(340, 88, 0, 25),
(341, 89, 0, 35),
(342, 90, 0, 20),
(343, 91, 0, 30),
(344, 92, 0, 30),
(345, 93, 0, 20),
(346, 94, 0, 25),
(347, 95, 0, 30),
(348, 96, 0, 40),
(349, 67, 1, 40),
(350, 68, 1, 30),
(351, 69, 1, 50),
(352, 70, 1, 35),
(353, 71, 1, 30),
(354, 72, 1, 25),
(355, 73, 1, 25),
(356, 74, 1, 20),
(357, 75, 1, 20),
(358, 76, 1, 30),
(359, 77, 1, 40),
(360, 78, 1, 45),
(361, 79, 1, 20),
(362, 80, 1, 40),
(363, 81, 1, 60),
(364, 82, 1, 25),
(365, 83, 1, 35),
(366, 84, 1, 30),
(367, 85, 1, 20),
(368, 86, 1, 45),
(369, 87, 1, 35),
(370, 88, 1, 25),
(371, 89, 1, 35),
(372, 90, 1, 20),
(373, 91, 1, 30),
(374, 92, 1, 30),
(375, 93, 1, 20),
(376, 94, 1, 25),
(377, 95, 1, 30),
(378, 96, 1, 40),
(379, 67, 2, 40),
(380, 68, 2, 30),
(381, 69, 2, 50),
(382, 70, 2, 35),
(383, 71, 2, 30),
(384, 72, 2, 25),
(385, 73, 2, 25),
(386, 74, 2, 20),
(387, 75, 2, 20),
(388, 76, 2, 30),
(389, 77, 2, 40),
(390, 78, 2, 45),
(391, 79, 2, 20),
(392, 80, 2, 40),
(393, 81, 2, 60),
(394, 82, 2, 25),
(395, 83, 2, 35),
(396, 84, 2, 30),
(397, 85, 2, 20),
(398, 86, 2, 45),
(399, 87, 2, 35),
(400, 88, 2, 25),
(401, 89, 2, 35),
(402, 90, 2, 20),
(403, 91, 2, 30),
(404, 92, 2, 30),
(405, 93, 2, 20),
(406, 94, 2, 25),
(407, 95, 2, 30),
(408, 96, 2, 40),
(409, 67, 3, 40),
(410, 68, 3, 30),
(411, 69, 3, 50),
(412, 70, 3, 35),
(413, 71, 3, 30),
(414, 72, 3, 25),
(415, 73, 3, 25),
(416, 74, 3, 20),
(417, 75, 3, 20),
(418, 76, 3, 30),
(419, 77, 3, 40),
(420, 78, 3, 45),
(421, 79, 3, 20),
(422, 80, 3, 40),
(423, 81, 3, 60),
(424, 82, 3, 25),
(425, 83, 3, 35),
(426, 84, 3, 30),
(427, 85, 3, 20),
(428, 86, 3, 45),
(429, 87, 3, 35),
(430, 88, 3, 25),
(431, 89, 3, 35),
(432, 90, 3, 20),
(433, 91, 3, 30),
(434, 92, 3, 30),
(435, 93, 3, 20),
(436, 94, 3, 25),
(437, 95, 3, 30),
(438, 96, 3, 40),
(439, 67, 4, 40),
(440, 68, 4, 30),
(441, 69, 4, 50),
(442, 70, 4, 35),
(443, 71, 4, 30),
(444, 72, 4, 25),
(445, 73, 4, 25),
(446, 74, 4, 20),
(447, 75, 4, 20),
(448, 76, 4, 30),
(449, 77, 4, 40),
(450, 78, 4, 45),
(451, 79, 4, 20),
(452, 80, 4, 40),
(453, 81, 4, 60),
(454, 82, 4, 25),
(455, 83, 4, 35),
(456, 84, 4, 30),
(457, 85, 4, 20),
(458, 86, 4, 45),
(459, 87, 4, 35),
(460, 88, 4, 25),
(461, 89, 4, 35),
(462, 90, 4, 20),
(463, 91, 4, 30),
(464, 92, 4, 30),
(465, 93, 4, 20),
(466, 94, 4, 25),
(467, 95, 4, 30),
(468, 96, 4, 40),
(469, 67, 5, 40),
(470, 68, 5, 30),
(471, 69, 5, 50),
(472, 70, 5, 35),
(473, 71, 5, 30),
(474, 72, 5, 25),
(475, 73, 5, 25),
(476, 74, 5, 20),
(477, 75, 5, 20),
(478, 76, 5, 30),
(479, 77, 5, 40),
(480, 78, 5, 45),
(481, 79, 5, 20),
(482, 80, 5, 40),
(483, 81, 5, 60),
(484, 82, 5, 25),
(485, 83, 5, 35),
(486, 84, 5, 30),
(487, 85, 5, 20),
(488, 86, 5, 45),
(489, 87, 5, 35),
(490, 88, 5, 25),
(491, 89, 5, 35),
(492, 90, 5, 20),
(493, 91, 5, 30),
(494, 92, 5, 30),
(495, 93, 5, 20),
(496, 94, 5, 25),
(497, 95, 5, 30),
(498, 96, 5, 40),
(499, 67, 6, 40),
(500, 68, 6, 30),
(501, 69, 6, 50),
(502, 70, 6, 35),
(503, 71, 6, 30),
(504, 72, 6, 25),
(505, 73, 6, 25),
(506, 74, 6, 20),
(507, 75, 6, 20),
(508, 76, 6, 30),
(509, 77, 6, 40),
(510, 78, 6, 45),
(511, 79, 6, 20),
(512, 80, 6, 40),
(513, 81, 6, 60),
(514, 82, 6, 25),
(515, 83, 6, 35),
(516, 84, 6, 30),
(517, 85, 6, 20),
(518, 86, 6, 45),
(519, 87, 6, 35),
(520, 88, 6, 25),
(521, 89, 6, 35),
(522, 90, 6, 20),
(523, 91, 6, 30),
(524, 92, 6, 30),
(525, 93, 6, 20),
(526, 94, 6, 25),
(527, 95, 6, 30),
(528, 96, 6, 40);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `favorite_farmers`
--
ALTER TABLE `favorite_farmers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_favorite_farmer` (`user_id`,`farmer_id`),
  ADD KEY `fk_ff_farmer` (`farmer_id`);

--
-- Indexes for table `favorite_products`
--
ALTER TABLE `favorite_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_favorite_product` (`user_id`,`product_id`),
  ADD KEY `fk_fp_product` (`product_id`);

--
-- Indexes for table `markets`
--
ALTER TABLE `markets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifications_user` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_customer` (`customer_id`),
  ADD KEY `fk_orders_market` (`market_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_oi_order` (`order_id`),
  ADD KEY `idx_oi_product` (`product_id`),
  ADD KEY `idx_oi_farmer` (`farmer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_products_farmer` (`farmer_id`),
  ADD KEY `idx_products_category` (`category_id`),
  ADD KEY `idx_products_status` (`status`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reviews_product` (`product_id`),
  ADD KEY `fk_reviews_customer` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_market` (`market_id`);

--
-- Indexes for table `weekly_stock`
--
ALTER TABLE `weekly_stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_weekly_stock` (`product_id`,`day_of_week`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `favorite_farmers`
--
ALTER TABLE `favorite_farmers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorite_products`
--
ALTER TABLE `favorite_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `markets`
--
ALTER TABLE `markets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `weekly_stock`
--
ALTER TABLE `weekly_stock`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=529;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorite_farmers`
--
ALTER TABLE `favorite_farmers`
  ADD CONSTRAINT `fk_ff_farmer` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ff_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorite_products`
--
ALTER TABLE `favorite_products`
  ADD CONSTRAINT `fk_fp_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_fp_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_customer` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orders_market` FOREIGN KEY (`market_id`) REFERENCES `markets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_oi_farmer` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_oi_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_oi_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_products_farmer` FOREIGN KEY (`farmer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_customer` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_market` FOREIGN KEY (`market_id`) REFERENCES `markets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `weekly_stock`
--
ALTER TABLE `weekly_stock`
  ADD CONSTRAINT `fk_weekly_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
