-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 10 sep. 2019 à 00:31
-- Version du serveur :  10.1.29-MariaDB
-- Version de PHP :  7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog_oop`
--

-- --------------------------------------------------------

--
-- Structure de la table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `author` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chat`
--

INSERT INTO `chat` (`id`, `author`, `message`, `creation_date`) VALUES
(100, 'Tim', 'Hey !', '2019-09-10 00:05:31'),
(101, 'Elton', 'Le café est offert ?', '2019-09-10 00:06:12'),
(102, 'Freddie', 'Vive le PHP', '2019-09-10 00:07:57'),
(103, 'Tim', 'Et pourquoi pas le js', '2019-09-10 00:09:38');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `author` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `author`, `comment`, `creation_date`) VALUES
(155, 28, 'Fafa', 'Belle prose !', '2019-09-10 00:02:34'),
(156, 28, 'Chercheur', 'C\'est du latin ?', '2019-09-10 00:11:30'),
(157, 28, 'Spok', 'C\'est du Klingon je crois', '2019-09-10 00:12:42'),
(158, 28, 'Spok', 'oui c\'est bien du Klingon je persiste', '2019-09-10 00:14:24'),
(159, 28, 'Jill', 'c ici le café ?', '2019-09-10 00:15:10');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `post` text NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `post`, `creation_date`) VALUES
(28, 23, 'Hello World', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquam, ipsum vitae rhoncus elementum, felis lorem venenatis purus, et imperdiet libero ipsum et magna. Phasellus fringilla molestie augue nec vestibulum. In bibendum, est id posuere sagittis, nibh sapien ultrices massa, in volutpat nisi libero quis arcu. Nullam sollicitudin accumsan massa, sed ullamcorper tellus. Aenean sed consectetur tortor, eget interdum lorem. Sed cursus justo dolor, et euismod lectus finibus sit amet. Aliquam lacus massa, rhoncus ut sodales at, iaculis ac nibh. Suspendisse a ipsum purus. Proin mattis vestibulum sollicitudin.', '2019-09-10 00:01:49'),
(29, 24, 'Règles du blog', 'Une seule règle prendre son café et rejoindre la communauté !', '2019-09-10 00:25:00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `role` varchar(5) NOT NULL,
  `pseudo` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `subscription_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `role`, `pseudo`, `password`, `subscription_date`) VALUES
(23, 'John', 'Doe', 'john@john.com', 'user', 'Jdoe', '$2y$12$Ng/qjsKXZk7303OCYzScmeV5zorj0PHSEgPwr8o6.RIPNlb4MCZqq', '2019-09-10 00:00:24'),
(24, 'Austin', 'Powers', 'admin@admin.com', 'admin', 'austin911', '$2y$12$JZezIXouTqXCLDNRWcZJk.kXY0LEQGLsbZYUZ2Jv/xd3lSx4EB8Mq', '2019-09-10 00:18:32');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
