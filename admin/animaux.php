<?php
session_start();
// Vérification du rôle
if (!isset($_SESSION['role']) && ($_SESSION['role'] !== 'admin' 
|| $_SESSION['role'] !== 'agent' 
|| $_SESSION['role'] !== 'veterinaire')) {
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
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion animaux</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS  -->
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?> <!-- navbarr -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- message popup -->
    <main class="admin">
        <!-- bouttons d ' action selon les droits  -->
        <div style = "display: flex; justify-content: center; gap: 10px;margin:20px;">
            <?php 
                if ( $role === 'admin' || $role === 'agent') {
                    echo '<button id="addAnimalBtn">Ajouter Un Animal</button>';// bouton ajout animal
                    // boutton pour changer des informations sur l animal // supprimer unanimal / ajouter ou supprimer des images
                    echo '<button id="mofifAnimalBtn">Modifier des informations</button>'; 
                }
                // boutton pour laisser un rapport // santé ----> veterinaire // nourriture ----> agent // ou laisser un commentaire
                echo '<button id="reportAnimalBtn">Faire un rapport</button>'; 
              ?>
        </div>
         <!-- affichage des habitats option de gestion pour admin et agent -->
         <div id="showHabitats" style = "text-align : center;">
            <!-- coder l affichage et la gestion si admin ou agent -->
        </div>
        <!-- formulaire pour ajouter un animal visible pour agent ou admin -->
        <div id="addAnimalForm">
            <h3>Ajouter un animal</h3>
            <form action="addAnimal.php" method="POST">
                
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
        </div>
        <!-- formulaire pour ajouter un animal visible pour agent ou admin -->
         <!-- pre remplir comme pour les services  -->
        <div id="modifAnimalForm">
            <h3>Ajouter un animal</h3>
            <form action="addAnimal.php" method="POST">
                
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
        </div>
        <!-- formulaire pour faire un rapport sur l  animal visible pour tous  -->
         <!-- rendre dynamique et différent selon le role (à gérer sur les boutons et js ) -->
        <div id="reportAnimal"></div>
        </main>
    <script src="../js/animals.js"></script> <!-- affichage au clique -->
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succés de l action) -->
</body>
</html>