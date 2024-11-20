# Arcadia Zoo

**Arcadia Zoo** est une application de gestion d'un zoo, où l'administrateur peut gérer les informations du site et ajouter ou supprimer de nouveaux agents et vétérinaires. Ce projet utilise une base de données MySQL et intègre un système de CAPTCHA Google pour les formulaires.

## Prérequis

Avant de commencer, assurez-vous que vous avez installé :

- **PHP** (version 7.4 ou supérieure)
- **MySQL**
- **Serveur local** comme [XAMPP](https://www.apachefriends.org/index.html) ou [Laragon](https://laragon.org/)
- **Composer** (facultatif, si vous utilisez des packages externes à l'avenir)

## Installation

1. **Clonez ce dépôt sur votre machine locale :**

   ```bash
   git clone git@github.com:Pierre-Cinart/Arcadia-zoo.git
2. **Créez la base de données :**

Dans le fichier arcadia.sql, vous trouverez le schéma SQL pour créer les tables nécessaires. Pour importer ce fichier dans votre base de données MySQL, Importez le fichier database.sql dans cette base de données.


3. **Modifiez les fichiers de configuration :**

Les informations sensibles telles que les identifiants de connexion à la base de données et les clés API sont stockées dans des fichiers de configuration (config.php et configCaptcha.php). Assurez-vous de les remplacer avec vos propres valeurs pour sécuriser votre application..

creez à la racine un fichier config.php : 
<?php
// Fichier config.php pour la connexion

$DB_HOST='localhost';
$DB_NAME= 'arcadia';
$DB_USER= 'nom_utilisateur';
$DB_PASS= 'mot_de_passe';

Remplacez les valeurs de connexion à la base de données par celles correspondant à votre environnement local.

créez un fichier configCaptcha.php :
$RECAPTCHA_PUBLIC_KEY = 'votre_public_key';
$RECAPTCHA_PRIVATE_KEY = 'votre_private_key';

Accès à l'interface administrateur
Pour accéder à l'interface administrateur, vous devez vous rendre à l'adresse suivante dans votre navigateur :


http://localhost/arcadia/admin

Identifiants administrateur :
Email : jose.admin@example.com
Mot de passe : MotDePasse123

Fonctionnalités administrateur :
Une fois connecté à la partie administrateur, vous pourrez :

Modifier les informations du site : Par exemple, ajouter ou mettre à jour les descriptions, images et autres informations visibles sur le site.
Ajouter ou supprimer des agents et vétérinaires : Gérez facilement les membres du personnel en ajoutant, modifiant ou supprimant des agents et vétérinaires.
Sécurité

*Fonctionnalités*
Page d'accueil : Présentation du zoo et des services proposés.
Page des services : Affichage des différents services disponibles au zoo (visites guidées, zoo en petit train, etc.).
Page des habitats : Liste des habitats avec des images et des descriptions.
Interface administrateur : Permet de gérer les informations du site et le personnel (ajouter, modifier, supprimer des agents et vétérinaires , valider ou supprimer les commentaires et effectué les rapports).
Google reCAPTCHA : Sécurisation des formulaires avec reCAPTCHA pour éviter les abus.
Aide et support
Si vous avez des questions ou rencontrez des problèmes avec le projet, n'hésitez pas à ouvrir une issue sur GitHub ou à consulter la documentation de PHP et MySQL pour résoudre vos problèmes de configuration.
