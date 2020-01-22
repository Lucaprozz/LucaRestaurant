-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2020 at 03:02 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lucarestaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_cart`
--

CREATE TABLE `bank_cart` (
  `id` int(11) NOT NULL,
  `userid_id_id` int(11) NOT NULL,
  `accountnr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cardnr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `omschrijving` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fos_user`
--

CREATE TABLE `fos_user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `last_activity` datetime DEFAULT NULL,
  `telnr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobilenr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insertionname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adres` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `last_activity`, `telnr`, `mobilenr`, `firstname`, `insertionname`, `lastname`, `adres`, `zip`, `city`, `country`) VALUES
(1, 'lucauser', 'lucauser', 'lucadowdenanthony@icloud.com', 'lucadowdenanthony@icloud.com', 1, NULL, '$2y$13$ZVDSLYJo..A5zMqSuq7Kge..fPNmP3w6RkEkjOSU7aTlHztfXMW4.', '2020-01-22 02:46:49', NULL, NULL, 'a:1:{i:0;s:13:\"ROLE_CUSTOMER\";}', '2020-01-22 02:50:54', '0654771519', '0654771519', 'Luca', 'lucauser', 'Dowden', 'Mokkabruin, 12', '2718NE', 'Zoetermeer', 'Netherlands'),
(2, 'lucamedewerker', 'lucamedewerker', 'lucamedewerker@icloud.com', 'lucamedewerker@icloud.com', 1, NULL, '$2y$13$PfVBQ85UBHXV4dnhly/uMOYnXS0PvzXqcgKrO0bQd7/0A6eUy.4i6', '2020-01-22 02:51:18', NULL, NULL, 'a:1:{i:0;s:15:\"ROLE_MEDEWERKER\";}', '2020-01-22 02:51:18', '0654771519', '0654771519', 'Luca', 'lucamedewerker', 'Droidw', 'Mokkabruin, 19', '2722NE', 'Zoetermeer', 'Netherlands'),
(3, 'lucaadmin', 'lucaadmin', 'lucaadmin@icloud.com', 'lucaadmin@icloud.com', 1, NULL, '$2y$13$3fRQ4Gp.4GZx/KVtSFt/eOu2wBWlbDJoL2SG9igXSfQlnNhAbah/6', '2020-01-22 02:42:28', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', '2020-01-22 02:46:08', '0654771519', '0654771519', 'Luca', 'lucaadmin', 'droedss', 'Mokkabruin, 14', '2720NE', 'Zoetermeer', 'Netherlands');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `product_id_id` int(11) NOT NULL,
  `omschrijving` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aantal` int(11) NOT NULL,
  `prijs` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `categorie_id_id` int(11) NOT NULL,
  `omschrijving` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prijs` double NOT NULL,
  `voorraad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservatie`
--

CREATE TABLE `reservatie` (
  `id` int(11) NOT NULL,
  `user_id_id` int(11) DEFAULT NULL,
  `medewerker_id_id` int(11) NOT NULL,
  `datum_tijd` datetime NOT NULL,
  `aantal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservatie`
--

INSERT INTO `reservatie` (`id`, `user_id_id`, `medewerker_id_id`, `datum_tijd`, `aantal`) VALUES
(1, 1, 1, '2020-05-22 17:00:00', 2),
(2, 1, 1, '2020-05-22 17:00:00', 10),
(3, 1, 1, '2022-01-22 17:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `reservatie_tafel`
--

CREATE TABLE `reservatie_tafel` (
  `id` int(11) NOT NULL,
  `reservatie_id_id` int(11) NOT NULL,
  `tafel_id_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservatie_tafel`
--

INSERT INTO `reservatie_tafel` (`id`, `reservatie_id_id`, `tafel_id_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tafel`
--

CREATE TABLE `tafel` (
  `id` int(11) NOT NULL,
  `personen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tafel`
--

INSERT INTO `tafel` (`id`, `personen`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 3),
(5, 3),
(6, 3),
(7, 4),
(8, 4),
(9, 4),
(10, 5),
(11, 5),
(12, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tijden`
--

CREATE TABLE `tijden` (
  `id` int(11) NOT NULL,
  `dag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `begintijd` time NOT NULL,
  `eindtijd` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_cart`
--
ALTER TABLE `bank_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A1C3DA39BD842010` (`userid_id_id`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fos_user`
--
ALTER TABLE `fos_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7D053A93DE18E50B` (`product_id_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD8A3C7387` (`categorie_id_id`);

--
-- Indexes for table `reservatie`
--
ALTER TABLE `reservatie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_956EA07F9D86650F` (`user_id_id`),
  ADD KEY `IDX_956EA07FD13DB2F4` (`medewerker_id_id`);

--
-- Indexes for table `reservatie_tafel`
--
ALTER TABLE `reservatie_tafel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_797412425F0EA862` (`reservatie_id_id`),
  ADD KEY `IDX_79741242A4835CDB` (`tafel_id_id`);

--
-- Indexes for table `tafel`
--
ALTER TABLE `tafel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tijden`
--
ALTER TABLE `tijden`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_cart`
--
ALTER TABLE `bank_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fos_user`
--
ALTER TABLE `fos_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservatie`
--
ALTER TABLE `reservatie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservatie_tafel`
--
ALTER TABLE `reservatie_tafel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tafel`
--
ALTER TABLE `tafel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tijden`
--
ALTER TABLE `tijden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_cart`
--
ALTER TABLE `bank_cart`
  ADD CONSTRAINT `FK_A1C3DA39BD842010` FOREIGN KEY (`userid_id_id`) REFERENCES `fos_user` (`id`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `FK_7D053A93DE18E50B` FOREIGN KEY (`product_id_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD8A3C7387` FOREIGN KEY (`categorie_id_id`) REFERENCES `categorie` (`id`);

--
-- Constraints for table `reservatie`
--
ALTER TABLE `reservatie`
  ADD CONSTRAINT `FK_956EA07F9D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `fos_user` (`id`),
  ADD CONSTRAINT `FK_956EA07FD13DB2F4` FOREIGN KEY (`medewerker_id_id`) REFERENCES `fos_user` (`id`);

--
-- Constraints for table `reservatie_tafel`
--
ALTER TABLE `reservatie_tafel`
  ADD CONSTRAINT `FK_797412425F0EA862` FOREIGN KEY (`reservatie_id_id`) REFERENCES `reservatie` (`id`),
  ADD CONSTRAINT `FK_79741242A4835CDB` FOREIGN KEY (`tafel_id_id`) REFERENCES `tafel` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
