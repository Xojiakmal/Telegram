-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 04, 2026 at 01:43 PM
-- Server version: 8.0.30
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Imtihon2`
--

-- --------------------------------------------------------

--
-- Table structure for table `informations`
--

CREATE TABLE `informations` (
  `id` int NOT NULL,
  `message` text NOT NULL,
  `users_id` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int NOT NULL,
  `text` text NOT NULL,
  `user_id` int NOT NULL,
  `create_ad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `yosh` int NOT NULL,
  `tel` varchar(14) NOT NULL,
  `millat` text NOT NULL,
  `jins` text NOT NULL,
  `other` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `yosh`, `tel`, `millat`, `jins`, `other`) VALUES
(1, 'Ali', 16, '+998901112233', 'Uzbek', 'Erkak', '{\"mfy\": \"Yoshlik\", \"kocha\": \"Mustaqillik\", \"davlat\": \"Uzbekistan\"}'),
(2, 'Dilshod', 18, '+998933334455', 'Uzbek', 'Erkak', '{\"mfy\": \"Do‘stlik\", \"kocha\": \"Navbahor\", \"davlat\": \"Uzbekistan\"}'),
(3, 'Malika', 17, '+998991234567', 'Uzbek', 'Ayol', '{\"mfy\": \"Bog‘bon\", \"kocha\": \"Gulzor\", \"davlat\": \"Uzbekistan\"}'),
(4, 'Jasmin', 19, '+998977778899', 'Tojik', 'Ayol', '{\"mfy\": \"Sharq\", \"kocha\": \"Istiqlol\", \"davlat\": \"Uzbekistan\"}'),
(5, 'Bekzod', 20, '+998935551122', 'Qozoq', 'Erkak', '{\"mfy\": \"Tinchlik\", \"kocha\": \"Yangi hayot\", \"davlat\": \"Uzbekistan\"}'),
(6, 'Sardor', 15, '+998909876543', 'Uzbek', 'Erkak', '{\"mfy\": \"Obod\", \"kocha\": \"Paxtakor\", \"davlat\": \"Uzbekistan\"}'),
(7, 'Zarina', 18, '+998941112244', 'Qirg‘iz', 'Ayol', '{\"mfy\": \"Bahor\", \"kocha\": \"Lola\", \"davlat\": \"Uzbekistan\"}'),
(8, 'Ali', 16, '+998901112233', 'Uzbek', 'Erkak', '{\"mfy\": \"Yoshlik\", \"kocha\": \"Mustaqillik\", \"davlat\": \"O‘zbekiston\"}'),
(9, 'Malika', 17, '+998991234567', 'Uzbek', 'Ayol', '{\"mfy\": \"Bog‘bon\", \"kocha\": \"Gulzor\", \"davlat\": \"O‘zbekiston\"}'),
(10, 'Bekzod', 20, '+998935551122', 'Qozoq', 'Erkak', '{\"mfy\": \"Tinchlik\", \"kocha\": \"Yangi hayot\", \"davlat\": \"O‘zbekiston\"}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `informations`
--
ALTER TABLE `informations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
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
-- AUTO_INCREMENT for table `informations`
--
ALTER TABLE `informations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
