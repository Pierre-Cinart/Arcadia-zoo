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
        <!-- bouttons d ' action  -->
        <div style = "display: flex; justify-content: center; gap: 10px;margin:20px;">
            <button id="addAnimalBtn">Ajouter Un Animal</button>
            <button id="showAnimalsBtn">Consulter Les Animaux</button>
            <button id="showHabitatsBtn">Gérer Les Habitats</button>
        </div>
        <!-- formulaire pour ajouter un animal -->
        <div id="addAnimalForm">
            <h3>Ajouter un animal</h3>
            <form action="ajouter_animal.php" method="POST">
                
                <label for="name">Nom :</label>
                <input type="text" name="name" required><br>

                <label for="race">Race :</label>
                <input type="text" name="race" required><br>

                <label for="age">Âge :</label>
                <input type="number" name="age" required><br>

                <label for="poid">Poids (kg) :</label>
                <input type="number" step="0.1" name="poid" required><br>

                <label for="habitat">Habitat :</label>
                <select name="habitat" required>
                    <option value="M">Marais</option>
                    <option value="F">Jungle</option>
                    <option value="F">Savane</option>
                    <option value="F">Autre</option>
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
        <div id="showAnimals" style = "text-align : center;">
            <?php include_once "../back/showAnimals.php"; ?>
        </div>
        <div id="showHabitats" style = "text-align : center;">
            coder l affichage ...
        </div>
    </main>
    <script src="../js/animals.js"></script> <!-- affichage au clique -->
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succés de l action) -->
</body>
</html>