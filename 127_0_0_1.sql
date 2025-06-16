-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 16 juin 2025 à 11:13
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `wec_2025`
--
CREATE DATABASE IF NOT EXISTS `wec_2025` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `wec_2025`;

-- --------------------------------------------------------

--
-- Structure de la table `newsletter_subscribers`
--

DROP TABLE IF EXISTS `newsletter_subscribers`;
CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `races`
--

DROP TABLE IF EXISTS `races`;
CREATE TABLE IF NOT EXISTS `races` (
  `id` int NOT NULL AUTO_INCREMENT,
  `race_name` varchar(100) NOT NULL,
  `circuit` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `race_date` date NOT NULL,
  `video_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `image_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `races`
--

INSERT INTO `races` (`id`, `race_name`, `circuit`, `category`, `race_date`, `video_url`, `image_url`) VALUES
(22, '6 Heures d\'Imola', 'Imola (Italie)', 'Hypercar / LMGT3', '2024-04-21', 'https://www.youtube.com/embed/39NkGjqYmRU?si=nQzLDEBsuN3iGpKv', NULL),
(23, '6 Heures de Spa-Francorchamps', 'Spa-Francorchamps (Belgique)', 'Hypercar / LMGT3', '2024-05-11', 'https://www.youtube.com/embed/FSsXSZedSbw?si=It7fjxXp0Kgbymbe', NULL),
(21, '1812 km du Qatar', 'Losail (Qatar)', 'Hypercar / LMGT3', '2024-03-02', 'https://www.youtube.com/embed/5CoAHA24F-U', NULL),
(26, 'Lone Star Le Mans', 'Cota (États-Unis)', 'Hypercar / LMGT3', '2024-09-01', 'https://www.youtube.com/embed/6-XFEs0IpjM?si=4KJpu3U1dEV_VjOF', NULL),
(24, '24h du Mans', 'Le Mans (France)', 'Hypercar / LMP2 / LMGT3', '2024-06-15', 'https://www.youtube.com/embed/9alDzunP4k8?si=2oY6M97tTp-6XG-k', NULL),
(25, '6 Heures de São Paulo', 'Interlagos (Brésil)', 'Hypercar / LMGT3', '2024-08-14', 'https://www.youtube.com/embed/P5SKqicLoAo?si=zfRiZJWDTEJrE4Sr', NULL),
(27, '6 Heures de Fuji', 'Fuji Speedway (Japon)', 'Hypercar / LMGT3', '2024-09-15', 'https://www.youtube.com/embed/28-Y526iyug?si=uOZ0eeNOkYWxQ4vE', NULL),
(28, '8 Heures de Bahreïn', 'Bahreïn International Circuit (Bahreïn)', 'Hypercar / LMGT3', '2024-11-02', 'https://www.youtube.com/embed/Ez546QuEojE?si=5_XlocAIYhfD1BKx', NULL),
(29, '1812 km du Qatar ', 'Losail (Qatar)', 'Hypercar / LMGT3', '2025-02-28', 'https://www.youtube.com/embed/V5uGpQBDfCE?si=CXUgq4KdS46Lgyu_', NULL),
(30, '6 Heures d\'Imola', 'Imola (Italie)', 'Hypercar / LMGT3', '2025-04-20', 'https://www.youtube.com/embed/NYj-2bkuQSc?si=rAsE0tw8R5AK0BK3', NULL),
(31, '6 Heures de Spa-Francorchamps', 'Spa-Francorchamps (Belgique)', 'Hypercar / LMGT3', '2025-05-10', 'https://www.youtube.com/embed/YnDrf2q5UHc?si=t3T4hV2HL42eI7TX', NULL),
(32, '24h du Mans', 'Le Mans (France)', 'Hypercar / LMP2 / LMGT3', '2025-06-14', 'https://www.youtube.com/embed/XUf5vNgMFoc?si=4e4QiJiG5r1-2UXP', ''),
(33, '6 Heures de São Paulo', 'Interlagos (Brésil)', 'Hypercar / LMGT3', '2025-07-13', '', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTXazyfLxPNu7HobrtQAOUVqW_bp_9WnWvLiQ&s'),
(34, 'Lone Star Le Mans', 'Cota (États-Unis)', 'Hypercar / LMGT3', '2025-09-07', '', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXr9heaRXCtyTdeVxMIxwJwrztFnLOu_gNIw&s'),
(35, '6 Heures de Fuji', 'Fuji Speedway (Japon)', 'Hypercar / LMGT3', '2025-09-28', '', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjGZAsFYkJn2rClo4W4DOuW2Z1Agdsg6KDzA&s'),
(36, '8 Heures de Bahreïn', 'Bahreïn International Circuit (Bahreïn)', 'Hypercar / LMGT3', '2025-11-08', '', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR2yVRpYxAjOimmoPYzjt7xT5HqgEtQ6JD52A&s');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `is_admin`, `first_name`, `last_name`) VALUES
(16, 'test@example.com', '$2y$10$t8EtmdJNgFmrPD9dAkYnAOO00N94/M5AQWYTXjnEP2/pJUJyTxyPm', 0, 'test', 'test'),
(19, 'testmail@mail.com', '$2y$10$2OqGkQhhuoSYbG8xJwgLqOplz8WI2gpb161J7P10D6NIg2gdd4CYW', 0, 'Romain', 'Mazille'),
(15, 'admin@example.com', '$2y$10$D.yzuwpQKzJkNH4bdfbbce8eflKz9dNV.x0CgQ8BCh25lO3gqk/Xm', 1, '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
