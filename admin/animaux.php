<?php
session_start();
// Vérification du rôle
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'agent', 'veterinaire'])) {
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis \n pour des raisons de sécurité, veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else { 
    $role = $_SESSION['role']; 
    // Connexion à la base de données
    include_once '../back/bdd.php';
    // Pour utilisation de token
    include_once '../back/token.php';
    checkToken($conn); // Vérifie si le token de session est correct et le met à jour
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion animaux</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?> <!-- Navbar -->
    </header>
    <?php include_once "../php/btnLogout.php"; ?> <!-- Bouton de déconnexion -->
    <?php include_once "../php/popup.php"; ?> <!-- Message popup -->
    <main class="admin">
        <!-- Boutons d'action selon les droits -->
        <div style="display: flex; justify-content: center; gap: 10px; margin: 20px;">
            <?php 
                if ($role === 'admin' || $role === 'agent') {
                    echo '<a href="./habitats.php"><button id="habitats">Gérer les habitats</button></a>';
                    echo '<button id="addAnimalBtn">Ajouter Un Animal</button>'; // Bouton ajout animal
                    echo '<button id="modifAnimalBtn">Modifier des informations</button>'; // Bouton modification d'informations
                }
                echo '<button id="reportAnimalBtn">Faire un rapport</button>'; // Bouton rapport
            ?>
        </div>
        <!-- Affichage des habitats et formulaire d'ajout d'animal -->
        <div id="addAnimalForm">
            <h3>Ajouter un animal</h3>
            <form action="addAnimal.php" method="POST">
                
                <!-- Nom de l'animal -->
                <label for="name">Nom :</label>
                <input type="text" name="name" required><br>

                <!-- Race de l'animal -->
                <label for="race">Race :</label>
                <select name="race" id="raceSelect" required>
                    <option value="">Sélectionnez une race</option>
                    <option value="Lion" data-regime="carnivore">Lion</option>
                    <option value="Tigre" data-regime="carnivore">Tigre</option>
                    <option value="Éléphant" data-regime="herbivore">Éléphant</option>
                    <option value="Autre">Autre (ajouter une nouvelle race)</option>
                </select>
                <input type="text" name="newRace" id="newRaceInput" placeholder="Entrez la nouvelle race" style="display: none;"><br>

                <!-- Régime de l'animal -->
                <div id="regimeContainer" style="display: none;">
                    <label for="regime">Régime :</label>
                    <select name="regime">
                        <option value="carnivore">Carnivore</option>
                        <option value="herbivore">Herbivore</option>
                        <option value="omnivore">Omnivore</option>
                    </select><br>
                </div>

                <!-- Date de naissance -->
                <label for="birthday">Date de naissance :</label>
                <input type="date" name="birthday" required><br>

                <!-- Poids de l'animal -->
                <label for="poid">Poids (kg) :</label>
                <input type="number" step="0.1" name="poid" required><br>

                <!-- Habitat de l'animal -->
                <div id="habitatContainer" style="display: none;">
                    <label for="habitat">Habitat :</label>
                    <select name="habitat" id="habitatSelect" required>
                        <option value="">Sélectionnez un habitat</option>
                        <option value="Marais">Marais</option>
                        <option value="Jungle">Jungle</option>
                        <option value="Savane">Savane</option>
                        <option value="Autre">Autre (ajouter un nouvel habitat)</option>
                    </select>
                    <input type="text" name="newHabitat" id="newHabitatInput" placeholder="Entrez le nouvel habitat" style="display: none;"><br>
                </div>

                <!-- Description -->
                <label for="description">Description :</label>
                <textarea name="description" required></textarea><br>

                <!-- Sexe -->
                <label for="sex">Sexe :</label>
                <select name="sex" required>
                    <option value="M">Mâle</option>
                    <option value="F">Femelle</option>
                </select><br>

                <!-- Santé -->
                <label for="health">Santé :</label>
                <input type="text" name="health" required><br>

                <!-- Soumettre -->
                <button type="submit">Soumettre</button>
            </form>
        </div>
        <div id="modifAnimalForm"><p>en testen testen testen test</p></div>
    </main>
    <script src="../js/animals.js"></script> <!-- Affichage au clic -->
    <script src="../js/toggleMenu.js"></script> <!-- Navbar mobile -->
    <script src="../js/popup.js"></script> <!-- Popup (erreur ou succès de l'action) -->   
</body>
</html>
