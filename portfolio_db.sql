-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 17 mai 2025 à 19:19
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `portfolio_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `about_content`
--

CREATE TABLE `about_content` (
  `id` int(11) NOT NULL,
  `section` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `about_content`
--

INSERT INTO `about_content` (`id`, `section`, `content`, `updated_at`) VALUES
(3, 'parcours', 'dfgfhgg', '2025-05-17 14:49:28'),
(4, 'competences', 'dgfhgg', '2025-05-17 14:49:28'),
(5, 'parcours', 'dfgfhgg', '2025-05-17 14:49:36'),
(6, 'competences', 'dgfhgg', '2025-05-17 14:49:36'),
(7, 'parcours', 'dfgfhgg', '2025-05-17 14:50:33'),
(8, 'competences', 'dgfhgg', '2025-05-17 14:50:33');

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `created_at`) VALUES
(2, 'admin@example.com', '$2y$10$7dgUzQ/yjdRFhpaPd7YZNu67FnFjaVu5TxMGr5K2o3EztifsGy6di', '2025-05-17 12:31:43');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'rectuteur', 'andrianletsy17@gmail.com', 'demande', 'rr', '2025-05-17 15:39:20'),
(2, 'Andriamalala Tsirifanantenana', 'aadmin@gmail.com', 'demande', 'gh', '2025-05-17 16:41:37'),
(3, 'ANDRIAM', 'dsf@gmail.com', 'mlay e', 'mlay be lety a', '2025-05-17 17:41:19');

-- --------------------------------------------------------

--
-- Structure de la table `index_content`
--

CREATE TABLE `index_content` (
  `id` int(11) NOT NULL,
  `section` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `index_content`
--

INSERT INTO `index_content` (`id`, `section`, `content`, `updated_at`) VALUES
(4, 'about_text', 'fbfb', '2025-05-17 14:59:18'),
(5, 'profile_image', 'uploads/profile_6828a4467e19e.png', '2025-05-17 14:59:18'),
(6, 'cv_file', 'uploads/cv_6828a4467e6e8.pdf', '2025-05-17 14:59:18'),
(7, 'name', 'Votre Nom', '2025-05-17 15:03:07'),
(8, 'slogan', 'Développeur web passionné', '2025-05-17 15:17:01'),
(9, 'name', 'ANDRIAM', '2025-05-17 15:19:04'),
(10, 'slogan', 'Développeur web passionné', '2025-05-17 15:19:04'),
(11, 'profile_image', 'uploads/profile_6828a4467e19e.png', '2025-05-17 15:19:04'),
(12, 'cv_file', 'uploads/cv_6828a4467e6e8.pdf', '2025-05-17 15:19:04'),
(13, 'name', 'ANDRIAMALALA Tsirifanantenana', '2025-05-17 15:19:46'),
(14, 'slogan', 'Développeur web passionné', '2025-05-17 15:19:46'),
(15, 'profile_image', 'uploads/profile_6828a9122a50e.jpg', '2025-05-17 15:19:46'),
(16, 'cv_file', 'uploads/cv_6828a4467e6e8.pdf', '2025-05-17 15:19:46');

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `technologies` varchar(255) DEFAULT NULL,
  `project_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `image`, `technologies`, `project_link`, `created_at`) VALUES
(1, 'HF', 'FHFH', 'Capture d’écran (1).png', 'HFHG', '', '2025-05-17 13:21:09'),
(2, 'dev', 'wweb personnaliser', 'FB_IMG_15621286054506937.jpg', 'HTML', '', '2025-05-17 16:16:34');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `about_content`
--
ALTER TABLE `about_content`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `index_content`
--
ALTER TABLE `index_content`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `about_content`
--
ALTER TABLE `about_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `index_content`
--
ALTER TABLE `index_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
