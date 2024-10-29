<?php
session_start();

// Vérification du rôle
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'agent', 'veterinaire'])) {
    session_unset();
    $_SESSION['error'] = "Il semblerait que vous n'ayez pas les droits requis pour des raisons de sécurité, veuillez vous reconnecter.";
    header('Location: ../admin/index.php'); // Redirection vers la page de connexion
    exit();
} else { 
    $role = $_SESSION['role']; 
    // Connexion à la base de données
    include_once '../back/bdd.php';
    include_once '../back/token.php';
    checkToken($conn); // Vérifie si le token de session est correct et le met à jour
}

// Récupérer les races d'animaux
$racesQuery = "SELECT id, name, regime FROM races";
$racesResult = $conn->query($racesQuery);
if ($racesResult) {
    $races = $racesResult->fetch_all(MYSQLI_ASSOC);
} else {
    // Gérer l'erreur si la requête échoue
    $races = [];
    error_log("Erreur lors de la récupération des races : " . $conn->error);
}

// Récupérer les habitats
$habitatsQuery = "SELECT id, name FROM habitats";
$habitatsResult = $conn->query($habitatsQuery);
if ($habitatsResult) {
    $habitats = $habitatsResult->fetch_all(MYSQLI_ASSOC);
} else {
    // Gérer l'erreur si la requête échoue
    $habitats = [];
    error_log("Erreur lors de la récupération des habitats : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion animaux</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <?php include_once "../php/navbarrAdmin.php"; ?>
    </header>
    <?php include_once "../php/btnLogout.php"; ?>
    <?php include_once "../php/popup.php"; ?>
    <main class="admin">
        <div style="display: flex; justify-content: center; gap: 10px; margin: 20px;">
            <?php 
                if ($role === 'admin' || $role === 'agent') {
                    echo '<a href="./habitats.php"><button id="modifHabitats">Gérer les habitats</button></a>';
                    echo '<button id="addAnimalBtn">Ajouter Un Animal</button>'; 
                    echo '<button id="modifAnimalBtn">Modifier des informations</button>'; 
                }
                echo '<button id="reportAnimalBtn">Faire un rapport</button>'; 
            ?>
        </div>
        
        <!-- Formulaire d'ajout d'animal -->
        <div id="addAnimalForm">
            <h3>Ajouter un animal</h3>
            <form action="../back/addAnimal.php" method="POST">
                <label for="name">Nom :</label>
                <input type="text" name="name" required><br>

                <label for="race">Race :</label>
                <select name="race" id="raceSelect" required>
                    <option value="">Sélectionnez une race</option>
                    <?php foreach ($races as $race): ?>
                        <option value="<?= htmlspecialchars($race['name']) ?>" data-regime="<?= htmlspecialchars($race['regime']) ?>">
                            <?= htmlspecialchars($race['name']) ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="Autre">Autre (ajouter une nouvelle race)</option>
                </select>
                <input type="text" name="newRace" id="newRaceInput" placeholder="Entrez la nouvelle race" style="display: none;"><br>

                <div id="regimeContainer" style="display: none;">
                    <label for="regime">Régime :</label>
                    <select name="regime">
                        <option value="carnivore">Carnivore</option>
                        <option value="herbivore">Herbivore</option>
                        <option value="omnivore">Omnivore</option>
                    </select><br>
                </div>

                <label for="birthday">Date de naissance :</label>
                <input type="date" name="birthday" required><br>

                <label for="poid">Poids (kg) :</label>
                <input type="number" step="0.1" name="poid" required><br>

                <div id="habitatContainer" style="display: none;">
                    <label for="habitat">Habitat :</label>
                    <select name="habitat" id="habitatSelect" required>
                        <option value="">Sélectionnez un habitat</option>
                        <?php foreach ($habitats as $habitat): ?>
                            <option value="<?= htmlspecialchars($habitat['name']) ?>">
                                <?= htmlspecialchars($habitat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="Autre">Autre (ajouter un nouvel habitat)</option>
                    </select>
                    <input type="text" name="newHabitat" id="newHabitatInput" placeholder="Entrez le nouvel habitat" style="display: none;"><br>
                </div>

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

        <!-- Formulaire de modification d'animal -->
        <div id="modifAnimalForm">
            <h3>Modifier un animal</h3>
            <form action="../back/modifAnimal.php" method="POST">
                <label for="modifID">ID de l'animal :</label>
                <input type="number" name="modifID" required><br>

                <label for="modifName">Nom :</label>
                <input type="text" name="modifName"><br>

                <label for="modifRace">Race :</label>
                <select name="modifRace" id="modifRaceSelect">
                    <option value="">Sélectionnez une race</option>
                    <?php foreach ($races as $race): ?>
                        <option value="<?= htmlspecialchars($race['name']) ?>" data-regime="<?= htmlspecialchars($race['regime']) ?>">
                            <?= htmlspecialchars($race['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="modifNewRace" id="modifRaceInput" placeholder="Entrez la nouvelle race" style="display: none;"><br>

                <div id="modifRegimeContainer" style="display: none;">
                    <label for="modifRegime">Régime :</label>
                    <select name="modifRegime">
                        <option value="carnivore">Carnivore</option>
                        <option value="herbivore">Herbivore</option>
                        <option value="omnivore">Omnivore</option>
                    </select><br>
                </div>

                <label for="modifBirthday">Date de naissance :</label>
                <input type="date" name="modifBirthday"><br>

                <label for="modifPoid">Poids (kg) :</label>
                <input type="number" step="0.1" name="modifPoid"><br>

                <label for="modifHabitat">Habitat :</label>
                <select name="modifHabitat" id="modifHabitatSelect">
                    <option value="">Sélectionnez un habitat</option>
                    <?php foreach ($habitats as $habitat): ?>
                        <option value="<?= htmlspecialchars($habitat['name']) ?>">
                            <?= htmlspecialchars($habitat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="modifNewHabitat" id="modifNewHabitatInput" placeholder="Entrez le nouvel habitat" style="display: none;"><br>

                <label for="modifDescription">Description :</label>
                <textarea name="modifDescription"></textarea><br>

                <label for="modifSex">Sexe :</label>
                <select name="modifSex">
                    <option value="M">Mâle</option>
                    <option value="F">Femelle</option>
                </select><br>

                <label for="modifHealth">Santé :</label>
                <input type="text" name="modifHealth"><br>

                <button type="submit">Soumettre</button>
            </form>
        </div>
    </main>
    <script src="../js/animals.js"></script> <!-- affichage au clique -->
    <script src="../js/toggleMenu.js"></script> <!-- navbarr mobile -->
    <script src="../js/popup.js"></script> <!-- popup (erreur ou succès de l'action) -->
</body>
</html>
