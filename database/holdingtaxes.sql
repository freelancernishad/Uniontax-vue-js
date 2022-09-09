-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2022 at 01:55 PM
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
-- Table structure for table `holdingtaxes`
--

CREATE TABLE `holdingtaxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unioun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holding_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maliker_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_or_samir_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gramer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `word_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nid_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `griher_barsikh_mullo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barsikh_muller_percent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jomir_vara` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_mullo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rokhona_bekhon_khoroch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prakklito_mullo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reyad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `angsikh_prodoy_korjoggo_barsikh_mullo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barsikh_vara` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rokhona_bekhon_khoroch_percent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prodey_korjoggo_barsikh_mullo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prodey_korjoggo_barsikh_varar_mullo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_prodey_korjoggo_barsikh_mullo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_year_kor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bokeya` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_bokeya` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holdingtaxes`
--

INSERT INTO `holdingtaxes` (`id`, `category`, `unioun`, `holding_no`, `maliker_name`, `father_or_samir_name`, `gramer_name`, `word_no`, `nid_no`, `mobile_no`, `griher_barsikh_mullo`, `barsikh_muller_percent`, `jomir_vara`, `total_mullo`, `rokhona_bekhon_khoroch`, `prakklito_mullo`, `reyad`, `angsikh_prodoy_korjoggo_barsikh_mullo`, `barsikh_vara`, `rokhona_bekhon_khoroch_percent`, `prodey_korjoggo_barsikh_mullo`, `prodey_korjoggo_barsikh_varar_mullo`, `total_prodey_korjoggo_barsikh_mullo`, `current_year_kor`, `bokeya`, `total_bokeya`, `created_at`, `updated_at`) VALUES
(2, 'মালিক নিজে বসবাসকারী', 'tungibaria', '896789', 'মালিকের নাম', 'পিতা/স্বামীর নাম', 'গ্রামের নাম', '3', '১২৫৪৭৮৯৩২', '01909756552', '100000', '7500', '2000', '9500', '1583.3333333333', '7916.6666666667', '1979.1666666667', '', '0', '', '5937.5', '', '', '415.625', '[{\"itemId\":null,\"status\":null,\"year\":\"2020 2021\",\"price\":\"200\"},{\"itemId\":null,\"status\":null,\"year\":\"2019 2020\",\"price\":\"100\"}]', '715.625', '2022-09-08 07:39:47', '2022-09-08 07:39:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `holdingtaxes`
--
ALTER TABLE `holdingtaxes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `holdingtaxes`
--
ALTER TABLE `holdingtaxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
