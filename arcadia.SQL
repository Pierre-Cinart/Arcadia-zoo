--
-- Base de données : `arcadia`
--
CREATE DATABASE arcadia; 
USE arcadia;
-- --------------------------------------------------------
--
--  table `animals`
--
CREATE TABLE `animals` (
  `id` int NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
  `race_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `age` int NOT NULL,
  `poid` decimal(10,2) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `regime` int DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `health` varchar(255) NOT NULL,
  `maj` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `maj_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
--  table `animal_pictures`
--
CREATE TABLE `animal_pictures` (
  `id` int NOT NULL  AUTO_INCREMENT  PRIMARY KEY ,
  `name` varchar(255) NOT NULL,
  `animal_id` int DEFAULT NULL,
  `maj_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `maj_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
--  table `avis`
--
CREATE TABLE `avis` (
  `id` int NOT NULL  AUTO_INCREMENT  PRIMARY KEY ,
  `pseudo` varchar(255) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  `isVisible` tinyint(1) NOT NULL DEFAULT '0',
  `validate_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
--  table `habitats`
--
CREATE TABLE `habitats` (
  `id` int NOT NULL  AUTO_INCREMENT  PRIMARY KEY ,
  `name` varchar(255) NOT NULL,
  `title_txt` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `maj_by` int DEFAULT NULL,
  `maj` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
--  table `horaires`
--
CREATE TABLE `horaires` (
  `id` int NOT NULL  AUTO_INCREMENT  PRIMARY KEY ,
  `description` varchar(255) NOT NULL,
  `maj_by` int DEFAULT NULL,
  `maj` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
--  table `messages`
--
CREATE TABLE `messages` (
  `id` int NOT NULL  AUTO_INCREMENT  PRIMARY KEY ,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `object` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `isReply` tinyint(1) NOT NULL DEFAULT '0',
  `reply_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `response` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
--  table `races`
--
CREATE TABLE `races` (
  `id` int NOT NULL  AUTO_INCREMENT  PRIMARY KEY ,
  `name` varchar(255) NOT NULL,
  `habitat` int DEFAULT NULL ,
  `regime` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
--  table `services`
--
CREATE TABLE `services` (
  `id` int NOT NULL  AUTO_INCREMENT  PRIMARY KEY ,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `maj_by` int DEFAULT NULL,
  `maj` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-------------------------------------------------------------------------
--
--  table `users`
--
CREATE TABLE `users` (
  `id` int NOT NULL  AUTO_INCREMENT  PRIMARY KEY ,
  `name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(255) DEFAULT NULL,
  `token_expiration` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- --------------------------------------------------------------
-- -- index foreign keys
--
-- Index table `animals`
--
ALTER TABLE `animals`
  ADD KEY `fk_animals_maj_by` (`maj_by`),
  ADD KEY `fk_animals_race_id` (`race_id`);
--
-- Index table `animal_pictures`
--
ALTER TABLE `animal_pictures`
  ADD KEY `fk_animal_pictures_animal_id` (`animal_id`),
  ADD KEY `fk_animal_pictures_maj_by` (`maj_by`);
--
-- Index table `avis`
--
ALTER TABLE `avis`
  ADD KEY `fk_avis_validate_by` (`validate_by`);
--
-- Index table `habitats`
--
ALTER TABLE `habitats`
  ADD KEY `fk_habitats_maj_by` (`maj_by`);
--
-- Index table `horaires`
--
ALTER TABLE `horaires`
  ADD KEY `fk_horaires_maj_by` (`maj_by`);
--
-- Index table `messages`
--
ALTER TABLE `messages`
  ADD KEY `fk_reply_by` (`reply_by`);
--
-- Index table `races`
--
ALTER TABLE `races`
  ADD KEY `fk_habitat_id` (`habitat`);
--
-- Index table `services`
--
ALTER TABLE `services`
  ADD KEY `fk_services_maj_by` (`maj_by`);
--
-- Index table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `email` (`email`);
-- ---------------------------------
--
-- Contraintes 
--
-- Contraintes  table `animals`
--
ALTER TABLE `animals`
  ADD CONSTRAINT `fk_animals_maj_by` FOREIGN KEY (`maj_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_animals_race_id` FOREIGN KEY (`race_id`) REFERENCES `races` (`id`) ON DELETE SET NULL;
--
-- Contraintes table `animal_pictures`
--
ALTER TABLE `animal_pictures`
  ADD CONSTRAINT `fk_animal_pictures_animal_id` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_animal_pictures_maj_by` FOREIGN KEY (`maj_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
--
-- Contraintes table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `fk_avis_validate_by` FOREIGN KEY (`validate_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
--
-- Contraintes table `habitats`
--
ALTER TABLE `habitats`
  ADD CONSTRAINT `fk_habitats_maj_by` FOREIGN KEY (`maj_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
--
-- Contraintes table `horaires`
--
ALTER TABLE `horaires`
  ADD CONSTRAINT `fk_horaires_maj_by` FOREIGN KEY (`maj_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
--
-- Contraintes table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_reply_by` FOREIGN KEY (`reply_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
--
-- Contraintes table `races`
--
ALTER TABLE `races`
  ADD CONSTRAINT `fk_habitat_id` FOREIGN KEY (`habitat`) REFERENCES `habitats` (`id`) ON DELETE SET NULL;
--
-- Contraintes table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_services_maj_by` FOREIGN KEY (`maj_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

