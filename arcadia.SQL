--
-- Base de données : `arcadia`
--
CREATE DATABASE IF NOT EXISTS arcadia DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ;

USE arcadia;

-- --------------------------------------------------------

--
-- Structure de la table `animals`
--

CREATE TABLE `animals` (
  `id` int NOT NULL,
  `race_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `poid` decimal(10,2) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `description` varchar(255) NOT NULL,
  `health` varchar(255) NOT NULL,
  `maj` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `maj_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `birthday` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

--
-- Déchargement des données de la table `animals`
--

INSERT INTO `animals` (`id`, `race_id`, `name`, `poid`, `sex`, `description`, `health`, `maj`, `maj_by`, `created_at`, `birthday`) VALUES
(1, 8, 'Baguera', 200.00, 'M', 'La plus belle panthère de l univers', 'casase', '2024-11-05 18:44:56', 1, '2024-10-26 10:18:49', '2024-11-03 23:00:00'),
(2, 2, 'Lacoste', 124.00, 'M', 'Splendide crocodile du Nil', 'bonne santé', '2024-11-04 20:22:58', NULL, '2024-10-26 10:52:40', '2024-10-28 08:59:17'),
(3, 3, 'Dumbo', 800.00, 'M', 'Splendide éléphant d \' Afrique', 'bonne santé', '2024-11-06 10:46:14', 1, '2024-10-26 10:52:40', '2024-10-28 08:59:17'),
(4, 9, 'Sherkan', 0.00, 'M', 'Sherkan , notre magnifique tigre du Benghal', 'bonne santé', '2024-11-04 22:14:17', NULL, '2024-10-26 10:52:40', '2024-10-28 08:59:17'),
(5, 1, 'Papa Singe', 2.10, 'M', 'le plus beau', 'RAS', '2024-11-04 11:08:02', 1, '2024-11-04 11:08:02', '2024-10-31 23:00:00'),
(6, 5, 'Mumu', 77.00, 'F', 'notre belle mumu la girafe ', 'RAS', '2024-11-04 18:31:06', 1, '2024-11-04 18:31:06', '2023-05-31 22:00:00'),
(7, 7, 'Simba', 187.00, 'M', 'Le roi de la Savane Simba', 'RAS', '2024-11-04 18:49:22', 1, '2024-11-04 18:49:22', '2022-06-30 22:00:00'),
(8, 6, 'Mamapo', 1390.00, 'F', 'Notre magnifique maman hippopotame ', 'En forme', '2024-11-04 18:51:55', 1, '2024-11-04 18:51:55', '2021-05-04 22:00:00'),
(9, 6, 'Papapo', 3000.00, 'M', 'Le gros papa hippopotame , belle bête !!!', 'Energique', '2024-11-05 17:33:59', 1, '2024-11-04 18:53:42', '2020-02-07 23:00:00'),
(10, 6, 'Peppa', 122.00, 'M', 'Notre nouveau venu , adorable bébé hippopotame', 'En super forme', '2024-11-04 18:55:19', 1, '2024-11-04 18:55:19', '2024-03-12 23:00:00'),
(11, 7, 'Nahla', 120.00, 'F', 'Magnifique princesse de la savane !!!', 'Parfaite', '2024-11-04 18:57:11', 1, '2024-11-04 18:57:11', '2022-06-21 22:00:00'),
(12, 1, 'Capucine', 3.00, 'F', 'Elle est vraiment adorable  ', 'parait fatiguée', '2024-11-04 18:59:55', 1, '2024-11-04 18:59:55', '2022-06-28 22:00:00'),
(13, 1, 'Donk', 1.00, 'M', 'le joli bébé capucin , profitez en . Ca grandit très vite', 'bonne santé', '2024-11-04 19:01:38', 1, '2024-11-04 19:01:38', '2024-04-10 22:00:00'),
(14, 4, 'Flamant rose a', 2.30, 'F', 'Flamant rose', 'bonne ', '2024-11-04 19:08:08', 1, '2024-11-04 19:08:08', '2020-02-11 23:00:00'),
(15, 4, 'Flammant rose b', 3.00, 'M', 'Flammant rose mâle', 'ras', '2024-11-05 13:30:20', 1, '2024-11-04 19:09:07', '2022-01-10 23:00:00'),
(16, 4, 'Flamant rose c', 2.00, 'F', 'flamant rose aussi', 'cool', '2024-11-04 19:10:19', 1, '2024-11-04 19:10:19', '2022-02-08 23:00:00'),
(17, 9, 'test service', 0.70, 'M', 'éééééééééééééé', 'SSSSSSSS', '2024-11-06 11:04:51', 1, '2024-11-06 11:04:51', '2024-11-05 23:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `animal_pictures`
--

CREATE TABLE `animal_pictures` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `animal_id` int DEFAULT NULL,
  `maj_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `maj_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

--
-- Déchargement des données de la table `animal_pictures`
--

INSERT INTO `animal_pictures` (`id`, `name`, `animal_id`, `maj_at`, `maj_by`) VALUES
(1, 'Papa Singe', 5, '2024-11-04 11:08:02', 1),
(2, 'Dumbo', 3, '2024-11-04 11:08:02', 1),
(3, 'Dumbo2', 3, '2024-11-04 11:08:02', 1),
(4, 'Dumbo3', 3, '2024-11-04 11:08:02', 1),
(5, 'Sherkan', 3, '2024-11-04 11:08:02', 1),
(6, 'Sherkan3', 3, '2024-11-04 18:17:54', 1),
(7, 'Sherkan2', 3, '2024-11-04 11:08:02', 1),
(8, 'Lacoste2', 2, '2024-11-04 18:24:24', 1),
(9, 'Lacoste', 2, '2024-11-04 18:24:24', 1),
(10, 'Lacoste3', 2, '2024-11-04 18:24:24', 1),
(11, 'Mumu', 6, '2024-11-04 18:31:06', 1),
(12, 'Mumu(1)', 6, '2024-11-04 18:31:06', 1),
(13, 'Mumu(2)', 6, '2024-11-04 18:31:06', 1),
(14, 'Simba', 7, '2024-11-04 18:49:22', 1),
(15, 'Simba(1)', 7, '2024-11-04 18:49:22', 1),
(16, 'Simba(2)', 7, '2024-11-04 18:49:22', 1),
(17, 'Mamapo', 8, '2024-11-04 18:51:55', 1),
(18, 'Papapo', 9, '2024-11-04 18:53:42', 1),
(19, 'Peppa', 10, '2024-11-04 18:55:19', 1),
(20, 'Nahla', 11, '2024-11-04 18:57:11', 1),
(21, 'Nahla(1)', 11, '2024-11-04 18:57:11', 1),
(22, 'Nahla(2)', 11, '2024-11-04 18:57:11', 1),
(23, 'Capucine', 12, '2024-11-04 18:59:55', 1),
(24, 'Capucine(1)', 12, '2024-11-04 18:59:55', 1),
(25, 'Donk', 13, '2024-11-04 19:01:38', 1),
(26, 'Flamant rose a', 14, '2024-11-04 19:08:08', 1),
(27, 'Flammant rose b', 15, '2024-11-04 19:09:07', 1),
(28, 'Flamant rose c', 16, '2024-11-04 19:10:19', 1),
(29, 'Baguera', 1, '2024-11-05 21:04:28', 1),
(30, 'Baguera2', 1, '2024-11-05 21:27:25', 1),
(31, 'Baguera3', 1, '2024-11-05 21:27:34', 1);

-- --------------------------------------------------------

--
-- Structure de la table `animal_reports`
--

CREATE TABLE `animal_reports` (
  `id` int NOT NULL,
  `animal_id` int DEFAULT NULL,
  `report_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `report_txt` text,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

--
-- Déchargement des données de la table `animal_reports`
--

INSERT INTO `animal_reports` (`id`, `animal_id`, `report_date`, `report_txt`, `user_id`) VALUES
(1, 1, '2024-11-02 14:27:30', 'tout est ok !', 1),
(2, 1, '2024-11-01 14:27:30', 'anxieuse !', 1),
(3, 2, '2024-11-04 20:14:05', 'RAS', 1),
(4, 3, '2024-11-04 20:22:03', 'nerveux', 1),
(5, 4, '2024-11-04 20:22:58', 'nerveux', 1),
(6, 5, '2024-11-04 22:14:17', 'il est malade', 1);

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id` int NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  `isVisible` tinyint(1) NOT NULL DEFAULT '0',
  `validate_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `pseudo`, `commentaire`, `isVisible`, `validate_by`, `created_at`) VALUES
(1, 'User12', 'J\'ai adoré chaque minute.', 1, NULL, '2024-10-21 09:49:34'),
(2, 'User13', 'Excellente ambiance.', 1, NULL, '2024-10-21 09:49:34'),
(3, 'User14', 'Le personnel est très accueillant.', 1, NULL, '2024-10-21 09:49:34'),
(4, 'User15', 'Commentaire de test numéro 15.', 1, NULL, '2024-10-21 09:49:34'),
(5, 'User16', 'Une expérience incroyable !', 1, NULL, '2024-10-21 09:49:34'),
(6, 'User17', 'Je reviendrai sans hésiter.', 1, NULL, '2024-10-21 09:49:34'),
(7, 'User18', 'Commentaire de test numéro 18.', 1, NULL, '2024-10-21 09:49:34'),
(8, 'User19', 'Vraiment un endroit à visiter.', 1, NULL, '2024-10-21 09:49:34'),
(9, 'User20', 'Ceci est un commentaire de test numéro 20.', 1, NULL, '2024-10-21 09:49:34'),
(10, 'User21', 'Une journée parfaite.', 1, NULL, '2024-10-21 09:49:34'),
(11, 'User22', 'Commentaire de test numéro 22.', 1, NULL, '2024-10-21 09:49:34'),
(12, 'User23', 'Une expérience à renouveler.', 1, NULL, '2024-10-21 09:49:34'),
(13, 'User24', 'J\'ai adoré ce moment.', 1, NULL, '2024-10-21 09:49:34'),
(14, 'User25', 'Commentaire de test numéro 25.', 1, NULL, '2024-10-21 09:49:34'),
(15, 'User26', 'Merci pour cette belle journée.', 1, NULL, '2024-10-21 09:49:34'),
(16, 'testdecommentaire', 'test de commentaire ssssss', 1, NULL, '2024-10-24 13:18:41'),
(17, 'testdecommentaire-3', 'testdecommentaire2testdecommentaire2testdecommentaire2', 1, NULL, '2024-10-24 13:21:26');


-- --------------------------------------------------------

--
-- Structure de la table `food_reports`
--

CREATE TABLE `food_reports` (
  `id` int NOT NULL,
  `race_id` int DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `food_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

--
-- Déchargement des données de la table `food_reports`
--

INSERT INTO `food_reports` (`id`, `race_id`, `quantity`, `food_date`, `user_id`) VALUES
(2, 1, 5.00, '2024-11-02 13:19:37', 1),
(2, 2, 5.00, '2024-11-02 13:19:37', 1),
(3, 8, 25.00, '2024-11-02 13:19:37', 1),
(4, 8, 25.00, '2024-11-01 06:19:37', 19),
(5, 4, 33.00, '2024-11-04 20:04:29', 1),
(6, 7, 222.00, '2024-11-04 20:04:50', 1),
(7, 7, 111.00, '2024-11-04 20:14:42', 1);

-- --------------------------------------------------------

--
-- Structure de la table `habitats`
--

CREATE TABLE `habitats` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `title_txt` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `maj_by` int DEFAULT NULL,
  `maj` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

--
-- Déchargement des données de la table `habitats`
--

INSERT INTO `habitats` (`id`, `name`, `title_txt`, `description`, `picture`, `maj_by`, `maj`) VALUES
(1, 'Savane', 'La Savane : Le Royaume des Grands Espaces', 'Entrez dans la savane, un vaste paysage ouvert, baigné de soleil et parsemé d’herbes dorées.Cet habitat vous plonge au cœur des plaines africaines, où des animaux majestueux cohabitent.', 'savane', 1, '2024-10-21 15:13:34'),
(2, 'Jungle', 'La Jungle : Un Monde de Mystères et de Couleurs', 'La jungle un lieu dense et vibrant, avec de nombreux arbres imposants et une végétation luxuriante.', 'jungle', NULL, '2024-10-21 15:17:08'),
(3, 'Marais', 'Les Marais : Un Refuge Aquatique', 'Les marais sont des lieux calmes où l’eau et la terre se rejoignent, créant un refuge pour une faune surprenante. C’est un habitat où chaque espèce a su s’adapter à la vie dans l’eau et sur terre.', 'marais', NULL, '2024-10-21 15:18:56');

-- --------------------------------------------------------

--
-- Structure de la table `horaires`
--

CREATE TABLE `horaires` (
  `id` int NOT NULL,
  `description` varchar(255) NOT NULL,
  `maj_by` int DEFAULT NULL,
  `maj` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

--
-- Déchargement des données de la table `horaires`
--

INSERT INTO `horaires` (`id`, `description`, `maj_by`, `maj`) VALUES
(1, 'Heures d\'ouverture : 10h - 18h', NULL, '2024-10-15 16:14:45');

-- --------------------------------------------------------

--
-- Structure de la table `races`
--

CREATE TABLE `races` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `habitat` int DEFAULT NULL,
  `regime` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

--
-- Déchargement des données de la table `races`
--

INSERT INTO `races` (`id`, `name`, `habitat`, `regime`) VALUES
(1, 'Capucin', 1, 'herbivore'),
(2, 'Crocodile', 3, 'carnivore'),
(3, 'Éléphant', 2, 'herbivore'),
(4, 'Flamant rose', 3, 'herbivore'),
(5, 'Girafe', 1, 'herbivore'),
(6, 'Hippopotame', 3, 'herbivore'),
(7, 'Lion', 1, 'carnivore'),
(8, 'Panthère', 2, 'carnivore'),
(9, 'Tigre', 2, 'carnivore');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `maj_by` int DEFAULT NULL,
  `maj` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `picture`, `maj_by`, `maj`) VALUES
(1, 'Restauration', 'Des points de restauration pour vous détendre et savourer un bon repas après votre visite.', 'restauration', NULL, '2024-10-19 07:11:16'),
(2, 'Visite guidée des habitats', 'Participez à une visite guidée gratuite des habitats pour en apprendre plus sur nos animaux.', 'visite', NULL, '2024-10-19 07:11:16'),
(3, 'Tour du zoo en petit train', 'Découvrez le parc en vous relaxant à bord de notre petit train qui fait le tour du zoo.', 'train', NULL, '2024-10-19 07:11:16');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(255) DEFAULT NULL,
  `token_expiration` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `name`, `email`, `password`, `role`, `created_at`, `token`, `token_expiration`) VALUES
(1, 'José', 'Admin', 'jose.admin@example.com', '$2y$10$ApoXU5twASzBbSvcF/lgl.bezz5jFyITALzerFFs.es1DAhJ5K5Ku', 'admin', '2024-10-16 09:08:19', '14cc93296c54f03ef1a47dafac1940b3316816afa33294c9102bf98d655c696576c06e447c792b7565e1d352f9bfe356ea7d172793b4188d896fc784af997336', '2024-11-17 14:06:16'),
(2, 'Veterinaire', 'test', 'test2@mail.com', '$2y$10$Feof6SV6L2lVnG7wOstMjOCRzWz7qjWLoe1R2SMYIo/kVIa0BYrdW', 'veterinaire', '2024-10-24 07:46:59', NULL, NULL),
(3, 'agent-test', 'test', 'aa@mail.com', '$2y$10$EuNBNDwSACpp0KJSmcFJje4OdbTxe/UmLQSown8lcAnVEpwYhSYK.', 'agent', '2024-10-24 07:56:35', '89217fa5b86d97b44fa474e24a90e2d59519f9d3eb2aeb2b29ba5386b52995af96d59e1bc528b2154b165d637203451968232e76b79c7f68e069a19d7bfa8cb3', '2024-10-24 09:59:33'),
(4, 'agent-test', 'aaa', 'ww@ww.hh', '$2y$10$.NfMAy2Od9e3pwtrfaNNvOa0KEGI3Em0FO2QFTTdoo9jIEsmvhzlG', 'veterinaire', '2024-10-24 08:18:12', NULL, NULL),
(5, 'CINART', 'Pierre', 'jose.ad@example.com', '$2y$10$Il6RJUIbNXeNpFGjG7DC1u2uemBfwyQ33sKO/phdxNPaVZMsiQRO2', 'agent', '2024-10-30 11:16:37', NULL, NULL),
(6, '', 'Pierre', 'cinae@gmail.com', '$2y$10$2tzUUohVzivmQWqhhxiq6.OE6z./zsV/Zf93RgQsQ6PQNflguYrh.', 'agent', '2024-10-30 11:21:24', NULL, NULL),
(7, 'Admin', 'José', 'jose.admintest@example.com', '$2y$10$XAYtuRjiA1hMN2eDX/yqnOOTYUAYzlGOFmLNSGL17yJCLLcqNPfDe', 'admin', '2024-10-30 11:29:01', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_animals_maj_by` (`maj_by`),
  ADD KEY `fk_animals_race_id` (`race_id`);

--
-- Index pour la table `animal_pictures`
--
ALTER TABLE `animal_pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_animal_pictures_animal_id` (`animal_id`),
  ADD KEY `fk_animal_pictures_maj_by` (`maj_by`);

--
-- Index pour la table `animal_reports`
--
ALTER TABLE `animal_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reports_animals_id` (`animal_id`),
  ADD KEY `fk_reports_user_id` (`user_id`);

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_avis_validate_by` (`validate_by`);

--
-- Index pour la table `food_reports`
--
ALTER TABLE `food_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_food_animals_id` (`race_id`),
  ADD KEY `fk_food_user_id` (`user_id`);

--
-- Index pour la table `habitats`
--
ALTER TABLE `habitats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_habitats_maj_by` (`maj_by`);

--
-- Index pour la table `horaires`
--
ALTER TABLE `horaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_horaires_maj_by` (`maj_by`);

--
-- Index pour la table `races`
--
ALTER TABLE `races`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_habitat_id` (`habitat`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_services_maj_by` (`maj_by`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT pour la table `animal_pictures`
--
ALTER TABLE `animal_pictures`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT pour la table `animal_reports`
--
ALTER TABLE `animal_reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `food_reports`
--
ALTER TABLE `food_reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `habitats`
--
ALTER TABLE `habitats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `horaires`
--
ALTER TABLE `horaires`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `races`
--
ALTER TABLE `races`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `animals`
--
ALTER TABLE `animals`
  ADD CONSTRAINT `fk_animals_maj_by` FOREIGN KEY (`maj_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_animals_race_id` FOREIGN KEY (`race_id`) REFERENCES `races` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `animal_pictures`
--
ALTER TABLE `animal_pictures`
  ADD CONSTRAINT `fk_animal_pictures_animal_id` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_animal_pictures_maj_by` FOREIGN KEY (`maj_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `animal_reports`
--
ALTER TABLE `animal_reports`
  ADD CONSTRAINT `fk_reports_animals_id` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_reports_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `fk_avis_validate_by` FOREIGN KEY (`validate_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `food_reports`
--
ALTER TABLE `food_reports`
  ADD CONSTRAINT `fk_food_races_id` FOREIGN KEY (`race_id`) REFERENCES `races` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_food_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `habitats`
--
ALTER TABLE `habitats`
  ADD CONSTRAINT `fk_habitats_maj_by` FOREIGN KEY (`maj_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `horaires`
--
ALTER TABLE `horaires`
  ADD CONSTRAINT `fk_horaires_maj_by` FOREIGN KEY (`maj_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `races`
--
ALTER TABLE `races`
  ADD CONSTRAINT `fk_habitat_id` FOREIGN KEY (`habitat`) REFERENCES `habitats` (`id`);

--
-- Contraintes pour la table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_services_maj_by` FOREIGN KEY (`maj_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

