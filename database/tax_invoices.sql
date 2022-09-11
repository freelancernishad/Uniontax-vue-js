-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2022 at 12:34 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uniontax_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `tax_invoices`
--

CREATE TABLE `tax_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoiceId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holdingTax_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PayYear` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `totalAmount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tax_invoices`
--

INSERT INTO `tax_invoices` (`id`, `invoiceId`, `holdingTax_id`, `PayYear`, `totalAmount`, `created_at`, `updated_at`) VALUES
(2, 'sdfsdf', '4', '2022', '293.5625', '2022-09-11 21:51:58', '2022-09-11 22:11:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tax_invoices`
--
ALTER TABLE `tax_invoices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tax_invoices`
--
ALTER TABLE `tax_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
