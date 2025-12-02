-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2025 at 08:13 PM
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
-- Database: `appFAQ`
--

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id_faq` bigint(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `reponse` varchar(255) NOT NULL DEFAULT '',
  `dat_question` datetime(6) NOT NULL,
  `dat_reponse` datetime(6) DEFAULT NULL,
  `id_user` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ligue`
--

CREATE TABLE `ligue` (
  `id_ligue` bigint(11) NOT NULL,
  `lib_ligue` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ligue`
--

INSERT INTO `ligue` (`id_ligue`, `lib_ligue`) VALUES
(1, 'Football'),
(2, 'Basketball'),
(3, 'Volleyball'),
(4, 'Handball'),
(5, 'Toutes les ligues');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` bigint(11) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `id_usertype` bigint(11) NOT NULL,
  `id_ligue` bigint(11) NOT NULL,
  `dateNaissance` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `pseudo`, `mdp`, `mail`, `id_usertype`, `id_ligue`, `dateNaissance`) VALUES
(12, 'SuperAdmin', '$2y$10$QiAP4jaNpBtZ6WgU9YihPO.O.gFJdPIFv9twkex6/HPjSQgocYele', 'superadmin@limayrac.fr', 3, 5, '2015-12-17'),
(14, 'adminfoot', '$2y$10$hwVoAW2fXYizEn6OvKrBh.KvHG.0ICp.LYbw2vTJdR.r8c1J2JyoS', 'adminfoot@limayrac.com', 2, 1, '0000-00-00'),
(15, 'adminvolley', '$2y$10$dwlu7QT2GVy1n9WO/iScOOMsI.RT7OLsYDllnHBhcVhRvK.F7mJnu', 'adminvolley@limayrac.fr', 2, 3, '0000-00-00'),
(16, 'adminhand', '$2y$10$EzPoMByyznAq55EYVZXeYuLkq7law3UFRW7.wFFpb/xNomxJZJtEK', 'adminhand@limayrac.fr', 2, 4, '0000-00-00'),
(17, 'adminbasket', '$2y$10$aj9DpH/idqx1QkQsbto4UeO/oVRN49cliqTWM1YKsis7IvS0zuWXa', 'adminbasket@limayrac.fr', 2, 2, '0000-00-00'),
(23, 'U1foot', '$2y$10$s6H/lQV4kolUMGj9NW28OO4m8BH1lJEOLhCi9AEMj5YbO1d.uN3XW', 'utilisateurfoot@limayrac.fr', 1, 1, '0000-00-00'),
(25, 'U1basketball', '$2y$10$PUakTEfx2lXPovUyzra4dusAWe6DwVSbD0RdM1zIWbG62HgeaY3Ku', 'utilisateurbasketball@limayrac.Fr', 1, 2, '0000-00-00'),
(26, 'U1volleyball', '$2y$10$..3oVTF4L4ed4dCf/ly.3OFl0iOKnnF.SYfslXk8oGiWzdQagbmWy', 'utilisateurvolleyball@limayrac.fr', 1, 3, '0000-00-00'),
(27, 'U1handball', '$2y$10$FJRjJcIXRY3HoCQcLIrg/OboH/9FG7Ms3YbjQV1Ng337v7rG7MGlq', 'utilisateurhandball@limayrac.fr', 1, 4, '0000-00-00'),
(34, 'test3', '$2y$10$.ZY8y7smUXg.wIw0SU8bSu3SQ/Q8ncW00dZ29wkzWaYhKwFk1eDfq', 'test@lim.fr', 1, 2, '2005-11-02');

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `id_usertype` bigint(11) NOT NULL,
  `lib_usertype` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`id_usertype`, `lib_usertype`, `description`) VALUES
(1, 'user', 'utilisateur lambda'),
(2, 'admin', 'repond aux questions, peut les modifier et les sup'),
(3, 'superadmin', 's occupe de toute la FAQ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faq`),
  ADD KEY `redige` (`id_user`);

--
-- Indexes for table `ligue`
--
ALTER TABLE `ligue`
  ADD PRIMARY KEY (`id_ligue`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `appartient` (`id_ligue`),
  ADD KEY `est de type` (`id_usertype`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`id_usertype`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id_faq` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `ligue`
--
ALTER TABLE `ligue`
  MODIFY `id_ligue` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `id_usertype` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `faq`
--
ALTER TABLE `faq`
  ADD CONSTRAINT `fk_faq_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `est de type` FOREIGN KEY (`id_usertype`) REFERENCES `usertype` (`id_usertype`),
  ADD CONSTRAINT `fk_user_ligue` FOREIGN KEY (`id_ligue`) REFERENCES `ligue` (`id_ligue`),
  ADD CONSTRAINT `fk_user_usertype` FOREIGN KEY (`id_usertype`) REFERENCES `usertype` (`id_usertype`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
