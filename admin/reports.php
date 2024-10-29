<?php
session_start();
// Vérification du rôle
if (!isset($_SESSION['role']) && ($_SESSION['role'] !== 'admin' 
|| $_SESSION['role'] !== 'agent' 
|| $_SESSION['role'] !== 'veterinaire' )){
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis \n pour des raisons de sécurité , veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else { 
    $role = $_SESSION['role']; 
     // Connexion à la base de données
    include_once '../back/bdd.php';
    // pour utilisation de token
    include_once '../back/token.php';
     checkToken($conn);// verifie si le token de session est correct et le met à jour
     // pour les boutons retour
     include_once "../php/btnBack.php"; 
}?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitats</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>
    </header>
    <main>
    <h3>Ajouter un animal</h3>
            <form action="../back/report.php" method="POST">
                
                <label for="name">Nom :</label>
                <input type="text" name="name" required><br>
                <!-- rendre le select habitat dynamique  
                 faire un select + choix autre 
                 si autre ajouter un input pour créer la race-->
                <label for="race">Race :</label>
                <input type="text" name="race" required><br>

                <label for="birthday">Date de naissance :</label> <!-- birthday pour calcul age dynamique -->
                <input type="number" name="birthday" required><br> <!-- afficher un calendrier -->

                <label for="poid">Poids (kg) :</label>
                <input type="number" step="0.1" name="poid" required><br>
                <!-- rendre le select habitat dynamique -->
                <label for="habitat">Habitat </label>
                <label for="habitat">(si l ' Habitat n ' est pas dans cette liste veuillez d 'abord enregistrer l habitat ' )</label>
                <select name="habitat" required>
                    <option value="M">Marais</option>
                    <option value="F">Jungle</option>
                    <option value="F">Savane</option>
                </select><br>

                <label for="regime">Régime :</label>
                <select name="regime" required>
                    <option value="carnivore">Carnivore</option>
                    <option value="herbivore">Herbivore</option>
                    <option value="omnivore">Omnivore</option>
                </select><br>

                <label for="description">Description :</label>
                <textarea name="description" required></textarea><br>

                <label for="sex">Sexe :</label>
                <select name="sex" required>
                    <option value="M">Mâle</option>
                    <option value="F">Femelle</option>
                </select><br>

                <label for="health">Santé :</label>
                <input type="text" name="health" required><br>

                <button type="submit">Soumettre</button>
            </form>
    </main>
</body>